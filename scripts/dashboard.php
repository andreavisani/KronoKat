
    
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
$query = "SELECT login FROM users WHERE id = '$user_id'";
$result = mysqli_query($mysqli, $query);

// Check if query was successful
if ($result) {
    // Fetch the row
    $row = mysqli_fetch_assoc($result);
    // Extract the username
    $username = $row['login'];
} else {
    // Error handling if the query fails
    $username = "Unknown"; // Default value for username
}
?>
            
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" type="text/css" href="./styles/dashstyle.css">
                <link rel="stylesheet" type="text/css" href="./styles/navbar-dashboard-style.css"/>
                <link rel="stylesheet" type="text/css" href="./styles/search-popup.css">
                <title>Hello there!</title>
            </head>
            
            <body>
                <script src="./js/sort.js" defer></script>
                <script src="./js/calendar.js" defer></script> <!-- IMPORT THE SORTING SCRIPT -->
                
                <nav class="navbar">
                <div class="holder">
                <div class="logo">
                    <a href=""><img src="./images/blackcat.png" alt="logo"></a>
                    <a href=""><h1>KRRONOKAT</h1></a>
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
    
        echo "<div id='search-popup' class='popup-container'>"; // Added class for styling
    
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
                echo "<div class=\"card\"> 
                <h3> No Results Found For Your Search </h3>
                </div>"; 
        }
    
        echo "</div>";
    }
    ?>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('search-popup').classList.add('show');
    });
    </script>
                    
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

            <div class="name">
            <div class="right-name">
            <b><em><?php echo "Welcome, $username"; ?></em></b>
            </div>
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
                    <h2>To-Do List:</h2>
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
                            <div class="list-holder">
                            <div style="display: flex; justify-content: space-between; padding-right: 20px;">
                                <p><?php echo $results['name']; ?></p>

                                <p><?php 
                                    // Convert due date timestamp to date and hour-minutes format without seconds and year
                                    $dueDate = date("M. d   H:i", strtotime($results['due_date']));
                                    echo $dueDate; ?>
                                    <a class="edit" href="<?php echo "edit.php?id=" . $results['id']; ?>"><img src="./images/change.png" class="icon" style="margin-left:20px; margin-right: 2px;">
</a>
                                    <a class="close" href="<?php echo "deleteTask.php?id=" . $results['id']; ?>"><img src="./images/close.png" class="icon"></a> 
                                </p>
                            </div>
                        </li>
                        <?php $index++; ?>
                    <?php } ?>                
                </ul>
            </div> <!-- END DEADLINE ELEMENT -->
            
        </div> <!-- END BIGBOX ELEMENT -->
        
    
        <div class="small-boxes">
            <div class="small-box" id="double-box">
                <div class="calendar-box">
                <h3 id="monthAndYear"></h3>
                    <div class="button-container-calendar">
                        <button id="previous" onclick="previous()">
                            ‹
                        </button>
                        <button id="next" onclick="next()">
                            ›
                        </button>
                    </div>
                    <table class="table-calendar" id="calendar" data-lang="en">
                        <thead id="thead-month"></thead>
                        <!-- Table body for displaying the calendar -->
                        <tbody id="calendar-body"></tbody>
                    </table>
                    <div class="footer-container-calendar">
                        <label for="month">Jump To: </label>
                        <!-- Dropdowns to select a specific month and year -->
                        <select id="month" onchange="jump()">
                            <option value=0>Jan</option>
                            <option value=1>Feb</option>
                            <option value=2>Mar</option>
                            <option value=3>Apr</option>
                            <option value=4>May</option>
                            <option value=5>Jun</option>
                            <option value=6>Jul</option>
                            <option value=7>Aug</option>
                            <option value=8>Sep</option>
                            <option value=9>Oct</option>
                            <option value=10>Nov</option>
                            <option value=11>Dec</option>
                        </select>
                        <!-- Dropdown to select a specific year -->
                        <select id="year" onchange="jump()"></select>
                    </div>
                </div>
                <div class="photo-container" id="photoContainer" onclick="changePhoto()">
                <h2>Click to Change Photo</h2>
                <input type="file" id="fileInput" accept="image/*" style="display: none;">
                <div id="imagePreview"></div>
                </div>
                </div>
                <script>
function changePhoto() {
    document.getElementById('fileInput').click();
}

document.getElementById('fileInput').addEventListener('change', function(event) {
    const previewContainer = document.getElementById('imagePreview');
    const h2Element = document.querySelector('.photo-container h2');
    previewContainer.innerHTML = ''; // Clear previous previews

    const files = event.target.files;
    for (const file of files) {
        const reader = new FileReader();

        reader.onload = function(e) {
            const imgElement = document.createElement('img');
            imgElement.src = e.target.result;
            imgElement.classList.add('img-preview');
            previewContainer.appendChild(imgElement);
        }

        reader.readAsDataURL(file);
    }

    // Hide the h2 element
    h2Element.style.display = 'none';
});
</script>

            <div class="small-box">

            <?php
    
    // Function to save notes for the logged-in user
    function saveNotes($notes, $user_id, $mysqli) {
        $sql = "UPDATE users SET notes = ? WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("si", $notes, $user_id);
        $stmt->execute();
        $stmt->close();
    }
    
    // Initialize notes
    if (!isset($_SESSION['notes'])) {
        $_SESSION['notes'] = '';
    }
    
    // Handle form submission to update notes
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Save the notes from the form
        if (isset($_POST['notes'])) {
            saveNotes($_POST['notes'], $user_id, $mysqli);
            $_SESSION['notes'] = $_POST['notes'];
        }
    }
    
    $sql = "SELECT users.notes FROM users 
            WHERE users.id = '$user_id'";
    
    $result_set = mysqli_query($mysqli,$sql);
    $results = mysqli_fetch_assoc($result_set)
    
    ?>
    
    <h1 style="color: #60b98b;">Notes:</h1>
    <form method="POST">
        <textarea style="background-color: black; color: white; font-weight:bold; width: 100%; height: 250px; border: none; resize: none; outline: none;" name="notes" placeholder="Enter your notes here..."><?php echo $results['notes']; ?></textarea>
        <br>
        <input type="submit" id="input-button" value="Save Notes">
    </form>
            </div>
        </div>
    </div>
    <script src="./js/popupdashboard.js" defer></script>
    </body>
    </html>
            
    