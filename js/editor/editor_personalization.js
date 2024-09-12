wordWrap.addEventListener("change", wordwrapUpdate);
minimap.addEventListener("change", minimapUpdate);
fontsizeElement.addEventListener("change", fontsizeUpdate);
themeElement.addEventListener("change", themeUpdate);
relativeNumber.addEventListener("change", rnuUpdate);

function fontsizeUpdate() {
    editorCodeBlock.updateOptions({ fontSize: parseInt(fontsizeElement.value, 10) });
    return;
}

function themeUpdate() {
    let selectedTheme = themeElement.value;
    if (selectedTheme.startsWith('vs') || selectedTheme.startsWith('hc')) {
        monaco.editor.setTheme(selectedTheme);
    } else {
        fetch("js/monaco-themes/" + selectedTheme + ".json")
            .then(response => response.json())
            .then(data => {
                monaco.editor.defineTheme(selectedTheme, data);
                monaco.editor.setTheme(selectedTheme);
            });
    }
    return;
}

function wordwrapUpdate() {
    if (wordWrap.checked) {
        editorCodeBlock.updateOptions({ wordWrap: "on" });
    } else {
        editorCodeBlock.updateOptions({ wordWrap: "off" });
    }
    return;
}

function minimapUpdate() {
    editorCodeBlock.updateOptions({ minimap: { enabled: minimap.checked } });
    return;
}

function rnuUpdate() {
    if (relativeNumber.checked) {
        editorCodeBlock.updateOptions({ lineNumbers: 'relative' });
    } else {
        editorCodeBlock.updateOptions({ lineNumbers: 'on' });
    }
    return;
}

var saveSettingsEvent;
function saveProjectSettings() {
    window.clearTimeout(saveSettingsEvent);
    saveSettingsEvent = setTimeout(saveSettings, 3000)
    return;
}

document.getElementById("compiler-select").addEventListener("change", saveProjectSettings);
document.getElementById('shell-escape-compile').addEventListener("click", saveProjectSettings);
document.getElementById("file-select").addEventListener("change", saveProjectSettings);
wordWrap.addEventListener("change", saveProjectSettings);
minimap.addEventListener("change", saveProjectSettings);
fontsizeElement.addEventListener("change", saveProjectSettings);
themeElement.addEventListener("change", saveProjectSettings);
relativeNumber.addEventListener("change", saveProjectSettings);
document.getElementById("success-info-toast").addEventListener("click", saveProjectSettings);
document.getElementById("error-warning-toast").addEventListener("click", saveProjectSettings);

