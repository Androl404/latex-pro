<?php

session_start();
if (isset($_SESSION["user_name"])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form - LaTeX-pro</title>
    <link rel="stylesheet" href="css/font.css" />
    <link rel="stylesheet" href="css/login.css" />
    <link rel="stylesheet" href="css/latex.css" />
    <link rel="icon" href="img/favicon/icon_128.png" />
</head>

<body>
    <div class="login">
        <h1><span class="latex">L<sup>a</sup>T<sub>e</sub>X</span>-pro</h1>
        <h2>Registration form</h2>
        <p>Your username should not contain any spaces.<br>
            Your password should contain at least 8 caracters.<br>
            Your email adress must be a valid email adress.</p>
        <?php
        require_once("php-scripts/functions/database_access.php");
        require_once("config/database.php");
        if (!canRegister($conn)) {
            echo "<p><span class='bold'>Registration is turned off!</span></p>";
        }
        ?>
        <div>
            <form action="php-scripts/registration.php" method="post">
                <div class="input-box">
                    <label for="">Full name</label>
                    <input type="text" name="fullname" placeholder="Full Name" required="required" autocomplete="on">
                </div>
                <div class="input-box">
                    <label for="">User name (with no spaces)</label>
                    <input type="text" name="username" placeholder="User Name" required="required" autocomplete="on">
                </div>
                <div class="input-box">
                    <label for="">Valid email adress</label>
                    <input type="emamil" name="email" placeholder="Email" required="required" autocomplete="on">
                </div>
                <div class="input-box">
                    <label for="">Password</label>
                    <input type="password" name="password" placeholder="Password" required="required">
                </div>
                <div class="input-box">
                    <label for="">Re-enter password</label>
                    <input type="password" name="repeat_password" placeholder="Repeat password" required="required">
                </div>
                <p><span class="bold">Your account will be inacessible if you forget your password, please do not forget it!</span></p>
                <div>
                    <input type="submit" value="Register" name="submit" class="submit-button">
                </div>
            </form>
            <div>
                <div>
                    <p>Already Registered? <a href="login.php">Log-in here</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
