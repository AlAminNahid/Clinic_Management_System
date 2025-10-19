<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include("../../Model/userModel.php");
include("../Validation/log_reg_forget/loginValidation.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $validation = validateLoginInput($email, $password);

    if($validation === true){
        $user = validUser($conn, $email, $password);

        if($user){
            $_SESSION['login_id'] = $user['LoginID'];
            $_SESSION['email'] = $user['Email'];
            $_SESSION['role'] = $user['Role'];
            $_SESSION['lastActivity'] = time();

            if($user['Role'] === 'admin'){
                $_SESSION['user_id'] = $user['AdminID'];
                $_SESSION['admin_id'] = $user['AdminID'];
            }
            else if($user['Role'] === 'doctor'){
                $_SESSION['user_id'] = $user['DoctorID'];
                $_SESSION['doctor_id'] = $user['DoctorID'];
            }
            else if($user['Role'] === 'patient'){
                $_SESSION['user_id'] = $user['PatientID'];
                $_SESSION['patient_id'] = $user['PatientID'];
            }

            if($user['Role'] === 'admin'){
                echo "
                    <script>
                        alert('Admin login successful.');
                        window.location.href = '../../View/dashboards/admin_/admin.php';
                    </script>
                ";
                exit;
            }
            else if($user['Role'] === 'doctor'){
                echo "
                    <script>
                        alert('Doctor login successful.');
                        window.location.href = '../../View/dashboards/doctor_/doctor.php';
                    </script>
                ";
                exit;
            }
            else if($user['Role'] === 'patient'){
                echo "
                    <script>
                        alert('Patient login successful.');
                        window.location.href = '../../View/dashboards/patient_/patient.php';
                   </script>
               ";
                exit;
            }
            else{
                echo "
                    <script>
                        alert('Unknown role, redirecting to login.');
                        window.location.href = '../../View/login_reg_forget/login/login.php';
                    </script>
                ";
            }
        }
        else{
            echo "
                <script>
                    alert('Invalid email or password.');
                    window.location.href = '../../View/login_reg_forget/login/login.php';
                </script>
            ";
        }
    }
    else{
        echo "
            <script>
                alert('$validation');
                window.location.href = '../../View/login_reg_forget/login/login.php';
            </script>
        ";
    }
}
?>