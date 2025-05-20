@extends('base.base')

@section('content')
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #F5F5F5;
        color: #333;
    }

    .order-details-container {
        display: flex;
        gap: 30px;
        margin: 30px;
    }

    /* Judul dengan panah kembali besar dan clean */
    .order-title {
        font-weight: 700;
        font-size: 32px;
        margin-bottom: 25px;
        color: #222;
        display: flex;
        align-items: center;
        gap: 16px;
        cursor: pointer;
        user-select: none;
        transition: color 0.3s ease;
        font-family: 'Bebas Neue', sans-serif;
    }

    .order-title:hover {
        color: #444;
    }

    /* Panah kiri besar SVG inline */
    .back-arrow {
        width: 32px;
        height: 32px;
        fill: #555;
        transition: fill 0.3s ease;
    }

    .order-title:hover .back-arrow {
        fill: #222;
    }

    /* Left Section styling */
    .left-details {
        flex: 2;
        background-color: #fff;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #222;
    }

    /* Map container styling */
    .map-container {
        width: 100%;
        max-width: 800px;  /* Lebih lebar dari sebelumnya */
        height: 400px;
        border-radius: 14px;
        box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
        overflow: hidden;
    }

    .map-container iframe {
        height: 100%;
        width: 100%;
        border: 0;
    }

    .delivery-info {
        font-size: 15px;
        color: #444;
        margin-top: 30px;
    }

    /* Right Section styling */
    .right-section {
        flex: 1;
        max-width: 450px; /* Container kanan lebih kecil */
        display: flex;
        flex-direction: column;
        gap: 20px;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        font-family: Arial, sans-serif;
        max-height: fit-content;
    }

    .right-section h2 {
        margin: 0;
        text-align: center;
        color: #202020;
        font-weight: bold;
        font-size: 24px;
    }

    .product {
        display: flex;
        gap: 15px;
        padding: 15px;
        border-radius: 8px;
        background-color: #f9f9f9;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        align-items: center;
        transition: box-shadow 0.3s ease, background-color 0.3s ease;
        cursor: pointer;
        text-decoration: none;
    }
    .product:hover {
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        background-color: #f0f0f0;
    }

    .product img {
        width: 80px;
        height: 80px;
        border-radius: 5px;
        flex-shrink: 0;
    }

    .product-info {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .product-info p:first-child {
        font-weight: 700;
        margin-bottom: 4px;
        color: #222;
    }

    /* Tambahin class qty-size supaya style QTY & Size sama */
    .product-info p.qty-size {
        font-size: 13px;
        color: #555;
        margin-bottom: 2px;
    }

    .product-price {
        font-weight: 700;
        white-space: nowrap;
        margin-left: auto;
        font-size: 15px;
        color: #333;
    }

    .summary {
        border-top: 2px solid #ddd;
        padding-top: 20px;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        font-size: 16px;
        margin-bottom: 10px;
        color: #555;
    }

    .summary-item.total {
        font-weight: 700;
        font-size: 18px;
        color: #222;
    }

    /* QR Code Container */
    .qr-code-container {
        margin-top: 20px;
        padding: 15px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        text-align: center;
    }

    .qr-code-container img {
        max-width: 200px;
        width: 100%;
        height: auto;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .order-details-container {
            flex-direction: column;
            margin: 20px;
        }
        .left-details, .right-section {
            max-width: 100%;
            flex: unset;
            padding: 20px;
        }
        .right-section {
            max-width: 100%;
        }
        .map-container {
            max-width: 100%;
            height: 350px;
        }
    }

    @media (max-width: 600px) {
        .order-title {
            font-size: 28px;
        }
        .product img {
            width: 60px;
            height: 60px;
        }
        .product-price {
            font-size: 14px;
        }
        .summary-item {
            font-size: 14px;
        }
        .summary-item.total {
            font-size: 16px;
        }
        .map-container {
            height: 250px;
        }
    }
</style>

<div class="order-details-container">
    <div class="left-details">
        <!-- Judul dengan panah kembali -->
        <div class="order-title" onclick="window.history.back();" title="Back to Orders">
            <svg class="back-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
            </svg>
            <span>Order Details #862682274</span>
        </div>

        <!-- Map showing the Pakuwon Mall, Surabaya -->
        <div class="map-container">
            <iframe 
                style="height:100%; width:100%; border:0;" 
                frameborder="0" 
                src="https://www.google.com/maps/embed/v1/place?q=pakuwon+mall+surabaya&key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8" 
                allowfullscreen 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

        <div class="delivery-info">
            <p><strong>Pick-up Location</strong></p>
            <p>Pakuwon Mall, Surabaya, East Java</p>
            <p><strong>Pick-up Time</strong></p>
            <p>From Jun 25 to Jun 28, 2021</p>
            <p style="margin-top: 20px;"><strong>Pick-up Instructions</strong></p>
            <p>Visit the pick-up desk located at the ground floor, next to the main entrance. Please show your order ID for confirmation.</p>
        </div>
    </div>

    <div class="right-section">
        <h2>Products</h2>

        <a href="{{ route('product.details', ['id' => 1]) }}" class="product" tabindex="0">
            <img src="{{ asset('images/products/1/NIKE air force 1 _07 men_s basketball shoes - white,1.webp') }}" alt="Product Image">
            <div class="product-info">
                <p>NIKE Air Force 1 '07 Men's Basketball Shoes - White</p>
                <p class="qty-size">QTY: 1</p>
                <p class="qty-size">Size: 36</p>
            </div>
            <div class="product-price">
                Rp 1.084.300
            </div>
        </a>

        <div class="summary">
            <div class="summary-item">
                <span>Subtotal</span>
                <span>Rp 1.084.300</span>
            </div>
            <div class="summary-item">
                <span>Shipping</span>
                <span>Rp 0</span>
            </div>
            <div class="summary-item total">
                <span>Total</span>
                <span>Rp 1.084.300</span>
            </div>
        </div>

        <div class="qr-code-container">
            <p><strong>Pick-up QR Code</strong></p>
            <img src="{{ asset('images/qr.jpg') }}" alt="Pick-up QR Code">
        </div>
    </div>
</div>
@endsection
