<?php

require_once('functions/database_access.php');
require_once('functions/files.php');
require_once('functions/die.php');

$errors = array();

session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: ../login.php");
    exit();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id_project']) && isset($_GET['archive'])) {
    require_once("../config/database.php");

    $projectId = mysqli_real_escape_string($conn, $_GET['id_project']) ?? null;
    $archive = $_GET['archive'];
    $target = $_GET['target'];

    $projectId = intval($projectId);
    if (!$projectId or !is_int($projectId)) {
        array_push($errors, "went-wrong");
        show_errors_and_die($errors, "../index.php", "archive-restore-failed");
        exit();
    } else {
        if (userHasAccess($_SESSION['id'], $projectId, $conn)) {
            if ($target === 'del') {
                if (file_exists("../archives/$projectId/$archive")) {
                    if (!unlink("../archives/$projectId/$archive")) {
                        array_push($errors, "went-wrong");
                        show_errors_and_die($errors, "../index.php", "archive-delete-failed");
                        exit();
                    } else {
                        header("Location: ../index.php?archive-delete-success=1");
                        exit();
                    }
                } else {
                    array_push($errors, "went-wrong");
                    show_errors_and_die($errors, "../index.php", "archive-delete-failed");
                    exit();
                }
            } elseif ($target === 'restore') {
                $zip = new ZipArchive;
                if ($zip->open("../archives/$projectId/$archive") === TRUE) {
                    $zip->extractTo("../projects/$projectId/");
                    $zip->close();
                        header("Location: ../index.php?archive-restore-success=1");
                        exit();
                } else {
                    array_push($errors, "went-wrong");
                    show_errors_and_die($errors, "../index.php", "archive-delete-failed");
                    exit();
                }
            } else {
                array_push($errors, "went-wrong");
                show_errors_and_die($errors, "../index.php", "archive-delete-failed");
                exit();
            }
        } else {
            array_push($errors, "forbidden");
            show_errors_and_die($errors, "../index.php", "archive-restore-failed");
            exit();
        }
    }
} else {
    array_push($errors, "went-wrong");
    show_errors_and_die($errors, "../index.php", "archive-restore-failed");
    exit();
}
