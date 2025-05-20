<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Auth Page</title>

  <!-- Load Google Fonts for Bebas Neue and Fredoka -->
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Fredoka:wght@400;500&display=swap" rel="stylesheet">

  <!-- Load Font Awesome for the eye icon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <style>
    :root {
      --dark: #181B1E;
      --dim: #5F6266;
      --cadet: #A5A9AE;
      --silver: #CFD1D4;
      --seasalt: #F8F9FA;
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Fredoka', sans-serif; /* Small text font */
      background-color: var(--seasalt);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background: linear-gradient(550deg, #F8F9FA, #181B1E);
    }

    .container {
      width: 800px;
      height: 500px;
      position: relative;
      overflow: hidden;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      background-color: #fff;
      display: flex;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .panel-container {
      display: flex;
      width: 100%;
      height: 100%;
      transition: transform 0.6s ease-in-out;
    }

    .form-panel {
      width: 50%;
      padding: 40px;
      background-color: var(--seasalt);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: flex-start;
      opacity: 0;
      transform: translateX(100%);
      transition: transform 0.6s ease-in-out, opacity 0.6s ease-in-out;
    }

    /* Active states */
    .container.active #loginPanel {
      transform: translateX(-10%);
      opacity: 1;
      pointer-events: auto;
    }

    .container.active #registerPanel {
      transform: translateX(0);
      opacity: 1;
      pointer-events: auto;
    }

    .container:not(.active) #loginPanel {
      transform: translateX(0);
      opacity: 1;
      pointer-events: auto;
    }

    .container:not(.active) #registerPanel {
      transform: translateX(100%);
      opacity: 0;
      pointer-events: none;
    }

    /* Apply Bebas Neue for large words (headings, buttons) */
    .form-panel h2 {
      font-family: 'Bebas Neue', sans-serif; /* Big words */
      font-size: 32px;
      margin-bottom: 20px;
    }

    .form-panel form {
      width: 100%;
      max-width: 300px;
      display: flex;
      flex-direction: column;
    }

    input, button {
      width: 100%;
      padding: 12px;
      margin: 8px 0;
      border: none;
      background: var(--silver);
      border-radius: 5px;
      font-family: 'Fredoka', sans-serif; /* Small text font */
      font-size: 16px;
    }

    button {
      background-color: var(--dark);
      color: white;
      cursor: pointer;
      transition: 0.3s;
      font-family: 'Bebas Neue', sans-serif; /* For button text */
      font-size: 18px;
    }

    button:hover {
      background-color: var(--dim);
    }

    .switch {
      background: linear-gradient(45deg, #e0e0e0, #c0c0c0);
      color: #000;
      cursor: pointer;
      border: none;
      margin-top: 20px;
      padding: 12px;
      border-radius: 5px;
      width: 200px;
      text-align: center;
      transition: all 0.3s ease;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .switch:hover {
      background: linear-gradient(45deg, #c0c0c0, #e0e0e0);
      transform: translateY(-2px);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }

    .switch:active {
      transform: translateY(1px);
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .forgot-password {
      text-align: right;
      font-size: 0.8em;
      margin-top: -5px;
      margin-bottom: 10px;
      color: var(--dim);
      text-decoration: none;
      cursor: pointer;
    }

    .forgot-password:hover {
      text-decoration: underline;
    }

    .side-panel {
      position: absolute;
      top: 0;
      right: 0;
      width: 50%;
      height: 100%;
      background-image: url('{{ asset('images/sepatu.png') }}');
      background-size: cover;
      background-position: center;
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      transition: transform 0.4s ease-in-out;
      padding: 20px;
      text-align: center;
      z-index: 1;
    }

    .logo {
      width: 150px;
      height: 150px;
      object-fit: cover;
      border-radius: 50%;
    }

    .container.active .side-panel {
      transform: translateX(-100%);
    }

    /* Eye Icon for Show Password */
    .eye-icon {
      position: absolute;
      right: 8px;
      top: 23px;
      cursor: pointer;
      font-size: 15px;
    }

    .eye-icon-wrapper {
      position: relative;
      width: 100%;
    }

    /* Ikon mata yang telah diklik */
    .eye-icon.clicked {
      color: red; /* Warna untuk ikon setelah diklik */
    }

    /* Apply Bebas Neue font to the side panel title */
    #sideTitle {
      font-family: 'Bebas Neue', sans-serif; /* Apply Bebas Neue to the title */
      font-size: 36px;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <div class="container" id="authContainer">
    <!-- Forms wrapper -->
    <div class="panel-container" id="panelContainer">
      <!-- Login Form -->
      <div class="form-panel" id="loginPanel">
        <h2>Login</h2>
        <form action="{{ route('login') }}" method="POST">
          @csrf
          <input type="email" name="email" placeholder="Email" required>
          <div class="eye-icon-wrapper">
            <input type="password" name="password" id="loginPassword" placeholder="Password" required>
            <i class="far fa-eye-slash eye-icon" id="toggleLoginPassword" onclick="togglePassword('loginPassword', this)"></i>
          </div>
          <div class="forgot-password" onclick="forgotPassword()">Forgot password?</div>
          <button type="submit">Login</button>
        </form>
      </div>

      <!-- Sign Up Form -->
      <div class="form-panel" id="registerPanel">
        <h2>Sign Up</h2>
        <form action="{{ route('register') }}" method="POST">
          @csrf
          <input type="text" name="name" placeholder="Username" required>
          <input type="email" name="email" placeholder="Email" required>
          <div class="eye-icon-wrapper">
            <input type="password" name="password" id="signupPassword" placeholder="Password" required>
            <i class="far fa-eye-slash eye-icon" id="toggleSignupPassword" onclick="togglePassword('signupPassword', this)"></i>
          </div>
          <button type="submit">Sign Up</button>
        </form>
      </div>
    </div>

    <!-- Side Info Panel -->
    <div class="side-panel" id="sidePanel">
      <!-- Logo -->
      <img src="{{ asset('images/Kickin.jpg') }}" alt="Kickin Fanatics Logo" class="logo">
      <h2 id="sideTitle">WELCOME BACK!</h2> <!-- Updated font for the title -->
      <p id="sideText">Please login to your account to continue</p>
      <button class="switch" id="switchBtn" onclick="toggleForm()">Create an account</button>
    </div>
  </div>

  <script>
    function toggleForm() {
      const container = document.getElementById('authContainer');
      const sideTitle = document.getElementById('sideTitle');
      const sideText = document.getElementById('sideText');
      const switchBtn = document.getElementById('switchBtn');
      
      container.classList.toggle('active');
      
      if (container.classList.contains('active')) {
        sideTitle.textContent = 'HELLO, FRIEND!';
        sideText.textContent = 'Enter your personal details and start your journey with us';
        switchBtn.textContent = 'Sign in';
      } else {
        sideTitle.textContent = 'WELCOME BACK!';
        sideText.textContent = 'Please login to your account to continue';
        switchBtn.textContent = 'Create an account';
      }
    }
    
    function forgotPassword() {
      window.location.href = "{{ route('forgot.password') }}";
    }

    // Toggle Password Visibility
    function togglePassword(id, icon) {
      const passwordField = document.getElementById(id);
      const type = passwordField.type === 'password' ? 'text' : 'password';
      passwordField.type = type;

      // Toggle the clicked class to change the icon
      icon.classList.toggle('clicked');
      icon.classList.toggle('fa-eye-slash'); // Toggle to eye-slash icon when clicked
      icon.classList.toggle('fa-eye'); // Toggle back to eye icon
    }
  </script>
</body>
</html>