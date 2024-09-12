<?php

require_once("php-scripts/functions/database_access.php");
require_once("php-scripts/functions/files.php");
require_once("php-scripts/functions/die.php");

session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: login.php");
    exit();
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_project']) && isset($_POST['file'])) {
        require_once("config/database.php");

        $projectId = mysqli_real_escape_string($conn, $_POST['id_project']) ??  null;
        $to_delete = $_POST['file'];

        if (empty($to_delete) or !$to_delete) {
            http_response_code(400);
            echo 'Bad request.';
            exit;
        }
        if (str_contains($to_delete, "..") || ($to_delete === ".*")) {
            http_response_code(403);
            echo 'Forbidden';
            exit;
        }
        if (str_starts_with($to_delete, "/")) {
            $to_delete = mb_substr($to_delete, 1);
        }

        // On distingue ici deux  cas :
        //  1. On chercher à supprimer des dossiers
        //  2. On cherche à supprimer des fichiers

        if (userHasAccess($_SESSION['id'], $projectId, $conn)) {
            if (str_contains($to_delete, "main.tex")) {
                sendResponseCodeAndDie(403, "Forbidden");
            }
            $to_delete = glob("projects/$projectId/$to_delete", GLOB_BRACE);
            foreach ($to_delete as $to) {
                if (($to === ".") || ($to === "..")) continue;
                if (file_exists($to) && is_dir($to)) {
                    if (!rrmdir($to)) {
                        sendResponseCodeAndDie(502);
                    }
                } elseif (file_exists($to)) {
                    if (!unlink($to)) {
                        sendResponseCodeAndDie(502);
                    }
                } else {
                    sendResponseCodeAndDie(404, "Not found.");
                }
            }
        } else {
            http_response_code(403);
            echo "Forbidden";
            exit();
        }
    } else {
        http_response_code(400);
        echo 'Bad request.';
        exit;
    }
}
