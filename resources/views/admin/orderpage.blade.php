@extends('base.base')

@section('content')
<div class="order-view">
    <h1 class="page-title">
        <i class="bi bi-check-circle" style="color: #6c757d; margin-right: 10px;"></i> 
        Order Management 
        <i class="bi bi-box" style="color: #6c757d; margin-left: 10px;"></i>
    </h1>
    <div class="order-table">
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
                        <td>#{{ str_pad($order->invoice_number, 4, '0', STR_PAD_LEFT) }}</td>
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

    /* Responsive Tablet */
    @media (max-width: 1024px) {
        .page-title {
            font-size: 32px;
        }
        .order-table {
            width: 95%;
            padding: 15px;
        }
        .rounded-table {
            min-width: 600px;
        }
        .order-table th, .order-table td {
            padding: 10px 12px;
            font-size: 13px;
        }
        .btn {
            padding: 6px 10px;
            font-size: 11px;
        }
    }

    /* Responsive Mobile */
    @media (max-width: 600px) {
        .page-title {
            font-size: 18px;
            white-space: nowrap;
        }
        .order-table {
            width: 100%;
            padding: 10px;
        }
        .rounded-table {
            min-width: 500px;
        }
        .order-table th, .order-table td {
            padding: 8px 10px;
            font-size: 12px;
        }
        .btn {
            padding: 5px 8px;
            font-size: 10px;
        }
    }
</style>
@endsection
