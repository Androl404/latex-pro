$(document).bind("keydown", function(e) {
    if (e.ctrlKey && !e.shiftKey && e.which == 83) { // Ctrl+S
        saveFile();
        updateTree();
        return false;
    }

    if (e.ctrlKey && e.which == 69) { // Ctrl+E
        saveFile();
        compileProject();
        updateTree();
        document.getElementById('pdf-reader').src = document.getElementById('pdf-reader').src;
        return false;
    }

    if (e.ctrlKey && e.shiftKey && e.which == 67) { // Ctrl+Maj+C
        document.getElementById("cleanProject").click();
        return false;
    }

    if (e.ctrlKey && e.shiftKey && e.which == 68) { // Ctrl+Maj+D
        document.getElementById("deleteFile").click();
        return false;
    }

    if (e.ctrlKey && e.shiftKey && e.which == 83) { // Ctrl+Maj+S
        document.getElementById("shell-escape-compile").click();
        return false;
    }

    if (e.ctrlKey && e.shiftKey && e.which == 70) { // Ctrl+Maj+F
        document.getElementById("createFolder").click();
        return false;
    }

    if (e.ctrlKey && e.shiftKey && e.which == 77) { // Ctrl+Maj+M
        document.getElementById("moveFile").click();
        return false;
    }

    if (e.ctrlKey && e.shiftKey && e.which == 78) { // Ctrl+Maj+N
        document.getElementById("createFile").click();
        return false;
    }

    if (e.ctrlKey && e.shiftKey && e.which == 85) { // Ctrl+Maj+U
        document.getElementById("toggleUploadZone").click();
        return false;
    }

    if (e.ctrlKey && e.shiftKey && e.which == 86) { // Ctrl+Maj+V
        document.getElementById("vim-mode").click();
        return false;
    }

    if (e.ctrlKey && e.shiftKey && e.which == 82) { // Ctrl + Shift + R
        loadFile();
        return false;
    }

    if (e.ctrlKey && e.shiftKey && e.which == 84) { // Ctrl + Shift + T
        updateTree();
        return false;
    }

    if (e.ctrlKey && e.shiftKey && e.which == 73) { // Ctrl + Shift + I
        document.getElementById("success-info-toast").click();
        return false;
    }
});

