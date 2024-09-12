document.getElementById("reloadFile").addEventListener("click", function() {
    loadFile();
});

document.getElementById("saveButton").addEventListener("click", function() {
    saveFile();
    updateTree();
});

document.getElementById("updateTree").addEventListener("click", updateTree);

document.getElementById("createFile").addEventListener("click", createFile);

document.getElementById("createFolder").addEventListener("click", createFolder);

document.getElementById("deleteFile").addEventListener("click", deleteContent);

document.getElementById("moveFile").addEventListener("click", moveContent);

document.getElementById("compile").addEventListener("click", compileProject);

document.getElementById("cleanProject").addEventListener("click", cleanProject);

