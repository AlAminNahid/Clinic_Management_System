<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();
    include("../../../Model/userModel.php");
    include("../../Validation/dashboard/doctor/doctorProfileValidation.php");

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $doctorID = $_SESSION['user_id'];
        $name = trim($_POST['fullname']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $specialization = trim($_POST['specialization']);
        $visit_fee = trim($_POST['visit-fee']);
        $password = trim($_POST['password']);

        $validation = validateDoctorProfileInput($name, $email, $phone, $specialization, $visit_fee, $password);

        if($validation == true){
            if(updateDoctorProfile($conn, $doctorID, $name, $email, $phone, $specialization, $visit_fee, $password)){
                echo "
                    <script>
                        alert('Profile update successfully.');
                        window.location.href = '../../../View/dashboards/doctor_/doctor.php';
                    </script>
                ";
            }
            else{
                echo "
                    <script>
                        alert('Error: Could not update profile.');
                        window.location.href = '../../../View/dashboards/doctor_/doctor.php';
                    </script>
                ";
            }
        }
        else{
            echo "
                <script>
                    alert('$validation');
                    window.location.href = '../../../View/dashboards/doctor_/doctor.php';
                </script>
            ";
        }
    }
?>