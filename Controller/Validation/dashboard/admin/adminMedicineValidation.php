<?php
    function validateAdminMedicineInput($name, $type, $strength, $manufacturer, $status){
        if(empty($name) || empty($type) || empty($strength) || empty($manufacturer) || empty($status)){
            return "All fields are required.";
        }
        if(!is_numeric($strength) || $strength <= 0) {
            return "Strength must be a valid number greater than 0.";
        }
        return true;
    }
?>