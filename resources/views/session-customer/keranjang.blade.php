@extends('session-customer.landing-layout')

@section('content')
<div class="container py-5 mt-5">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold mb-0"><i class="fas fa-shopping-cart text-warning me-2"></i>Keranjang Saya</h3>
            <p class="text-muted small mb-0">
                {{ $keranjang->count() }} item dalam keranjang
            </p>
        </div>
        <a href="{{ route('session-customer.menu') }}" class="btn btn-outline-warning btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Lanjut Belanja
        </a>
    </div>

    @if($keranjang->count() > 0)
    <div class="row g-4">

        {{-- Tabel Keranjang --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 text-muted fw-semibold border-0" style="width:45%">Menu</th>
                                    <th class="py-3 text-muted fw-semibold border-0 text-center">Harga</th>
                                    <th class="py-3 text-muted fw-semibold border-0 text-center">Jumlah</th>
                                    <th class="py-3 text-muted fw-semibold border-0 text-center">Subtotal</th>
                                    <th class="pe-4 py-3 border-0"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $subtotal = 0; @endphp
                                @foreach($keranjang as $item)
                                @php $subtotal += $item->produk->harga * $item->jumlah; @endphp
                                <tr>
                                    {{-- Nama & Foto Menu --}}
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="{{ asset('images/foto_produk/' . ($item->produk->foto_produk ?? 'default.png')) }}"
                                                alt="{{ $item->produk->nama_produk }}"
                                                class="rounded-3 object-fit-cover"
                                                style="width:64px;height:64px;">
                                            <div>
                                                <p class="fw-semibold mb-0">{{ $item->produk->nama_produk }}</p>
                                                <p class="text-muted small mb-0">{{ $item->seller->nama_toko }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Harga --}}
                                    <td class="py-3 text-center">
                                        <span class="fw-semibold text-warning">
                                            Rp {{ number_format($item->produk->harga, 0, ',', '.') }}
                                        </span>
                                    </td>

                                    {{-- Jumlah --}}
                                    <td class="py-3 text-center">
                                        <div class="d-flex align-items-center justify-content-center gap-1">
                                            {{-- Ganti jumlah pake form atau link --}}
                                            <span class="fw-bold px-2">{{ $item->jumlah }}x</span>
                                        </div>
                                    </td>

                                    {{-- Subtotal --}}
                                    <td class="py-3 text-center fw-bold">
                                        Rp {{ number_format($item->produk->harga * $item->jumlah, 0, ',', '.') }}
                                    </td>

                                    {{-- Hapus --}}
                                    <td class="pe-4 py-3 text-center">
                                        <form action="{{ route('hapusKeranjang', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus item ini dari keranjang?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-light text-danger border-0" type="submit">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Catatan Kolektif --}}
            <div class="card border-0 shadow-sm rounded-4 mt-4">
                <div class="card-body p-4">
                    <label class="fw-semibold mb-2"><i class="fas fa-sticky-note text-warning me-2"></i>Catatan Tambahan</label>
                    <textarea class="form-control border-1" rows="3" name="catatan" form="form-checkout"
                        placeholder="Contoh: Sambal dipisah, ya..."></textarea>
                </div>
            </div>
        </div>

        {{-- Ringkasan Pembayaran --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top:80px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Ringkasan Pesanan</h5>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    
                    <hr>

                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold fs-5">Total</span>
                        <span class="fw-bold fs-5 text-warning">
                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                        </span>
                    </div>

                    <form id="form-checkout" action="{{ route('checkout') }}" method="POST">
                        @csrf
                        <input type="hidden" name="total_harga" value="{{ $subtotal }}">
                        <button type="submit" class="btn btn-warning text-white w-100 fw-bold py-3 rounded-3">
                            <i class="fas fa-credit-card me-2"></i>Pesan Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    @else
    {{-- Empty State --}}
    <div class="text-center py-5 my-5">
        <div class="mb-4">
            <i class="fas fa-shopping-cart fa-4x text-muted opacity-25"></i>
        </div>
        <h5 class="fw-bold text-muted">Keranjang Masih Kosong</h5>
        <a href="{{ route('session-customer.menu') }}" class="btn btn-warning text-white fw-semibold px-5 mt-2">
            Lihat Menu
        </a>
    </div>
    @endif

</div>
@endsection