<?php

require_once("php-scripts/functions/database_access.php");
require_once("php-scripts/functions/files.php");
require_once("php-scripts/functions/die.php");

session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: login.php");
    exit();
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_project']) && isset($_POST['project_name'])) {
        require_once("config/database.php");

        $projectId = mysqli_real_escape_string($conn, $_POST['id_project']) ??  null;
        $projectName = $_POST['project_name'];

        if (userHasAccess($_SESSION['id'], $projectId, $conn)) {

            // Remove any trailing slashes from the path
            // $rootPath = rtrim($rootPath, '\\/');

            // Get real path for our folder
            $rootPath = realpath("projects/$projectId");

            if (!file_exists("archives/$projectId") && !is_dir("archives/$projectId")) {
                mkdir("archives/$projectId");
            }

            date_default_timezone_set("Europe/Paris");
            $date = date("Y-m-d_H-i-s");
            $archive_name = "archives/" . $projectId . "/" . $projectName . "_" . $date . ".zip";

            // Initialize archive object
            $zip = new ZipArchive();
            if ($zip->open($archive_name, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
                sendResponseCodeAndDie(502, "Cannot create the zip file");
            }

            // Create recursive directory iterator
            /** @var SplFileInfo[] $files */
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($rootPath),
                RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $file) {
                // Skip directories (they would be added automatically)
                if (!$file->isDir()) {
                    // Get real and relative path for current file
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($rootPath) + 1);

                    // Add current file to archive
                    $zip->addFile($filePath, $relativePath);
                }
            }

            // Zip archive will be created only after closing object
            if (!$zip->close()) {
                sendResponseCodeAndDie(502, "Cannot write the archive.");
            }

            echo $archive_name;
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
