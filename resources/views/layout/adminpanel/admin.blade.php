<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- CSS only -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    />

    <title>Canteen Management System</title>
    <!-- ======= Styles ====== -->
    <link
      rel="stylesheet"
      href="{{ asset('adminpanel/adminpanelcss/style.css') }}"
    />
    <link
      rel="stylesheet"
      href="{{ asset('adminpanel/adminpanelcss/dashbaord.css') }}"
    />

    <link
      rel="icon"
      type="image/svg+xml"
      href="{{ asset('assets/images/Logjo.svg') }}?v={{ time() }}"
    />
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

      .search-btn:hover {
        background-color: #fc8019;
        /* transform: translateX(10px); */
        color: #fff;
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
        {{--
        <a href="#">
          <i class="fas fa-bell bell-icon"></i>
        </a>
        --}}
        <div class="user">
          <img
            src="/adminpanel/assets/images/profile-pic.avif"
            alt="profile-image"
          />
        </div>
      </div>

      <!-- List to add item or delete item -->
      <div style="background-color: #fafafa">
        <div class="items-detail">
          <span>Admin</span>
          <!-- <a href="" style="margin-left: auto;" class="btn btn-danger ">New Products</a> -->
        </div>
        @if(session('warning'))
        <div class="alert alert-warning">{{ session('warning') }}</div>
        @endif
        <!-- Table to show orders detail -->
        <div class="details">
          <div class="recentOrders">
            <div class="cardHeader">
            </div>
            @include('sweetalert::alert')
            <table>
              <thead>
                <tr>
                  <th class="fw-bold">Name</th>
                  <th class="fw-bold">Email</th>
                  <th>Role</th>
                  <th style="text-align: center">Username</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($admins as $admin)
                <tr
                  style="background-color: {{ $loop->iteration % 2 == 0 ? '#f2f2f2' : 'transparent' }}"
                >
                  <td style="padding-right: 50px" class="fw-bold">
                    {{ $admin->name }}
                  </td>
                  <td style="padding-right: 50px">{{ $admin->email }}</td>

                  <td style="padding-right: 50px">{{$admin->role}}</td>
                  <td style="padding-right: 50px">{{ $admin->username }}</td>
                  {{--
                  <td style="padding-right: 50px">{{ $user->class }}</td>
                  --}}
                </tr>
                @endforeach
              </tbody>
            </table>
            <div class="pagination mt-2">
              {{-- {{ $orders->links('pagination::bootstrap-4') }} --}}
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- =========== Scripts =========  -->
    <script src="{{ asset('adminpanel/adminjs/main.js') }}"></script>

    <!-- ====== ionicons ======= -->
    <script
      type="module"
      src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"
    ></script>
    <script
      nomodule
      src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"
    ></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js" ></script> -->
  </body>
</html>
