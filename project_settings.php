<?php

require_once("php-scripts/functions/database_access.php");
require_once("php-scripts/functions/die.php");

session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: login.php");
    exit();
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_project']) && isset($_POST['action'])) {
        require_once("config/database.php");
        $projectId = mysqli_real_escape_string($conn, $_POST['id_project']);
        $action = $_POST['action'];
        if (userHasAccess($_SESSION['id'], $projectId, $conn)) {
            if ($action === 'save') {
                $actions = array(
                    "compiler" => $_POST['compiler'],
                    "shell_escape" => $_POST['shell_escape'],
                    "file" => $_POST['file'],
                    "font_size" => $_POST['font_size'],
                    "theme" => $_POST['theme'],
                    "word_wrap" => $_POST['word_wrap'],
                    "minimap" => $_POST['minimap'],
                    "vim" => $_POST['vim'],
                    "rnu" => $_POST['rnu'],
                    "si_notif" => $_POST['si_notif'],
                    "ew_notif" => $_POST['ew_notif'],
                );
                foreach ($actions as $key => $value) {
                    /* error_log($key . " => " . $value); */
                    if (!isset($value)) {
                        sendResponseCodeAndDie(400, "Bad request");
                        exit;
                    }
                }
                $test = $_POST['shell_escape'] === true;
                $sql = "UPDATE PROJECT_SETTING SET compiler = ?, shell_escape = ?, file = ?, font_size = ?, theme = ?, word_wrap = ?, minimap = ?, vim = ?, rnu = ?, si_notif = ?, ew_notif = ? WHERE id_project = ?";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                if ($prepareStmt) {
                    mysqli_stmt_bind_param($stmt, "sisisiiiiiii", $_POST['compiler'], $_POST['shell_escape'], $_POST['file'], $_POST['font_size'], $_POST['theme'], $_POST['word_wrap'], $_POST['minimap'], $_POST['vim'], $_POST['rnu'], $_POST['si_notif'], $_POST['ew_notif'], $projectId);
                    mysqli_stmt_execute($stmt);
                    exit();
                } else {
                    sendResponseCodeAndDie(502, "Something went wrong");
                    exit();
                }
            } elseif ($action === 'load') {
                $sql = "SELECT * FROM PROJECT_SETTING WHERE id_project = $projectId";
                $result = mysqli_query($conn, $sql);
                $settings = mysqli_fetch_array($result, MYSQLI_ASSOC);
                unset($settings['id_project']);
                echo json_encode($settings);
            } else {
                sendResponseCodeAndDie(400, "Bad request");
            }
        } else {
            sendResponseCodeAndDie(403, "Forbidden");
        }
    } else {
        sendResponseCodeAndDie(400, "Bad request");
    }
}
