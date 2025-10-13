<?php
require_once "conn.php";

class PatientModel {
    private $conn;

    public function __construct() {
        $this->conn = getConnection();
        if (!$this->conn) {
            throw new Exception("Database connection failed");
        }
    }

    public function getPatientById($patientId) {
        $stmt = $this->conn->prepare("SELECT * FROM Patient WHERE PatientID = ?");
        $stmt->bind_param("i", $patientId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateProfile($patientId, $fullname, $phone, $age, $gender, $address) {
        try {
            if (empty($patientId) || empty($fullname) || empty($phone)) {
                throw new Exception("Required fields missing");
            }

            $sql = "UPDATE Patient SET FullName=?, PhoneNumber=?, Age=?, Gender=?, Address=? WHERE PatientID=?";
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->conn->error);
            }

            $stmt->bind_param("ssissi", $fullname, $phone, $age, $gender, $address, $patientId);

            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            $stmt->close();
            return true;

        } catch (Exception $e) {
            error_log("updateProfile Error: " . $e->getMessage());
            return false;
        }
    }

    public function getDoctors() {
        $query = "SELECT DoctorID, FullName, Specialization FROM Doctor";
        $result = $this->conn->query($query);
        $doctors = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $doctors[] = $row;
            }
        }
        return $doctors;
    }

    
}
?>
