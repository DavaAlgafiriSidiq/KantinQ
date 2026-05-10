@extends('session-customer.rating-customer.layout-rating')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">
        <div class="card-header">
            <h4>Beri Rating Produk</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('rating.store') }}" method="POST">
                @csrf

                <input type="hidden" name="produk_id" value="{{ $produk->id }}">

                <!-- Rating -->
                <div class="mb-3">
                    <label class="form-label">Rating</label>

                    <select name="rating" class="form-select" required>
                        <option value="">Pilih Rating</option>
                        <option value="5">⭐⭐⭐⭐⭐ - Sangat Baik</option>
                        <option value="4">⭐⭐⭐⭐ - Baik</option>
                        <option value="3">⭐⭐⭐ - Cukup</option>
                        <option value="2">⭐⭐ - Buruk</option>
                        <option value="1">⭐ - Sangat Buruk</option>
                    </select>
                </div>

                <!-- Ulasan -->
                <div class="mb-3">
                    <label class="form-label">Ulasan</label>

                    <textarea
                        name="ulasan"
                        class="form-control"
                        rows="5"
                        placeholder="Tulis ulasan..."
                    ></textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    Kirim Rating
                </button>

            </form>

        </div>
    </div>

</div>

@endsection