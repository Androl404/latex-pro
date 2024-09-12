<?php

require_once("php-scripts/functions/files.php");
require_once("php-scripts/functions/die.php");
require_once("php-scripts/functions/database_access.php");

session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: login.php");
    exit();
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_project'])) {
        require_once("config/database.php");

        $projectId = $_POST['id_project'];
        if (empty($projectId)) {
            sendResponseCodeAndDie(400, "Bad request.");
        }
        $projectId = intval($projectId);
        if (!is_int($projectId)) {
            sendResponseCodeAndDie(400, "Bad request.");
        }

        if (userHasAccess($_SESSION['id'], $projectId, $conn)) {
            $dir_content = dirToArray("projects/$projectId");
            $html_to_export = getFiles($dir_content, $projectId);
            echo $html_to_export;
            // print_r($dir_content);
        } else {
            sendResponseCodeAndDie(403, "Forbidden.");
        }
    }
}
