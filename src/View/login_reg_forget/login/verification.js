document.addEventListener("DOMContentLoaded", function(){
    const form = document.querySelector("form");
    const messageBox = document.querySelector("[data-form-message]");
    const email = document.querySelector("input[name='email']");
    const password = document.querySelector("input[name='password']");

    function showMessage(message, fields){
        messageBox.textContent = message;
        messageBox.classList.add("is-visible");
        fields.forEach(function(field){
            field.classList.add("is-invalid");
        });
    }

    function clearMessage(){
        messageBox.textContent = "";
        messageBox.classList.remove("is-visible");
        [email, password].forEach(function(field){
            field.classList.remove("is-invalid");
        });
    }

    [email, password].forEach(function(field){
        field.addEventListener("input", clearMessage);
    });

    form.addEventListener("submit", function(e){
        clearMessage();

        const invalidFields = [];
        if(email.value.trim() === ""){
            invalidFields.push(email);
        }
        if(password.value.trim() === ""){
            invalidFields.push(password);
        }

        if(invalidFields.length > 0){
            e.preventDefault();
            showMessage("Please enter your email and password to continue.", invalidFields);
            invalidFields[0].focus();
        }
    });
});
