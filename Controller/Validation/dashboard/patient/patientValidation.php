<?php
class PatientValidation {
    public static function validateAppointment($data) {
        $errors = [];
        
        if (empty($data['DoctorID']) || $data['DoctorID'] <= 0) {
            $errors[] = "Please select a doctor.";
        }
        
        if (empty($data['Date'])) {
            $errors[] = "Date is required.";
        } elseif (strtotime($data['Date']) < strtotime(date('Y-m-d'))) {
            $errors[] = "Appointment date cannot be in the past.";
        }
        
        if (empty($data['Time'])) {
            $errors[] = "Time is required.";
        }
        
        if (empty($data['Reason'])) {
            $errors[] = "Reason is required.";
        }
        
        return $errors;
    }
    
    public static function validateProfile($data) {
        $errors = [];
        
        if (empty($data['FullName'])) {
            $errors[] = "Full name is required.";
        }
        
        if (empty($data['Email']) || !filter_var($data['Email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Valid email is required.";
        }
        
        return $errors;
    }
}
?>