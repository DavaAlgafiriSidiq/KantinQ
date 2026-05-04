<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Akun - KantinQ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">

    <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
        <h3 class="text-center mb-4">Daftar Akun KantinQ</h3>

        <form action="/register" method="POST">
            @csrf

            <!-- Menampilkan pesan error jika ada -->
            @if ($errors->any())
                <div class="alert alert-danger py-2">
                    <ul class="mb-0 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Pilihan role -->
            <div class="mb-3">
                <label class="form-label d-block fw-bold">Mendaftar Sebagai:</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input role-radio" type="radio" name="role" id="roleCustomer" value="customer" required>
                    <label class="form-check-label" for="roleCustomer">Customer</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input role-radio" type="radio" name="role" id="roleSeller" value="seller" required>
                    <label class="form-check-label" for="roleSeller">Seller (Penjual)</label>
                </div>
            </div>

            <!-- Input untuk nama (Dinamis via JS) -->
            <div class="mb-3">
                <label class="form-label" id="label-username">Nama Lengkap</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>

            <!-- Input nomor HP (Dinamis via JS) -->
            <div class="mb-3" id="wrapper-nohp" style="display: none;">
                <label class="form-label" id="label-nohp">Nomor Handphone</label>
                <input type="text" name="nomor_handphone" id="nomor_handphone" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" id="pass" name="password" class="form-control" minlength="8" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" id="konfirmasiPassword" name="password_confirmation" class="form-control"
                    required>
            </div>

            <button type="submit" id="btn-daftar" class="btn btn-primary w-100">Daftar Sekarang</button>
        </form>

        <!-- Link untuk login jika sudah punya akun -->
        <div class="text-center mt-3">
            <small>Sudah punya akun? <br>
                <a href="/login">Login Customer</a> | <a href="/seller-login">Login Seller</a>
            </small>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleRadios = document.querySelectorAll('.role-radio');
            const labelUsername = document.getElementById('label-username');
            const wrapperNoHp = document.getElementById('wrapper-nohp');
            const labelNoHp = document.getElementById('label-nohp');
            // Element input dinamis untuk nomor handphone/whatsapp
            const inputNoHp = document.getElementById('nomor_handphone');

            roleRadios.forEach(radio => {
                radio.addEventListener('change', function () {
                    if (this.value === 'customer') {
                        labelUsername.textContent = 'Nama Pribadi';
                        wrapperNoHp.style.display = 'block';
                        labelNoHp.textContent = 'Nomor Handphone';
                        // Menyesuaikan name input untuk tabel users
                        inputNoHp.name = 'nomor_handphone';
                        inputNoHp.required = true;
                    } else if (this.value === 'seller') {
                        labelUsername.textContent = 'Nama Toko';
                        wrapperNoHp.style.display = 'block';
                        labelNoHp.textContent = 'Nomor WhatsApp';
                        // Menyesuaikan name input untuk tabel seller
                        inputNoHp.name = 'nomor_hp';
                        inputNoHp.required = true;
                    }
                });
            });
            
            // Trigger change if already selected (e.g., after validation error)
            const checkedRadio = document.querySelector('.role-radio:checked');
            if(checkedRadio) {
                checkedRadio.dispatchEvent(new Event('change'));
            }
        });
    </script>
</body>

</html>