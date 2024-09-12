<?php

session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: login.php");
    exit;
} else {
    echo "

    <header>
        <div class='logo'>
            <a href='index.php'>
                <img src='img/favicon/icon_512.png' class='logo-icon' />
                <span class='latex-pro'><span class='latex'>L<sup>a</sup>T<sub>e</sub>X</span>-pro</span>
            </a>
        </div>
        <div class='account'>
            <ul> ";
    if ($_SESSION['isAdmin']) {
        echo "<li class='button'>
                    <a href='admin_control_panel.php'>Admin control panel</a>
                </li>";
    }
    echo "
                <li class='button'>
                    <a href='index.php'>My <span class='latex'>L<sup>a</sup>T<sub>e</sub>X</span> projects</a>
                </li>
                <li class='button'>";
    echo $_SESSION['full_name'];
    echo "
                    <ul class='sub-menu'>
<li>";
    echo $_SESSION['email'];
    echo "
    </li>
                        <li><a href='dashboard.php'>Dashboard</a></li>
                        <li><a href='php-scripts/logout.php'>Log-out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </header>

";
}

/*

Here is the good old header :


    <header>
        <div class="logo">
            <a href="index.php">
                <img src="img/favicon/icon_512.png" width="60px" />
                <span class="latex-pro"><span class="latex">L<sup>a</sup>T<sub>e</sub>X</span>-pro</span>
            </a>
        </div>
        <div class="account">
            <ul>
                <?php
                if ($_SESSION['isAdmin']) {
                    echo "<li class='button'>
                    <a href='admin_control_panel.php'>Admin control panel</a>
                </li>";
                }
                ?>
                <li class="button">
                    <a href="index.php">My <span class="latex">L<sup>a</sup>T<sub>e</sub>X</span> projects</a>
                </li>
                <li class="button">
                    <?php echo $_SESSION['full_name']; ?>
                    <ul class="sub-menu">
                        <li><?php echo $_SESSION['email']; ?></li>
                        <li><a href="dashboard.php">Dashboard</a></li>
                        <li><a href="php-scripts/logout.php">Log-out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </header> 

*/
