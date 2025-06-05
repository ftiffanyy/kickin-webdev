@extends('base.base')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3 shadow-lg z-3" role="alert" style="min-width: 300px;">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@section('content')

<style>
    /* Wishlist icon */
    .wishlist-icon {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 10;
    }

    /* tombol hati */
    .wishlist-btn {
        font-size: 20px;
        background: none;
        border: none;
        cursor: pointer;
        padding: 5px;
        color: white;
        -webkit-text-stroke: 1.5px #181b1e;
        text-stroke: 1.5px #181b1e;
        transition: color 0.3s ease;
    }

    /* hati merah kalau sudah di wishlist */
    .wishlist-btn.active {
        color: red;
        -webkit-text-stroke: 0;
        text-stroke: 0;
    }

    /* Product card styling */
    .product-card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
        transition: all 0.3s ease;
        border-radius: 8px;
        border: 1px solid #ddd;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }

    .card-img-top {
        max-height: 200px;
        object-fit: cover;
        border-bottom: 1px solid #ddd;
    }

    .card-body {
        display: flex;
        flex-direction: column;
        padding: 15px;
        text-align: center;
        flex-grow: 1;
    }

    .card-body .card-title {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .card-body .card-text {
        font-size: 14px;
        color: #777;
        margin-bottom: 10px;
    }

    .card-body .card-price {
        font-size: 16px;
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
    }

    .card-body .card-discount-price {
        font-size: 16px;
        color: red;
    }

    /* Layout for Products Grid - FIXED */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    /* Filter Section Styles */
    .filter-container {
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        width: 100%;
        margin-right: 20px;
        position: sticky;
        top: 0;
        max-height: 90vh;
        overflow-y: scroll;
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none;  /* Internet Explorer 10+ */
    }

    .filter-container::-webkit-scrollbar {
        display: none; /* Safari and Chrome */
    }

    .filter-container label {
        font-weight: bold;
        margin-right: 10px;
        font-size: 14px;
        color: #333;
    }

    .filter-container input[type="checkbox"],
    .filter-container input[type="radio"] {
        display: none;
    }

    .filter-btn {
        padding: 12px 18px;
        background-color: black;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-top: 20px;
        width: 100%;
    }

    .filter-btn:hover {
        background-color: black;
    }

    .filter-option {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
        flex-wrap: wrap;
        gap: 5px;
    }

    .filter-section {
        margin-bottom: 20px;
    }

    .collapse-header {
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 10px;
        cursor: pointer;
        color: black;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .collapse-header:hover {
        color: black;
    }

    .filter-option {
        margin-left: 0px;
    }

    .filter-section .collapse {
        margin-left: 0px;
    }

    /* Responsive grid */
    @media (max-width: 991px) {
        .product-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 767px) {
        .product-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Tambahan untuk tombol interaktif filter */
    .filter-option input[type="checkbox"] {
        display: none;
    }
    .filter-option label {
        border: 1px solid #ccc;
        padding: 8px 12px;
        border-radius: 5px;
        margin: 5px 0;
        cursor: pointer;
        display: inline-block;
        align-items: center;
        gap: 8px;
        min-width: 80px;
        text-align: center;
        transition: background-color 0.2s ease, transform 0.2s ease;
    }
    .filter-option input[type="checkbox"]:checked + label,
    .filter-option input[type="radio"]:checked + label {
        background-color: #000;
        color: white;
        border-color: #000;
        transform: scale(0.98);
    }
    .filter-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
    }

    .filter-color-circle {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        display: inline-block;
        border: 1px solid #ccc;
    }
    .color-black { background-color: black; }
    .color-white { background-color: white; border: 1px solid #888; }
    .color-red { background-color: red; }
    .color-blue { background-color: blue; }

    .clear-btn {
        background-color: #f9f9f9;
        color: #000;
        border: 1px solid #ccc;
        margin-top: 10px;
        display: block;
        text-align: center;
        text-decoration: none;
        border-radius: 5px;
        padding: 12px 18px;
        transition: background-color 0.3s ease;
    }
    .clear-btn:hover {
        background-color: #e5e5e5;
        color: #000;
        text-decoration: none;
    }
</style>

<div class="container" style="padding-top: 25px; padding-bottom: 50px;">
    <div class="row">
        <!-- Filter Section -->
        <div class="col-md-3">
            <div class="filter-container">
                <form method="GET" action="{{ route('products.filter') }}">
                    <!-- Gender Filter -->
                    <div class="filter-section">
                        <div class="collapse-header" data-bs-toggle="collapse" data-bs-target="#gender-filter" aria-expanded="false" aria-controls="gender-filter">
                            Jenis Kelamin <i class="fas fa-chevron-down"></i>
                        </div>
                        <div id="gender-filter" class="collapse">
                            <div class="filter-option filter-grid">
                                <input type="checkbox" name="gender[]" value="Male" id="gender_male" @if(in_array('Male', request('gender', []))) checked @endif>
                                <label for="gender_male">Male</label>

                                <input type="checkbox" name="gender[]" value="Female" id="gender_female" @if(in_array('Female', request('gender', []))) checked @endif>
                                <label for="gender_female">Female</label>

                                <input type="checkbox" name="gender[]" value="Unisex" id="gender_unisex" @if(in_array('Unisex', request('gender', []))) checked @endif>
                                <label for="gender_unisex">Unisex</label>
                            </div>
                        </div>
                    </div>

                    <!-- Color Filter -->
                    <div class="filter-section">
                        <div class="collapse-header" data-bs-toggle="collapse" data-bs-target="#color-filter" aria-expanded="false" aria-controls="color-filter">
                            Warna <i class="fas fa-chevron-down"></i>
                        </div>
                        <div id="color-filter" class="collapse">
                            <div class="filter-option filter-grid">
                                @foreach (['black', 'white', 'red', 'blue'] as $color)
                                    <input type="checkbox" name="color[]" value="{{ $color }}" id="color_{{ $color }}" @if(in_array($color, request('color', []))) checked @endif>
                                    <label for="color_{{ $color }}">
                                        <span class="filter-color-circle color-{{ $color }}"></span> {{ ucfirst($color) }}
                                    </label>
                                @endforeach

                            </div>
                        </div>
                    </div>

                    <!-- Size Filter -->
                    <div class="filter-section">
                        <div class="collapse-header" data-bs-toggle="collapse" data-bs-target="#size-filter" aria-expanded="false" aria-controls="size-filter">
                            Ukuran <i class="fas fa-chevron-down"></i>
                        </div>
                        <div id="size-filter" class="collapse">
                            <div class="filter-option filter-grid">
                                @foreach ($sizes as $size)
                                    <input type="checkbox" name="size[]" value="{{ $size }}" id="size_{{ $size }}" @if(in_array($size, request('size', []))) checked @endif>
                                    <label for="size_{{ $size }}">{{ $size }}</label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Brand Filter -->
                    <div class="filter-section">
                        <div class="collapse-header" data-bs-toggle="collapse" data-bs-target="#brand-filter" aria-expanded="false" aria-controls="brand-filter">
                            Brand <i class="fas fa-chevron-down"></i>
                        </div>
                        <div id="brand-filter" class="collapse">
                            <div class="filter-option filter-grid">
                                @foreach ($brands as $brand)
                                    <input type="checkbox" name="brand[]" value="{{ $brand }}" id="brand_{{ $brand }}" @if(in_array($brand, request('brand', []))) checked @endif>
                                    <label for="brand_{{ $brand }}">{{ ucfirst($brand) }}</label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Sort -->
                    <div class="filter-section">
                        <div class="collapse-header" data-bs-toggle="collapse" data-bs-target="#sort-filter" aria-expanded="false" aria-controls="sort-filter">
                            Sort By <i class="fas fa-chevron-down"></i>
                        </div>
                        <div id="sort-filter" class="collapse">
                            <div class="filter-option">
                                <input type="radio" name="sort" value="low_high" id="sort_low" @if(request('sort') == 'low_high') checked @endif>
                                <label for="sort_low">Price: Low to High</label>
                            </div>
                            <div class="filter-option">
                                <input type="radio" name="sort" value="high_low" id="sort_high" @if(request('sort') == 'high_low') checked @endif>
                                <label for="sort_high">Price: High to Low</label>
                            </div>
                        </div>
                    </div>

                    <div class="filter-btn-container">
                        <button type="submit" class="filter-btn">Apply Filters</button>
                        <a href="{{ route('product.show') }}" class="filter-btn clear-btn">Clear Filters</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Product Grid Section -->
        <div class="col-md-9">
            <div class="product-grid">
                @php $userId = session('user_id'); @endphp
                @foreach ($products as $product)
                    @php
                        $inWishlist = $userId ? \App\Models\Wishlist::where('user_id', $userId)
                                        ->where('product_id', $product->id)
                                        ->exists() : false;
                    @endphp

                    <div class="product-card" style="position:relative;">
                        <form action="{{ route('wishlist.toggle') }}" method="POST" class="wishlist-form" style="position: absolute; top: 10px; right: 10px; z-index: 10;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="wishlist-btn {{ $inWishlist ? 'active' : '' }}" aria-label="Toggle wishlist" title="Toggle wishlist">
                                <i class="fas fa-heart"></i>
                            </button>
                        </form>

                        <div class="card-body">
                            <a href="{{ route('product.details', ['id' => $product->id]) }}">
                                @if ($product->images->isNotEmpty())
                                    <img src="{{ asset('images/' . $product->images->first()->url) }}" class="card-img-top product-image" alt="{{ $product->name }}">
                                @else
                                    <p>No image available</p>
                                @endif
                            </a>

                            <h5 class="card-title">{{ strtoupper($product->name) }}</h5>
                            <p class="card-text"><i>{{ $product->brand }} - {{ $product->gender }}</i></p>

                            <p class="card-price">
                                @if ($product->discount > 0)
                                    <span style="text-decoration: line-through; color: gray;">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    <span class="card-discount-price">Rp {{ number_format($product->price * (1 - $product->discount / 100), 0, ',', '.') }}</span>
                                @else
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                @endif
                            </p>

                            <p class="card-text">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= floor($product->rating_avg))
                                        <i class="fas fa-star text-warning"></i>
                                    @elseif ($i - 0.5 <= $product->rating_avg && $product->rating_avg - floor($product->rating_avg) >= 0.25)
                                        <i class="fas fa-star-half-alt text-warning"></i>
                                    @else
                                        <i class="fas fa-star text-muted"></i>
                                    @endif
                                @endfor
                                ({{ $product->total_reviews }} reviews)
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
