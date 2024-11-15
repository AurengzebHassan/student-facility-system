<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstarp cdn -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />

  <!-- font awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

  <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/Logjo.svg') }}?v={{ time() }}" />
  <!-- css--file -->
   <link rel="stylesheet" href="{{ asset('css/menu.css') }}"> 
  <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
  <title>Canteen Management System</title>
  <style>
    .background-container {
      background-color: #fff !important;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1) !important;
      height: 100px;
      /* width: 105%; */
    }
  </style>
</head>

<body>
  <!-- navbar start -->
  <div class="background-container">
    <div class="container mx-auto d-flex align-items-center " style="max-width: 1240px">
      <header class="container-fluid">
        <div class="row mt-2">  
          <div class="col-md-2">
            <a href="/">
              <img src="{{ asset('assets/images/Logjo.svg') }}" alt="Logo" class="img-fluid" style="margin-top: 6px" />
            </a>
          </div>
         
          <div class="col-md-7 d-flex align-items-center justify-content-center hide-on-small-screens">
            <a href="{{ route('userprofile')}}" class="nav-link font-weight-bold active">Profile</a>
            <a href="{{ route ('frontend.menu')}}" class="nav-link font-weight-bold">Menu</a>
            <a href="{{ route('orderhistory')}}" class="nav-link font-weight-bold">Order History</a>
            
            <a href="{{ route('user.logout')}}" class="nav-link font-weight-bold">Logout</a>
          </div>
          <!-- Icons and Login button on the right -->
          <div class="col-md-3 d-flex align-items-center justify-content-end ">
            <div style="display: flex; align-items: center;">
              <p class="user-name"><strong></strong> </p>
              <div class="dropdown d-none d-md-block">
                <img src="/adminpanel/assets/images/profile-pic.avif" alt="Profile"
                  style="width: 60px; height: 55px; border-radius: 50%;">
              </div>
            </div>
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
       

        <a class="nav-link font-weight-bold active " href="{{ route ('userprofile')}}" style="color: #000000; padding: 10px 10px 14px 30px;">Profile</a>
        <a class="nav-link font-weight-bold" href="{{ route('orderhistory')}}" style="color: #000000; padding: 10px 10px 14px 30px;">Order History</a>
        <a class="nav-link font-weight-bold" href="{{ route ('frontend.menu')}}" style="color: #000000; padding: 10px 10px 14px 30px;">Menu</a>
        <a class="nav-link font-weight-bold" href="{{ route('user.logout') }}" style="color: #000000; padding: 10px 10px 14px 30px;">Logout</a>

      </aside>


    </div>
    <!-- End of the container -->
  </div>


  <!-- {{-- user profile data show --}} -->

  {{-- <form action=""> --}}
    <div class="user-input-fields">
      <div class="container">
        <h3 class="dash-heading">My profile</h3>
        <div class="row">
                           @foreach ($users as $user)
                           @include('sweetalert::alert')       
                          
          <div class="col-md-6 mt-3">   
            <form action="{{ route('update.userprofile') }}" method="post">
                @csrf
                <input type="hidden" class="form-control" id="id" name="id" value="{{$user->id}}">
              <div class="form-group">
                <label for="userName">Name:</label>
                <input type="text" value="{{ $user->name }}" id="userName" name="name" class="form-control" autocomplete="off" >
                @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
              </div>
          </div>
          <div class="col-md-6 mt-3">
           
              <div class="form-group">
                <label for="userEmail">Email:</label>
                <input type="email" value="{{ $user->email }}" id="userEmail" name="email" class="form-control" autocomplete="off" disabled >
                @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
              </div>
          </div>
          <div class="col-md-6 mt-3">
            
              <div class="form-group">
                <label for="userPhone">Phone:</label>
                <input type="text" value="{{ $user->number}}" id="userPhone" name="number" class="form-control" autocomplete="off" >
                @error('number')
                <span class="text-danger">{{ $message }}</span>
            @enderror
              </div>
          </div>
          <div class="col-md-6 mt-3">
              <div class="form-group">
                <label for="userClass">Depart:</label>
                <input type="text" value="{{ $user->class }}" id="userClass" name="class" class="form-control"  disabled>
                @error('class')
                <span class="text-danger">{{ $message }}</span>
            @enderror
              </div>
          </div>
          <div class="col-md-6 mt-3">
            
            <div class="form-group">
              <label for="userRollNo">Roll No:</label>
              <input type="text" value="{{ $user->rollno }}" id="userRollNo" name="rollno" class="form-control" disabled>
              @error('rollno')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
          </div>
          @endforeach
          <div class="col-md-12 mt-3">
            
            {{-- <a href="" type="submit"  class=" btn bg-primary  save-btn mb-2 ">Edit</a> --}}
          </div>
        
        </div>
      </div>   
      <div class="container">
        <h3 class="dash-heading">Password</h3>
        <div class="row">
          <div class="col-md-6 mt-3">
            <div class="form-group">
              <label for="currentPassword">Current Password:</label>
              <input type="password" id="currentPassword" name="oldpassword" class="form-control" autocomplete="off" >
              @error('oldpassword')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
          </div>
          <div class="col-md-6 mt-3">
            <div class="form-group">
              <label for="newPassword">New Password:</label>
              <input type="password" id="newPassword" name="newpassword" class="form-control" autocomplete="off" >
              @error('newpassword')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
          </div>
          <div class="col-md-6 mt-3">
            <div class="form-group">
              <label for="confirmPassword">Confirm Password:</label>
              <input type="password" id="confirmPassword" name="confirmpassword" class="form-control" autocomplete="off" >
              @error('newpassword')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
          </div>
        </div>
        <button type="submit"  class=" btn save-btn mb-2 ">Save</button>
      </form>
      </div>
    </div>
  
  


</body>
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