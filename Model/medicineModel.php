<?php
    include("conn.php");

    function addMedicine($conn, $name, $type, $strength, $manufacturer, $status){
        $name = mysqli_real_escape_string($conn, $name);
        $type = mysqli_real_escape_string($conn, $type);
        $strength = mysqli_real_escape_string($conn, $strength);
        $manufacturer = mysqli_real_escape_string($conn, $manufacturer);
        $status = mysqli_real_escape_string($conn, $status);

        $sql = "INSERT INTO Medicine (Name, type, Strength, ManufacturerName, Status)
                VALUES ('$name', '$type', '$strength', '$manufacturer', '$status')
                ";
        
        return mysqli_query($conn, $sql);
    }
?>