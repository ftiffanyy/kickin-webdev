@extends('base.base')

@section('content')

<!-- Display Error/Success Messages -->
    @if(session('error'))
        <div class="alert alert-success alert-danger fade show position-fixed top-0 end-0 m-3 shadow-lg z-3" role="alert" style="min-width: 300px;">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3 shadow-lg z-3" role="alert" style="min-width: 300px;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container-fluid" style="background-color: #FFFFFF; padding-top: 25px; padding-bottom: 50px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6" style="background-color: #FFFFFF; padding: 20px;">
                    <!-- Carousel for Product Images -->
                    <div id="product-images" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($images as $index => $image)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <img src="{{ asset('images/' . $image->url) }}" class="d-block w-100" alt="{{ $products->name }}">
                            </div>
                        @endforeach
                    </div>

                        <!-- Left arrow button -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#product-images" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <!-- Right arrow button -->
                        <button class="carousel-control-next" type="button" data-bs-target="#product-images" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>

                <div class="col-md-6" style="background-color: #f8f9fad8; padding: 20px;">
                    <!-- Product Details -->
                    <div class="mt-3">
                        <p class="text-muted" style="font-family: 'Fredoka', sans-serif; font-size: 16px;">
                            <strong style="font-family: 'Bebas Neue', sans-serif; font-size: 22px;">
                                {{ strtoupper($products->brand) }} - {{ $products->gender }}
                            </strong>
                        </p>
                        <h3 style="font-family: 'Bebas Neue', sans-serif; font-size: 36px; color: #181B1E;">
                            <strong>{{ strtoupper($products->name) }}</strong>
                        </h3>
                        <p style="font-family: 'Fredoka', sans-serif; font-size: 14px; color: #5F6266; text-align: justify;">
                            {{ $products->description }}
                        </p>
                        <p style="font-family: 'Fredoka', sans-serif; font-size: 18px; color: #5F6266;">
                            @if ($products->discount > 0)
                                <span style="text-decoration: line-through; color: #A5A9AE;">Rp {{ number_format($products->price, 0, ',', '.') }}</span> 
                                <span style="color: red;">Rp {{ number_format($products->price * (1 - $products->discount / 100), 0, ',', '.') }}</span>
                            @else
                                Rp {{ number_format($products->price, 0, ',', '.') }}
                            @endif
                        </p>

                        <p style="font-family: 'Fredoka', sans-serif; font-size: 16px; color: #5F6266;">
                            {{ number_format($products->sold, 0, ',', '.') }} sold
                        </p>
                        <p style="font-family: 'Fredoka', sans-serif; font-size: 16px; color: #5F6266;">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= floor($products->rating_avg)) 
                                    <i class="fas fa-star text-warning"></i> <!-- Full Star -->
                                @elseif ($i - 0.5 <= $products->rating_avg && $products->rating_avg - floor($products->rating_avg) >= 0.25) 
                                    <i class="fas fa-star-half-alt text-warning"></i> <!-- Half Star -->
                                @else
                                    <i class="fas fa-star text-muted"></i> <!-- Empty Star -->
                                @endif
                            @endfor
                            ({{ $products->total_reviews }} reviews)
                        </p>
                    </div>

                    <form action="{{ route('add_to_cart', $products->id) }}" method="POST" id="add-to-cart-form">
                        @csrf
                        
                        <!-- EU Size Selection (Modern Radio Button Style) -->
                        <div class="mt-3">
                            <h4 style="font-family: 'Bebas Neue', sans-serif; font-size: 24px; color: #181B1E; margin-bottom: 15px;">Size</h4>
                            <div class="size-grid">
                                @foreach ($availableSizes as $size => $stock)
                                    <div class="size-option">
                                        <input type="radio" 
                                               class="size-radio" 
                                               name="size" 
                                               id="size-{{ $loop->index }}" 
                                               value="{{ $size }}" 
                                               data-stock="{{ $stock }}" 
                                               @if ($stock == 0) disabled @endif
                                               required>
                                        <label class="size-btn {{ $stock == 0 ? 'disabled' : '' }}" 
                                               for="size-{{ $loop->index }}">
                                            {{ $size }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <!-- Error message for size -->
                            <div id="size-error" style="color: #dc3545; font-size: 14px; display: none; margin-top: 10px; font-family: 'Fredoka', sans-serif;">
                                Please select a size!
                            </div>
                        </div>
                        
                        <!-- Quantity Dropdown -->
                        <div class="mt-3">
                            <h4 style="font-family: 'Bebas Neue', sans-serif; font-size: 24px; color: #181B1E;">Quantity</h4>
                            <select name="qty" class="form-select" id="quantity-select" style="font-family: 'Fredoka', sans-serif; font-size: 14px;" required>
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        
                        <!-- Add to Cart Button -->
                        <button type="submit" class="btn w-100 mt-3" id="add-to-cart-btn" 
                                style="font-family: 'Fredoka', sans-serif; font-size: 16px; border: 2px solid #181B1E; background-color: #181B1E; color: #F8F9FA; transition: all 0.3s ease;">
                            <i class="fas fa-cart-shopping"></i> Add to Cart
                        </button>
                    </form>

                    <!-- Buy Now Button -->
                    <form action="{{ route('copage') }}" method="POST" class="mt-3">
                        @csrf
                        <input type="hidden" name="quantity" id="quantity-input-buy-now">
                        <button type="submit" class="btn w-100" 
                            style="font-family: 'Fredoka', sans-serif; font-size: 16px; border: 2px solid #181B1E; background-color: #F8F9FA; color: #181B1E;">
                            Buy Now
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    let selectedSize = '';
    let selectedStock = 0;

    document.addEventListener('DOMContentLoaded', function() {
        // Handle size selection
        const sizeRadios = document.querySelectorAll('.size-radio');
        
        sizeRadios.forEach(function(radio) {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    const size = this.value;
                    const stock = parseInt(this.getAttribute('data-stock'));
                    handleSizeSelection(this, size, stock);
                }
            });
        });

        // Auto-hide alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            }, 5000);
        });
    });

    function handleSizeSelection(radioButton, size, stock) {
        if (stock === 0) return; // Prevent selection of out of stock items
        
        selectedSize = size;
        selectedStock = stock;
        
        console.log('Selected Size:', size);
        console.log('Available Stock:', stock);
        
        // Hide error message
        document.getElementById('size-error').style.display = 'none';
        
        // Update quantity dropdown based on stock
        updateQuantityDropdown(stock);
    }

    // Function to update the quantity dropdown based on available stock
    function updateQuantityDropdown(stock) {
        let quantitySelect = document.getElementById('quantity-select');
        // Clear previous options
        quantitySelect.innerHTML = '';
        
        // Add new options based on stock (max 10 or stock, whichever is lower)
        const maxQty = Math.min(10, stock);
        for (let i = 1; i <= maxQty; i++) {
            let option = document.createElement('option');
            option.value = i;
            option.textContent = i;
            quantitySelect.appendChild(option);
        }
    }

    // Form validation before submit
    document.getElementById('add-to-cart-form').addEventListener('submit', function(e) {
        const selectedSizeRadio = document.querySelector('input[name="size"]:checked');
        
        if (!selectedSizeRadio) {
            e.preventDefault();
            document.getElementById('size-error').style.display = 'block';
            document.getElementById('size-error').textContent = 'Please select a size!';
            
            // Scroll to size selection
            document.querySelector('input[name="size"]').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'center' 
            });
            
            return false;
        }
        
        const quantity = parseInt(document.getElementById('quantity-select').value);
        const stock = parseInt(selectedSizeRadio.dataset.stock);
        
        if (quantity > stock) {
            e.preventDefault();
            alert(`Sorry, only ${stock} items available for size ${selectedSizeRadio.value}`);
            return false;
        }
        
        console.log('Form submitted with:', {
            size: selectedSizeRadio.value,
            quantity: quantity
        });
        
        return true;
    });
</script>
@endsection

@push('styles')
    <style>
        /* Hide default radio button */
        .size-radio {
            display: none;
        }
        
        /* Size Grid Layout */
        .size-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 8px;
            margin-bottom: 10px;
        }
        
        /* Size Button Styling */
        .size-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 48px;
            padding: 12px 8px;
            font-family: 'Fredoka', sans-serif;
            font-size: 14px;
            font-weight: 500;
            text-align: center;
            background-color: #ffffff;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            color: #333333;
            cursor: pointer;
            transition: all 0.2s ease;
            user-select: none;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        /* Hover Effect */
        .size-btn:hover:not(.disabled) {
            border-color: #181B1E;
            background-color: #f8f9fa;
            transform: translateY(-1px);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }
        
        /* Focus Effect (when button is focused) */
        .size-btn:focus:not(.disabled) {
            background-color: #5F6266;
            color: #F8F9FA;
            border-color: #5F6266;
            outline: none;
        }
        
        /* Selected State - when radio is checked */
        .size-radio:checked + .size-btn {
            background-color: #181B1E !important;
            border-color: #181B1E !important;
            color: #F8F9FA !important;
            box-shadow: 0 2px 8px rgba(24, 27, 30, 0.3);
            transform: translateY(-1px);
        }
        
        /* Disabled State */
        .size-btn.disabled {
            background-color: #f5f5f5;
            border-color: #d0d0d0;
            color: #999999;
            cursor: not-allowed;
            opacity: 0.6;
        }
        
        .size-btn.disabled:hover {
            transform: none;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            background-color: #f5f5f5;
            border-color: #d0d0d0;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .size-grid {
                grid-template-columns: repeat(4, 1fr);
                gap: 6px;
            }
            
            .size-btn {
                min-height: 44px;
                padding: 10px 6px;
                font-size: 13px;
            }
        }
        
        /* Carousel Arrows Styling */
        .carousel-control-prev-icon, .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            padding: 10px;
        }

        .carousel-control-prev, .carousel-control-next {
            width: 5%;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .carousel:hover .carousel-control-prev, .carousel:hover .carousel-control-next {
            opacity: 1;
        }

        .carousel-inner img {
            object-fit: cover;
            height: 400px;
        }

        .form-select {
            width: 100%;
        }

        .btn {
            font-size: 16px;
            padding: 12px;
        }

        .mt-3 {
            margin-top: 20px;
        }
        
        .alert {
            border-radius: 5px;
            margin-top: 15px;
        }
    </style>
@endpush