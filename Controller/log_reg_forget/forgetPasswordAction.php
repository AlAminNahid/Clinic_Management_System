<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include("../../Model/userModel.php");
    include("../Validation/log_reg_forget/forgetPasswordValidation.php");

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        $validation = validPasswordReset($email, $password, $confirm_password);

        if($validation == true){
            $updated = updatePassword($conn, $email, $password);

            if($updated){
                echo "
                    <script>
                        alert('Password has been reset successfully.');
                        window.location.href = '../View/login_reg_forget/login/login.php';
                    </script>
                    ";
            }
            else{
                echo "
                    <script>
                        alert('Error: Could not update password. Make sure the email exists.');
                    </script>
                ";
            }
        }
        else{
            echo "
                <script>
                    alert('$validation');
                    window.location.href = '../View/login_reg_forget/forget_password/forgetpass.php';
                </script>
            ";
        }
    }
?>