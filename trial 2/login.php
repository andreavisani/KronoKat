<?php
$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM users WHERE login = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $_POST["login"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if($user) {
        if (password_verify($_POST["password"],$user["password"])){

            session_start(); 
            $_SESSION["users_id"] = $user['id'];
            header('Location: ./dashboard.php');
            exit; 
        }
    }
    $is_invalid=true;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    
    <h1>Login</h1>

    <?php
        if ($is_invalid): ?>
        <em>Invalid Login</em>
    <?php endif; ?>

    
    <form method="post">
        <label for="User-name">User-Name</label>
        <input type="text" name="login" id="login">
        
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        
        <button>Log in</button>
    </form>
    
</body>
</html>
