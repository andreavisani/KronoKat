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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./styles/dashboard-style.css">
    <title>Hello thereee!</title>
</head>

<body>
    <script src="./js/sort.js" defer></script> <!-- IMPORT THE SORTING SCRIPT -->
    <script src="./js/popupAndList.js" defer></script> <!-- IMPORT THE POPUP AND LIST SCRIPT -->
    

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
                <!-- FORM IS SENT TO createTask.php and info sent back -->
                <form action="createTask.php" method="POST" style="padding: 1rem; display: grid; grid-template-columns: 2; gap: 0.5rem;">
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

</body>
</html>


