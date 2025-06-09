@extends('base.base')

@section('content')
        <style>
            .logox img {
                width: 300px; /* sesuaikan dengan ukuran yang diinginkan */
                height: auto; /* untuk menjaga rasio gambar */
            }

            body {
                font-family: Arial, sans-serif;
                background-color: #f9f9f9;
                margin: 0;
                padding: 0;
                animation: fadeIn 2s ease-out;
            }

            .about-container {
                text-align: center;
                padding: 70px;
                opacity: 0;
                animation: fadeInUp 1.5s ease-out 0.5s forwards;
                
            }

            .logo img {
                max-width: 150px; /* Adjust logo size */
                opacity: 0;
                animation: logoFadeIn 2s ease-out forwards;
                box-shadow: 0 5px 15px rgb(0 0 0 / 0.15);
            }

            h1 {
                font-size: 42px;
                font-weight: bold;
                color: #181b1e; 
                margin-top: 20px;
                opacity: 0;
                animation: fadeInUp 2s ease-out 1s forwards;
            }

            p {
                font-size: 18px;
                color: #333;
                background-color: #f9f9f9;
                border-radius: 8px;  
                line-height: 1.6;
                max-width: 800px;
                margin: 20px auto;
                padding: 0 10px;
                opacity: 0;
                animation: fadeInUp 2s ease-out 1.5s forwards;
                box-shadow: 0 5px 15px rgb(0 0 0 / 0.15);
            }

            @keyframes fadeIn {
                0% {
                    opacity: 0;
                }
                100% {
                    opacity: 1;
                }
            }

            @keyframes fadeInUp {
                0% {
                    opacity: 0;
                    transform: translateY(20px);
                }
                100% {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes logoFadeIn {
                0% {
                    opacity: 0;
                    transform: scale(0.5);
                }
                100% {
                    opacity: 1;
                    transform: scale(1);
                }
            }
        </style>
    </head>
    <body>
        <div class="about-container">
            <div class="logox">
                <img src="{{ asset('images/Kickin.jpg') }}" alt="Logo" />
            </div>

            <h1>KICKIN</h1>
            <p>
                Kickin is a shoe retail company dedicated to providing high-quality products with trendy designs and comfort for every step you take. Since its establishment, Kickin has committed to being the top choice for shoe lovers who prioritize style, comfort, and durability.

                <br><br>We believe that shoes are not just footwear but also a part of self-expression and lifestyle. Therefore, Kickin always presents the latest shoe collections that follow fashion trends without compromising material quality and production processes.

                <br><br>With an extensive network of stores and friendly customer service, Kickin strives to provide an easy and enjoyable shopping experience. We also support sustainability by selecting eco-friendly materials and implementing responsible production processes.
            </p>
        </div>
    </body>
@endsection