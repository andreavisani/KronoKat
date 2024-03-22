<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" type="text/css" href="styles/indexcss.css">
    <title>Hello there!</title>
</head>
<body>
    
    <!-- SET THE CONNECTION -->
    <?php 
    require_once('./database/db_credentials.php');
    require_once('./database/database.php');

    $db = db_connect();
    ?>

    
    <div style="display: flex;">
        <!-- TASK SORTED BY DUE DATE -->
        <div style="border: 2px solid black; background-color: white; margin-block: 0.5rem; margin-inline: auto; border-radius: 10px; padding: 2rem;">
            <h3>Approaching Due Dates</h3>
            <?php 
                $sql = "SELECT tasks.*, IFNULL(projects.name, '') AS 'project' 
                        FROM tasks 
                        JOIN users_tasks ON tasks.id = users_tasks.task_id 
                        LEFT JOIN projects ON tasks.project_id = projects.id 
                        WHERE users_tasks.user_id = 10 
                        ORDER BY tasks.due_date ASC;";
                //echo $sql;
                $result_set = mysqli_query($db,$sql);
            ?>
            <?php while($results = mysqli_fetch_assoc($result_set)) { ?>
                <div style="border: 2px solid black; background-color: grey; max-width: 300px; margin-block: 0.5rem; margin-inline: auto; border-radius: 10px; padding: 1rem;">
                    <p style="color:white;"><b><?php echo $results['name']; ?></b></p>
                    <p><b>Location: </b><?php echo $results['location']; ?></p>
                    <p><b>Description: </b><?php echo $results['description'] ; ?></p>
                    <p><b>Start date: </b><?php echo $results['start_date']; ?></p>
                    <p><b>Due date: </b><?php echo $results['due_date']; ?></p>
                    <p><b>Project name: </b><?php echo $results['project']; ?></p>
                    <td><a class="action" href="<?php echo"show.php?id=" . $results['id']; ?>">View</a></td>
                    <td><a class="action" href="<?php echo "edit.php?id=" . $results['id']; ?>">Edit</a></td>
                    <td><a class="action" href="<?php echo "delete.php?id=" . $results['id']; ?>">delete</a></td>
                    <td><a class="action" href="<?php echo "showUsersTasks.php?id=" . $results['id']; ?>">View tasks</a></td>
                    
                </div>
            <?php } ?>
        </div>
        
        <!-- STARTING TODAY -->
        <div style="border: 2px solid black; background-color: white; margin-block: 0.5rem; margin-inline: auto; border-radius: 10px; padding: 2rem;">
            <h3>Starting Today</h3>
            <?php 
                $sql = "SELECT tasks.*, IFNULL(projects.name, '') AS 'project' 
                        FROM tasks 
                        JOIN users_tasks ON tasks.id = users_tasks.task_id 
                        JOIN projects ON tasks.project_id = projects.id 
                        WHERE users_tasks.user_id = 10 -- WE NEED TO REPLACE THIS USER ID WITH THE VARIABLE COMING FROM POST
                        AND DATE(tasks.start_date) = CURDATE();";
                //echo $sql;
                $result_set = mysqli_query($db,$sql);
            ?>
            <?php while($results = mysqli_fetch_assoc($result_set)) { ?>
                <div style="border: 2px solid black; background-color: grey; max-width: 300px; margin-block: 0.5rem; margin-inline: auto; border-radius: 10px; padding: 1rem;">
                    <p style="color:white;"><b><?php echo $results['name']; ?></b></p>
                    <p><b>Location: </b><?php echo $results['location']; ?></p>
                    <p><b>Description: </b><?php echo $results['description'] ; ?></p>
                    <p><b>Start date: </b><?php echo $results['start_date']; ?></p>
                    <p><b>Due date: </b><?php echo $results['due_date']; ?></p>
                    <p><b>Project name: </b><?php echo $results['project']; ?></p>
                    <td><a class="action" href="<?php echo"show.php?id=" . $results['id']; ?>">View</a></td>
                    <td><a class="action" href="<?php echo "edit.php?id=" . $results['id']; ?>">Edit</a></td>
                    <td><a class="action" href="<?php echo "delete.php?id=" . $results['id']; ?>">delete</a></td>
                    <td><a class="action" href="<?php echo "showUsersTasks.php?id=" . $results['id']; ?>">View tasks</a></td>
                    
                </div>
            <?php } ?>
        </div>

        <!-- ONGOING -->
        <div style="border: 2px solid black; background-color: white; margin-block: 0.5rem; margin-inline: auto; border-radius: 10px; padding: 2rem;">
            <h3>Ongoing Tasks</h3>
            <?php 
                $sql = "SELECT tasks.*, IFNULL(projects.name, '') AS 'project' 
                        FROM tasks 
                        JOIN users_tasks ON tasks.id = users_tasks.task_id 
                        JOIN projects ON tasks.project_id = projects.id 
                        WHERE users_tasks.user_id = 10 -- WE NEED TO REPLACE THIS USER ID WITH THE VARIABLE COMING FROM POST
                        AND CURDATE() BETWEEN DATE(tasks.start_date) AND DATE(tasks.due_date)
                        ORDER BY tasks.due_date ASC;";
                //echo $sql;
                $result_set = mysqli_query($db,$sql);
            ?>
            <?php while($results = mysqli_fetch_assoc($result_set)) { ?>
                <div style="border: 2px solid black; background-color: grey; max-width: 300px; margin-block: 0.5rem; margin-inline: auto; border-radius: 10px; padding: 1rem;">
                    <p style="color:white;"><b><?php echo $results['name']; ?></b></p>
                    <p><b>Location: </b><?php echo $results['location']; ?></p>
                    <p><b>Description: </b><?php echo $results['description'] ; ?></p>
                    <p><b>Start date: </b><?php echo $results['start_date']; ?></p>
                    <p><b>Due date: </b><?php echo $results['due_date']; ?></p>
                    <p><b>Project name: </b><?php echo $results['project']; ?></p>
                    <td><a class="action" href="<?php echo"show.php?id=" . $results['id']; ?>">View</a></td>
                    <td><a class="action" href="<?php echo "edit.php?id=" . $results['id']; ?>">Edit</a></td>
                    <td><a class="action" href="<?php echo "delete.php?id=" . $results['id']; ?>">delete</a></td>
                    <td><a class="action" href="<?php echo "showUsersTasks.php?id=" . $results['id']; ?>">View tasks</a></td>
                    
                </div>
            <?php } ?>
        </div>






    </div>
    


    
</body>
</html>


