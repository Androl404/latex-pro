<?php

session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your archived projects - LaTeX-pro</title>
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/header_footer.css">
    <link rel="stylesheet" href="css/latex.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" href="img/favicon/icon_128.png" />
    <link rel="stylesheet" href="modules/boxicons-2.1.4/css/boxicons.min.css">
    <script src="modules/sweetalert-2.11/sweetalert.min.js"></script>
</head>

<body>

    <?php require("header.php"); ?>

    <div id="content">
        <div class="nav">
            <div class="nav-categories"><a href="index.php">Your projects</a></div>
            <div class="nav-categories active"><a href="archived.php">Your archived projects</a></div>
            <div class="nav-categories"><a href="recycle-bin.php">Recycle bin</a></div>
        </div>
        <div class="index">
            <h2>Your existing archived projects</h2>
            <?php
            require_once("config/database.php");
            $sql = "SELECT id_project, project_name, creation_date, last_opened, last_saved FROM PROJECT WHERE id_user_owner = " . $_SESSION['id'] . " AND trashed = 0 AND archived = 1";
            $result = mysqli_query($conn, $sql);
            ?>

            <table class="existing-projects">
                <tr>
                    <th>Project name</th>
                    <th>Creation date</th>
                    <th>Last opened date</th>
                    <th>Last saved date</th>
                    <th>Actions on the project</th>
                </tr>
                <?php
                while ($rows = $result->fetch_assoc()) {
                ?>
                    <tr>
                        <td><a href="edit.php?id_project=<?php echo $rows['id_project']; ?>&file=main.tex"><?php echo $rows['project_name']; ?></a></td>
                        <td><?php echo $rows['creation_date']; ?></td>
                        <td><?php echo $rows['last_opened']; ?></td>
                        <td><?php echo $rows['last_saved']; ?></td>
                        <td><a href="php-scripts/delete_project.php?id_project=<?php echo $rows['id_project']; ?>&target=recycle"><i class='bx bx-recycle' alt="Move to the recycle bin" title="Move to the recycle bin"></i></a> <a href="php-scripts/delete_project.php?id_project=<?php echo $rows['id_project']; ?>&target=index"><i class='bx bx-archive-out' alt="Dearchive the project" title="Dearchive the project"></i></a></td>
                        <!-- <td><form action="php-scripts/delete_project.php" action="POST"><input type="submit" value="Delete the project" name="<?php // echo $rows['id_project']; 
                                                                                                                                                    ?>"></input></form></td> -->
                    </tr>
                <?php
                }
                ?>
            </table>

        </div>
    </div>

    <?php require("footer.php"); ?>

</body>

</html>
