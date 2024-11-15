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
    /* .account_user:active{
      text-decoration: none;
      color: #000
    } */
  </style>
</head>

<body>
  <!-- Background Container -->
  <div class="background-container" style="animation: fadeInUp 2s ease-out;" >
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
            <a href="/" class="nav-link active font-weight-bold" style="border-bottom: 2px solid #ff6826">Home</a>
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

      <!-- Hero Section -->
      <section class="container-fluid hero-section">
        <div class="row">
          <!-- Left Side -->
          <div class="col-md-6 text-left">
            <div class="hero-title">
              Where Every Bite Tells <br />
              a <strong style="color: #ff2626">Delicious</strong> Story
            </div>
            <div class="hero-description">
              At CanteenEase, we craft more than meals; we curate <br />
              experiences. Immerse yourself in a culinary journey <br />
              that transforms every bite into a delightful narrative.
            </div>

            <a href="{{ route('frontend.menu')}}" class="cta-button">Explore Menu</a>

            <!-- Video CTA -->
            <a href="#" class="video-button">
              <div class="video-container">
                <div class="video-icon" style="background-color: #dddddd">
                  <i class="fas fa-play"></i>
                </div>
                <div class="watch-video font-weight-bold text-decoration-none">
                  Watch Video
                </div>
              </div>
            </a>
          </div>

          <!-- Right Side -->
          <div class="col-md-6 text-center">
            <img src="assets\images\Hero right image.svg" alt="Hero Image" class="img-fluid hero-image" />
          </div>
        </div>
      </section>
    </div>
    <!-- End of the container -->
  </div>
  <!-- End of the background container -->

  <!-- Popular Food Categories section start -->

  <div class="food-category-background" style="animation: fadeInUp 2s ease-out;">
    <div class="container">
      <div class="row" id="slider-text">
        <div class="">
          <h1 class="mb-4 category-heading">
            <span style="color: #ff6826">Popular</span> Food Categories
            <div class="float-right" style="margin-right: 8px">
              <button class="right" href="#itemslider" data-slide="prev" style="
                    border: none;
                    margin-right: 10px;
                    font-size: 25px;
                    background-color: white;
                    font-family: Inter;
                  ">
                &#8249;
              </button>
              <button class="left" href="#itemslider" data-slide="next" style="
                    border: none;
                    margin-left: 10px;
                    color: #ff2626;
                    font-size: 25px;
                    background-color: white;
                    font-family: Inter;
                  ">
                &#8250;
              </button>
            </div>
          </h1>
        </div>
      </div>
    </div>

    <!-- Item slider-->
    <div class="container" >
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="carousel carousel-showmanymoveone slide" id="itemslider">
            <div class="carousel-inner">
              <!-- 1 -->
              <div class="item active">
                <div class="col-sm-3 col-md-3 mb-3">
                  <div class="card shadow popular-food-card">
                    <div class="card-body popular-food-card-body">
                      <img class="food-menu-images" src="./assets/foodmenu/Ellipse15.png" alt="pizza-image" width: 50px;
                        height: 50px;>
                      <h5 class="card-title popular-food-card-title">
                        Pizza
                      </h5>
                      <p class="card-text popular-food-card-text">
                        24 Items Available
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <!-- 2 -->
              <div class="item">
                <div class="col-sm-3 col-md-3 mb-3">
                  <div class="card shadow popular-food-card">
                    <div class="card-body popular-food-card-body">
                      <img class="food-menu-images" src="./assets/foodmenu/Ellipse16.png" alt="Burger-image" width:
                        50px; height: 50px;>
                      <h5 class="card-title popular-food-card-title">
                        Burger
                      </h5>
                      <p class="card-text popular-food-card-text">
                        56 Items Available
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <!-- 3 -->

              <div class="item">
                <div class="col-sm-3 col-md-3 mb-3">
                  <div class="card shadow popular-food-card">
                    <div class="card-body popular-food-card-body">
                      <img class="food-menu-images" src="./assets/foodmenu/Ellipse 17.png" alt="Fries-image" width:
                        50px; height: 50px;>
                      <h5 class="card-title popular-food-card-title">
                        Juice
                      </h5>
                      <p class="card-text popular-food-card-text">
                        40 Items Available
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <!-- 4 -->
              <div class="item">
                <div class="col-sm-3 col-md-3 mb-3">
                  <div class="card shadow popular-food-card">
                    <div class="card-body popular-food-card-body">
                      <img class="food-menu-images" src="./assets/foodmenu/Ellipse19.png" alt="Fries-image" width: 50px;
                        height: 50px;>
                      <h5 class="card-title popular-food-card-title">
                        Fries
                      </h5>
                      <p class="card-text popular-food-card-text">
                        40 Items Available
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <!-- 5 -->
              <div class="item">
                <div class="col-sm-3 col-md-3 mb-3">
                  <div class="card shadow popular-food-card">
                    <div class="card-body popular-food-card-body">
                      <img class="food-menu-images" src="./assets/foodmenu/Ellipse18.png" alt="Biryani-image" width:
                        50px; height: 50px;>
                      <h5 class="card-title popular-food-card-title">
                        Biryani
                      </h5>
                      <p class="card-text popular-food-card-text">
                        30 Items Available
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Popular Food Categories section End -->

  <!-- How Works  start-->

  <div class="work-background mt-5" style="animation: fadeInUp 2s ease-out;">
    <h1 class="mt-5 mb-5 How-It-Works">How It Works?</h1>

    <!-- Card Section -->
    <div class="container mt-3">
      <div class="row section-3-row">
        <!-- Card 1 -->
        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
          <div class="card card-work">
            <svg xmlns="http://www.w3.org/2000/svg" width="110" height="110" viewBox="0 0 110 110" fill="none">
              <circle cx="55" cy="55" r="55" fill="#FFE9E9" />
            </svg><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50" fill="none">
              <path
                d="M21.8224 39H31.7705C33.784 39 35.4163 37.433 35.4163 35.5V27.5C35.4163 25.567 33.784 24 31.7705 24H18.2288C17.7272 24 17.2491 24.0972 16.8141 24.2732C15.2157 23.4604 13.3928 23 11.458 23C10.3747 23 9.3264 23.1444 8.33301 23.414V9C8.33301 6.79086 10.1985 5 12.4997 5H24.9997V17C24.9997 19.2091 26.8651 21 29.1663 21H41.6663V41C41.6663 43.2092 39.8009 45 37.4997 45H27.0459C26.9378 44.2774 26.5943 43.581 26.0151 43.0252L21.8224 39ZM32.2913 33V35.5C32.2913 35.7762 32.0582 36 31.7705 36H23.958V33H32.2913ZM23.958 30V27H31.7705C32.0582 27 32.2913 27.2238 32.2913 27.5V30H23.958ZM28.1247 6V17C28.1247 17.5523 28.5911 18 29.1663 18H40.6247L28.1247 6ZM19.0998 39.2148C20.1912 37.7436 20.833 35.9438 20.833 34C20.833 29.0294 16.6357 25 11.458 25C6.28034 25 2.08301 29.0294 2.08301 34C2.08301 38.9706 6.28034 43 11.458 43C13.4827 43 15.3576 42.3838 16.8901 41.3362L22.3324 46.5606C22.9426 47.1464 23.9318 47.1464 24.542 46.5606C25.1522 45.9748 25.1522 45.0252 24.542 44.4394L19.0998 39.2148ZM17.708 34C17.708 37.3138 14.9098 40 11.458 40C8.00624 40 5.20801 37.3138 5.20801 34C5.20801 30.6862 8.00624 28 11.458 28C14.9098 28 17.708 30.6862 17.708 34Z"
                fill="#FE6700" />
            </svg>
            <div class="card-body">
              <h5 class="card-title card-title-work text-center">
                Browse the Menu
              </h5>
            </div>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
          <div class="card card-work">
            <div class="Work-section-svg">
              <svg xmlns="http://www.w3.org/2000/svg" width="110" height="110" viewBox="0 0 110 110" fill="none">
                <circle cx="55" cy="55" r="55" fill="#FFE9E9" />
              </svg>

              <!-- Shopping Cart Icon Path -->
              <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50" fill="none">
                <path
                  d="M5.20801 8.85416C5.20801 7.99123 5.90757 7.29166 6.77051 7.29166H7.93355C9.91369 7.29166 11.0993 8.62289 11.7773 9.86039C12.2292 10.6853 12.5561 11.642 12.8118 12.5082C12.881 12.5028 12.9512 12.5 13.0222 12.5H39.0582C40.7878 12.5 42.0368 14.155 41.5626 15.8183L37.7547 29.1706C37.053 31.6317 34.8043 33.3287 32.2453 33.3287H19.8534C17.2732 33.3287 15.0113 31.604 14.3285 29.1158L12.7441 23.3427L10.122 14.4912L10.1178 14.4757C9.79342 13.2927 9.48899 12.1876 9.03661 11.3619C8.5973 10.56 8.24711 10.4167 7.93355 10.4167H6.77051C5.90757 10.4167 5.20801 9.7171 5.20801 8.85416ZM18.7497 43.75C21.0509 43.75 22.9163 41.8846 22.9163 39.5833C22.9163 37.2821 21.0509 35.4167 18.7497 35.4167C16.4485 35.4167 14.583 37.2821 14.583 39.5833C14.583 41.8846 16.4485 43.75 18.7497 43.75ZM33.333 43.75C35.6343 43.75 37.4997 41.8846 37.4997 39.5833C37.4997 37.2821 35.6343 35.4167 33.333 35.4167C31.0318 35.4167 29.1663 37.2821 29.1663 39.5833C29.1663 41.8846 31.0318 43.75 33.333 43.75Z"
                  fill="#FE6700" />
              </svg>
            </div>
            <div class="card-body d-flex flex-column align-items-center">
              <h5 class="card-title card-title-work text-center">
                Place an Order
              </h5>
            </div>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
          <div class="card card-work">
            <svg xmlns="http://www.w3.org/2000/svg" width="110" height="110" viewBox="0 0 110 110" fill="none">
              <circle cx="55" cy="55" r="55" fill="#FFE9E9" />
            </svg><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50" fill="none">
              <path
                d="M10.9373 10.4167C7.1979 10.4167 4.1665 13.4481 4.1665 17.1875V19.7917H45.8332V17.1875C45.8332 13.4481 42.8017 10.4167 39.0623 10.4167H10.9373ZM45.8332 22.9167H4.1665V32.8125C4.1665 36.5519 7.1979 39.5833 10.9373 39.5833H39.0623C42.8017 39.5833 45.8332 36.5519 45.8332 32.8125V22.9167ZM32.8123 30.2083H38.0207C38.8836 30.2083 39.5832 30.9079 39.5832 31.7708C39.5832 32.6337 38.8836 33.3333 38.0207 33.3333H32.8123C31.9494 33.3333 31.2498 32.6337 31.2498 31.7708C31.2498 30.9079 31.9494 30.2083 32.8123 30.2083Z"
                fill="#FE6700" />
            </svg>
            <div class="card-body">
              <h5 class="card-title card-title-work text-center">
                Confirm and Pay
              </h5>
            </div>
          </div>
        </div>

        <!-- Card 4 -->
        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
          <div class="card card-work">
            <svg class="" xmlns="http://www.w3.org/2000/svg" width="110" height="110" viewBox="0 0 110 110" fill="none">
              <circle cx="55" cy="55" r="55" fill="#FFE9E9" />
            </svg><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50" fill="none">
              <path
                d="M26.6971 25.4102L11.007 28.0252C10.6395 28.0865 10.3327 28.3394 10.2024 28.6883L4.79012 43.1829C4.27205 44.5152 5.66668 45.786 6.94516 45.1469L22.934 37.1525C22.9223 36.9225 22.9165 36.691 22.9165 36.4583C22.9165 28.9794 28.9792 22.9167 36.4582 22.9167C39.694 22.9167 42.6648 24.0517 44.9942 25.9452C45.5515 25.2115 45.3686 24.0635 44.4451 23.6017L6.94516 4.85177C5.66668 4.21252 4.27205 5.48345 4.79012 6.81562L10.2024 21.3102C10.3327 21.6592 10.6395 21.9121 11.007 21.9733L26.6971 24.5883C26.924 24.626 27.0773 24.8408 27.0396 25.0677C27.0103 25.2433 26.8728 25.381 26.6971 25.4102ZM36.4582 25C42.7865 25 47.9165 30.13 47.9165 36.4583C47.9165 42.7867 42.7865 47.9167 36.4582 47.9167C30.1298 47.9167 24.9998 42.7867 24.9998 36.4583C24.9998 30.13 30.1298 25 36.4582 25ZM40.6248 36.4585H36.4582V31.2498C36.4582 30.6746 35.9917 30.2081 35.4165 30.2081C34.8413 30.2081 34.3748 30.6746 34.3748 31.2498V37.4969V37.5002C34.3748 38.0754 34.8413 38.5419 35.4165 38.5419H40.6248C41.2001 38.5419 41.6665 38.0754 41.6665 37.5002C41.6665 36.9248 41.2001 36.4585 40.6248 36.4585Z"
                fill="#FE6700" />
            </svg>
            <div class="card-body">
              <h5 class="card-title card-title-work text-center">
                Enjoy Quick Delivery
              </h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Work section End -->

  <!-- Testominal Section Strat -->
  <div class="customer-background" style="animation: fadeInUp 2s ease-out;">
    <div class="mt-5">
      <h2 class="testimonials-heading">Testimonials</h2>
      <p class="testimonials-paragraph mt-3">
        What Our Customers Have to Say
      </p>
      <div class="container">
        <div class="row">
          <!-- First Review -->
          <div class="col-md-4 customer-image">
            <img src="./assets/images/Ellipse 24.png" alt="Customer-Image" class="img-fluid" width: 303px; height:
              303px;>
          </div>
          <div class="col-md-8 mt-3">
            <q class="customer-review">
              CanteenEase made ordering my lunch a breeze! The food was
              delicious, and it arrived right on time. I love the variety in
              the menu. The quality of the food is top-notch. Highly
              recommended!
            </q>
            <h5 class="mt-3 customer-review-heading">Muhammad Usama</h5>
            <p class="customer">Customer</p>
            <div class="rating">
              <span class="star">&#9733;</span>
              <span class="star">&#9733;</span>
              <span class="star">&#9733;</span>
              <span class="star">&#9733;</span>
              <span class="star">&#9733;</span>
            </div>
            <div>
              <!-- second Review -->
              <div id="secondReview" style="display: none">
                <div class="col-md-4 customer-image">
                  <img src="./assets/images/Ellipse 24.png" alt="Customer-Image" class="img-fluid" width: 303px; height:
                    303px;>
                </div>
                <div class="col-md-8 mt-3">
                  <q class="customer-review">
                    CanteenEase made ordering my lunch a breeze! The food was
                    delicious, and it arrived right on time. I love the
                    variety in the menu. The quality of the food is top-notch.
                    Highly recommended!
                  </q>
                  <h5 class="mt-3 customer-review-heading">Muhammad Usama</h5>
                  <p class="customer">Customer</p>
                  <div class="rating">
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                  </div>
                </div>
              </div>
              <!-- Right Arrow Button -->
              {{-- <button class="btn moving-button float-right active-button" onclick="toggleReviews('right')">
                &#8250;
              </button> --}}
              <!-- Left Arrow Button -->
              {{-- <button class="btn moving-button float-right mr-2" onclick="toggleReviews('left')">
                &#8249;
              </button> --}}
              <!-- Read More Reviews Button -->
              {{-- <button class="btn review-btn mt-2 " >
                Read more Reviews
              </button> --}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Testominal Section End -->
  <hr />
  <!-- About section start -->
  <div class="about-background " id="about" style="animation: fadeInUp 2s ease-out;">
    <!-- style="background-color: #f6f7f9" -->
    <div class="container mt-5">
      <div class="row">
        <div class="col-md-8 overflow-hidden">
          <h2 class="about-heading mt-5 display-4 display-md-2">About Us</h2>
          <p class="about-paragraph lead lead-md">
            Experience the perfect blend of convenience and culinary delight
            at CanteenEase. We are a passionate team committed to providing a
            seamless dining experience that caters to your cravings.
          </p>
          <div class="">
            <h4 class="about-heading2 mt-5">Key Features</h4>
            <div>
              <ul class="two-column-list">
                <li>Quick and Easy Ordering</li>
                <li>Diverse Menu Options</li>
                <li>Quality Ingredients</li>
                <li>Swift and Reliable Service</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-4 mt-5 about-image">
          <img src="./assets/images/about.svg" alt="aboutimage" class="img-fluid" />
        </div>
      </div>
    </div>
  </div>
  <!-- About section end -->
  <hr />
  <!-- Team section start -->

  <div class="team-background mt-5" style="animation: fadeInUp 2s ease-out;">
    <div class="container">
      <h2 class="team-heading mb-5">Meet Our Team</h2>

      <div class="row">
        <!-- First Card -->
        <div class="col-md-4 mt-3">
          <div class="card team-cards">
            <img src="./assets/team/Union (1).png" class="card-img-top" alt="Team Member 1" />
            <div class="card-body d-flex flex-column align-items-center">
              <h5 class="card-title team-card-heading">Kristin Watson</h5>
              <p class="card-text team-card-paragraph">Founder & CEO</p>
            </div>
          </div>
        </div>

        <!-- Second Card -->
        <div class="col-md-4 mt-3">
          <div class="card team-cards">
            <img src="./assets/team/Union (2).png" class="card-img-top" alt="Team Member 2" />
            <div class="card-body d-flex flex-column align-items-center">
              <h5 class="card-title team-card-heading">Esther Howard</h5>
              <p class="card-text team-card-paragraph">Head Chef</p>
            </div>
          </div>
        </div>

        <!-- Third Card -->
        <div class="col-md-4 mt-3">
          <div class="card team-cards">
            <img src="./assets/team/Union.png" class="card-img-top" alt="Team Member 3" />
            <div class="card-body d-flex flex-column align-items-center">
              <h5 class="card-title team-card-heading">Robert Fox</h5>
              <p class="card-text team-card-paragraph">Operations Manager</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Team section end -->

  <!-- Order section start -->

  <div class="container ordersection-container" style="margin-top: 100px; animation: fadeInUp 2s ease-out;" >
    <div class="row">
      <div class="col-md-7 col-md-7-order">
        <h2 class="order-heading">Start Ordering with <br />CanteenEase</h2>
        <p class="order-paragraph mt-4">
          Experience the Convenience of <br />
          online Food ordering
        </p>
        <div class="">
          <a href="{{ route('frontend.menu')}}" class="btn mt-5 order-btn text-white">Get Started</a>

        </div>
      </div>
      <div class="col-md-5 mt-5 order-image">
        <img src="./assets/images/Get Started.svg" alt="aboutimage" class="img-fluid" />
      </div>
    </div>
  </div>
  <!-- Order section end -->

  <!-- Contact section start -->

  <div class="container" id="contact" style="margin-top: 70px; animation: fadeInUp 2s ease-out">
    <h2 class="contact-heading">Contact Us</h2>
    <div class="contact-background">
      <div class="row">
        <div class="col-md-6 contact-image text-center">
          <img src="\assets\images\Contact Us left.svg" alt="contactimage" />
        </div>
        <div class="col-md-6 mt-5 text-center text-md-left">
          {{-- form start --}}
          <form style="margin-top: 30px" class="" action="{{ route('customer_review') }}" method="post"
            onsubmit="return formValidation();">
            @csrf 
            @include('sweetalert::alert')
            <div class="form-group">
              <input type="text" class="form-control" name="name" id="name" placeholder="Name" autocomplete="name"/>
              <span id="nameError" class="text-danger input-message"></span>
            </div>
            <div class="form-group">
              <input type="email" class="form-control" name="email" id="email" placeholder="Email" autocomplete="off" />
              <span id="emailError" class="text-danger input-message"></span>
            </div>
            <div class="form-group">
              <textarea class="form-control" id="message" name="message" rows="4" placeholder="Message..." autocomplete="off"></textarea>
              <span id="messageError" class="text-danger input-message"></span>
            </div>
            <button type="submit" class="btn contact-btn text-white">
              Submit
            </button>
          </form>
          {{-- form end --}}
        </div>
      </div>
    </div>
  </div>
  <!-- Contact section end -->

  <!-- Footer section start -->
  <div class="footer-background " style="background-color: #ede8f3; margin-top: 80px;  animation: fadeInUp 2s ease-out;">
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
  <div class="last-section" style="background-color: #dcd8e2; height: 50px; font-size: 15px;  animation: fadeInUp 2s ease-out;">
    <div class="container">
      <p style="
            padding-top: 20px;
            font-size: 16px;
            color: #000000;
            font-family: Inter;
          ">
        Copyright © 2024 Student Facility. All Rights Reserved.
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