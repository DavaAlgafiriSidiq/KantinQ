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
                            'lunas' => 'primary',
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
                                <li class="d-flex justify-content-between align-items-center text-muted mb-2">
                                    <div>
                                        <span>{{ $item->quantity }}x {{ $item->produk?->nama_produk ?? 'Menu Dihapus' }}</span>
                                        @if($order->status == 'selesai' && $item->produk)
                                            <div class="mt-2">
                                                @if(in_array($item->produk->id, $ratedProductIds))
                                                    <span class="btn btn-sm btn-secondary text-light rounded-pill shadow-sm fw-bold px-3 disabled" style="opacity: 0.7;">
                                                        <i class="fas fa-check-circle"></i> Sudah Diulas
                                                    </span>
                                                @else
                                                    <a href="{{ route('rating.create', $item->produk->id) }}" class="btn btn-sm btn-warning text-dark rounded-pill shadow-sm fw-bold px-3">
                                                        <i class="fas fa-star text-dark"></i> Beri Ulasan
                                                    </a>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    <span class="fw-medium">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    @if($order->status == 'siap_diambil')
                    <div class="mt-3 p-3 bg-warning-subtle border border-warning rounded-3 text-center shadow-sm">
                        <span class="d-block small text-warning-emphasis mb-1"><i class="fas fa-shield-alt me-1"></i> Tunjukkan Kode Ini ke Kasir</span>
                        <h3 class="fw-bold text-dark mb-0 tracking-widest" style="letter-spacing: 5px;">{{ $order->kode_unik }}</h3>
                    </div>
                    @endif
                    </div>
                
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="col-md-4 text-md-end mt-3 mt-md-0 d-flex flex-column align-items-md-end gap-2">
    
                    @if($order->status == 'selesai')
                        <a href="{{ route('customer.invoice', $order->id) }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                            <i class="fas fa-file-pdf me-1"></i> Unduh Bukti
                        </a>
                    @endif

                    <form action="{{ route('customer.pesan-lagi', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-warning text-white fw-bold rounded-pill px-4">
                            <i class="fas fa-redo-alt me-1"></i> Pesan Lagi
                        </button>
                    </form>

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