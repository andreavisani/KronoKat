<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['users_id'])) {
    header("Location: login.php");
    exit;
}

// Establish database connection
$mysqli = require __DIR__ . "/database.php";
$user_id = mysqli_real_escape_string($mysqli, $_SESSION['users_id']);

if (isset($_GET['submit-search'])) {
    $search = mysqli_real_escape_string($mysqli, $_GET['search']);
    $sql = "SELECT * FROM tasks 
            INNER JOIN users_tasks ON tasks.id = users_tasks.task_id
            WHERE (tasks.name LIKE '%$search%' 
                OR tasks.location LIKE '%$search%' 
                OR tasks.description LIKE '%$search%')
            AND users_tasks.user_id = '$user_id'
            ORDER BY tasks.due_date ASC;";
    $result = mysqli_query($mysqli, $sql);
    $queryResult = mysqli_num_rows($result);

    echo "<div id='search-popup' style='display: block; /* Initially show the popup */
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: white;
    border: 1px solid black;
    padding: 20px;
    z-index: 999;'>";
    
    if ($queryResult > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div> 
                <h3>" . $row['name'] . "</h3>
                <image src='./images/location.png' alt='Location Icon'> <p>" . $row['location'] . "</p>
                <p><b>Location: <b>" . $row['description'] . "</p>
                <p>" . $row['start_date'] . "</p>
                <p>" . $row['due_date'] . "</p>
                </div>";
        }
    } else {
        echo "There are no results matching your search!";
    }
    
    echo "</div>";
}
?>
