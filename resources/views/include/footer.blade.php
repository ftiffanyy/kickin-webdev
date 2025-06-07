<style>
        body {
            margin: 0;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            font-size: large;
        }

    /* css footer */

    footer {
    background-color: #f5f5f5;
    padding: 30px 20px;
    text-align: left;
}

.footer-content {
    display: flex;
    justify-content: space-between;
    gap: 40px;
    flex-wrap: wrap;
}

.footer-column {
    width: 12%;
}

.footer-column h3 {
    margin-bottom: 10px;
    font-size: 18px;
    font-weight: bold;
}

.footer-column ul {
    list-style-type: none;
    padding: 0;
}

.footer-column ul li {
    margin: 5px 0;
}

.footer-column ul li a {
    text-decoration: none;
    color: #5f6266;
}

.footer-column ul li a:hover {
    color: #a5a9ae;
}


.footer-links {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
    background-color: #a5a9ae;
    text-align: center;
    width: 100%; 
    padding: 10px 0; 
    justify-content: center; 
}

    </style>
</head>
<body>

       <footer>
        <div class="footer-content">
            <div class="footer-column">
                <h3>ABOUT</h3>
                <ul>
                    <li><a href="{{ route('about') }}">about us</a></li>
                    <li><a href="{{ route('terms') }}">terms and conditions</a></li>
                  </ul>
            </div>
            <div class="footer-column">
                <h3>CUSTOMER SERVICE</h3>
                <ul>
                    <li><a href="{{ route('Privacy') }}">privacy policy</a></li>
                    <li><a href="{{ route('contact') }}">contact us</a></li>
                    <li><a href="{{ route('faq') }}">frequently asked question </a></li>

                </ul>
            </div>
            <div class="footer-column">
              
            </div>
        
              <div class="footer-column">
                <h3>SOCIAL</h3>
                <ul>
                    <li><a href="https://instagram.com/yourprofile" target="_blank" rel="noopener" style="font-size:30px; color:#E1306C; margin-right:10px;">
                        <i class="fab fa-instagram"></i>
                        </a></li>
                    <li><a href="https://wa.me/yourphonenumber" target="_blank" rel="noopener" style="font-size:30px; color:#25D366;">
                        <i class="fab fa-whatsapp"></i>
                        </a></li>
                    <li><a href="https://facebook.com/yourprofile" target="_blank" rel="noopener" style="font-size:30px; color:#1877F2; margin-right:10px;">
                        <i class="fab fa-facebook-f"></i>
                        </a></li>
                </ul>
            </div>


            <div class="footer-links">
                <span>© 2025 Kickin, Inc. All rights reserved</span>
            </div>
        </div>
    </footer>
        </div>
    </footer>
</body>