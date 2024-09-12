<?php

require_once("php-scripts/functions/database_access.php");
require_once("php-scripts/functions/files.php");
require_once("php-scripts/functions/die.php");

session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: login.php");
    sendResponseCodeAndDie(403, "Forbidden, session expired.");
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_project']) && isset($_FILES) && isset($_FILES['uploadedFile'])) {
        require_once("config/database.php");

        $projectId = $_POST['id_project'];
        $userId = $_SESSION['id'];

        if (userHasAccess($userId, $projectId, $conn)) {
            // Vérifiez si un fichier a été uploadé
            if (!isset($_FILES['uploadedFile'])) {
                sendResponseCodeAndDie(400, "No file uploaded or there was an upload error.");
            } else {
                // Vérifier la taille des fichiers et le nombre de fichiers
                $total = count($_FILES['uploadedFile']['name']);
                if ($total > 40) { // Change number of files here
                    sendResponseCodeAndDie(400, "Too much files!");
                }

                $totalsize = 0;
                for ($i = 0; $i < $total; $i++) {
                    $totalsize += $_FILES['uploadedFile']['size'][$i];
                    if (file_get_contents($_FILES['uploadedFile']['tmp_name'][$i]) == "") {
                        sendResponseCodeAndDie(400, "One file empty!");
                    }
                    if (!check_file_uploaded_name($_FILES['uploadedFile']['name'][$i])) {
                        sendResponseCodeAndDie(400, "File name invalid");
                    }
                    if (check_file_uploaded_length($_FILES['uploadedFile']['name'][$i])) {
                        sendResponseCodeAndDie(400, "File name is too long");
                    }
                    if ($_FILES['uploadedFile']['error'][$i] != UPLOAD_ERR_OK) {
                        sendResponseCodeAndDie(400, "No file uploaded or there was an upload error.");
                    }
                }
                if ($totalsize > 50 * 1024 * 1024) { // Change size of files here
                    sendResponseCodeAndDie(400, "Files too fat!");
                }

                for ($i = 0; $i < $total; $i++) {
                    //Get the temp file path
                    $tmpFilePath = $_FILES['uploadedFile']['tmp_name'][$i];
                    // $size = $_FILES['file']['size'][$i];

                    error_log($i . " passing here");

                    //Make sure we have a file path
                    if ($tmpFilePath != "") {
                        //Setup our new file path
                        $newFilePath = "projects/$projectId/" . $_FILES['uploadedFile']['name'][$i];

                        //Upload the file into the temp dir
                        if (!move_uploaded_file($tmpFilePath, $newFilePath)) {
                            sendResponseCodeAndDie(502, "Something went wrong, an error occured while uploading the file");
                        }
                    }
                }
            }
        } else {
            sendResponseCodeAndDie(403, "Forbidden");
        }
    } else {
        sendResponseCodeAndDie(400, "Bad gateway");
    }
}
