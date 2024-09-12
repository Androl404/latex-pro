<?php

session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact us - LaTeX-pro</title>
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
            <h1>Contact us</h1>
            <p>
                This form has for objective to send a message to the team working behind <span class='latex-pro'><span class='latex'>L<sup>a</sup>T<sub>e</sub>X</span>-pro</span>. We will try to answer you the most quickly possible on your registered email, which can be found in <a href="dashboard.php">your dashboard</a>.
            </p>
            <p>
                You're welcome to fill in this form if you found a security issue, a bug, if you have a feature request, an improvement to make to the tool, or if you just want to give us a constructive feedback on your experience with <span class='latex-pro'><span class='latex'>L<sup>a</sup>T<sub>e</sub>X</span>-pro</span>.
            </p>
            <form action="php-scripts/contact-us.php" method="post">
                <div class="input-box">
                    <label for="">Subject</label>
                    <input type="text" placeholder="Subject" name="subject" required="required" autocomplete="on"></input>
                </div>
                <div class="input-box">
                    <label for="">Message</label>
                    <textarea placeholder="Message" name="message" required="required" rows="10"></textarea>
                </div>

                <input type="submit" value="Send" name="modify" class="submit-button">
            </form>
            <p>
                We would like to thank you for the time you will take to write us your message, thank you for using <span class='latex-pro'><span class='latex'>L<sup>a</sup>T<sub>e</sub>X</span>-pro</span>.
            </p>
        </div>
    </div>

    <?php require("footer.php"); ?>

</body>

</html>
