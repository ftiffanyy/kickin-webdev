@extends('base.base')

@section('content')
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
                                {{ $products->brand }} - {{ $products->gender }}
                            </strong>
                        </p>
                        <h3 style="font-family: 'Bebas Neue', sans-serif; font-size: 36px; color: #181B1E;">
                            <strong>{{ $products->name }}</strong>
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

                    <!-- EU Size Selection (Grid Layout) -->
                    <div class="mt-3">
                        <h4 style="font-family: 'Bebas Neue', sans-serif; font-size: 24px; color: #181B1E;">Size</h4>
                        <div class="row row-cols-5 g-1">
                            @foreach ($availableSizes as $size => $stock)
                                <div class="col">
                                    <button type="button" class="size-btn w-100 
                                        @if ($stock == 0) disabled @endif"
                                        style="font-family: 'Fredoka', sans-serif; font-size: 14px; 
                                            @if ($stock == 0) color: #A5A9AE; @endif"
                                        onclick="highlightSize(this)">
                                        {{ $size }}
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>



                    {{-- <form action="{{ route('add_to_cart', $product->product_id) }}" method="POST"> --}}
                        @csrf
                        <!-- Hidden input to pass quantity -->
                        <input type="hidden" name="quantity" id="quantity-input">
                        
                        <!-- Quantity Dropdown -->
                        <div class="mt-3">
                            <h4 style="font-family: 'Bebas Neue', sans-serif; font-size: 24px; color: #181B1E;">Quantity</h4>
                            <select name="quantity" class="form-select" id="quantity-select" style="font-family: 'Fredoka', sans-serif; font-size: 14px;">
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        
                        <!-- Add to Cart Button -->
                        <button type="submit" class="btn w-100 mt-3" style="font-family: 'Fredoka', sans-serif; font-size: 16px; border: 2px solid #181B1E; background-color: #181B1E; color: #F8F9FA; transition: all 0.3s ease;">
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
        document.getElementById('quantity-select').addEventListener('change', function() {
            // Update the hidden quantity input with the selected value
            document.getElementById('quantity-input').value = this.value;
        });

        // Set the initial quantity when the page loads (default quantity value)
        document.getElementById('quantity-input').value = document.getElementById('quantity-select').value;

        // Function to handle the highlighting behavior
        function highlightSize(button) {
            // Remove the 'active' class from all buttons
            var buttons = document.querySelectorAll('.size-btn');
            buttons.forEach(function(btn) {
                btn.classList.remove('active');
            });

            // Add the 'active' class to the clicked button
            if (!button.disabled) {
                button.classList.add('active');
            }
        }
    </script>
@endsection


@push('styles')
    <style>
        /* Carousel Arrows Styling */
        .carousel-control-prev-icon, .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.5); /* Circular black with 50% transparency */
            border-radius: 50%; /* Circular shape */
            padding: 10px; /* Increase padding to make the buttons larger */
        }

        /* Position and hide arrows initially */
        .carousel-control-prev, .carousel-control-next {
            width: 5%; /* Adjust the width of the control button areas */
            top: 50%;
            transform: translateY(-50%);
            opacity: 0; /* Hide arrows by default */
            transition: opacity 0.3s ease; /* Smooth transition for opacity */
        }

        /* Show arrows on hover over the carousel */
        .carousel:hover .carousel-control-prev, .carousel:hover .carousel-control-next {
            opacity: 1; /* Show arrows when carousel is hovered */
        }

        /* Carousel container styling */
        .carousel-inner img {
            object-fit: cover; /* Ensure the images cover the container */
            height: 400px; /* Fixed height for images */
        }


        /* Quantity Dropdown Styling */
        .form-select {
            width: 100%; /* Ensure the dropdown takes full width */
        }

        /* Buttons Styling */
        .btn {
            font-size: 16px; /* Make the text inside buttons larger */
            padding: 12px; /* Increase padding for larger buttons */
        }

        .mt-3 {
            margin-top: 20px;
        }

        /* Button Styling */
        .size-btn {
            width: 100%;
            background-color: #ffffff;  /* Light gray background color */
            border: 1px solid #A5A9AE;  /* Thin border with dark color */
            padding: 15px;
            text-align: center;
            color: #000000;  /* Light font color */
            font-family: 'Fredoka', sans-serif; /* Use Fredoka for small text */
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Button Hover Effect */
        .size-btn:hover {
            background-color: #5F6266; /* Darker gray background on hover */
            color: #F8F9FA;  /* Light font color on hover */
            border-radius: 0px;
        }

        /* Button Focus Effect (when button is focused) */
        .size-btn:focus {
            background-color: #5F6266; /* Darker gray background on focus */
            color: #F8F9FA;  /* Light font color on focus */
            border-radius: 0px;
            outline: none;
        }

        /* Button when selected (active) */
        .size-btn.active {
            background-color: #181B1E; /* Dark background color for selected state */
            color: #F8F9FA; /* White text for selected button */
        }

        /* Disabled Button Styling */
        .size-btn.disabled {
            background-color: #F8F9FA;  /* Light gray for disabled button */
            cursor: not-allowed; /* Disable the cursor */
        }

    </style>
@endpush