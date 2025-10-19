<?php
    function validPasswordReset($email, $password, $confirm_password){
        if(empty($email) || empty($password) || empty($confirm_password)){
            return "All fields are required.";
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return "Invalid email format.";
        }
        if($password !== $confirm_password){
            return "Password do not match.";
        }

        return true;
    }
?>