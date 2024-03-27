

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
        header("Location: home.php");
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
    <link rel="stylesheet" type="text/css" href="./styles/style.css">
    <link rel="stylesheet" type="text/css" href="./styles/dashboard-style.css">
    <script src="./js/popup-script.js">
    
</script>
    <title>Hello there!</title>
</head>
<body>
    
    <!-- SET THE CONNECTION -->
    <?php

    ?>

    <div style="display: flex; justify-content: space-around; gap: 2rem;">

        <!-- DEADLINE -->
        <div class="element-container" id="daily-view">
                
            <div id="myDIV" class="header">
                <h2>DEADLINE</h2>
                
                <button id="openPopup">New Taks</button>
                <div id="popup" class="popup">
                    <form action="home.php" method="POST" style="padding: 1rem; display: grid; grid-template-columns: 2; gap: 0.5rem;">
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
                
            </div>
            <?php 
                $sql = "SELECT tasks.*, IFNULL(projects.name, '') AS 'project' 
                        FROM tasks 
                        JOIN users_tasks ON tasks.id = users_tasks.task_id 
                        LEFT JOIN projects ON tasks.project_id = projects.id 
                        WHERE users_tasks.user_id = '$user_id'
                        ORDER BY tasks.due_date ASC;";
                //echo $sql;
                $result_set = mysqli_query($mysqli,$sql);
            ?>
                <div>
                    <span style="margin-left: 38px;">Name <img id="sort-name" src="./images/apps-sort.png" style="width: 20px;"></span> <span style="float: right; margin-right: 60px;">Due date <img id="sort-date" src="./images/apps-sort.png" style="width: 20px;"></span> 
                </div>
            <ul id="task-list">
                <?php while($results = mysqli_fetch_assoc($result_set)) { ?>
                    <li>
                        <div style="display: flex; justify-content: space-between; padding-right: 60px;">
                            <p><?php echo $results['name']; ?></p>
                            <p><?php 
                        // Convert due date timestamp to date and hour-minutes format without seconds and year
                        $dueDate = date("M. d   H:i", strtotime($results['due_date']));
                        echo $dueDate; ?></p>
                        </div>
                        <a class="close" href="<?php echo "deleteTask.php?id=" . $results['id']; ?>">×</a>  
                    </li>
                    
                <?php } ?>                
            </ul>
        </div>
    </div>

    <script>
        // Click on a close button to hide the current list item
        var close = document.getElementsByClassName("close");
        var i;
        for (i = 0; i < close.length; i++) {
        close[i].onclick = function() {
            var div = this.parentElement;
            div.style.display = "none";
        }
        }
        
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


