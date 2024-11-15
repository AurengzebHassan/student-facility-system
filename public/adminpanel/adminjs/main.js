
// Menu Toggle
let toggle = document.querySelector(".toggle");
let navigation = document.querySelector(".navigation");
let main = document.querySelector(".main");

// Check if the toggle was active before
if (localStorage.getItem('toggleActive') === 'true') {
    navigation.classList.add("active");
    main.classList.add("active");
}

toggle.onclick = function () {
    // Toggle the active class for navigation and main
    navigation.classList.toggle("active");
    main.classList.toggle("active");

    // Update localStorage with the current state of the toggle
    localStorage.setItem('toggleActive', navigation.classList.contains('active'));
};
