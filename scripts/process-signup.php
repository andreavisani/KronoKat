<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check for empty or invalid inputs
    $errors = [];

    if (empty($_POST["fName"])) {
        $errors[] = "First Name is required";
    }

    if (empty($_POST["lName"])) {
        $errors[] = "Last Name is required";
    }

    if (empty($_POST["dob"])) {
        $errors[] = "Date of Birth is required";
    }

    if (empty($_POST["email"]) || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }

    if (empty($_POST["login"])) {
        $errors[] = "User Name is required";
    }

    if (strlen($_POST["pass"]) < 8 || !preg_match("/[a-z]/i", $_POST["pass"]) || !preg_match("/[0-9]/", $_POST["pass"])) {
        $errors[] = "Password must be at least 8 characters and contain at least one letter and one number";
    }

    // If there are errors, output them and stop execution
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
        exit;
    }

    // Hash the password
    $password_hash = password_hash($_POST["pass"], PASSWORD_DEFAULT);

    // Database connection
    $mysqli = require __DIR__ . "/database.php";

    // SQL statement
    $sql = "INSERT INTO users (first_name, last_name, email, password, login)
            VALUES (?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $mysqli->prepare($sql);

    // Check for prepare errors
    if (!$stmt) {
        die("SQL error: " . $mysqli->error);
    }

    // Bind parameters and execute the statement
    $stmt->bind_param("sssss", $_POST['fName'], $_POST['lName'], $_POST['email'], $password_hash, $_POST['login']);

    if ($stmt->execute()) {
        header("Location: ./login.php");
        exit; // Stop script execution to prevent further output
    } else {
        die("Error executing statement: " . $stmt->error);
    }

    // Close the statement
    $stmt->close();
}




