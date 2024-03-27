<?php
session_start();

?>

<!-- SET THE CONNECTION -->
<?php
    $mysqli = require __DIR__ . "/database.php";
    $user_id = mysqli_real_escape_string($mysqli, $_SESSION['users_id']);
?>


<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $due_date = $_POST['due_date'];
    

    // Insert task into tasks table
    $sql = "INSERT INTO tasks (name, location, description, start_date, due_date) 
            VALUES ('$name','$location','$description','$start_date', '$due_date')";
    $result = mysqli_query($mysqli, $sql);

    // For INSERT statements, $result is true/false
    if ($result) {
        $task_id = mysqli_insert_id($mysqli);
        
        // Insert association into users_tasks table
        $sql_users_tasks = "INSERT INTO users_tasks (task_id, user_id) 
                            VALUES ('$task_id', '$user_id')";
        $result_users_tasks = mysqli_query($mysqli, $sql_users_tasks);

        if (!$result_users_tasks) {
            // Handle the case where insertion into users_tasks failed
            echo "Error: " . mysqli_error($mysqli);
            exit; // or handle the error in some other way
        }

        // Redirect to show page
        //header("Location: showTask.php?id=$task_id");
    } else {
        // Handle the case where insertion into tasks failed
        echo "Error: " . mysqli_error($mysqli);
        exit; // or handle the error in some other way
    }
} else {
    header("Location: home.php");
}

?>
