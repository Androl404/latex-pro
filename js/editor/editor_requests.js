const requests_content = {
    load: {
        file: 'load.php',
        success: ' The file was successfully loaded.',
        error: 'An error occurred while loading the file.',
        after: function(response_message, status) {
            editorCodeBlock.setValue(response_message);
            if (status === "success") {
                editorCodeBlock.onDidChangeModelContent(function() {
                    updateFileStatus('Not saved', 'orange');
                    window.clearTimeout(saveEvent);
                    saveEvent = setTimeout(saveFile, 3000);
                });
                updateFileStatus('Saved', 'green');
                window.clearTimeout(saveEvent);
            } else {
                updateFileStatus("Error on load!", 'red');
            }
            loadSettings();
            return;
        },
    },
    load_settings: {
        file: 'project_settings.php',
        success: ' The settings of your project were successfully loaded.',
        error: 'An error occurred while loading the settings of your project.',
        after: function(response_message) {
            setSettings($.parseJSON(response_message));
            return;
        },
    },
    save: {
        file: 'save.php',
        success: 'The file was successfully saved.',
        error: 'An error occurred while saving the file.',
        after: function(response_message, status) {
            if (status === "success") {
                updateFileStatus("Saved", 'green');
            } else {
                updateFileStatus("Error on save!", 'red');
            }
            return;
        },
    },
    save_settings: {
        file: 'project_settings.php',
        success: 'The project\'s settings were successfully saved.',
        error: 'An error occurred while saving the project\'s settings.',
        after: function() {
            return;
        },
    },
    tree: {
        file: 'get_tree.php',
        success: 'The tree was successfully updated.',
        error: 'An error occurred while updating the tree.',
        after: function(response) {
            document.getElementById("TreeProject").innerHTML = response;

            document.querySelectorAll('.tree-directory').forEach(folder =>
                folder.addEventListener('click', () => {
                    folder.classList.toggle('opened');
                    folder.querySelector("i.bxs-folder").classList.toggle('bxs-folder-open');
                })
            );
            selectFile();
            return;
        },
    },
    compile: {
        file: 'compile_project.php',
        success: 'The project was successfully compiled!',
        error: 'An error occurred while compiling the project.',
        after: function() {
            get_log_messages();
            let pdf_file = document.getElementById("file-select").value.split('/').at(-1).replace(/[^/.]+$/, "") + 'pdf';
            document.getElementById('pdf-reader').src = `${web_domain}projects/${projectId}/` + pdf_file;
            toogleCompileIcon();
            return;
        }
    },
    log_message: {
        file: 'get_log_messages.php',
        success: 'The log was successfully updated!',
        error: 'An error occurred while updating the log.',
        after: function(response) {
            document.getElementById("log-messages").innerHTML = response;
            updateTree();
            orderLogMessages();
            return;
        }
    },
    create_file: {
        file: 'create_file_dir.php',
        success: 'The file was successfully created.',
        error: 'An error occurred while creating the file.',
        after: function() {
            updateTree();
            return;
        }
    },
    create_folder: {
        file: 'create_file_dir.php',
        success: 'The directory was successfully created.',
        error: 'An error occurred while creating the directory.',
        after: function() {
            updateTree();
            return;
        }
    },
    delete: {
        file: 'delete_file_dir.php',
        success: 'The file(s)/directory(ies) was/were successfully deleted.',
        error: 'An error occurred while deleting the file(s)/directory(ies).',
        after: function() {
            updateTree();
            return;
        }
    },
    move: {
        file: 'move_file_dir.php',
        success: 'The file(s)/directory(ies) was/were successfully moved.',
        error: 'An error occurred while moving the file(s)/directory(ies).',
        after: function() {
            updateTree();
            return;
        }
    },
    clean: {
        file: 'clean_project.php',
        success: 'The project was successfully cleaned!',
        error: 'An error occurred while cleaning the project.',
        after: function() {
            updateTree();
            return;
        }
    },
    archive: {
        file: 'archive_project.php',
        success: 'The project was successfully archived!',
        error: 'An error occurred while archiving the project.',
        after: function(response) {
            let link = document.createElement('a');
            link.href = web_domain + response;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            return;
        }
    },
};

function handleRequest(type, arguments) {
    var file = "";
    var success_message = '';
    var error_message = '';
    var afterRequest;
    if (Object.keys(requests_content).includes(type)) {
        file = requests_content[type]["file"];
        success_message = requests_content[type]['success'];
        error_message = requests_content[type]['error'];
        afterRequest = requests_content[type]['after'];
    } else {
        createToast("error", "<span class='bold'>Error!</span> Bad request.", 10000);
        return;
    }
    var response_message;
    // while ($.active !== 0) {}
    $.ajax({
        type: 'POST',
        url: file,
        async: true,
        data: arguments,
        success: function(response) {
            response_message = response;
            createToast("success", "<span class='bold'>Success!</span> " + success_message, 5000);
        },
        error: function() {
            createToast("error", "<span class='bold'>Error!</span> " + error_message, 10000);
            checkConnection();
        },
        complete: function(ajaxObject, returnedStatus) {
            afterRequest(response_message, returnedStatus);
        },
    });
}

