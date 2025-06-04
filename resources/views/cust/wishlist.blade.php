@extends('base.base')

@section('content')
    <style>
        /* Wishlist icon */
        .wishlist-icon {
            position: absolute;
            top: 4px;
            right: 8px;
            z-index: 10; /* Ensure it's above other elements */
        }

        /* Style for the heart button */
        .wishlist-btn {
            font-size: 20px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px;
            color: white;
            -webkit-text-stroke: 1.5px #181b1e; /* Black outline */
            text-stroke: 1.5px #181b1e; /* Black outline */
            transition: color 0.3s ease;
        }

        /* Style for the active heart button (filled red) */
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

        /* Loading spinner for wishlist actions */
        .wishlist-loading {
            display: none;
            position: absolute;
            top: 4px;
            right: 35px;
            z-index: 11;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }

        /* Empty wishlist styling */
        .empty-wishlist {
            text-align: center;
            padding: 50px 0;
        }

        .empty-wishlist h3 {
            color: #666;
            margin-bottom: 20px;
        }

        .empty-wishlist p {
            color: #888;
            margin-bottom: 30px;
        }

        .btn-continue-shopping {
            background-color: #007bff;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .btn-continue-shopping:hover {
            background-color: #0056b3;
            color: white;
            text-decoration: none;
        }
    </style>

    <div class="container" style="padding-top: 25px; padding-bottom: 50px;">
        <h2>My Wishlist</h2>

        @if($wishlist->isEmpty())
            <div class="empty-wishlist">
                <h3>Your wishlist is empty</h3>
                <p>Discover amazing products and add them to your wishlist!</p>
                <a href="{{ route('product.show') }}" class="btn-continue-shopping">
                    <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
                </a>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-4 g-4">
                @foreach ($wishlist as $product)
                    <div class="col">
                        <div class="card product-card">
                            <!-- Wishlist Heart Icon -->
                            <form action="{{ route('wishlist.toggle') }}" method="POST" class="wishlist-form" style="position: absolute; top: 10px; right: 10px; z-index: 10;">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                <button type="submit" class="wishlist-btn {{ $wishlist ? 'active' : '' }}" aria-label="Toggle wishlist" title="Toggle wishlist">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </form>

                            <!-- Loading spinner -->
                            <div class="wishlist-loading" id="loading-{{ $product->product_id }}">
                                <div class="spinner-border spinner-border-sm text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>

                            <a href="{{ route('product.details', ['id' => $product->product_id]) }}">
                                <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->product_name }}">
                            </a>
                            <div class="card-body">
                                <h5 class="card-title">{{ strtoupper($product->product_name) }}</h5>
                                <p class="card-text"><i>{{ $product->brand }} - {{ $product->gender }}</i></p>
                                <p class="card-text">
                                    @if ($product->discount > 0)
                                        <span style="text-decoration: line-through; color: gray;">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        <span style="color: red;">Rp {{ number_format($product->price * (1 - $product->discount / 100), 0, ',', '.') }}</span>
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
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.wishlist-btn').forEach(btn => {
            btn.addEventListener('click', async function() {
                const productId = this.dataset.productId;
                const btnElement = this;

                btnElement.disabled = true;

                try {
                    const response = await fetch('{{ route("wishlist.toggle") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ product_id: productId })
                    });

                    const data = await response.json();

                    if(data.success) {
                        showToast(data.message, 'success');
                        // tidak toggle class sesuai permintaan
                    } else {
                        showToast(data.message || 'Terjadi kesalahan', 'error');
                    }
                } catch(err) {
                    showToast('Kesalahan jaringan. Coba lagi.', 'error');
                } finally {
                    btnElement.disabled = false;
                }
            });
        });
    });

    function showToast(message, type = 'success') {
        document.querySelectorAll('.custom-toast').forEach(t => t.remove());

        const toast = document.createElement('div');
        toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed top-0 end-0 m-3 shadow-lg custom-toast`;
        toast.style.minWidth = '300px';
        toast.style.zIndex = '9999';
        toast.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;

        document.body.appendChild(toast);

        setTimeout(() => {
            if (toast && toast.parentNode) toast.remove();
        }, 3000);
    }
</script>
@endsection
