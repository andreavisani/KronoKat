
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
            <link rel="stylesheet" type="text/css" href="./styles/dashstyle.css">
            <link rel="stylesheet" type="text/css" href="./styles/navbar-dashboard-style.css">
            <link rel="stylesheet" type="text/css" href="./styles/search-popup.css">
            <title>Hello there!</title>
        </head>
        
        <body>
            <script src="./js/sort.js" defer></script> <!-- IMPORT THE SORTING SCRIPT -->
            <script src="./js/popupAndList.js" defer></script> <!-- IMPORT THE POPUP AND LIST SCRIPT -->
            
            <nav class="navbar">
            <div class="holder">
            <div class="logo">
                <a href="./index.php"><img src="./images/blackcat.png" alt="logo"></a>
                <a href="./index.php"><h1>KRRONOKAT</h1></a>
            </div>
            
            <div class="bar">
                <div class="searchBx">
                    <div class="inputBx">
                        <form action="./dashboard.php" method="GET">
                            <input type="text" name="search" placeholder="Search..">
                    </div>
                    <button type="submit" name="submit-search" id="openSearchPopup">Search</button>
                    </form>
                </div>

                <?php
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

                        echo "<div id='search-popup' style='display: block; /* show the popup */
                        position: fixed;
                        top: 50%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                        background-color: white;
                        border: 1px solid black;
                        padding: 20px;
                        z-index: 999;
                        height: 80vh; 
                        overflow-y: auto;'>";
                        
                        if ($queryResult > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<div class=\"card\"> 
                                    <h3>" . $row['name'] . "</h3>
                                    <P><image class='icon' src='./images/location.png' alt='Location Icon'>   " . $row['location'] . "</p>
                                    <P><image class='icon' src='./images/information.png' alt='info Icon' >   " . $row['description'] . "</p>
                                    <P><image class='icon' src='./images/start-date.png' alt='start date Icon'>   " . $row['start_date'] . "</p>
                                    <P><image class='icon' src='./images/due-date.png' alt='due date Icon'>   " . $row['due_date'] . "</p>
                                    </div>";
                            }
                        } else {
                            echo "There are no results matching your search!";
                        }
                        
                        echo "</div>";
                    }
                    ?>
                
                
            
    
                <div class="logout">
                <a href="index.php">
                    <button class="logout">
                    Logout
                    </button>
                </a>
                </div>
            </div>
        </div>
    </nav>
    
    <div class="container">
    <div class="big-box">

        <div class="clock">
        </div> 
        
        <script>
        function updateClock() {
        var now = new Date();
        var hours = now.getHours();
        var minutes = now.getMinutes();
        var timeString = hours + ":" + (minutes < 10 ? "0" + minutes : minutes); // Add leading zero if minutes < 10
        document.querySelector(".clock").textContent = timeString;
        }

        // Update the clock every second
        setInterval(updateClock, 1000);

        // Initial call to display the clock immediately
        updateClock();
        </script>

        <!-- START DEADLINE ELEMENT -->
        <div class="element-container" id="daily-view">
            
            <div id="myDIV" class="header">
                <h2>DEADLINES</h2>
                <button id="openPopup">New tasks</button> <!-- WHEN CLICKING THIS BUTTON, THE POPUP WILL POP UP :) -->
            </div>

            <!--- POP UP FOR ADDING NEW TASK, INITIALLY HIDDEN  ---->
            <div id="popup" class="popup">
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
        </div> <!-- END DEADLINE ELEMENT -->
        
    </div> <!-- END BIGBOX ELEMENT -->
    

    <div class="small-boxes">
        <div class="small-box">
            <!-- Content for the first small box -->
        </div>
        <div class="small-box">
            <!-- Content for the second small box -->
        </div>
    </div>
</div>
</body>
</html>
        
