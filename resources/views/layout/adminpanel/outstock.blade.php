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
    padding: 13px 16px;
    width: 100%;
    font-size: 16px;
    color: #495057;
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
.input-message {
    display: block;
    margin-top: 5px; 
    /* font-size: 14px; */
}
.error {
    box-shadow: 0 0 0 1px rgba(219, 99, 62, 1) !important; 
    border-color: rgba(219, 99, 62, 1) !important;
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
            <span style="margin-right: auto;">Out Of Stock</span>
            {{-- <a href="#" id="newProductBtn" style="margin-left: auto;" class="btn btn-danger">New Product</a> --}}
        </div>
        @if(session('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>
    @endif
    @include('sweetalert::alert')
        <!-- fields start -->
        <div class="container-fluid ">
          
         <!-- ================ Order Details List ================= -->
         <div class="details">
            <div class="recentOrders">
                <div class="cardHeader">
                    <h2>Items Out Of Stock</h2>
                    <input type="search" class="form-control w-25 " placeholder="Search...">
                </div>

                <table>
                    <thead>
                        <tr>
                          
                            <th style="padding-right: 50px;">Image</th>

                            <th style="padding-right: 50px;">Name</th>

                            <th style="padding-right: 50px;">Description</th>

                            <th style="padding-right: 50px;">Total Price</th>

                            <th style="padding-right: 50px;">Total Quantity</th>

                            <th style="padding-right: 50px;">Remaining Quantity</th>

                            

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

                            <td style="padding-right: 50px;">{{ date('Y-m-d h:i:s A', strtotime('Asia/Karachi')) }}</td>

                            <td>
                                <a class="edit-product btn btn-primary btn-sm " href="{{ route('editproducts', ['uuid' => $product['uuid']]) }}">
                                    Edit
                                </a>
                            </td>
                            
                            <td>
                                <a href="{{ route('hide.delete', ['uuid' => $product['uuid']]) }}" class="btn btn-danger btn-sm">Hide</a>
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
   {{-- <script src="{{ asset('adminpanel/adminjs/index.js') }}"></script> --}}
   <!-- ====== ionicons ======= -->
   <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
   <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
   <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js" ></script> -->
</html>