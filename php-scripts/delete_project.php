<?php

require_once('functions/database_access.php');
require_once('functions/files.php');
require_once('functions/die.php');

$errors = array();

session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: ../login.php");
    exit();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id_project']) && isset($_GET['target'])) {
    require_once("../config/database.php");

    $target = $_GET['target'];

    $projectId = mysqli_real_escape_string($conn, $_GET['id_project']) ?? null;
    $projectId = intval($projectId);
    if (!$projectId or !is_int($projectId)) {
        array_push($errors, "went-wrong");
        show_errors_and_die($errors, "../index.php", "project-delete-failed");
        exit();
        // echo "<div>Something went wrong with the project id</div>";
    } else {
        if (userHasAccess($_SESSION['id'], $projectId, $conn)) {
            if ($target === "recycle") {
                $sql = "UPDATE PROJECT SET trashed = 1 WHERE id_project = ?";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                if ($prepareStmt) {
                    mysqli_stmt_bind_param($stmt, "i", $projectId);
                    mysqli_stmt_execute($stmt);
                    header("Location: ../index.php?recycle-project-success=1");
                    exit();
                } else {
                    array_push($errors, "went-wrong");
                    show_errors_and_die($errors, "../index.php", "project-recycle-failed");
                    exit();
                }
            } elseif ($target === "archive") {
                $sql = "UPDATE PROJECT SET archived = 1 WHERE id_project = ?";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                if ($prepareStmt) {
                    mysqli_stmt_bind_param($stmt, "i", $projectId);
                    mysqli_stmt_execute($stmt);
                    header("Location: ../index.php?archive-project-success=1");
                    exit();
                } else {
                    array_push($errors, "went-wrong");
                    show_errors_and_die($errors, "../index.php", "project-archive-failed");
                    exit();
                }
            } elseif ($target === "index") {
                $sql = "UPDATE PROJECT SET trashed = 0, archived = 0 WHERE id_project = ?";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                if ($prepareStmt) {
                    mysqli_stmt_bind_param($stmt, "i", $projectId);
                    mysqli_stmt_execute($stmt);
                    header("Location: ../index.php?restore-project-success=1");
                    exit();
                } else {
                    array_push($errors, "went-wrong");
                    show_errors_and_die($errors, "../index.php", "project-delete-failed");
                    exit();
                }
            } elseif ($target === "del") {
                $sql = "DELETE FROM PROJECT WHERE id_project = ?";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                if ($prepareStmt) {
                    mysqli_stmt_bind_param($stmt, "i", $projectId);
                    mysqli_stmt_execute($stmt);
                    // echo "<div>Project deleted from database.</div>";
                    if (rrmdir("../projects/$projectId") && rrmdir("../archives/$projectId")) {
                        header("Location: ../index.php?delete-project-success=1");
                        exit();
                        // echo "<div>Project files deleted from server.</div>";
                        // echo "<div>Your project was succesfully deleted, please return to the home page!</div>";
                    } else {
                        array_push($errors, "went-wrong");
                        show_errors_and_die($errors, "../index.php", "project-delete-failed");
                        exit();
                    }
                } else {
                    array_push($errors, "went-wrong");
                    show_errors_and_die($errors, "../index.php", "project-delete-failed");
                    exit();
                }
            } else {
                array_push($errors, "went-wrong");
                show_errors_and_die($errors, "../index.php", "project-delete-failed");
                exit();
            }
        } else {
            array_push($errors, "forbidden");
            show_errors_and_die($errors, "../index.php", "project-delete-failed");
            exit();
        }
    }
} else {
    array_push($errors, "went-wrong");
    show_errors_and_die($errors, "../index.php", "project-delete-failed");
    exit();
}
