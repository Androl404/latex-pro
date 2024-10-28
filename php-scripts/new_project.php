<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once("functions/die.php");
require_once("functions/files.php");

session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: login.php");
    exit();
} else {
    require_once("../config/database.php");

    $project_name = mysqli_real_escape_string($conn, $_POST['project_name']);
    $errors = array();

    if (empty($project_name)) {
        array_push($errors, "project-name-empty");
        show_errors_and_die($errors, "../index.php", "project-creation-failed");
        exit();
    }
    if (check_file_uploaded_length($project_name, 100)) {
        array_push($errors, "project-name-invalid");
        show_errors_and_die($errors, "../index.php", "project-creation-failed");
        exit();
    }
    if (!check_file_uploaded_name($project_name)) {
        array_push($errors, "project-name-invalid");
        show_errors_and_die($errors, "../index.php", "project-creation-failed");
        exit();
    }

    if (count($errors) == 0) {
        $sql = "INSERT INTO PROJECT (id_user_owner, project_name) VALUES (?, ?)";
        $stmt = mysqli_stmt_init($conn);
        $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
        if ($prepareStmt) {
            mysqli_stmt_bind_param($stmt, "is", $_SESSION['id'], $project_name);
            mysqli_stmt_execute($stmt);
        } else {
            array_push($errors, "went-wrong");
            show_errors_and_die($errors, "../index.php", "project-creation-failed");
            exit();
        }
        $sql = "SELECT id_project FROM PROJECT ORDER BY id_project DESC";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $id_project = $user['id_project'];

        $sql = "INSERT INTO PROJECT_SETTING (id_project) VALUES (?)";
        $stmt = mysqli_stmt_init($conn);
        $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
        if ($prepareStmt) {
            mysqli_stmt_bind_param($stmt, "i", $id_project);
            mysqli_stmt_execute($stmt);
        } else {
            array_push($errors, "went-wrong");
            show_errors_and_die($errors, "../index.php", "project-creation-failed");
            exit();
        }

        mkdir("../projects/$id_project", 0755);
        $filename = "../projects/$id_project/main.tex";
        $default_data = "\documentclass[]{report}\n\n\begin{document}\n\nYour new \LaTeX{} project!\n\n\\end{document}";
        // $default_data = iconv("CP1257","UTF-8", $default_data);
        $file = fopen($filename, "a");
        if (!$file) {
            array_push($errors, "error-creating-file");
            show_errors_and_die($errors, "../index.php", "project-creation-failed");
            exit();
        }
        if (!fwrite($file, $default_data)) {
            array_push($errors, "error-writing-file");
            show_errors_and_die($errors, "../index.php", "project-creation-failed");
            exit();
        }
        fclose($file);
        header("Location: ../index.php?creation-success=1");
        exit();
    } else {
        array_push($errors, "went-wrong");
        show_errors_and_die($errors, "../index.php", "project-creation-failed");
        exit();
    }
}
