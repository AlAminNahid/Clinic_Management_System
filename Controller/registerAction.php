<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();
    include("../Model/userModel.php");
    include("./Validation/registerValidation.php");

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phoneNumber = $_POST['phone'];
        $password = $_POST['password'];
        $confirm_Password = $_POST['confirm-pass'];
        $role = $_POST['user-type'];

        $validation = validateRegisterInput($name, $email, $phoneNumber, $role, $password, $confirm_Password);

        if($validation === true){
            if(registerUser($conn, $name, $email, $phoneNumber, $role, $password)){
                echo "Registration Successful. <a href='../View/login_reg_forget/login/login.php'>Login here</a>";
            }
            else{
                echo "Error: Could not register user.";
            }
        }
        else{
            echo $validation;
        }
    }
?>