<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih - Pesan Anda Telah Diterima</title>
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
            <h1>✅ Terima Kasih!</h1>
            <p>Pesan Anda telah diterima</p>
        </div>
        
        <div class="content">
            <p>Halo <strong>{{ $contactName }}</strong>,</p>
            
            <p>Terima kasih telah menghubungi kami! Pesan Anda dengan subjek "<strong>{{ $contactSubject }}</strong>" telah kami terima pada {{ $contactDate }}.</p>
            
            <div class="highlight-box">
                <p><strong>🎯 Apa yang terjadi selanjutnya?</strong></p>
                <ul>
                    <li>Tim kami akan meninjau pesan Anda dalam 1-2 hari kerja</li>
                    <li>Kami akan merespons melalui email ini</li>
                    <li>Untuk pertanyaan mendesak, silakan hubungi kami langsung</li>
                </ul>
            </div>
            
            <p>Sementara itu, jangan ragu untuk mengunjungi website kami atau menghubungi kami melalui:</p>
            
            <div class="contact-info">
                <h3>📞 Informasi Kontak</h3>
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
                    <span>Senin - Jumat: 08.00 - 17.00</span>
                </div>
            </div>
            
            <p>Sekali lagi, terima kasih atas kepercayaan Anda kepada kami!</p>
            
            <p>Salam hangat,<br>
            <strong>Tim {{ config('app.name') }}</strong></p>
        </div>
        
        <div class="footer">
            <p>Email ini dikirim otomatis sebagai konfirmasi bahwa pesan Anda telah diterima.</p>
            <p>Jika Anda tidak mengirim pesan ini, abaikan email ini.</p>
        </div>
    </div>
</body>
</html>