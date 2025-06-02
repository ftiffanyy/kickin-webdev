@extends('base.base')

@section('content')
<style>
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
        flex: 1; /* supaya label sama lebar */
        text-align: center;
        transition: all 0.3s ease;
    }

    /* Active button (when selected) */
    .delivery-options input[type="radio"]:checked + label {
        background-color: #333; /* Black background for selected */
        color: white;
        border-color: #333;
    }

    .delivery-options input[type="radio"] {
        display: none;
    }

    .shipping-address {
        display: flex;
        margin-bottom: 20px;
    }

    .shipping-address label {
        font-size: 16px;
        color: #333;
        margin-right: 20px;
    }

    .name-fields {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        gap: 20px;
    }

    .name-fields input {
        flex: 1;
        padding: 10px;
        border-radius: 4px;
        border: 1px solid #ddd;
        font-size: 14px;
    }

    .address-fields input,
    .contact-fields input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        margin-bottom: 10px;
    }

    .contact-fields {
        display: flex;
        justify-content: space-between;
        margin-bottom: 30px;
        gap: 20px;
    }

    .contact-fields input {
        flex: 1;
    }

    .pick-up-section {
        display: none;
        margin-top: 20px;
    }

    .pick-up-section.active {
        display: block;
    }

    select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #fff;
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

    /* Right Section - Order Summary */
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

    /* Scrollbar */
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
        white-space: nowrap; /* supaya tetap sebaris tanpa wrap */
        font-weight: 700;
        font-size: 16px;
        color: #444;
        width: 100px; /* atau sesuai kebutuhan */
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

    .size-display,
    .quantity-display {
        font-family: 'Fredoka', sans-serif;
        font-size: 1rem;
        color: #5F6266;
        display: inline; /* hilangkan kotak, inline saja */
        padding: 0; /* hilangkan padding */
        border: none; /* hilangkan border */
        user-select: none;
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
    font-weight: 600; /* supaya beda dengan label */
    color: #4A4A4A; /* warna lebih gelap untuk isi size dan quantity */
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
        .name-fields, .contact-fields {
            flex-direction: column;
        }
        .name-fields input, .contact-fields input {
            width: 100% !important;
            margin-bottom: 15px;
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
</style>

<div class="copage-container">
    <!-- Left Section -->
    <div class="left-section">
        <h1>CHECKOUT</h1>
        <form action="#" method="POST">
            <div class="delivery-options">
                <h2>DELIVERY OPTIONS</h2>
                <div class="delivery-type">
                    <input type="radio" name="delivery" value="ship" checked id="ship-option" onclick="toggleDeliveryFields('ship')">
                    <label for="ship-option" class="active">Ship</label>

                    <input type="radio" name="delivery" value="pick-up" id="pick-up-option" onclick="toggleDeliveryFields('pick-up')">
                    <label for="pick-up-option">Pick Up</label>
                </div>

                <!-- Name Fields -->
                <div class="name-fields" id="name-fields">
                    <input type="text" placeholder="First Name" required>
                    <input type="text" placeholder="Last Name" required>
                </div>

                <!-- Address Fields -->
                <div class="address-fields" id="address-fields">
                    <input type="text" placeholder="Start typing the first line of your address" required>
                </div>

                <!-- Contact Fields -->
                <div class="contact-fields" id="contact-fields">
                    <input type="email" placeholder="Email" required>
                    <input type="tel" placeholder="Phone Number" required>
                </div>

                <!-- Pick Up Location -->
                <div class="pick-up-section" id="pick-up-section">
                    <h3>Select a Location</h3>
                    <select>
                        <option value="pakuwon-mall">Pakuwon Mall</option>
                        <option value="pakuwon-city-mall">Pakuwon City Mall</option>
                        <option value="galaxy-mall">Galaxy Mall</option>
                        <option value="tunjungan-plaza">Tunjungan Plaza</option>
                        <option value="ciputra-world">Ciputra World</option>
                    </select>
                </div>
            </div>
        </form>
        <form action="{{ route('checkout') }}" method="POST">
            @csrf
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
                $shippingCost = 20000; // Contoh tetap
                $tax = 0;
                $totalPrice = $subtotalPrice + $shippingCost + $tax;
            @endphp

            <div class="summary-row">
                <span>Subtotal</span>
                <span>Rp {{ number_format($subtotalPrice, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span>Shipping</span>
                <span>Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span>Tax</span>
                <span>Rp {{ number_format($tax, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row total">
                <span>Total</span>
                <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleDeliveryFields(deliveryType) {
        if (deliveryType === 'pick-up') {
            document.getElementById('pick-up-section').classList.add('active');
            document.getElementById('name-fields').style.display = 'none';
            document.getElementById('address-fields').style.display = 'none';
            document.getElementById('contact-fields').style.display = 'none';
        } else {
            document.getElementById('pick-up-section').classList.remove('active');
            document.getElementById('name-fields').style.display = 'flex';
            document.getElementById('address-fields').style.display = 'block';
            document.getElementById('contact-fields').style.display = 'flex';
        }
    }
</script>
@endsection
