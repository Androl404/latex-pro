<?php

require_once("php-scripts/functions/database_access.php");
require_once("php-scripts/functions/die.php");
require_once("php-scripts/functions/files.php");

session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: login.php");
    exit();
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_project']) && isset($_POST['new_name'])) {

        require_once("config/database.php");

        $content = $_POST['content'];
        $projectId = mysqli_real_escape_string($conn, $_POST['id_project']) ?? null;
        $new_name = mysqli_real_escape_string($conn, $_POST['new_name']) ?? null;

        if (!$projectId) {
            sendResponseCodeAndDie(400);
        }
        $projectId = intval($projectId);
        if (!is_integer($projectId)) {
            sendResponseCodeAndDie(502);
        }
        if (!is_string($new_name) or empty($new_name)) {  // or !str_ends_with($file, ".tex")
            sendResponseCodeAndDie(400);
        }
        if (!check_file_uploaded_name($new_name) or check_file_uploaded_length($new_name, 100)) {
            sendResponseCodeAndDie(400);
        }

        if (userHasAccess($_SESSION['id'], $projectId, $conn)) {
            $sql = "UPDATE PROJECT SET project_name = ? WHERE id_project = ?";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
            if ($prepareStmt) {
                mysqli_stmt_bind_param($stmt, "si", $new_name, $projectId);
                mysqli_stmt_execute($stmt);
                exit();
            } else {
                sendResponseCodeAndDie(502, "Something went wrong");
                exit();
            }
        } else {
            sendResponseCodeAndDie(403);
            // echo 'Forbidden.';
        }
    } else {
        sendResponseCodeAndDie(405);
        // echo 'Method Not Allowed';
    }
}
