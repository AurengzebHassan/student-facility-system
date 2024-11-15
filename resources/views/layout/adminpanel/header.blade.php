<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <title>Canteen Management System</title>
<style>
    .notification-counter, .notification-counter-reviews {
    position: absolute;
    top: -5px; 
    background-color:  #ff0000;
    color: #ffffff;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: 12px;
}

</style>
</head>
<body>
    
    <div class="container1">
        <div class="navigation">
            <ul>
                <li style="border-bottom: 2px">
                    <a href="#">
                        <span class="icon">
                            <img src="{{ asset('assets/images/Logjo.svg') }}" alt="logo" style="margin-top: 5px;">
                        </span>
                        {{-- <span class="title">Canteen System</span>  --}}
                    </a>
                </li>
                   <!-- =============== Dashboard Section ================ -->
                <li>  
                    <a href="{{ route('dashboard') }}" >
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                  <!-- =============== Products Section ================ -->
                <li>
                    <a href="{{ route('products') }}">
                        <span class="icon">
                            <ion-icon name="basket-outline"></ion-icon>
                        </span>
                        <span class="title">Products</span>
                    </a>
                </li>
                <!-- =============== Category Section ================ -->
                <li>
                    <a href="{{ route('showcategory') }}">
                        <span class="icon">
                            <ion-icon name="list-outline"></ion-icon>
                        </span>
                        <span class="title">Category</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('showsubcategory') }}">
                        <span class="icon">
                            <ion-icon name="folder-outline"></ion-icon>
                        </span>
                        <span class="title">Sub Category</span>
                    </a>
                </li>
                
                 <!-- =============== Category Section ================ -->
                <li>
                    <a href="{{ route('instock') }}">
                        <span class="icon">
                            <ion-icon name="checkmark-circle-outline"></ion-icon>
                        </span>
                        <span class="title">In Stock</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('outstock') }}">
                        <span class="icon">
                            <ion-icon name="close-circle-outline"></ion-icon>
                        </span>
                        <span class="title">Out of stock</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('unhideproducts') }}">
                        <span class="icon">
                            <ion-icon name="eye-off-outline"></ion-icon>
                        </span>
                        <span class="title">Hide Products</span>
                    </a>
                </li>
                
                 <!-- =============== Orders Section ================ -->
                 <li>
                    <a href="{{ route('order') }}">
                        <span class="notification-counter">0</span> <!-- Notification counter -->
                        <span class="icon">
                            <ion-icon name="receipt-outline"></ion-icon>
                        </span>
                        <span class="title">Orders</span>
                    </a>
                </li>
                   <!-- =============== Pending-Order Section ================ -->
                {{-- <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="alert-circle-outline"></ion-icon>
                        </span>
                        <span class="title">Pending-Order</span>
                    </a>
                </li> --}}
                   <!-- =============== Completed-Order Section ================ -->
                <li>
                    <a href="{{route('completedorder')}}">
                        <span class="icon">
                            <ion-icon name="checkmark-done-outline"></ion-icon>
                        </span>
                        <span class="title">Completed-Order</span>
                    </a>
                </li>
                <li>
                     <!-- =============== Cancel-Order Section ================ -->
                    <a href="{{ route('Cancelorder') }}">
                        <span class="icon">
                            <ion-icon name="close-circle-outline"></ion-icon>
                        </span>
                        <span class="title">Cancel Order</span>
                    </a>
                </li>
 <!-- =============== PAyment Method Section ================ -->
                <li>
                   
                   <a href="{{ route('showpayment.method') }}">
                       <span class="icon">
                        <ion-icon name="card-outline"></ion-icon>
                       </span>
                       <span class="title">Payment Method</span>
                   </a>
               </li>
                
                   <!-- =============== User Section ================ -->
                   <li>
                    <a href="{{route('user.profile')}}">
                        <span class="icon">
                            <ion-icon name="person-outline"></ion-icon> <!-- Assuming "person-outline" represents the user icon -->
                        </span>
                        <span class="title">New Users</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('Authenticated.user')}}">
                        <span class="icon">
                            <ion-icon name="person-circle-outline"></ion-icon>
                        </span>
                        <span class="title">Authenticated Users</span>
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('reviews') }}">
                        <span class="notification-counter-reviews">0</span> <!-- Notification counter -->
                        <span class="icon">
                            <ion-icon name="star-outline"></ion-icon>
                        </span>
                        <span class="title">Customer-Reviews</span>
                    </a>
                </li>
                     <!-- =============== Admin Section ================ -->
                <li>
                    <a href="{{route ('admindetail')}}">
                        <span class="icon">
                            <ion-icon name="shield-checkmark-outline"></ion-icon>
                        </span>
                        <span class="title">Admin</span>
                    </a>
                </li>
                 <!-- =============== Reset Password Section ================ -->
                 <li>
                    <a href="{{ route('reset') }}">
                        <span class="icon">
                            <ion-icon name="key-outline"></ion-icon>
                        </span>
                        <span class="title">Forgot Password</span>
                    </a>
                </li>
                <!-- =============== Sign Out Section ================ -->
                <li>
                    <a href="{{ route('logout') }}">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</body>
<!-- jQuery CDN hosted by jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    var viewedNotifications = false;

    function checkNewReviews() {
        $.ajax({
            url: '/check-newreviews',
            type: 'GET',
            success: function(response) {
                // Update the notification counter with the number of new reviews
                $('.notification-counter-reviews').text(response.newReviewsCount);

                // If the user has viewed the notifications and there are no new reviews, hide the counter
                if (viewedNotifications && response.newReviewsCount === 0) {
                    $('.notification-counter-reviews').hide();
                } else {
                    $('.notification-counter-reviews').show(); // Ensure counter is shown if there are new reviews
                }
            },
            // error: function(xhr, status, error) {
            //     console.error('Error checking new reviews:', error);
            // }
        });
    }

    // Check for new reviews every 2 seconds
    setInterval(checkNewReviews, 2000);

    // Event handler for when the user views the notifications
    $('.notification-counter-reviews').click(function() {
        // Reset the flag and show the notifications
        viewedNotifications = true;
    });
});



$(document).ready(function() {
    var viewedNotifications = false;

    function checkNewReviews() {
        $.ajax({
            url: '/check-neworders',
            type: 'GET',
            success: function(response) {
                // Update the notification counter with the number of new reviews
                $('.notification-counter').text(response.newReviewsCount);

                // If the user has viewed the notifications and there are no new reviews, hide the counter
                if (viewedNotifications && response.newReviewsCount === 0) {
                    $('.notification-counter').hide();
                } else {
                    $('.notification-counter').show(); // Ensure counter is shown if there are new reviews
                }
            },
            // error: function(xhr, status, error) {
            //     console.error('Error checking new reviews:', error);
            // }
        });
    }

    // Check for new reviews every 2 seconds
    setInterval(checkNewReviews, 2000);

    // Event handler for when the user views the notifications
    $('.notification-counter').click(function() {
        // Reset the flag and show the notifications
        viewedNotifications = true;
    });
});
</script>
</html>