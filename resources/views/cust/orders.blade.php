@extends('base.base')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3 shadow-lg z-3" role="alert" style="min-width: 300px;">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@section('content')
    <style>
        .my-orders {
            font-family: Arial, sans-serif;
            margin: 30px;
            color: #333;
        }

        h2 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            color: #202020;
        }

        .order-item {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
            transition: transform 0.3s ease-in-out;
        }

        .order-item:hover {
            transform: translateY(-5px);
        }

        .order-image {
            width: 120px;
            height: 120px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 20px;
            order: -1; /* Moves the image to the left */
        }

        .order-status {
            flex: 1;
            padding-right: 20px;
            border-right: 1px solid #ddd;
        }

        .order-status p {
            margin: 8px 0;
            font-size: 14px;
            color: #666;
        }

        .order-status p strong {
            color: #333;
        }

        .order-details {
            flex: 2;
            text-align: right; /* Align buttons to the right */
        }

        .order-details p {
            margin: 8px 0;
            font-size: 14px;
            color: #666;
        }

        button {
            padding: 12px 20px;
            margin: 5px;
            cursor: pointer;
            border: 1px solid #333; /* Black border */
            background-color: white;
            color: #333;
            border-radius: 4px;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #f1f1f1;
        }

        .order-item-header {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 16px;
            color: #333;
        }

        /* Loading bar effect (green progress bar) */
        .order-status .progress-bar {
            width: 100%;
            height: 5px;
            background-color: #ddd;
            border-radius: 5px;
            margin-top: 10px;
        }

        .order-status .progress-bar span {
            display: block;
            height: 100%;
            background-color: #4CAF50; /* Green color for "loading" */
            width: 70%; /* Change this percentage dynamically based on order status */
        }

        @media (max-width: 768px) {
            .order-item {
                flex-direction: column;
                text-align: center;
            }

            .order-status {
                border-right: none;
                padding-right: 0;
            }

            .order-image {
                width: 100px;
                height: 100px;
                margin: 0 0 15px 0; /* Adjust for mobile layout */
            }

            .order-details {
                margin-top: 15px;
                text-align: center;
            }
        }
    </style>

    <div class="my-orders">
        <!-- Add FontAwesome Icon next to the title -->
        <h2><i class="fas fa-box"></i> My Orders</h2>

        <!-- Order Item 1 -->
        <div class="order-item">
            <img src="{{ asset('images/products/1/NIKE air force 1 _07 men_s basketball shoes - white,1.webp') }}" alt="order image" class="order-image">
            <div class="order-status">
                <p class="order-item-header">ORDER STATUS: IT'S ORDERED!</p>
                <p>Total item(s) : 1 </p>
                <p>Estimated delivery Saturday 9th September 2023</p>
                <!-- Green Progress Bar -->
                <div class="progress-bar">
                    <span style="width: 10%"></span>
                </div>
            </div>
            <div class="order-details">
                <p>ORDER NO.: 862682274</p>
                <p>ORDER DATE: 06 Sep, 2023</p>
                <!-- First Button "Detail Order" -->
                <form action="{{ route('order_details', ['id' => 1]) }}" method="GET">
                    <button type="submit" class="view-order">DETAIL ORDER</button>
                </form>
                <button class="cancel-order">CANCEL ORDER</button>
            </div>
        </div>

        <!-- Order Item 2 -->
        <div class="order-item">
            <img src="{{ asset('images/products/4/PUMA speedcat og unisex lifestyle shoes - red,1.webp') }}" alt="Order Image" class="order-image">
            <div class="order-status">
                <p class="order-item-header">ORDER STATUS: IT'S DELIVERED!</p>
                <p>Total item(s) : 2 </p>
                <p>Delivered Saturday 28th November 2020</p>
                <!-- Green Progress Bar with 100% completion (for delivered) -->
                <div class="progress-bar">
                    <span style="width: 100%"></span>
                </div>
            </div>
            <div class="order-details">
                <p>ORDER NO.: 562353858</p>
                <p>SHIPPED DATE: 27 Nov, 2020</p>
                <form action="{{ route('order_details', ['id' => 2]) }}" method="GET">
                    <button type="submit" class="view-order">DETAIL ORDER</button>
                </form>
            </div>
        </div>
    </div>

@endsection
