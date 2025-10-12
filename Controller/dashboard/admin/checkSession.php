<?php
    session_start();
    header('Content-Type: application/json');

    $timeoutDuration = 60;

    if(!isset($_SESSION['admin_id'])){
        echo json_encode(["status" => "expired"]);
        exit;
    }

    if (isset($_SESSION['lastActivity']) && (time() - $_SESSION['lastActivity']) > $timeoutDuration) {
        session_unset();
        session_destroy();
        echo json_encode(["status" => "expired"]);
        exit;
    }

    $_SESSION['lastActivity'] = time();

    echo json_encode(["status" => "active"]);
    exit;
?>