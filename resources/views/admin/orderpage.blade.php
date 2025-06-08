@extends('base.base')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3 shadow-lg z-3" role="alert" style="min-width: 300px;">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@section('content')
<div class="order-view">
    <h1 class="page-title">
        <i class="bi bi-check-circle" style="color: #6c757d; margin-right: 10px;"></i> 
        Order Management 
        <i class="bi bi-box" style="color: #6c757d; margin-left: 10px;"></i>
    </h1>
    <div class="order-table">
        <!-- Filter Form -->
        <form action="{{ route('order_management') }}" method="GET" class="mb-3">
            <div class="filter-container">
                <div class="filter-item">
                    <input type="text" name="order_id" placeholder="Search by Order ID" value="{{ request('order_id') }}">
                </div>
                <div class="filter-item">
                    <input type="text" name="customer_name" placeholder="Search by Customer Name" value="{{ request('customer_name') }}">
                </div>
                <div class="filter-item">
                    <input type="text" name="address" placeholder="Search by Address" value="{{ request('address') }}">
                </div>
                <div class="filter-item">
                    <input type="date" name="date" value="{{ request('date') }}">
                </div>
                <div class="filter-item">
                    <select name="status">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="dispatched" {{ request('status') == 'dispatched' ? 'selected' : '' }}>Dispatched</option>
                        <option value="in-transit" {{ request('status') == 'in-transit' ? 'selected' : '' }}>In Transit</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="already-pick-up" {{ request('status') == 'already-pick-up' ? 'selected' : '' }}>Already Picked Up</option>
                    </select>
                </div>
                <div class="filter-item">
                    <button type="submit" class="btn">Apply Filters</button>
                    <a href="{{ route('orderadmin') }}" class="btn clear-filters">Clear</a>
                </div>
            </div>
        </form>

        <table class="rounded-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Address</th>
                    <th>Date</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $order->user->name ?? 'Unknown' }}</td>
                        <td>
                            @if($order->status === 'Pick Up')
                                Pick up at {{ $order->shipping_address }}
                            @else
                                {{ $order->shipping_address }}
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($order->date)->format('d M Y, h:i A') }}</td>
                        <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td>
                            <span class="status {{ strtolower(str_replace(' ', '-', $order->shipping_status)) }}">
                                {{ $order->shipping_status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('order_details_admin', ['orderid' => $order->id]) }}" class="btn detail">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
    /* Styling for the filter section */
    .filter-container {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
    }

    .filter-item {
        flex: 1;
    }

    .filter-item input, .filter-item select {
        width: 100%;
        padding: 8px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .filter-item button {
        background-color: #181B1E;
        color: white;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
        border: none;
    }

    .filter-item button:hover {
        background-color: #333;
    }

    .filter-item .clear-filters {
        background-color: #181B1E; /* Same background as Apply Filters */
        color: white; /* Text color to white */
        padding: 10px 15px; /* Same padding as the Apply Filters button */
        border-radius: 5px; /* Same border radius */
        text-decoration: none; /* Remove underline */
        font-size: 14px; /* Same font size */
        margin-left: 10px; /* Add some space between buttons */
        cursor: pointer;
        display: inline-block;
        transition: background-color 0.3s, color 0.3s;
    }

    .filter-item .clear-filters:hover {
        background-color: #333; /* Darker background on hover, same as Apply Filters */
        color: #fff; /* Ensure text is white on hover */
    }


    /* The rest of the table styling remains the same */
    body {
        background-color: #F8F9FA;
        font-family: 'Fredoka', sans-serif;
        color: #181B1E;
    }

    .page-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 40px;
        color: #181B1E;
        text-align: center;
        margin-bottom: 20px;
        position: relative;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;

        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .page-title i {
        font-size: 42px;
        margin: 0 10px;
    }

    .order-table {
        width: 90%;
        margin: 0 auto;
        padding: 20px;
        background-color: #FFFFFF;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow-x: auto;
    }

    .rounded-table {
        width: 100%;
        border-collapse: collapse;
        color: #181B1E;
        border-radius: 8px;
        min-width: 700px;
    }

    .order-table th, .order-table td {
        padding: 12px 20px;
        text-align: left;
        font-size: 14px;
        white-space: nowrap;
    }

    .order-table th {
        background-color: #D6D9DC;
        color: #181B1E;
        font-weight: bold;
        border-radius: 8px 8px 0 0;
    }

    .order-table tr:nth-child(even) {
        background-color: #FFFFFF;
    }

    .order-table tr:hover {
        background-color: #F1F1F1;
    }

    .status {
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: bold;
        background-color: #FFFFFF;
        color: #181B1E;
        display: inline-block;
    }

    .status.pending {
        border: 2px solid red;
    }

    .status.dispatched {
        border: 2px solid yellow;
    }

    .status.in-transit {
        border: 2px solid yellow;
    }

    .status.delivered {
        border: 2px solid green;
    }

    .status.already-pick-up {
        border: 2px solid green;
    }

    .btn {
        background-color: #fff;
        color: #181B1E;
        border: 2px solid #181B1E;
        padding: 8px 12px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 12px;
        white-space: nowrap;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.3s, color 0.3s;
    }

    .btn:hover {
        background-color: #181B1E;
        color: #fff;
    }
</style>
@endsection
