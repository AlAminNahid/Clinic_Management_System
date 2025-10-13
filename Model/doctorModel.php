<?php
require_once "conn.php";

class DoctorModel {
    private $conn;

    public function __construct() {
        $this->conn = getConnection();
    }

    public function getDoctorById($doctorId) {
        $stmt = $this->conn->prepare("SELECT * FROM Doctor WHERE DoctorID = ?");
        $stmt->bind_param("i", $doctorId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

public function updateProfile($doctorID, $name, $email, $phoneNumber, $specialization, $visitFee, $password = null) {
$doctorID = (int)$doctorID;

    $name = mysqli_real_escape_string($this->conn, $name);
    $email = mysqli_real_escape_string($this->conn, $email);
    $phoneNumber = mysqli_real_escape_string($this->conn, $phoneNumber);
    $specialization = mysqli_real_escape_string($this->conn, $specialization);
    $visitFee = (float)$visitFee;

    $sqlDoctor = "UPDATE Doctor 
                  SET FullName='$name', Specialization='$specialization', PhoneNumber='$phoneNumber', VisitFee=$visitFee
                  WHERE DoctorID=$doctorID";

    if (!mysqli_query($this->conn, $sqlDoctor)) {
        return false;
    }

    if ($password) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $sqlLogin = "UPDATE Login 
                     SET Password='$passwordHash' 
                     WHERE DoctorID=$doctorID AND Role='doctor'";

        if (!mysqli_query($this->conn, $sqlLogin)) {
            return false;
        }
    }

    return true;
}


}
?>
