@extends('session-seller.layout-seller') 

@section('content')

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
@endsection