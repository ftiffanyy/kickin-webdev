@extends('base.base')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-3">
            <h2 class="text-center mb-4" style="font-family: 'Bebas Neue', sans-serif; color: #181B1E; margin-top: 30px; font-weight: bold;">
                <i class="bi bi-list-ul" style="color: #181B1E; font-size: 30px; margin-right: 10px;"></i> Manage Product
            </h2>
            <!-- Create New Product Button & SEARCH BAR -->
            <div class="d-flex justify-content-end">
                <form id="searchForm" style="margin-right: 10px;">
                    {{-- <div class="input-group">
                        <input type="text" class="form-control" id="searchProduct" name="search" placeholder="Search" style="width: 250px;">
                        <button class="btn btn-info" type="submit" id="searchButton">
                            <i class="bi bi-search" style="font-size: 16px; color: white;"></i>
                        </button>
                    </div> --}}
                </form>
                <a href="{{ route('create_product_form') }}" class="btn btn-primary btn-sm custom-btn">Insert New Product</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div style="overflow-x: auto;">
            <table class="table table-striped">
                <thead class="table-head">
                    <tr>
                        <th scope="col" class="text-center col-align">ID</th>
                        <th scope="col" class="text-center col-align">Image</th>
                        <th scope="col" class="text-center col-align">Product Name</th>
                        <th scope="col" class="text-center col-align">Original Price</th>
                        <th scope="col" class="text-center col-align">Discount</th>
                        <th scope="col" class="text-center col-align">Brand</th>
                        <th scope="col" class="text-center col-align">Gender</th>
                        <th scope="col" class="text-center col-align">Rating</th>
                        <th scope="col" class="text-center col-align">Total Reviews</th>
                        <th scope="col" class="text-center col-align">Sold Count</th>
                        {{-- <th scope="col" class="text-center col-align">Hide</th> --}}
                        <th scope="col" class="text-center col-align">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <th scope="row" class="align-middle text-center">{{ $product->id }}</th>
                            <td class="align-middle text-center">
                                @if ($product->images->isNotEmpty()) <!-- Check if there are images -->
                                    <img src="{{ asset('images/' . $product->images->first()->url) }}" class="card-img-top product-image" alt="{{ $product->name }}" style="max-width: 100px; height: auto;">
                                @else
                                    <p>No image available</p>
                                @endif
                            </td>
                            <td class="align-middle" style="font-family: 'Fredoka', sans-serif; font-size: 0.9rem; color: #5F6266; vertical-align: middle;">{{ strtoupper($product->name) }}</td>
                            <td class="align-middle text-end" style="font-family: 'Fredoka', sans-serif; font-size: 0.9rem; color: #5F6266;">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="align-middle text-end" style="font-family: 'Fredoka', sans-serif; font-size: 0.9rem; color: #5F6266;">{{ $product->discount }}%</td>
                            <td class="align-middle text-center" style="font-family: 'Fredoka', sans-serif; font-size: 0.9rem; color: #5F6266;">{{ $product->brand }}</td>
                            <td class="align-middle text-center" style="font-family: 'Fredoka', sans-serif; font-size: 0.9rem; color: #5F6266;">{{ $product->gender }}</td>
                            <td class="align-middle text-center" style="font-family: 'Fredoka', sans-serif; font-size: 0.9rem; color: #5F6266;">
                                @php
                                    // Hitung data dari table reviews
                                    $reviewsFromTable = \App\Models\Review::where('product_id', $product->id);
                                    $newReviewsCount = $reviewsFromTable->count();
                                    $newReviewsAvg = $reviewsFromTable->avg('rating') ?? 0;
                                    
                                    // Data existing dari product
                                    $existingReviewsCount = $product->total_reviews; // 123 review
                                    $existingRatingAvg = $product->rating_avg;
                                    
                                    // Hitung weighted average
                                    if ($newReviewsCount > 0) {
                                        // Total semua rating = (existing_avg * existing_count) + (new_avg * new_count)
                                        $totalRatingPoints = ($existingRatingAvg * $existingReviewsCount) + ($newReviewsAvg * $newReviewsCount);
                                        $totalReviewsCount = $existingReviewsCount + $newReviewsCount;
                                        $finalRating = round($totalRatingPoints / $totalReviewsCount, 2);
                                    } else {
                                        $finalRating = $existingRatingAvg;
                                    }
                                @endphp
                                {{ $finalRating }} <i class="fas fa-star text-warning"></i>
                            </td>
                            <td class="align-middle text-end" style="font-family: 'Fredoka', sans-serif; font-size: 0.9rem; color: #5F6266;">
                                @php
                                    $reviewsCount = \App\Models\Review::where('product_id', $product->id)->count();
                                    $totalReviews = $product->total_reviews + $reviewsCount;
                                @endphp
                                {{ $totalReviews }}
                            </td>
                            <td class="align-middle text-end" style="font-family: 'Fredoka', sans-serif; font-size: 0.9rem; color: #5F6266;">
                                @php
                                    // Hitung total qty dari order_details berdasarkan variant product ini
                                    $soldFromOrders = \DB::table('order_details')
                                        ->join('variants', 'order_details.variant_id', '=', 'variants.id')
                                        ->where('variants.product_id', $product->id)
                                        ->sum('order_details.qty');
                                    
                                    $totalSold = $product->sold + $soldFromOrders;
                                @endphp
                                {{ $totalSold }}
                            </td>
                            {{-- <td class="align-middle">
                                <!-- Toggle Show Product: On/Off (Just the UI without backend connection) -->
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="product-toggle-{{ $product['product_id'] }}"/>
                                    <label class="form-check-label" for="product-toggle-{{ $product['product_id'] }}"></label>
                                </div>
                            </td> --}}
                            <td class="align-middle">
                                <!-- Show Details Button -->
                                <a href="{{ route('productadmin.details', ['id' => $product->id]) }}" class="btn btn-info btn-sm btn-spacing no-border">Show Details</a>
                                
                                <!-- Edit Button -->
                                <a href="{{ route('edit_product_form', ['id' => $product->id]) }}" class="btn btn-warning btn-sm btn-spacing no-border">Edit</a>

                                <!-- Delete Button -->
                                <form action="{{ route('delete_product', $product->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure want to delete this product?');" style="display: inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-black">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .btn-spacing {
            margin-right: 0px;
            margin-bottom: 5px;
        }

        /* Remove borders from Show Details and Edit Buttons */
        .no-border {
            border: none !important; /* Remove borders */
        }

        /* Body background and text color */
        body {
            background-color: #F8F9FA;
            color: #181B1E;
            font-family: 'Fredoka', sans-serif;
        }

        /* Table Styling */
        .table {
            background-color: #FFFFFF;
            font-size: 14px; /* Make the font smaller */
        }

        .table th, .table td {
            vertical-align: middle;
            font-weight: normal; /* Remove bold text */
            font-size: 14px; /* Make the font smaller */
            padding: 15px; /* Add consistent padding */
        }

        .table-head {
            background-color: #CFD1D4;
            color: #181B1E;
        }

        /* Title */
        .title-text {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 36px;
            color: #181B1E;
        }

        /* Button Styling */
        .btn {
            font-family: 'Fredoka', sans-serif;
            font-weight: normal;
        }

        /* Image inside table */
        .product-image {
            max-width: 100px;
            height: auto;
        }

        /* Action Buttons */
        .btn-info {
            background-color: #5F6266;
            color: #FFFFFF;
        }

        .btn-warning {
            background-color: #A5A9AE;
            color: #FFFFFF;
        }

        .btn-danger {
            background-color: #F44336;
            color: #FFFFFF;
        }

        /* Form Switch for Hide */
        .form-check-label {
            font-family: 'Fredoka', sans-serif;
            color: #181B1E;
            font-size: 14px; /* Smaller font size for the label */
        }

        /* Column Adjustments */
        .col-align {
            padding: 10px 20px; /* Add horizontal padding for consistent gap */
        }

        .custom-btn {
            width: auto; /* Automatically adjusts the width based on the content */
            max-width: 200px; /* Maximum width to prevent it from becoming too wide */
            max-height: 50px;
            padding-left: 20px; /* Padding for better appearance */
            padding-right: 20px; /* Padding for better appearance */
            display: flex; /* Ensures the content is aligned vertically */
            justify-content: center; /* Centers the text inside */
            align-items: center; /* Vertically aligns the text */
            background-color: #181B1E; /* Set background color to a standard blue */
            color: white; /* Text color set to white */
            border: 1px solid #181B1E; /* Border color matches background color */
            border-radius: 4px; /* Rounded corners for the button */
            font-family: 'Fredoka', sans-serif; /* Use consistent font */
            font-size: 0.9rem; /* Font size for better readability */
            text-align: center; /* Center text horizontally */
            transition: background-color 0.3s ease, border-color 0.3s ease; /* Smooth transition for hover effect */
        }

        .custom-btn:hover {
            background-color: #ffffff; /* Darker blue on hover */
            border-color: #181B1E; /* Darker border color on hover */
            color: #181B1E; /* Text color changes to white on hover */
        }

        /* Ensure the container for the button is aligned */
        .d-flex.justify-content-end {
            display: flex;
            justify-content: flex-end; /* Align the button to the right */
            align-items: center; /* Vertically align the button */
            margin-top: 20px; /* Adjust vertical positioning */
        }

        /* Align input and button on one line */
        .input-group {
            display: flex; /* Use flexbox for horizontal alignment */
            align-items: center; /* Vertically center the items */
            width: auto; /* Ensure the width adjusts based on content */
        }

        /* Remove blue border from the input and button */
        .input-group .form-control:focus,
        .input-group .btn:focus {
            outline: none; /* Remove the focus outline */
            box-shadow: none; /* Remove the shadow effect that appears when focused */
        }

        /* Optional: Remove border when not focused */
        .input-group .form-control {
            border: 1px solid #ccc; /* Regular border color */
            border-radius: 0.375rem 0 0 0.375rem; /* Rounded left corners */
            width: 250px; /* Set the width of the input */
        }

        /* Button styling */
        .input-group .btn {
            border: 1px solid #ccc; /* Regular border color */
            border-radius: 0 0.375rem 0.375rem 0; /* Rounded right corners */
            background-color: #5F6266; /* Default background color */
            color: white; /* Default text color */
            padding-left: 10px; /* Padding inside the button */
            padding-right: 10px; /* Padding inside the button */
            cursor: pointer; /* Pointer cursor on hover */
        }

        /* Hover effect: change border and background color */
        .input-group .btn:hover {
            border: 1px solid #181B1E; /* Change border to black on hover */
            background-color: #181B1E; /* Change background color to black */
            color: white; /* Keep text color white */
        }

        /* Custom black button style */
        .btn-black {
            background-color: #181B1E; /* Black background */
            color: #fff; /* White icon and text */
            border: none; /* Optional: removes button border */
            padding: 10px 20px; /* Optional: adjust padding */
            border-radius: 5px; /* Optional: rounded corners */
            text-transform: uppercase; /* Optional: capitalizes button text */
        }

        .btn-black:hover {
            background-color: #ff0000; /* Darker shade on hover */
            opacity: 0.9;
            color: #ffffff;
        }

                @media (max-width: 1200px) {
            .table th, .table td {
                font-size: 12px;
                padding: 10px;
            }

            .input-group .form-control {
                width: 200px;
            }

            .input-group .btn {
                font-size: 14px;
                padding-left: 8px;
                padding-right: 8px;
            }
        }

        @media (max-width: 992px) {
            .table th, .table td {
                font-size: 10px;
                padding: 8px;
            }

            .input-group .form-control {
                width: 150px;
            }

            .input-group .btn {
                font-size: 12px;
                padding-left: 6px;
                padding-right: 6px;
            }

            .custom-btn {
                max-width: 180px;
                padding-left: 15px;
                padding-right: 15px;
            }
        }

        @media (max-width: 768px) {
            .table th, .table td {
                font-size: 9px;
                padding: 5px;
            }

            .input-group .form-control {
                width: 100px;
            }

            .input-group .btn {
                font-size: 10px;
                padding-left: 5px;
                padding-right: 5px;
            }

            .custom-btn {
                max-width: 150px;
                padding-left: 10px;
                padding-right: 10px;
            }
        }

        @media (max-width: 576px) {
            .table th, .table td {
                font-size: 8px;
                padding: 4px;
            }

            .input-group .form-control {
                width: 100px;
            }

            .input-group .btn {
                font-size: 9px;
                padding-left: 4px;
                padding-right: 4px;
            }

            .custom-btn {
                width: auto;
                max-width: 120px;
            }

            .d-flex.justify-content-end {
                flex-direction: column;
                align-items: flex-start;
                margin-top: 15px;
            }
        }
    </style>
@endpush

@section('scripts')
    <script>
        // // Live search functionality
        // document.addEventListener('DOMContentLoaded', function() {
        //     const searchForm = document.getElementById('searchForm');
        //     const searchInput = document.getElementById('searchProduct');
        //     const searchButton = document.getElementById('searchButton');
        //     const tableBody = document.querySelector('tbody');
        //     let searchTimeout;

        //     // Function to perform search
        //     function performSearch(query) {
        //         fetch(`{{ route('productadmin.search') }}`, {
        //             method: 'POST',
        //             headers: {
        //                 'Content-Type': 'application/json',
        //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        //             },
        //             body: JSON.stringify({
        //                 search: query
        //             })
        //         })
        //         .then(response => response.json())
        //         .then(data => {
        //             updateTable(data.products);
        //         })
        //         .catch(error => {
        //             console.error('Search error:', error);
        //         });
        //     }

        //     // Function to update table with search results
        //     function updateTable(products) {
        //         tableBody.innerHTML = '';
                
        //         if (products.length === 0) {
        //             tableBody.innerHTML = `
        //                 <tr>
        //                     <td colspan="11" class="text-center" style="padding: 20px; color: #666;">
        //                         No products found matching your search criteria.
        //                     </td>
        //                 </tr>
        //             `;
        //             return;
        //         }

        //         products.forEach(product => {
        //             const row = createProductRow(product);
        //             tableBody.appendChild(row);
        //         });
        //     }

        //     // Function to create product row
        //     function createProductRow(product) {
        //         const tr = document.createElement('tr');
                
        //         // Calculate ratings and reviews
        //         const finalRating = product.final_rating || product.rating_avg;
        //         const totalReviews = product.total_reviews_count || product.total_reviews;
        //         const totalSold = product.total_sold_count || product.sold;
                
        //         tr.innerHTML = `
        //             <th scope="row" class="align-middle text-center">${product.id}</th>
        //             <td class="align-middle text-center">
        //                 ${product.image_url ? 
        //                     `<img src="${product.image_url}" class="card-img-top product-image" alt="${product.name}" style="max-width: 100px; height: auto;">` : 
        //                     '<p>No image available</p>'
        //                 }
        //             </td>
        //             <td class="align-middle" style="font-family: 'Fredoka', sans-serif; font-size: 0.9rem; color: #5F6266; vertical-align: middle;">${product.name.toUpperCase()}</td>
        //             <td class="align-middle text-end" style="font-family: 'Fredoka', sans-serif; font-size: 0.9rem; color: #5F6266;">Rp ${formatNumber(product.price)}</td>
        //             <td class="align-middle text-end" style="font-family: 'Fredoka', sans-serif; font-size: 0.9rem; color: #5F6266;">${product.discount}%</td>
        //             <td class="align-middle text-center" style="font-family: 'Fredoka', sans-serif; font-size: 0.9rem; color: #5F6266;">${product.brand}</td>
        //             <td class="align-middle text-center" style="font-family: 'Fredoka', sans-serif; font-size: 0.9rem; color: #5F6266;">${product.gender}</td>
        //             <td class="align-middle text-center" style="font-family: 'Fredoka', sans-serif; font-size: 0.9rem; color: #5F6266;">
        //                 ${finalRating} <i class="fas fa-star text-warning"></i>
        //             </td>
        //             <td class="align-middle text-end" style="font-family: 'Fredoka', sans-serif; font-size: 0.9rem; color: #5F6266;">${totalReviews}</td>
        //             <td class="align-middle text-end" style="font-family: 'Fredoka', sans-serif; font-size: 0.9rem; color: #5F6266;">${totalSold}</td>
        //             <td class="align-middle">
        //                 <a href="/admin/products/${product.id}/details" class="btn btn-info btn-sm btn-spacing no-border">Show Details</a>
        //                 <a href="/admin/products/${product.id}/edit" class="btn btn-warning btn-sm btn-spacing no-border">Edit</a>
        //                 <form action="/admin/products/${product.id}" method="POST" onsubmit="return confirm('Are you sure want to delete this product?');" style="display: inline">
        //                     <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
        //                     <input type="hidden" name="_method" value="DELETE">
        //                     <button type="submit" class="btn btn-black">
        //                         <i class="fa fa-trash"></i>
        //                     </button>
        //                 </form>
        //             </td>
        //         `;
                
        //         return tr;
        //     }

        //     // Function to format numbers
        //     function formatNumber(num) {
        //         return new Intl.NumberFormat('id-ID').format(num);
        //     }

        //     // Form submit event
        //     searchForm.addEventListener('submit', function(e) {
        //         e.preventDefault(); // Prevent default form submission
        //         const query = searchInput.value.trim();
                
        //         if (query.length === 0) {
        //             // If search is empty, reload the page to show all products
        //             window.location.reload();
        //         } else if (query.length >= 2) {
        //             performSearch(query);
        //         } else {
        //             alert('Please enter at least 2 characters to search');
        //         }
        //     });

        //     // Live search on input (optional - bisa dihapus jika hanya ingin search saat submit)
        //     searchInput.addEventListener('input', function() {
        //         clearTimeout(searchTimeout);
        //         const query = this.value.trim();
                
        //         if (query.length === 0) {
        //             // If search is empty, reload the page to show all products
        //             window.location.reload();
        //             return;
        //         }
                
        //         if (query.length >= 2) {
        //             searchTimeout = setTimeout(() => {
        //                 performSearch(query);
        //             }, 500); // Increased debounce time for less frequent requests
        //         }
        //     });

        //     // Clear search functionality
        //     searchInput.addEventListener('keyup', function(e) {
        //         if (e.key === 'Escape') {
        //             this.value = '';
        //             window.location.reload();
        //         }
        //     });
        // });

        function confirmDelete() {
            if (confirm("Are you sure you want to delete this product?")) {
                setTimeout(function() {
                    window.location.href = "{{ route('productadmin.show') }}?success=true";
                }, 500);
            }
        }
    </script>
@endsection