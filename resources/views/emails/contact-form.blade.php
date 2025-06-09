<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Baru dari Website</title>
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
            background: linear-gradient(550deg, #F8F9FA, #181B1E);
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
        }
        .info-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #667eea;
        }
        .info-row {
            display: flex;
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: bold;
            width: 100px;
            color: #555;
        }
        .info-value {
            flex: 1;
            color: #333;
        }
        .message-box {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
        }
        .message-title {
            font-weight: bold;
            color: #667eea;
            margin-bottom: 10px;
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
            <h1>📧 Pesan Baru dari Website</h1>
            <p>{{ $contactDate }}</p>
        </div>
        
        <div class="content">
            <div class="info-box">
                <div class="info-row">
                    <div class="info-label">Nama:</div>
                    <div class="info-value">{{ $contactName }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value">{{ $contactEmail }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Subjek:</div>
                    <div class="info-value">{{ $contactSubject }}</div>
                </div>
            </div>
            
            <div class="message-box">
                <div class="message-title">Pesan:</div>
                <div>{!! nl2br(e($contactMessage)) !!}</div>
            </div>
        </div>
        
        <div class="footer">
            <p>Email ini dikirim otomatis dari sistem contact form website Anda.</p>
            <p>Silakan balas langsung ke email pengirim: {{ $contactEmail }}</p>
        </div>
    </div>
</body>
</html>