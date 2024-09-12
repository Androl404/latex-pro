var projectId = getUrlParameter("id_project", location.search);
var file_to_edit = getUrlParameter("file", location.search);

var codeContent = $.trim($("#CodeBlock").text());
$("#CodeBlock").html("");

var wordWrap = document.getElementById("word-wrap");
var minimap = document.getElementById("see-minimap");
var fontsizeElement = document.getElementById("editor-font-size");
var themeElement = document.getElementById("editor-theme");
var relativeNumber = document.getElementById("relative-number");
var editorCodeBlock;

require(['vs/editor/editor.main', 'js/monaco/monaco-vim.js'], function(a, MonacoVim) {
    editorCodeBlock = monaco.editor.create(
        document.getElementById("CodeBlock"),
        {
            value: codeContent,
            language: "latex",
            theme: themeElement.value,
            lineNumbers: "on",
            fontSize: parseInt(fontsizeElement.value, 10),
            glyphMargin: false,
            wordWrap: "on",
            vertical: "auto",
            horizontal: "auto",
            verticalScrollbarSize: 10,
            horizontalScrollbarSize: 10,
            scrollBeyondLastLine: true,
            readOnly: false,
            automaticLayout: true,
            minimap: {
                enabled: false
            },
            lineheight: 19,
        },
    );

    let vimMode;
    document.getElementById('vim-mode').addEventListener('change', function() {
        if (!document.getElementById('vim-mode').checked) {
            vimMode.dispose();
            vimMode = null;
            document.getElementById('vimStatus').display = "none";
            $("#CodeBlock").height(document.body.scrollHeight - 47);
        } else if (document.getElementById('vim-mode').checked) {
            document.getElementById('vimStatus').display = "block";
            vimMode = MonacoVim.initVimMode(editorCodeBlock, document.getElementById('vimStatus'));
            $("#CodeBlock").height(document.body.scrollHeight - 100);
        } else {
            vimMode.dispose();
            vimMode = null;
            document.getElementById('vimStatus').display = "none";
            $("#CodeBlock").height(document.body.scrollHeight - 47);
        }
    });
});

document.getElementById("toggleUploadZone").addEventListener("click", function() {
    $(".file-uploader-compart").toggle();
});

// To resize the Monaco Editor's and the tree's projects's height
$(document).ready(function() {
    $("#dTreeProject").height($("body").height() - $(".actions").height() - 40);
    $("#CodeBlock").height(document.body.scrollHeight - 47);
});

// create an Observer instance to watch the body height
const resizeObserver = new ResizeObserver((entries) => {
    $("#dTreeProject").height($("body").height() - $(".actions").height() - 40);
    if (document.getElementById("vim-mode").checked) {
        $("#CodeBlock").height(document.body.scrollHeight - 100);
    } else {
        $("#CodeBlock").height(document.body.scrollHeight - 47);
    }
});

resizeObserver.observe(document.body);

document.querySelector("div.menu").addEventListener("click", function() {
    $("#menu").toggle();
});

document.getElementById("view-log").addEventListener("click", function() {
    $("#log-messages").toggle();
});

document.querySelector("header>div.home>div").addEventListener("click", function() {
    var link = document.createElement('a');
    link.href = 'https://zeo.hopto.org/latex-pro/index.php';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    return;
});

document.getElementById("pdf-download").addEventListener("click", function() {
    $.ajax({
        type: 'HEAD',
        url: 'https://zeo.hopto.org/latex-pro/projects/' + projectId + '/main.pdf',
        success: function() {
            var link = document.createElement('a');
            link.href = 'https://zeo.hopto.org/latex-pro/projects/' + projectId + '/main.pdf';
            link.target = '_blank';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        },
        error: function() {
            $.ajax({
                type: 'HEAD',
                url: 'https://zeo.hopto.org/latex-pro/projects/' + projectId + '/' + file_to_edit.split("/").at(-1).replace(/[^/.]+$/, "") + 'pdf',
                success: function() {
                    let link = document.createElement('a');
                    link.href = 'https://zeo.hopto.org/latex-pro/projects/' + projectId + '/' + file_to_edit.split("/").at(-1).replace(/[^/.]+$/, "") + 'pdf';
                    link.target = '_blank';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                },
                error: function() {
                    createToast("error", '<span class="bold">Error!</span> No PDF file found!<span class="code">main.pdf</span> file!', 10000);
                }
            });
        }
    });
});

document.getElementById("archive-download").addEventListener("click", function() {
    let projectName = document.querySelector("div.project-name").innerText;
    handleRequest("archive", { id_project: projectId, project_name: projectName, });
});

var saveEvent;
$(document).ready(function() {
    updateTree();
    isEditorReady();
});

