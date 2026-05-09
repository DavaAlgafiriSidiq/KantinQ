{{-- =============================================
     favorites/index.blade.php
     ============================================= --}}
@extends('session-customer.landing-layout')

@section('content')
<div class="container py-5 mt-5">
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="fw-bold"><i class="fas fa-heart text-danger me-2"></i>Menu Favorit Anda</h3>
            <p class="text-muted">Daftar menu yang Anda sukai dari riwayat pesanan sebelumnya.</p>
        </div>
    </div>

    <div class="row g-4">
        @forelse($favorites as $fav)
            <div class="col-md-4 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                    {{-- Foto Produk --}}
                    <div class="position-relative">
                        <img src="{{ asset('storage/' . $fav->produk->foto_produk) }}" 
                             class="card-img-top" 
                             alt="{{ $fav->produk->nama_produk }}"
                             style="height: 200px; object-fit: cover;">
                        <span class="position-absolute top-0 end-0 m-3 badge bg-warning rounded-pill">
                            Rp {{ number_format($fav->produk->harga, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold mb-1">{{ $fav->produk->nama_produk }}</h5>
                        <p class="text-muted small mb-3">{{ Str::limit($fav->produk->deskripsi, 50) }}</p>
                        
                        <div class="mt-auto">
                            <hr class="my-2 opacity-25">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <small class="text-muted">
                                    <i class="fas fa-shopping-bag me-1"></i> Dari: <strong>#{{ $fav->order->kode_pesanan }}</strong>
                                </small>
                            </div>
                            
                            {{-- Tombol Aksi --}}
                            <div class="d-grid gap-2">
                                <a href="{{ route('session-customer.menu') }}" class="btn btn-outline-warning rounded-pill fw-bold btn-sm">
                                    Pesan Lagi
                                </a>
                                {{-- Tombol Hapus Favorit --}}
                                <form action="{{ route('favorites.destroy', $fav->id) }}" method="POST" onsubmit="return confirm('Hapus dari favorit?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link btn-sm text-danger w-100 text-decoration-none">
                                        <i class="fas fa-trash-alt me-1"></i>Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-heart-broken fa-4x text-light"></i>
                </div>
                <h5 class="text-muted">Belum ada menu favorit.</h5>
                <p class="small text-muted">Ayo belanja dan tambahkan menu kesukaanmu!</p>
                <a href="{{ route('session-customer.menu') }}" class="btn btn-warning text-white rounded-pill px-4 mt-2">
                    Cari Menu Enak
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection