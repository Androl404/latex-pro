<?php

session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: login.php");
    exit();
}
if (!$_SESSION['isAdmin']) {
    header("Location: index.php");
    exit();
}
?>

<?php
require_once("config/database.php");
require_once("php-scripts/functions/database_access.php");
require_once("php-scripts/functions/die.php");

if (isset($_POST["admin-enable"]) && !empty($_POST['admin-enable-id'])) {
    $user_id = mysqli_real_escape_string($conn, $_POST["admin-enable-id"]);
    $sql = "UPDATE USER SET isAdmin = 1 WHERE id = ?";
    sqlRequestUserId($sql, $user_id, $conn);
} else if (isset($_POST["admin-disable"]) && !empty($_POST['admin-disable-id'])) {
    $user_id = mysqli_real_escape_string($conn, $_POST["admin-disable-id"]);
    $sql = "UPDATE USER SET isAdmin = 0 WHERE id = ?";
    sqlRequestUserId($sql, $user_id, $conn);
} else if (isset($_POST["account-enable"]) && !empty($_POST['account-enable-id'])) {
    $user_id = mysqli_real_escape_string($conn, $_POST["account-enable-id"]);
    $sql = "UPDATE USER SET isActivated = 1 WHERE id = ?";
    sqlRequestUserId($sql, $user_id, $conn);
} else if (isset($_POST["account-disable"]) && !empty($_POST['account-disable-id'])) {
    $user_id = mysqli_real_escape_string($conn, $_POST["account-disable-id"]);
    $sql = "UPDATE USER SET isActivated = 0 WHERE id = ?";
    sqlRequestUserId($sql, $user_id, $conn);
} else if (isset($_POST["toggle-registration"])) {
    toggleRegistration($conn);
} else if (($_SERVER['REQUEST_METHOD'] === 'POST') && isset($_POST['submit'])) {
    require_once "config/database.php";
    $fullName = mysqli_real_escape_string($conn, $_POST["fullname"]);
    $userName = mysqli_real_escape_string($conn, $_POST["username"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $passwordRepeat = mysqli_real_escape_string($conn, $_POST["repeat_password"]);

    $isAdmin = 0; // Faux par défaut
    $isActivated = 1; // Vrai par défaut

    $errors = array();

    if (empty($fullName) or empty($email) or empty($password) or empty($passwordRepeat) or empty($userName)) {
        array_push($errors, "all-fields-required");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "email-not-valid");
    }
    if (strlen($password) < 8) {
        array_push($errors, "password-not-8-characters-long");
    }
    if ($password !== $passwordRepeat) {
        array_push($errors, "passwords-does-not-match");
    }
    if (str_contains($userName, ' ')) {
        array_push($errors, "username-contains-spaces");
    }

    if (count($errors) > 0) {
        show_errors_and_die($errors, "admin_control_panel.php", "registration-failed");
        exit();
    }

    $sql = "SELECT * FROM USER WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $rowCount = mysqli_num_rows($result);

    if ($rowCount > 0) {
        array_push($errors, "email-exists");
        show_errors_and_die($errors, "admin_control_panel.php", "registration-failed");
        exit();
    }
    if (count($errors) == 0) {
        $passwordHash = password_hash($password . "GG#HZ2pqY00Zo>g7kn>iqM~1I?*£u3pUH(g6x`vD", PASSWORD_DEFAULT);
        $sql = "INSERT INTO USER (user_name, full_name, email, password, isAdmin, isActivated) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
        if ($prepareStmt) {
            mysqli_stmt_bind_param($stmt, "ssssii", $userName, $fullName, $email, $passwordHash, $isAdmin, $isActivated);
            mysqli_stmt_execute($stmt);
            header("Location: admin_control_panel.php?registration-success=1");
            exit();
        } else {
            // die("Something went wrong");
            array_push($errors, "went-wrong");
            show_errors_and_die($errors, "admin_control_panel.php", "registration-failed");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin control panel - LaTeX-pro</title>
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/header_footer.css">
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/control_panel.css">
    <link rel="stylesheet" href="css/latex.css">
    <link rel="icon" href="img/favicon/icon_128.png" />
    <link rel="stylesheet" href="modules/boxicons-2.1.4/css/boxicons.min.css">
</head>

<body>

    <?php require("header.php"); ?>

    <div id="content">
        <div>
            <h1>Welcome to the Admin Control Panel <?php echo $_SESSION["full_name"]; ?></h1>
            <p>
                We trust you have received the usual lecture from the local System Administrator. It usually boils down to these three things:
            </p>
            <ol>
                <li>Respect the privacy of others;</li>
                <li>Think before you type or click;</li>
                <li>With great power comes great responsibility.</li>
            </ol>
            <h2>Users</h2>
            <h3>List of users</h3>

            <?php
            require_once("config/database.php");
            $sql = "SELECT * FROM USER";
            $result = mysqli_query($conn, $sql);
            # $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            ?>

            <table class="existing-projects">
                <tr>
                    <th>id</th>
                    <th>user_name</th>
                    <th>full_name</th>
                    <th>email</th>
                    <th>password</th>
                    <th>isAdmin</th>
                    <th>isActivated</th>
                    <th>last_activity</th>
                    <th>date_creation_account</th>
                </tr>
                <?php
                while ($rows = $result->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?php echo $rows['id']; ?></td>
                        <td><?php echo $rows['user_name']; ?></td>
                        <td><?php echo $rows['full_name']; ?></td>
                        <td><?php echo $rows['email']; ?></td>
                        <td><?php echo $rows['password']; ?></td>
                        <td><?php echo $rows['isAdmin']; ?></td>
                        <td><?php echo $rows['isActivated']; ?></td>
                        <td><?php echo $rows['last_activity']; ?></td>
                        <td><?php echo $rows['date_creation_account']; ?></td>
                    </tr>
                <?php
                }
                ?>
            </table>
            <button onclick="location.reload();">Update/Refresh</button>
            <h3>Create a new user</h3>
            <p>This form will create a new user whether or not the state of registration.</p>
            <div>
                <form action="admin_control_panel.php" method="post">
                    <div class="input-box">
                        <label for="">Full name</label>
                        <input type="text" name="fullname" placeholder="Full Name" required="required" autocomplete="on">
                    </div>
                    <div class="input-box">
                        <label for="">User name (with no spaces)</label>
                        <input type="text" name="username" placeholder="User Name" required="required" autocomplete="on">
                    </div>
                    <div class="input-box">
                        <label for="">Valid email adress</label>
                        <input type="emamil" name="email" placeholder="Email" required="required" autocomplete="on">
                    </div>
                    <div class="input-box">
                        <label for="">Password</label>
                        <input type="password" name="password" placeholder="Password" required="required">
                    </div>
                    <div class="input-box">
                        <label for="">Re-enter password</label>
                        <input type="password" name="repeat_password" placeholder="Repeat password" required="required">
                    </div>
                    <div>
                        <input type="submit" value="Register the user" name="submit">
                    </div>
                </form>
            </div>
            <div>
                <h3>Manage users</h3>
                <div>
                    Enable administrative rights for a user:
                    <form action="admin_control_panel.php" method="post">
                        <input type="text" placeholder="user_id" name="admin-enable-id" required="required"></input>
                        <input type="submit" name="admin-enable" value="Send"></input>
                    </form>
                </div>
                <div>
                    Remove administrative rights for a user:
                    <form action="admin_control_panel.php" method="post">
                        <input type="text" placeholder="user_id" name="admin-disable-id" required="required"></input>
                        <input type="submit" name="admin-disable" value="Send"></input>
                    </form>
                </div>
                <div>
                    Enable a user account:
                    <form action="admin_control_panel.php" method="post">
                        <input type="text" placeholder="user_id" name="account-enable-id" required="required"></input>
                        <input type="submit" name="account-enable" value="Send"></input>
                    </form>
                </div>
                <div>
                    Disable a user account:
                    <form action="admin_control_panel.php" method="post">
                        <input type="text" placeholder="user_id" name="account-disable-id" required="required"></input>
                        <input type="submit" name="account-disable" value="Send"></input>
                    </form>
                </div>
                <h3>Turn on/off registration</h3>
                <p>Registration is currently <?php require_once("php-scripts/functions/database_access.php");
                                                require_once("config/database.php");
                                                if (canRegister($conn)) {
                                                    echo "on";
                                                } else {
                                                    echo "off";
                                                } ?>.</p>
                <form action="admin_control_panel.php" method="post">
                    <input type="submit" name="toggle-registration" value="Toggle registration off/on"></input>
                </form>
                <p>Refresh the page after using the one of the buttons just above to see the true state of registration.</p>
                <h2>All Projects</h2>

                <?php
                require_once("config/database.php");
                $sql = "SELECT * FROM PROJECT";
                $result = mysqli_query($conn, $sql);
                ?>
                <table class="existing-projects">
                    <tr>
                        <th>id_project</th>
                        <th>id_user_owner</th>
                        <th>project_name</th>
                        <th>creation_date</th>
                        <th>last_opened</th>
                        <th>last_saved</th>
                        <th>project actions</th>
                    </tr>
                    <?php
                    while ($rows = $result->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?php echo $rows['id_project']; ?></td>
                            <td><?php echo $rows['id_user_owner']; ?></td>
                            <td><a href="edit.php?id_project=<?php echo $rows['id_project']; ?>&file=main.tex"><?php echo $rows['project_name']; ?></a></td>
                            <td><?php echo $rows['creation_date']; ?></td>
                            <td><?php echo $rows['last_opened']; ?></td>
                            <td><?php echo $rows['last_saved']; ?></td>
                            <td><a href="php-scripts/delete_project.php?id_project=<?php echo $rows['id_project']; ?>&target=del"><i class='bx bx-trash' title="delete permanently" alt="delete permanently"></i></a> <a href="php-scripts/delete_project.php?id_project=<?php echo $rows['id_project']; ?>&target=recycle"><i class='bx bx-recycle' alt="move to recycle bin" title="move to recycle bin"></i></a> <a href="php-scripts/delete_project.php?id_project=<?php echo $rows['id_project']; ?>&target=archive"><i class="bx bx-box" alt="Archive the project" title="Archive the project"></i></a> <a href="view_archive.php?id_project=<?php echo $rows['id_project']; ?>"><i class='bx bx-time-five' alt="See all the backed-up version" title="See all the backed-up version"></i></a> <a href="php-scripts/delete_project.php?id_project=<?php echo $rows['id_project']; ?>&target=index"><i class='bx bx-archive-out' alt="Dearchive the project" title="Dearchive the project"></i></a> <a href="php-scripts/delete_project.php?id_project=<?php echo $rows['id_project']; ?>&target=index"><i class="bx bx-redo" alt="Restore the project" title="Restore the project"></i></a> </td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>

    <?php require("footer.php"); ?>

</body>

</html>
