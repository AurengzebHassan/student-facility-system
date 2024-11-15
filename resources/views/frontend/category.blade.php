<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstarp cdn -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />

    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/Logjo.svg') }}?v={{ time() }}" />
       <!-- css--file -->
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <title>Canteen Management System</title>
    <style>
    .buy-now-btn:hover{
      color: #ff6826
    } 

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
  font-family: Poppins;
}

.dropdown-menu li a:hover {
  background-color: #f0f0f0;
}

.dropdown:hover .dropdown-menu {
  display: block;
}

.search-form .input-group {
    position: relative;
}

.search-form .input-group-append {
    position: absolute;
    right: 0;
    top: 0;
    bottom: 0;
    z-index: 3;
    display: flex;
    align-items: center;
    padding: 0;
}

.search-form .input-group-append .btn {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}
  .menu-search-button{
    margin-right: 10px;
    background-color: #EDE8F3;
    
  }
  
.nav-links{
  padding: 10px 10px 14px 30px !important;
}
.nav-link:hover{
 color: #ff6826 !important;
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
    a{
        text-decoration: none !important;
    }
    a:hover{
        text-decoration: none !important;
    }
    </style>
</head>
<body>
    {{--  navbar start  --}}
    <div class="header-section" style="margin-top: 4.7px;">
    <header class="container mx-auto"  style="max-width: 1240px">
      <div class="container-fluid">
        <div class="row mt-2">
          <!-- Logo on the left corner -->
          <div class="col-md-2">
            <a href="/">
              <img src="{{ asset('assets/images/Logjo.svg')}}" alt="Logo" class="img-fluid" width: 97px;
              height: 84.967px; /></a>
          </div>

          <!-- Links in the middle -->
          <div class="col-md-7 d-flex align-items-center justify-content-center hide-on-small-screens">
            <a href="/" class="nav-link  font-weight-bold" >Home</a>
            <a href="{{ route('frontend.menu')}}" class="nav-link active font-weight-bold" style="border-bottom: 2px solid #ff6826; color: #ff6826">Menu</a>
            <a href="/" class="nav-link font-weight-bold">Contact</a>
            <a href="/" class="nav-link font-weight-bold" id="aboutLink">About Us</a>
          </div>

          <!-- Icons and Login button on the right -->
          <div class="col-md-3 d-flex align-items-center justify-content-end">
         @if(session()->has('id'))
    {{-- <!-- Show user profile dropdown --> --}}
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
    {{-- <!-- Show login button --> --}}
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
            <i class="fas fa-bars fa-lg"></i>
          </div>
        </div>
      </div>
      
    
      <!-- Sidebar for Small Screens -->
      <aside class="sidebar d-none">
        <button class="close-button" onclick="toggleSidebar()">
          <span class="icon">
            <i class="fas fa-times fa-lg"></i>
          </span>
        </button>
        <!-- Sidebar Content (Copy your navigation links here) -->
        <a href="/" class="nav-link nav-links font-weight-bold">Home</a>
        <a href="{{ route('frontend.menu') }}" class="nav-link nav-links active font-weight-bold"  style="border-bottom: 2px solid #ff6826; color: #ff6826;">Menu</a>
        <a href="/" class="nav-link nav-links font-weight-bold">Contact</a>
        <a href="/" class="nav-link nav-links font-weight-bold">About Us</a>
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
    </header>
    </div>
       <!-- navbar end -->

       <!-- search button -->
       <div class="search-section">
        <div class="container">
            <div class="row height d-flex justify-content-center align-items-center">
                <div class="col-md-6">
                    <div class="form search-form">
                        <form action="{{ route('frontend.menu') }}" method="get">
                            <div class="input-group">
                                <input type="text" id="searchInput" style="border-radius: 20px;" class="form-control form-input" name="search" value="{{ $searchQuery }}" placeholder="Search anything...">
                                <div class="input-group-append">
                                    <button style="border-radius: 8px;" type="submit" class="btn menu-search-button">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
      <!-- search button -->

      <!-- Menu section start -->
      <div class="items-section">
      <div class="container">
        <h1 class="menu-heading"><span style="color: #ff6826;">Our</span> Menu</h1>
        <div class="moving-btn float-right ">
          <button class="right" href="#itemslider" data-slide="prev" style="
              border: none;
              margin-right: 10px;
              font-size: 28px;
              background-color: white;
              font-family: Inter;
              ">
              &#8249;
          </button>
          <button class="left" href="#itemslider" data-slide="next" style="
              border: none;
              margin-left: 10px;
              color: #ff2626;
              font-size: 28px;
              background-color: white;
              font-family: Inter;
              ">
              &#8250;
          </button>
      </div>
        <div class="row">
            <div class="items-btn" id="categorySlider">
            <a href="{{ route('frontend.menu') }}">   <span type="button" class="btn  menu-items-btn">All Items</span> </a> 
                @foreach ($categories as $categoryItem)
                <a href="{{ route('frontend.menu.category', ['category' => $categoryItem->id]) }}">
                    <span type="button" class="btn {{ isset($category) && $category && $category->id == $categoryItem->id ? 'active' : '' }} menu-items-btn">{{ $categoryItem->name }}</span>
                </a>
            @endforeach
            


            </div>
        </div>
      
        <!-- Bootstrap Card Section -->
        <div class="row">
            @if($products->isNotEmpty())
            @foreach($products as $product)
                <div class="col-lg-4 col-md-6 col-sm-12 mx-auto text-center">
                    <div class="card menu-card">
                        <img src="{{ asset('product/images/' . $product->image) }}" class="card-img-top mx-auto product-image" alt="{{ $product->name }}">
                        <div class="card-body product-detail-body mx-auto">
                            <strong class="card-text menu-card-price">Rs {{ $product->price }}</strong>
                            <h5 class="card-title menu-card-heading">{{ $product->name }}</h5>
                            <p class="card-text menu-card-description">{{ $product->description }}</p>       
                            
                            @if(session()->has('id'))
                                @if(auth()->check() && auth()->user()->email_verified_at && auth()->user()->is_enabled)
                                    <a id="orderButton" href="{{ route('confirmationorder', ['uuid' => $product->uuid]) }}" class="buy-now-btn" data-uuid="{{ $product->uuid }}">Order Now</a>
                                @else
                                    <button type="button" class="btn buy-now-btn text-center" disabled>Order Now (Login required)</button>
                                @endif
                            @else
                                <button type="button" class="btn buy-now-btn text-center" disabled>Order Now (Login required)</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p style=" font-family: Inter;padding: 15px 15px;font-size: 20px;">No products found.</p>
        @endif
        
          
      </div>
      
</div>

        </div>
    </div>
    

    <!-- menu section end -->

  </div>
    <!-- Footer section start -->
  <div class="footer-background" style="background-color: #EDE8F3; margin-top: 80px;">
    <div class="container ">
      <div class="row">
        <div class="col-md-6 col-lg-3 mt-5 ">
       <a href="/">   <img src="{{ asset('assets/images/Logjo.svg')}}" alt="logo"></a>
          <h3 class="mt-3 footer-heading">Follow Us:</h3>
          <div class="footer-social-icons mt-3">
            <a href="">
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
            <a href="/">About</a>
            <a href="/">Contact Us</a>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <h3 class="mt-5 footer-third-heading">Legal:</h3>
          <div class="footer-nav">
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <h3 class="mt-5 footer-forth-heading">Subscribe</h3>
          <p class="footer-paragraph">Subscribe to our Newsletter to get latest <br> news from us.</p>
          <div class="form-group">
            <input type="email" class="form-control footer-input-field" autocomplete="off" id="email" placeholder="Email" style="
            width: 250px;
            height: 55px;
            border-radius: 10px;
            border: 1px solid var(--foundation-red-red-300, #FF6E6E);
          "/>
          </div>
          <button class="btn footer-btn text-white mb-2">Subscribe</button>
        </div>
      </div>
    </div>
  </div>
  <div class="last-section" style="background-color: #dcd8e2; height: 50px; font-size: 15px;">
    <div class="container">
      <p class="" style="
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
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('js/index.js') }}"></script>
<!-- jQuery CDN hosted by jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
     function toggleSidebar() {
    var sidebar = document.querySelector(".sidebar");
    sidebar.classList.toggle("d-none");
  }

 
  $(document).ready(function() {
    function checkStockAndUpdateButton() {
        $.ajax({
            url: "{{ route('check.stock') }}",
            type: "GET",
            success: function(response) {
                // console.log(response);
                response.products.forEach(function(product) {
                    var anchor = $('[data-uuid="' + product.uuid + '"]');
                    // console.log("Anchor element:", anchor);
                    if (product.remaining_quantity >= 10) {
                        // Product is in stock
                        var href = `/user-order/${product.uuid}`;
                        // console.log("New href:", href);
                        anchor.html('Order Now').removeAttr('disabled').removeClass('disabled').attr('href', href);
                    } else {
                        // Product is out of stock
                        anchor.removeAttr('href').addClass('disabled').html('Out of stock');
                    }
                });
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    // Event delegation to handle dynamically added anchor elements
    $(document).on('click', '[data-uuid]', function() {
        checkStockAndUpdateButton(); // Refresh data before following the link
    });

    checkStockAndUpdateButton();
    setInterval(checkStockAndUpdateButton, 3000); // Poll every 3 seconds for updates
});

document.addEventListener("DOMContentLoaded", function() {
    const categorySlider = document.getElementById("categorySlider");
    const prevBtn = document.querySelector(".moving-btn .right");
    const nextBtn = document.querySelector(".moving-btn .left");

    let currentCategory = 0;
    const categories = categorySlider.querySelectorAll(".menu-items-btn");
    const totalCategories = categories.length;

    function updateCategoryVisibility() {
        categories.forEach((category, index) => {
            if (index >= currentCategory && index < currentCategory + 3) {
                category.style.display = "inline-block";
            } else {
                category.style.display = "none";
            }
        });
    }

    updateCategoryVisibility();

    prevBtn.addEventListener("click", function() {
        if (currentCategory > 0) {
            currentCategory--;
            updateCategoryVisibility();
        }
    });

    nextBtn.addEventListener("click", function() {
        if (currentCategory + 1 < totalCategories) {
            currentCategory++;
            updateCategoryVisibility();
        }
    });
});

</script>
</html>