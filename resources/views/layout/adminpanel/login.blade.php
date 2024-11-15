<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
    <!-- css file -->
    {{-- <link rel="stylesheet" href="login.css"/> --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/Logjo.svg') }}?v={{ time() }}"/>
    {{-- css file --}}
    <link rel="stylesheet" href="{{ asset('adminpanel/adminpanelcss/login.css') }}">
    <title>Canteen Management System</title>
    <script type="text/javascript"> 
        window.history.forward(); 
        function noBack() { 
            window.history.forward(); 
        } 
    </script> 
    
    <style>
        .col-lg-5 , .col-md-12 , .col-sm-12 {
            padding: 0 ;
        }
        body {
            -webkit-touch-callout: none; 
            -webkit-user-select: none; 
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none; 
        }
    </style>
</head>
<body oncontextmenu="return false;">
    <div class="container-fluid">
        <div class="row">
            <!-- Left side with login form -->
            
               
            <div class="col-lg-5 col-md-12 col-sm-12 login-form-container">
                <h3 class="login-heading font-weight-bold mb-4">Log In</h3>
                <h4 style="font-family: Poppins;
                font-size: 16px;
                font-style: normal;
                font-weight: bold;" class="mb-5 signup-heading" >Already a Member?  <a href="{{route ('signup')}}" class="signup-head">Sign Up Now</a> </h4>
                 @if(session('success'))
                 <div class="alert alert-success">
                    {{ session('success') }}
                 </div>
                 @endif
                 @include('sweetalert::alert')
              <form action="{{ route('login.submit') }}" method="post" id="login-form" autocomplete="off" onsubmit="showLoader()">
                    @csrf
                   

                    <div class="form-group ">
                        <input type="email" class="form-control email " name="email" id="inputEmail" placeholder="Email" autocomplete="off" />
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control password " name="password" id="inputPassword" placeholder="Password" autocomplete="off" />
                    </div>
                 {{-- <div class="" > --}}
                            <a href="{{route ('userpassword')}}" class="Forget-password">Forget Password?</a>
                        {{-- </div>  --}}

                        <button type="submit" class="btn login-btn mt-4 mb-3 ">Login <span id="loader" style="display:none;">Loading...</span></button>
            </div>
        </form>
            <!-- Right side with background image -->
            <div class="col-lg-7 col-md-12 col-sm-12">
                <div class="right-side-background">
                    <h3 class="right-side-heading">Hi Welcome Back!</h3>
                    <img src="{{ asset('adminpanel/assets/images/lunch-break-isometric 1.png') }}" alt="image" class="mx-auto d-block">
                    <h3 class="right-side-heading2">Delicious Meals, Fast Service and Happy Moments!</h3>
                    <h1 class="right-side-heading3">Sign in to explore a <br> world of culinary <br> delights.</h1>
                </div>
            </div>
        
        </div>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="{{ asset('adminpanel/adminjs/loader.js') }}"></script>
<script>
     window.addEventListener('contextmenu', function (e) {
        e.preventDefault();
     });

     window.addEventListener('keydown', function(e) {
    // Disable Ctrl+Shift+I, Ctrl+Shift+J, and Ctrl+Shift+C
    if ((e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J' || e.key === 'C')) ||
        // Disable Ctrl+Shift+U (View Source)
        (e.ctrlKey && e.shiftKey && e.key === 'U') ||
        // Disable F12 key
        (e.key === 'F12')) {
        e.preventDefault();
    }
      // Disable Ctrl+U
      if (e.ctrlKey && e.key === 'u') {
        e.preventDefault();
    }
});


</script>


</html>
