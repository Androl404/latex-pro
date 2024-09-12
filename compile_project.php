<?php

require_once("php-scripts/functions/database_access.php");
require_once("php-scripts/functions/die.php");

session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: login.php");
    exit();
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_project']) && isset($_POST['file']) && isset($_POST['shell_escape']) && isset($_POST['compiler'])) {
        $projectId = $_POST['id_project'];
        $file = $_POST['file'];
        $shell_escape = $_POST['shell_escape'];
        $compiler = $_POST['compiler'];
        require_once("config/database.php");
        if (userHasAccess($_SESSION['id'], $projectId, $conn)) {
            if (file_exists("projects/$projectId/$file")) {
                $response_code = 0;
                $output = array();
                if (!chdir("projects/$projectId")) {
                    sendResponseCodeAndDie(400, "Bad gateway");
                    exit();
                }
                switch ($compiler) {
                    case 'pdflatex':
                        $arguments = '-pdf -pdflatex';
                        break;

                    case 'latex':
                        $arguments = '-dvi -latex';
                        break;

                    case 'lualatex':
                        $arguments = '-pdflua -lualatex';
                        break;

                    case 'xelatex':
                        $arguments = '-pdfxe -xelatex';
                        break;

                    default:
                        sendResponseCodeAndDie(400, "Bad gateway");
                        exit();
                        break;
                }
                $exec = 'latexmk';
                $arguments .= ' -bibtex -interaction=nonstopmode -g -norc'; // -synctex=1 // Not needed for now
                if ($shell_escape == 1) {
                    $arguments .= " --shell-escape";
                }
                $final_command = $exec . ' ' . $arguments . ' ' . $file;
                /* error_log($final_command); */
                exec($final_command, $output, $response_code); // -output-directory=projects/{$projectId} 
                if ($response_code !== 0) {
                    sendResponseCodeAndDie(502);
                }
            } else {
                sendResponseCodeAndDie(502, "No main file");
            }
        } else {
            sendResponseCodeAndDie(403, "Forbidden");
        }
    } else {
        sendResponseCodeAndDie(400, "Bad request");
    }
}
