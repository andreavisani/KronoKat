<nav class="navbar">
    <div class="logo">
        <img src="images/blackcat.png" alt="Logo">
        <a href="#">KRRONOKAT</a>
    </div>
    <ul class="navdiv-ul">
        <li><a href="#" >Home</a></li>
        <li><a href="./signup.php" class="active">Signup</a></li>
        <li><a href="./login.php">Login</a></li>
    </ul>
    <div class="hamburger">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </div>
</nav>

<script>
    const hamburger = document.querySelector('.hamburger');
    const navUl = document.querySelector('.navdiv-ul');

    hamburger.addEventListener('click', function () {
        hamburger.classList.toggle('active');
        navUl.classList.toggle('active');
    });
</script>
