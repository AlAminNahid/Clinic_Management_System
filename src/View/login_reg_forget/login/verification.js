document.addEventListener("DOMContentLoaded", function(){
    const form = document.querySelector("form");

    form.addEventListener("submit", function(e){
        const email = document.querySelector("input[name='email']").value;
        const password = document.querySelector("input[name='password']").value;

        if(email.trim() === "" || password.trim() === ""){
            alert("Email and Password cannot be empty.");
            e.preventDefault();
        }
    });
});