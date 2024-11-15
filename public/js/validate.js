// Function to handle form submission
function handleSubmit(event) {
    const paymentMethodSelect = document.getElementById('paymentMethodSelect');
    const selectedOption = paymentMethodSelect.options[paymentMethodSelect.selectedIndex];
    const paymentImageInput = document.getElementById('paymentImageInput');
    const paymentImage = paymentImageInput.files[0]; // Get the selected image file

    // If payment method is not cash_on_delivery and no image is uploaded
    if (selectedOption.value !== 'cash_on_delivery' && (!paymentImage || !paymentImage.type.includes('image'))) {
        event.preventDefault(); // Prevent form submission
        alert('Please upload a valid image file before confirming the order (JPEG or PNG format).');
    }
}

// Function to show/hide payment method details and image upload field
function showPaymentMethodDetails() {
    const paymentMethodSelect = document.getElementById('paymentMethodSelect');
    const selectedOption = paymentMethodSelect.options[paymentMethodSelect.selectedIndex];
    const paymentMethodDetails = document.getElementById('paymentMethodDetails');
    const paymentImageInput = document.getElementById('paymentImageInput');
    const paymentImageLabel = document.getElementById('paymentImageLabel');

    if (selectedOption.value === 'cash_on_delivery') {
        paymentMethodDetails.style.display = 'none'; // Hide details for Cash On Delivery
        paymentImageInput.style.display = 'none'; // Hide image 
        paymentImageLabel.style.display = 'none'; // Hide image 
    } else {
        paymentMethodDetails.style.display = 'block'; // Show details for other payment methods
        paymentImageInput.style.display = 'block'; // Show image 
        paymentImageLabel.style.display = 'block'; // Show image 
    }
}

// Event listener for dropdown menu selection
document.getElementById('paymentMethodSelect').addEventListener('change', showPaymentMethodDetails);

// Event listener for form submission
document.getElementById('orderForm').addEventListener('submit', handleSubmit);
