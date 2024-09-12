<?php

session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: login.php");
    exit();
}
$projectId = $_GET['id_project'];

require_once("php-scripts/functions/database_access.php");
require_once("config/database.php");

if (!userHasAccess($_SESSION['id'], $projectId, $conn)) {
    header("Location: index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archived back-ups of projects - LaTeX-pro</title>
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/header_footer.css">
    <link rel="stylesheet" href="css/latex.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/content.css">
    <link rel="icon" href="img/favicon/icon_128.png" />
    <link rel="stylesheet" href="modules/boxicons-2.1.4/css/boxicons.min.css">
    <script src="modules/sweetalert-2.11/sweetalert.min.js"></script>
</head>

<body>

    <?php require("header.php"); ?>

    <div id="content-doc">
        <div>
            <?php
            require_once("config/database.php");
            $projectId = mysqli_real_escape_string($conn, $_GET['id_project']);
            $sql = "SELECT project_name FROM PROJECT WHERE id_project = $projectId";
            $result = mysqli_query($conn, $sql);
            $projectName = mysqli_fetch_array($result, MYSQLI_ASSOC)['project_name'];
            ?>

            <h1>All the backed-up versions of <?php echo $projectName; ?></h1>
            <p>Each time, you created an archive from the menu in the editor, you can immediatly download it, but it also will be stored as a back-up of your project, in case your lose some data or want to come back to an older version of your projects. We advise you to frequently generate a back-up of your project, even if you do not download it immediatly.</p>
            <p>Here are the different back-up(s) of your project : </p>
            <?php
            require_once("php-scripts/functions/files.php");
            $projectId = $_GET['id_project'];

            $files = dirToArray("archives/$projectId");
            ?>

            <table class="existing-projects">
                <tr>
                    <th>Archive name</th>
                    <th>Actions on the archive</th>
                </tr>
                <?php
                foreach ($files as $file) {
                ?>
                    <tr>
                        <td><a class='archives' href='archives/<?php echo $projectId; ?>/<?php echo $file; ?>'><?php echo $file; ?></a></td>
                        <td><a href="php-scripts/restore_archive.php?id_project=<?php echo $projectId; ?>&archive=<?php echo $file; ?>&target=restore"><i class='bx bx-redo bx-md' alt="Restore the archive" title="Restore the archive"></i></a> <a href="php-scripts/restore_archive.php?id_project=<?php echo $projectId; ?>&archive=<?php echo $file; ?>&target=del"><i class='bx bx-trash bx-md' alt="Delete the archive" title="Delete the archive"></i></a></td>
                    </tr>
                <?php
                }
                ?>
            </table>
            <p><a href="edit.php?id_project=<?php echo $_GET['id_project']; ?>&file=main.tex">Edit this project</a></p>
        </div>
    </div>

    <?php require("footer.php"); ?>

</body>

</html>
