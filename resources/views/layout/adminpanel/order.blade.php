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
 .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7); 
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .modal img {
        max-width: 90%;
        max-height: 90%;
    }
    tbody, td, tfoot, th, thead, tr {
    border-width: 1px; 
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
            <span >Orders</span>
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
                    <h2>Recent Orders</h2>
                    <form action="{{ route('order') }}" method="GET" class="form-inline">
                        <div class="input-group">
                            <input type="search" name="search" class="form-control input-search" style="border-radius: 8px;" placeholder="Search..." value="{{ $searchQuery ?? '' }}">
                            <select name="filter" class="form-select ms-2" style="border-radius: 8px;">
                                <option value="order_id">Order ID</option>
                                <option value="rollno">Roll Number</option>
                                {{-- <option value="name">Name</option>  --}}
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
                            <th  class="fw-bold">Order_id</th>
                                <th  class="fw-bold">Student_Name</th>
                                <th >Roll-No</th>
                                <th style=" text-align: center !important;">Product_name</th>
                                <th style=" text-align: center !important;">Price</th>
                                <th style=" text-align: start !important;">Order_quantity</th>
                                <th style=" text-align: center !important;">Total_Price</th>
                                <th style=" text-align: center !important;">Payment</th>
                                <th style="padding-right: 50px; text-align: center !important;">Image</th>
                                <th style="padding-right: 50px; ">Date/Time</th>
                                <th style=" text-align: end !important;">Actions</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($orders as $order)
                        <tr style="background-color: {{ $loop->iteration % 2 == 0 ? '#f2f2f2' : 'transparent' }}">     
                            <td style="padding-right: 50px;" class="fw-bold">{{ $order->order_id }}</td>
                                <td style="padding-right: 50px;">{{ optional ($order->user)->name }}</td>
                                <td style="padding-right: 50px;" class="fw-bold">{{optional ($order->user)->rollno }}</td>
                                <td style="padding-right: 50px;" class="fw-bold ">{{optional ($order->product)->name }}</td>
                                <td style="padding-right: 50px;">Rs {{optional ($order->product)->price }}</td>
                                <td style="padding-right: 50px;">{{ $order->quantity }}</td>
                                <td style="padding-right: 50px;" class="fw-bold ">Rs {{ $order->order_price }}</td>


                                <td style="padding-right: 50px;">{{ $order->paymentMethod->method_name ?? 'N/A' }}</td>

                                <td style="padding-right: 50px;">
                                    @if($order->image)
                                        <img src="{{ asset('payment/images/' . $order->image) }}" class="order-image" alt="Payment Image" style="max-width: 100px; max-height: 100px;">
                                    @else
                                        No Image
                                    @endif
                                </td>
                                <td>{{ $order->created_at->setTimezone('Asia/Karachi')->format('M d, Y h:i A') }}</td>

                                <td><a href="{{ route('completeorder', ['id' => $order->id]) }}" class="btn btn-primary btn-sm">Accept</a></td>

                                <td> <a href="{{ route('ordercancel', ['id' => $order->id]) }}" class="btn btn-danger btn-sm">Cancel</a></td>
                        </tr>  
                        @endforeach         
                    </tbody>
                </table>
                <div class="pagination mt-2  ">
                    {{ $orders->links('pagination::bootstrap-4') }}
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js" ></script> -->
</body>
<script>
    // Get all image elements with the 'order-image' class
    const orderImages = document.querySelectorAll('.order-image');

    // Add click event listener to each image
    orderImages.forEach(image => {
        image.addEventListener('click', function() {
            // Create a modal or lightbox element
            const modal = document.createElement('div');
            modal.classList.add('modal');

            // Create an image element to display the clicked image
            const modalImage = document.createElement('img');
            modalImage.src = this.src; // Set the source of the clicked image

            // Add the image to the modal
            modal.appendChild(modalImage);

            // Add the modal to the document body
            document.body.appendChild(modal);

            // Close the modal when clicked outside the image
            modal.addEventListener('click', function() {
                modal.remove(); // Remove the modal from the DOM
            });
        });
    });

    var successMessage = '{{ session("success") }}';
    if (successMessage) {
      Swal.fire({
        icon: "success",
        title: successMessage,
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
      });
    }
</script>

</html>