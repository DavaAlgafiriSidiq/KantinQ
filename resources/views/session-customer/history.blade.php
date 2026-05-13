@extends('session-customer.landing-layout')

@section('content')
<div class="container py-5 mt-5">
    <div class="d-flex align-items-center mb-4">
        <h3 class="fw-bold mb-0"><i class="fas fa-history text-warning me-3"></i>Riwayat Pesanan</h3>
    </div>

    @forelse($orders as $order)
    <div class="card border-0 shadow-sm rounded-4 mb-3 overflow-hidden">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <span class="badge bg-light text-dark border">#{{ $order->kode_pesanan ?? $order->id }}</span>
                        <span class="text-muted small">{{ $order->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    
                    <h5 class="fw-bold text-dark mb-1">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</h5>
                    
                    <!-- Menampilkan status dengan warna -->
                    @php
                        $statusColors = [
                            'baru' => 'primary',
                            'diproses' => 'info',
                            'siap_diambil' => 'warning',
                            'selesai' => 'success',
                            'dibatalkan' => 'danger'
                        ];
                        $color = $statusColors[$order->status] ?? 'secondary';
                    @endphp
                   <span class="badge bg-{{ $color }} rounded-pill px-3">
                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                    </span>
                    
                    <div class="mt-3 p-3 bg-light rounded border">
                        <h6 class="fw-bold mb-2 text-secondary fs-6"><i class="fas fa-receipt me-2"></i>Detail Pesanan:</h6>
                        <ul class="list-unstyled mb-0 small">
                            @foreach($order->orderItems as $item)
                                <li class="d-flex justify-content-between text-muted mb-1">
                                    <span>{{ $item->quantity }}x {{ $item->produk->nama_produk ?? 'Menu Dihapus' }}</span>
                                    <span>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    </div>
                
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('session-customer.menu') }}" class="btn btn-warning text-white fw-bold rounded-pill px-4">
                        Pesan Lagi
                    </a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-5">
        <div class="mb-3">
            <i class="fas fa-utensils fa-3x text-muted opacity-25"></i>
        </div>
        <h5 class="text-muted">Belum ada riwayat pesanan nih.</h5>
        <a href="{{ route('session-customer.menu') }}" class="btn btn-warning text-white mt-2">Lihat Menu</a>
    </div>
    @endforelse
</div>
@endsection