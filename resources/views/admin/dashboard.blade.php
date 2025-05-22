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

  .dashboard-wrapper {
    max-width: 1200px;
    margin: auto;
    margin-top: 20px;
    display: flex;
    gap: 30px;
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

  .recent-movement {
    background: var(--color-primary);
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 3px 8px rgb(0 0 0 / 0.15);
    color: var(--color-accent);
  }
  .recent-movement-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 16px;
    align-items: center;
  }
  .recent-movement-header strong {
    font-weight: 600;
  }
  .recent-movement-header select,
  .recent-movement-header input {
    padding: 6px 10px;
    font-size: 14px;
    border-radius: 6px;
    border: none;
    outline: none;
    color: var(--color-accent);
    font-weight: 600;
  }
  .recent-movement-header select {
    background: var(--color-primary);
    margin-right: 12px;
  }
  .recent-movement-header input {
    background: var(--color-primary);
    width: 140px;
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
    flex: 1;
    background: var(--color-secondary);
    border-radius: 12px;
    padding: 20px;
    color: var(--color-text);
    box-shadow: 0 3px 8px rgba(0,0,0,0.15);
    max-height: 1245px;
    overflow-y: auto;
    border: none;
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
</style>
</head>
<body>

<div class="dashboard-wrapper">
  <!-- Dashboard Utama -->
  <div class="dashboard" role="main" aria-label="Analytics Dashboard">
    <div class="header">
      <h2>Admin Dashboard</h2>
    </div>

    <div class="metrics">
      <div class="card" tabindex="0" role="region" aria-label="Sales data">
        <div class="title"><span class="icon" aria-hidden="true">💰</span> Sales</div>
        <div class="value">2,382</div>
        <div class="change negative" aria-live="polite">-3.65% Since last week</div>
      </div>
      <div class="card" tabindex="0" role="region" aria-label="Earnings data">
        <div class="title"><span class="icon" aria-hidden="true">💵</span> Earnings</div>
        <div class="value">$21,300</div>
        <div class="change positive" aria-live="polite">6.85% Since last week</div>
      </div>
      <div class="card" tabindex="0" role="region" aria-label="Visitors data">
        <div class="title"><span class="icon" aria-hidden="true">👥</span> Visitors</div>
        <div class="value">14,212</div>
        <div class="change positive" aria-live="polite">5.25% Since last week</div>
      </div>
      <div class="card" tabindex="0" role="region" aria-label="Orders data">
        <div class="title"><span class="icon" aria-hidden="true">🛒</span> Orders</div>
        <div class="value">64</div>
        <div class="change negative" aria-live="polite">-2.25% Since last week</div>
      </div>
    </div>

    <div class="recent-movement" role="region" aria-label="Recent Movement Chart">
      <div class="recent-movement-header">
        <div><strong>Recent Movement</strong></div>
        <div>
          <select aria-label="Select Month">
            <option>Jan</option>
            <option>Feb</option>
            <option>Mar</option>
            <option>Apr</option>
            <option>May</option>
            <option>Jun</option>
            <option>Jul</option>
            <option>Aug</option>
            <option>Sep</option>
            <option>Oct</option>
            <option>Nov</option>
            <option>Dec</option>
          </select>
          <select aria-label="Search">
            <option>Sales</option>
            <option>Revenue</option>
          </select>
        </div>
      </div>
      <canvas id="movementChart" height="100"></canvas>
    </div>

    <!-- Top Products Section -->
    <div class="top-products" role="region" aria-label="Top 3 Products">
      <h3>Top 3 Best-Selling Products</h3>
      <ul class="product-list">
        <li>
          <div class="product-info">
            <img src="{{ asset('images/products/1/NIKE air force 1 _07 men_s basketball shoes - white,3.webp') }}"
                 alt="Nike Air Max"
                 class="product-img clickable"
                 onclick="showImageModal(this.src)">
            <span class="product-name">Nike Air Max</span>
          </div>
          <span class="product-sales">1,024 sold</span>
        </li>
        <li>
          <div class="product-info">
            <img src="{{ asset('images/products/1/NIKE air force 1 _07 men_s basketball shoes - white,1.webp') }}"
                 alt="Adidas Ultraboost"
                 class="product-img clickable"
                 onclick="showImageModal(this.src)">
            <span class="product-name">Adidas Ultraboost</span>
          </div>
          <span class="product-sales">967 sold</span>
        </li>
        <li>
          <div class="product-info">
            <img src="{{ asset('images/products/1/NIKE air force 1 _07 men_s basketball shoes - white,2.webp') }}"
                 alt="Ventela Public"
                 class="product-img clickable"
                 onclick="showImageModal(this.src)">
            <span class="product-name">Ventela Public</span>
          </div>
          <span class="product-sales">882 sold</span>
        </li>
      </ul>
    </div>
  </div>

  <!-- Sidebar stok barang -->
  <aside class="sidebar" role="region" aria-label="Stock Inventory">
    <div class="stock-header">Stock Inventory</div>
    <ul class="stock-list" tabindex="0">
      <li><span class="stock-name">Nike Air Max</span> <span class="stock-qty">154 pcs</span></li>
      <li><span class="stock-name">Adidas Ultraboost</span> <span class="stock-qty">89 pcs</span></li>
      <li><span class="stock-name">Ventela Public</span> <span class="stock-qty">67 pcs</span></li>
      <li><span class="stock-name">Puma Running</span> <span class="stock-qty">43 pcs</span></li>
      <li><span class="stock-name">Reebok Classic</span> <span class="low_stok">9 pcs</span></li>
      <li><span class="stock-name">New Balance 574</span> <span class="stock-qty">120 pcs</span></li>
      <li><span class="stock-name">Converse All Star</span> <span class="stock-qty">98 pcs</span></li>
      <li><span class="stock-name">Skechers Sport</span> <span class="stock-qty">54 pcs</span></li>
      <li><span class="stock-name">Asics Gel Kayano</span> <span class="stock-qty">40 pcs</span></li>
      <li><span class="stock-name">Under Armour Charged</span> <span class="stock-qty">76 pcs</span></li>
       <li><span class="stock-name">Nike Air Max</span> <span class="stock-qty">154 pcs</span></li>
      <li><span class="stock-name">Adidas Ultraboost</span> <span class="stock-qty">89 pcs</span></li>
      <li><span class="stock-name">Ventela Public</span> <span class="low_stok">10 pcs</span></li>
      <li><span class="stock-name">Puma Running</span> <span class="stock-qty">43 pcs</span></li>
      <li><span class="stock-name">Reebok Classic</span> <span class="stock-qty">78 pcs</span></li>
      <li><span class="stock-name">New Balance 574</span> <span class="stock-qty">120 pcs</span></li>
      <li><span class="stock-name">Converse All Star</span> <span class="stock-qty">98 pcs</span></li>
      <li><span class="stock-name">Skechers Sport</span> <span class="stock-qty">54 pcs</span></li>
      <li><span class="stock-name">Asics Gel Kayano</span> <span class="stock-qty">40 pcs</span></li>
      <li><span class="stock-name">Under Armour Charged</span> <span class="stock-qty">76 pcs</span></li>
       <li><span class="stock-name">Nike Air Max</span> <span class="stock-qty">154 pcs</span></li>
      <li><span class="stock-name">Adidas Ultraboost</span> <span class="stock-qty">89 pcs</span></li>
      <li><span class="stock-name">Ventela Public</span> <span class="stock-qty">67 pcs</span></li>
      <li><span class="stock-name">Puma Running</span> <span class="stock-qty">43 pcs</span></li>
      <li><span class="stock-name">Reebok Classic</span> <span class="stock-qty">78 pcs</span></li>
      <li><span class="stock-name">New Balance 574</span> <span class="stock-qty">120 pcs</span></li>
      <li><span class="stock-name">Converse All Star</span> <span class="stock-qty">98 pcs</span></li>
      <li><span class="stock-name">Skechers Sport</span> <span class="stock-qty">54 pcs</span></li>
      <li><span class="stock-name">Asics Gel Kayano</span> <span class="stock-qty">40 pcs</span></li>
      <li><span class="stock-name">Under Armour Charged</span> <span class="stock-qty">76 pcs</span></li>
    </ul>
  </aside>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('movementChart').getContext('2d');

  const movementChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      datasets: [{
        label: 'Movement',
        data: [2100, 1800, 2000, 2200, 1900, 2500, 2700, 3100, 3400, 3200, 3500, 3300],
        fill: true,
        backgroundColor: 'rgba(0, 0, 0, 0.1)',
        borderColor: 'rgba(0, 0, 0, 1)',
        borderWidth: 2,
        tension: 0.3,
        pointRadius: 4,
        pointBackgroundColor: 'rgba(0, 0, 0, 1)'
      }]
    },
    options: {
      maintainAspectRatio: true,
      aspectRatio: 2.5,
      scales: {
        y: {
          beginAtZero: false,
          min: 1000,
          max: 4000,
          ticks: {
            stepSize: 500,
            color: '#000000'
          },
          grid: {
            color: 'rgba(0, 0, 0, 0.1)'
          }
        },
        x: {
          ticks: {
            color: '#000000'
          },
          grid: {
            color: 'rgba(0, 0, 0, 0.05)'
          }
        }
      },
      plugins: {
        legend: { display: false }
      },
      responsive: true,
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
