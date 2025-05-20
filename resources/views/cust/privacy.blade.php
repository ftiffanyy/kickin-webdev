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
      Home / <span>Privacy Policy - EN</span>
    </div>
    <h2>PRIVACY POLICY</h2>
    <strong>Effective since Feb 21, 2025.</strong>
    <p>
      This Privacy Policy explains how Universitas Ciputra ("we", "us") collect, use, and protect personal data of our service users. We are committed to safeguarding the privacy and security of the information you provide when using the Kickin website, application, or services.
    </p>

    <h2>Information We Collect</h2>
    <p>
      We collect personal data you provide directly such as name, email address, phone number, and purchase transaction details. Additionally, we may collect usage data like IP address, device type, and user activity to enhance service experience.
    </p>

    <h2>Use of Information</h2>
    <p>
      The data we collect is used to process orders, provide customer service, improve product and service quality, and send relevant promotional or update information.
    </p>

    <h2>Data Protection</h2>
    <p>
      We implement technical and organizational security measures to protect your personal data from unauthorized access, alteration, or disclosure.
    </p>

    <h2>Information Sharing</h2>
    <p>
      We do not share your personal data with third parties without consent unless required by law or for service purposes such as delivery by logistics partners.
    </p>

    <h2>Your Rights</h2>
    <p>
      You have the right to request access, correction, or deletion of your personal data we store in accordance with applicable laws.
    </p>

    <h2>Policy Changes</h2>
    <p>
      We may update this Privacy Policy from time to time. Changes will be announced on the website and effective from the specified date.
    </p>

    <p>
      If you have any questions about this Privacy Policy, please <a href="contact.html">contact us</a>.
    </p>
  </div>
</body>
@endsection