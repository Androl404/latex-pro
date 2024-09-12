<?php

require_once("functions/die.php");

session_start();
if (isset($_SESSION["user_name"])) {
    header("Location: ../index.php");
    exit;
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["submit"])) {
        $errors = array();
        
        require_once("../config/database.php");
        require_once("functions/database_access.php");
        if (!canRegister($conn)) { 
            array_push($errors, "registration-off");
            // header("Location: ../login.php?registration-off=1");
            show_errors_and_die($errors, "../login.php", "registration-failed");
            exit;
        }

        require_once "../config/database.php";
        $fullName = mysqli_real_escape_string($conn, $_POST["fullname"]);
        $userName = mysqli_real_escape_string($conn, $_POST["username"]);
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);
        $passwordRepeat = mysqli_real_escape_string($conn, $_POST["repeat_password"]);

        $isAdmin = 0; // Faux par défaut
        $isActivated = 1; // Vrai par défaut

        if (empty($fullName) or empty($email) or empty($password) or empty($passwordRepeat) or empty($userName)) {
            array_push($errors, "all-fields-required");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "email-not-valid");
        }
        if (strlen($password) < 8) {
            array_push($errors, "password-not-8-characters-long");
        }
        if ($password !== $passwordRepeat) {
            array_push($errors, "passwords-does-not-match");
        }
        if (str_contains($userName, ' ')) {
            array_push($errors, "username-contains-spaces");
        }

        if (count($errors) > 0) {
            show_errors_and_die($errors, "../login.php", "registration-failed");
            exit();
        }

        $sql = "SELECT * FROM USER WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        $rowCount = mysqli_num_rows($result);

        if ($rowCount > 0) {
            array_push($errors, "email-exists");
            show_errors_and_die($errors, "../login.php", "registration-failed");
            exit();
        }
        if (count($errors) == 0) {
            $passwordHash = password_hash($password . "GG#HZ2pqY00Zo>g7kn>iqM~1I?*£u3pUH(g6x`vD", PASSWORD_DEFAULT);
            $sql = "INSERT INTO USER (user_name, full_name, email, password, isAdmin, isActivated) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
            if ($prepareStmt) {
                mysqli_stmt_bind_param($stmt, "ssssii", $userName, $fullName, $email, $passwordHash, $isAdmin, $isActivated);
                mysqli_stmt_execute($stmt);
                header("Location: ../login.php?registration-success=1");
                exit();
            } else {
                // die("Something went wrong");
                array_push($errors, "went-wrong");
                show_errors_and_die($errors, "../login.php", "registration-failed");
                exit();
            }
        } else {
            array_push($errors, "went-wrong");
            show_errors_and_die($errors, "../login.php", "registration-failed");
            exit();
        }
    } else {
        header("Location : ../login.php");
    }
}
