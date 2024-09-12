<?php

session_start();
if (isset($_SESSION["user_name"])) {
    header("Location: ../index.php");
    exit;
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["login"])) {
        require_once "../config/database.php";
        $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
        if (!$email) {
            sleep($sleep_time);
            header("Location: ../login.php?went-wrong-credentials=1");
            exit();
        }
        $email = mysqli_real_escape_string($conn, $email);
        $password = mysqli_real_escape_string($conn, $_POST["password"]) ?? null;

        $sleep_time = 3; // Temps (en secondes) d'attente en cas d'erreur d'identification
        if ($email and $password and !empty($email) and !empty($password)) {
            $sql = "SELECT * FROM USER WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

            if ($user) {
                if ($user['isActivated']) {
                    if ($user and password_verify($password . "GG#HZ2pqY00Zo>g7kn>iqM~1I?*£u3pUH(g6x`vD", $user["password"])) {
                        session_start();
                        $_SESSION["user_name"] = $user["user_name"];
                        $_SESSION["full_name"] = $user["full_name"];
                        $_SESSION["email"] = $user["email"];
                        $_SESSION["id"] = $user["id"];
                        $_SESSION["isAdmin"] = $user["isAdmin"];
                        $sql = "UPDATE USER SET last_activity=current_timestamp() WHERE email='$email'";
                        $stmt = mysqli_stmt_init($conn);
                        $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                        if ($prepareStmt) {
                            mysqli_stmt_execute($stmt);
                        } else {
                            sleep($sleep_time);
                            header("Location: ../login.php?went-wrong=1");
                            exit();
                            /* die("Something went wrong"); */
                        }
                        header("Location: ../index.php");
                        exit();
                    } else {
                        sleep($sleep_time);
                        header("Location: ../login.php?went-wrong-credentials=1");
                    }
                } else {
                    sleep($sleep_time);
                    header("Location: ../login.php?account-disabled=1");
                }
            } else {
                sleep($sleep_time);
                header("Location: ../login.php?went-wrong-credentials=1");
            }
        } else {
            sleep($sleep_time);
            header("Location: ../login.php?went-wrong-credentials=1");
        }
    } else {
        header("Location: ../index.php");
    }
}
