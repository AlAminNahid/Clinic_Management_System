<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();
    include("../Model/userModel.php");
    include("../Validation/log_reg_forget/registerValidation.php");

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
                echo "
                    <script>
                        alert('Registration Successful!');
                        window.location.href = '../View/login_reg_forget/login/login.php';
                    </script>
                ";
                exit;   
            }
            else{
                echo "
                    <script>
                        alert('Error: Could not register user.');
                    </script>
                ";
            }
        }
        else{
            echo "
                <script>
                    alert('$validation');
                    window.location.href = '../View/login_reg_forget/registration/reg.php';
                </script>
            ";
        }
    }
?>