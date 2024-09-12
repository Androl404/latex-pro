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
    <title>Your projects - LaTeX-pro</title>
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/header_footer.css">
    <link rel="stylesheet" href="css/latex.css">
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" href="img/favicon/icon_128.png" />
    <link rel="stylesheet" href="modules/boxicons-2.1.4/css/boxicons.min.css">
    <script src="modules/sweetalert-2.11/sweetalert.min.js"></script>
</head>

<body>

    <?php require("header.php"); ?>

    <?php
    $failure_messages = array(
        "project-creation-failed" => "The creation of the project has failed.",
        "project-name-empty" => "The name of the project cannot be empty.",
        "project-name-invalid" => "The name of the project cannot contain spaces and certain caracters (refer to the user documentation).",
        "error-creating-file" => "The .tex file could not be created.",
        "error-writing-file" => "The .tex file could not be written in it.",
        "project-delete-failed" => "The deleting of the project has failed.",
        "project-recycle-failed" => "The recycling of the project has failed.",
        "archive-restore-failed" => "The restoring of the archive has failed.",
        "archive-delete-failed" => "The deleting of the archive has failed.",
        "project-archived-failed" => "The archiving of the project has failed.",
        "message-error" => "Your message could not be sent, please try again.",
        "forbidden" => "Access forbidden.",
        "went-wrong" => "Something went wrong.",
    );
    $success_messages = array(
        "creation-success" => "The project was successfully created.",
        "delete-project-success" => "The project was successfully deleted.",
        "recycle-project-success" => "The project was successfully recycled.",
        "archive-project-success" => "The project was successfully archived.",
        "restore-project-success" => "The project was successfully restored.",
        "archive-restore-success" => "The archive was successfully restored.",
        "archive-delete-success" => "The archive successfully deleted.",
        "message-sent" => "Your message was successfully sent.",
    );

    $err = "";
    foreach ($failure_messages as $short_err => $err_message) {
        if (isset($_GET[$short_err]) and $_GET[$short_err]) {
            $err .= $err_message . "<br>";
            /* echo "<div>$err_message</div>"; */
        }
    }

    $ok = "";
    foreach ($success_messages as $short_mes => $success_message) {
        if (isset($_GET[$short_mes]) and $_GET[$short_mes]) {
            /* echo "<div>$success_message</div>"; */
            $ok .= $success_message . "<br>";
        }
    }

    if (!empty($err)) {
        echo "<script>
            Swal.fire({
                title: 'Error!',
                html: '$err',
                icon: 'error',
                showCloseButton: true,
            });
            </script>";
    }
    if (!empty($ok)) {
        echo "<script>
            Swal.fire({
                title: 'Success!',
                html: '$ok',
                icon: 'success',
                showCloseButton: true,
            });
            </script>";
    }
    ?>

    <div id="content">
        <div class="nav">
            <div class="nav-categories active"><a href="index.php">Your projects</a></div>
            <div class="nav-categories"><a href="archived.php">Your archived projects</a></div>
            <div class="nav-categories"><a href="recycle-bin.php">Recycle bin</a></div>
        </div>
        <div class="index">
            <div class="new-project">
                <h2>Create a new <span class="latex">L<sup>a</sup>T<sub>e</sub>X</span> project:</h2>
                <div>
                    <form action="php-scripts/new_project.php" method="POST">
                        <input type="text" placeholder="Your project name" name="project_name" required="required">
                        <input type="submit" name="create_new_projet" value="Create the project">
                    </form>
                    <!-- <a href="php-scripts/new_project.php">Create a new <span class="latex">L<sup>a</sup>T<sub>e</sub>X</span> project</a> -->
                </div>
            </div>

            <div class="space"></div>
            <h2>Your existing projects</h2>
            <?php
            require_once("config/database.php");
            $sql = "SELECT id_project, project_name, creation_date, last_opened, last_saved FROM PROJECT WHERE id_user_owner = " . $_SESSION['id'] . " AND trashed = 0 AND archived = 0";
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
                        <td><a href="php-scripts/delete_project.php?id_project=<?php echo $rows['id_project']; ?>&target=recycle"><i class='bx bx-recycle' alt="Move to the recycle bin" title="Move to the recycle bin"></i></a> <a href="php-scripts/delete_project.php?id_project=<?php echo $rows['id_project']; ?>&target=archive"><i class='bx bx-box' alt="Archive the project" title="Archive the project"></i></a> <a href="view_archive.php?id_project=<?php echo $rows['id_project']; ?>"><i class='bx bx-time-five' alt="See all the backed-up version" title="See all the backed-up version"></i></a></td>
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
