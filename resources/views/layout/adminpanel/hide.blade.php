<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- CSS only -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />

    <title>Canteen Management System</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="{{ asset('adminpanel/adminpanelcss/style.css') }}">
    <link rel="stylesheet" href="{{ asset('adminpanel/adminpanelcss/dashbaord.css') }}">

    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/Logjo.svg') }}?v={{ time() }}" />
<style>
      /* CSS styles for demonstration purposes */
      .items-detail {
            /* margin-top: 20px; */
            display: flex;
            align-items: center;
        }
        .item-inputs {
    margin-top: 20px;
}

label{
    font-size: 16px;
    font-weight: 800;
    font-family: Intern;
    padding: 10px 5px;
}
.form-control {
    border: none; 
    background-color: #ffff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border-radius: 8px; 
    padding: 10px 14px;
    /* width: 50%; */
    font-size: 16px;
    color: #495057;
    background-color: #CFCBCB;
}


.form-control:focus {
    outline: 2px solid rgb(190, 16, 54);
}

.form-control:focus {
    border-color: #80bdff; 
    box-shadow: none; 
}

#addItemBtn{
    padding: 7px 24px;
    background-color: rgb(190, 16, 54);
    color: #ffff;
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
            <span style="margin-right: auto;">Hidden</span>
            {{-- <a href="#" id="newProductBtn" style="margin-left: auto;" class="btn btn-danger">New Product</a> --}}
        </div>
        @if(session('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>
    @endif
    <!-- In your Blade view -->
@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

        <!-- fields start -->
        <div class="container-fluid ">
            @include('sweetalert::alert')
         <!-- ================ Order Details List ================= -->
         <div class="details">
            <div class="recentOrders">
                <div class="cardHeader">
                    <h2>Hidden Items</h2>
                    <form action="{{ route('unhideproducts') }}" method="GET" class="form-inline">
                        <div class="input-group">
                            <input type="search" name="search"  class="form-control input-search" style="border-radius: 8px;" placeholder="Search..." value="{{ $searchQuery ?? '' }}">
                            <div class=" ms-2 ">
                                <button type="submit" class=" search-btn btn">Search</button>
                            </div>
                        </div>
                        
                    </form> 
                </div>

                <table>
                    <thead>
                        <tr>
                          
                            <th style="padding-right: 50px;">Image</th>

                            <th style="padding-right: 50px;">Name</th>

                            <th style="padding-right: 50px;">Description</th>

                            <th style="padding-right: 50px;">Total_Price</th>

                            <th style="padding-right: 50px;">Total_Quantity</th>

                            <th style="padding-right: 50px;">Remaining_Quantity</th>

                            

                            <th style="padding-right: 50px;">Date/Time</th>
                            <th>Actions</th>
                            
                            
                        </tr>
                        
                    </thead>

                    <tbody>
                        @foreach($products as $product)
                        <tr>
                           
                            <td><img src="{{ asset('product/images/' . $product->image) }}" class="img-fluid" alt="{{ $product->name }}"></td>

                            <td style="padding-right: 50px;">{{ $product->name }}</td>

                            <td style="max-width: 300px; word-wrap: break-word;">{{ $product->description }}</td>

                            <td style="padding-right: 50px;">{{ $product->price }}</td>

                            <td style="padding-right: 50px;">{{ $product->total_quantity }}</td>

                            <td style="padding-right: 50px;">{{ $product->remaining_quantity }}</td>

                            <td style="padding-right: 50px;">{{ date('Y-m-d H:i:s') }}</td>


                            {{-- <td>
                                <a class="edit-product btn btn-primary btn-sm " href="{{ route('editproducts', ['uuid' => $product['uuid']]) }}">
                                    Edit
                                </a>
                            </td> --}}
                            
                            
                            <td>
                                <a href="{{ route('unhide.delete', ['uuid' => $product['uuid']]) }}" class="btn btn-secondary btn-sm">UnHide</a>
                            </td>
                                                        
                        </tr>
                        @endforeach
                    
                    </tbody>
                </table>
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
 {{-- <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js" ></script> --> --}}

 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
{{-- <script>
    $(document).ready(function() {
        
        setTimeout(function() {
            $('#successMessage, #failMessage').fadeOut('slow');
        }, 5000);
    });
</script> --}}

  
</html>