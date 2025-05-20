<!-- resources/views/auth/forget.blade.php -->
<!DOCTYPE html>
<html lang="en">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
<style>
    :root {
        --black: #181B1E;
        --dim-gray: #5F6266;
        --cadet-gray: #A5A9AE;
        --silver: #CFD1D4;
        --seasalt: #F8F9FA;
    }

    body, html {
        height: 100%;
        margin: 0;
        font-family: 'Montserrat', sans-serif;
        background-color: var(--black);
    }

    .login-wrapper {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .login-card {
        background-color: var(--dim-gray);
        padding: 40px 30px;
        border-radius: 12px;
        width: 100%;
        max-width: 420px;
        color: var(--seasalt);
    }

    .form-control {
        background-color: var(--cadet-gray);
        color: var(--black);
        border: none;
        border-radius: 10px;
    }

    .form-control::placeholder {
        color: var(--silver);
    }

    .form-control:focus {
        outline: none;
        box-shadow: none;
        background-color: var(--silver);
    }

    .btn-submit {
        background-color: var(--black);
        color: var(--seasalt);
        border: none;
        border-radius: 8px;
        padding: 10px;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        background-color: var(--cadet-gray);
        color: var(--black);
    }

    .form-label {
        font-weight: 600;
    }

    .text-link {
        color: var(--seasalt);
        font-size: 0.9rem;
    }

    .text-link:hover {
        color: var(--silver);
        text-decoration: underline;
    }
</style>
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="login-wrapper">
    <div class="login-card">
        <h3 class="mb-4 text-center">Reset Password</h3>

        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('forgot.send') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="email" class="form-label">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    placeholder="your@email.com"
                    required>
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-submit">Send Reset Link</button>
            </div>

            <div class="text-center">
                <a href="{{ route('auth') }}" class="text-link">Back to Login</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>