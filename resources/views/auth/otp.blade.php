<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    
    <!-- Load Google Fonts for Bebas Neue and Fredoka -->
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Fredoka:wght@400;500&display=swap" rel="stylesheet">
    
    <!-- Load Font Awesome -->
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
            font-family: 'Fredoka', sans-serif;
            background: linear-gradient(135deg, var(--dark) 0%, #2d2d2d 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .otp-container {
            background: var(--seasalt);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            text-align: center;
            position: relative;
        }

        .logo-container {
            margin-bottom: 30px;
        }

        .logo {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            margin: 0 auto;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            border: 3px solid var(--silver);
        }

        .title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 28px;
            color: var(--dark);
            margin-bottom: 15px;
            letter-spacing: 1px;
        }

        .subtitle {
            font-family: 'Fredoka', sans-serif;
            color: var(--dim);
            font-size: 14px;
            margin-bottom: 30px;
            line-height: 1.4;
        }

        /* Success Alert Style */
        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-family: 'Fredoka', sans-serif;
            font-size: 14px;
            border: 1px solid #c3e6cb;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Error Alert Style for Invalid OTP - Changed to Red */
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-family: 'Fredoka', sans-serif;
            font-size: 14px;
            border: 1px solid #f5c6cb;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .otp-inputs {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-bottom: 30px;
        }

        .otp-input {
            width: 50px;
            height: 50px;
            border: 2px solid var(--silver);
            border-radius: 12px;
            text-align: center;
            font-size: 20px;
            font-weight: 500;
            font-family: 'Fredoka', sans-serif;
            background: white;
            color: var(--dark);
            transition: all 0.3s ease;
            outline: none;
        }

        .otp-input:focus {
            border-color: var(--dark);
            box-shadow: 0 0 10px rgba(24, 27, 30, 0.2);
            transform: scale(1.05);
        }

        .otp-input:valid {
            border-color: #28a745;
        }

        .verify-btn {
            width: 100%;
            background: var(--dark);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 15px;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 18px;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 16px rgba(24, 27, 30, 0.2);
            margin-bottom: 20px;
        }

        .verify-btn:hover {
            background: var(--dim);
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(24, 27, 30, 0.3);
        }

        .verify-btn:active {
            transform: translateY(0);
        }

        .back-link {
            color: var(--dim);
            font-family: 'Fredoka', sans-serif;
            font-size: 14px;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: var(--dark);
            text-decoration: none;
        }

        /* Responsive design */
        @media (max-width: 480px) {
            .otp-container {
                padding: 30px 20px;
                margin: 10px;
            }
            
            .otp-inputs {
                gap: 8px;
            }
            
            .otp-input {
                width: 45px;
                height: 45px;
                font-size: 18px;
            }
            
            .title {
                font-size: 24px;
            }
        }

        /* Animation for container */
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .otp-container {
            animation: slideUp 0.6s ease-out;
        }

        /* Animation for OTP inputs */
        .otp-input {
            animation: slideUp 0.6s ease-out;
        }

        .otp-input:nth-child(1) { animation-delay: 0.1s; }
        .otp-input:nth-child(2) { animation-delay: 0.15s; }
        .otp-input:nth-child(3) { animation-delay: 0.2s; }
        .otp-input:nth-child(4) { animation-delay: 0.25s; }
        .otp-input:nth-child(5) { animation-delay: 0.3s; }
        .otp-input:nth-child(6) { animation-delay: 0.35s; }

        /* Success check animation */
        @keyframes checkmark {
            0% { transform: scale(0); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }

        .alert i {
            animation: checkmark 0.5s ease-out;
        }

        /* New button styling for Resend OTP */
        .resend-btn {
            width: 100%;
            background: var(--dim);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-family: 'Fredoka', sans-serif;
            font-size: 16px;
            cursor: pointer;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .resend-btn:hover {
            background: var(--dark);
            transform: translateY(-2px);
        }

        .resend-btn:active {
            transform: translateY(0);
        }

        .resend-link {
            font-size: 14px;
            color: var(--dim);
            text-decoration: none;
            margin-top: 10px;
            display: inline-block;
        }

        .resend-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="otp-container">
        <!-- Logo -->
        <div class="logo-container">
            <img src="{{ asset('images/Kickin.jpg') }}" alt="Logo" class="logo">
        </div>

        <!-- Title -->
        <h1 class="title">OTP VERIFICATION</h1>
        <p class="subtitle">Enter the 6-digit code sent to your email to continue</p>

        <!-- Display success message if OTP has been sent -->
        @if(session('status') && !str_contains(strtolower(session('status')), 'invalid'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('status') }}
            </div>
        @endif

        <!-- Display error message if OTP is invalid -->
        @if(session('error') || (session('status') && str_contains(strtolower(session('status')), 'invalid')))
            <div class="alert alert-error">
                <i class="fas fa-times-circle"></i>
                {{ session('error') ?: session('status') }}
            </div>
        @endif

        <!-- OTP Form -->
        <form action="{{ route('verify.otp') }}" method="POST">
            @csrf
            <div class="otp-inputs">
                <input type="text" name="otp1" class="otp-input" maxlength="1" required>
                <input type="text" name="otp2" class="otp-input" maxlength="1" required>
                <input type="text" name="otp3" class="otp-input" maxlength="1" required>
                <input type="text" name="otp4" class="otp-input" maxlength="1" required>
                <input type="text" name="otp5" class="otp-input" maxlength="1" required>
                <input type="text" name="otp6" class="otp-input" maxlength="1" required>
            </div>
            
            <button type="submit" class="verify-btn">
                <i class="fas fa-shield-alt" style="margin-right: 8px;"></i>
                VERIFY OTP
            </button>
        </form>

        <!-- Resend OTP Button -->
        <form action="{{ route('resend.otp') }}" method="POST">
            @csrf
            <button type="submit" class="resend-btn">Resend OTP</button>
        </form>

        <!-- Back Link -->
        <a href="{{ route('forgot.password') }}" class="back-link">
            <i class="fas fa-arrow-left"></i>
            Back to Forgot Password
        </a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.otp-input');
            
            inputs.forEach((input, index) => {
                // Auto-focus next input when typing
                input.addEventListener('input', function() {
                    // Only allow numbers
                    this.value = this.value.replace(/[^0-9]/g, '');
                    
                    if (this.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                });
                
                // Handle backspace
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && this.value === '' && index > 0) {
                        inputs[index - 1].focus();
                    }
                });
                
                // Handle paste
                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const paste = (e.clipboardData || window.clipboardData).getData('text');
                    const numbers = paste.replace(/[^0-9]/g, '').slice(0, 6);
                    
                    numbers.split('').forEach((num, i) => {
                        if (inputs[i]) {
                            inputs[i].value = num;
                        }
                    });
                    
                    // Focus on the next empty input or the last one
                    const nextEmptyIndex = Math.min(numbers.length, inputs.length - 1);
                    inputs[nextEmptyIndex].focus();
                });
            });
        });
    </script>
</body>
</html>