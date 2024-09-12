<?php

require_once("php-scripts/functions/database_access.php");
require_once("php-scripts/functions/log_parser.php");
require_once("php-scripts/functions/die.php");

session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: login.php");
    exit();
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_project']) && isset($_POST['file'])) {
        $projectId = $_POST['id_project'];
        $file = $_POST['file'];
        require_once("config/database.php");
        if (userHasAccess($_SESSION['id'], $projectId, $conn)) {
            if (!chdir("projects/$projectId")) {
                sendResponseCodeAndDie(400, "Bad gateway");
                exit();
            }
            $file = end(explode("/", $file));
            if (str_ends_with($file, '.tex')) {
                $file = substr($file, -2) . 'log';
            }
            if (!file_exists($file)) {
                $file = glob("*.log")[0];
            }
            $raw_log = file_get_contents($file);
            $log_file = $file;
            exec("texlogsieve $file --no-summary --no-page-delay --no-shipouts --file-banner --box-detail", $output, $return_code);
            $type = false;
            foreach ($output as $line) {
                if (isDummyLine($line)) {
                    if ($type !== false) echo '</div></div>';
                    $type = false;
                    continue;
                } elseif (isFileLine($line)) {
                    if ($type !== false) echo '</div></div>';
                    $type = false;
                    $file = substr($line, 10);
                    if (str_ends_with($file, ":")) {
                        $file = substr($file, 0, -1);
                    }
                    // echo 'File: ' . substr($line, 10);
                    continue;
                } elseif (str_contains($line, "for immediate help")) {
                    continue;
                }
                $important = isImportantLine($line);
                if ($important != '') {
                    if (in_array($important, array('error', 'warning', 'info'))) {
                        if ($type !== false) echo '</div></div>';
                        $type = $important;
                        echo "<div class='message $important'><div class='title'>$line</div><div class='file'>$file</div><div class='content'>";
                    } else {
                        $type = false;
                    }
                } else {
                    if ($type !== false) {
                        echo $line . "<br>";
                    }
                }
            }
            echo "</div></div><div class='message raw-log'><div class='title'>Raw compilation log (" . $log_file . ")</div><div class='content'><button id='show-raw-log' class='raw-log-button'>Toggle the display of the raw log</button><div id='raw-log' style='display: none;'>" . nl2br($raw_log) . "</div></div></div>";
        } else {
            sendResponseCodeAndDie(403, "Forbidden");
        }
    } else {
        sendResponseCodeAndDie(400, "Bad request");
    }
}
