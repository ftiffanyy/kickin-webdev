@extends('base.base')

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

@section('content')

@php
    use Illuminate\Support\Facades\Auth;

    $userId = session('user_id', Auth::id()); // ambil user id dari session atau Auth

    // Fungsi bantu untuk status ke persen progress bar (sesuaikan sendiri logika kamu)
    function statusToProgress($status) {
        $map = [
            'pending' => 10,
            'dispatched' => 50,
            'in transit' => 75,
            'delivered' => 100,
            'already pick up' => 100,
        ];
        $key = strtolower($status);
        return $map[$key] ?? 0;
    }
@endphp

<style>
    /* ...style sama seperti yang kamu kasih sebelumnya... */
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
        background-color: #4CAF50;
        width: 0;
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
            margin: 0 0 15px 0;
        }

        .order-details {
            margin-top: 15px;
            text-align: center;
        }
    }
</style>

<div class="my-orders">
    <h2><i class="fas fa-box"></i> My Orders</h2>

    @forelse($orders as $order)
        @php
            $firstDetail = $order->orderDetails->first();
            $product = $firstDetail ? $firstDetail->variant->product : null;
            $mainImage = $product && $product->images->isNotEmpty()
                ? $product->images->firstWhere('main', 1) ?? $product->images->first()
                : null;
            $progressWidth = statusToProgress($order->shipping_status);
            $totalQty = $order->orderDetails->sum('qty');
        @endphp

        <div class="order-item">
            @if($mainImage)
                <img src="{{ asset('images/' . $mainImage->url) }}" alt="{{ $product->name }}" class="order-image">
            @else
                <div class="order-image" style="display:flex;align-items:center;justify-content:center;background:#ddd;">No Image</div>
            @endif

            <div class="order-status">
                <p class="order-item-header">ORDER STATUS: {{ strtoupper($order->shipping_status) }}</p>
                <p>Total item(s) : {{ $totalQty }} </p>
                <p>
                    @if(in_array(strtolower($order->shipping_status), ['delivered', 'already pick up']))
                        Delivered on {{ \Carbon\Carbon::parse($order->date)->format('d M, Y') }}
                    @else
                        Estimated delivery: {{ \Carbon\Carbon::parse($order->date)->addDays(4)->format('d M, Y') }}
                    @endif
                </p>
                <div class="progress-bar">
                    <span style="width: {{ $progressWidth }}%"></span>
                </div>
            </div>

            <div class="order-details">
                <p>ORDER NO. : {{ $order->id }}</p>
                <p>ORDER DATE: {{ \Carbon\Carbon::parse($order->date)->format('d M, Y') }}</p>
                <form action="{{ route('order_details', ['id' => $order->id]) }}" method="GET">
                    <button type="submit" class="view-order">DETAIL ORDER</button>
                </form>
                {{-- <button class="cancel-order">CANCEL ORDER</button> --}}
            </div>
        </div>
    @empty
        <p>You have no orders yet.</p>
    @endforelse
</div>

@endsection
