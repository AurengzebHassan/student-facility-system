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

        label {
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

        #addItemBtn {
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


        /* Modal Header */
        .modal-header {
            background-color: #6c757d;
            color: #fff;
            border-bottom: none;
            padding: 15px 20px;
        }

        /* Modal Body */
        .modal-body {
            padding: 20px;
        }

        /* Modal Footer */
        .modal-footer {
            border-top: none;
            padding: 15px 20px;
        }

        /* Close Button */
        .close {
            color: #fff;
            font-size: 28px;
        }

        /* Remove Image Checkbox */
        .form-check-label {
            font-weight: normal;
        }

        /* Remove Image Checkbox Styling */
        .form-check-input:checked+.form-check-label::before {
            background-color: #007bff;
            border-color: #007bff;
        }

        .form-check-input:checked+.form-check-label::after {
            color: #fff;
        }
    </style>
</head>

<body>
    <!-- =============== Navigation ================ -->


    @include('layout.adminpanel.header')
    @include('sweetalert::alert')
    <!-- ========================= Main ==================== -->
    <div class="main">
        <div class="topbar">
            <div class="toggle">
                <ion-icon name="menu-outline"></ion-icon>
            </div>

            <div class="user">
                <img src="/adminpanel/assets/images/profile-pic.avif" alt="profile-image">
            </div>
        </div>

        <!-- List to add item or delete item -->
        <div style="background-color: #FAFAFA;">
            <div class="items-detail">
                <span style="margin-right: auto;">Edit User</span>
                {{-- <a href="#" id="newProductBtn" style="margin-left: auto;" class="btn btn-danger">New Product</a>
                --}}
            </div>

            <!-- fields start -->
            <div class="container-fluid ">
                <div class="row justify-content-center">
                    <div class="col-md-12">

                        <div id="itemInputs" class="item-inputs">
                            <!-- Input fields for adding new item -->
                            <div class="row">

                                <div class="col-md-5 mt-3">
                                    <form action="{{ route ('updateAuthenticated.user')}}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" class="form-control" id="id" name="id" value="{{$users->id}}">

                                        <div class="form-group">
                                            <label>Name <span style="color: rgb(219, 99, 62);">*</span></label>
                                            <input type="text" id="itemName" name="name" class="form-control"
                                                value="{{ $users->name }}">
                                            @error('name') <!-- Display error message for the 'name' field -->
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                </div>

                               <div class="col-md-5 mt-3">                                   
                                        <div class="form-group">
                                            <label>Email <span style="color: rgb(219, 99, 62);">*</span></label>
                                            <input type="text" id="itemName" name="email" class="form-control"
                                                value="{{ $users->email }}" disabled>
                                            @error('email') <!-- Display error message for the 'name' field -->
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                </div>

                                <div class="col-md-5 mt-3">                                   
                                    <div class="form-group">
                                        <label>Phone <span style="color: rgb(219, 99, 62);">*</span></label>
                                        <input type="text" id="itemName" name="number" class="form-control"
                                            value="{{ $users->number }}">
                                        @error('number') <!-- Display error message for the 'name' field -->
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                            </div>

                                <div class="col-md-5 mt-3">                                   
                                        <div class="form-group">
                                            <label>Depart <span style="color: rgb(219, 99, 62);">*</span></label>
                                            <input type="text" id="itemName" name="class" class="form-control"
                                                value="{{ $users->class }}">
                                            @error('class') <!-- Display error message for the 'name' field -->
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                </div>

                                <div class="col-md-5 mt-3">                                   
                                    <div class="form-group">
                                        <label>Roll No <span style="color: rgb(219, 99, 62);">*</span></label>
                                        <input type="text" id="itemName" name="rollno" class="form-control"
                                            value="{{ $users->rollno }}">
                                        @error('rollno') <!-- Display error message for the 'name' field -->
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                            </div>
                            <div class="form-group mt-3">
                                <button id="addItemBtn" type="submit" class="btn mb-2 ">Save Changes</button>
                            </div>
                               
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ================ Order Details List ================= -->
                <!-- fields end -->
            </div>
        </div>


</body>
<!-- =========== Scripts =========  -->
<script src="{{ asset('adminpanel/adminjs/main.js') }}"></script>
<script src="{{ asset('adminpanel/adminjs/index.js') }}"></script>
<!-- ====== ionicons ======= -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
{{-- <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js" ></script> -->
--}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



</html>