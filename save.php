<?php

require_once("php-scripts/functions/database_access.php");
require_once("php-scripts/functions/die.php");

session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: login.php");
    exit();
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_project']) && isset($_POST['file']) && isset($_POST['content'])) {

        require_once("config/database.php");

        $content = $_POST['content'];
        $projectId = mysqli_real_escape_string($conn, $_POST['id_project']) ?? null;
        $file = mysqli_real_escape_string($conn, $_POST['file']) ?? null;

        if (!$projectId) {
            sendResponseCodeAndDie(400);
        }
        $projectId = intval($projectId);
        if (!is_integer($projectId)) {
            sendResponseCodeAndDie(502);
        }
        if (!is_string($file) or empty($file)) {  // or !str_ends_with($file, ".tex")
            sendResponseCodeAndDie(400);
        }

        if (userHasAccess($_SESSION['id'], $projectId, $conn)) {
            // Définir le chemin du fichier où le contenu sera sauvegardé
            $filePath = "projects/$projectId/$file";
            $content = iconv(mb_detect_encoding($content, mb_detect_order(), true), "UTF-8", $content);

            // Sauvegarder le contenu dans le fichier
            if (file_put_contents($filePath, $content, LOCK_EX)) {
                if (!$_SESSION['isAdmin']) {
                    $sql = "UPDATE PROJECT SET last_saved=current_timestamp() WHERE id_project = ?";
                    $stmt = mysqli_stmt_init($conn);
                    $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                    if ($prepareStmt) {
                        mysqli_stmt_bind_param($stmt, "i", $projectId);
                        mysqli_stmt_execute($stmt);
                    } else {
                        sendResponseCodeAndDie(502, "Something went wrong");
                    }
                    // echo 'File saved successfully!';
                }
            } else {
                sendResponseCodeAndDie(500);
                // echo 'Failed to save the file.';
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
