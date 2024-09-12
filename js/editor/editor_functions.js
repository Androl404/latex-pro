function toogleCompileIcon() {
    document.getElementById("compile-icon").classList.toggle("rotate");
}

function getUrlParameter(name, url) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
    var results = regex.exec(url);
    return results === null
        ? ""
        : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function selectFile() {
    var select = document.querySelector("select#file-select");
    var doc = document.querySelectorAll("ul#TreeProject li>a");
    var active_file;
    if (select.value == "") {
        active_file = "main.tex";
    } else {
        active_file = select.value;
    }
    select.innerHTML = `<option value='${active_file}'>${active_file}</option>`;
    doc.forEach(element => {
        let file = element.getAttribute("href");
        if (file.startsWith("edit.php")) {
            file = file.split("?");
            file = getUrlParameter("file", file);
        }
        if (file.startsWith("/")) {
            file = file.substring(1);
        }
        if (file.endsWith(".tex") && (file !== active_file)) {
            select.innerHTML += "<option value='" + file + "'>" + file + "</option>";
        }
    });
}

function loadFile() {
    handleRequest('load', { id_project: projectId, file: file_to_edit });
}

function loadSettings() {
    handleRequest('load_settings', { id_project: projectId, action: 'load' });
}

function saveFile() {
    window.clearTimeout(saveEvent);
    updateFileStatus("Saving...", "gray");
    let codeContent = editorCodeBlock.getValue();
    handleRequest('save', { content: codeContent, id_project: projectId, file: file_to_edit, });
}

function updateTree() {
    handleRequest('tree', { id_project: projectId, });
}

function compileProject() {
    toogleCompileIcon();
    saveFile();

    var shell_escape = 0;
    if (document.getElementById('shell-escape-compile').checked) {
        shell_escape = 1;
    }
    var file = document.getElementById("file-select").value;
    var compiler = document.getElementById("compiler-select").value;
    // alert(shell_escape);
    handleRequest('compile', { id_project: projectId, file: file, shell_escape: shell_escape, compiler: compiler });
}

function get_log_messages() {
    let file = document.querySelector("select#file-select").value;
    if (file.startsWith("/")) {
        file = file.substring(1);
    }
    handleRequest('log_message', { id_project: projectId, file: file, });
}

function orderLogMessages() {
    var nb_span = document.getElementById("nb-log");
    var log_messages = document.getElementById("log-messages");
    var new_html = "";

    nb_span.innerHTML = "<span style='color: red;'>" + log_messages.getElementsByClassName("error").length + "</span> ";
    nb_span.innerHTML += "<span style='color: orange;'>" + log_messages.getElementsByClassName("warning").length + "</span> ";
    nb_span.innerHTML += "<span style='color: blue;'>" + log_messages.getElementsByClassName("info").length + "</span> ";

    log_messages.querySelectorAll("div.message.error").forEach((element) => {
        new_html += '<div class="message error">' + element.innerHTML + "</div>";
    });
    log_messages.querySelectorAll("div.message.warning").forEach((element) => {
        new_html += '<div class="message warning">' + element.innerHTML + "</div>";
    });
    log_messages.querySelectorAll("div.message.info").forEach((element) => {
        new_html += '<div class="message info">' + element.innerHTML + "</div>";
    });
    new_html += "<div class='message raw-log'>" + document.querySelector("div.message.raw-log").innerHTML + "</div>";

    log_messages.innerHTML = new_html;
    document.getElementById("show-raw-log").addEventListener("click", function() {
        $("#raw-log").toggle();
    });
}

function createFile() {
    let input = null;
    Swal.fire({
        title: "Enter your file name",
        text: "Enter the name of your new file. If you want to place your file in subdirectories, please adopt the following syntax: 'subdir/subdir/new_file.extension'.",
        input: "text",
        inputAttributes: {
            autocapitalize: "off",
            autocomplete: "on",
            required: "on",
        },
        showCancelButton: true,
        confirmButtonText: "Validate",
        showLoaderOnConfirm: true,
        preConfirm: async (login) => {
            input = login;
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            if (input != null) {
                handleRequest('create_file', { id_project: projectId, file: input, type: 'file', });
            }
        }
    });
}

function createFolder() {
    let input = null;
    Swal.fire({
        title: "Enter your directory name",
        text: "Enter the name of your new directory. If you want to place your directory in subdirectories, please adopt the following syntax: 'subdir/subdir/new_directory'. Please end with '/' to indicate it is a folder.",
        input: "text",
        inputAttributes: {
            autocapitalize: "off",
            autocomplete: "on",
            required: "on",
        },
        showCancelButton: true,
        confirmButtonText: "Validate",
        showLoaderOnConfirm: true,
        preConfirm: async (login) => {
            input = login;
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            if (input != null) {
                handleRequest('create_folder', { id_project: projectId, file: input, type: 'folder', });
            }
        }
    });
}

function deleteContent() {
    let input = null;
    Swal.fire({
        title: "Enter your file or directory name",
        text: "Enter the name of the file or directory you want to delete. If you want to delete a file in subdirectories, please adopt the following syntax: 'subdir/subdir/file_to_delete.extension'. If you want to delete a directory, please end with '/'. You can also use glob motions (*, ? and braces for now).",
        input: "text",
        inputAttributes: {
            autocapitalize: "off",
            autocomplete: "on",
            required: "on",
        },
        showCancelButton: true,
        confirmButtonText: "Validate",
        showLoaderOnConfirm: true,
        preConfirm: async (login) => {
            input = login;
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            if (input != null) {
                handleRequest('delete', { id_project: projectId, file: input, });
            }
        }
    });
}

function moveContent() {
    let file_name = null;
    let destination = null;
    Swal.fire({
        title: "Enter your file(s) or directory(ies) name",
        text: "Enter the name of the file or directory you want to move. If you want to move a file in subdirectories, please adopt the following syntax: 'subdir/subdir/file_to_move.extension'. If you want to move a directory, please end with '/'. You can also use glob motions (*, ? and braces for now). If the file or directory already exists, it will be overwritten.",
        input: "text",
        inputAttributes: {
            autocapitalize: "off",
            autocomplete: "on",
            required: "on",
        },
        showCancelButton: true,
        confirmButtonText: "Validate",
        showLoaderOnConfirm: true,
        preConfirm: async (login) => {
            file_name = login;
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "Enter your file(s) or directory(ies) name",
                text: "Enter the path of the destination of your files.",
                input: "text",
                inputAttributes: {
                    autocapitalize: "off",
                    autocomplete: "on",
                    required: "on",
                },
                showCancelButton: true,
                confirmButtonText: "Validate",
                showLoaderOnConfirm: true,
                preConfirm: async (login) => {
                    destination = login;
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    if ((file_name !== null) && (destination !== null)) {
                        handleRequest('move', { id_project: projectId, to_move: file_name, destination: destination, });
                    }
                }
            });
        }
    });
}

function cleanProject() {
    handleRequest("clean", { id_project: projectId, });
}

function isEditorReady() {
    if (typeof editorCodeBlock === "undefined") {
        setTimeout(isEditorReady, 300);
        return;
    } else {
        loadFile();
    }
}

function updateFileStatus(status, color) {
    let span_status = document.getElementById('file-status');
    span_status.innerHTML = status;
    span_status.style.color = color;
}

function setSettings(settings) {
    document.getElementById("compiler-select").value = settings['compiler'];
    document.getElementById('shell-escape-compile').checked = parseInt(settings['shell_escape']);
    document.getElementById("file-select").value = settings['file'];
    fontsizeElement.value = settings['font_size'];
    fontsizeUpdate();
    themeElement.value = settings['theme'];
    themeUpdate();
    wordWrap.checked = parseInt(settings['word_wrap']);
    wordwrapUpdate();
    minimap.checked = parseInt(settings['minimap']);
    minimapUpdate();
    // document.getElementById('vim-mode').checked = parseInt(settings['vim']);
    relativeNumber.checked = parseInt(settings['rnu']);
    rnuUpdate();
    document.getElementById("success-info-toast").checked = parseInt(settings['si_notif']);
    document.getElementById("error-warning-toast").checked = parseInt(settings['ew_notif']);
    return;
}

function saveSettings() {
    let compiler = document.getElementById("compiler-select").value;
    let shell_escape = boolToInt(document.getElementById('shell-escape-compile').checked);
    let file = document.getElementById("file-select").value;
    let font_size = fontsizeElement.value;
    let theme = themeElement.value;
    let word_wrap = boolToInt(wordWrap.checked);
    let miniMap = boolToInt(minimap.checked);
    let vim = boolToInt(document.getElementById('vim-mode').checked);
    let rnu = boolToInt(relativeNumber.checked);
    let si_notif = boolToInt(document.getElementById("success-info-toast").checked);
    let ew_notif = boolToInt(document.getElementById("error-warning-toast").checked);
    handleRequest('save_settings', { id_project: projectId, action: 'save', compiler: compiler, shell_escape: shell_escape, file: file, font_size: font_size, theme: theme, word_wrap: word_wrap, minimap: miniMap, vim: vim, rnu: rnu, si_notif: si_notif, ew_notif: ew_notif });
    return;
}

function boolToInt(bool) {
    if (bool === true) {
        return 1
    } else {
        return 0;
    }
}
