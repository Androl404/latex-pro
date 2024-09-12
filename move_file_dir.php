<?php

require_once("php-scripts/functions/database_access.php");
require_once("php-scripts/functions/files.php");
require_once("php-scripts/functions/die.php");

session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: login.php");
    exit();
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_project']) && isset($_POST['to_move']) && isset($_POST['destination'])) {
        require_once("config/database.php");

        $projectId = mysqli_real_escape_string($conn, $_POST['id_project']) ?? null;
        $to_move = $_POST['to_move'];
        $destination = $_POST['destination'];

        if (empty($to_move) or !$to_move or empty($destination) or !$destination) {
            sendResponseCodeAndDie(400, "Bad request");
        }
        if (str_contains($to_move, "..") or str_contains($destination, "..")) {
            sendResponseCodeAndDie(403, "Forbidden");
        }
        if (str_starts_with($to_move, "/")) {
            $to_move = mb_substr($to_move, 1);
        }
        /* if (str_starts_with($destination, "/")) { */
        /*     $destination = mb_substr($destination, 1); */
        /* } */
        if (userHasAccess($_SESSION['id'], $projectId, $conn)) {
            // `mv projects/{$projectId}/{$to_move} projects/{$projectId}/{$destination}`; # the solution was so simple
            $result = array();
            $return_code = 0;
            exec("mv projects/{$projectId}/{$to_move} projects/{$projectId}/{$destination}", $result, $return_code);
            if ($return_code) {
                sendResponseCodeAndDie(502, "Something went wrong");
            }
        } else {
        }
    } else {
        sendResponseCodeAndDie(400, "Bad request");
    }
}

/*
function theCrappyCodeIWrote()
{
    $file_array = glob("projects/$projectId/$to_move", GLOB_BRACE | GLOB_MARK);
    if (count($file_array) == 0) {
        sendResponseCodeAndDie(409, "No file selected.");
    } elseif (count($file_array) === 1) {
        if (file_exists($file_array[0]) and is_dir($file_array[0]) and str_ends_with($destination, "/")) {
            try {
                rmoveWrapper($file_array[0], "projects/$projectId/$destination");
            } catch (Exception $e) {
                sendResponseCodeAndDie(502, "Something went wrong.");
            }
        } elseif (file_exists($file_array[0]) and !is_dir($file_array[0])) {
            if (str_ends_with($destination, "/")) {
                $file_array_temp = explode("/", $file_array[0]);
                $destination . +$file_array_temp[-1];
            }
            if (!rename($file_array[0], "projects/$projectId/$destination")) {
                sendResponseCodeAndDie(502, "Something went wrong");
            }
        } else {
            sendResponseCodeAndDie(400, "File do not exist or destination incorrect.");
        }
    } else {
        if (str_ends_with($destination, "/")) {
            foreach ($file_array as $file) {
                if (is_dir($file)) {
                    try {
                        rmoveWrapper($file, "projects/$projectId/$destination");
                    } catch (Exception $e) {
                        sendResponseCodeAndDie(502, "Something went wrong.");
                    }
                } else {
                    if (!rename($file, "projects/$projectId/$destination")) {
                        sendResponseCodeAndDie(502, "Something went wrong");
                    }
                }
            }
        } else {
            sendResponseCodeAndDie(400, "File do not exist or destination incorrect.");
        }
    }
}
*/
