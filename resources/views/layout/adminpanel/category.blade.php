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
      .items-detail {
        /* margin-top: 20px; */
        display: flex;
        align-items: center;
      }
      #addItemBtn {
        padding: 7px 24px;
        background-color: rgb(190, 16, 54);
        color: #ffff;
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

      <!-- List to add item or delete item -->
      <div style="background-color: #fafafa">
        <div class="items-detail">
          <span>Category</span>
          <a
            href="{{route ('addcategory')}}"
            style="margin-left: auto"
            id="addItemBtn"
            class="btn btn-danger"
            >New Category</a
          >
        </div>
        @if(session('warning'))
        <div class="alert alert-warning">{{ session('warning') }}</div>
        @endif @include('sweetalert::alert')
        <!-- Table to show orders detail -->
        <div class="details">
          <div class="recentOrders">
            <div class="cardHeader">
              <h2>Categories</h2>
              <form action="{{ route ('showcategory')}}" method="GET" class="form-inline">
                <div class="input-group">
                  <input
                    type="search"
                    name="search"
                    class="form-control input-search"
                    style="border-radius: 8px"
                    placeholder="Search..."
                    value="{{ $searchQuery ?? '' }}"
                  />
                  <div class="ms-2">
                    <button type="submit" class="search-btn btn">Search</button>
                  </div>
                </div>
              </form>
            </div>

            <table>
              <thead>
                <tr>
                  <th class="fw-bold">Name</th>
                  <th class="fw-bold">Description</th>
                  <th class="fw-bold">Status</th>
                  <th style="text-align: end">Actions</th>
                </tr>
              </thead>

              <tbody>
                @foreach($categories as $category)
                <tr
                  style="background-color: {{ $loop->iteration % 2 == 0 ? '#f2f2f2' : 'transparent' }}"
                >
                  <td style="padding-right: 50px" class="fw-bold">
                    {{$category->name}}
                  </td>
                  <td style="padding-right: 50px">
                    {{$category->description}}
                  </td>
                  <td style="" class="fw-bold">{{$category->status}}</td>
                  <td>
                    <a
                      href="{{ route('editcategory', ['id' => $category->id]) }}"
                      class="btn btn-primary btn-sm text-start"
                      onclick="disableLink(event, this)">Edit</a
                    >

                    <a
                      href="{{ route('deletemaincategory', ['id' => $category->id]) }}"
                      class="btn btn-danger btn-sm delete-button"
                      >Delete</a
                    >
                  </td>
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
    <script src="{{ asset('adminpanel/adminjs/loader.js') }}"></script>
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js" ></script> -->
  </body>
  <script>
    // Get all elements with the class 'delete-button'
    var deleteButtons = document.getElementsByClassName("delete-button");

    // Loop through all delete buttons
    for (var i = 0; i < deleteButtons.length; i++) {
      // Attach a click event listener to each delete button
      deleteButtons[i].addEventListener("click", function (event) {
        // Prevent the default action (i.e., following the link)
        event.preventDefault();

        // Get the URL from the delete button's href attribute
        var url = this.getAttribute("href");

        // Display the SweetAlert confirmation dialog
        Swal.fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#d33",
          cancelButtonColor: "#3085d6",
          confirmButtonText: "Yes, delete it!",
        }).then((result) => {
          // If user confirms deletion
          if (result.isConfirmed) {
            // Perform the deletion (redirect to delete URL)
            window.location.href = url;
          }
        });
      });
    }
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
