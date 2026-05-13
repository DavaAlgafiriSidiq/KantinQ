@extends('session-customer.landing-layout')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
                <div class="card-header bg-primary" style="height: 70px;"></div>
                
                <div class="card-body">
                    <div class="d-flex align-items-center mb-5" style="margin-top: -35px; position: relative; z-index: 1;">
                        <div class="flex-shrink-0">
                            <img src="{{ $profile && $profile->foto ? asset($profile->foto) : 'https://www.gravatar.com/avatar/000?d=mp&s=120' }}" 
                                 class="rounded-circle border border-5 border-white shadow-sm" 
                                 height="120" width="120" style="object-fit: cover; background-color: #f8f9fa;" />
                        </div>
                        <div class="ms-4 mt-5">
                            <h4 class="fw-bold mb-1 text-dark">{{ $user->name }}</h4>
                            <span class="badge bg-info">Customer Account</span>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="p-4 rounded-3 border bg-light">
                                <label class="text-muted small text-uppercase fw-bold mb-2 d-block">Nomor Handphone</label>
                                <span class="text-dark fw-bold">{{ $profile->phone ?? ($user->nomor_handphone ?? 'Belum diisi') }}</span>                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-4 rounded-3 border bg-light">
                                <label class="text-muted small text-uppercase fw-bold mb-2 d-block">Email</label>
                                <span class="text-dark fw-bold">{{ $user->email }}</span>
                            </div>
                        </div>
                    </div>
                    

                    <hr class="my-5 opacity-25" />

                    <div class="d-flex justify-content-between">
                        <a href="/" class="btn btn-secondary px-4">Kembali</a>
                        <a href="{{ route('profil-customer.edit') }}" class="btn btn-primary px-4">
                            Edit Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection