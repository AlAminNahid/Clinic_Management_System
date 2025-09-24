document.addEventListener("DOMContentLoaded", function(){
    const form = document.querySelector("form");

    form.addEventListener("submit", function(e){
        const name = document.querySelector("input[name='name']").value;
        const email = document.querySelector("input[name='email']").value;
        const phoneNumber = document.querySelector("input[name='phone']").value;
        const userType = document.querySelector("select[name='user-type']").value;
        const password = document.querySelector("input[name='password']").value;
        const confirmPassword = document.querySelector("input[name='confirm-pass']").value;

        if(name.trim() === "" || email.trim() === "" || phoneNumber.trim() === "" || userType.trim() === "" || password.trim()){
            alert("All fields are required.");
            e.preventDefault();
        }
        if(password !== confirmPassword){
            alert("Passwords do not match.");
            e.preventDefault();
        }
    });
});