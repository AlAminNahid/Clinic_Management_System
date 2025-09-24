<?php
    include("conn.php");

    function registerUser($conn, $name, $email, $phoneNumber, $userType, $password){
        $name = mysqli_real_escape_string($conn, $name);
        $email = mysqli_real_escape_string($conn, $email);
        $phoneNumber = mysqli_real_escape_string($conn, $phoneNumber);
        $role = mysqli_real_escape_string($conn, $userType);
        $password = password_hash($password, PASSWORD_DEFAULT);

        if($role === "admin"){
            $sql = "INSERT INTO Admin (FullName, PhoneNumber, Email) VALUES ('$name', '$phoneNumber', $email)";
        }
        else if($role === "doctor"){
            $sql = "INSERT INTO Doctor (FullName, PhoneNumber) VALUES ('$name', $phoneNumber)";
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

        $sqlLogin = "INSERT INTO Login (Email, Password, Role, UserID) 
                     VALUES ('$email', '$password', '$role', '$userID')";

        return mysqli_query($conn, $sqlLogin);
    }

    function validUser($conn, $email, $password){
        $email = mysqli_real_escape_string($conn, $email);
        $sql = "SELECT * FROM Login WHERE Email='$email'";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);

        if($user && password_verify($password, $user['password'])){
            return $user;
        }
        else{
            return false;
        }
    }

    function updatePassword($conn, $email, $newPassword){
        $email = mysqli_real_escape_string($conn, $email);
        $password = password_hash($newPassword, PASSWORD_DEFAULT);

        $sql = "UPDATE Login SET Password='$password'";

        return mysqli_query($conn, $sql);
    }
?>