<?php
    function validateLoginInput($email, $password){
        if(empty($email) || empty($password)){
            return "Email and Password are required.";
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return "Invalid email format.";
        }

        return true;
    }
?>