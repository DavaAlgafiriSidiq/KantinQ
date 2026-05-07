<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\keranjang;
use App\Models\Order;
use App\Models\OrderItem;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function __construct()
    {
        // Konfigurasi Midtrans dari .env
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = true;
        Config::$is3ds        = true;
    }

    /**
     * Tampilkan halaman review sebelum bayar
     */
    public function index()
    {
        $user     = Auth::user();
        $customer = $user->profilCustomer;

        if (!$customer) {
            return redirect()->route('profil-customer.edit')
                ->with('error', 'Lengkapi profil dulu sebelum checkout.');
        }

        $keranjang = keranjang::with(['produk', 'seller'])
            ->where('id_profil_customer', $customer->id)
            ->get();

        if ($keranjang->isEmpty()) {
            return redirect()->route('keranjang')
                ->with('error', 'Keranjang kamu kosong!');
        }

        $subtotal = $keranjang->sum(fn($item) => $item->produk->harga * $item->jumlah);

        return view('session-customer.checkout', compact('keranjang', 'subtotal', 'customer'));
    }

    /**
     * Buat Order & ambil Snap Token dari Midtrans
     */
    public function store(Request $request)
    {
        $user     = Auth::user();
        $customer = $user->profilCustomer;

        $keranjang = keranjang::with(['produk', 'seller'])
            ->where('id_profil_customer', $customer->id)
            ->get();

        if ($keranjang->isEmpty()) {
            return redirect()->route('keranjang')->with('error', 'Keranjang kosong!');
        }

        // --- AMBIL ID SELLER DARI ITEM PERTAMA ---
        $idSeller = $keranjang->first()->id_seller; 

        $subtotal   = $keranjang->sum(fn($item) => $item->produk->harga * $item->jumlah);
        $kodeOrder  = 'KQ-' . strtoupper(uniqid());

        // ── 1. Simpan ke tabel Order ──────────────────────────────
        $pesanan = Order::create([
            'kode_pesanan'        => $kodeOrder,
            'id_profil_customer' => $customer->id,
            'id_seller'          => $idSeller,
            'total_amount'        => $subtotal,
            'catatan'            => $request->catatan,
            'status'             => 'baru',
            'status_midtrans'    => 'pending',
        ]);


        // ── 2. Simpan item Order ───────────────────────────────────
        foreach ($keranjang as $item) {
            OrderItem::create([
                'order_id' => $pesanan->id,
                'id_produk'  => $item->id_produk,
                'id_seller'  => $item->id_seller,
                'id_profil_customer' => $customer->id,
                'quantity'     => $item->jumlah,
                'price'      => $item->produk->harga,
                'subtotal'   => $item->produk->harga * $item->jumlah,
            ]);
        }

        // ── 3. Kosongkan keranjang ───────────────────────────────────
        keranjang::where('id_profil_customer', $customer->id)->delete();

        // ── 4. Kirim ke Midtrans Snap ────────────────────────────────
        $params = [
            'transaction_details' => [
                'order_id'     => $kodeOrder,
                'gross_amount' => (int) $subtotal,
            ],
            'customer_details' => [
                'first_name' => $customer->nama ?? $user->name,
                'email'      => $user->email,
                'phone'      => $customer->no_hp ?? '',
            ],
            'item_details' => $keranjang->map(fn($item) => [
                'id'       => (string) $item->id_produk,
                'price'    => (int) $item->produk->harga,
                'quantity' => $item->jumlah,
                'name'     => substr($item->produk->nama_produk, 0, 50),
            ])->values()->toArray(),
            'enabled_payments' => [
                'credit_card', 'mandiri_clickpay', 'cimb_clicks',
                'bca_klikbca', 'bca_klikpay', 'bri_epay', 'echannel',
                'bni_va', 'bri_va', 'bca_va', 'other_va',
                'gopay', 'shopeepay', 'indomaret', 'alfamart', 'qris',
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            // Simpan snap token ke Order (opsional, buat retry)
            $pesanan->update(['snap_token' => $snapToken]);

            return view('session-customer.payment', compact('snapToken', 'pesanan', 'subtotal'));
       } catch (\Exception $e) {

            if (isset($pesanan)) {
                OrderItem::where('order_id', $pesanan->id)->delete();
                $pesanan->delete();
            }

            return redirect()->route('keranjang')
                ->with('error', 'Gagal menghubungi payment gateway: ' . $e->getMessage());
        }}

    /**
     * Callback / Webhook dari Midtrans (POST)
     * URL ini didaftarkan di dashboard Midtrans
     */
    public function callback(Request $request)
    {
        $serverKey      = config('midtrans.server_key');
        $hashedKey      = hash('sha512',
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        // Verifikasi signature
        if ($hashedKey !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $pesanan = Order::where('kode_pesanan', $request->order_id)->first();

        if (!$pesanan) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $transactionStatus = $request->transaction_status;
        $fraudStatus       = $request->fraud_status;

        if ($transactionStatus === 'capture') {
            $status = ($fraudStatus === 'accept') ? 'lunas' : 'ditolak';
        } elseif ($transactionStatus === 'settlement') {
            $status = 'lunas';
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $status = 'dibatalkan';
        } elseif ($transactionStatus === 'pending') {
            $status = 'menunggu_pembayaran';
        } else {
            $status = $pesanan->status;
        }

        $pesanan->update([
            'status'          => $status,
            'status_midtrans' => $transactionStatus,
        ]);

        return response()->json(['message' => 'OK']);
    }

   /**
     * Halaman sukses setelah pembayaran
     */
    public function sukses(Request $request)
    {
        // Nama variabel harus $pesanan
        $pesanan = Order::where('kode_pesanan', $request->order_id)->first();
        
        // Di dalam compact juga harus 'pesanan'
        return view('session-customer.checkout-sukses', compact('pesanan'));
    }

    /**
     * Halaman gagal / expired
     */
    public function gagal(Request $request)
    {
        // Nama variabel harus $pesanan
        $pesanan = Order::where('kode_pesanan', $request->order_id)->first();
        
        // Di dalam compact juga harus 'pesanan'
        return view('session-customer.checkout-gagal', compact('pesanan'));
    }
}