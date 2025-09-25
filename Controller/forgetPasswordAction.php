<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include("../Model/userModel.php");
    include("./Validation/forgetPasswordValidation.php");

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        $validation = validPasswordReset($email, $password, $confirm_password);

        if($validation == true){
            $updated = updatePassword($conn, $email, $password);

            if($updated){
                echo "Password has been reset successfully. <a href='../View/login_reg_forget/login/login.php'>Login here</a>";
            }
            else{
                echo "Error: Could not update password. Make sure the email exists.";
            }
        }
        else{
            echo $validation . " <a href='../View/login_reg_forget/forget_password/forgetpass.php'>Back</a>";
        }
    }
?>