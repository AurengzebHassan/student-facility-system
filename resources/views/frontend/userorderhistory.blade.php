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
 
  <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/userorder.css') }}">

  <title>Canteen Management System</title>
<style>
   .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent black background */
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .modal img {
        max-width: 90%;
        max-height: 90%;
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
            <a href="{{ route('userprofile')}}" class="nav-link font-weight-bold ">Profile</a>
            <a href="{{ route ('frontend.menu')}}" class="nav-link font-weight-bold">Menu</a>
            <a href="{{ route('orderhistory')}}" class="nav-link font-weight-bold active">Order History</a>
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
        <a class="nav-link font-weight-bold  " href="{{ route ('userprofile')}}" style="color: #000000; padding: 10px 10px 14px 30px;">Profile</a>
        <a class="nav-link font-weight-bold active" href="{{ route('orderhistory')}}" style="color: #000000; padding: 10px 10px 14px 30px;">Order History</a>
        <a href="{{ route ('frontend.menu')}}" style="color: #000000; padding: 10px 10px 14px 30px;" class="nav-link font-weight-bold">Menu</a>
        <a class="nav-link font-weight-bold" href="{{ route('user.logout') }}" style="color: #000000; padding: 10px 10px 14px 30px;">Logout</a>
      </aside>
    </div>
    <!-- End of the container -->
  </div>
  @if(session('success'))
  <div class="alert alert-success mt-4 ">
      {{ session('success') }}
  </div>
@endif
  <!-- {{-- user order data show --}} -->
  <main class="table mt-5 " id="customers_table">
    <section class="table__header">
        <h1>Customer's Orders</h1>
        <!-- <div class="input-group">
            <input type="search" placeholder="Search Data...">
            <img src="images/search.png" alt="">
        </div> -->
       
    
    </section>
    <section class="table__body">
        <table>
            <thead>
                <tr>
                    <th> Order-Id <span class="icon-arrow">&UpArrow;</span></th>
                    <th> Product-Name <span class="icon-arrow">&UpArrow;</span></th>
                    <th> Price<span class="icon-arrow">&UpArrow;</span></th>
                    <th> Order Date <span class="icon-arrow">&UpArrow;</span></th>
                    <th> Status <span class="icon-arrow">&UpArrow;</span></th>
                    <th> Total-Quantity <span class="icon-arrow">&UpArrow;</span></th>
                    <th> Total-Price <span class="icon-arrow">&UpArrow;</span></th>
                    <th> Payment <span class="icon-arrow">&UpArrow;</span></th>
                    <th> Image <span class="icon-arrow">&UpArrow;</span></th>
                </tr>
            </thead>
            <tbody> @include('sweetalert::alert')
              @foreach ($orders as $order)
                <tr>
                    <td style="font-weight: bold">{{ $order->order_id }}</td>
                    {{-- <td> {{ $order->user->name }}</td> --}}
                    <td> {{ optional ($order->product)->name }} </td>

                    <td> {{ optional ($order->product)->price }}   </td>

                    <td>{{ $order->created_at->setTimezone('Asia/Karachi')->format('M d, Y h:i A') }}</td>


                  <td id="orderStatus_{{ $order->id }}" class="order-status">
                    @if ($order->archive == 0)
                    <p class="status pending">Pending</p>
                    @elseif ($order->archive == 1)
                    <p class="status delivered">Completed</p>
                    @elseif ($order->archive == 2)
                    <p class="status cancelled">Cancelled</p> 
                    @endif
                </td> 
                
                

                  <td style="text-align: center"> {{  $order->quantity }} </td>

                    <td> <strong> {{ $order->order_price ?? 'N/A' }} </strong></td>

               <td>    <strong>{{ $order->paymentMethod->method_name ?? 'N/A' }}</strong></td> 
               <td >
                @if($order->image)
                    <img src="{{ asset('payment/images/' . $order->image) }}" class="order-image" alt="Payment Image" >
                @else
                    No Image
                @endif
            </td>
                </tr>
               
            </tbody>
            @endforeach   
        </table>
        <div class="pagination ">
          {{ $orders->links('pagination::bootstrap-4') }}
      </div>
    </section>
</main>

</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="{{ asset('js/index.js') }}"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  function toggleSidebar() {
    var sidebar = document.querySelector(".sidebar");
    sidebar.classList.toggle("d-none");
  }
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
</script>

</html>