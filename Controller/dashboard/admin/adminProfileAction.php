<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();
    include("../../../Model/userModel.php");
    include("../../Validation/dashboard/admin/adminProfileValidation.php");

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $adminID = $_SESSION['user_id'];
        $name = trim($_POST['fullname']);
        $email = trim($_POST['email']);
        $phoneNumber = trim($_POST['phone']);
        $password = trim($_POST['password']);

        $validation = validateAdminProfileInput($name, $email, $phoneNumber, $password);

        if($validation == true){
            if(updateAdminProfile($conn, $adminID, $name, $email, $phoneNumber, $password)){
                echo "
                    <script>
                        alert('Profile updated successfully.');
                    </script>
                ";
            }
            else{
                echo "
                    <script>
                        alert('Error: Could not update profile.');
                    </script>
                ";
            }
        }
        else{
            echo "
                <script>
                    alert('$validation');
                </script>
            ";
        }
    }
?>