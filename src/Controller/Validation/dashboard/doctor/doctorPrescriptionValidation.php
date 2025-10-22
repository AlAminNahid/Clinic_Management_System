<?php
    function validateDoctorPrescriptionInput($selectPatient, $medicineName, $dosage, $duration, $notes){
        if(empty($selectPatient) || empty($medicineName) || empty($dosage) || empty($duration) || empty($notes)){
            return "All fields are required.";
        }
        
        return true;
    }
?>