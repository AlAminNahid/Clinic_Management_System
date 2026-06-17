document.addEventListener("DOMContentLoaded", () => {
    const profileForm = document.querySelector("#profile form");
    const medicineForm = document.querySelector("#medicines form");

    function showMessage(form, message, fields){
        const messageBox = form.querySelector("[data-form-message]");
        messageBox.textContent = message;
        messageBox.classList.add("is-visible");
        fields.forEach(field => field.classList.add("is-invalid"));
    }

    function clearMessage(form){
        const messageBox = form.querySelector("[data-form-message]");
        messageBox.textContent = "";
        messageBox.classList.remove("is-visible");
        form.querySelectorAll(".is-invalid").forEach(field => field.classList.remove("is-invalid"));
    }

    function bindClear(form){
        form.querySelectorAll("input, select").forEach(field => {
            field.addEventListener("input", () => clearMessage(form));
            field.addEventListener("change", () => clearMessage(form));
        });
    }

    if(profileForm){
        bindClear(profileForm);

        profileForm.addEventListener("submit", function(e) {
            clearMessage(profileForm);

            const fullname = document.getElementById("fullname");
            const email = document.getElementById("email");
            const phone = document.getElementById("phone");
            const password = document.getElementById("password");
            const fields = [fullname, email, phone, password];
            const emptyFields = fields.filter(field => field.value.trim() === "");

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const phonePattern = /^[0-9]{11}$/;

            if(emptyFields.length > 0){
                e.preventDefault();
                showMessage(profileForm, "Please complete all profile fields before saving.", emptyFields);
                emptyFields[0].focus();
                return;
            }

            if(!emailPattern.test(email.value.trim())){
                e.preventDefault();
                showMessage(profileForm, "Please enter a valid email address.", [email]);
                email.focus();
                return;
            }

            if(!phonePattern.test(phone.value.trim())){
                e.preventDefault();
                showMessage(profileForm, "Phone number must be exactly 11 digits.", [phone]);
                phone.focus();
                return;
            }

            if(password.value.trim().length < 6){
                e.preventDefault();
                showMessage(profileForm, "Password must be at least 6 characters long.", [password]);
                password.focus();
            }
        });
    }

    if(medicineForm){
        bindClear(medicineForm);

        medicineForm.addEventListener("submit", function(e) {
            clearMessage(medicineForm);

            const name = document.getElementById("medicine-name");
            const type = document.getElementById("medicine-type");
            const strength = document.getElementById("medicine-strength");
            const manufacturer = document.getElementById("medicine-manufacturer");
            const status = document.getElementById("medicine-status");
            const fields = [name, type, strength, manufacturer, status];
            const emptyFields = fields.filter(field => field.value.trim() === "");

            if(emptyFields.length > 0){
                e.preventDefault();
                showMessage(medicineForm, "Please complete all medicine fields before adding it.", emptyFields);
                emptyFields[0].focus();
                return;
            }

            if(strength.value.trim().length < 1 || isNaN(strength.value.trim())){
                e.preventDefault();
                showMessage(medicineForm, "Strength must be a valid number.", [strength]);
                strength.focus();
            }
        });
    }
});
