<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset OTP</title>
    <style>
        /* Email-safe CSS */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            line-height: 1.6;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #1a1a1a 0%, #2c2c2c 50%, #3a3a3a 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }
        
        .header-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #3a3a3a 0%, #4a4a4a 100%);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 36px;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }
        
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
            letter-spacing: 1px;
        }
        
        .header p {
            margin: 8px 0 0 0;
            font-size: 16px;
            opacity: 0.9;
        }
        
        .content {
            padding: 40px 30px;
            text-align: center;
        }
        
        .greeting {
            font-size: 18px;
            color: #2c3e50;
            margin-bottom: 30px;
            font-weight: 500;
        }
        
        .otp-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 16px;
            padding: 30px;
            margin: 30px 0;
            border: 2px dashed #dee2e6;
            position: relative;
        }
        
        .otp-label {
            font-size: 14px;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .otp-code {
            font-size: 36px;
            font-weight: 700;
            color: #2c3e50;
            letter-spacing: 8px;
            margin: 0;
            font-family: 'Courier New', monospace;
            background: linear-gradient(135deg, #1a1a1a, #3a3a3a);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .otp-validity {
            font-size: 12px;
            color: #6c757d;
            margin-top: 15px;
            font-style: italic;
        }
        
        .security-notice {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border: 1px solid #ffeaa7;
            border-radius: 12px;
            padding: 20px;
            margin: 30px 0;
            text-align: left;
        }
        
        .security-notice h3 {
            margin: 0 0 10px 0;
            color: #856404;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .security-notice p {
            margin: 0;
            color: #856404;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .instructions {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 25px;
            margin: 30px 0;
            text-align: left;
        }
        
        .instructions h3 {
            margin: 0 0 15px 0;
            color: #2c3e50;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .instructions ol {
            margin: 0;
            padding-left: 20px;
            color: #495057;
        }
        
        .instructions li {
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .footer {
            background: linear-gradient(135deg, #1a1a1a 0%, #2c2c2c 100%);
            color: white;
            padding: 30px;
            text-align: center;
            font-size: 14px;
        }
        
        .footer p {
            margin: 0 0 10px 0;
            opacity: 0.8;
        }
        
        .footer .company-name {
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 15px;
        }
        
        .divider {
            height: 2px;
            background: linear-gradient(90deg, transparent, #dee2e6, transparent);
            margin: 30px 0;
        }
        
        /* Responsive design for email clients */
        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 8px;
            }
            
            .header {
                padding: 30px 20px;
            }
            
            .header h1 {
                font-size: 24px;
            }
            
            .content {
                padding: 30px 20px;
            }
            
            .otp-code {
                font-size: 28px;
                letter-spacing: 4px;
            }
            
            .otp-section {
                padding: 20px;
            }
            
            .header-icon {
                width: 60px;
                height: 60px;
            }
            
            .header-icon img {
                width: 35px;
                height: 35px;
            }
        }
        
        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .email-container {
                background-color: #1a1a1a;
            }
            
            .content {
                background-color: #1a1a1a;
                color: #ffffff;
            }
            
            .greeting {
                color: #ffffff;
            }
            
            .otp-section {
                background: linear-gradient(135deg, #2c2c2c 0%, #3c3c3c 100%);
                border-color: #4a4a4a;
            }
            
            .otp-code {
                color: #ffffff;
            }
            
            .instructions {
                background: #2c2c2c;
                color: #ffffff;
            }
            
            .instructions h3 {
                color: #ffffff;
            }
            
            .instructions ol {
                color: #cccccc;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header Section -->
        <div class="header">
            <div class="header-icon">
                <img src="{{ asset('images/Kickin.jpg') }}" alt="Kickin Logo">
            </div>
            <h1>Password Reset</h1>
            <p>Secure verification code</p>
        </div>
        
        <!-- Main Content -->
        <div class="content">
            <div class="greeting">
                Hello! We received a request to reset your password.
            </div>
            
            <!-- OTP Section -->
            <div class="otp-section">
                <div class="otp-label">Your Verification Code</div>
                <div class="otp-code">{{ $otp }}</div>
                <div class="otp-validity">This code will expire in 10 minutes</div>
            </div>
            
            <!-- Instructions -->
            <div class="instructions">
                <h3>
                    📋 How to use this code:
                </h3>
                <ol>
                    <li>Return to the password reset page</li>
                    <li>Enter the verification code above</li>
                    <li>Create your new secure password</li>
                    <li>Confirm your new password</li>
                </ol>
            </div>
            
            <div class="divider"></div>
            
            <!-- Security Notice -->
            <div class="security-notice">
                <h3>
                    ⚠️ Security Notice
                </h3>
                <p>
                    If you did not request a password reset, please ignore this email and ensure your account is secure. 
                    This verification code will expire automatically and cannot be used after 10 minutes.
                </p>
            </div>
            
            <div style="margin-top: 30px; font-size: 14px; color: #6c757d;">
                <p>For security reasons, do not share this code with anyone.</p>
                <p>This is an automated message, please do not reply to this email.</p>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <div class="company-name">Kickin</div>
            <p>This email was sent to you because a password reset was requested for your account.</p>
            <p>© 2024 Kickin. All rights reserved.</p>
        </div>
    </div>
</body>
</html>