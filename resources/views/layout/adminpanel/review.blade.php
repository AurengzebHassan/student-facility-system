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
tr:nth-child(even) {
    background-color: #f2f2f2; 
  }

  th {
    padding-left: 10px
  }

 
</style>
</head>

<body>
    <!-- =============== Navigation ================ -->

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
            <span >Customer-Reviews</span>
        </div>
        @if(session('warning'))
    <div class="alert alert-warning">
        {{ session('warning') }}
    </div>
@endif
        <!-- Table to show orders detail -->
        <div class="details">
            <div class="recentOrders">
                <div class="cardHeader">
                    <h2>Customer-Reviews</h2>
                    <!-- <input type="text" class="form-control w-25 " placeholder="Search..."> -->
                </div>

                <div style="height: 400px; width:900px; overflow-y: auto;">
                    <table class="">
                        <thead>
                            <tr>
                                {{-- <th style="padding-right: 20px;">#</th> --}}
                                <th style="padding-right: 20px;">Name</th>
                                <th style="padding-right: 20px;">Email</th>
                                <th style="padding-right: 20px;">Message</th>
                            </tr>
                        </thead>
                        <tbody id="">
                           
                            @foreach ($reviews as $review)
                                
                                <tr >
                                    {{-- <td style="padding-right: 20px;">{{ $review->id }}</td> --}}
                                    <td style="padding-right: 20px;">{{ $review->name }}</td>
                                    <td style="padding-right: 20px;">{{ $review->email }}</td>
                                    <td style="white-space: pre-wrap; word-break: break-all;">{{ $review->message }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                   
                </div>
                <div class="pagination ">
                    {{ $reviews->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
        </div>
        </div>
    <!-- =========== Scripts =========  -->
    <script src="{{ asset('adminpanel/adminjs/main.js') }}"></script>
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js" ></script> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>
<script>
    
</script>
</html>