<?php

session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: ../login.php");
    exit;
} else {
    echo "

    <footer>
        <div class='logo'>
            <a href='../index.php'>
                <img src='../img/favicon/icon_512.png' class='logo-icon' />
                <span class='latex-pro'><span class='latex'>L<sup>a</sup>T<sub>e</sub>X</span>-pro</span>
            </a>
        </div>
        <div class='mentions'>
            <div class='infos'>
                <div>
                    <h1>Legal Informations</h1>
                    <a href='../docs/eula.php'>End User Licence Agreement (EULA)</a><br>
                    <a href='../docs/tos.php'>Terms of Services (ToS)</a><br>
                    <a href='../docs/pcp.php'>Privacy and Cookie Policy (PCP)</a>
                </div>
                <div>
                    <h1>Documentation</h1>
                    <a href='../docs/documentation.php'>User Documentation</a><br>
                    <a href='../docs/shortcuts.php'>Shortcuts</a>
                </div>
                <div>
                    <h1>Contact</h1>
                    <a href='../contact.php'>Contact</a>
                </div>
            </div>
            <div class='copyright'>
                Copyright 2024 - All rights reserved <br>
                Andrei Zeucianu <br>
                <a href='mailto:andrei.zeucianu@etu.univ-st-etienne.fr'>andrei.zeucianu@etu.univ-st-etienne.fr</a>
            </div>
        </div>
    </footer>

    ";
}
