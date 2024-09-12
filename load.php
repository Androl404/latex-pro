<?php

require_once("php-scripts/functions/database_access.php");
require_once("php-scripts/functions/die.php");

session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: login.php");
    exit();
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_project'])) {
        require_once("config/database.php");

        $projectId = mysqli_real_escape_string($conn, $_POST['id_project']) ?? null;
        $file = mysqli_real_escape_string($conn, $_POST['file']) ?? null;

        if (!$projectId or empty($projectId)) {
            sendResponseCodeAndDie(403);
        }
        $projectId = intval($projectId);
        if (!is_integer($projectId)) {
            sendResponseCodeAndDie(502);
        }
        if (!is_string($file) or empty($file)) { // or !str_ends_with($file, ".tex")
            sendResponseCodeAndDie(502);
        }

        if ($projectId and ($projectId !== 0) and $file) {
            if (userHasAccess($_SESSION['id'], $projectId, $conn)) {
                // Définir le chemin du fichier en fonction de l'identifiant du projet
                $filePath = "projects/$projectId/$file";

                if (file_exists($filePath)) {
                    $content = file_get_contents($filePath);
                    if (!$_SESSION['isAdmin']) {
                        $sql = "UPDATE PROJECT SET last_opened=current_timestamp() WHERE id_project = ?";
                        $stmt = mysqli_stmt_init($conn);
                        $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                        if ($prepareStmt) {
                            mysqli_stmt_bind_param($stmt, "i", $projectId);
                            mysqli_stmt_execute($stmt);
                        } else {
                            sendResponseCodeAndDie(502, "Something went wrong");
                        }
                    }
                    echo $content;
                } else {
                    sendResponseCodeAndDie(404);
                    // echo 'File not found.';
                }
            } else {
                sendResponseCodeAndDie(403);
                // echo 'Forbidden.';
            }
        } else {
            sendResponseCodeAndDie(403);
            // echo 'Forbidden.';
        }
    } else {
        http_response_code(400);
        // echo 'Bad request.';
    }
}
