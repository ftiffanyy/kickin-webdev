@extends('base.base')

@section('content')
<style>
    body {
      font-family: Arial, sans-serif;
      background-color: #fff;
      margin: 0;
      padding: 20px 40px;
      color: #000;
      animation: fadeIn 1s ease forwards;
      box-sizing: border-box;
    }
    @keyframes fadeIn {
      from {opacity: 0;}
      to {opacity: 1;}
    }
    .container {
      max-width: 900px;
      margin: 40px auto;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      padding: 25px 30px;
      border-radius: 6px;
      background-color: #fff;
    }
    .breadcrumb {
      font-size: 14px;
      color: #555;
      margin-bottom: 20px;
    }
    .breadcrumb span {
      font-weight: 600;
    }
    h2 {
      font-size: 18px;
      font-weight: 700;
      margin-bottom: 15px;
    }
    p, strong {
      font-size: 14px;
      line-height: 1.6;
      margin-bottom: 15px;
    }
    strong {
      font-weight: 700;
    }
    a {
      font-weight: 700;
      color: #000;
      text-decoration: underline;
      cursor: pointer;
    }
    a:hover {
      color: #007BFF;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="breadcrumb">
      Home / <span>TERMS AND CONDITIONS - EN</span>
    </div>
    <h2>TERMS AND CONDITIONS</h2>
    <strong>Effective since Jun 2024.</strong>
    <p>
      This site is owned and operated by Universitas Ciputra and these Terms and Conditions apply to visitors and users of Kickin website. The term "We" refers to Universitas Ciputra that provides this site to you, and "You" refers to the users who accept these Terms and Conditions. If you do not agree to these Terms and Conditions, please do not use this site.
    </p>

    <h2>Eligibility</h2>
    <p>
      As a user and to place an order on Kickin, you must be at least 17 (seventeen) years old. If you are under 17, you can only place orders with the involvement of your parent or guardian. If you do not have approval and involvement of your parent or guardian, you must stop using the site.
    </p>

    <h2>Privacy Policy</h2>
    <p>
      You agree that all personal information provided to Kickin via website, email, phone, or other communication means is truly your own and not third-party information obtained without lawful permission. You acknowledge having read and understood our Privacy Policy and agree to all its terms. Specifically, you agree and grant us permission to collect, process, analyze, store, disclose, transfer, and delete your personal information according to our Policy. Please visit <a href="#">Privacy Policy</a> to access our latest Privacy Policy.
    </p>

    <h2>License and Site Access</h2>
    <p>
      Kickin and all content on this site are owned by Universitas Ciputra, licensors, or content providers, and protected by copyright, trademarks, and applicable domestic and international laws and regulations. Kickin grants you a limited license to access and use the Kickin site for personal and non-commercial purposes.
    </p>
  </div>
</body>
@endsection