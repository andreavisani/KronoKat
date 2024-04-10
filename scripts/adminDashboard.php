<?php
session_start();

//MAKE SURE THE USER IS CONNECTED
if (!isset($_SESSION['users_id'])) {
    header("Location: login.php");
    exit; // Make sure to stop the script after redirection
}

//SET CONNECTION
$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT tasks.*, IFNULL(projects.name, '') AS 'project' 
        FROM tasks 
        LEFT JOIN projects ON tasks.project_id = projects.id 
        ORDER BY tasks.due_date ASC;";
$result_set = mysqli_query($mysqli, $sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tasks</title>

    <style>

    @font-face {
    font-family: 'Louie'; /* Name your font */
    src: url('./fonts/louis_george_cafe/Louis\ George\ Cafe\ Bold.ttf') format('truetype'), /* Specify the path to your font file */
    }

    @font-face {
    font-family: 'Stretch';
    src: url('./fonts/stretch_pro/StretchPro.otf') format('opentype');
}
 
        /* CSS styles here */
        body {
            font-family: 'Louie'; 
            background-color: #f8f8f8; /* Light gray background */
            padding: 20px; /* Add some padding */
        }

        h2 {
            margin-bottom: 20px; /* Add some spacing below the heading */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff; /* White background for the table */
            border: 1px solid #ddd; /* Add a border around the table */
        }

        th, td {
            border: 1px solid #ddd; /* Add border to table cells */
            padding: 10px; /* Add padding to table cells */
            text-align: left; /* Align text to the left in table cells */
        }

        th {
            background-color: #f2f2f2; /* Light gray background for table headers */
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9; /* Alternate row background color */
        }

        a {
            color: #007bff; /* Blue link color */
            text-decoration: none; /* Remove underline from links */
        }

        a:hover {
            text-decoration: underline; /* Add underline on hover */
        }

        .footer {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column; 
    min-height: 200px;
}
.footer-text {
   color:rgb(160, 76, 135); 
   font-family: "Stretch";
}

.final-copyright {
    margin-top: 10px;
    color: black; 
    font-family: "Louie";
}
    </style>
</head>

<body>

    <h2>Tasks</h2>

    <table>
        <thead>
            <tr>
                <th>Task ID</th>
                <th>Task Name</th>
                <th>Due Date</th>
                <th>Project</th>
                <th>View</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result_set)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['due_date'] . "</td>";
                echo "<td>" . $row['project'] . "</td>";
                // View link
                echo "<td><a href='viewTask.php?id="   . $row['id'] . "'>View</a></td>";
                // Edit link
                echo "<td><a href='edit.php?id="   . $row['id'] . "'>Edit</a></td>";
                // Delete link
                echo "<td><a href='deleteTask.php?id=" . $row['id'] . "'>Delete</a></td>";
                echo "</tr>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <?php include('./footer.php'); ?>
</body>

</html>
