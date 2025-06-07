@extends('base.base')

@section('content')

@php
    $isShipping = strtolower($order->status) === 'shipping';

    // Tentukan progress bar width sesuai shipping_status
    $progressPercent = 0;
    $status = strtolower($order->shipping_status ?? '');

    if ($status === 'pending') {
        $progressPercent = 2;
    } elseif ($status === 'dispatched') {
        $progressPercent = 35;
    } elseif ($status === 'in transit') {
        $progressPercent = 65;
    } elseif ($status === 'delivered') {
        $progressPercent = 100;
    }
    $canReview = in_array($status, ['delivered', 'already pick up']);
@endphp

<style>
  /* Fonts dan base styling */
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@700&family=Roboto&display=swap');

  body {
    font-family: 'Roboto', sans-serif;
    margin: 0; padding: 0;
    background-color: #F5F5F5;
    color: #333;
  }

  .order-details-container {
    display: flex;
    gap: 30px;
    margin: 30px;
  }

  /* Judul dengan panah kembali */
  .order-title {
    font-family: 'Poppins', sans-serif;
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
  }

  .order-title span {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .order-title:hover {
    color: #444;
  }

  .back-arrow {
    width: 32px;
    height: 32px;
    fill: #555;
    transition: fill 0.3s ease;
  }

  .order-title:hover .back-arrow {
    fill: #222;
  }

  .left-details {
    flex: 2;
    background-color: #fff;
    padding: 40px;
    border-radius: 16px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    color: #222;
    font-family: 'Roboto', sans-serif;
  }

  /* Loading bar container */
  .loading-bar-container {
    position: relative;
    height: 20px;
    background: #e0e6ed;
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 40px;
    box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
  }

  /* Loading bar progress - dinamis width */
  .loading-bar-progress {
    height: 100%;
    background: linear-gradient(90deg, #38b2ac 0%, #81e6d9 100%);
    border-radius: 10px 0 0 10px;
    width: {{ $progressPercent }}%;
    transition: width 0.6s ease;
  }

  /* Label container below bar */
  .loading-labels {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
    font-weight: 600;
    color: #555;
    margin-top: 8px;
    font-family: 'Roboto', sans-serif;
  }

  .delivery-info {
    font-size: 15px;
    color: #444;
    margin-top: 30px;
    font-family: 'Roboto', sans-serif;
  }

  /* Shipment progress */
  .shipment-progress {
    background: #fafafa;
    border-radius: 14px;
    padding: 30px 40px;
    box-shadow: inset 0 0 15px rgba(0,0,0,0.06);
    font-size: 16px;
    color: #4a5568;
    margin-top: 30px;
    line-height: 1.6;
    border: 1.5px solid #cbd5e0;
    font-weight: 600;
    font-family: 'Roboto', sans-serif;
  }

  .shipment-status {
    display: flex;
    flex-direction: column;
    gap: 14px;
  }

  .shipment-status .status {
    color: #222;
    font-weight: 700;
    padding-left: 12px;
    border-left: 3px solid #38b2ac;
    border-radius: 2px;
  }

  .shipment-status .datetime {
    color: #666;
    font-size: 14px;
    font-family: monospace;
    min-width: 190px;
    text-align: left;
    flex-shrink: 0;
    letter-spacing: 0.02em;
  }

  /* Map container styling */
  .map-container {
    width: 100%;
    max-width: 800px;
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

  /* Right Section */
  .right-section {
    max-width: 450px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    font-family: 'Roboto', sans-serif;
    align-self: flex-start; /* Supaya tinggi kanan menyesuaikan isi */
  }


  .right-section h2 {
    font-family: 'Poppins', sans-serif;
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
    font-family: 'Roboto', sans-serif;
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

  /* styling QTY dan SIZE supaya sama dan tidak biru */
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

  .review-form {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between; /* pastikan ada jarak antar elemen */
    gap: 12px;
    margin-top: 12px;
    flex-wrap: wrap;
  }

  .star-rating {
    display: flex;
    flex-direction: row-reverse;
    font-size: 28px;
    gap: 4px;
    align-items: center;
    margin: 0;
  }

  .star-rating input[type="radio"] {
    display: none;
  }

  .star-rating label {
    color: #ccc;
    cursor: pointer;
    transition: color 0.2s ease;
  }

  .star-rating input[type="radio"]:checked ~ label,
  .star-rating label:hover,
  .star-rating label:hover ~ label {
    color: gold;
  }

  .review-form button {
    background-color: white;
    border: 1.5px solid black;
    color: black;
    cursor: pointer;
    font-size: 14px;
    padding: 6px 14px;
    border-radius: 4px;
    transition: all 0.3s ease;
    white-space: nowrap;
  }

  .review-form button:hover {
    background-color: black;
    color: white;
  }



  /* Responsive */

  @media (max-width: 1024px) {
    .order-details-container {
      flex-direction: column;
      margin: 20px;
    }
    .left-details {
      padding: 25px;
    }
    .right-section {
      padding: 15px;
    }
  }

  @media (max-width: 768px) {
    .order-title {
      font-size: 26px;
    }
    .left-details {
      padding: 20px;
      border-radius: 12px;
    }
    .right-section {
      padding: 15px;
      border-radius: 12px;
    }
    .product-info p:first-child {
      font-size: 15px;
    }
    .product-info p.qty-size {
      font-size: 13px;
    }
  }

  @media (max-width: 480px) {
    .order-title {
      font-size: 22px;
      gap: 12px;
    }
    .loading-bar-container {
      height: 15px;
    }
    .loading-labels {
      font-size: 12px;
      margin-top: 6px;
    }
    .delivery-info {
      font-size: 13px;
      margin-top: 20px;
    }
    .shipment-progress {
      padding: 20px;
      font-size: 14px;
    }
    .product {
      flex-direction: column;
      align-items: flex-start;
      gap: 10px;
      padding: 10px;
    }
    .product img {
      width: 100%;
      max-width: 150px;
      height: auto;
      border-radius: 8px;
    }
    .product-price {
      margin-left: 0;
      font-size: 14px;
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
      <span>Order Details #{{ $order->id }}</span>
    </div>

    @if($isShipping)
      <!-- Shipping content -->
      <div class="loading-bar-container" aria-label="Shipment Progress">
        <div class="loading-bar-progress"></div>
      </div>
      <div class="loading-labels" aria-hidden="true">
        <span>Pending</span>
        <span>Dispatched</span>
        <span>In Transit</span>
        <span>Delivered</span>
      </div>

      <div class="delivery-info">
        <p><strong>Estimated delivery date</strong></p>
        <p>From {{ \Carbon\Carbon::parse($order->date)->format('M d, Y') }} to {{ \Carbon\Carbon::parse($order->date)->addDays(3)->format('M d, Y') }}</p>
        <p style="margin-top: 20px;"><strong>Delivery location</strong></p>
        <p>{{ $order->shipping_address }}</p>
      </div>

      <div class="shipment-progress">
        <div class="shipment-status">
          @foreach($order->shippings->sortByDesc('date') as $shipping)
            <div class="shipment-step">
              <div class="datetime">{{ \Carbon\Carbon::parse($shipping->date)->format('M d, Y  h:i A') }}</div>
              <div class="status">{{ $shipping->comment }}</div>
            </div>
          @endforeach
        </div>
      </div>

    @else
      <!-- Pick up content -->
      @php
          $encodedAlamat = urlencode($order->shipping_address); // Ambil alamat dari database (misalnya: "Pakuwon Mall")
          $apiKey = 'AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8'; // API key kamu
          $gmapSrc = "https://www.google.com/maps/embed/v1/place?q={$encodedAlamat}&key={$apiKey}";
      @endphp

      <div class="map-container">
        <iframe 
          style="height:100%; width:100%; border:0;" 
          frameborder="0" 
          src="{{ $gmapSrc }}"
          allowfullscreen 
          loading="lazy" 
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>

      <div class="delivery-info">
        <p><strong>Pick-up Location</strong></p>
        <p>{{ $order->shipping_address }}</p>
        <p><strong>Pick-up Time</strong></p>
        <p>From {{ \Carbon\Carbon::parse($order->pickup_start_date)->format('M d, Y') }} to {{ \Carbon\Carbon::parse($order->pickup_end_date)->format('M d, Y') }}</p>
        <p style="margin-top: 20px;"><strong>Pick-up Instructions</strong></p>
        <p>Please bring a valid ID and your order confirmation for pick-up.</p>
      </div>
    @endif

  </div>

  <div class="right-section">
    <h2>Products</h2>

    @foreach($order->orderDetails as $detail)
        @php
            $productId = $detail->variant->product->id;
            $existingReview = isset($userReviews) && $userReviews->has($productId) ? $userReviews->get($productId)->rating : 0;
        @endphp

        <a href="{{ route('product.details', ['id' => $productId]) }}" class="product" tabindex="0">
          <img src="{{ asset('images/' . $detail->variant->product->images->firstWhere('main', 1)->url) }}" alt="Product Image">
          <div class="product-info">
            <p>{{ strtoupper($detail->variant->product->name) }}</p>
            <p class="qty-size">QTY: {{ $detail->qty }}</p>
            <p class="qty-size">Size: {{ $detail->variant->size }}</p>

            @if($canReview)
              <form method="POST" action="{{ route('review_submit', ['order_id' => $order->id, 'product_id' => $productId]) }}" class="review-form">
                  @csrf
                  <div class="star-rating" data-product-id="{{ $productId }}">
                      @for ($i = 5; $i >= 1; $i--)
                          <input type="radio" id="star{{ $i }}-{{ $productId }}" name="rating" value="{{ $i }}" {{ ($existingReview == $i) ? 'checked' : '' }}>
                          <label for="star{{ $i }}-{{ $productId }}" title="{{ $i }} stars">&#9733;</label>
                      @endfor
                  </div>

                  @if(!$existingReview)
                    <button type="submit">Submit</button>
                  @endif
              </form>
            @elseif($existingReview)
              <p>Your rating:
                @for ($i = 1; $i <= 5; $i++)
                    <span style="color: {{ $i <= $existingReview ? 'gold' : '#ccc' }};">&#9733;</span>
                @endfor
              </p>
            @endif

          </div>
          <div class="product-price">
            Rp {{ number_format($detail->qty * $detail->price_at_purchase, 0, ',', '.') }}
          </div>
        </a>
    @endforeach

    <div class="summary">
      <div class="summary-item">
        <span>Subtotal</span>
        <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
      </div>
      <div class="summary-item">
        <span>Shipping</span>
        <span>Rp {{ $isShipping ? '20.000' : '0' }}</span>
      </div>
      <div class="summary-item total">
        <span>Total</span>
        <span>Rp {{ number_format($order->total_price + ($isShipping ? 20000 : 0), 0, ',', '.') }}</span>
      </div>
    </div>

   @if(!$isShipping)
    <div style="background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); font-family: 'Roboto', sans-serif;">
      <h3 style="text-align: center; font-size: 16px; font-weight: 700; color: #202020; margin-bottom: 12px;">Pick-up QR Code</h3>
      <div style="text-align: center;">
        <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ urlencode($order->shipping_address . ' | Order No: #' . $order->id) }}&size=200x200" 
             alt="QR Code for Pickup" 
             style="border: 1px solid #ccc; border-radius: 8px; padding: 5px;">
        <p style="font-size: 13px; color: #555; margin-top: 10px;">Scan this at the pick-up location</p>
      </div>
    </div>
    @endif
  </div>
</div>

@endsection
