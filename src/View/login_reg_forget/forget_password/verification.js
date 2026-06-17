document.addEventListener("DOMContentLoaded", function(){
    const form = document.querySelector("form");
    const messageBox = document.querySelector("[data-form-message]");
    const email = document.querySelector("input[name='email']");
    const password = document.querySelector("input[name='password']");
    const confirmPassword = document.querySelector("input[name='confirm_password']");
    const fields = [email, password, confirmPassword];

    function showMessage(message, invalidFields){
        messageBox.textContent = message;
        messageBox.classList.add("is-visible");
        invalidFields.forEach(function(field){
            field.classList.add("is-invalid");
        });
    }

    function clearMessage(){
        messageBox.textContent = "";
        messageBox.classList.remove("is-visible");
        fields.forEach(function(field){
            field.classList.remove("is-invalid");
        });
    }

    fields.forEach(function(field){
        field.addEventListener("input", clearMessage);
    });

    form.addEventListener("submit", function(e){
        clearMessage();

        const emptyFields = fields.filter(function(field){
            return field.value.trim() === "";
        });

        if(emptyFields.length > 0){
            e.preventDefault();
            showMessage("Please enter your email, new password, and confirmation.", emptyFields);
            emptyFields[0].focus();
            return;
        }

        if(password.value !== confirmPassword.value){
            e.preventDefault();
            showMessage("Passwords do not match. Please confirm the same new password.", [password, confirmPassword]);
            confirmPassword.focus();
        }
    });
});
