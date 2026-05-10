@extends('session-customer.landing-layout')

@section('content')

{{-- Flash Messages --}}
<div class="container mt-4">
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert" style="margin-top: 80px;">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-circle me-3 fs-4"></i>
                <div><strong>Ups!</strong> {{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('success_masuk') || session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert" style="margin-top: 80px;">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-3 fs-4"></i>
                <div><strong>Berhasil!</strong> {{ session('success_masuk') ?: session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>

<section class="py-5">
    <div class="container">
        <h2 class="mb-4 fw-bold">Daftar Menu</h2>

        {{-- Filter Kategori --}}
        <form method="GET" action="{{ route('session-customer.menu') }}" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <select name="kategori" onchange="this.form.submit()"
                        class="form-select border-0 shadow-sm fw-semibold"
                        style="padding: 12px; border-radius: 10px; background-color: #fff3cd; color: #856404;">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('kategori') == $category->id ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>

        {{-- Grid Produk --}}
        <div class="row">
            @forelse ($products as $product)
                @php $habis = $product->stok <= 0 || $product->status == 'unavailable'; @endphp
                <div class="col-md-3 mb-4">
                    <div class="card h-100 border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">

                        {{-- Foto Produk dengan Overlay jika Habis --}}
                        <div class="position-relative">
                            @if($product->foto_produk)
                                <img src="{{ asset($product->foto_produk) }}" alt="{{ $product->nama_produk }}"
                                    class="card-img-top" style="height: 180px; object-fit: cover;">
                            @else
                                <img src="{{ asset('images/foto_produk/default.png') }}" alt="Default"
                                    class="card-img-top" style="height: 180px; object-fit: cover;">
                            @endif

                            @if($habis)
                                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                                    style="background: rgba(0,0,0,0.5);">
                                    <span class="badge bg-danger px-3 py-2">HABIS / TUTUP</span>
                                </div>
                            @endif
                        </div>

                        <div class="card-body p-3 d-flex flex-column">
                            {{-- Badge Kategori --}}
                            <span class="badge bg-light text-dark mb-2 align-self-start"
                                style="font-size: 0.75rem; border: 1px solid #ddd;">
                                {{ $product->kategori->nama_kategori ?? 'Umum' }}
                            </span>

                            {{-- Nama Produk --}}
                            <h5 class="card-title fw-bold mb-1 text-truncate">{{ $product->nama_produk }}</h5>

                            {{-- Nama Toko --}}
                            <p class="card-text text-muted mb-2" style="font-size: 0.9rem;">
                                <i class="fas fa-store text-warning me-1"></i>
                                {{ $product->seller->nama_toko ?? 'Kantin' }}
                            </p>

                            {{-- Info Stok --}}
                            <p class="mb-2 small fw-bold">
                                @if(!$habis)
                                    <span class="text-success">
                                        <i class="fas fa-check-circle me-1"></i> Stok: {{ $product->stok }}
                                    </span>
                                @else
                                    <span class="text-danger">
                                        <i class="fas fa-times-circle me-1"></i> Tidak Tersedia
                                    </span>
                                @endif
                            </p>

                            {{-- Harga --}}
                            <p class="fw-bold fs-4 mb-2 text-dark">
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </p>

                            {{-- Rating --}}
                            <div class="text-warning small mb-3">
                                ⭐ {{ $product->ratings_avg_rating ? number_format($product->ratings_avg_rating, 1) : '0.0' }}
                                <span class="text-muted">({{ $product->ratings->count() }} ulasan)</span>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="d-flex align-items-center gap-2 mt-auto">
                                @if(!$habis)
                                    <form action="{{ route('tambahKeKeranjang', $product->id) }}" method="POST" class="flex-grow-1">
                                        @csrf
                                        <button type="submit" class="btn w-100 py-2"
                                            style="background-color: #fd7e14; border: none; font-weight: 600; border-radius: 8px; font-size: 0.85rem; color: white;">
                                            <i class="fas fa-shopping-cart me-1"></i> Keranjang
                                        </button>
                                    </form>
                                @else
                                    <button class="btn w-100 py-2"
                                        style="border-radius: 8px; font-size: 0.85rem; background-color: #e9ecef; color: #6c757d; border: none;" disabled>
                                        Habis
                                    </button>
                                @endif

                                {{-- Tombol Favorit --}}
                                @php
                                    $isFavorite = \App\Models\Favorite::where('id_user', Auth::id())
                                                    ->where('id_produk', $product->id)
                                                    ->first();
                                @endphp

                                @if($isFavorite)
                                    <form action="{{ route('favorites.destroy', $isFavorite->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-decoration-none p-0">
                                            <i class="fas fa-heart text-danger" style="font-size: 1.5rem;"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('favorites.toggle', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-link text-decoration-none p-0" style="color: #6c757d;">
                                            <i class="far fa-heart" style="font-size: 1.5rem;"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-utensils fa-3x text-light mb-3"></i>
                    <p class="text-muted">Yah, belum ada menu yang tersedia di kategori ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

@endsection