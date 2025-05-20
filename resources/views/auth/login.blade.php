<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login & Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #181B1E;
        }

        .container-box {
            width: 800px;
            height: 500px;
            margin: 40px auto;
            display: flex;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
            overflow: hidden;
            border-radius: 20px;
        }

        .form-section {
            flex: 1;
            background: #F8F9FA;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px;
            transition: transform 0.6s ease-in-out;
        }

        .info-section {
            flex: 1;
            background: #181B1E;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px;
            transition: transform 0.6s ease-in-out;
        }

        .form-section form {
            width: 100%;
        }

        .form-control {
            border-radius: 0;
            background: #EDEDED;
        }

        .btn-dark {
            background-color: #181B1E;
            border: none;
            transition: background 0.3s;
        }

        .btn-dark:hover {
            background-color: #5F6266;
        }

        .toggle-btn {
            color: #fff;
            text-decoration: underline;
            cursor: pointer;
            margin-top: 10px;
        }

        .slide-container {
            display: flex;
            width: 1600px;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }

        .container-box.active .slide-container {
            transform: translateX(-800px);
        }
    </style>
</head>
<body>

<div class="container-box" id="loginBox">
    <div class="slide-container">

        {{-- Login Form --}}
        <div class="form-section">
            <h3 class="mb-4">Login</h3>
            <form action="#" method="POST">
                @csrf
                <div class="mb-3">
                    <input type="text" name="email" class="form-control" placeholder="Email">
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-dark w-100">Login</button>
            </form>
            <p class="mt-3">Don't have an account? <span class="toggle-btn" onclick="toggleForm()">Sign Up</span></p>
        </div>

        {{-- Register Form --}}
        <div class="form-section">
            <h3 class="mb-4">Sign Up</h3>
            <form action="#" method="POST">
                @csrf
                <div class="mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username">
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email">
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-dark w-100">Sign Up</button>
            </form>
            <p class="mt-3">Already have an account? <span class="toggle-btn" onclick="toggleForm()">Login</span></p>
        </div>

    </div>
</div>

<script>
    function toggleForm() {
        document.getElementById('loginBox').classList.toggle('active');
    }
</script>

</body>
</html>