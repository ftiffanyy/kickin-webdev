@extends('base.base')

@section('title', 'Contact Us')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Fredoka:wght@300;400;500;600;700&display=swap');

    /* Reset untuk section ini saja */
    .contact-page * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .contact-page {
        font-family: 'Fredoka', sans-serif;
        color: #333;
        line-height: 1.6;
        min-height: 100vh;
        position: relative;
    }

    /* Floating particles background */
    .particles {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 1;
    }

    .particle {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }

    .hero {
        height: 60vh;
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.6), rgba(45, 45, 45, 0.6)), 
                    url('https://images.unsplash.com/photo-1557804506-669a67965ba0?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: white;
        position: relative;
        text-align: center;
        overflow: hidden;
    }

    .hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 30% 40%, rgba(255, 255, 255, 0.05) 0%, transparent 50%),
                    radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
        pointer-events: none;
    }

    .hero-content {
        z-index: 2;
        max-width: 800px;
        padding: 0 2rem;
    }

    .hero h1 {
        font-family: 'Bebas Neue', cursive;
        font-size: 4.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        background: white;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: slideInDown 1s ease-out;
    }

    .hero p {
        font-size: 1.3rem;
        margin: 0 auto;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        opacity: 0.9;
        animation: slideInUp 1s ease-out 0.3s both;
        /* text-transform: uppercase; */
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    @keyframes slideInDown {
        from { transform: translateY(-100px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    @keyframes slideInUp {
        from { transform: translateY(100px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        margin: -5rem auto 4rem;
        max-width: 1400px;
        padding: 0 2rem;
        position: relative;
        z-index: 10;
    }

    .form-section {
        background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 3rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
        animation: fadeInLeft 1s ease-out;
        color: #ffffff;
    }

    .form-section:hover {
        transform: translateY(-10px);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4);
        border-color: rgba(255, 255, 255, 0.2);
    }

    .contact-info-section {
        display: grid;
        grid-template-rows: auto 1fr;
        gap: 2rem;
        animation: fadeInRight 1s ease-out;
    }

    @keyframes fadeInLeft {
        from { transform: translateX(-50px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    @keyframes fadeInRight {
        from { transform: translateX(50px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    .map-container-wrapper {
        background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
        color: #ffffff;
    }

    .map-container-wrapper:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
        border-color: rgba(255, 255, 255, 0.2);
    }

    .map-container {
        width: 100%;
        height: 250px;
        border-radius: 15px;
        overflow: hidden;
        margin-bottom: 1rem;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    }

    .map-container iframe {
        width: 100%;
        height: 100%;
        border: 0;
        /* filter: grayscale(1) invert(1) contrast(1.2); */
    }

    .contact-info {
        background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
        backdrop-filter: blur(20px);
        padding: 2rem;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
        color: #ffffff;
    }

    .contact-info:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
        border-color: rgba(255, 255, 255, 0.2);
    }

    .section-title {
        position: relative;
        padding-bottom: 1rem;
        margin-bottom: 2rem;
        font-family: 'Bebas Neue', cursive;
        color: #ffffff;
        font-size: 2.2rem;
        text-align: center;
        /* text-transform: lowercase; */
    }

    .section-title::after {
        content: '';
        position: absolute;
        left: 50%;
        bottom: 0;
        transform: translateX(-50%);
        width: 60px;
        height: 4px;
        background: linear-gradient(45deg, #666666, #333333);
        border-radius: 2px;
    }

    .contact-item {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
        padding: 1rem;
        border-radius: 12px;
        transition: all 0.3s ease;
        background: rgba(45, 45, 45, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .contact-item:hover {
        background: rgba(77, 77, 77, 0.8);
        transform: translateX(10px);
        border-color: rgba(255, 255, 255, 0.1);
    }

    .contact-icon {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 60px;
        height: 60px;
        background: linear-gradient(45deg, #404040, #1a1a1a);
        border-radius: 50%;
        margin-right: 1rem;
        color: white;
        font-size: 1.5rem;
        flex-shrink: 0;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.5);
        border: 2px solid rgba(255, 255, 255, 0.1);
    }

    .contact-details h3 {
        font-family: 'Bebas Neue', cursive;
        font-size: 1.3rem;
        color: #cccccc;
        margin-bottom: 0.25rem;
        /* text-transform: lowercase; */
    }

    .contact-details p {
        font-size: 1.1rem;
        font-weight: 500;
        color: #ffffff;
        /* text-transform: uppercase; */
        letter-spacing: 0.5px;
    }

    .input-group {
        margin-bottom: 1.5rem;
        position: relative;
    }

    .input-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #cccccc;
        font-family: 'Bebas Neue', cursive;
        font-size: 1.2rem;
        /* text-transform: lowercase; */
    }

    .contact-page input, .contact-page textarea {
        width: 100%;
        padding: 1rem 1.2rem;
        border: 2px solid #404040;
        border-radius: 12px;
        font-family: 'Fredoka', sans-serif;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: rgba(45, 45, 45, 0.8);
        color: #ffffff;
        /* text-transform: uppercase; */
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    .contact-page input::placeholder, .contact-page textarea::placeholder {
        color: #888888;
        /* text-transform: lowercase; */
        font-weight: 400;
    }

    .contact-page input:focus, .contact-page textarea:focus {
        outline: none;
        border-color: #666666;
        box-shadow: 0 0 0 4px rgba(102, 102, 102, 0.2);
        background: rgba(45, 45, 45, 1);
        transform: translateY(-2px);
    }

    .contact-page textarea {
        min-height: 120px;
        resize: vertical;
    }

    .submit-btn {
        background: linear-gradient(45deg, #404040, #1a1a1a);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.1);
        padding: 1.2rem 2rem;
        border-radius: 12px;
        cursor: pointer;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        width: 100%;
        /* text-transform: lowercase; */
        letter-spacing: 1px;
        font-family: 'Bebas Neue', cursive;
        position: relative;
        overflow: hidden;
    }

    .submit-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transition: left 0.5s;
    }

    .submit-btn:hover::before {
        left: 100%;
    }

    .submit-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5);
        border-color: rgba(255, 255, 255, 0.2);
        background: linear-gradient(45deg, #555555, #2a2a2a);
    }

    .submit-btn:active {
        transform: translateY(-1px);
    }

    .message {
        padding: 1rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        font-weight: 500;
        display: none;
        animation: slideIn 0.5s ease-out;
    }

    @keyframes slideIn {
        from { transform: translateY(-20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .success-message {
        background: linear-gradient(45deg, #1a4a3a, #2d5a4a);
        color: #90ee90;
        border: 1px solid #4a6a5a;
    }

    .error-message {
        background: linear-gradient(45deg, #4a1a1a, #5a2d2d);
        color: #ff6b6b;
        border: 1px solid #6a4a4a;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .content {
            grid-template-columns: 1fr;
            gap: 2rem;
            margin-top: -3rem;
        }
        
        .hero h1 {
            font-size: 3.5rem;
        }
    }

    @media (max-width: 768px) {
        .hero h1 {
            font-size: 2.8rem;
        }
        
        .hero p {
            font-size: 1.1rem;
        }
        
        .content {
            padding: 0 1rem;
            margin-top: -2rem;
        }
        
        .form-section, .map-container-wrapper, .contact-info {
            padding: 1.5rem;
        }
        
        .section-title {
            font-size: 1.8rem;
        }
    }

    @media (max-width: 480px) {
        .hero {
            height: 50vh;
        }
        
        .hero h1 {
            font-size: 2.2rem;
        }
        
        .contact-item {
            flex-direction: column;
            text-align: center;
        }
        
        .contact-icon {
            margin-right: 0;
            margin-bottom: 0.5rem;
        }
    }
</style>

<div class="contact-page">
    <!-- Floating particles -->
    <div class="particles">
        <div class="particle" style="left: 20%; animation-delay: 0s; width: 6px; height: 6px;"></div>
        <div class="particle" style="left: 40%; animation-delay: 1s; width: 8px; height: 8px;"></div>
        <div class="particle" style="left: 60%; animation-delay: 2s; width: 4px; height: 4px;"></div>
        <div class="particle" style="left: 80%; animation-delay: 1.5s; width: 10px; height: 10px;"></div>
        <div class="particle" style="left: 10%; top: 60%; animation-delay: 3s; width: 5px; height: 5px;"></div>
        <div class="particle" style="left: 70%; top: 70%; animation-delay: 0.5s; width: 7px; height: 7px;"></div>
    </div>

    <!-- Hero Section -->
    <div class="hero">
        <div class="hero-content">
            <h1>Contact Us</h1>
            <p>We are ready to assist you anytime. Do not hesitate to contact us and get the best solution for your needs.</p>
        </div>
    </div>

    <!-- Content Section -->
    <div class="content">
        <!-- Contact Form -->
        <div class="form-section">
            <h2 class="section-title">Send Message</h2>
            
            <div class="success-message message" id="success-message">
                ✅ Your message has been sent successfully! We will contact you soon.
            </div>
            
            <div class="error-message message" id="error-message">
                ❌ There was an error in sending the message. Please try again.
            </div>
            
            <form id="contact-form" action="{{ route('contact.send') }}" method="POST">
                @csrf
                <div class="input-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your full name" required value="{{ old('name') }}" />
                    @error('name')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="input-group">
                    <label for="email">Email Adress</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email address" required value="{{ old('email') }}" />
                    @error('email')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="input-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" placeholder="Enter the message subject" required value="{{ old('subject') }}" />
                    @error('subject')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="input-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" placeholder="Write your message here..." required>{{ old('message') }}</textarea>
                    @error('message')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                
                <button type="submit" class="submit-btn">
                    <span>Send Message</span>
                </button>
            </form>
        </div>

        <!-- Contact Info & Map Section -->
        <div class="contact-info-section">
            <!-- Map Section -->
            <div class="map-container-wrapper">
                <h2 class="section-title">Our Location</h2>
                <div class="map-container">
                    <iframe 
                        src="https://www.google.com/maps/embed/v1/place?q=universitas+ciputra+surabaya&key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8" 
                        allowfullscreen 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <p style="text-align: center; color: #cccccc; font-style: italic;">
                    📍 Visit us at Ciputra University, Surabaya. Easily accessible and strategic location.
                </p>
            </div>

            <!-- Contact Info -->
            <div class="contact-info">
                <h2 class="section-title">Contact Information</h2>
                
                <div class="contact-item">
                    <div class="contact-icon">📞</div>
                    <div class="contact-details">
                        <h3>Phone</h3>
                        <p>+66 972 729 666</p>
                    </div>
                </div>
                
                <div class="contact-item">
                    <div class="contact-icon">✉️</div>
                    <div class="contact-details">
                        <h3>Email</h3>
                        <p>keenanchan01@student.ciputra.ac.id</p>
                    </div>
                </div>
                
                <div class="contact-item">
                    <div class="contact-icon">📍</div>
                    <div class="contact-details">
                        <h3>Adress</h3>
                        <p>Universitas Ciputra, Surabaya</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">⏰</div>
                    <div class="contact-details">
                        <h3>Operating Hours</h3>
                        <p>Monday - Friday: 08.00 - 17.00</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Form submission dengan Laravel
    document.getElementById('contact-form').addEventListener('submit', function(e) {
        const submitBtn = document.querySelector('.submit-btn');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.innerHTML = '<span>Sending...</span>';
        submitBtn.disabled = true;
        
        // Form akan disubmit secara normal ke Laravel
        // Laravel akan handle redirect dan response
    });

    // Show success/error messages if they exist from Laravel session
    @if(session('success'))
        document.getElementById('success-message').style.display = 'block';
        setTimeout(() => {
            document.getElementById('success-message').style.display = 'none';
        }, 5000);
    @endif

    @if(session('error'))
        document.getElementById('error-message').style.display = 'block';
        setTimeout(() => {
            document.getElementById('error-message').style.display = 'none';
        }, 5000);
    @endif
</script>
@endsection