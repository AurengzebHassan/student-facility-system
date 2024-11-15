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
            <span style="margin-right: auto;">Add Products</span>
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
                   
                    <div id="itemInputs" class="item-inputs" >
                        <!-- Input fields for adding new item -->
                        <div class="row">
                          
                            <div class="col-md-5 mt-3">
                                <form action="{{ route('addproducts') }}" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                                    @csrf
                                    
                                    <div class="form-group">
                                        <label>Name <span style="color: rgb(219, 99, 62);">*</span></label>
                                        <input type="text" id="itemName" name="name" class="form-control" value="{{ old('name') }}" placeholder="Item Name">
                                        @if($errors->has('error'))
                                  <div class="alert alert-danger">
                                {{ $errors->first('error') }}
                               </div>
                              @endif
                                    </div>
                                </div>
                                    <div class="col-md-5 mt-3">
                                        <div class="form-group">
                                            <label>Description <span style="color: rgb(219, 99, 62);">*</span></label>
                                            <textarea id="itemDescription" name="description" value="{{ old('description') }}" class="form-control" placeholder="Item Description">{{ old('description') }}</textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-5 mt-3">
                                        <div class="form-group">
                                            <label>Price <span style="color: rgb(219, 99, 62);">*</span></label>
                                            <input type="number" id="itemPrice" name="price" value="{{ old('price') }}" class="form-control" placeholder="Item Price">
                                            {{-- <span id="priceError" class="text-danger input-message"></span> --}}
                                        </div>
                                    </div>
                                    <div class="col-md-5 mt-3">
                                        <div class="form-group">
                                            <label>Total Quantity <span style="color: rgb(219, 99, 62);">*</span></label>
                                            <input type="number" id="totalQuantity" name="total_quantity" value="{{ old('total_quantity') }}" class="form-control" placeholder="Total Quantity">
                                            {{-- <span id="totalQuantityError" class="text-danger input-message"></span> --}}
                                        </div>
                                    </div>
                                    <div class="col-md-5 mt-3">
                                        <div class="form-group">
                                            <label>Image <span style="color: rgb(219, 99, 62);">*</span></label>
                                            <input type="file" id="itemImage" name="image"  class="form-control">
                                            <img id="imagePreview" src="#" alt="Preview" style="margin: 0 auto; max-width: 50%; height: 50%; margin-top: 5px; display: none;">
                                            {{-- <span id="imageError" class="text-danger input-message"></span> --}}
                                        </div>
                                    </div>
                                    <div class="col-md-5 mt-3">
                                        <div class="form-group">
                                            <label>Main Categories <span style="color: rgb(219, 99, 62);">*</span></label>
                                            <select class="form-control" id="main_category" name="category_id">
                                                <option label="Select Main Category" disabled selected class="fw-bold"></option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{-- Sub-categories --}}
                                    <div class="col-md-5 mt-3">
                                        <div class="form-group">
                                            <label>Subcategories <span style="color: rgb(219, 99, 62);">*</span></label>
                                            <select class="form-control" id="subcategory" name="subcategory_id" disabled>
                                                <option label="Select Subcategory" disabled selected class="fw-bold"></option>
                                            </select>
                                        </div>
                                    </div>
                                    @if ($errors->has('subcategoryerror'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('subcategoryerror') }}
                                    </div>
                                @endif                                   
                                    <div class="form-group mt-3">
                                        <div id="formError" class="text-danger"></div>
                                        <button id="addItemBtn" type="submit" class="btn mb-2" >Create</button>
                                        
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
    {{-- <script src="{{ asset('adminpanel/adminjs/index.js') }}"></script> --}}
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
     {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js" ></script>  --}}
    
        <script>


   // Function to display image preview
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block'; 
        }
        reader.readAsDataURL(input.files[0]); 
    } else {
        preview.src = '#';
        preview.style.display = 'none'; 
    }
}

// Listen for the change event on the file input
document.getElementById('itemImage').addEventListener('change', function() {
    previewImage(this);
});


function validateForm() {
    // Get form fields
    var itemName = document.getElementById('itemName').value.trim();
    var itemDescription = document.getElementById('itemDescription').value.trim();
    var itemPrice = document.getElementById('itemPrice').value.trim();
    var totalQuantity = document.getElementById('totalQuantity').value.trim();
    var itemImage = document.getElementById('itemImage').value.trim();
    var mainCategory = document.getElementById('main_category').value.trim(); // Get selected main category
    var subcategory = document.getElementById('subcategory').value.trim(); // Get selected subcategory

    // Check if any field is empty
    if (itemName === '' || itemDescription === '' || itemPrice === '' || totalQuantity === '' || itemImage === '' || mainCategory === '' || subcategory === '') {
        document.getElementById('formError').textContent = 'All fields are required';
        return false; 
    }
    return true;
}



        $(document).ready(function() {
        $('#main_category').change(function() {
            var categoryId = $(this).val();
            // Send an AJAX request to fetch subcategories for the selected category
            $.ajax({
                url: '/get-subcategories/' + categoryId,
                type: 'GET',
                success: function(response) {
                    $('#subcategory').empty();
                    $('#subcategory').append($('<option>', {
                        value: '',
                        text: 'Select Subcategory'
                    }));
                    $.each(response.subcategories, function(key, value) {
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