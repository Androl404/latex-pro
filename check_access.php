<?php

require_once("config/database.php");
require_once("config/config.php");
require_once("php-scripts/functions/database_access.php");
require_once("php-scripts/functions/die.php");

session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: $super_path/login.php");
    exit();
} else {
    if (!isset($_GET['file'])) {
        sendResponseCodeAndDie(400, "Bad request.");
    }

    $file = $_GET['file'];
    $pathParts = explode('/', $file);
    $projectId = $pathParts[1] ?? null;

    if (!$projectId || !isset($_SESSION["user_name"])) {
        sendResponseCodeAndDie(403, "Access denied.");
    }

    if (!userHasAccess($_SESSION['id'], $projectId, $conn)) {
        sendResponseCodeAndDie(403, "Access denied.");
    }

    // Serve the file
    $filePath = __DIR__ . '/' . $file;
    # echo $filePath;
    if (file_exists($filePath)) {
        header('Content-Type: ' . mime_content_type($filePath));
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    } else {
        sendResponseCodeAndDie(404, "File not found.");
    }
}
