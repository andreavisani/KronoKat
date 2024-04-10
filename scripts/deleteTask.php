<?php
session_start();


/************  SET THE CONNECTION **************/

    $mysqli = require __DIR__ . "/database.php";
    $user_id = mysqli_real_escape_string($mysqli, $_SESSION['users_id']);

    $id = $_GET['id'];

    $sql = "DELETE FROM tasks WHERE id = $id";
    $result = mysqli_query($mysqli, $sql);

    // For INSERT statements, $result is true/false
    if ($result) {
        
        header("Location: dashboard.php");
    } else {
        // Handle the case where insertion into tasks failed
        echo "Error: " . mysqli_error($mysqli);
        exit; // or handle the error in some other way
    }

?>
