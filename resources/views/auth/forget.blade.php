<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    
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
            background: linear-gradient(550deg, #F8F9FA, #181B1E);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .reset-container {
            background: white;
            border-radius: 15px;
            padding: 50px 60px;
            width: 100%;
            max-width: 650px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            position: relative;
            animation: slideUp 0.6s ease-out;
            background: linear-gradient(135deg, rgba(248, 249, 250, 0.95) 0%, rgba(255, 255, 255, 0.98) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .header-section {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 25px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        .logo-container {
            position: relative;
        }

        .logo {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border: 4px solid white;
            transition: all 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.2);
        }

        .logo-glow {
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--dark), var(--dim));
            opacity: 0.1;
            animation: pulse 2s infinite;
            z-index: -1;
        }

        .title-section {
            text-align: left;
            flex: 1;
            min-width: 250px;
        }

        .title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 42px;
            color: var(--dark);
            margin: 0 0 10px 0;
            letter-spacing: 3px;
            background: linear-gradient(135deg, var(--dark), var(--dim));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .subtitle {
            font-family: 'Fredoka', sans-serif;
            color: var(--dim);
            font-size: 16px;
            margin: 0;
            line-height: 1.6;
            font-weight: 400;
        }

        .icon-divider {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 30px 0;
            gap: 20px;
        }

        .divider-line {
            flex: 1;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--silver), transparent);
        }

        .icon-container {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--dark), var(--dim));
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(24, 27, 30, 0.2);
            position: relative;
            overflow: hidden;
        }

        .icon-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.8s;
        }

        .icon-container:hover::before {
            left: 100%;
        }

        .reset-icon {
            font-size: 22px;
            color: white;
            z-index: 1;
        }

        /* Success Alert Style */
        .alert-success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
            padding: 18px 24px;
            border-radius: 15px;
            margin-bottom: 30px;
            font-family: 'Fredoka', sans-serif;
            font-size: 15px;
            border: 1px solid #c3e6cb;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideDown 0.5s ease-out;
            box-shadow: 0 4px 15px rgba(21, 87, 36, 0.1);
        }

        /* Error Alert Style */
        .alert-error {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
            padding: 18px 24px;
            border-radius: 15px;
            margin-bottom: 30px;
            font-family: 'Fredoka', sans-serif;
            font-size: 15px;
            border: 1px solid #f5c6cb;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideDown 0.5s ease-out;
            box-shadow: 0 4px 15px rgba(114, 28, 36, 0.1);
        }

        .form-section {
            margin: 40px 0;
        }

        .form-group {
            text-align: left;
            margin-bottom: 30px;
            position: relative;
        }

        .form-label {
            font-family: 'Fredoka', sans-serif;
            font-weight: 500;
            color: var(--dark);
            font-size: 16px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-input {
            width: 100%;
            padding: 18px 24px;
            border: 2px solid var(--silver);
            border-radius: 15px;
            font-family: 'Fredoka', sans-serif;
            font-size: 16px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(248, 249, 250, 0.9));
            color: var(--dark);
            transition: all 0.4s ease;
            outline: none;
            position: relative;
        }

        .form-input:focus {
            border-color: var(--dark);
            box-shadow: 0 0 25px rgba(24, 27, 30, 0.15);
            transform: translateY(-2px);
            background: white;
        }

        .form-input::placeholder {
            color: var(--cadet);
            font-style: italic;
        }

        /* Validation error styles */
        .form-input.is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 15px rgba(220, 53, 69, 0.2);
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 14px;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-family: 'Fredoka', sans-serif;
            animation: slideDown 0.3s ease-out;
        }

        .submit-btn {
            width: 100%;
            background: linear-gradient(135deg, var(--dark), var(--dim));
            color: white;
            border: none;
            border-radius: 15px;
            padding: 20px;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 20px;
            letter-spacing: 2px;
            cursor: pointer;
            transition: all 0.4s ease;
            box-shadow: 0 8px 25px rgba(24, 27, 30, 0.2);
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(24, 27, 30, 0.3);
        }

        .submit-btn:active {
            transform: translateY(-1px);
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.6s;
        }

        .submit-btn:hover::before {
            left: 100%;
        }

        .footer-section {
            border-top: 2px solid var(--silver);
            padding-top: 25px;
            margin-top: 25px;
        }

        .back-link {
            color: var(--dim);
            font-family: 'Fredoka', sans-serif;
            font-size: 16px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
            padding: 12px 24px;
            border-radius: 10px;
            background: linear-gradient(135deg, rgba(95, 98, 102, 0.1), rgba(165, 169, 174, 0.1));
        }

        .back-link:hover {
            color: var(--dark);
            text-decoration: none;
            background: linear-gradient(135deg, rgba(24, 27, 30, 0.1), rgba(95, 98, 102, 0.1));
            transform: translateX(-5px);
        }

        /* Animations */
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0%, 100% { 
                transform: scale(1);
                opacity: 0.1;
            }
            50% { 
                transform: scale(1.1);
                opacity: 0.2;
            }
        }

        .alert i {
            animation: bounce 0.8s ease-out;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .reset-container {
                padding: 40px 30px;
                max-width: 500px;
            }
            
            .header-section {
                flex-direction: column;
                gap: 20px;
            }
            
            .title-section {
                text-align: center;
            }
            
            .title {
                font-size: 36px;
            }
            
            .subtitle {
                font-size: 15px;
            }
        }

        @media (max-width: 480px) {
            .reset-container {
                padding: 30px 20px;
                margin: 10px;
            }
            
            .title {
                font-size: 32px;
                letter-spacing: 2px;
            }
            
            .subtitle {
                font-size: 14px;
            }
            
            .form-input {
                padding: 15px 20px;
                font-size: 15px;
            }

            .submit-btn {
                padding: 18px;
                font-size: 18px;
                letter-spacing: 1px;
            }
        }

        /* Loading state */
        .loading {
            opacity: 0.8;
            pointer-events: none;
        }

        .loading .submit-btn {
            background: linear-gradient(135deg, var(--cadet), var(--silver));
        }

        /* Enhanced focus states */
        .form-input:focus + .form-label {
            color: var(--dark);
        }

        .validation-success {
            border-color: #28a745 !important;
            box-shadow: 0 0 15px rgba(40, 167, 69, 0.2) !important;
        }

        .validation-error {
            border-color: #dc3545 !important;
            box-shadow: 0 0 15px rgba(220, 53, 69, 0.2) !important;
        }
    </style>
</head>
<body>
    <div class="reset-container">
        <!-- Header Section -->
        <div class="header-section">
            <div class="logo-container">
                <div class="logo-glow"></div>
                <img src="{{ asset('images/Kickin.jpg') }}" alt="Logo" class="logo">
            </div>
            
            <div class="title-section">
                <h1 class="title">RESET PASSWORD</h1>
                <p class="subtitle">Enter your email address and we'll send you a secure OTP code to reset your password</p>
            </div>
        </div>

        <!-- Icon Divider -->
        <div class="icon-divider">
            <div class="divider-line"></div>
            <div class="icon-container">
                <i class="fas fa-key reset-icon"></i>
            </div>
            <div class="divider-line"></div>
        </div>

        <!-- Display success message -->
        @if(session('status') && !str_contains(strtolower(session('status')), 'not found') && !str_contains(strtolower(session('status')), 'invalid'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('status') }}
            </div>
        @endif

        <!-- Form Section -->
        <div class="form-section">
            <form action="{{ route('forgot.send') }}" method="POST" id="resetForm">
                @csrf
                
                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope"></i>
                        Email Address
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-input @error('email') is-invalid @enderror" 
                        placeholder="Enter your registered email address"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                    >
                    @error('email')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <button type="submit" class="submit-btn" id="submitBtn">
                    <i class="fas fa-paper-plane" style="margin-right: 10px;"></i>
                    SEND OTP CODE
                </button>
            </form>
        </div>

        <!-- Footer Section -->
        <div class="footer-section">
            <a href="{{ route('auth') }}" class="back-link">
                <i class="fas fa-arrow-left"></i>
                Back to Login
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('resetForm');
            const submitBtn = document.getElementById('submitBtn');
            const emailInput = document.getElementById('email');
            const container = document.querySelector('.reset-container');

            // Form submission with loading state
            form.addEventListener('submit', function(e) {
                container.classList.add('loading');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right: 10px;"></i>SENDING...';
                submitBtn.disabled = true;
            });

            // Enhanced email validation with visual feedback
            emailInput.addEventListener('input', function() {
                const email = this.value;
                const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
                
                // Remove previous validation classes
                this.classList.remove('validation-success', 'validation-error');
                
                if (email.length > 0) {
                    if (isValid) {
                        this.classList.add('validation-success');
                    } else {
                        this.classList.add('validation-error');
                    }
                }
            });

            // Enhanced focus effects
            emailInput.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });

            emailInput.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });

            // Auto-focus email input with delay for better UX
            setTimeout(() => {
                emailInput.focus();
            }, 300);

            // Add floating animation to logo
            const logo = document.querySelector('.logo');
            let floatDirection = 1;
            
            setInterval(() => {
                const currentTransform = logo.style.transform || '';
                const currentY = parseFloat(currentTransform.match(/translateY\(([^)]+)\)/) || [0, 0])[1];
                const newY = currentY + (floatDirection * 0.5);
                
                if (Math.abs(newY) > 3) {
                    floatDirection *= -1;
                }   
                
                logo.style.transform = `translateY(${newY}px)`;
            }, 100);
        });
    </script>
</body>
</html>