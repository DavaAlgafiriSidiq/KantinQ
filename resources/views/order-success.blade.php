<h2>Halo, {{ $order->customer_name }}!</h2>
<p>Terima kasih sudah membeli di KantinQ. Berikut adalah rincian pesananmu:</p>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Harga</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->orderItems as $item)
        <tr>
            <td>{{ $item->produk->nama_produk }}</td>
            <td>{{ $item->quantity }}</td>
            <td>Rp {{ number_format($item->price) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<p><strong>Total Bayar: Rp {{ number_format($order->total_price) }}</strong></p>

<p>Silahkan tunjukkan QR Code di bawah ini ke kasir/penjual untuk pengambilan:</p>
<!-- <div>
    {{-- Generate QR Code dari Order ID --}}
</div> -->

<p>Selamat menikmati!</p>