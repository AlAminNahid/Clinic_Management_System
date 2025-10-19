<?php
    function validateAdminProfileInput($name, $email, $phoneNumber, $password){
        if(empty($name) || empty($email) || empty($phoneNumber) || empty($password)){
            return "All fields are required.";
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return "Invalid email format.";
        }
        if(!preg_match("/^[0-9]{11}$/", $phoneNumber)){
            return "Phone number must be exactly 11 digits.";
        }

        return true;
    }
?>