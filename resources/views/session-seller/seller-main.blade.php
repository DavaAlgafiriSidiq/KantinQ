@extends('session-seller.layout-seller') 

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-0 bg-light">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-1">Selamat Datang, {{ Auth::guard('seller')->user()->username }}! 🎉</h4>
                        <p class="text-muted mb-0">Email: {{ Auth::guard('seller')->user()->email }}</p>
                    </div>
                    <div class="d-flex gap-2">
                        <select id="filterStatus" class="form-select w-auto" onchange="fetchOrders()">
                            <option value="semua">Semua Pesanan Aktif</option>
                            <option value="baru">Pesanan Baru</option>
                            <option value="diproses">Sedang Dimasak</option>
                            <option value="siap_diambil">Siap Diambil</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold"><i class="fas fa-list-ol me-2 text-warning"></i>Antrean Pesanan Masuk</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Jam</th>
                            <th>ID Order</th>
                            <th>Menu & Detail</th>
                            <th>Estimasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="orderTableBody">
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="spinner-border text-warning" role="status"></div>
                                <p class="mt-2 text-muted">Memuat antrean...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<audio id="notifSuara" src="{{ asset('sounds/notification.mp3') }}" preload="auto"></audio>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let lastOrderCount = 0;

    function fetchOrders() {
        const status = $('#filterStatus').val();
        
        $.ajax({
            url: "{{ route('seller.orders.data') }}",
            method: "GET",
            data: { status: status },
            success: function(response) {
                // AC 3: Notifikasi visual/suara jika ada pesanan 'baru' bertambah
                if (response.baru_count > lastOrderCount) {
                    document.getElementById('notifSuara').play().catch(e => console.log("Audio play blocked"));
                    
                }
                lastOrderCount = response.baru_count;

                let html = '';
                if (response.orders.length === 0) {
                    html = '<tr><td colspan="6" class="text-center py-4 text-muted">Tidak ada pesanan aktif saat ini.</td></tr>';
                } else {
                    response.orders.forEach(order => {
                        // Menampilkan Detail Menu 
                        let items = '<ul>';
                        order.order_items.forEach(item => {
                            items += `<li class="small">${item.quantity}x ${item.produk ? item.produk.nama_produk : 'Menu'}</li>`;
                        });
                        items += '</ul>';

                        // Logika Tombol Aksi 
                        let btn = '';
                        if (order.status === 'baru') {
                            btn = `<button onclick="changeStatus(${order.id}, 'diproses')" class="btn btn-sm btn-primary">Terima & Masak</button>`;
                        } else if (order.status === 'diproses') {
                            btn = `<button onclick="changeStatus(${order.id}, 'siap_diambil')" class="btn btn-sm btn-warning text-white">Siap Diambil</button>`;
                        } else if (order.status === 'siap_diambil') {
                            btn = `<button onclick="changeStatus(${order.id}, 'selesai')" class="btn btn-sm btn-success">Selesai</button>`;
                        }

                        let badgeColor = order.status === 'baru' ? 'danger' : (order.status === 'diproses' ? 'primary' : 'warning');

                        html += `
                            <tr>
                                <td class="fw-bold">${order.time_formatted}</td>
                                <td>#${order.id}</td>
                                <td>${items}</td>
                                <td><span class="text-danger fw-bold">${order.eta} Menit</span></td>
                                <td><span class="badge bg-${badgeColor}">${order.status.toUpperCase()}</span></td>
                                <td>${btn}</td>
                            </tr>
                        `;
                    });
                }
                $('#orderTableBody').html(html);
            }
        });
    }

    function changeStatus(id, newStatus) {
        $.ajax({
            url: `/seller/orders/${id}/status`,
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                status: newStatus
            },
            success: function() {
                fetchOrders(); 
            }
        });
    }

    //  Auto update setiap 5 detik tanpa refresh
    setInterval(fetchOrders, 5000);

    $(document).ready(function() {
        fetchOrders();
    });
</script>
@endsection