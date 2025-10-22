document.addEventListener("DOMContentLoaded", () =>{
    const profileForm = document.querySelector("#profile-form");
    const medicineForm = document.querySelector("#medicine-form");

    profileForm.addEventListener("submit", function(e) {
        const fullname = document.getElementById("fullname").value.trim();
        const email = document.getElementById("email").value.trim();
        const phoneNumber = document.getElementById("phone").value.trim();
        const specialization = document.getElementById("specialization").value.trim();
        const visitFee = document.getElementById("visit-fee").value.trim();
        const password = document.getElementById("password").value.trim();

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const phonePattern = /^[0-9]{11}$/;

        if(fullname == "" || email == "" || phoneNumber == "" || specialization == "" || visitFee == "" || password == ""){
            alert("All fields are required.");
            e.preventDefault();
        }
        else{
            if(!emailPattern.test(email)){
                alert("Please enter a valid email address.");
                e.preventDefault();
            }
            if(!phonePattern.test(phoneNumber)){
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
        const selectPatient = document.getElementById("select-patient").value.trim();
        const medicineName = document.getElementById("medicine-name").value.trim();
        const dosage = document.getElementById("dosage").value.trim();
        const duration = document.getElementById("duration").value.trim();
        const notes = document.getElementById("notes").value.trim();

        if(selectPatient == "" || medicineName == "" || dosage == "" || duration == "" || notes == ""){
            alert("All fields are required.");
            e.preventDefault();
        }
    });
});