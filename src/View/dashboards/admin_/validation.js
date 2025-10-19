document.addEventListener("DOMContentLoaded", () => {
    const profileForm = document.querySelector("#profile form");
    const medicineForm = document.querySelector("#medicines form");

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
        else{
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
        }
    });

    medicineForm.addEventListener("submit", function(e) {
        const name = document.getElementById("medicine-name").value.trim();
        const type = document.getElementById("medicine-type").value;
        const strength = document.getElementById("medicine-strength").value.trim();
        const manufacturer = document.getElementById("medicine-manufacturer").value.trim();
        const status = document.getElementById("medicine-status").value;

        if(name === "" || type === "" || strength === "" || manufacturer === "" || status === ""){
            alert("All fields are required for adding a medicine.");
            e.preventDefault();
        }
        else{
            if(strength.length < 1 || isNaN(strength)){
                alert("Strength must be a valid number.");
                e.preventDefault();
            }
        }
    });
});