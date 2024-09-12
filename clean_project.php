<?php

require_once("php-scripts/functions/database_access.php");
require_once("php-scripts/functions/files.php");
require_once("php-scripts/functions/die.php");

session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: login.php");
    exit();
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_project'])) {
        require_once("config/database.php");

        $projectId = mysqli_real_escape_string($conn, $_POST['id_project']) ??  null;

        if (userHasAccess($_SESSION['id'], $projectId, $conn)) {
            $files_to_delete = glob("projects/$projectId/*.{log,aux,dvi,lof,lot,loa,lol,bit,idx,glo,bbl,bcf,ilg,toc,ind,out,blg,fdb_latexmk,fls,run.xml,synctex.gz,xdv,pyg}", GLOB_BRACE);
            if (is_dir("projects/$projectId/_minted-main")) {
                array_push($files_to_delete, "projects/$projectId/_minted-main");
            }
            foreach ($files_to_delete as $file) {
                error_log($file);
                if (is_file($file) && !is_dir($file)) {
                    if (!unlink($file)) sendResponseCodeAndDie(502, "Error suppressing the file");
                } elseif (!is_file($file) && is_dir($file)) {
                    if (!rrmdir($file)) sendResponseCodeAndDie(502, "Error suppressing the directory");
                } else {
                    sendResponseCodeAndDie(502, "Something went wrong");
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
