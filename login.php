<?php

session_start();
if (isset($_SESSION["user_name"])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form - LaTeX-pro</title>
    <link rel="stylesheet" href="css/font.css" />
    <link rel="stylesheet" href="css/login.css" />
    <link rel="stylesheet" href="css/latex.css" />
    <link rel="icon" href="img/favicon/icon_128.png" />
    <script src="modules/sweetalert-2.11/sweetalert.min.js"></script>
</head>

<body>
    <div class="login">
        <h1><span class="latex">L<sup>a</sup>T<sub>e</sub>X</span>-pro</h1>
        <?php
        $failure_messages = array(
            "account-disabled" => "Your account is disabled, please contact your network administrator.",
            "went-wrong-credentials" => "Something went wrong, credentials are invalid.",
            "registration-off" => "Registration is turned off, please contact your network administrator",
            "registration-failed" => "Registration has failed.",
            "all-fields-required" => "All fields are required in order to complete registration.",
            "email-not-valid" => "Your email adress is invalid.",
            "password-not-8-characters-long" => "Your password is not 8 characters long, please choose a stronger password.",
            "passwords-does-not-match" => "The passwords does not match.",
            "username-contains-spaces" => "Your user-name should not contain any spaces.",
            "email-exists" => "This email adress already exists.",
            "went-wrong" => "Something went wrong.",
        );
        $success_messages = array(
            "registration-success" => "The registration was successful, you can now log-in.",
        );

        foreach ($failure_messages as $short_err => $err_message) {
            if (isset($_GET[$short_err]) and $_GET[$short_err]) {
                echo "<div class='err-msg'>$err_message</div>";
            }
        }

        foreach ($success_messages as $short_mes => $success_message) {
            if (isset($_GET[$short_mes]) and $_GET[$short_mes]) {
                echo "<div class='ok-msg'>$success_message</div>";
            }
        }
        ?>
        <h2>Log-in form</h2>
        <div>
            <form action="php-scripts/log-in.php" method="post">
                <div class="input-box">
                    <label for="">Email</label>
                    <input type="email" placeholder="Enter Email" name="email" required="required" autocomplete="on">
                </div>
                <div class="input-box">
                    <label for="">Password</label>
                    <input type="password" placeholder="Enter Password" name="password" required="required">
                </div>
                <input type="submit" value="Login" name="login" class="submit-button">
            </form>
        </div>
        <div>
            <p>Not registered yet? <a href="register.php">Register here</a></p>
            <p>Forgot your password? <a id="password-fg" href="#password-fg">Click here</a></p>
        </div>
    </div>
    <script>
        document.getElementById("password-fg").addEventListener('click', function() {
            Swal.fire({
                title: "Password forgotten?",
                text: "Please contact your network administrator in order to get back your access to the service.",
                icon: "info",
                showCloseButton: true,
            });
        });
    </script>
</body>

</html>
