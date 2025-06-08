@extends('base.base')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Fredoka&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Fredoka', sans-serif; /* default small font */
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }

        .hero {
            height: 400px;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('images/shoe.jpg') center/cover no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            position: relative;
            text-align: center;
        }

        .hero h1 {
            font-family: 'Bebas Neue', cursive; /* big font */
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .hero p {
            font-family: 'Fredoka', sans-serif; /* small font */
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        .content {
            display: flex;
            flex-wrap: wrap;
            margin: 4rem auto;
            max-width: 1200px;
            gap: 2.5rem;
            padding: 0 2rem;
            font-family: 'Fredoka', sans-serif; /* small font */
        }

        .section-title {
            position: relative;
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
            font-family: 'Bebas Neue', cursive; /* big font */
            color: #2c3e50;
            font-size: 2rem;
        }

        .section-title:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 3px;
            background-color: #3498db;
        }

        /* Map Section Container */
        .map-container-wrapper {
            flex: 1;
            min-width: 300px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            padding: 25px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .map-container-wrapper:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .map-container {
            width: 100%;
            height: 300px;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .map-container iframe {
            width: 100%;
            height: 100%;
            border: 0;
        }

        .contact-info {
            flex: 1;
            min-width: 300px;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            font-family: 'Fredoka', sans-serif; /* small font */
        }

        .contact-info:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }

        .contact-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .contact-icon {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50px;
            height: 50px;
            background: #e9f5fe;
            border-radius: 50%;
            margin-right: 1rem;
            color: #3498db;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .contact-details {
            flex-grow: 1;
        }

        .contact-details h3 {
            font-family: 'Bebas Neue', cursive; /* big font for small headings */
            font-size: 1.2rem;
            color: #777;
            margin-bottom: 0.25rem;
        }

        .contact-details p {
            font-family: 'Fredoka', sans-serif; /* small font */
            font-size: 1.1rem;
            font-weight: 500;
            color: #2c3e50;
        }

        .form-section {
            flex: 1;
            min-width: 300px;
            background: white;
            padding: 35px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            font-family: 'Fredoka', sans-serif; /* small font */
        }

        .form-section:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .input-group {
            margin-bottom: 1.5rem;
        }

        .input-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #2c3e50;
            font-family: 'Bebas Neue', cursive; /* big font for labels */
            font-size: 1.1rem;
        }

        input, textarea {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-family: 'Fredoka', sans-serif; /* small font */
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }

        textarea {
            min-height: 150px;
            resize: vertical;
        }

        button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 1rem 1.8rem;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 1rem;
            transition: background-color 0.3s ease, transform 0.2s ease;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-family: 'Bebas Neue', cursive; /* big font for button */
        }

        button:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }

        button:active {
            transform: translateY(0);
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1.5rem;
            display: none;
            font-family: 'Fredoka', sans-serif;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1.5rem;
            display: none;
            font-family: 'Fredoka', sans-serif;
        }

        @media (max-width: 992px) {
            .content {
                gap: 2rem;
            }
        }

        @media (max-width: 768px) {
            .content {
                flex-direction: column;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1rem;
                padding: 0 1rem;
            }

            .map-container-wrapper, .contact-info, .form-section {
                width: 100%;
            }
        }
    </style>

    <!-- Hero Section -->
    <div class="hero">
        <h1>Contact Us</h1>
        <p>We are ready to help you. Do not hesitate to contact us anytime.</p>
    </div>

    <!-- Content Section -->
    <div class="content">
        <!-- Map Section -->
        <div class="map-container-wrapper">
            <h2 class="section-title">Lokasi Kami</h2>
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed/v1/place?q=universitas+ciputra&key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8" 
                    allowfullscreen 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
            <p style="margin-top: 1rem; color: #666;">Kunjungi kami di Universitas Ciputra, Surabaya, Indonesia. Kami terletak di area yang mudah diakses dan strategis.</p>
        </div>

        <!-- Contact Info Section -->
        <div class="contact-info">
            <h2 class="section-title">Informasi Kontak</h2>
            
            <div class="contact-item">
                <div class="contact-icon">📞</div>
                <div class="contact-details">
                    <h3>Telepon</h3>
                    <p>+66 972 729 666</p>
                </div>
            </div>
            
            <div class="contact-item">
                <div class="contact-icon">✉</div>
                <div class="contact-details">
                    <h3>Email</h3>
                    <p>jevonyes@ivander.com</p>
                </div>
            </div>
            
            <div class="contact-item">
                <div class="contact-icon">📍</div>
                <div class="contact-details">
                    <h3>Alamat</h3>
                    <p>Universitas Ciputra, Surabaya</p>
                </div>
            </div>

            <div class="contact-item">
                <div class="contact-icon">⏰</div>
                <div class="contact-details">
                    <h3>Jam Operasional</h3>
                    <p>Senin - Jumat: 08.00 - 17.00</p>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="form-section">
            <h2 class="section-title">Kirim Pesan</h2>
            
            <div class="success-message" id="success-message">
                Pesan Anda berhasil terkirim! Kami akan segera menghubungi Anda.
            </div>
            
            <div class="error-message" id="error-message">
                Terjadi kesalahan dalam pengiriman pesan. Silakan coba lagi.
            </div>
            
            <form method="POST" action="">
                @csrf
                <div class="input-group">
                    <label for="name">Nama</label>
                    <input type="text" id="name" name="name" placeholder="Masukkan nama lengkap Anda" required />
                </div>
                
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Masukkan alamat email Anda" required />
                </div>
                
                <div class="input-group">
                    <label for="message">Pesan</label>
                    <textarea id="message" name="message" placeholder="Tulis pesan Anda di sini..." required></textarea>
                </div>
                
                <button type="submit">Kirim Pesan</button>
            </form>
        </div>
    </div>
@endsection
