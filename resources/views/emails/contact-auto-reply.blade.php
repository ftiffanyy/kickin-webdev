<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - Your Message Has Been Received</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
            line-height: 1.6;
        }
        .highlight-box {
            background: linear-gradient(45deg, #e8f5e8, #f0f9f0);
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #28a745;
        }
        .contact-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .contact-info h3 {
            color: #667eea;
            margin-bottom: 15px;
        }
        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .contact-icon {
            width: 20px;
            margin-right: 10px;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ Thank You!</h1>
            <p>Your message has been received</p>
        </div>
        
        <div class="content">
            <p>Hello <strong>{{ $contactName }}</strong>,</p>
            
            <p>Thank you for contacting us! Your message with subject "<strong>{{ $contactSubject }}</strong>" we have received on {{ $contactDate }}.</p>
            
            <div class="highlight-box">
                <p><strong>🎯 What happens next?</strong></p>
                <ul>
                    <li>Our team will review your message within 1-2 business days.</li>
                    <li>We will respond via this email</li>
                    <li>For urgent questions, please contact us directly</li>
                </ul>
            </div>
            
            <p>In the meantime, please feel free to visit our website or contact us via:</p>
            
            <div class="contact-info">
                <h3>📞 Contact Information</h3>
                <div class="contact-item">
                    <span class="contact-icon">📞</span>
                    <span>+66 972 729 666</span>
                </div>
                <div class="contact-item">
                    <span class="contact-icon">✉️</span>
                    <span>jevonyes@ivander.com</span>
                </div>
                <div class="contact-item">
                    <span class="contact-icon">📍</span>
                    <span>Universitas Ciputra, Surabaya</span>
                </div>
                <div class="contact-item">
                    <span class="contact-icon">⏰</span>
                    <span>Monday - Friday: 08.00 - 17.00</span>
                </div>
            </div>
            
            <p>Once again, thank you for your trust in us!</p>
            
            <p>Warm regards,<br>
            <strong>Tim Kickin</strong></p>
        </div>
        
        <div class="footer">
            <p>This email is sent automatically as confirmation that your message has been received.</p>
            <p>If you did not send this message, please ignore this email.</p>
        </div>
    </div>
</body>
</html>