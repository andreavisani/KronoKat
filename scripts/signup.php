
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="./styles/stylesignup.css">
        <title>Signup</title>
    </head>
    
    <body>
        <div class="formcontainer">
            <h1>KRRONOKAT</h1>
            <hr>
            <form action="process-signup.php" method="post" onsubmit="return validate();">
                
                <div class="textfield">
                    <label for="firstName">First Name </label>
                    <input type="text" name="fName" id="fname" placeholder="First Name">
                </div>
    
                <div class="textfield">
                    <label for="lastName">Last Name</label>
                    <input type="text" name="lName" id="lname" placeholder="Last Name">
                </div>
    
                <div class="datefield">
                    <label for="dob">Date of Birth</label>
                    <input type="date" name="dob" id="dob" placeholder="Date of Birth">
                </div>
    
                <div class="textfield">
                    <label for="email">Email Address</label>
                    <input type="text" name="email" id="email" placeholder="Email">
                </div>
                
                <div class="textfield">
                    <label for="login">User Name</label>
                    <input type="text" name="login" id="login" placeholder="User name">
                </div>
    
                <div class="textfield">
                    <label for="pass">Password</label>
                    <input type="password" name="pass" id="pass" placeholder="Password">
                </div>
            
                <div class="textfield">
                    <label for="pass2">Re-type Password</label>
                    <input type="password" id="pass2" placeholder="Password">
                </div>
    
                <div class="checkbox">
                    <input type="checkbox" name="terms" id="terms">
                    <label for="terms">I Agree to the terms and conditions</label>
                </div>
                <div class="button">
                <button type="submit">Sign-Up</button>
                </div>
    
            </form>
        </div>
        <script src="./js/scriptsignup.js"></script>
    </body>
</html>
    
    
