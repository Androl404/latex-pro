<?php

function userHasAccess(int $userId, int $projectId, mysqli $conn)
{
    if ($_SESSION['isAdmin']) {
        return True;
    }
    $sql = "SELECT id_user_owner FROM PROJECT WHERE id_project = $projectId";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if ($user['id_user_owner'] == $userId) {
        return true;
    } else {
        return false;
    }
}

function canRegister(mysqli $conn)
{
    $sql = "SELECT registration FROM CONFIG";
    $result = mysqli_query($conn, $sql);
    $table = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if ($table['registration']) {
        return True;
    } else {
        return False;
    }
}

function toggleRegistration(mysqli $conn)
{
    if (canRegister($conn)) {
        $sql = "UPDATE CONFIG SET registration = 0";
    } else {
        $sql = "UPDATE CONFIG SET registration = 1";
    }
    $stmt = mysqli_stmt_init($conn);
    $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
    if ($prepareStmt) {
        mysqli_stmt_execute($stmt);
        echo "<div>Operation successful.</div>";
    } else {
        die("Something went wrong");
        exit();
    }
}

function sqlRequestUserId($sql, $user_id, $conn)
{
    $stmt = mysqli_stmt_init($conn);
    $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
    if ($prepareStmt) {
        mysqli_stmt_bind_param($stmt, "s", $user_id);
        mysqli_stmt_execute($stmt);
        echo "<div>Operation successful.</div>";
    } else {
        die("Something went wrong");
        exit();
    }
}
