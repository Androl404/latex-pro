<?php
/* require_once("php-scripts/functions/database_access.php"); */
require_once("../php-scripts/functions/die.php");

session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: ../login.php");
    exit();
} else {
    $errors = array();
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subject']) && isset($_POST['message'])) {
        date_default_timezone_set("Europe/Paris");
        $to = "andrei@4.local";
        $subject = "[LaTeX-pro] - " . $_POST['subject'];
        $message = $_POST['message'];
        if (isset($_SESSION) && isset($_SESSION['email'])) {
            $headers = array(
                'From' => 'noreply@4.local',
                'Reply-To' => $_SESSION['email'],
                'X-Mailer' => 'PHP/' . phpversion()
            );

            $pre_message = "This message is coming from the contact page from LaTeX-pro (<https://zeo.hopto.org/latex-pro/>).\nFrom: " . $_SESSION['full_name'] . "\nEmail: " . $_SESSION['email'] . "\nSend date: " . date("Y-m-d H:i:s") . "\n\nMessage:\n";
            $return_code = mail($to, $subject, $pre_message . $message, $headers);
            if (!$return_code) {
                array_push($errors, "went-wrong");
            } else {
                header("Location: ../index.php?message-sent=1");
            }
        } else {
            array_push($errors, "went-wrong");
        }
    } else {
        array_push($errors, "went-wrong");
    }
    show_errors_and_die($errors, "../index.php", "message-error");
}
