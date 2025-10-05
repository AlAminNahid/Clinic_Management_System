document.addEventListener("DOMContentLoaded", () => {
    const profileForm = document.querySelector("#profile form");

    profileForm.addEventListener("submit", function(e) {
        const fullname = document.getElementById("fullname").value.trim();
        const email = document.getElementById("email").value.trim();
        const phone = document.getElementById("phone").value.trim();
        const password = document.getElementById("password").value.trim();

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const phonePattern = /^[0-9]{11}$/;

        if(fullname == "" || email == "" || phone == "" || password == ""){
            alert("All fields are required.");
            e.preventDefault();
        }
        if(!emailPattern.test(email)){
            alert("Please enter a valid email address.");
            e.preventDefault();
        }
        if(!phonePattern.test(phone)){
            alert("Phone number must be exactily 11 digits.");
            e.preventDefault();
        }
        if(password.length < 6){
            alert("Password must be at least 6 characters long.");
            e.preventDefault();
        }
    });
});