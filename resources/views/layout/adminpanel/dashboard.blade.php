<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- CSS only -->
    <link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Canteen Management System</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="{{ asset('adminpanel/adminpanelcss/style.css') }}"/>
    <link rel="stylesheet"href="{{ asset('adminpanel/adminpanelcss/dashbaord.css') }}"/>

    <link rel="icon" type="image/svg+xml"href="{{ asset('assets/images/Logjo.svg') }}?v={{ time() }}"/>

    <style>
      .form-control {
        border: none;
        background-color: #cfcbcb;
        /* box-shadow: 0 2px 4px rgba(235, 231, 231, 0.1); */
        border-radius: 8px;
        padding: 10px 16px;
      }
      .form-control:focus {
        border-color: #80bdff;
        box-shadow: none;
        outline: 2px solid rgb(190, 16, 54);
      }
      .chart-canvas {
        background: #fff;
        /* box-shadow: 0 7px 25px rgba(0, 0, 0, 0.08); */
        transition: transform 0.3s ease;
      }
      .chart-canvas:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
      }
      .card-tale {
    border-radius: 10px;
    border: 1px solid #e3e3e3;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.card-tale .card-body {
    padding: 20px;
    text-align: center;
}

.card-tale p {
    margin: 0;
}

.card-tale p.mb-4 {
    font-size: 18px;
    color: #333;
}

.card-tale p.fs-30 {
    font-size: 30px;
    color: #009688; /* or any color you prefer */
}
.accepted-order {
    color: #28a745; /* Green color for accepted orders */
    font-weight: bold;
}

.cancelled-order {
    color: #dc3545; /* Red color for cancelled orders */
    font-weight: bold;
}

    </style>
  </head>

  <body>
    <!-- =============== Navigation ================ -->

    {{-- header file included here --}} @include('layout.adminpanel.header')

    <!-- ========================= Main ==================== -->
    <div class="main">
      <div class="topbar">
        <div class="toggle">
          <ion-icon name="menu-outline"></ion-icon>
        </div>

        <div class="user">
          <img
            src="/adminpanel/assets/images/profile-pic.avif"
            alt="profile-image"
          />
        </div>
      </div>
      @include('sweetalert::alert')
      <!-- ======================= Cards ================== -->
      <div style="background-color: #fafafa">
        <div class="items-detail">
          <span>Dashboard</span>
        </div>
        @if(session('warning'))
        <div class="alert alert-warning">{{ session('warning') }}</div>
        @endif {{--
        <p>User ID: {{ session()->get('id') }}</p>
        --}}
        <div class="cardBox">
          <div class="card">
            <div>
              {{-- admin name will appear here --}}
              <div class="cardName">
                <strong>Welcome! </strong>{{ $adminName }}
              </div>
            </div>
          </div>
        </div>
        <!-- ================ Order Details List ================= -->
        <div class="container">
          <div class="row">
            <div class="col-md-6 mb-4 col-sm-12 mb-4 ">
              <div class="card card-tale">
                <div class="card-body">
                  <p class="mb-4">Register Users</p>
                  <p class="fs-30 mb-2">{{ $userCount }}</p>
                </div>
              </div>
            </div>
            <div class="col-md-6 mb-4 col-sm-12 mb-4 ">
              <div class="card card-tale">
                  <div class="card-body">
                      <p class="mb-4">Daily Orders</p>
                      <p class="fs-20 mb-2"><span class="accepted-order">Accepted:</span> {{ $acceptedOrdersToday }}</p>
                      <p class="fs-20 mb-2"><span class="cancelled-order">Cancelled:</span> {{ $cancelledOrdersToday }}</p>
                  </div>
              </div>
          </div>
          
            <div class="col-md-6 col-sm-12 mb-2 ">
              <canvas id="monthlyEarningsChart" class="chart-canvas"></canvas>
            </div>
            <div class="col-md-6 col-sm-12">
              <canvas
                id="dailyOrdersAndEarningsChart"
                class="chart-canvas"
              ></canvas>
            </div>
          

          </div>
        </div>

        <div class="details">
          <div class="recentOrders">
            <div class="cardHeader">
              <h2>Recent Orders</h2>
            </div>

            <table>
              <thead>
                <tr>
                  {{--
                  <th style="padding-right: 50px">#</th>
                  --}}
                  <th style="padding-right: 50px">Customer-Name</th>
                  <th style="">Order-Id</th>
                  <th style="padding-right: 50px">Product-Name</th>
                  <th style="">Total Price</th>
                  <th style="padding-right: 50px">Price</th>
                  <th style="padding-right: 50px">Total-Quantity</th>
                  <th style="padding-right: 50px">Status</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($orders as $order)
                <tr>
                  {{--
                  <td style="padding-right: 50px">1</td>
                  --}}
                  <td style="padding-right: 50px">{{$order->user->name}}</td>
                  <td style="padding-right: 50px">{{$order->order_id}}</td>
                  <td style="padding-right: 50px">
                    {{optional ($order->product)->name}}
                  </td>
                  <td style="padding-right: 50px">
                    Rs {{optional ($order->product)->price}}
                  </td>
                  <td style="padding-right: 50px">
                    Rs {{$order->order_price}}
                  </td>
                  <td style="padding-right: 50px">{{$order->quantity}}</td>
                  <td>
                    @if($order->archive == 0)
                    <span class="status pending">Pending</span>
                    @elseif($order->archive == 1)
                    <span class="status delivered">Complete</span>
                    @elseif($order->archive == 2)
                    <span class="status return">Canceled</span>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <div class="pagination">
              {{ $orders->links('pagination::bootstrap-4') }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  <script src="{{ asset('adminpanel/adminjs/main.js') }}"></script>
  <script src="{{ asset('adminpanel/adminjs/chart.js') }}"></script>
  <script type="module"src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script  nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</html>
