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
        .text-danger {
    /* color: #dc3545; */
    /* font-size: 14px;  */
    display: flex; 
    align-items: center;
    justify-content: flex-start; 
   
    
}
@media (max-width: 768px) {
  #passwordError {
    margin-left: 0 !important; 
    width: auto; 
  }
}
    </style>
</head>
<body >
    <div class="container-fluid">
        <div class="row">
            <!-- Left side with login form -->
            
               
            <div class="col-lg-5 col-md-12 col-sm-12 login-form-container">
                <h3 class="login-heading font-weight-bold mb-4">Sign up </h3>
                <h4 style="font-family: Poppins;
                font-size: 16px;
                font-style: normal;
                font-weight: bold;" class="mb-5 signup-heading" >Already a Member?  <a href="{{route ('login')}}" class="signup-head">Log In Now</a> </h4>
               @include('sweetalert::alert')
            
             <form method="post" action="{{ route('register.submit') }}" onsubmit="return formValidation() && showLoader()" >
                    @csrf
                    {{-- <div id="formError" class="text-danger  mb-2  "></div> --}}
                    <div class="form-group ">
                        <input type="text" class="form-control name" value="{{ old('name') }}" name="name" id="inputname" placeholder="Name (Muhammad Usama)" autocomplete="off" />
                        @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                    <div id="nameError" class="text-danger mx-2 mb-2"></div>
                    </div>
                    <div class="form-group ">
                        <input type="text" class="form-control  rollno" value="{{ old('rollno') }}" name="rollno" id="inputrollno" placeholder="Complete Roll No (BSIT51BF20R046)" autocomplete="off" />
                        @if ($errors->has('rollno'))
                        <span class="text-danger">{{ $errors->first('rollno') }}</span>
                    @endif
                    <div id="rollNoError" class="text-danger mx-2 mb-2"></div>
                    </div>
                    <div class="form-group ">
                        <input type="text" class="form-control  class" value="{{ old('class') }}" name="class" id="inputclass" placeholder="Depart (CS&IT)" autocomplete="off" />
                        @if ($errors->has('class'))
                        <span class="text-danger">{{ $errors->first('class') }}</span>
                    @endif
                    <div id="classError" class="text-danger mx-2 mb-2"></div>
                    </div>
                    {{-- <div class="form-group ">
                        <input type="text" class="form-control  username" value="{{ old('username') }}" name="username" id="inputusername" placeholder="Username" autocomplete="off" />
                    </div> --}}
                    <div class="form-group ">
                        <input type="email" class="form-control  email" value="{{ old('email') }}" name="email" id="inputEmail" placeholder="Email (user@gmail.com)" autocomplete="off" />
                         @if ($errors->has('email'))
                     <span class="text-danger">{{ $errors->first('email') }}</span>
                     @endif
                     <div id="emailError" class="text-danger mx-2 mb-2"></div>
                    </div>
                    <div class="form-group ">
                        <input type="text" class="form-control  number" value="{{ old('number') }}" name="number" id="inputnumber" placeholder="Number (01234567899)" autocomplete="off" />
                        @if ($errors->has('number'))
                      <span class="text-danger">{{ $errors->first('number') }}</span>
                     @endif
                     <div id="numberError" class="text-danger mx-2 mb-2"></div>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control password " name="password" id="inputPassword" placeholder="Password" autocomplete="off" />
                        @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                    @endif
                    <div id="passwordError" class="text-danger error-message mx-2 mb-2"></div>

                    </div>
                    
                    
                        <button type="submit" class="btn login-btn mt-4 mb-3 ">Signup <span id="loader" style="display:none;">Loading...</span></button>
            </div>
        </form>
            <!-- Right side with background image -->
            <div class="col-lg-7 col-md-12 col-sm-12">
                <div class="right-side-background">
                    <h3 class="right-side-heading">Welcome To CanteenEase!</h3>
                    <img src="{{ asset('adminpanel/assets/images/fast-food-isometric-50951 1.png') }}" alt="image" class="mx-auto d-block">
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
    // window.addEventListener('contextmenu', function (e) {
    //     e.preventDefault();
    //  });

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



  
function formValidation() {
    let name = document.getElementById('inputname').value.trim();
    let email = document.getElementById('inputEmail').value.trim();
    let password = document.getElementById('inputPassword').value.trim();
    let classValue = document.getElementById('inputclass').value.trim();
    let number = document.getElementById('inputnumber').value.trim();
    let rollNo = document.getElementById('inputrollno').value.trim();

    const emailPattern = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/;
    const passwordPattern = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/;
    const numberPattern = /^0[0-9]{10}$/;
    const rollNoPattern = /^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]+$/;

    let isValid = true;

    if (name === "") {
        document.getElementById('nameError').innerHTML = "Name cannot be empty.";
        isValid = false;
    } else {
        document.getElementById('nameError').innerHTML = "";
    }

    if (email === "" || !emailPattern.test(email)) {
        document.getElementById('emailError').innerHTML = "Please enter a valid email address.";
        isValid = false;
    } else {
        document.getElementById('emailError').innerHTML = "";
    }

    if (password === "" ) {
        document.getElementById('passwordError').innerHTML = "Password must contain be strong.";
        isValid = false;
    } else {
        document.getElementById('passwordError').innerHTML = "";
    }

    if (classValue === "") {
        document.getElementById('classError').innerHTML = "Depart cannot be empty.";
        isValid = false;
    } else {
        document.getElementById('classError').innerHTML = "";
    }

    if (number === "" || !numberPattern.test(number)) {
        document.getElementById('numberError').innerHTML = "Please enter a valid phone number";
        isValid = false;
    } else {
        document.getElementById('numberError').innerHTML = "";
    }

    if (rollNo === "" || !rollNoPattern.test(rollNo)) {
        document.getElementById('rollNoError').innerHTML = "Please enter a valid roll number.";
        isValid = false;
    } else {
        document.getElementById('rollNoError').innerHTML = "";
    }

    return isValid;
}


</script>

</html>
