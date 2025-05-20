@extends('base.base')

@section('content')

<div class="order-detail-admin">
    <h1 class="page-title" onclick="window.history.back()" style="cursor: pointer;">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#444" class="bi bi-arrow-left-short" viewBox="0 0 16 16" style="margin-right: 10px;">
            <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5A.5.5 0 0 1 12 8z"/>
        </svg>
        Order Detail #1232
    </h1>

    <div class="order-detail-container">
        <!-- LEFT -->
        <div class="order-left-container">
            <div class="order-card">
                <!-- Info Horizontal -->
                <div class="order-horizontal-info">
                    <div><strong>Name:</strong><br>Brooklyn Zoe</div>
                    <div><strong>Phone:</strong><br>0812 3456 7890</div>
                    <div><strong>Pickup/Shipping:</strong><br>Shipping</div>
                    <div><strong>Date:</strong><br>31 Jul 2020</div>
                </div>

                <!-- Delivery Address Box -->
                <div class="delivery-box">
                    <div class="delivery-box-header">
                        <span class="label">Delivery Address</span>
                        <a href="#" class="edit-link">Edit</a>
                    </div>
                    <div class="delivery-box-content">
                        <p><strong>Name:</strong> Brooklyn Zoe</p>
                        <p>Jl. Kenangan Indah No.45, Blok C3<br>Kelapa Gading, Jakarta Utara, DKI Jakarta 14240</p>
                        <p>Call: 0812 3456 7890</p>
                    </div>
                </div>

                <!-- Produk -->
                <h3>Product Information</h3>
                <div class="product-table">
                    <div class="product-table-header">
                        <div class="col-item">Item</div>
                        <div class="col-qty">Qty</div>
                        <div class="col-size">Size</div>
                        <div class="col-total">Total</div>
                    </div>

                    <div class="product-table-row">
                        <div class="col-item">
                            <div class="product-info">
                                <img src="{{ asset('images/products/1/NIKE air force 1 _07 men_s basketball shoes - white,1.webp') }}" alt="Nike">
                                <span>NIKE Air Force 1 '07 Men's Basketball Shoes - White</span>
                            </div>
                        </div>
                        <div class="col-qty">2</div>
                        <div class="col-size">42</div>
                        <div class="col-total">Rp 1.000.000</div>
                    </div>

                    <div class="product-table-row">
                        <div class="col-item">
                            <div class="product-info">
                                <img src="{{ asset('images/products/4/PUMA speedcat og unisex lifestyle shoes - red,1.webp') }}" alt="Puma">
                                <span>PUMA Speedcat OG Unisex Lifestyle Shoes - Red</span>
                            </div>
                        </div>
                        <div class="col-qty">1</div>
                        <div class="col-size">41</div>
                        <div class="col-total">Rp 1.300.000</div>
                    </div>
                </div>

                <!-- Ringkasan -->
                <div class="order-summary-admin">
                    <div class="summary-item-admin">
                        <span><strong>Subtotal:</strong></span>
                        <span>Rp 2.300.000</span>
                    </div>
                    <div class="summary-item-admin">
                        <span><strong>Shipping:</strong></span>
                        <span>Rp 20.000</span>
                    </div>
                    <div class="summary-item-admin total">
                        <span><strong>Total:</strong></span>
                        <span>Rp 2.320.000</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="order-right-container">
            <div class="status-notes-container">
                <h3>Update Order Status & Notes</h3>
                <div class="status-section">
                    <div id="status-display" class="status-pending">
                        <span>Pending</span>
                    </div>

                    <div class="status-update" style="margin-top: 10px;">
                        <label for="status-select" class="status-label"><strong>Update Status:</strong></label>
                        <select id="status-select" class="form-select">
                            <option value="pending" selected>Pending</option>
                            <option value="dispatched">Dispatched</option>
                            <option value="in-transit">In Transit</option>
                            <option value="delivered">Delivered</option>
                        </select>
                    </div>

                    <div class="message-box-section" style="margin-top: 15px;">
                        <label for="message-box"><strong>Admin Notes / Shipping Instructions:</strong></label>
                        <textarea id="message-box" rows="6" placeholder="Enter notes or special instructions for the shipment..."></textarea>
                    </div>

                    <button onclick="updateStatus()" class="btn" style="margin-top: 20px;">Update Status</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- STYLE -->
<style>
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

    .delivery-box .edit-link {
        color: #007bff;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
    }

    .delivery-box .edit-link:hover {
        text-decoration: underline;
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

    .status-delivered {
        background-color: #28a745;
    }

    /* Responsive styles */
    @media (max-width: 1024px) {
        .order-detail-container {
            flex-wrap: wrap;
            margin: 0 15px 30px;
        }
        .order-left-container,
        .order-right-container {
            flex: 1 1 100%;
            margin-bottom: 20px;
            padding: 15px;
        }
    }

    @media (max-width: 600px) {
        .page-title {
            font-size: 28px;
            margin: 20px 15px;
        }
        .order-detail-container {
            flex-direction: column;
            margin: 0 10px 20px;
        }
        .order-left-container,
        .order-right-container {
            padding: 10px;
        }
        .order-horizontal-info {
            font-size: 14px;
        }
        .product-table-header,
        .product-table-row {
            grid-template-columns: 1.8fr 1fr 1fr 1fr;
            font-size: 13px;
            padding: 10px 8px;
        }
        .form-select,
        .message-box-section textarea {
            font-size: 14px;
        }
        .btn {
            font-size: 14px;
            padding: 10px;
            width: 100%;
        }
    }
</style>

<script>
    function updateStatus() {
        const status = document.getElementById("status-select").value;
        const statusDisplay = document.getElementById("status-display");

        statusDisplay.innerHTML = status.charAt(0).toUpperCase() + status.slice(1).replace('-', ' ');
        statusDisplay.className = 'status-' + status;

        const notes = document.getElementById("message-box").value;
        console.log("Status updated to:", status);
        console.log("Notes:", notes);
    }

    window.addEventListener("DOMContentLoaded", () => {
        document.getElementById("status-select").addEventListener("change", updateStatus);
        updateStatus();
    });
</script>

@endsection
