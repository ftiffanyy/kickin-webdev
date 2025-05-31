@extends('base.base')

@section('content')

<!-- Display Error/Success Messages -->
    @if(session('error'))
        <div class="alert alert-danger mt-3" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success mt-3" role="alert">
            {{ session('success') }}
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
                        
                        <!-- EU Size Selection (Radio Button Style) -->
                        <div class="mt-3">
                            <h4 style="font-family: 'Bebas Neue', sans-serif; font-size: 24px; color: #181B1E;">Size</h4>
                            <div class="row row-cols-5 g-1">
                                @foreach ($availableSizes as $size => $stock)
                                    <div class="col">
                                        <div class="form-check">
                                            <input type="radio" 
                                                   class="form-check-input size-radio" 
                                                   name="size" 
                                                   id="size-{{ $loop->index }}" 
                                                   value="{{ $size }}" 
                                                   data-stock="{{ $stock }}" 
                                                   @if ($stock == 0) disabled @endif
                                                   onchange="handleSizeSelection(this, '{{ $size }}', {{ $stock }})"
                                                   required>
                                            <label class="form-check-label size-label" 
                                                   for="size-{{ $loop->index }}" 
                                                   style="font-family: 'Fredoka', sans-serif; font-size: 14px; 
                                                          padding: 12px 8px; border: 2px solid #181B1E; 
                                                          background-color: #F8F9FA; color: #181B1E; 
                                                          border-radius: 8px; cursor: pointer; 
                                                          transition: all 0.3s ease; display: block; 
                                                          text-align: center; width: 100%;
                                                          @if ($stock == 0) 
                                                              border-color: #A5A9AE; background-color: #e9ecef; 
                                                              color: #A5A9AE; cursor: not-allowed; opacity: 0.6; 
                                                          @endif">
                                                {{ $size }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- Error message for size -->
                            <div id="size-error" style="color: red; font-size: 12px; display: none; margin-top: 5px;">
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
        
        // Update label styling
        updateSizeLabels();
    }

    function updateSizeLabels() {
        // Remove selected styling from all labels
        document.querySelectorAll('.size-label').forEach(label => {
            if (!label.closest('.form-check').querySelector('input').disabled) {
                label.style.backgroundColor = '#F8F9FA';
                label.style.color = '#181B1E';
            }
        });
        
        // Add selected styling to the selected label
        const selectedRadio = document.querySelector('input[name="size"]:checked');
        if (selectedRadio) {
            const selectedLabel = document.querySelector(`label[for="${selectedRadio.id}"]`);
            selectedLabel.style.backgroundColor = '#181B1E';
            selectedLabel.style.color = '#F8F9FA';
        }
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

    // Auto-hide alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
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
        
        // Add hover effects for size labels
        document.querySelectorAll('.size-label').forEach(label => {
            const input = label.closest('.form-check').querySelector('input');
            
            if (!input.disabled) {
                label.addEventListener('mouseenter', function() {
                    if (!input.checked) {
                        this.style.backgroundColor = '#181B1E';
                        this.style.color = '#F8F9FA';
                    }
                });
                
                label.addEventListener('mouseleave', function() {
                    if (!input.checked) {
                        this.style.backgroundColor = '#F8F9FA';
                        this.style.color = '#181B1E';
                    }
                });
            }
        });
    });
</script>
@endsection

@push('styles')
    <style>
        /* Hide default radio button */
        .size-radio {
            display: none;
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