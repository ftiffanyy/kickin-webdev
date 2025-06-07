@extends('base.base')

@section('content')
<style>
  /* --- Style utama --- */
  :root {
    --color-primary: #fff;
    --color-secondary: #fff;
    --color-accent: #5a1a1a;
    --color-text: #000;
  }

  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: var(--color-primary);
    margin: 20px;
    margin-top: 40px;
    color: var(--color-text);
  }

  /* rumah utama */
  .rumah-utama {
    display: flex;
    max-width: 100%;
  }

  /* div 1 */
  .dashboard-wrapper {
    flex: 3;
    margin: auto;
    margin-top: 20px;
    display: flex;
    gap: 30px;
  }

  /* div 2 */
  .dashboard-wrapper-kanan {
    flex: 1;
    
  }

  .dashboard {
    flex: 3;
    background: var(--color-secondary);
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 5px 15px rgb(0 0 0 / 0.15);
    margin-bottom: 20px;
    color: var(--color-text);
  }

  .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
  }
  .header h2 {
    font-weight: 600;
    font-size: 24px;
    color: var(--color-text);
  }
  .header .buttons {
    display: flex;
    gap: 12px;
  }
  button {
    background-color: var(--color-primary);
    border: none;
    color: var(--color-accent);
    padding: 8px 16px;
    font-weight: 600;
    border-radius: 4px;
    cursor: pointer;
    transition: transform 0.15s ease, box-shadow 0.15s ease;
  }
  button:hover {
    transform: scale(1.05);
    box-shadow: 0 3px 8px rgba(0,0,0,0.3);
  }
 
  .metrics {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    margin-bottom: 30px;
  }
  .card {
    background: var(--color-primary);
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 3px 8px rgb(0 0 0 / 0.15);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    color: var(--color-accent);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .card:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.3);
  }
  .card .title {
    font-weight: 600;
    font-size: 14px;
    color: var(--color-accent);
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .card .value {
    font-size: 28px;
    font-weight: 700;
    color: var(--color-accent);
  }
  .card .change {
    font-size: 13px;
    margin-top: 8px;
    display: inline-block;
    font-weight: 600;
    border-radius: 12px;
    padding: 3px 8px;
  }
  .change.positive {
    background-color: #a8d5a2;
    color: #1e3d16;
  }
  .change.negative {
    background-color: #e8a3a1;
    color: #5a1a1a;
  }

  .icon {
    font-size: 20px;
    background: var(--color-secondary);
    border-radius: 50%;
    padding: 6px 8px;
    color: var(--color-text);
  }


  .top-products {
    background: var(--color-primary);
    margin-top: 30px;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
    color: var(--color-accent);
  }

  .top-products h3 {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 15px;
    color: var(--color-accent);
  }

  .product-list {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .product-list li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--color-secondary);
    padding: 12px 16px;
    margin-bottom: 10px;
    border-radius: 8px;
    font-weight: 500;
    color: var(--color-text);
  }

  .product-info {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .product-img {
    width: 100px;
    height: auto;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid var(--color-secondary);
  }

  .product-name {
    font-size: 24px;
    color: var(--color-text);
  }

  .product-sales {
    font-size: 24px;
    color: var(--color-text);
  }

  .clickable {
    cursor: pointer;
    transition: transform 0.2s ease;
  }

  .clickable:hover {
    transform: scale(1.05);
  }

  .modal {
    display: none;
    position: fixed;
    z-index: 999;
    padding-top: 60px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.8);
  }

  .modal-content {
    margin: auto;
    display: block;
    max-width: 80vw;
    max-height: 80vh;
    object-fit: contain;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(255,255,255,0.3);
    background-color: #fff;
  }

  .close {
    position: absolute;
    top: 30px;
    right: 40px;
    color: var(--color-primary);
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.2s;
  }

  .close:hover {
    color: var(--color-secondary);
  }

  .sidebar {
    /* margin-top: 20px; */
    flex: 0 0 300px; /* Menentukan lebar sidebar tetap, misalnya 300px */
    background: var(--color-secondary);
    border-radius: 12px;
    padding: 20px;
    color: var(--color-text);
    box-shadow: 0 3px 8px rgba(0,0,0,0.15);
    max-height: 100vh; /* Batasi tinggi maksimum sesuai tinggi layar */
    overflow-y: auto; /* Scroll jika kontennya melebihi tinggi */
    border: none;
    position: sticky; /* Biar tetap terlihat saat scroll */
    top: 20px;
    margin-bottom: 20px;
}
  .stock-header {
    font-weight: 600;
    font-size: 20px;
    margin-bottom: 16px;
    border-bottom: 1px solid var(--color-accent);
    padding-bottom: 6px;
    color: var(--color-accent);
  }

  .stock-list {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .stock-list li {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid rgba(0,0,0,0.1);
    font-size: 16px;
    color: var(--color-text);
  }

  .stock-name {
    font-weight: 600;
    color: var(--color-text);
  }

  .low_stok {
    background: #e74c3c;
    border-radius: 12px;
    padding: 3px 10px;
    font-weight: 700;
    color: var(--color-primary);
  }

  .stock-qty {
    background: var(--color-secondary);
    border-radius: 12px;
    padding: 3px 10px;
    font-weight: 700;
    color: var(--color-text);
  }

  /* --- Responsiveness --- */

  /* Tablet */
  @media (max-width: 1024px) {
    .dashboard-wrapper {
      flex-direction: column;
      max-width: 900px;
    }
    .sidebar {
      max-height: none;
      margin-top: 30px;
    }
  }

  /* Tablet kecil dan HP */
  @media (max-width: 768px) {
    .dashboard-wrapper {
      flex-direction: column;
      padding: 20px;
    }
    .dashboard, .sidebar {
      width: 100%;
      max-width: 100%;
      margin: 0 0 30px 0;
    }

    .metrics {
      grid-template-columns: repeat(2, 1fr);
    }

    .card .value {
      font-size: 24px;
    }

    .card .title {
      font-size: 12px;
    }

    .recent-movement-header select,
    .recent-movement-header input {
      width: 100px;
      font-size: 12px;
    }

    .recent-movement-header {
      flex-direction: column;
      gap: 10px;
    }

    .recent-movement-header div:last-child {
      display: flex;
      gap: 10px;
    }

    .top-products h3 {
      font-size: 16px;
    }

    .product-list li {
      flex-direction: column;
      align-items: flex-start;
      gap: 6px;
    }

    .product-name, .product-sales {
      font-size: 16px;
    }

    .product-img {
      width: 80px;
    }

    .stock-list li {
      font-size: 14px;
    }
  }

  /* HP kecil */
  @media (max-width: 480px) {
    .metrics {
      grid-template-columns: 1fr;
    }

    .card {
      padding: 15px;
    }

    .card .value {
      font-size: 20px;
    }

    .dashboard-wrapper {
      padding: 10px;
    }

    .product-name, .product-sales {
      font-size: 14px;
    }

    .product-img {
      width: 60px;
    }

    .stock-list li {
      font-size: 12px;
    }
  }


  /* ini baru */

  .sidebar .stock-list li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    font-size: 16px;
    color: var(--color-text);
    white-space: normal; /* Allow text to wrap to the next line */
    word-wrap: break-word; /* Break long words */
    overflow-wrap: break-word; /* Ensure long words break */
}

    .sidebar .stock-list li span:first-child {
    flex: 1; /* Allow product name to take available space */
    margin-right: 10px; /* Optional, for spacing between name and stock */
      }
  
    .chart-container {
        background-color: #fff;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        margin-top: 24px;
    }

     .filter-container {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        margin-bottom: 16px;
        gap: 8px;
        border-radius: 8px;
    }

    .year-dropdown {
        padding: 8px 16px;
        border-radius: 12px;
        border: 1px solid #ccc;
        background-color: #f9f9f9;
        font-size: 14px;
    }

    .btn-filter {
        padding: 8px 16px;
        border-radius: 12px;
        background-color: #ccc;
        color: white;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .filter-teks {
      margin-right: 5px;
      font-size: 28px;
    }

    /* .btn-filter:hover {
        background-color: #f9f9f9;
        color :#ccc;
    } */
    

</style>
</head>
<body>

<div class="rumah-utama">

<div class="dashboard-wrapper">

  <!-- Dashboard Utama -->
  <div class="dashboard" role="main" aria-label="Analytics Dashboard">
      <div class="header">
      <h2>Admin Dashboard</h2>
      </div>

    <div class="metrics">
    <div class="card" tabindex="0" role="region" aria-label="Sales data">
        <div class="title"><span class="icon" aria-hidden="true">💰</span> Sales</div>
        <div class="value">{{ $totalOrder }}</div>
        <div class="change negative" aria-live="polite">-3.65% Since last week</div>
    </div>
    <div class="card" tabindex="0" role="region" aria-label="Earnings data">
        <div class="title"><span class="icon" aria-hidden="true">💵</span> Earnings</div>
        <div class="value">Rp {{ number_format($TotalEarnings) }}</div>
        <div class="change positive" aria-live="polite">6.85% Since last week</div>
    </div>
    <div class="card" tabindex="0" role="region" aria-label="Visitors data">
        <div class="title"><span class="icon" aria-hidden="true">👥</span> User</div>
        <div class="value">{{ $totalActiveUsers }}</div>
        <div class="change positive" aria-live="polite">5.25% Since last week</div>
    </div>
    <div class="card" tabindex="0" role="region" aria-label="Orders data">
        <div class="title"><span class="icon" aria-hidden="true">🛒</span> Orders</div>
        <div class="value">{{ $totalQtySold }}</div>
        <div class="change negative" aria-live="polite">-2.25% Since last week</div>
    </div>
</div>


<div class="chart-container">
  <div><h3>Recent Movement</h1></div>
    <div class="filter-container">
        <form method="GET" action="{{ route('dashboard') }}">
    <label for="year" class="filter-teks">Filter Tahun</label>
    <select name="year" onchange="this.form.submit()" class="btn-filter">
        @foreach ($availableYears as $year)
            <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                {{ $year }}
            </option>
        @endforeach
    </select>
</form>

    </div>

    <canvas id="salesChart" width="400" height="200"></canvas>
</div>


<canvas id="salesChart" height="100"></canvas>

    <!-- Top Products Section -->
    <div class="top-products" role="region" aria-label="Top 3 Products">
        <h2>Top 3 Best-Selling Products</h2>
        <ul class="product-list">
          @foreach($topProducts as $index => $product)
            <li>
              <div class="product-info">
                <img src="{{ asset('images/' . $product->image_url) }}" alt="{{ $product->name }}" class="product-img clickable" onclick="showImageModal(this.src)">
                <span class="product-name" style="text-transform: uppercase;">{{ $product->name }}</span>
                
              </div>
              <span class="product-sales">{{ number_format($product->sold) }} sold</span>
            </li>
          @endforeach
        </ul>
      </div>

</div>

<div class="dashboard-wrapper-kanan">
    <!-- Sidebar stok barang -->
      <aside class="sidebar" role="region" aria-label="Stock Inventory">
        <div class="stock-header">Stock Inventory</div>
        <ul class="stock-list" tabindex="0">
          @foreach($inventory as $item)
                  <li>
                    <span style="text-transform: uppercase;">{{ $item->product_name }}</span>
                    @if($item->total_stock < 10)
                        <span style="color: white; background-color: red; padding: 2px 8px; border-radius: 10px;">
                            {{ $item->total_stock }} pcs
                        </span>
                    @else
                        <span>{{ $item->total_stock }} pcs</span>
                    @endif
                </li>
            @endforeach
        </ul>
      </aside>
</div>
</div>



<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const salesChartCtx = document.getElementById('salesChart').getContext('2d');

    const salesChart = new Chart(salesChartCtx, {
        type: 'line',
        data: {
            labels: [
                'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
            ],
            datasets: [
                {
                    label: 'Total Revenue',
                    data: @json($monthlyRevenue),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.3
                },
                {
                    label: 'Total Qty Sold',
                    data: @json($monthlyQty),
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<!-- Modal for zoom image -->
<div id="imgModal" class="modal" onclick="closeImageModal()">
  <span class="close">&times;</span>
  <img class="modal-content" id="modalImage">
</div>

<script>
  // Modal function
  function showImageModal(src) {
    const modal = document.getElementById("imgModal");
    const modalImg = document.getElementById("modalImage");
    modal.style.display = "block";
    modalImg.src = src;
  }

  function closeImageModal() {
    document.getElementById("imgModal").style.display = "none";
  }
</script>

</body>

@endsection
