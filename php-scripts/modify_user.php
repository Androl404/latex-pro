<?php

require_once("functions/die.php");

session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: ../login.php");
    exit;
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["modify"])) {

        $errors = array();
        require_once "../config/database.php";

        $fullName = mysqli_real_escape_string($conn, $_POST["fullname"]);
        $userName = mysqli_real_escape_string($conn, $_POST["username"]);
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);
        $passwordRepeat = mysqli_real_escape_string($conn, $_POST["repeat_password"]);

        if (empty($fullName) or empty($email) or empty($userName)) {
            array_push($errors, "all-fields-required");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "email-not-valid");
        }
        if (!empty($password)) {
            if (strlen($password) < 8) {
                array_push($errors, "password-not-8-characters-long");
            }
        }
        if ($password !== $passwordRepeat) {
            array_push($errors, "passwords-does-not-match");
        }
        if (str_contains($userName, ' ')) {
            array_push($errors, "username-contains-spaces");
        }

        if (count($errors) > 0) {
            show_errors_and_die($errors, "../dashboard.php", "modification-failed");
            exit();
        } else {
            if (empty($password)) {
                $sql = "UPDATE USER SET user_name = ?, full_name = ?, email = ? WHERE id = ?";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                if ($prepareStmt) {
                    mysqli_stmt_bind_param($stmt, "sssi", $userName, $fullName, $email, $_SESSION['id']);
                    mysqli_stmt_execute($stmt);
                    // echo "<div>Your informations were updated successfully!</div>";
                    header("Location: logout.php");
                    exit();
                } else {
                    array_push($errors, "went-wrong");
                    show_errors_and_die($errors, "../dashboard.php", "modification-failed");
                    exit();
                }
            } elseif (!empty($password)) {
                $passwordHash = password_hash($password . "GG#HZ2pqY00Zo>g7kn>iqM~1I?*£u3pUH(g6x`vD", PASSWORD_DEFAULT);
                $sql = "UPDATE USER SET user_name = ?, full_name = ?, email = ?, password = ? WHERE id = ?";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                if ($prepareStmt) {
                    mysqli_stmt_bind_param($stmt, "ssssi", $userName, $fullName, $email, $passwordHash, $_SESSION['id']);
                    mysqli_stmt_execute($stmt);
                    // echo "<div>Your informations were updated successfully!</div>";
                    header("Location: logout.php");
                    exit();
                } else {
                    array_push($errors, "went-wrong");
                    show_errors_and_die($errors, "../dashboard.php", "modification-failed");
                    exit();
                }
            } else {
                array_push($errors, "went-wrong");
                show_errors_and_die($errors, "../dashboard.php", "modification-failed");
                exit();
            }
        }
    }
}
