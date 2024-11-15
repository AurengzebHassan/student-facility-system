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
                <span style="margin-right: auto;">Edit products</span>
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
                                    <form action="{{ route('products.update') }}" method="post"
                                        enctype="multipart/form-data" onsubmit="return validateTotalQuantity()">
                                        @csrf
                                        @isset($product)
                                        <div class="form-group">
                                            <label>Name <span style="color: rgb(219, 99, 62);">*</span></label>
                                            <input type="text" id="itemName" name="name" class="form-control"
                                                value="{{ $product->name }}">
                                            @error('name') <!-- Display error message for the 'name' field -->
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                </div>
                                <div class="col-md-5 mt-3">
                                    <div class="form-group">
                                        <label>Description <span style="color: rgb(219, 99, 62);">*</span></label>
                                        <input type="text" id="itemDescription" name="description" class="form-control"
                                            value="{{ $product->description }}">
                                        @error('description') <!-- Display error message for the 'name' field -->
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-5 mt-3">
                                    <div class="form-group">
                                        <label>Price <span style="color: rgb(219, 99, 62);">*</span></label>
                                        <input type="number" id="itemPrice" name="price" class="form-control"
                                            value="{{ $product->price }}">
                                        @error('price') <!-- Display error message for the 'name' field -->
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-5 mt-3">
                                    <div class="form-group">
                                        <label>Total Quantity <span style="color: rgb(219, 99, 62);">*</span></label>
                                        <input type="number" id="totalQuantity" name="total_quantity"
                                            class="form-control" value="{{ $product->total_quantity }}">
                                        @error('total_quantity') <!-- Display error message for the 'name' field -->
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div id="warningMessage" class="alert alert-warning d-none"></div>
                                </div>
                                
                                <div class="col-md-5 mt-3">
                                    <div class="form-group">
                                        <label>Image <span style="color: rgb(219, 99, 62);">*</span></label>
                                        <input type="file" id="itemImage" name="image" class="form-control">
                                        <!-- Remove display: none; from the style attribute -->
                                        <img id="imagePreview" src="{{ asset('product/images/' . $product->image) }}"
                                            alt="Preview"
                                            style="margin: 0 auto; max-width: 50%; height: 50%; margin-top: 5px;">
                                    </div>
                                    @error('image') <!-- Display error message for the 'name' field -->
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-5 mt-3">
                                    <div class="form-group">
                                        <label>Main Categories <span style="color: rgb(219, 99, 62);">*</span></label>
                                        <select class="form-control" id="main_category" name="category_id">
                                            <option label="Select Main Category" disabled selected class="fw-bold">
                                            </option>
                                            @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ $product->category_id ==
                                                $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Sub-categories --}}
                                <div class="col-md-5 mt-3">
                                    <div class="form-group">
                                        <label>Subcategories <span style="color: rgb(219, 99, 62);">*</span></label>
                                        <select class="form-control" id="subcategory" name="subcategory_id">
                                            <option label="Select Subcategory" disabled selected class="fw-bold">
                                            </option>
                                            @foreach ($subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}" {{ $product->subcategory_id ==
                                                $subcategory->id ? 'selected' : '' }}>
                                                {{ $subcategory->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @error('subcategory_id')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                                @enderror

                                <div class="col-md-5 mt-3">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <!-- Checkbox to reset remaining quantity -->
                                            <input style="margin-top: 13px" class="form-check-input"  type="checkbox" id="reset_remaining_quantity" name="reset_remaining_quantity"  value="{{ $product->remaining_quantity }}">
                                            <label class="form-check-label  " for="reset_remaining_quantity">
                                                Reset Remaining Quantity
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                

                                <div class="form-group mt-3">
                                    <button id="addItemBtn" type="submit" class="btn mb-2 ">Save Changes</button>
                                </div>
                                <input type="hidden" class="form-control" id="uuid" name="uuid"
                                    value="{{$product->uuid}}">
                                @endisset
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

<script>
  function validateTotalQuantity() {
    var totalQuantityInput = document.getElementById('totalQuantity');
    var remainingQuantity = parseInt("{{ $product->remaining_quantity }}");
    var totalQuantity = parseInt(totalQuantityInput.value);
    
    // Calculate the new remaining quantity after updating total quantity
    var newRemainingQuantity = remainingQuantity + (totalQuantity - {{ $product->total_quantity }});
    
    // Check if the admin wants to reset the remaining quantity
    var resetRemainingQuantity = document.getElementById('reset_remaining_quantity').checked;

    // If reset remaining quantity is checked, set new remaining quantity to null
    if (resetRemainingQuantity) {
        newRemainingQuantity = null;
    }

    // Check if the new remaining quantity is negative
    if (newRemainingQuantity < 0) {
        var warningMessage = document.getElementById('warningMessage');
        warningMessage.innerText = 'Total quantity cannot make remaining quantity negative.';
        warningMessage.classList.remove('d-none');
        return false; 
    }

    return true; 
}



    $(document).ready(function () {
        $('#main_category').change(function () {
            var categoryId = $(this).val();
            // Send an AJAX request to fetch subcategories for the selected category
            $.ajax({
                url: '/get-subcategories/' + categoryId,
                type: 'GET',
                success: function (response) {
                    $('#subcategory').empty();
                    $('#subcategory').append($('<option>', {
                        value: '',
                        text: 'Select Subcategory'
                    }));
                    $.each(response.subcategories, function (key, value) {
                        $('#subcategory').append($('<option>', {
                            value: value.id,
                            text: value.name
                        }));
                    });
                    $('#subcategory').prop('disabled', false);
                }
            });
        });
    });

</script>

</html>