@extends('base.base')

@section('content')
    <style>
        /* Simple wishlist icon styling (matching the product page) */
        .wishlist-icon {
            position: absolute;
            top: 4px;
            right: 8px;
            z-index: 10; /* Ensure it's above other elements */
        }

        /* Hide the actual checkbox */
        .wishlist-checkbox {
            display: none;
        }

        /* Style for the heart icon */
        .wishlist-btn {
            font-size: 20px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px;
        }

        /* Style for the default heart - outlined with white inside */
        .wishlist-btn i {
            color: white;
            -webkit-text-stroke: 1.5px #181b1e; /* Black outline */
            text-stroke: 1.5px #181b1e; /* Black outline */
        }

        /* Style for when heart is checked (active) */
        .wishlist-checkbox:checked + .wishlist-btn i {
            color: red;
            -webkit-text-stroke: 0;
            text-stroke: 0;
        }

        /* Product card styling - Matching product page behavior */
        .product-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            transition: all 0.3s ease;
            position: relative;
            border: 1px solid grey; /* Start with transparent border of same width */
            overflow: hidden; /* Keep content inside the border */
            margin-top: 10px;
        }

        /* Hover effect for the entire card */
        .product-card:hover {
            border: 2px solid black;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Image transition */
        .card-img-top {
            transition: transform 0.3s ease;
            max-height: 200px; /* Ensure consistent image height */
            object-fit: cover;
        }

        .product-card:hover .card-img-top {
            transform: scale(1.025);
        }

        /* Ensure image doesn't overlap heart icon */
        .card-body {
            position: relative;
            z-index: 0;
        }

        /* Ensure all columns are equally spaced */
        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .col {
            display: flex;
            margin-bottom: 20px; /* Add space between rows */
        }

        .card {
            width: 100%; /* Ensure card takes full width of column */
        }

        /* Add margin-bottom to create space between the content and footer */
        .container {
            margin-bottom: 50px; /* Adjust this value to your preference */
        }
    </style>

    <div class="container">
        <h2>Your Wishlist</h2>

        <div class="row row-cols-1 row-cols-md-4 g-4">
            @foreach ($wishlist as $product)
                <div class="col">
                    <div class="card product-card">
                        <!-- Wishlist Heart Icon - Using consistent styling -->
                        <div class="wishlist-icon">
                            <input type="checkbox" id="wishlist-{{ $product['product_id'] }}" class="wishlist-checkbox" checked>
                            <label for="wishlist-{{ $product['product_id'] }}" class="wishlist-btn">
                                <i class="fas fa-heart"></i>
                            </label>
                        </div>

                        <a href="{{ route('product.details', ['id' => $product['product_id']]) }}">
                            <img src="{{ asset($product['image']) }}" class="card-img-top" alt="{{ $product['product_name'] }}">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">{{ $product['product_name'] }}</h5>
                            <p class="card-text"><i>{{ $product['brand'] }} - {{ $product['gender'] }}</i></p>
                            <p class="card-text">
                                @if ($product['discount'] > 0)
                                    <span style="text-decoration: line-through; color: gray;">Rp {{ number_format($product['price'], 0, ',', '.') }}</span>
                                    <span style="color: red;">Rp {{ number_format($product['price'] * (1 - $product['discount'] / 100), 0, ',', '.') }}</span>
                                @else
                                    Rp {{ number_format($product['price'], 0, ',', '.') }}
                                @endif
                            </p>
                            <p class="card-text">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= floor($product['rating_avg']))
                                        <i class="fas fa-star text-warning"></i> <!-- Full Star -->
                                    @elseif ($i - 0.5 <= $product['rating_avg'] && $product['rating_avg'] - floor($product['rating_avg']) >= 0.25)
                                        <i class="fas fa-star-half-alt text-warning"></i> <!-- Half Star -->
                                    @else
                                        <i class="fas fa-star text-muted"></i> <!-- Empty Star -->
                                    @endif
                                @endfor
                                ({{ $product['total_reviews'] }} reviews)
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection