<!DOCTYPE html>
<html>
<head>
    <title>Invoice {{ $order->kode_pesanan }}</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h2>Bukti Transaksi KantinQ</h2>
    <p><strong>ID Pesanan:</strong> #{{ $order->kode_pesanan }}</p>
    <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
    <p><strong>Status Pembayaran:</strong> {{ strtoupper($order->status_midtrans) }}</p>
    
    <table>
        <thead>
            <tr>
                <th>Menu</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
            <tr>
                <td>{{ $item->produk->nama_produk ?? 'Menu Dihapus' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-right">Total Keseluruhan</th>
                <th>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>