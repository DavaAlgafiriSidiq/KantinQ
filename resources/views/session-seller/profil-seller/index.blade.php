@extends('session-seller.layout-seller')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-11">
        <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 0.5rem;">
            
            {{-- Header Biru --}}
            <div class="card-header bg-primary" style="height: 70px; border-radius: 0.5rem 0.5rem 0 0;"></div>
            
            <div class="card-body">
                {{-- Header Profil --}}
                <div class="d-flex align-items-center mb-5" style="margin-top: -35px; position: relative; z-index: 1;">
                    <div class="flex-shrink-0">
                        <img src="{{ $seller->foto_profil ? asset('storage/' . $seller->foto_profil) : 'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y&s=120' }}" 
                             alt="user-avatar" 
                             class="rounded-circle border border-5 border-white shadow-sm" 
                             height="120" width="120" 
                             style="object-fit: cover; background-color: #f8f9fa;" /> {{-- Warna disamakan dengan edit --}}
                    </div>
                    <div class="ms-4 mt-5">
                        <h4 class="fw-bold mb-1 text-dark">{{ $seller->nama_toko }}</h4>
                        <div class="d-flex align-items-center text-muted small">
                            <i class="bx bx-map-pin me-1"></i>
                            <span>Kantin UPI Purwakarta</span>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                        <i class="bx bx-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- TAMPILAN ISI DATA --}}
                <div class="row g-4 mt-2">
                    <div class="col-lg-4">
                        <div class="px-2">
                            {{-- Kotak WhatsApp --}}
                            <div class="mb-4 p-3 rounded-3" style="background: rgba(40, 167, 69, 0.05); border: 1px solid rgba(40, 167, 69, 0.1);">
                                <label class="text-muted small text-uppercase fw-bold mb-2 d-block" style="letter-spacing: 0.5px;">Nomor WhatsApp</label>
                                <div class="d-flex align-items-center">
                                    <i class='bx bxl-whatsapp fs-4 text-success me-2'></i>
                                    <span class="text-dark fw-medium">{{ $seller->nomor_hp }}</span>
                                </div>
                            </div>
                            
                            {{-- Kotak Email --}}
                            <div class="mb-2 p-3 rounded-3" style="background: rgba(105, 108, 255, 0.05); border: 1px solid rgba(105, 108, 255, 0.1);">
                                <label class="text-muted small text-uppercase fw-bold mb-2 d-block" style="letter-spacing: 0.5px;">Email Bisnis</label>
                                <div class="d-flex align-items-center">
                                    <i class='bx bx-envelope fs-4 text-primary me-2'></i>
                                    <span class="text-dark">{{ $seller->email }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="px-2">
                            <label class="text-muted small text-uppercase fw-bold mb-3 d-block" style="letter-spacing: 0.5px;">Deskripsi Toko</label>
                            <div class="p-4 rounded-3 text-dark" 
                                 style="background: rgba(0, 0, 0, 0.02); 
                                        border: 1px dashed #d9dee3; 
                                        min-height: 120px; 
                                        line-height: 1.6; 
                                        text-align: justify; 
                                        font-size: 0.9rem;">
                                {{ $seller->deskripsi_toko ?? 'Pemilik toko belum menambahkan deskripsi singkat.' }}
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-5 opacity-25" />

                <div class="d-flex justify-content-between align-items-center mb-2 px-2">
                    <a href="/seller-produk" class="btn btn-label-secondary border-0 btn-sm">
                        <i class='bx bx-chevron-left me-1'></i> Kembali ke Dashboard
                    </a>
                    <a href="{{ route('profil-seller.edit') }}" class="btn btn-primary px-4 shadow-sm btn-sm">
                        <i class='bx bx-edit-alt me-2'></i> Edit Profil Toko
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection