<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Seller - KantinQ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">KantinQ Seller</a>
            <div class="d-flex">
                <form action="/seller-logout" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin keluar?');">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title">Selamat Datang, {{ Auth::guard('seller')->user()->username }}! 🎉</h4>
                        <p class="text-muted">Email kamu: {{ Auth::guard('seller')->user()->email }}</p>
                        <hr>
                        <p>Ini adalah halaman Dashboard Utama.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>