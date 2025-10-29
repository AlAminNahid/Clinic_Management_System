<?php
    include("conn.php");

    $conn = getConnection();

    function registerUser($conn, $name, $email, $phoneNumber, $userType, $password){
        $name = mysqli_real_escape_string($conn, $name);
        $email = mysqli_real_escape_string($conn, $email);
        $phoneNumber = mysqli_real_escape_string($conn, $phoneNumber);
        $role = strtolower($userType);
        $password = password_hash($password, PASSWORD_DEFAULT);

        if($role === "admin"){
            $sql = "INSERT INTO Admin (FullName, PhoneNumber, Email) VALUES ('$name', '$phoneNumber', '$email')";
        }
        else if($role === "doctor"){
            $sql = "INSERT INTO Doctor (FullName, PhoneNumber) VALUES ('$name', '$phoneNumber')";
        }
        else if($role === "patient"){
            $sql = "INSERT INTO Patient (FullName, PhoneNumber) VALUES ('$name', '$phoneNumber')";
        }
        else{
            return false;
        }

        if(!mysqli_query($conn, $sql)){
            return false;
        }

        $userID = mysqli_insert_id($conn);

        if($role === "admin"){
            $sqlLogin = "INSERT INTO Login (Email, Password, Role, AdminID) 
                         VALUES ('$email', '$password', '$role', '$userID')";
        }
        else if($role === "doctor"){
            $sqlLogin = "INSERT INTO Login (Email, Password, Role, DoctorID)
                         VALUES ('$email', '$password', '$role', '$userID')";
        }
        else if($role === "patient"){
            $sqlLogin = "INSERT INTO Login (Email, Password, Role, PatientID)
                         VALUES ('$email', '$password', '$role', '$userID')";
        }

        return mysqli_query($conn, $sqlLogin);
    }

    function validUser($conn, $email, $password){
        $email = mysqli_real_escape_string($conn, $email);

        $sql = "SELECT * FROM Login WHERE Email='$email'";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);

        if($user && password_verify($password, $user['Password'])){
            return $user;
        }
        else{
            return false;
        }
    }

    function updatePassword($conn, $email, $newPassword){
        $email = mysqli_real_escape_string($conn, $email);
        $password = password_hash($newPassword, PASSWORD_DEFAULT);

        $sql = "UPDATE Login SET Password='$password' WHERE Email = '$email'";

        return mysqli_query($conn, $sql);
    }

    function updateAdminProfile($conn, $adminID, $name, $email, $phoneNumber, $password){
        $name = mysqli_real_escape_string($conn, $name);
        $email = mysqli_real_escape_string($conn, $email);
        $phoneNumber = mysqli_real_escape_string($conn, $phoneNumber);
        $adminID = (int)$adminID;
        $password = password_hash($password, PASSWORD_DEFAULT);

        $sqlAdmin = "UPDATE Admin SET FullName='$name', Email='$email', PhoneNumber='$phoneNumber'
                     WHERE AdminID=$adminID";
        
        $updateAdmin = mysqli_query($conn, $sqlAdmin);

        if(!$updateAdmin){
            return false;
        }

        $sqlLogin = "UPDATE Login SET Email='$email', Password='$password'
                     WHERE AdminID=$adminID AND Role='admin'";

        $updateLogin = mysqli_query($conn, $sqlLogin);

        return $updateLogin;
    }

    function updateDoctorProfile($conn, $doctorID, $name, $email, $phone, $specialization, $visit_fee, $password){
        $name = mysqli_real_escape_string($conn, $name);
        $email = mysqli_real_escape_string($conn, $email);
        $phone = mysqli_real_escape_string($conn, $phone);
        $specialization = mysqli_real_escape_string($conn, $specialization);
        $visit_fee = mysqli_real_escape_string($conn, $visit_fee);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $doctorID = (int)$doctorID;

        $sqlDoctor = "UPDATE Doctor SET FullName='$name', PhoneNumber='$phone', Specialization='$specialization', VisitFee='$visit_fee'
                      WHERE DoctorID=$doctorID";
        
        $updateDoctor = mysqli_query($conn, $sqlDoctor);

        if(!$updateDoctor){
            return false;
        }

        $sqlLogin = "UPDATE Login SET Email='$email', Password='$password'
                     WHERE DoctorID=$doctorID AND Role='doctor'";

        $updateLogin = mysqli_query($conn, $sqlLogin);
        
        return $updateLogin;
    }
?>