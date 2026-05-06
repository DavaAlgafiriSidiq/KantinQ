@extends('session-customer.landing-layout')

@section('content')
<section class="py-5">
    <div class="container">
        <h2 class="mb-4">Daftar Menu</h2>
        
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
                        
                        <div class="card-body p-3">
                            {{-- Badge Kategori --}}
                            <span class="badge bg-light text-dark mb-2" style="font-size: 0.75rem; border: 1px solid #ddd;">
                                {{ $product->kategori->nama_kategori ?? 'Umum' }}
                            </span>

                            {{-- Nama Produk --}}
                            <h5 class="card-title fw-bold mb-1">{{ $product->nama_produk }}</h5>
                            
                            {{-- Nama Toko (Dibuat sedikit lebih menonjol) --}}
                            <p class="card-text text-muted mb-2" style="font-size: 0.9rem; font-weight: 500;">
                                <i class="fas fa-map-marker-alt text-warning me-1"></i> 
                                {{ $product->seller->nama_toko ?? 'Top Sticks' }}
                            </p>
                            
                            {{-- Harga --}}
                            <p class="card-text fw-bold fs-3 mb-3 text-dark">
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </p>
                            
                            {{-- Tombol Keranjang dan Favorit --}}
                            <div class="d-flex align-items-center gap-2 mt-auto">
                                
                                <button class="btn btn-primary flex-grow-1 py-2" style="background-color: #fd7e14; border: none; font-weight: 600; border-radius: 8px; font-size: 0.85rem;">
                                    <i class="fas fa-shopping-cart me-1"></i> Keranjang                                
                                </button>

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