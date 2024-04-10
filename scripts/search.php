<!-- SET THE CONNECTION -->
<?php
$mysqli = require __DIR__ . "/database.php";
?>

<h1>Search Page</h1>

<div class="container">
    <?php
    if (isset($_GET['submit-search'])) {
        $search = mysqli_real_escape_string($mysqli, $_GET['search']);
        $sql = "SELECT * FROM tasks WHERE tasks.name LIKE '%$search%' 
                OR tasks.location LIKE '%$search%' 
                OR tasks.description LIKE '%$search%'";
        $result = mysqli_query($mysqli, $sql);
        $queryResult = mysqli_num_rows($result);

        if ($queryResult > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div> 
                <h3>" . $row['name'] . "</h3>
                <P>" . $row['location'] . "</p>
                <P>" . $row['description'] . "</p>
                <P>" . $row['start_date'] . "</p>
                <P>" . $row['due_date'] . "</p>
                </div>";
            }
        } else {
            echo "there are no results matching your search !";
        }
    }

    ?>
</div>