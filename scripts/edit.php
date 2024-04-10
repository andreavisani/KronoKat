<?php
session_start();

/************  SET THE CONNECTION **************/
$mysqli = require __DIR__ . "/database.php";
$user_id = mysqli_real_escape_string($mysqli, $_SESSION['users_id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = mysqli_real_escape_string($mysqli, $_POST['name']);
    $location = mysqli_real_escape_string($mysqli, $_POST['location']);
    $description = mysqli_real_escape_string($mysqli, $_POST['description']);
    $start_date = $_POST['start_date'];
    $due_date = $_POST['due_date'];
    
    // Update task in tasks table
    $sql_users_tasks = "UPDATE `tasks` 
                        SET `name` = '$name', 
                            `location` = '$location', 
                            `description` = '$description', 
                            `start_date` = '$start_date', 
                            `due_date` = '$due_date' 
                        WHERE `id` = '$id' ";
    $result = mysqli_query($mysqli, $sql_users_tasks);

    // Check if the update was successful
    if ($result) {
        header("Location: dashboard.php");
        exit;
    } else {
        // Output the error message
        echo "Error: " . mysqli_error($mysqli);
        exit;
    }
}

// If not POST request, show the form
$id = $_GET['id'];
$sql = "SELECT * FROM tasks WHERE id = '$id'";
$result = mysqli_query($mysqli, $sql);
$queryResult = mysqli_num_rows($result);
$row = mysqli_fetch_assoc($result);

if ($queryResult > 0) {
    // Show the edit form
    echo '<!DOCTYPE html>
<html>
<head>
    <title>Edit Task</title>
    <link rel="stylesheet" type="text/css" href="./styles/edit.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: rgb(255,255,255);
            background: linear-gradient(90deg, rgb(219, 219, 219) 19%, rgb(174, 89, 147) 72%);
        }
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 50px;
            border: 1px solid #ccc;
            border-radius: 40px;
            z-index: 9999;
        }
        .popup label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .popup input[type="text"],
        .popup input[type="datetime-local"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .popup input[type="submit"],
        .popup input[type="reset"] {
            padding: 10px 20px;
            background-color: #a05182;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .popup input[type="submit"]:hover,
        .popup input[type="reset"]:hover {
            background-color: #733a5d;
        }
    </style>
</head>
<body>
    <!--- POP UP FOR EDITING NEW TASK, INITIALLY HIDDEN  ---->
    <div id="editPopup" class="popup">
        <form action="edit.php" method="POST">
            <input type="hidden" name="id" value="' . $row["id"] . '">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required value="' . $row["name"] . '">
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" value="' . $row["location"] . '">
            <label for="description">Description:</label>
            <input type="text" id="description" name="description" value="' . $row["description"] . '">
            <label for="start_date">Start date:</label>
            <input type="datetime-local" id="start_date" name="start_date" required value="' . date('Y-m-d\TH:i', strtotime($row['start_date'])) . '">
            <label for="due_date">Due date:</label>
            <input type="datetime-local" id="due_date" name="due_date" required value="' . date('Y-m-d\TH:i', strtotime($row['due_date'])) . '">
            <input type="submit" value="Edit task">
            <input type="reset" value="Reset">
        </form>
    </div>

    <script>
        // JavaScript to show the popup
        document.getElementById("editPopup").style.display = "block";
    </script>
</body>
</html>';
} else {
    echo "There are no results matching your search!";
}
?>
