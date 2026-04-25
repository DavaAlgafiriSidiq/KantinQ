<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Seller - KantinQ</title>
    
    <link rel="stylesheet" href="{{ asset('assets-dashboard/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets-dashboard/vendor/css/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets-dashboard/vendor/fonts/boxicons.css') }}" />
</head>
<body>

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Toko {{ $toko->name }}</h4>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="row mb-4">
                <div class="col-12">
                    <div class="card bg-{{ $isTokoBuka ? 'success' : 'danger' }} text-white">
                        <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <h5 class="card-title text-white mb-0">
                                Status Operasional: <strong>{{ $isTokoBuka ? 'BUKA' : 'TUTUP' }}</strong>
                            </h5>
                            
                            <form action="{{ route('seller.toggle-status', $toko->id) }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="btn btn-{{ $isTokoBuka ? 'light' : 'dark' }}">
                                    <i class='bx bx-power-off me-1'></i> 
                                    Ubah jadi {{ $isTokoBuka ? 'TUTUP' : 'BUKA' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <span class="fw-semibold d-block mb-1">Total Pendapatan Hari Ini</span>
                            <h3 class="card-title mb-2">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <span class="fw-semibold d-block mb-1">Pesanan Diselesaikan</span>
                            <h3 class="card-title mb-2">{{ $pesananSelesai }} Pesanan</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-lg-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0 me-2">Antrean Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <ul class="p-0 m-0">
                                <li class="d-flex mb-4 pb-1">
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2"><h6 class="mb-0">Pesanan Baru</h6></div>
                                        <div class="user-progress d-flex align-items-center gap-1">
                                            <span class="fw-semibold">{{ $pesananBaru }}</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex mb-4 pb-1">
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2"><h6 class="mb-0 text-warning">Sedang Diproses</h6></div>
                                        <div class="user-progress d-flex align-items-center gap-1">
                                            <span class="fw-semibold">{{ $pesananDiproses }}</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex">
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2"><h6 class="mb-0 text-success">Siap Diambil</h6></div>
                                        <div class="user-progress d-flex align-items-center gap-1">
                                            <span class="fw-semibold">{{ $pesananSiap }}</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0 me-2">Top 3 Menu Terlaris Hari Ini</h5>
                        </div>
                        <div class="card-body">
                            <ul class="p-0 m-0">
                                @foreach($topMenus as $menu)
                                <li class="d-flex mb-4 pb-1">
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2"><h6 class="mb-0">{{ $menu->name }}</h6></div>
                                        <div class="user-progress d-flex align-items-center gap-1">
                                            <span class="fw-semibold">{{ $menu->total_sold }} porsi</span>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <h5 class="card-header">Riwayat Pesanan Masuk</h5>
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Waktu</th>
                                        <th>Nama Pembeli</th>
                                        <th>Total Bayar</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @forelse($riwayatPesanan as $order)
                                    <tr>
                                        <td>{{ $order->created_at->format('H:i') }} <small class="text-muted">({{ $order->created_at->format('d/m') }})</small></td>
                                        <td><strong>{{ $order->user?->name ?? 'Anonim / Mahasiswa' }}</strong></td>
                                        <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                        <td>
                                            @if($order->status == 'baru')
                                                <span class="badge bg-label-info">BARU</span>
                                            @elseif($order->status == 'diproses')
                                                <span class="badge bg-label-warning">DIPROSES</span>
                                            @elseif($order->status == 'siap_diambil')
                                                <span class="badge bg-label-primary">SIAP DIAMBIL</span>
                                            @elseif($order->status == 'selesai')
                                                <span class="badge bg-label-success">SELESAI</span>
                                            @else
                                                <span class="badge bg-label-secondary">{{ strtoupper($order->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada pesanan masuk hari ini.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

    </div>
    

    <script src="{{ asset('assets-dashboard/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets-dashboard/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets-dashboard/js/main.js') }}"></script>

</body>
</html>