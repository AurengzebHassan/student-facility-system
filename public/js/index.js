function formValidation() {
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const message = document.getElementById('message').value;
  
    const englishLettersPattern = /^[a-zA-Z .!,]+$/;
    const emailPattern = /^[a-zA-Z0-9._-]+@(gmail\.com|[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4})$/;
  
    let errorsFound = false;
  
    if (name.length < 3 || !englishLettersPattern.test(name)) {
      document.getElementById("nameError").textContent = "Name must be 3 characters and contain only alphabets";
      errorsFound = true;
    } else {
      document.getElementById("nameError").textContent = "";
    }
  
    if (!email.match(emailPattern)) {
      document.getElementById("emailError").textContent = "Please enter a valid email";
      errorsFound = true;
    } else {
      document.getElementById("emailError").textContent = "";
    }
  
    if (message.length < 20 || !englishLettersPattern.test(message)) {
      document.getElementById("messageError").textContent = "Message must be at least 20 characters and contain only alphabets";
      errorsFound = true;
    } else {
      document.getElementById("messageError").textContent = "";
    }
  
    if (errorsFound) {
      
      return false;
    }
    return true;
  }
  
  // code for product slider
   //
   document.addEventListener("DOMContentLoaded", function() {
    var itemSlider = document.getElementById('itemslider');
    var interval = 3000;
    var items = document.querySelectorAll('.carousel-showmanymoveone .item');

    // setInterval(function() {
    //     var event = new Event('click');
    //     itemSlider.dispatchEvent(event);
    // }, interval);

    items.forEach(function(item) {
        var itemToClone = item;

        for (var i = 1; i < 4; i++) {
            itemToClone = itemToClone.nextElementSibling || item.parentElement.firstElementChild;

            var clonedItem = itemToClone.firstElementChild.cloneNode(true);
            clonedItem.classList.add("cloneditem-" + i);
            item.appendChild(clonedItem);
        }
    });
});

