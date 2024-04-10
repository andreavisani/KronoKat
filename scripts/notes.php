<?php

//SET CONNECTION
$mysqli = require _DIR_ . "/database.php";
$user_id = mysqli_real_escape_string($mysqli, $_SESSION['users_id']);

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

<h1 style="color: white;">Notes</h1>
<form method="POST">
    <textarea style="background-color: black; color: white; font-weight:bold; width: 100%; height: 250px; border: none; resize: none; outline: none;" name="notes" placeholder="Enter your notes here..."><?php echo $results['notes']; ?></textarea>
    <br>
    <input type="submit" value="Save Notes">
</form>

