document.addEventListener("DOMContentLoaded", function(){
    const form = document.querySelector("form");
    const messageBox = document.querySelector("[data-form-message]");
    const fields = [
        document.querySelector("input[name='name']"),
        document.querySelector("input[name='email']"),
        document.querySelector("input[name='phone']"),
        document.querySelector("select[name='user-type']"),
        document.querySelector("input[name='password']"),
        document.querySelector("input[name='confirm-pass']")
    ];
    const password = document.querySelector("input[name='password']");
    const confirmPassword = document.querySelector("input[name='confirm-pass']");

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
        field.addEventListener("change", clearMessage);
    });

    form.addEventListener("submit", function(e){
        clearMessage();

        const emptyFields = fields.filter(function(field){
            return field.value.trim() === "";
        });

        if(emptyFields.length > 0){
            e.preventDefault();
            showMessage("Please complete all registration fields before creating an account.", emptyFields);
            emptyFields[0].focus();
            return;
        }

        if(password.value !== confirmPassword.value){
            e.preventDefault();
            showMessage("Passwords do not match. Please re-enter your password confirmation.", [password, confirmPassword]);
            confirmPassword.focus();
        }
    });
});
