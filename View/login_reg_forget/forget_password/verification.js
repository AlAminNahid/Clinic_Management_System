document.addEventListener("DOMContentLoaded", function(){
    const form = document.querySelector("form");

    form.addEventListener("submit", function(e){
        const email = document.querySelector("input[name='email']").value;
        const password = document.querySelector("input[name='password']").value;
        const confirmPassword = document.querySelector("input[name='confirm_password']").value;

        if(email.trim() === "" || password.trim() === "" || confirmPassword.trim() === ""){
            alert("All fields are required.");
            e.preventDefault();
        }
        if(password !== confirmPassword){
            alert("Password do not match.");
            e.preventDefault();
        }
    });
});