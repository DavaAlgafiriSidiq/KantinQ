@extends('session-customer.landing-layout')

@section('content')
<div class="container py-5 mt-5" style="max-width:820px;">

    {{-- Breadcrumb / Step --}}
    <div class="d-flex align-items-center gap-2 mb-4 text-muted small">
        <a href="{{ route('keranjang') }}" class="text-decoration-none text-muted">
            <i class="fas fa-shopping-cart me-1"></i>Keranjang
        </a>
        <i class="fas fa-chevron-right" style="font-size:10px;"></i>
        <span class="text-warning fw-semibold"><i class="fas fa-receipt me-1"></i>Review Pesanan</span>
        <i class="fas fa-chevron-right" style="font-size:10px;"></i>
        <span>Pembayaran</span>
    </div>

    <h4 class="fw-bold mb-4">Review Pesanan</h4>

    {{-- Flash Message --}}
    @if(session('error'))
        <div class="alert alert-danger rounded-3 mb-4">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
        </div>
    @endif

    <div class="row g-4">

        {{-- Kiri: Detail Item --}}
        <div class="col-lg-7">

            {{-- Info Pickup --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3"><i class="fas fa-store text-warning me-2"></i>Info Pickup</h6>
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-3 bg-warning bg-opacity-10 p-2 text-warning">
                            <i class="fas fa-map-marker-alt fa-lg"></i>
                        </div>
                        <div>
                            <p class="fw-semibold mb-0">Ambil di Tempat (Pickup)</p>
                            <p class="text-muted small mb-0">Silakan ambil pesananmu langsung di warung/toko.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Daftar Item --}}
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 px-4 pt-4 pb-0">
                    <h6 class="fw-bold mb-0"><i class="fas fa-utensils text-warning me-2"></i>Item Pesanan</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            @php $subtotalCalc = 0; @endphp
                            @foreach($dataKeranjang as $item)
                            @php $subtotalCalc += $item->produk->harga * $item->jumlah; @endphp
                            <tr>
                                <td class="ps-4 py-3" style="width:55%">
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ asset('images/foto_produk/' . ($item->produk->foto_produk ?? 'default.png')) }}"
                                            class="rounded-3 object-fit-cover" style="width:52px;height:52px;"
                                            alt="{{ $item->produk->nama_produk }}">
                                        <div>
                                            <p class="fw-semibold mb-0 small">{{ $item->produk->nama_produk }}</p>
                                            <p class="text-muted mb-0" style="font-size:12px;">{{ $item->seller->nama_toko }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center py-3 text-muted small">{{ $item->jumlah }}x</td>
                                <td class="text-end pe-4 py-3 fw-semibold text-warning small">
                                    Rp {{ number_format($item->produk->harga * $item->jumlah, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            {{-- Catatan --}}
            <div class="card border-0 shadow-sm rounded-4 mt-4">
                <div class="card-body p-4">
                    <label class="fw-semibold small mb-2">
                        <i class="fas fa-sticky-note text-warning me-2"></i>Catatan untuk Warung
                    </label>
                    <textarea class="form-control border-1 rounded-3" rows="2" id="catatanInput"
                        placeholder="Contoh: Sambal dipisah, tidak pakai bawang...">{{ old('catatan') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Kanan: Ringkasan --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top:80px;">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4">Ringkasan Pembayaran</h6>

                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-muted">Subtotal ({{ $dataKeranjang->count() }} item)</span>
                        <span class="fw-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-muted">Biaya Layanan</span>
                        <span class="fw-semibold text-success">Gratis</span>
                    </div>

                    <hr class="my-3">

                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold">Total Bayar</span>
                        <span class="fw-bold fs-5 text-warning">
                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                        </span>
                    </div>

                    {{-- Metode Pembayaran Info --}}
                    <div class="rounded-3 bg-warning bg-opacity-10 p-3 mb-4 small">
                        <p class="fw-semibold mb-1 text-warning"><i class="fas fa-credit-card me-2"></i>Metode Pembayaran</p>
                        <p class="text-muted mb-0">Pilih metode di halaman berikutnya: QRIS, Transfer Bank, E-wallet (GoPay, ShopeePay), Kartu Kredit, dan lainnya.</p>
                    </div>

                    {{-- Tombol Bayar --}}
                    <form id="form-checkout" action="{{ route('checkout.proses') }}" method="POST">
                        @csrf
                        <input type="hidden" name="catatan" id="catatanHidden">
                        <button type="submit" id="btnBayar"
                            class="btn btn-warning text-white w-100 fw-bold py-3 rounded-3">
                            <i class="fas fa-lock me-2"></i>Bayar Sekarang
                        </button>
                    </form>

                    <a href="{{ route('keranjang') }}" class="btn btn-outline-secondary w-100 mt-2 small">
                        <i class="fas fa-arrow-left me-1"></i>Kembali ke Keranjang
                    </a>

                    {{-- Trust badge --}}
                    <div class="text-center mt-3">
                        <p class="text-muted mb-1" style="font-size:11px;">Pembayaran aman diproses oleh</p>
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b4/Midtrans_logo_%28ver._2023%29.svg/320px-Midtrans_logo_%28ver._2023%29.svg.png"
                            alt="Midtrans" style="height:20px; opacity:0.6;">
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    document.getElementById('form-checkout').addEventListener('submit', function (e) {
        document.getElementById('catatanHidden').value = document.getElementById('catatanInput').value;
        const btn = document.getElementById('btnBayar');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
    });
</script>
@endsection