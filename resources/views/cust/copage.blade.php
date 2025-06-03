@extends('base.base')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3 shadow-lg z-3" role="alert" style="min-width: 300px;">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-success alert-danger fade show position-fixed top-0 end-0 m-3 shadow-lg z-3" role="alert" style="min-width: 300px;">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@section('content')
<style>
    /* -- semua style kamu tetap -- */
    body {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f5f5f5;
    }

    .copage-container {
        display: flex;
        justify-content: space-between;
        padding: 40px;
        gap: 40px;
    }

    /* Left Section - Delivery Options */
    .left-section {
        width: 65%;
        background-color: #ffffff;
        padding: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        margin-top: 30px;
    }

    .left-section h1 {
        font-size: 28px;
        color: #333;
        margin-bottom: 30px;
    }

    .left-section h2 {
        font-size: 20px;
        margin-bottom: 20px;
    }

    .delivery-options {
        margin-bottom: 30px;
    }

    .delivery-type {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        gap: 10px;
    }

    .delivery-type label {
        font-size: 16px;
        color: #333;
        font-weight: 600;
        padding: 15px 40px;
        cursor: pointer;
        border-radius: 4px;
        border: 2px solid #333;
        display: flex;
        justify-content: center;
        align-items: center;
        flex: 1;
        text-align: center;
        transition: all 0.3s ease;
    }

    /* Active button (when selected) */
    .delivery-options input[type="radio"]:checked + label {
        background-color: #333;
        color: white;
        border-color: #333;
    }

    .delivery-options input[type="radio"] {
        display: none;
    }

    .address-fields input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        margin-bottom: 10px;
    }

    .pick-up-section {
        display: none;
        margin-top: 20px;
    }

    .pick-up-section.active {
        display: block;
    }

    select#pickup-select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-color: #fff;
        border: 2px solid #333;
        border-radius: 8px;
        padding: 12px 40px 12px 16px;
        font-size: 16px;
        color: #333;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        background-image: url('data:image/svg+xml;charset=US-ASCII,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="%23333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="4 6 8 10 12 6"/></svg>');
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 16px 16px;
        transition: border-color 0.3s ease;
        margin-bottom: 20px;
        width: 100%;
    }

    select#pickup-select:hover {
        border-color: #555;
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    select#pickup-select:focus {
        outline: none;
        border-color: #222;
        box-shadow: 0 0 6px #555;
    }

    .save-continue-btn {
        background-color: white;
        color: #333;
        border-color: #333;
        border-radius: 4px;
        border: 2px solid #333;
        padding: 15px;
        width: 100%;
        font-size: 16px;
        cursor: pointer;
        margin-top: 20px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .save-continue-btn:hover {
        background-color: #333;
        color: white;
    }

    /* Right Section - Order Summary (style asli, tidak diubah) */
    .right-section {
        width: 35%;
        background-color: #ffffff;
        padding: 30px 35px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        margin-top: 30px;
        font-family: 'Poppins', sans-serif;
        display: flex;
        flex-direction: column;
        gap: 30px;
        max-width: 480px;
    }

    .right-section h2 {
        font-size: 24px;
        font-weight: 700;
        color: #222;
        margin-bottom: 15px;
        border-bottom: 2px solid #eee;
        padding-bottom: 15px;
        text-align: center;
    }

    .order-items {
        display: flex;
        flex-direction: column;
        gap: 25px;
        max-height: 360px;
        overflow-y: auto;
        padding-right: 5px;
    }

    .order-items::-webkit-scrollbar {
        width: 6px;
    }
    .order-items::-webkit-scrollbar-thumb {
        background-color: #bbb;
        border-radius: 3px;
    }

    .order-item {
        display: flex;
        gap: 18px;
        align-items: center;
        background: #f9f9f9;
        border-radius: 10px;
        padding: 14px 18px;
        box-shadow: inset 0 0 10px rgba(0,0,0,0.03);
        transition: box-shadow 0.3s ease;
    }
    .order-item:hover {
        box-shadow: inset 0 0 18px rgba(0,0,0,0.07);
    }

    .order-item img {
        width: 90px;
        height: 90px;
        border-radius: 10px;
        object-fit: cover;
        flex-shrink: 0;
    }

    .order-item-info {
        flex-grow: 1;
    }

    .order-item-info p:first-child {
        font-weight: 700;
        font-size: 15px;
        color: #222;
        margin-bottom: 6px;
    }
    .order-item-info p:last-child {
        font-size: 13px;
        color: #666;
        line-height: 1.3;
    }

    .order-item-price {
        text-align: right;
        white-space: nowrap;
        font-weight: 700;
        font-size: 16px;
        color: #444;
        width: 100px;
    }

    .summary-box {
        border-top: 2px solid #eee;
        padding-top: 15px;
        display: flex;
        flex-direction: column;
        gap: 14px;
        font-weight: 600;
        color: #444;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        font-size: 15px;
    }

    .summary-row.total {
        font-size: 18px;
        font-weight: 700;
        color: #222;
        margin-top: 12px;
        border-top: 1px solid #ddd;
        padding-top: 14px;
    }

    /* Style untuk label Size: dan Quantity: supaya konsisten */
    .order-item-info p {
        font-family: 'Fredoka', sans-serif;
        font-size: 1rem;
        color: #5F6266;
        margin: 0 0 6px 0;
    }

    .order-item-info p span.size-display,
    .order-item-info p span.quantity-display {
        font-weight: 600;
        color: #4A4A4A;
    }

    /* RESPONSIVE */
    @media (max-width: 1024px) {
        .copage-container {
            flex-direction: column;
            padding: 20px;
        }
        .left-section, .right-section {
            width: 100%;
            max-width: 100%;
            margin-top: 20px;
        }
        .delivery-type {
            flex-direction: column;
        }
        .delivery-type label {
            width: 100% !important;
            padding: 15px 0 !important;
        }
    }

    @media (max-width: 600px) {
        .left-section {
            padding: 20px;
        }
        .right-section {
            padding: 20px;
        }
        .save-continue-btn {
            font-size: 14px;
            padding: 12px;
        }
        .order-item img {
            width: 70px;
            height: 70px;
        }
        .order-item-info p:first-child {
            font-size: 13px;
        }
        .order-item-info p:last-child {
            font-size: 11px;
        }
        .order-item-price {
            font-size: 14px;
            width: 80px;
        }
    }

    /* Map container style */
    #my-map-display {
        overflow: hidden;
        max-width: 100%;
        width: 100%;
        height: 250px;
        border-radius: 10px;
        margin-top: 15px;
    }
    #my-map-display iframe {
        height: 100%;
        width: 100%;
        border: 0;
    }
</style>

<div class="copage-container">
    <!-- Left Section -->
    <div class="left-section">
        <h1>CHECKOUT</h1>
        <form action="{{ route('checkout') }}" method="POST" id="checkout-form">
            @csrf
            <div class="delivery-options">
                <h2>DELIVERY OPTIONS</h2>
                <div class="delivery-type">
                    <input type="radio" name="delivery" value="Shipping" checked id="ship-option" onclick="toggleDeliveryFields('Shipping')">
                    <label for="ship-option" class="active">Shipping</label>

                    <input type="radio" name="delivery" value="Pick Up" id="pick-up-option" onclick="toggleDeliveryFields('Pick Up')">
                    <label for="pick-up-option">Pick Up</label>
                </div>

                <!-- Address Fields -->
                <div class="address-fields" id="address-fields">
                    <input id="address-input" name="address" type="text" placeholder="Start typing the first line of your address">
                </div>

                <!-- Pick Up Location -->
                <div class="pick-up-section" id="pick-up-section">
                    <h3>Select a Location</h3>
                    <select id="pickup-select" name="pickup_location">
                        <option value="Pakuwon Mall, Surabaya">Pakuwon Mall</option>
                        <option value="Pakuwon City Mall, Surabaya">Pakuwon City Mall</option>
                        <option value="Galaxy Mall, Surabaya">Galaxy Mall</option>
                        <option value="Tunjungan Plaza, Surabaya">Tunjungan Plaza</option>
                        <option value="Ciputra World, Surabaya">Ciputra World</option>
                    </select>
                </div>

                <!-- Map -->
                <div id="my-map-display">
                    <iframe
                        id="map-frame"
                        frameborder="0"
                        src="https://www.google.com/maps/embed/v1/place?q=Surabaya&key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>

            <button type="submit" class="save-continue-btn">SAVE & CONTINUE</button>
        </form>
    </div>
    <!-- Right Section -->
    <div class="right-section">
        <h2>IN YOUR BAG</h2>

        <div class="order-items">
            @foreach($cartItems as $item)
                @php
                    $discount = $item->variant->product->product_discount ?? $item->variant->product->discount ?? 0;
                    $discountedPrice = $item->variant->product->price * (1 - $discount / 100);
                    $subtotal = $discountedPrice * $item->qty;
                    $productImage = $item->variant->product->images->first()->url ?? 'default-image.jpg';
                @endphp
                <div class="order-item">
                    <img src="{{ asset('images/' . $productImage) }}" alt="{{ $item->variant->product->name }}">
                    <div class="order-item-info">
                        <p>{{ $item->variant->product->name }}</p>
                        <p>Size: <span class="size-display">{{ $item->variant->size }}</span></p>
                        <p>Quantity: <span class="quantity-display">{{ $item->qty }}</span></p>
                    </div>
                    <div class="order-item-price">Rp {{ number_format($subtotal, 0, ',', '.') }}</div>
                </div>
            @endforeach
        </div>

        <div class="summary-box">
            @php
                $subtotalPrice = 0;
                foreach ($cartItems as $item) {
                    $discount = $item->variant->product->product_discount ?? $item->variant->product->discount ?? 0;
                    $discountedPrice = $item->variant->product->price * (1 - $discount / 100);
                    $subtotalPrice += $discountedPrice * $item->qty;
                }
                $tax = 0;
            @endphp

            <div class="summary-row">
                <span>Subtotal</span>
                <span id="subtotal-price">Rp {{ number_format($subtotalPrice, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span>Shipping</span>
                <span id="shipping-price">Rp 20.000</span>
            </div>
            <div class="summary-row">
                <span>Tax</span>
                <span>Rp {{ number_format($tax, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row total">
                <span>Total</span>
                <span id="total-price">Rp {{ number_format($subtotalPrice + 20000, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle tampilan field alamat/pickup
    function toggleDeliveryFields(deliveryType) {
        if (deliveryType === 'Pick Up') {
            document.getElementById('pick-up-section').classList.add('active');
            document.getElementById('address-fields').style.display = 'none';
        } else {
            document.getElementById('pick-up-section').classList.remove('active');
            document.getElementById('address-fields').style.display = 'block';
        }
        updateShippingPrice();
    }

    // Format angka ke Rupiah
    function formatRupiah(num) {
        return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    // Update harga shipping dan total
    function updateShippingPrice() {
        const shipPrice = 20000;
        const pickupPrice = 0;
        const isShip = document.getElementById('ship-option').checked;

        const shippingPriceEl = document.getElementById('shipping-price');
        const totalPriceEl = document.getElementById('total-price');
        const subtotalPriceEl = document.getElementById('subtotal-price');

        let shippingCost = isShip ? shipPrice : pickupPrice;

        shippingPriceEl.textContent = formatRupiah(shippingCost);

        let subtotalText = subtotalPriceEl.textContent.replace(/[^\d]/g, '');
        let subtotalNumber = parseInt(subtotalText, 10) || 0;

        let total = subtotalNumber + shippingCost;
        totalPriceEl.textContent = formatRupiah(total);
    }

    // Update map iframe sesuai input alamat atau pickup
    const addressInput = document.getElementById('address-input');
    const pickupSelect = document.getElementById('pickup-select');
    const mapFrame = document.getElementById('map-frame');

    function updateMap(location) {
        const apiKey = 'AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8';
        const encodedLocation = encodeURIComponent(location);
        const src = `https://www.google.com/maps/embed/v1/place?q=${encodedLocation}&key=${apiKey}`;
        mapFrame.src = src;
    }

    addressInput.addEventListener('input', () => {
        if(addressInput.value.trim() !== '') {
            updateMap(addressInput.value);
        }
    });

    pickupSelect.addEventListener('change', () => {
        updateMap(pickupSelect.value);
    });

    // Update harga saat pilihan delivery berubah
    document.getElementById('ship-option').addEventListener('change', updateShippingPrice);
    document.getElementById('pick-up-option').addEventListener('change', updateShippingPrice);

    // Inisialisasi harga dan peta saat load
    window.addEventListener('load', () => {
        updateShippingPrice();
        if(document.getElementById('ship-option').checked) {
            updateMap(addressInput.value || 'Surabaya');
        } else {
            updateMap(pickupSelect.value);
        }
    });

    // Validasi form custom sebelum submit supaya tidak error invalid form control
    document.getElementById('checkout-form').addEventListener('submit', function(e) {
        const delivery = document.querySelector('input[name="delivery"]:checked').value;
        const addressVal = addressInput.value.trim();
        const pickupVal = pickupSelect.value.trim();

        if(delivery === 'Shipping' && addressVal === '') {
            e.preventDefault();
            alert('Alamat wajib diisi untuk pengiriman.');
            addressInput.focus();
            return false;
        }
        if(delivery === 'Pick Up' && pickupVal === '') {
            e.preventDefault();
            alert('Harap pilih lokasi pick up.');
            pickupSelect.focus();
            return false;
        }
    });
</script>
@endsection
