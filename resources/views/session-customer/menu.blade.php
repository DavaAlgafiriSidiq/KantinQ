@extends('session-customer.landing-layout')

@section('content')

<div class="container mt-4"> {{-- Tambah container agar sejajar dengan konten --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert" style="margin-top: 80px;">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-circle me-3 fs-4"></i>
                <div>
                    <strong>Ups!</strong> {{ session('error') }}
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert" style="margin-top: 80px;">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-3 fs-4"></i>
                <div>
                    <strong>Berhasil!</strong> {{ session('success') }}
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>

<section class="py-5">
    <div class="container">
        <h2 class="mb-4">Daftar Menu</h2>

<!-- Untuk filter kategori produk -->
        <form method="GET"
            action="{{ route('session-customer.menu') }}"
            class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <select name="kategori"
                            onchange="this.form.submit()"
                            class="btn btn-warning fw-semibold text-start w-100 border-0"
                            style="padding: 10px 15px; border-radius: 8px;">
                        <option value="">
                            Semua Kategori
                        </option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('kategori') == $category->id ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
        
        <div class="row">
            @forelse ($products as $product)
                <div class="col-md-3 mb-4">
                    {{-- Mengurangi shadow dan ukuran agar lebih pas --}}
                    <div class="card h-100 border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
                        
                        {{-- Logika Foto: Cek file di folder images/foto_produk --}}
                        <img src="{{ !empty($product->foto_produk) ? asset('images/foto_produk/' . $product->foto_produk) : asset('images/foto_produk/default.png') }}" 
                            class="card-img-top" 
                            style="height: 180px; object-fit: cover;" 
                            alt="{{ $product->nama_produk }}">
                        
                            <div class="card-body p-3 d-flex flex-column">                            {{-- Badge Kategori }}
                            <span class="badge bg-light text-dark mb-2" style="font-size: 0.75rem; border: 1px solid #ddd;">
                                {{ $product->kategori->nama_kategori ?? 'Umum' }}
                            </span>

                            {{-- Nama Produk --}}
                            <h5 class="card-title fw-bold mb-1">{{ $product->nama_produk }}</h5>
                            
                            {{-- Nama Toko (Dibuat sedikit lebih menonjol) --}}
                            <p class="card-text text-muted mb-2" style="font-size: 0.9rem; font-weight: 500;">
                                <i class="fas fa-map-marker-alt text-warning me-1"></i> 
                                {{ $product->seller->nama_toko ?? '-' }}
                            </p>

                            <p class="card-text mb-2"
                            style="font-size: 0.9rem; font-weight: 500;">
                                <i class="fas fa-box-open text-warning me-1"></i>
                                @if($product->stok > 0)
                                    <span class="text-success">
                                        Stock: {{ $product->stok }}
                                    </span>
                                @else
                                    <span class="text-danger">
                                        Stock Habis
                                    </span>
                                @endif
                            </p>
                            
                            {{-- Harga --}}
                            <p class="card-text fw-bold fs-3 mb-3 text-dark">
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </p>
                            
                            {{-- Tombol Keranjang dan Favorit --}}
                            <div class="d-flex align-items-center gap-2 mt-auto">
                                
                                <form action="{{ route('tambahKeKeranjang', $product->id) }}" method="POST" class="flex-grow-1">
                                    @csrf
                                    <button type="submit" class="btn btn-primary w-100 py-2" style="background-color: #fd7e14; border: none; font-weight: 600; border-radius: 8px; font-size: 0.85rem;">
                                        <i class="fas fa-shopping-cart me-1"></i> Keranjang
                                    </button>
                                </form>

                                <button class="btn btn-link text-decoration-none p-0" style="color: #6c757d; font-size: 1.5rem; line-height: 1;">
                                    <i class="far fa-heart"></i>
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada produk yang tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection