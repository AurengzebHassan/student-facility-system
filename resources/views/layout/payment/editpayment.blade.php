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
  </style>
</head>

<body>
  <!-- =============== Navigation ================ -->

  {{-- header file included here --}}

  @include('layout.adminpanel.header')

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
        <span style="margin-right: auto;">Edit Payment Method</span>
        {{-- <a href="#" id="addItemBtn" style="margin-left: auto;" class="btn btn-danger">Add Categories</a> --}}
      </div>
      @if(session()->has('error'))
      <div class="alert alert-danger">
        {{ session('error') }}
      </div>
      @endif
      @include('sweetalert::alert')
      @if(session('warning'))
      <div class="alert alert-warning">
        {{ session('warning') }}
      </div>
      @endif

      <!-- fields start -->
      <div class="container-fluid ">
        <div class="row justify-content-center">
          <div class="col-md-12">

            <div id="itemInputs" class="item-inputs">
              <!-- Input fields for adding new item -->
              <div class="row">

                <div class="col-md-5 mt-3">
                  <form action="{{ route('updatepayment.method', ['id' => $paymentMethod->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                      <label>Name <span style="color: rgb(219, 99, 62);">*</span></label>
                      <input type="text" id="itemName" name="method_name" class="form-control" value="{{ $paymentMethod->method_name }}"
                        placeholder="Name">
                        
                    @if ($errors->has('method_name'))
                    <span class="text-danger">{{ $errors->first('method_name') }}</span>
                @endif
                    </div>
                </div>

                <div class="col-md-5 mt-3">
                    <div class="form-group">
                        <label>Account Name <span style="color: rgb(219, 99, 62);">*</span></label>
                        <input type="text" id="itemName" name="account_name" class="form-control" value="{{ $paymentMethod->account_name }}"
                          placeholder="Account Name">
                        @if($errors->has('error'))
                        <div class="alert alert-danger">
                          {{ $errors->first('error') }}
                        </div>
                        @endif
                        @if ($errors->has('account_name'))
                        <span class="text-danger">{{ $errors->first('account_name') }}</span>
                    @endif
                      </div>
                    </div>
                    <div class="col-md-5 mt-3">
                        <div class="form-group">
                            <label>Account Number<span style="color: rgb(219, 99, 62);">*</span></label>
                            <input type="text" id="itemName" name="account_number" class="form-control" value="{{ $paymentMethod->account_number }}"
                              placeholder="Account Number">
                            @if($errors->has('error'))
                            <div class="alert alert-danger">
                              {{ $errors->first('error') }}
                            </div>
                            @endif
                            @if ($errors->has('account_number'))
        <span class="text-danger">{{ $errors->first('account_number') }}</span>
    @endif

                          </div>
                        </div>
    
                        <div class="col-md-5 mt-3">
                            <div class="form-group">
                                <label>Branch<span style="color: rgb(219, 99, 62);">*</span></label>
                                <input type="text" id="itemName" name="branch" class="form-control" value="{{ $paymentMethod->branch }}"
                                  placeholder="Branch">
                                @if($errors->has('error'))
                                <div class="alert alert-danger">
                                  {{ $errors->first('error') }}
                                </div>
                                @endif
                                @if ($errors->has('branch'))
                                <span class="text-danger">{{ $errors->first('branch') }}</span>
                            @endif
                              </div>
                            </div>
                </div>
                <div class="form-group mt-3">
                  <div id="formError" class="text-danger"></div>
                  <button id="addItemBtn" type="submit" class="btn mb-2">Save</button>

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
<!-- ====== ionicons ======= -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
{{--
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



</html>