<?php

require_once("php-scripts/functions/database_access.php");
require_once("php-scripts/functions/files.php");
require_once("php-scripts/functions/die.php");

session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: login.php");
    exit();
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_project']) && isset($_POST['file']) && isset($_POST['type'])) {
        require_once("config/database.php");

        $projectId = mysqli_real_escape_string($conn, $_POST['id_project']) ??  null;
        $to_create = $_POST['file'];

        if (empty($to_create) or !$to_create) {
            sendResponseCodeAndDie(400, "Bad request.");
        }
        if (str_contains($to_create, "..")) {
            sendResponseCodeAndDie(403, "Forbidden.");
        }
        // if (!check_file_uploaded_name($to_create)) {
        //     sendResponseCodeAndDie(400, "File name invalid");
        // }
        if (check_file_uploaded_length($to_create, 255)) {
            sendResponseCodeAndDie(400, "File name is too long");
        }
        if (str_starts_with($to_create, "/")) {
            $to_create = mb_substr($to_create, 1);
        }
        // if (str_contains($to_create, "main.tex")) {
        //     sendResponseCodeAndDie(403, "Forbidden");
        // }

        // On distingue ici trois cas :
        //  1. On chercher à créer des dossiers
        //  2. On cherche à créer des dossiers et des fichiers
        //  3. On cherche à créer un fichier

        if (userHasAccess($_SESSION['id'], $projectId, $conn)) {
            if (str_ends_with($to_create, "/") || ($_POST['type'] === 'folder')) {
                createDir($to_create, $projectId);
            } elseif (!str_contains($to_create, "/") && ($_POST['type'] === 'file')) {
                createFile($to_create, $projectId);
            } elseif (($_POST['type'] === 'file')) {
                if (str_contains($to_create, "/")) {
                    $dirs = explode("/", $to_create);
                    $file_to_create = array_pop($dirs);
                    $dirs = implode("/", $dirs);
                    createDir($dirs, $projectId);
                    createFile($to_create, $projectId);
                } else {
                    sendResponseCodeAndDie(400, "Bad request.");
                }
            } else {
                sendResponseCodeAndDie(400, "Bad request.");
            }
        } else {
            sendResponseCodeAndDie(403, "Forbidden.");
        }
    } else {
        sendResponseCodeAndDie(400, "Bad request.");
    }
}
