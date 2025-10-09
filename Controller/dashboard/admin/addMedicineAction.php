<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();
    include("../../../Model/medicineModel.php");
    include("../../Validation/dashboard/admin/adminMedicineValidation.php");

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $name = trim($_POST['name']);
        $type = trim($_POST['type']);
        $strength = trim($_POST['strength']);
        $manufacturer = trim($_POST['manufacturer']);
        $status = trim($_POST['status']);

        $validation = validateAdminMedicineInput($name, $type, $strength, $manufacturer, $status);

        if($validation == true){
            if(addMedicine($conn, $name, $type, $strength, $manufacturer, $status)){
                echo "
                    <script>
                        alert('Medicine added successfully.');
                        window.location.href = '../../../View/dashboards/admin_/admin.php';
                    </script>
                ";
            }
            else{
                echo "
                    <script>
                        alert('Error: Could not add medicine.');
                        window.location.href = '../../../View/dashboards/admin_/admin.php';
                    </script>
                ";
            }
        }
        else{
            echo "
                <script>
                    alert('$validation');
                    window.location.href = '../../../View/dashboards/admin_/admin.php';
                </script>
            ";
        }
    }
?>