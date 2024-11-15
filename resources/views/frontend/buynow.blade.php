<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Canteen Management System</title>

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/Logjo.svg') }}?v={{ time() }}" />

    <link rel="stylesheet" href="{{ asset('css/buynow.css') }}">
<style>
.payment-method {
    margin-bottom: 20px;
}

.payment-method span {
    display: block;
    font-size: 16px;
    margin-bottom: 5px;
}

.styled-select {
    position: relative;
    display: inline-block;
    width: 100%;
}

.styled-select select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    width: 100%;
    padding: 10px 40px 10px 15px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #fff;
    background-image: linear-gradient(to bottom, #ffffff, #f2f2f2);
    color: #333;
    cursor: pointer;
}

.styled-select::after {
    content: '\25BC'; /* Down arrow */
    position: absolute;
    top: 50%;
    right: 15px;
    transform: translateY(-50%);
    font-size: 18px;
    color: #888;
    pointer-events: none;
}

.styled-select select:focus {
    outline: none;
    border-color: #007bff;
}

.styled-select select option {
    padding: 10px;
    background-color: #fff;
    color: #333;
}

.styled-select select option:hover {
    background-color: #f0f0f0;
}
#paymentMethodDetails {
    display: none;
    border: 1px solid #e0e0e0;
    background-color: #f9f9f9;
    padding: 20px;
    margin-top: 20px;
    border-radius: 5px;
}

#paymentMethodDetails span {
    display: block;
    margin-bottom: 10px;
    font-size: 16px;
}

#paymentImageLabel {
    display: block;
    margin-top: 20px;
    cursor: pointer;
    color: #007bff;
    font-weight: bold;
    text-decoration: none;
}

#paymentImageLabel:hover {
    text-decoration: underline;
}

#paymentImageInput {
    display: none;
}

/* Style for file input button */
.custom-file-input {
    color: transparent;
}

.custom-file-input::-webkit-file-upload-button {
    visibility: hidden;
}

.custom-file-input::before {
    content: 'Select Image';
    display: inline-block;
} 

</style>
</head>
<body>

    <div class="py-3 py-md-5 ">
        <div class="container">
            <div class="row">
                @include('sweetalert::alert')
                <div class="col-md-5 mt-3">
                    <form id="orderForm" method="POST" action="{{ route('confirm.order') }}" onsubmit="showLoader() && handleSubmit(event) " enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <input type="hidden" name="order_quantity" value="1"> <!-- Assuming default quantity is 1 -->
                        <input type="hidden" name="order_price" value="{{ $product->price }}"> <!-- Assuming order price is same as product price -->
                    <div class="bg-white border">
                        <img src="{{ asset('product/images/' . $product->image) }}" class="w-100" alt=" {{ $product->name }}"> <!-- Display product image dynamically -->
                    </div>
                </div>
                <div class="col-md-7 mt-3">
                    <div class="product-view">
                        <h4 class="product-name fw-bold ">
                            {{ $product->name }} <!-- Display product name dynamically -->
                            <label class="label-stock">In Stock</label>
                        </h4>
                        <hr>
                        <div>
                            <span class="selling-price" id="price" name="order_price">Rs {{ $product->price }}</span> <!-- Display product price dynamically -->
                        </div>
                        <div class="payment-method">
                            <span class="fw-bold" style="font-size:18px;">Choose Payment Method</span>
                            {{-- <div class="styled-select">
                                <select name="id" id="paymentMethodSelect">
                                    
                                </select>
                            </div> --}}
                            <div class="payment-method">
                                {{-- <span class="fw-bold" style="font-size: 18px;">Choose Payment Method</span> --}}
                                <div class="styled-select">
                                    <select name="payment_method_id" id="paymentMethodSelect">
                                        {{-- <option value="cash_on_delivery" selected>Cash on Delivery</option> <!-- Selected by default --> --}}
                                        @foreach($payment_methods as $payment_method)
                                            <option value="{{ $payment_method->id }}">{{ $payment_method->method_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div id="paymentMethodDetails" style="display: none;">
                                <span id="accountName" name="account_name"></span><br>
                                <span id="accountNumber" name="account_number"></span><br>
                                <span id="branch" name="branch"></span><br>
                                <label for="paymentImageInput" id="paymentImageLabel" style="display: none;">Upload Payment Image</label>
                                <input type="file" id="paymentImageInput" name="image" style="display: none;">
                            </div>
                        
                        
                        <div class="mt-2">
                            <div class="input-group">
                                <span class="btn btn1" id="decrement"><i class="fa fa-minus"></i></span>
                                <input type="number" value="1" name="quantity" class="input-quantity" id="quantity" min="1" required />
                                <span class="btn btn1" id="increment"><i class="fa fa-plus"></i></span>
                                
                            </div>
                            <button class="ms-auto btn mt-3 login-btn confirm-btn" style="background-color: #e21b70; color:#fff;">Confirm <span id="loader" style="display:none;">Loading...</span></button>
                        </div>
                        <div class="mt-3">
                            <h5 class="mb-0 fw-bold " style="color: #FF6826;">Small Description</h5>
                            <p>
                                {{ $product->description }} <!-- Display product description dynamically -->
                            </p>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/index.js') }}"></script>
<script src="{{ asset('js/validate.js') }}"></script>
<script src="{{ asset('adminpanel/adminjs/loader.js') }}"></script>
<script>
    // Get elements
    const incrementBtn = document.getElementById('increment');
    const decrementBtn = document.getElementById('decrement');
    const priceDisplay = document.getElementById('price');
    const quantityInput = document.getElementById('quantity');
    const totalPriceInput = document.getElementById('total_price'); // Add this line

    // Set initial price and quantity
    let price = {{ $product->price }};
    let quantity = 1;

    // Function to update price and quantity
    function updatePriceAndQuantity() {
        const totalPrice = price * quantity;
        priceDisplay.textContent = `Price: Rs ${totalPrice}`;
        totalPriceInput.value = totalPrice; // Update the hidden input field with the total price
    }

    // Event listener for increment button
    incrementBtn.addEventListener('click', () => {
        quantity++;
        quantityInput.value = quantity;
        updatePriceAndQuantity();
    });

    // Event listener for decrement button
    decrementBtn.addEventListener('click', () => {
        if (quantity > 1) {
            quantity--;
            quantityInput.value = quantity;
            updatePriceAndQuantity();
        }
    });

    // Event listener for input change
    quantityInput.addEventListener('change', () => {
        // Validate if the input is a number greater than 0
        if (isNaN(quantityInput.value) || parseInt(quantityInput.value) < 1) {
            quantityInput.value = 1;
        }
        quantity = parseInt(quantityInput.value);
        updatePriceAndQuantity();
    });



// Function to fetch payment methods and their details from the backend
function fetchPaymentMethodsAndDetails() {
    fetch('/get-payment-methods-and-details')
        .then(response => response.json())
        .then(data => {
            const paymentMethodSelect = document.getElementById('paymentMethodSelect');
            // Clear existing options
            paymentMethodSelect.innerHTML = '';
            // Add "Cash On Delivery" option
            const cashOnDeliveryOption = document.createElement('option');
            cashOnDeliveryOption.value = 'cash_on_delivery';
            cashOnDeliveryOption.textContent = 'Cash On Delivery';
            paymentMethodSelect.appendChild(cashOnDeliveryOption);
            // Populate options from fetched data
            data.forEach(method => {
                const option = document.createElement('option');
                option.value = method.value;
                option.textContent = method.label;
                paymentMethodSelect.appendChild(option);

                // Store details as data attribute of option
                option.dataset.details = JSON.stringify(method.details);
            });
            // Trigger change event to fetch details for the default selected method
            paymentMethodSelect.dispatchEvent(new Event('change'));
        })
        .catch(error => console.error('Error fetching payment methods and details:', error));
}

document.getElementById('paymentMethodSelect').addEventListener('change', function() {
    var paymentMethod = this.value; // Get selected payment method
    if (paymentMethod === 'cash_on_delivery') {
        // For Cash On Delivery, hide the details
        document.getElementById('paymentMethodDetails').style.display = 'none';
    } else {
        // For other payment methods, retrieve and display details
        var details = JSON.parse(this.options[this.selectedIndex].dataset.details);
        document.getElementById('accountName').innerText = 'Account Name: ' + details.accountName;
        document.getElementById('accountNumber').innerText = 'Account Number: ' + details.accountNumber;
        document.getElementById('branch').innerText = 'Branch: ' + details.branch;
        document.getElementById('paymentMethodDetails').style.display = 'block';
    }
});

// Fetch payment methods and their details when the page loads
document.addEventListener('DOMContentLoaded', function() {
    fetchPaymentMethodsAndDetails();
});


</script>


</html>