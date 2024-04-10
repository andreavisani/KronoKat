<?php 
session_start();
$_SESSION = array(); 
session_destroy(); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/index.css">
    <link rel="stylesheet" href="./styles/headerindex.css">
    <link rel="stylesheet" href="./styles/footer.css">

    <title>KronoKat - Manage your tasks</title>
</head>

<body>

    <?php include('header.php'); ?>

    <section class="Home">
        <div class="features_container">
            <div id="Features">
                <div class="features"><b>Supercharge Your Productivity</b></div>
                <div class="features"><b>Collaborate Like a Professional</b></div>
                <div class="features"><b>Effortless Task Management</b></div>
            </div>

            <div id="kronokat_container">
                <h1>KRRONOKAT</h1>
                <p><em>Your personal task manager.</em></p>
            </div>
        </div>
    </section>
    <script src="./js/indexscript.js"></script>
    <section class="About">
        <div class="page-containers">
            <div class="card-container">
                <h2>Filter</h2>
                <div class="card-text-paragraph">
                Discover the power of our app's streamlined task management system. Effortlessly find and access your tasks with precision and speed. <br>
                <br>
                Our intuitive interface ensures that tasks are organized and easily retrievable, saving you valuable time and maximizing productivity. Experience the convenience of locating tasks instantly, empowering you to stay focused and achieve more
                </div>
                <div class="card-icon">
                    <image src="./images/filter.png"></image>
                </div>
            </div>

            <div class="card-container">
                <h2>Organize</h2>
                <div class="card-text-paragraph">
                Unlock the potential of our app to revolutionize your scheduling experience. Seamlessly organize your schedule with ease and efficiency. <br>
                <br>
                From appointments to deadlines, our intuitive platform empowers you to arrange and manage your time effectively. Experience the freedom of a well-structured schedule, allowing you to stay on track and accomplish your goals with confidence
                </div>
                <div class="card-icon">
                    <image src="./images/organize.png"></image>
                </div>
            </div>

            <div class="card-container">
                <h2>Collab</h2>
                <div class="card-text-paragraph">
                Experience the collaborative power of our app, bringing teams together like never before. Seamlessly collaborate with colleagues, share updates, and delegate tasks effortlessly. <br>
                <br>
                collaboration regardless of distance. Empower your team to achieve collective goals with ease, fostering productivity and innovation
                </div>
                <div class="card-icon">
                    <image src="./images/collaborate.png"></image>
                </div>
            </div>
        </div>
    </section>
    
    <?php include('./footer.php'); ?>
</body>

</html>