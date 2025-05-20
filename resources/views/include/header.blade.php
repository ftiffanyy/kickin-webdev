<style>
  body {
    margin: 0;
    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    font-size: large;
  }
  header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 20px;
    background-color: #f8f9fa;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    animation: fadeIn 0.5s ease-out;
    flex-wrap: nowrap; /* default */
  }
  /* Logo */
  .logo img {
    height: 50px;
    cursor: pointer;
    transition: transform 0.3s ease-in-out;
  }
  .logo img:hover {
    transform: scale(1.1);
  }

  /* Nav Links */
  .nav-links {
    display: flex;
    gap: 40px;
    margin-left: 130px; /* Adjust untuk tengah */
  }
  .nav-links a {
    text-decoration: none;
    color: #181b1e;
    font-weight: 500;
    position: relative;
    display: inline-block;
    transition: color 0.3s ease;
  }
  .nav-links a:hover {
    color: #a5a9ae;
  }
  .nav-links a::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    background-color: #a5a9ae;
    bottom: 0;
    left: 0;
    transition: width 0.3s ease;
  }
  .nav-links a:hover::after {
    width: 100%;
  }

  /* Header right (search, icons, login) */
  .header-right {
    display: flex;
    align-items: center;
    gap: 10px;
  }
 
 
 
  .cart-icon a,
  .wishlist a {
    font-size: 30px;
    color: #181b1e;
    margin-right: 10px;
    cursor: pointer;
    text-decoration: none;
    transition: color 0.3s ease;
  }
  .wishlist a {
    color: #181b1e;
  }
  .cart-icon a:hover,
  .wishlist a:hover {
    color: #a5a9ae;
  }

  .login-btn button {
    background-color: #a5a9ae;
    color: #181b1e;
    padding: 8px 15px;
    border: none;
    border-radius: 20px;
    cursor: pointer;
    font-weight: bold;
    text-transform: uppercase;
    font-size: 14px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .login-btn button:hover {
    background-color: #5f6266;
    transform: scale(1.2);
    box-shadow: 0 0 20px #5f6266;
    color: #fff;
  }

  /* Animasi FadeIn */
  @keyframes fadeIn {
    0% { opacity: 0; }
    100% { opacity: 1; }
  }

  /* Responsive */
  @media (max-width: 768px) {
    header {
      flex-wrap: wrap;
      padding: 10px;
    }
    .logo {
      flex: 1 1 100%;
      text-align: center;
      margin-bottom: 10px;
    }
    .logo img {
      height: 40px;
    }
    .nav-links {
      flex: 1 1 100%;
      justify-content: center;
      gap: 20px;
      margin-left: 0;
      margin-bottom: 10px;
    }
    .header-right {
      flex: 1 1 100%;
      justify-content: center;
      gap: 15px;
    }
    .cart-icon a,
    .wishlist a {
      font-size: 26px;
    }
  }

  /* Profile Dropdown */
  .profile-dropdown {
    position: relative;
    display: inline-block;
  }

  .profile-icon {
    font-size: 26px;
    cursor: pointer;
    padding: 2px;
    color: #181b1e;
    transition: background-color 0.3s;
  }

  .profile-icon:hover {

    color: #a5a9ae;
  }

  .dropdown-menu {
    display: none;
    position: absolute;
    right: 0;
    top: 110%;
    background-color: #fff;
    min-width: 150px;
    padding: 10px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    border-radius: 8px;
    z-index: 99;
  }

  .dropdown-menu.show {
    display: block;
  }

  .dropdown-menu p {
    margin: 0 0 10px;
    font-weight: bold;
    color: #181b1e;
  }

  .dropdown-menu button {
    background-color: #a5a9ae;
    color: #181b1e;
    border: none;
    padding: 6px 12px;
    width: 100%;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    transition: background-color 0.2s;
  }

  .dropdown-menu button:hover {
    background-color: #5f6266;
  }
</style>

<header>
  <div class="logo">
    <img src="{{ asset('images/Kickin.jpg') }}" alt="Logo" />
  </div>

  @php $role = session('user_role', 'Guest'); @endphp

  <div class="nav-links">
    <a href="{{ route('dashboard') }}">DASHBOARD</a>
    @if ($role !== 'Admin')
        <a href="{{ route('product.show') }}">SHOP HERE</a>
    @else
        <a href="{{ route('product.show') }}">PRODUCT</a>
    @endif
    <a href="{{ route('order_customer') }}">ORDERS</a>
    @if ($role !== 'Admin')
      <a href="{{ route('about') }}">ABOUT US</a>
    @endif
  </div>

  <div class="header-right">
    <div class="cart-icon">
      <a href="{{ route('view_cart') }}">
        <i class="fas fa-cart-shopping"></i>
      </a>
    </div>
    <div class="wishlist">
      <a href="{{ route('wishlist') }}">
        <i class="fas fa-heart"></i>
      </a>
    </div>

    {{-- Profile Dropdown --}}
    <div class="profile-dropdown" onclick="toggleDropdown()">
      <div class="profile-icon">
        <i class="fas fa-user"></i>
      </div>
      <div class="dropdown-menu" id="dropdownMenu">
        <p>{{ $role }}</p>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit">Log Out</button>
        </form>
      </div>
    </div>
  </div>
</header>

<script>
  function toggleDropdown() {
    const dropdown = document.getElementById('dropdownMenu');
    dropdown.classList.toggle('show');
  }

  // Tutup jika klik di luar dropdown
  document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('dropdownMenu');
    const profile = document.querySelector('.profile-dropdown');

    if (!profile.contains(e.target)) {
      dropdown.classList.remove('show');
    }
  });
</script>
