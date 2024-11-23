<?php

session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id_project']) || !isset($_GET['file'])) {
    header("Location: index.php");
    exit();
}

require_once("config/config.php")
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit LaTeX document - LaTeX-pro</title>
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/editor/editor.css">
    <link rel="stylesheet" href="css/editor/file_uploader.css">
    <link rel="stylesheet" href="css/editor/toast_notification.css">
    <link rel="stylesheet" href="css/editor/verify_connection.css">
    <link rel="icon" href="img/favicon/icon_128.png" />
    <link rel="stylesheet" href="modules/boxicons-2.1.4/css/boxicons.min.css">
    <script type="text/javascript" src="modules/jquery-3.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="modules/sweetalert-2.11/sweetalert.min.js"></script>

    <link rel="stylesheet" data-name="vs/editor/editor.main" href="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.49.0/min/vs/editor/editor.main.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script type="text/javascript">
        var web_domain = "<?php echo $web_url; ?>";
    </script>
    <script type="text/javascript">
        var require = {
            paths: {
                'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.49.0/min/vs',
            }
        };
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.49.0/min/vs/loader.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.49.0/min/vs/editor/editor.main.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.49.0/min/vs/editor/editor.main.nls.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>

    <ul class="notifications"></ul>

    <header>
        <div class="menu">Menu</div>
        <div class="home">
            <div><i class='bx bxs-home' style='color:#ffffff; font-size: 20pt;'></i></div>
        </div>
        <div class="project-name">
            <?php
            require_once("config/database.php");
            $projectId = mysqli_real_escape_string($conn, $_GET['id_project']);
            $sql = "SELECT project_name FROM PROJECT WHERE id_project = $projectId";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            echo $user['project_name'];
            ?>
        </div>
        <div class="regular-text">
            File info: <span class="bold"><?php echo $_GET['file']; ?></span>, <span id="file-status" class="bold" style="color: green;">Saved</span>
        </div>
    </header>

    <div id="menu">
        <h1>
            Download
        </h1>
        <div class="compart-wrapper">
            <div id="pdf-download" class="compart">
                <i class='bx bxs-file-pdf bx-lg' style='color:#ffffff'></i><span>Download PDF file</span>
            </div>
            <div id="archive-download" class="compart">
                <i class='bx bxs-file-archive bx-lg' style='color:#ffffff'></i><span>Download project's archive</span>
            </div>
            <div>
                <a href="view_archive.php?id_project=<?php echo $_GET['id_project']; ?>" target="_blank" class="compart"><i class='bx bxs-archive bx-lg' style='color:#ffffff'></i><span>View all the archives</span></a>
            </div>
        </div>
        <h1>
            Compilation options
        </h1>
        <div class="menu-compart">
            <label>Choose your compiler:</label>
            <select name="compiler" id="compiler-select">
                <option value="pdflatex">pdfLaTeX</option>
                <option value="latex">LaTeX (<span class="code">dvi</span> file)</option>
                <!-- <option value="lualatex">LuaLaTeX</option> -->
                <option value="xelatex">XeLaTeX</option>
            </select>
        </div>
        <div class="menu-compart">
            <input type="checkbox" name="shell-escape-compile" id="shell-escape-compile">
            <label>Compile with the <span class="code">--shell-escape</span> argument</label>
        </div>
        <div class="menu-compart">
            <label for="file-select">Choose your main file to compile:</label>
            <select name="file" id="file-select">

            </select>
        </div>
        <h1>
            Editor options
        </h1>
        <div class="menu-compart">
            <label for="file-select">Choose your editor font size:</label>
            <input type="number" name="editor-font-size" id="editor-font-size" value="13" min="5" max="99">
        </div>
        <div class="menu-compart">
            <label for="editor-them">Choose your editor theme:</label>
            <select name="file" id="editor-theme">
                <option value="vs-dark">Default (Dark)</option>
                <option value="vs">Light</option>
                <option value="hc-light">High contrast light</option>
                <option value="hc-black">High contrast dark</option>
                <option value="active4d">Active4D</option>
                <option value="all-hallows-eve">All Hallows Eve</option>
                <option value="amy">Amy</option>
                <option value="birds-of-paradise">Birds of Paradise</option>
                <option value="blackboard">Blackboard</option>
                <option value="brilliance-black">Brilliance Black</option>
                <option value="brilliance-dull">Brilliance Dull</option>
                <option value="chrome-devtools">Chrome DevTools</option>
                <option value="clouds-midnight">Clouds Midnight</option>
                <option value="clouds">Clouds</option>
                <option value="cobalt">Cobalt</option>
                <option value="cobalt2">Cobalt2</option>
                <option value="dawn">Dawn</option>
                <option value="dracula">Dracula</option>
                <option value="dreamweaver">Dreamweaver</option>
                <option value="eiffel">Eiffel</option>
                <option value="espresso-libre">Espresso Libre</option>
                <option value="github-dark">GitHub Dark</option>
                <option value="github-light">GitHub Light</option>
                <option value="github">GitHub</option>
                <option value="idle">IDLE</option>
                <option value="katzenmilch">Katzenmilch</option>
                <option value="kuroir-theme">Kuroir Theme</option>
                <option value="lazy">LAZY</option>
                <option value="magicwb--amiga-">MagicWB (Amiga)</option>
                <option value="merbivore-soft">Merbivore Soft</option>
                <option value="merbivore">Merbivore</option>
                <option value="monokai-bright">Monokai Bright</option>
                <option value="monokai">Monokai</option>
                <option value="night-owl">Night Owl</option>
                <option value="nord">Nord</option>
                <option value="oceanic-next">Oceanic Next</option>
                <option value="pastels-on-dark">Pastels on Dark</option>
                <option value="slush-and-poppies">Slush and Poppies</option>
                <option value="solarized-dark">Solarized-dark</option>
                <option value="solarized-light">Solarized-light</option>
                <option value="spacecadet">SpaceCadet</option>
                <option value="sunburst">Sunburst</option>
                <option value="textmate--mac-classic-">Textmate (Mac Classic)</option>
                <option value="tomorrow-night-blue">Tomorrow-Night-Blue</option>
                <option value="tomorrow-night-bright">Tomorrow-Night-Bright</option>
                <option value="tomorrow-night-eighties">Tomorrow-Night-Eighties</option>
                <option value="tomorrow-night">Tomorrow-Night</option>
                <option value="tomorrow">Tomorrow</option>
                <option value="twilight">Twilight</option>
                <option value="upstream-sunburst">Upstream Sunburst</option>
                <option value="vibrant-ink">Vibrant Ink</option>
                <option value="xcode-default">Xcode_default</option>
                <option value="zenburnesque">Zenburnesque</option>
                <option value="iplastic">iPlastic</option>
                <option value="idlefingers">idleFingers</option>
                <option value="krtheme">krTheme</option>
                <option value="monoindustrial">monoindustria</option>
            </select>
        </div>
        <div class="menu-compart">
            <input type="checkbox" name="word-wrap" id="word-wrap" checked="checked">
            <label>Enable word wrap</label>
        </div>
        <div class="menu-compart">
            <input type="checkbox" name="see-minimap" id="see-minimap">
            <label>Show the minimap</label>
        </div>
        <div class="menu-compart">
            <input type="checkbox" name="vim-mode" id="vim-mode">
            <label>Enable VIM mode</label>
        </div>
        <div class="menu-compart">
            <input type="checkbox" name="relative-number" id="relative-number">
            <label>Enable relative line numbers</label>
        </div>
        <h1>
            Notifications options
        </h1>
        <div class="menu-compart">
            <input type="checkbox" name="success-info-toast" id="success-info-toast">
            <label>Show successes and infos toast notifications</label>
        </div>
        <div class="menu-compart">
            <input type="checkbox" name="error-warning-toast" id="error-warning-toast" checked="checked">
            <label>Show errors and warnings toast notifications</label>
        </div>
        <h1>
            Help
        </h1>
        <div class="menu-compart">
            <div>
                <a href="docs/documentation.php" class="help" target="_blank">
                    <i class='bx bxs-book' style='color:#ffffff;'></i>
                    Documentation
                </a>
            </div>
            <div>
                <a href="docs/shortcuts.php" class="help" target="_blank">
                    <i class='bx bxs-keyboard' style='color:#ffffff'></i>
                    Shortcuts
                </a>
            </div>
            <div>
                <a href="contact.php" class="help" target="_blank">
                    <i class='bx bxs-help-circle' style='color:#ffffff'></i>
                    Contact us
                </a>
            </div>
        </div>
    </div>

    <div class="code-sup">
        <div class="tree-actions">
            <div class="actions">
                <button id="reloadFile"><img src="img/icon/ic_fluent_arrow_clockwise_24.png" alt="Re-load the file from the server" title="Re-load the file from the server (Ctrl+Shift+R)" /></button>
                <button id="saveButton"><img src="img/icon/ic_fluent_save_24.png" alt="Save the current file" title="Save the current file (Ctrl+S)" /></button>
                <button id="updateTree"><img src="img/icon/ic_fluent_text_bullet_list_tree_24.png" alt="Update project's tree" title="Update project's tree (Ctrl+Shift+T)" /></button>
                <button id="createFile"><img src="img/icon/ic_fluent_document_add_24.png" alt="Create a new file" title="Create a new file (Ctrl+Shift+N)" /></button>
                <button id="createFolder"><img src="img/icon/ic_fluent_folder_add_24_filled.png" alt="Create a new directory" title="Create a new directory (Ctrl+Shift+F)" /></button>
                <button id="moveFile"><img src="img/icon/ic_fluent_arrow_move_24_filled.png" alt="Move/rename a file or a directory" title="Move/rename a file or a directory (Ctrl+Shift+M)" /></button>
                <button id="deleteFile"><img src="img/icon/ic_fluent_delete_24_filled.png" alt="Delete a file or a directory" title="Delete a file or a directory (Ctrl+Shift+D)" /></button>
                <button id="toggleUploadZone"><img src="img/icon/ic_fluent_arrow_upload_24.png" alt="Toggle the upload zone" title="Toggle the upload zone (Ctrl+Shift+U)" /></button>
                <button id="cleanProject"><img src="img/icon/ic_fluent_dismiss_24.png" alt="Clean the project's files" title="Clean the project's files (Ctrl+Shift+C)" /></button>
                <!-- <form action="" id="uploadForm" enctype="multipart/form-data" method="POST">
                    <input type="file" name="uploadedFile[]" multiple="multiple"></input>
                    <button type="submit" id="submitFilesToUpload" name="submitFilesToUpload" style="visibility: hidden;">Upload file(s)</button>
                </form> -->
            </div>
            <div id="dTreeProject">
                <ul id="TreeProject">

                </ul>
            </div>
        </div>
        <div class="editor-wrapper">
            <div id="tree-resizer" class="resize-bar"></div>
            <div id="CodeBlock"></div>
            <div id="vimStatus"></div>
        </div>
        <div class="pdf-reader">
            <div class="pdf-bar">
                <div class="pdf-compile">
                    <button id="compile" alt="Compile the main file" title="Compile the main file (Ctrl+E)"><i class='bx bx-refresh bx-flip-horizontal' id="compile-icon"></i> <span>Compile the main file</span></button>
                </div>
                <span id="view-log" title="View errors, warnings, infos and log from compilation"><i class='bx bx-file'></i></span>
                <span id="nb-log" class="bold" style="font-size: 18pt; margin-left: 7px;"></span>
            </div>
            <div id="log-messages">
                <h1 style="margin: 20px;">Please compile to get infos, warnings, errors.</h1>
            </div>
            <iframe src="projects/<?php echo $_GET['id_project']; ?>/main.pdf" id="pdf-reader"></iframe>
        </div>
    </div>

    <div class="file-uploader-compart">
        <div class="file-uploader-wrapper">
            <div class="file-uploader">
                <div class="uploader-header">
                    <h2 class="uploader-title">File Uploader</h2>
                    <h4 class="file-completed-status"></h4>
                </div>
                <ul class="file-list"></ul>
                <div class="file-upload-box">
                    <h2 class="box-title">
                        <span class="file-instruction">Drag files here or</span>
                        <span class="file-browse-button">browse</span>
                    </h2>
                    <input class="file-browse-input" type="file" name="uploadedFile[]" id="uploadedFile" multiple hidden>
                </div>
                <div style="height: 10px;"></div>
            </div>
        </div>
    </div>

    <div class="connection-popup">
        <div class="icon"><i class="" style="color: #fff;"></i></div>
        <div class="details">
            <h2 class="title"></h2>
            <p class="desc"></p>
            <button class="reconnect">Reconnect Now</button>
        </div>
    </div>

    <script type="text/javascript" src="js/toast_notification.js"></script>
    <script type="text/javascript" src="js/verify_connection.js"></script>
    <script type="text/javascript" src="js/monaco/monaco-latex.js"></script>
    <script type="text/javascript" src="js/monaco/monaco-vim.js"></script>
    <script type="text/javascript" src="js/editor/editor_functions.js"></script>
    <script type="text/javascript" src="js/editor/editor_requests.js"></script>
    <script type="text/javascript" src="js/editor/edit.js"></script>
    <script type="text/javascript" src="js/editor/editor_personalization.js"></script>
    <script type="text/javascript" src="js/editor/editor_actions.js"></script>
    <script type="text/javascript" src="js/editor/editor_shortchuts.js"></script>
    <script type="text/javascript" src="js/file_upload.js"></script>
    <script type="text/javascript" src="js/editor/editor_resize.js"></script>

</body>

</html>
