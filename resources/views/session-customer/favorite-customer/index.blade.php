@extends('session-customer.landing-layout')

@section('content')
<div class="container py-5 mt-5">
    <div class="row mb-4 align-items-center">
        <div class="col-md-8">
            <h3 class="fw-bold mb-1">
                <i class="fas fa-heart text-danger me-2"></i>Menu Favorit Anda
            </h3>
            <p class="text-muted mb-0">Daftar menu yang sering Anda pesan.</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="{{ route('session-customer.menu') }}" class="btn btn-secondary rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
            </a>
        </div>
    </div>

    <hr class="mb-5 opacity-10">

    <div class="row g-4">
        @forelse($favorites as $fav)
            <div class="col-md-4 col-lg-3">
                <div class="card h-100 border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
                    <img src="{{ !empty($fav->produk->foto_produk) ? asset('images/foto_produk/' . $fav->produk->foto_produk) : asset('images/foto_produk/default.png') }}" 
                         class="card-img-top" style="height: 180px; object-fit: cover;">

                    <div class="card-body d-flex flex-column p-3">
                        <h5 class="card-title fw-bold small mb-1">{{ $fav->produk->nama_produk ?? 'Produk' }}</h5>
                        <p class="text-warning fw-bold mb-2">Rp {{ number_format($fav->produk->harga ?? 0, 0, ',', '.') }}</p>
                        
                        <p class="text-muted mb-3" style="font-size: 0.75rem;">
                            <i class="fas fa-history me-1"></i>
                            Order Terkait: <strong>#{{ $fav->order->kode_pesanan ?? 'Pesanan Terakhir' }}</strong>
                        </p>

                        <div class="d-grid gap-2 mt-auto">
                            {{-- FORM UNTUK PESAN LAGI --}}
                            <form action="{{ route('tambahKeKeranjang', $fav->produk->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning text-white rounded-pill btn-sm fw-bold w-100">
                                    <i class="fas fa-shopping-cart me-1"></i> Pesan Lagi
                                </button>
                            </form>
                            
                            {{-- FORM UNTUK HAPUS --}}
                            <form action="{{ route('favorites.destroy', $fav->id) }}" method="POST" onsubmit="return confirm('Hapus dari favorit?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link btn-sm text-danger text-decoration-none w-100">
                                    <i class="fas fa-trash me-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-heart-broken fa-4x text-muted mb-3 opacity-50"></i>
                <h5 class="text-muted">Belum ada menu favorit.</h5>
            </div>
        @endforelse
    </div>
</div>
@endsection