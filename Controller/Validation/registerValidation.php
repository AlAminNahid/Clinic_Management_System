<?php
    function validateRegisterInput($name, $email, $phoneNumber, $role, $password, $confirm_password){
        if(empty($name) || empty($email) || empty($phoneNumber) || empty($role) || empty($password) || empty($confirm_password)){
            return "All fields are required.";
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return "Invalid email format.";
        }
        if($password !== $confirm_password){
            return "Password do not match.";
        }
        if(!in_array($role, ['admin', 'doctor', 'patient'])){
            return "Invalid role selected.";
        }

        return true;
    }
?>