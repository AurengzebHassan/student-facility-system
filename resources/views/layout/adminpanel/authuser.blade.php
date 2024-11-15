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
.form-control {
    border: none; 
    background-color: #cfcbcb;
    /* box-shadow: 0 2px 4px rgba(235, 231, 231, 0.1); */
    border-radius: 8px; 
    padding: 10px 16px;
    /* width: 100%; */
}
.form-control:focus {
    border-color: #80bdff; 
    box-shadow: none; 
    outline: 2px solid rgb(190, 16, 54);
}
.input-group {
    /* display: flex; */
    position: relative;
    align-items: center;
    padding: 2px;
}

 .search-btn:hover{
   background-color: #FC8019;
   /* transform: translateX(10px); */
   color: #fff;
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
            <span >Authenticated User</span>
            <!-- <a href="" style="margin-left: auto;" class="btn btn-danger ">New Products</a> -->
        </div>
        @if(session('warning'))
    <div class="alert alert-warning">
        {{ session('warning') }}
    </div>
@endif 
@include('sweetalert::alert')
        <!-- Table to show orders detail -->
        <div class="details">
            <div class="recentOrders">
                <div class="cardHeader">
                    <h2>Authenticated User</h2>
                    <form action="{{ route('Authenticated.user') }}" method="GET" class="form-inline">
                        <div class="input-group">
                            <input type="search" name="search" class="form-control input-search" style="border-radius: 8px;" placeholder="Search..." value="{{ $searchQuery ?? '' }}">
                            <select name="filter" class="form-select ms-2" style="border-radius: 8px;">
                                <option value="rollno">Roll Number</option>
                                <option value="email">Email</option>
                                <option value="name">Name</option> 
                            </select>
                            <div class="ms-2">
                                <button type="submit" class="search-btn btn">Search</button>
                            </div>
                        </div>
                    </form>
                    
                </div>
                
                <table>
                    <thead>
                        <tr>
                            <th  class="fw-bold">Student-Name</th>
                                <th  class="fw-bold">Cell-No</th>
                                <th >Roll_no</th>
                                <th style="text-align: center;">Email</th>
                                <th >Depart</th>
                                <th >email_verified_at</th>
                                <th style="text-align: center;">Status</th>
                                <th style=" text-align: end !important;">Actions</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($users as $user)
                        <tr style="background-color: {{ $loop->iteration % 2 == 0 ? '#f2f2f2' : 'transparent' }}">     
                            <td style="padding-right: 50px;" class="fw-bold">{{ $user->name }}</td>
                                <td style="padding-right: 50px;">{{ $user->number }}</td>
                                
                                <td style="padding-right: 50px;">{{$user->rollno}}</td>
                                <td style="padding-right: 50px;">{{ $user->email }}</td>
                                <td style="padding-right: 50px;">{{ $user->class }}</td>
                                <td style="padding-right: 50px;">{{ $user->email_verified_at }}</td>
                                <td style="padding-right: 50px;">{{ $user->is_enabled }}</td>
                               <td > <a href="{{ route('editAuthenticated.user', ['id' => $user->id]) }}" class="btn btn-info btn-sm" onclick="disableLink(event, this)">Edit</a>
                               </td><td >
                                <a href="{{ route('disable.user', ['id' => $user->id]) }}" class="btn btn-danger btn-sm" onclick="disableLink(event, this)">Disable</a>
                            </td>
                        </tr>  
                        @endforeach         
                    </tbody>
                </table>
                <div class="pagination mt-2  ">
                    {{ $users->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
        </div>
        </div>
    <!-- =========== Scripts =========  -->
    <script src="{{ asset('adminpanel/adminjs/main.js') }}"></script>
    <script src="{{ asset('adminpanel/adminjs/loader.js') }}"></script>
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js" ></script> -->
</body>

</html>