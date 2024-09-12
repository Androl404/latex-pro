<?php

session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your dashboard - LaTeX-pro</title>
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/header_footer.css">
    <link rel="stylesheet" href="css/latex.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/content.css">
    <link rel="icon" href="img/favicon/icon_128.png" />
    <script src="modules/sweetalert-2.11/sweetalert.min.js"></script>
</head>

<body>

    <?php require("header.php"); ?>

    <div id="content-doc">
        <div>
            <h1>Welcome to your dashboard <?php echo $_SESSION["full_name"]; ?></h1>
            <p>In this page, you can modify your personal information.</p>
            <p>If your informations are succesfully updated, your will be <span class="bold">loged out</span>.
            <p>If you do not want to modify your password, leave the text inputs empty. Else, fill in your new password.</p>

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
                "modification-failed" => "No modification were made, resulting in failure."
            );

            foreach ($failure_messages as $short_err => $err_message) {
                if (isset($_GET[$short_err]) and $_GET[$short_err]) {
                    echo "<div>$err_message</div>";
                }
            }

            require_once("config/database.php");
            $sql = "SELECT last_activity FROM USER WHERE email = '" . mysqli_real_escape_string($conn, $_SESSION['email']) . "'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            ?>
            <div>
                <form action="php-scripts/modify_user.php" method="post">
                    <div class="input-box">
                        <label for="">User name</label>
                        <input type="text" placeholder="Username" name="username" value="<?php echo $_SESSION['user_name']; ?>" required="required" autocomplete="on"></input>
                    </div>
                    <div class="input-box">
                        <label for="">Full name</label>
                        <input type="text" placeholder="Full name" name="fullname" value="<?php echo $_SESSION['full_name']; ?>" required="required" autocomplete="on"></input>
                    </div>
                    <div class="input-box">
                        <label for="">Email</label>
                        <input type="email" placeholder="Your email" name="email" value="<?php echo $_SESSION['email']; ?>" required="required" autocomplete="on"></input>
                    </div>
                    <div class="input-box">
                        <label for="">Modify password</label>
                        <input type="password" placeholder="Password" name="password"></input>
                    </div>
                    <div class="input-box">
                        <label for="">Re-type password</label>
                        <input type="password" placeholder="Re-type password" name="repeat_password"></input>
                    </div>
                    <input type="submit" value="Modify" name="modify" class="submit-button">
                </form>
            </div>

            <div>
                Last login date and time: <span><?php echo $user['last_activity']; ?></span></input>
            </div>
        </div>
    </div>

    <?php require("footer.php"); ?>

</body>

</html>
