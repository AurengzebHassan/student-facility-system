<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  {{-- <!-- Bootstrap CDN --> --}}
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />
  {{-- <!-- Font Awesome CSS --> --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />

  {{-- <!-- Add your custom CSS file if needed --> --}}
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/slider.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/header.css') }}" />
  {{-- Icon --}}
  <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/Logjo.svg') }}?v={{ time() }}" />

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  {{-- <!-- Latest compiled and minified JavaScript --> --}}
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <title>Canteen Management System</title>
  <style>
   .dropdown-menu {
  display: none;
  position: absolute;
  top: 21px;
    right: 28px;
    left: -98px;
  background-color: #fff;
  border-radius: 5px;
  box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
}

.dropdown-menu li {
  list-style-type: none;
}

.dropdown-menu li a {
  display: block;
  padding: 10px;
  text-decoration: none;
  color: #333;
}

.dropdown-menu li a:hover {
  background-color: #f0f0f0;
}

.dropdown:hover .dropdown-menu {
  display: block;
}
.nav-links{
  padding: 10px 10px 14px 30px !important;
}
.account_user{
  font-family: Poppins;
/* font-size: 16px; */
font-style: normal;
font-weight: 600;
line-height: normal;
color:  #000;
}
.account_user i {
        font-size: 20px; /* Adjust the size as needed */
    }
    .account_user span {
        font-size: 16px; /* Adjust the size as needed */
    }
    .account_user:hover{
      text-decoration: none;
      color: #000
    }
    .privacy-policy-container {
      margin-top: 50px;
      padding-left: 15px;
      padding-right: 15px;
    }
    .section-heading {
      font-size: 24px;
      margin-bottom: 20px;
      font-weight: 600;
    }
    .information {
      font-size: 20px;
      margin-bottom: 20px;
    }
    .list-item {
      margin-left: 20px;
    }
    .bold-text {
      font-weight: bold;
      font-size: 16px
    }
    .contact-info {
      margin-top: 30px;
    }
    .contact-info p {
      margin-bottom: 5px;
    }
    @media screen and  (max-width: 350px) {
      .privacy-policy-container {
        width: 350px !important;
      }
      .section-heading {
      font-size: 20px;
      
    }
    .information {
      font-size: 16px;
    
    }
    }
  </style>
</head>

<body>

    <!-- Container with a maximum width of 1240 pixels -->
    <div class="container mx-auto" style="max-width: 1240px">
      <!-- Header Section -->
      <header class="container-fluid">
        <div class="row mt-2">
          <!-- Logo on the left corner -->
          <div class="col-md-2">
            <a href="/">
              <img src="{{ asset('assets/images/Logjo.svg') }}" alt="Logo" class="img-fluid" style="margin-top: 6px" />
            </a>
          </div>

          <!-- Links in the middle -->
          <div class="col-md-7 d-flex align-items-center justify-content-center hide-on-small-screens">
            
            <a href="/" class="nav-link font-weight-bold" >Home</a>
            <a href="{{ route('frontend.menu') }}" class="nav-link font-weight-bold">Menu</a>

            <a href="#contact" class="nav-link font-weight-bold">Contact</a>
            <a href="#about" class="nav-link font-weight-bold">About Us</a>
          </div>

          <!-- Icons and Login button on the right -->
          <div class="col-md-3 d-flex align-items-center justify-content-end">
        @if(session()->has('id'))
    <!-- Show user profile dropdown -->
    <div class="dropdown d-none d-md-block">
      <a href="#" class="account_user">
        <i class="far fa-user"></i> <span style="margin-left: 5px;">Account</span>
    </a>
    
        <ul class="dropdown-menu">
            <li><a href="{{ route('userprofile')}}">Profile</a></li>
            <li><a href="{{ route('orderhistory')}}">Order History</a></li>
            <li><a href="{{ route('user.logout') }}">Logout</a></li>
        </ul>
    </div>
    {{-- <p>User ID: {{ session('id') }}</p> --}}
    
@else
    <!-- Show login button -->
    <a href="{{ route('login') }}"> 
        <button class="btn btn-primary" style="
            font-family: Poppins;
            width: 146px;
            height: 40px;
            background-color: #ff2626;
            border: none;
            border-radius: 10px;
        ">
            Login
        </button>
    </a>
@endif

        </div>
        
          <!-- Toggle Button for Small Screens -->
          <div class="toggle-button d-md-none" onclick="toggleSidebar()">
            <span class="icon">
              <i class="fas fa-bars fa-lg"></i>
            </span>
          </div>
        </div>
      </header>

      <!-- Sidebar for Small Screens -->
      <aside class="sidebar d-none">
        <button class="close-button" onclick="toggleSidebar()">
          <span class="icon">
            <i class="fas fa-times fa-lg"></i>
          </span>
        </button>
        <!-- Sidebar Content (Copy your navigation links here) -->
        <a href="/" class="nav-link nav-links active font-weight-bold" style="border-bottom: 2px solid #ff6826">Home</a>
        <a href="{{ route('frontend.menu') }}" class="nav-link nav-links font-weight-bold">Menu</a>
        <a href="#contact" class="nav-link nav-links font-weight-bold">Contact</a>
        <a href="#about" class="nav-link nav-links font-weight-bold">About Us</a>
        @if(session()->has('id'))
        <!-- Show navigation links when session has 'id' data -->
        <a class="nav-link font-weight-bold nav-links" href="{{ route('userprofile')}}" style="color: #000000;">Profile</a>
        <a class="nav-link font-weight-bold nav-links" href="{{ route('orderhistory')}}" style="color: #000000;">Order History</a>
        <a class="nav-link font-weight-bold nav-links" href="{{ route('user.logout') }}" style="color: #000000;">Logout</a>
    @else
        <!-- Show login button when session does not have 'id' data -->
        <a class="nav-link font-weight-bold nav-links " href="{{ route('login') }}" style="color: #000000;">Login</a>
    @endif
    

      </aside>
    </div>
    <!-- End of the container -->
 

<div style="background-color: #f9fafba1; ">
  <div class="container privacy-policy-container" >
    <h1 class="section-heading">Privacy Policy</h1>
    <p class="information">
        Thank you for exploring <strong>Canteen Ease</strong>. Safeguarding your privacy is paramount to us, and we prioritize it deeply. This Privacy Policy page is crafted to provide clarity on how we gather, utilize, and safeguard your personal information while you engage with our services.</p>
    <h2 class="section-heading">Information We Collect</h2>
    <p class="information">We gather data that you furnish to us directly, including your name, email address, phone number, and any additional details you opt to share. Additionally, we may gather information regarding your interactions with our website and services.</p>
    <h2 class="section-heading">Use of Information</h2>
    <p class="information">
        We utilize the gathered information to enhance and refine our services, to establish communication with you, to tailor your experience, and to fulfill legal obligations. Additionally, we may seek your consent to employ your information for sending marketing communications that we deem relevant to your interests. You retain the option to opt out of receiving marketing communications from us at any juncture.</p>
    <h2 class="section-heading">Disclosure of Information</h2>
    <p class="information">
        We might disclose your information to our service providers, such as hosting providers and payment processors, to facilitate the provision and enhancement of our services. Your information may also be shared with our affiliates and subsidiaries for purposes aligned with this Privacy Policy. Furthermore, we may divulge your information as mandated by law, such as in response to a subpoena or other legal proceedings, or to safeguard our rights or the rights of others.</p>
    <h2 class="section-heading">Data Security</h2>
    <p class="information">
        We implement reasonable measures to safeguard your personal information against unauthorized access, usage, or disclosure. However, it's important to note that no method of data transmission over the internet or electronic storage system can be guaranteed to be completely secure. Consequently, while we strive to uphold stringent security protocols, we cannot guarantee the absolute security of your personal information.</p>
    <h2 class="section-heading">Data Retention</h2>
    <p class="information">
      We will retain your information for the duration necessary to fulfill our service obligations, adhere to legal requirements, resolve disputes, and enforce our agreements. Once the information is no longer required for these purposes, we will securely delete or destroy it.</p>
    <h2 class="section-heading">Changes and Updated to this Privacy Policy</h2>
    <p class="information">We reserve the right to periodically update this Privacy Policy. In the event of any significant changes, we will notify you via email or by posting a notice on our website. Your continued utilization of our services subsequent to any alterations to this Privacy Policy signifies your acceptance of such modifications.</p>
    <div class="contact-info">
      <h2 class="section-heading">Contact Us</h2>
      <p class="information">If you have any questions or concerns about our Privacy Policy, please contact us at <a href="mailto:canteeneasee@gmail.com">canteeneasee@gmail.com</a> or visit our office.</p>
      {{-- <p class="information bold-text">Canteen Ease</p> --}}
      <p class="information">Address: <b>Thal Universty Bhakkar</b> </p>
      <p class="information">Email: <a href="mailto:canteeneasee@gmail.com">canteeneasee@gmail.com</a></p>
    </div>
    
  </div>
</div>
  <!-- Footer section start -->
  <div class="footer-background " style="background-color: #ede8f3; margin-top:80px">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-lg-3 mt-5">
          <a href="/"> <img src="{{ asset('assets/images/Logjo.svg')}}" alt="logo" /></a>
          <h3 class="mt-3 footer-heading">Follow Us:</h3>
          <div class="footer-social-icons mt-3">
            <a href="https://www.facebook.com/profile.php?id=100011332284002" target="_blank">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 mt-3">
          <h3 class="footer-second-heading">Quick Links:</h3>
          <div class="footer-nav">
            <a href="/">Home</a>
            <a href="#about">About</a>
            <a href="#contact">Contact Us</a>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <h3 class="mt-5 footer-third-heading">Legal:</h3>
          <div class="footer-nav">
            <a href="{{ route ('privacy.policy')}}">Privacy Policy</a>
            {{-- <a href="#">Terms of Service</a> --}}
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <h3 class="mt-5 footer-forth-heading">Subscribe</h3>
          <p class="footer-paragraph">
            Subscribe to our Newsletter to get latest <br />
            news from us.
          </p>
          <div class="form-group">
            <input type="email" class="form-control footer-input-field" id="email" placeholder="Email" autocomplete="off" style="
                  width: 250px;
                  height: 55px;
                  border-radius: 10px;
                  border: 1px solid var(--foundation-red-red-300, #FF6E6E);
                " />
          </div>
          <button class="btn footer-btn text-white mb-2">Subscribe</button>
        </div>
      </div>
    </div>
  </div>
  <div class="last-section" style="background-color: #dcd8e2; height: 50px; font-size: 15px; ">
    <div class="container">
      <p style="
            padding-top: 20px;
            font-size: 16px;
            color: #000000;
            font-family: Inter;
          ">
        Copyright © 2024 Canteen Ease. All Rights Reserved.
      </p>
    </div>
  </div>

</body>
<!-- Include Bootstrap, Font Awesome, and other scripts at the end of the body -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="{{ asset('js/index.js') }}"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script>
  function toggleSidebar() {
    var sidebar = document.querySelector(".sidebar");
    sidebar.classList.toggle("d-none");
  }
  
</script>
</html>