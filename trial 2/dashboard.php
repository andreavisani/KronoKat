<?php
session_start();

//MAKE SURE THE USER IS CONNECTED
if (!isset($_SESSION['users_id'])) {
    header("Location: login.php");
    exit; // Make sure to stop the script after redirection
}

//SET CONNECTION
$mysqli = require __DIR__ . "/database.php";
$user_id = mysqli_real_escape_string($mysqli, $_SESSION['users_id']);


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
        header("Location: dashboard.php");
    } else {
        // Handle the case where insertion into tasks failed
        echo "Error: " . mysqli_error($mysqli);
        exit; // or handle the error in some other way
    }
} else {
    //header("Location: login.php");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./styles/dashboard-style.css">
    
    <title>Hello there!</title>
</head>

<body>
    <script src="./js/sort.js" defer></script>

    <div style="display: flex; justify-content: space-around; gap: 2rem;">

        <!-- DEADLINE ELEMENT -->
        <div class="element-container" id="daily-view">
                
            <div id="myDIV" class="header">
                <h2>DEADLINE</h2>
                <button id="openPopup">New Taks</button> <!-- WHEN CLICKING THIS BUTTON, THE POPUP WILL POP UP :) -->
            </div>

            <!--- POP UP FOR ADDING NEW TASK, INITIALLY HIDDEN  ---->
            <div id="popup" class="popup" style="display: none; /* Initially hide the popup */
                                                    position: fixed;
                                                    top: 50%;
                                                    left: 50%;
                                                    transform: translate(-50%, -50%);
                                                    background-color: white;
                                                    border: 1px solid black;
                                                    padding: 20px;
                                                    z-index: 999;">
                <form action="dashboard.php" method="POST" style="padding: 1rem; display: grid; grid-template-columns: 2; gap: 0.5rem;">
                    <label class="col1" for="name">Name:</label>
                    <input class="col2" type="text" id="name" name="name" required>
                    <label class="col1" for="location">Location:</label>
                    <input class="col2" type="text" id="location" name="location" >
                    <label class="col1" for="description">Description:</label>
                    <input class="col2" type="text" id="description" name="description" >
                    <label class="col1" for="start_date">Start date</label>
                    <input class="col2" type="datetime-local" id="start_date" name="start_date" required/>
                    <label class="col1" for="due_date">Due date</label>
                    <input class="col2" type="datetime-local" id="due_date" name="due_date" required/>
                    <input class="col1" id="create_task" type="submit" value="Create new task">
                    <input class="col2" id="reset_task" type="reset" value="Reset">
                </form>
            </div>

            <!--- QUERY TO SELECT ALL THE TASKS ASSOCIATED WITH THIS USER (ID TAKEN FROM SESSION) ---->
            <?php 
                $sql = "SELECT tasks.*, IFNULL(projects.name, '') AS 'project' 
                        FROM tasks 
                        JOIN users_tasks ON tasks.id = users_tasks.task_id 
                        LEFT JOIN projects ON tasks.project_id = projects.id 
                        WHERE users_tasks.user_id = '$user_id'
                        ORDER BY tasks.due_date ASC;";
                $result_set = mysqli_query($mysqli,$sql);
            ?>
            
            <!-- HEADER ROW FOR TASKS -->
            <div style="padding: 10px;">
                <div style="display: flex; justify-content: space-between;">
                    <span style="margin-left: 20px; font-size: 18px; font-weight: bold;">Name</span>
                    <span style="margin-right: 20px; font-size: 18px; font-weight: bold; cursor: pointer;" onclick="reverseSort()">
                        Due date <img id="sort-date" src="./images/apps-sort.png" style="width: 20px; vertical-align: middle;">
                    </span> 
                </div>
            </div>

            <!-- LIST CONTAINING THE DATA RETURNED BY THE SQL QUERY -->
            <ul id="task-list">
                <?php $index = 0; ?>
                <?php while($results = mysqli_fetch_assoc($result_set)) { ?>
                    <li class="task-item" data-index="<?php echo $index; ?>">
                        <div style="display: flex; justify-content: space-between; padding-right: 20px;">
                            <p><?php echo $results['name']; ?></p>
                            <p><?php 
                                // Convert due date timestamp to date and hour-minutes format without seconds and year
                                $dueDate = date("M. d   H:i", strtotime($results['due_date']));
                                echo $dueDate; ?>
                            </p>
                        </div>
                        <a class="close" href="<?php echo "deleteTask.php?id=" . $results['id']; ?>">×</a>  
                    </li>
                    <?php $index++; ?>
                <?php } ?>                
            </ul>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var openPopupButton = document.getElementById('openPopup');
        var popup = document.getElementById('popup');
        
        // Show the popup when the openPopup button is clicked
        openPopupButton.addEventListener('click', function() {
            popup.style.display = 'block';
        });

        document.addEventListener('click', function(event) {
            if (!popup.contains(event.target) && event.target !== openPopupButton) {
                popup.style.display = 'none';
            }
        });
    });

    
    // Add a "checked" symbol when clicking on a list item
    var list = document.querySelector('ul');
    list.addEventListener('click', function(ev) {
        // Check if the clicked target is either the <li> or one of its children
        var clickedElement = ev.target;
        while (clickedElement && clickedElement !== list) {
            if (clickedElement.tagName === 'LI') {
                clickedElement.classList.toggle('checked');
                break;
            }
            clickedElement = clickedElement.parentNode;
        }
    }, false);
</script>
    


    
</body>
</html>


