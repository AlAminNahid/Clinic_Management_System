<?php
require_once 'conn.php';

class PatientModel {
    private $conn;
    
    public function __construct() {
        $this->conn = getConnection();
    }
    
    public function getPatientProfile($patientID) {
        $stmt = $this->conn->prepare("SELECT p.PatientID, p.FullName, p.PhoneNumber, p.Age, p.Gender, p.Address, l.Email
                                    FROM Patient p
                                    LEFT JOIN Login l ON p.PatientID = l.PatientID
                                    WHERE p.PatientID = ?");
        $stmt->bind_param("i", $patientID);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_assoc();
    }
    
    public function getPatientAppointments($patientID) {
        $stmt = $this->conn->prepare("SELECT a.AppointmentID, a.Date, a.Time, a.Reason, a.Status, d.FullName AS DoctorName
                                    FROM Appointment a
                                    LEFT JOIN Doctor d ON a.DoctorID = d.DoctorID
                                    WHERE a.PatientID = ?
                                    ORDER BY a.Date DESC, a.Time DESC");
        $stmt->bind_param("i", $patientID);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getAllDoctors() {
        $res = $this->conn->query("SELECT DoctorID, FullName, Specialization FROM Doctor ORDER BY FullName");
        return $res->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getPatientPrescriptions($patientID) {
        $stmt = $this->conn->prepare("SELECT pr.PrescriptionID, pr.Date, pr.AdditionalNotes, d.FullName AS DoctorName, 
                                     m.Name as MedicineName, pr.Dosage, pr.Duration
                                     FROM Prescription pr
                                     LEFT JOIN Doctor d ON pr.DoctorID = d.DoctorID
                                     LEFT JOIN Medicine m ON pr.MedicineID = m.MedicineID
                                     WHERE pr.PatientID = ?
                                     ORDER BY pr.Date DESC");
        $stmt->bind_param("i", $patientID);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_all(MYSQLI_ASSOC);
    }
    
    public function bookAppointment($data) {
        // Your existing booking logic here
        $stmt = $this->conn->prepare("INSERT INTO Appointment (DoctorID, PatientID, Date, Time, Reason, Status) 
                                     VALUES (?, ?, ?, ?, ?, 'Booked')");
        $stmt->bind_param("iisss", $data['DoctorID'], $data['PatientID'], $data['Date'], $data['Time'], $data['Reason']);
        return $stmt->execute();
    }
    
    public function updateProfile($data) {
        // Your existing profile update logic here
        // Use transactions as in your original code
    }
}
?>