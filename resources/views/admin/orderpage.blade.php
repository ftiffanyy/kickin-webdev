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
                <tr>
                    <td>#1232</td>
                    <td>Brooklyn Zoe</td>
                    <td>Pick up at Pakuwon Mall Surabaya</td>
                    <td>31 Jul 2020</td>
                    <td>Rp 2.300.000</td>
                    <td><span class="status pending">Pending</span></td>
                    <td><a href="{{ route('order_details_admin', ['orderid' => 1]) }}" class="btn detail">Detail</a></td>
                </tr>
                <tr>
                    <td>#1233</td>
                    <td>John McCormick</td>
                    <td>Jalan Merdeka No. 45, Bandung, Indonesia</td>
                    <td>01 Aug 2020</td>
                    <td>Rp 3.800.000</td>
                    <td><span class="status dispatched">Dispatched</span></td>
                    <td><a href="{{ route('order_details_admin', ['orderid' => 2]) }}" class="btn detail">Detail</a></td>
                </tr>
                <tr>
                    <td>#1234</td>
                    <td>James Witwicky</td>
                    <td>Jalan Pahlawan No. 12, Surabaya, Indonesia</td>
                    <td>26 March 2020, 12:42 AM</td>
                    <td>Rp 2.500.000</td>
                    <td><span class="status dispatched">Dispatched</span></td>
                    <td><a href="{{ route('order_details_admin', ['orderid' => 2]) }}" class="btn detail">Detail</a></td>
                </tr>
                <tr>
                    <td>#1235</td>
                    <td>David Horison</td>
                    <td>Jalan Tugu No. 99, Yogyakarta, Indonesia</td>
                    <td>26 March 2020, 02:42 PM</td>
                    <td>Rp 350.000</td>
                    <td><span class="status delivered">Delivered</span></td>
                    <td><a href="{{ route('order_details_admin', ['orderid' => 2]) }}" class="btn detail">Detail</a></td>
                </tr>
                <tr>
                    <td>#1236</td>
                    <td>Emilia Johansson</td>
                    <td>Jalan Sunter No. 50, Jakarta Utara, Indonesia</td>
                    <td>26 March 2020, 02:12 AM</td>
                    <td>Rp 4.000.000</td>
                    <td><span class="status dispatched">Dispatched</span></td>
                    <td><a href="{{ route('order_details_admin', ['orderid' => 2]) }}" class="btn detail">Detail</a></td>
                </tr>
                <tr>
                    <td>#1237</td>
                    <td>Rendy Greenlee</td>
                    <td>Jalan Soekarno Hatta No. 80, Makassar, Indonesia</td>
                    <td>26 March 2020, 12:42 AM</td>
                    <td>Rp 700.000</td>
                    <td><span class="status dispatched">Dispatched</span></td>
                    <td><a href="{{ route('order_details_admin', ['orderid' => 2]) }}" class="btn detail">Detail</a></td>
                </tr>
                <tr>
                    <td>#1238</td>
                    <td>Jessica Wong</td>
                    <td>Pick up at Pakuwon Mall Surabaya</td>
                    <td>26 March 2020, 12:42 AM</td>
                    <td>Rp 3.600.000</td>
                    <td><span class="status pending">Pending</span></td>
                    <td><a href="{{ route('order_details_admin', ['orderid' => 1]) }}" class="btn detail">Detail</a></td>
                </tr>
                <tr>
                    <td>#1239</td>
                    <td>Veronica</td>
                    <td>Jalan Gajah Mada No. 100, Surabaya, Indonesia</td>
                    <td>26 March 2020, 12:42 AM</td>
                    <td>Rp 1.100.000</td>
                    <td><span class="status dispatched">Dispatched</span></td>
                    <td><a href="{{ route('order_details_admin', ['orderid' => 2]) }}" class="btn detail">Detail</a></td>
                </tr>
                <tr>
                    <td>#1240</td>
                    <td>Samantha Bake</td>
                    <td>Jalan Jendral Sudirman No. 88, Semarang, Indonesia</td>
                    <td>26 March 2020, 12:42 AM</td>
                    <td>Rp 350.000</td>
                    <td><span class="status dispatched">Dispatched</span></td>
                    <td><a href="{{ route('order_details_admin', ['orderid' => 2]) }}" class="btn detail">Detail</a></td>
                </tr>
                <tr>
                    <td>#1241</td>
                    <td>Olivia Shine</td>
                    <td>Pick up at Pakuwon Mall Surabaya</td>
                    <td>26 March 2020, 12:42 AM</td>
                    <td>Rp 1.200.000</td>
                    <td><span class="status pending">Pending</span></td>
                    <td><a href="{{ route('order_details_admin', ['orderid' => 1]) }}" class="btn detail">Detail</a></td>
                </tr>
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
