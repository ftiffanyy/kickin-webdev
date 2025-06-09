@extends('base.base')

@section('content')
    <style>
.video-container {
    width: 100%;
    max-width: 100%;
    position: relative;
    padding-bottom: 56.25%; /* Aspect ratio 16:9 */
    height: 0;
    overflow: hidden;
    background: #000;
    margin-bottom: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.video-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: none;
    border-radius: 8px;
}

/* Hide any potential control elements */
.video-container iframe::-webkit-media-controls {
    display: none !important;
}

.video-container iframe::-webkit-media-controls-enclosure {
    display: none !important;
}


    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
    }

    .container {
        width: 80%;
        margin: 50px auto;
        text-align: center;
        margin-top: 200px;
    }

    h1 {
        font-size: 36px;
        color: #2c3e50;
        margin-bottom: 40px;
    }


    /* WHY US CSS */
    /* .card {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin-bottom: 40px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        
    }

    .card-image {
        flex: 1;
        max-width: 300px;
        padding: 20px;
    }

    .card-image img {
        width: 100%;
        border-radius: 8px;
    }

    .card-text {
        flex: 2;
        max-width: 600px;
        padding: 20px;
    }

    .card-text h2 {
        font-size: 24px;
        color: #181B1E;
        margin-bottom: 10px;
        padding: 25px;
    }

    .card-text p {
        font-size: 16px;
        color: #7f8c8d;
        line-height: 1.6;
    } */

/* ======================== */
.card {
    display: flex;
    align-items: center;      /* Vertikal center */
    gap: 30px;                /* Jarak gambar dan teks */
    margin-bottom: 40px;
    padding: 25px 40px;
    border: 1px solid #ddd;
    border-radius: 12px;
    background-color: white;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.card-image {
    flex: 0 0 200px;          /* Lebar tetap 150px */
    max-width: 200px;
}

.card-image img {
    width: 100%;
    height: auto;
    border-radius: 12px;
}

.card-text {
    flex: 1;
    text-align: left;
}

.card-text h2 {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 12px;
    color: #111;
}

.card-text p {
    font-size: 15px;
    color: #7f8c8d;
    line-height: 1.5;
    max-width: 600px;
}

/* Responsive - jadi kolom saat layar kecil */
@media (max-width: 768px) {
    .card {
        flex-direction: column;
        align-items: center;
        gap: 20px;
        padding: 20px;
        text-align: center;
    }
    .card-image {
        flex: none;
        width: 120px;
        max-width: 120px;
    }
    .card-text h2 {
        font-size: 20px;
    }
    .card-text p {
        max-width: 100%;
    }
}



            /* /animasi           ---------------------/ */
    .carousel-container {
        width: 80%;
        max-width: 1200px;
        margin: 50px auto;
        overflow: hidden;
        gap: 50px;
        text-align: center;
        margin-top: 200px;
    }

    .carousel {
        display: flex;
        transition: transform 1s ease-in-out;
    }

    .carousel img {
        width: AUTO;
        height: 200PX;
        max-width: 100%;
        object-fit: cover;
    }

    /* CAROUSEL animation */
    @keyframes slide {
        0% {
            transform: translateX(0);
        }
        20% {
            transform: translateX(-100%);
        }
        40% {
            transform: translateX(-200%);
        }
        60% {
            transform: translateX(-300%);
        }
        80% {
            transform: translateX(-400%);
        }
        100% {
            transform: translateX(-500%);
        }
    }


    .carousel {
        animation: slide 200s infinite;
    }



    /* /SHOES CHART CSS/ */
    .chart {
        background-color: #7f8c8d; 
        color: #181B1E;               
        text-align: center;        
        padding: 20px;             
        border-radius: 8px;      
        width: 100%;       
        margin: 20px auto;   
        margin-top: 200px;   
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        margin-bottom: 30px;
    }


    .chart h1 {
        color: #f4f4f4;
    }

    .chart img {
        max-width: 98%;
        height: auto;
        border-radius: 6px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.25);
        
        cursor: pointer;
    }

    .chart img:hover {
        transform: scale(1.05); 
        box-shadow: 0 8px 16px rgba(0,0,0,0.4);
    }

    .closing {
        margin-top: 40px;
        margin-bottom: 40px;
        color: #f4f4f4;
    }


    /* /CHART/ */
    td:not(:first-child):hover {
    transform: scale(1.2);
    font-weight: bold;
    background-color: #3c3f42;
    transition: all 0.2s ease-in-out;
    z-index: 1;
    position: relative;
    box-shadow: 0 4px 10px rgba(0,0,0,0.4);
    }

    .CHART {
        background-color: #7f8c8d; /* warna background utama */
        color: #fff;
        text-align: center;
        border-radius: 80px;
        padding: 30px;
        margin-top: 120px;
    }
    .CHART h1 {
        font-weight: bold;
        margin-bottom: 20px;
        font-size: 42px;
        color: #fff;
    }
    /* Bungkus tabel agar bisa scroll horizontal */
    .table-container {
        margin: 0 auto;
        max-width: 100%;
        overflow-x: auto;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        border-radius: 8px;
        background-color: #7f8c8d; /* samakan dengan background utama */
        display: inline-block;
    }
    table {
        border-collapse: collapse;
        color: #fff;
        border-radius: 8px;
        overflow: hidden;
        min-width: 900px; /* supaya ada scroll kalau layar kecil */
    }
    th, td {
        padding: 12px 18px;
        border: 1px solid #4a4d50; /* border abu gelap */
        text-align: center;
        font-weight: normal;
        font-size: 18px;
        white-space: nowrap;
        background-color: #5f6266; /* latar abu gelap */
        color: #fff; /* teks putih */
    }
    /* Header dan footer */
    thead th {
        background-color: #43474b;
        font-weight: bold;
    }
    tfoot td {
        background-color: #43474b;
        font-weight: bold;
    }
    /* Kolom paling kiri */
    tbody td:first-child {
        font-weight: bold;
        text-align: left;
        padding-left: 18px;
    }
    /* Buat scroll halus */
    .table-container::-webkit-scrollbar {
        height: 8px;
    }
    .table-container::-webkit-scrollbar-track {
        background: #5f6266;
    }
    .table-container::-webkit-scrollbar-thumb {
        background-color: #888;
        border-radius: 4px;
    }
    p.note {
        margin-top: 30px;
        color: #eaeaea;
        font-size: 24px;
    }

    </style>
    
    </head>
    <body>
        
<div class="video-container">
    <iframe 
        width="100%" 
        height="auto" 
        src="https://drive.google.com/file/d/1194G5Lv7n-e2krHBEWbBS8HAJh6GZmYX/preview" 
        frameborder="0" 
        allow="autoplay; encrypted-media; fullscreen" 
        allowfullscreen
        style="border:none;">
    </iframe>
</div>

        <div class="container">
            <h1>WHY KICKIN ?!?!</h1>
            <div class="card">
                <div class="card-image">
                    <img src="{{ asset('images/store.jpg') }}" alt="Upper Canvas 12oz">
                </div>
                <div class="card-text">
                    <h2>YOUR ONE-STOP STORE</h2>
                    <p>We provide all your footwear needs, from running shoes, fashion shoes, walking shoes, and many more, with various brands from around the world..</p>
                </div>
            </div>

            <div class="card">
                <div class="card-image">
                    <img src="{{ asset('images/garansi.jpg') }}" alt="Ultralite Foam Insole">
                </div>
                <div class="card-text">
                    <h2>ON-TIME GUARANTEE</h2>
                    <p>On-time delivery guarantee, delivery within a maximum of 2 days after payment schedule, if the item is late, you get 200% money back.</p>
                </div>
            </div>

            <div class="card">
                <div class="card-image">
                    <img src="{{ asset('images/harga.jpg') }}" alt="Stitching">
                </div>
                <div class="card-text">
                    <h2>THE LOWEST PRICE IN INDONESIA</h2>
                    <p>Supplier prices directly from the factory, and the main and number one distributor in Indonesia. Guaranteed very cheap, guys!!</p>
                </div>
            </div>
        </div>

    
            <div class="carousel-container">
                <h1> OUR BRANDs</h1>
                <div class="carousel">
                    <img src="{{ asset('images/merk/adidas.jpg') }}" alt="Image 1">
                    <img src="{{ asset('images/merk/ardiles.jpg') }}" alt="Image 2">
                    <img src="{{ asset('images/merk/asics.jpg') }}" alt="Image 3">
                    <img src="{{ asset('images/merk/fila.jpg') }}" alt="Image 4">
                    <img src="{{ asset('images/merk/nike.jpg') }}" alt="Image 5">
                    <img src="{{ asset('images/merk/puma.jpg') }}" alt="Image 6">
                    <img src="{{ asset('images/merk/reebok.jpg') }}" alt="Image 6">
                    <img src="{{ asset('images/merk/vans.jpg') }}" alt="Image 6">
                    <img src="{{ asset('images/merk/ventela.jpg') }}" alt="Image 6">

                    <img src="{{ asset('images/merk/adidas.jpg') }}" alt="Image 1">
                    <img src="{{ asset('images/merk/asics.jpg') }}" alt="Image 3">
                    <img src="{{ asset('images/merk/fila.jpg') }}" alt="Image 4">
                    <img src="{{ asset('images/merk/nike.jpg') }}" alt="Image 5">
                    <img src="{{ asset('images/merk/puma.jpg') }}" alt="Image 6">
            </div>
    


    <div class="CHART">

    <h1>SHOES CHART</h1>

    <div class="table-container">
        <table>
        <thead>
            <tr>
            <th>EUR</th>
            <th>33</th>
            <th>34</th>
            <th>35</th>
            <th>36</th>
            <th>37</th>
            <th>38</th>
            <th>39</th>
            <th>40</th>
            <th>41</th>
            <th>42</th>
            <th>43</th>
            <th>44</th>
            <th>45</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <td>MEN’S</td>
            <td>2</td>
            <td>2.5</td>
            <td>3.5</td>
            <td>4.5</td>
            <td>5</td>
            <td>6</td>
            <td>6.5</td>
            <td>7.5</td>
            <td>8</td>
            <td>9</td>
            <td>10</td>
            <td>10.5</td>
            <td>11.5</td>
            </tr>
            <tr>
            <td>WO’S</td>
            <td>3.5</td>
            <td>4</td>
            <td>5</td>
            <td>6</td>
            <td>6.5</td>
            <td>7.5</td>
            <td>8</td>
            <td>9</td>
            <td>9.5</td>
            <td>10.5</td>
            <td>11.5</td>
            <td>12</td>
            <td></td>
            </tr>
            <tr>
            <td>UK</td>
            <td>1</td>
            <td>1.5</td>
            <td>2.5</td>
            <td>3.5</td>
            <td>4</td>
            <td>5</td>
            <td>5.5</td>
            <td>6.5</td>
            <td>7</td>
            <td>8</td>
            <td>9</td>
            <td>9.5</td>
            <td>10.5</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
            <td>CM</td>
            <td>21.2</td>
            <td>21.8</td>
            <td>22.5</td>
            <td>23.1</td>
            <td>23.8</td>
            <td>24.7</td>
            <td>25.2</td>
            <td>26.1</td>
            <td>26.5</td>
            <td>27.4</td>
            <td>28.3</td>
            <td>28.8</td>
            <td>29.6</td>
            </tr>
        </tfoot>
        </table>
    </div>

    <p class="note">Choose your size and checkout now! Become part of the Kickin Indonesia family..</p>

    </div>

    </body>

@endsection