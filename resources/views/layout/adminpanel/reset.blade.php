<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- CSS only -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <title>Canteen Management System</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="{{ asset('adminpanel/adminpanelcss/style.css') }}">
    <link rel="stylesheet" href="{{ asset('adminpanel/adminpanelcss/dashbaord.css') }}">

    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/Logjo.svg') }}?v={{ time() }}" />
    
    <style>
  
.form-control:focus {
    border-color: #80bdff; 
    box-shadow: none; 
    outline: 2px solid rgb(190, 16, 54);
}
.reset{
    padding: 7px 24px;
    background-color: rgb(190, 16, 54);
    color: #ffff;
} 
.reset:hover{
    background-color: rgb(190, 16, 54);
    color: #ffff;
}
.form-control {
    border: none; 
    background-color: #ffff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border-radius: 8px; 
    padding: 13px 16px;
    width: 100%;
    font-size: 16px;
    color: #495057;
}

.alert-danger{
    color: #721c24;
     padding: 0.75rem 1.25rem;
      border-radius: 0.25rem;
      border: none;
}
    </style>
</head>

<body>
    <!-- =============== Navigation ================ -->
   
{{-- header file included here --}}

@include('layout.adminpanel.header')

        <!-- ========================= Main ==================== -->
        <div class="main" >
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                <div class="user">
                    <img src="/adminpanel/assets/images/profile-pic.avif" alt="profile-image" >
                                </div>
            </div>

         <!-- List to add item or delete item -->
         <div style="background-color: #FAFAFA;">
         <div class="items-detail">
            <span style="margin-right: auto;">Reset Your Password</span>
            
        </div>
         
        <!-- fields start -->
        <div class="container-fluid ">
            <div class="row justify-content-center">
                <div class="col-md-12">
                   
                    <div id="itemInputs" class="item-inputs" >
                        <!-- Input fields for adding new item -->
                        <div class="row">
                            @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif    
                            <div class="col-md-7 mt-3 ">
                                <form action="{{ route('reset.password') }}" method="post">

              
                                    @csrf
                                <div class="form-group">
                                    <label >Email <span style="color: rgb(219, 99, 62);">*</span></label>
                                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Email" autocomplete="on">
                                </div>
                                @error('email')
                                <div class="alert alert-danger mt-2 ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-7 mt-3 ">
                                <div class="form-group">
                                    <label >New Password <span style="color: rgb(219, 99, 62);">*</span></label>
                                    <input type="password" name="password" id="newpassword" class="form-control" placeholder="New Password" autocomplete="off">
                                </div>
                                @error('password')
                                <div class="alert alert-danger mt-2 ">
                                    {{ $message }}
                                </div>
                            @enderror
                            </div>
                            <div class="col-md-7 mt-3 ">
                                <div class="form-group">
                                    <label >Confirm Password <span style="color: rgb(219, 99, 62);">*</span></label>
                                    <input type="password" name="confirm_password" id="confirmpassword" class="form-control" placeholder="Confirm Password" autocomplete="off">
                                </div>
                                @error('confirm_password')
                              <div class="alert alert-danger mt-2 ">{{ $message }}</div>
                            @enderror
                            </div>
                            
                       

                        </div>
                        <div class="form-group mt-3 ">
                            <button id="submit " class="btn mb-3 reset">Reset Password</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- fields end -->
    </div>
        </div>
  
    
</body>
  <!-- =========== Scripts =========  -->
  <script src="{{ asset('adminpanel/adminjs/main.js') }}"></script>
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js" ></script> -->
</html>