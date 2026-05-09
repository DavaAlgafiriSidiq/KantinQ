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
        {{-- Tombol Kembali ke Dashboard --}}
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
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                    {{-- Foto Produk --}}
                    @if($fav->produk && $fav->produk->foto_produk)
                        <img src="{{ asset('storage/' . $fav->produk->foto_produk) }}" 
                             class="card-img-top" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-utensils fa-3x text-muted"></i>
                        </div>
                    @endif

                    <div class="card-body">
                        <h5 class="card-title fw-bold small mb-1">{{ $fav->produk->nama_produk ?? 'Produk Tidak Ditemukan' }}</h5>
                        <p class="text-warning fw-bold mb-3">Rp {{ number_format($fav->produk->harga ?? 0, 0, ',', '.') }}</p>
                        
                        <div class="d-grid gap-2">
                            <a href="{{ route('session-customer.menu') }}" class="btn btn-warning text-white rounded-pill btn-sm fw-bold">
                                <i class="fas fa-shopping-cart me-1"></i> Pesan Lagi
                            </a>
                            
                            {{-- Tombol Hapus --}}
                            <form action="{{ route('favorites.destroy', $fav->id) }}" method="POST" onsubmit="return confirm('Hapus dari daftar favorit?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link btn-sm text-danger text-decoration-none w-100 mt-1">
                                    <i class="fas fa-trash me-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-heart-broken fa-4x text-muted opacity-50"></i>
                </div>
                <h5 class="text-muted">Belum ada menu favorit.</h5>
                <p class="small text-secondary">Ayo pesan menu favoritmu dan tambahkan ke sini!</p>
                <a href="{{ route('session-customer.menu') }}" class="btn btn-warning text-white rounded-pill px-4 mt-2 fw-bold">
                    Cari Menu Enak
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection