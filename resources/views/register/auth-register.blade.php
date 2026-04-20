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

            <div class="mb-3">
                <label class="form-label d-block fw-bold">Mendaftar Sebagai:</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="role" id="roleCustomer" value="customer"
                        disabled>
                    <label class="form-check-label text-muted" for="roleCustomer">
                        Customer <small>(Segera Hadir)</small>
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="role" id="roleSeller" value="seller" required>
                    <label class="form-check-label" for="roleSeller">Seller (Penjual)</label>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Toko / Nama Lengkap</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" id="pass" name="password" class="form-control" minlength="8" required>
                <small class="text-muted">Minimal 8 karakter.</small>
            </div>

            <div class="mb-4">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" id="konfirmasiPassword" name="password_confirmation" class="form-control"
                    required>
            </div>

            <button type="submit" id="btn-daftar" class="btn btn-primary w-100" disabled>Daftar Sekarang</button>
        </form>

        <div class="text-center mt-3">
            <small>Sudah punya akun? <a href="/seller-login">Login di sini</a></small>
        </div>
    </div>

</body>

</html>

<script>
    const pass = document.getElementById('pass');
    const confirm = document.getElementById('konfirmasiPassword');
    const btn = document.getElementById('btn-daftar');

    function validasiCepat() {
        // Cek apakah password dan konfirmasi cocok, dan apakah panjang password cukup
        const cocok = pass.value === confirm.value;
        const panjangCukup = pass.value.length >= 8;

        btn.disabled = !(cocok && panjangCukup);
    }

    pass.oninput = validasiCepat;
    confirm.oninput = validasiCepat;
</script>