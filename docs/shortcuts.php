<?php

session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Documentation of LaTeX-pro - Shortcuts</title>
    <link rel="stylesheet" href="../css/font.css">
    <link rel="stylesheet" href="../css/header_footer.css">
    <link rel="stylesheet" href="../css/latex.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/content.css">
    <link rel="icon" href="../img/favicon/icon_128.png" />
    <link rel="stylesheet" href="../modules/boxicons-2.1.4/css/boxicons.min.css">
    <script src="../modules/jquery-3.7.1/jquery.min.js"></script>
</head>

<body>

    <?php require("header.php"); ?>

    <div id="content-doc">
        <div>
            <nav id="toc">
                <h1 class="invisible">Table of contents</h1>
            </nav>
            <h1>Shortcuts of the <span class='latex-pro'><span class='latex'>L<sup>a</sup>T<sub>e</sub>X</span>-pro</span> editor</h1>
            <p>This part of the user documentation of this tool is concerning the shortcuts available.</p>
            <p>The <span class='latex-pro'><span class='latex'>L<sup>a</sup>T<sub>e</sub>X</span>-pro</span> editor offers to the user a multitude of key-bindings in order to make the editing user experience more interressant and productive.</p>
            <p>It is important to note that some of these key-bindings won't specially work when the focus is on the PDF reader (depending of the browser you are using) or in the text editor.</p>
            <h2>List of key-bindings</h2>
            <p>Here the list of the key-bindings available in the <span class='latex-pro'><span class='latex'>L<sup>a</sup>T<sub>e</sub>X</span>-pro</span> editor:</p>
            <ul>
                <li><span class="key-short">Ctrl + S</span>: Save the current file opened in the editor;</li>
                <li><span class="key-short">Ctrl + E</span>: Compile the <span class="latex">L<sup>a</sup>T<sub>e</sub>X</span> project you are currently editing;</li>
                <li><span class="key-short">Ctrl + Shift + R</span>: Reload the current file;</li>
                <li><span class="key-short">Ctrl + Shift + T</span>: Update the project's tree;</li>
                <li><span class="key-short">Ctrl + Shift + N</span>: Create a new file;</li>
                <li><span class="key-short">Ctrl + Shift + F</span>: Create a new directory;</li>
                <li><span class="key-short">Ctrl + Shift + M</span>: Move or rename a file or a directory;</li>
                <li><span class="key-short">Ctrl + Shift + D</span>: Delete a file or a directory;</li>
                <li><span class="key-short">Ctrl + Shift + U</span>: Toggle the display of the upload zone;</li>
                <li><span class="key-short">Ctrl + Shift + C</span>: Clean the project.</li>
                <li><span class="key-short">Ctrl + Shift + V</span>: Toggle VIM mode.</li>
                <li><span class="key-short">Ctrl + Shift + S</span>: Toggle the <span class="code">--shel-escape</span> argument.</li>
                <li><span class="key-short">Ctrl + Shift + I</span>: Toggle the display of successes and infos toast notifications.</li>
            </ul>
            <h2>The text editor</h2>
            <p>Our tool uses the Monaco Editor in order to write your <span class="latex">L<sup>a</sup>T<sub>e</sub>X</span> code. Hence, there are many "classic" key-bindings available. More on that in the <a href="https://microsoft.github.io/monaco-editor/docs.html" target="_blank">Monaco Editor documentation</a>.</p>
        </div>
    </div>

    <?php require("footer.php"); ?>
    <script src="../js/toc.js"></script>

</body>

</html>
