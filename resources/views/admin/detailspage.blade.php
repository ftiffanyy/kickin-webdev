@extends('base.base')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3 shadow-lg z-3" role="alert" style="min-width: 300px;">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@section('content')

@php
    $isShipping = strtolower($order->status) === 'shipping';
    $statusOptions = $isShipping
        ? ['Pending', 'Dispatched', 'In Transit', 'Delivered']
        : ['Pending', 'Already Pick Up'];
    $currentStatus = strtolower($order->shipping_status);
@endphp

<div class="order-detail-admin">
    <h1 class="page-title" onclick="window.history.back()" style="cursor: pointer;">
        <i class="bi bi-arrow-left-short" style="margin-right: 10px;"></i> Order Detail #{{ $order->id }}
    </h1>

    <div class="order-detail-container">
        <!-- LEFT -->
        <div class="order-left-container">
            <div class="order-card">
                <div class="order-horizontal-info">
                    <div><strong>Name:</strong><br>{{ $order->user->name }}</div>
                    <div><strong>Phone:</strong><br>{{ $order->user->phone ?? '-' }}</div>
                    <div><strong>Type:</strong><br>{{ ucfirst($order->status) }}</div>
                    <div><strong>Date:</strong><br>{{ \Carbon\Carbon::parse($order->date)->format('d M Y') }}</div>
                </div>

                @if ($isShipping)
                <div class="delivery-box">
                    <div class="delivery-box-header">
                        <span class="label">Delivery Address</span>
                    </div>
                    <div class="delivery-box-content">
                        <p><strong>Name:</strong> {{ $order->user->name }}</p>
                        <p>{{ $order->shipping_address }}</p>
                        <p>Call: {{ $order->user->phone ?? '-' }}</p>
                    </div>
                </div>
                @endif

                <h3>Product Information</h3>
                <div class="product-table">
                    <div class="product-table-header">
                        <div class="col-item">Item</div>
                        <div class="col-qty">Qty</div>
                        <div class="col-size">Size</div>
                        <div class="col-total">Total</div>
                    </div>

                    @foreach($order->orderDetails as $detail)
                    <div class="product-table-row">
                        <div class="col-item">
                            <div class="product-info">
                                @php
                                    $mainImage = $detail->variant->product->images->firstWhere('main', 1);
                                @endphp

                                @if ($mainImage)
                                    <img src="{{ asset('images/' . $mainImage->url) }}" alt="{{ $detail->variant->product->name }}"/>
                                @else
                                    <p>Product</p>
                                @endif
                                <span>{{ $detail->variant->product->name }}</span>
                            </div>
                        </div>
                        <div class="col-qty">{{ $detail->qty }}</div>
                        <div class="col-size">{{ $detail->variant->size }}</div>
                        <div class="col-total">Rp {{ number_format($detail->qty * $detail->price_at_purchase, 0, ',', '.') }}</div>
                    </div>
                    @endforeach
                </div>

                <div class="order-summary-admin">
                    <div class="summary-item-admin">
                        <span><strong>Subtotal:</strong></span>
                        <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-item-admin">
                        <span><strong>Shipping:</strong></span>
                        <span>Rp {{ $isShipping ? '20.000' : '0' }}</span>
                    </div>
                    <div class="summary-item-admin total">
                        <span><strong>Total:</strong></span>
                        <span>Rp {{ number_format($order->total_price + ($isShipping ? 20000 : 0), 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="order-right-container">
            <div class="status-notes-container">
                <h3>Update Order Status</h3>
                <form action="{{ route('order.updateStatus', $order->id) }}" method="POST">
                    @csrf
                    <div class="status-section">
                        <div id="status-display" class="status-{{ str_replace(' ', '-', strtolower($order->shipping_status)) }}">
                            <span>{{ ucfirst($order->shipping_status) }}</span>
                        </div>

                        <label for="status-select"><strong>Update Status:</strong></label>
                        <select id="status-select" name="shipping_status" class="form-select">
                            @foreach ($statusOptions as $status)
                                <option value="{{ strtolower($status) }}" {{ $currentStatus === strtolower($status) ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>

                        <div class="message-box-section" style="margin-top: 15px;">
                            <label for="message-box"><strong>Admin Notes:</strong></label>
                            <textarea id="message-box" name="comment" rows="5" placeholder="Enter notes here..."></textarea>
                        </div>

                        <button type="submit" class="btn" style="margin-top: 20px;">Update Status</button>
                    </div>
                </form>
            </div>

            @if ($order->shippings->isNotEmpty())
            <div class="status-notes-container" style="margin-top: 30px;">
                <h4>Shipping History</h4>
                <ul style="list-style-type:none; padding-left: 0; margin: 0; max-height: 300px; overflow-y: auto;">
                    @foreach ($order->shippings->sortByDesc('date') as $shipping)
                    <li style="margin-bottom: 20px; border-left: 4px solid #000; padding-left: 10px;">
                        <p style="margin: 0; font-weight: 600; font-size: 14px; color: #000;">
                            {{ \Carbon\Carbon::parse($shipping->date)->format('M j, Y  h:i A') }}
                        </p>
                        <p style="margin: 0; font-size: 16px; font-weight: 500; color: #000;">
                            {{ $shipping->comment }}
                        </p>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Style sama seperti sebelumnya */
    .page-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 36px;
        margin: 30px;
        color: #181B1E;
        font-weight: bold;
        display: flex;
        align-items: center;
    }

    .order-detail-container {
        display: flex;
        gap: 30px;
        margin: 0 30px 30px;
        flex-wrap: nowrap;
    }

    .order-left-container {
        flex: 2;
        background-color: #fff;
        padding: 25px;
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .order-horizontal-info {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 30px;
        font-size: 16px;
    }

    .order-horizontal-info div {
        flex: 1;
        min-width: 180px;
    }

    .delivery-box {
        background-color: #f0f0f0;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 30px;
    }

    .delivery-box-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .delivery-box .label {
        font-weight: 600;
        font-size: 15px;
        color: #666;
    }

    .delivery-box-content p {
        margin: 4px 0;
        font-size: 15px;
    }

    .product-table {
        display: flex;
        flex-direction: column;
        margin-top: 20px;
        margin-bottom: 30px;
        font-size: 15px;
        width: 100%;
    }

    .product-table-header,
    .product-table-row {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr;
        gap: 10px;
        padding: 12px 16px;
        align-items: center;
    }

    .product-table-header {
        background-color: #f0f0f0;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 14px;
        border-radius: 8px 8px 0 0;
    }

    .product-table-row {
        background-color: #f9f9f9;
        border-bottom: 1px solid #ddd;
        font-size: 15px;
    }

    .product-table-row:last-child {
        border-radius: 0 0 8px 8px;
        border-bottom: none;
    }

    .product-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .product-info img {
        width: 50px;
        height: 50px;
        border-radius: 6px;
        object-fit: cover;
    }

    .order-summary-admin {
        background-color: #FFFFFF;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .summary-item-admin {
        display: flex;
        justify-content: space-between;
        font-size: 16px;
        margin-bottom: 10px;
    }

    .summary-item-admin.total {
        font-weight: 700;
        font-size: 18px;
        color: #222;
    }

    .order-right-container {
        flex: 1;
    }

    .status-notes-container {
        background-color: #FFFFFF;
        padding: 20px;
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .form-select {
        padding: 8px;
        font-size: 15px;
        width: 100%;
        margin-top: 5px;
    }

    .message-box-section textarea {
        width: 100%;
        padding: 12px;
        font-size: 15px;
        border-radius: 8px;
        border: 1px solid #ccc;
        resize: none;
    }

    .btn {
        background-color: white;
        color: black;
        padding: 10px 15px;
        border: 2px solid black;
        border-radius: 5px;
        cursor: pointer;
        font-size: 15px;
        transition: background-color 0.3s, color 0.3s;
    }

    .btn:hover {
        background-color: black;
        color: white;
    }

    #status-display {
        padding: 10px 15px;
        font-weight: bold;
        font-size: 16px;
        text-align: center;
        border-radius: 8px;
        margin-bottom: 10px;
        color: white;
    }

    .status-pending {
        background-color: #dc3545;
    }

    .status-dispatched,
    .status-in-transit {
        background-color: #ffc107;
        color: black;
    }

    .status-delivered,
    .status-already-pick-up {
        background-color: #28a745;
    }
</style>

<script>
    function updateStatus() {
        const selected = document.getElementById("status-select").value;
        const display = document.getElementById("status-display");

        display.className = '';
        display.classList.add('status-' + selected.replace(/\s+/g, '-').toLowerCase());
        display.innerHTML = `<span>${selected.replace('-', ' ').replace(/\b\w/g, c => c.toUpperCase())}</span>`;
    }

    document.addEventListener('DOMContentLoaded', () => {
        updateStatus();
        document.getElementById("status-select").addEventListener("change", updateStatus);
    });
</script>

@endsection
