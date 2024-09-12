const fileList = document.querySelector(".file-list");
const fileBrowseButton = document.querySelector(".file-browse-button");
const fileBrowseInput = document.querySelector(".file-browse-input");
const fileUploadBox = document.querySelector(".file-upload-box");
const fileCompletedStatus = document.querySelector(".file-completed-status");

let totalFiles = 0;
let totalSize = 0;
let completedFiles = 0;

// Function to create HTML for each file item
const createFileItemHTML = (file, uniqueIdentifier) => {
    // Extracting file name, size, and extension
    const { name, size } = file;
    const extension = name.split(".").pop();
    const formattedFileSize = size >= 1024 * 1024 ? `${(size / (1024 * 1024)).toFixed(2)} MB` : `${(size / 1024).toFixed(2)} KB`;


    // Generating HTML for file item
    return `<li class="file-item" id="file-item-${uniqueIdentifier}">
                <div class="file-extension">${extension}</div>
                <div class="file-content-wrapper">
                <div class="file-content">
                    <div class="file-details">
                    <h5 class="file-name">${name}</h5>
                    <div class="file-info">
                        <small class="file-size">0 MB / ${formattedFileSize}</small>
                        <small class="file-divider">•</small>
                        <small class="file-status">Uploading...</small>
                    </div>
                    </div>
                    <button class="cancel-button">
                    <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="file-progress-bar">
                    <div class="file-progress"></div>
                </div>
                </div>
            </li>`;
}

// Function to handle file uploading
const handleFileUploading = (file, uniqueIdentifier) => {
    const xhr = new XMLHttpRequest();
    const formData = new FormData();
    formData.append("uploadedFile[]", file);
    formData.append("id_project", projectId);

    // Adding progress event listener to the ajax request
    xhr.upload.addEventListener("progress", (e) => {
        // Updating progress bar and file size element
        const fileProgress = document.querySelector(`#file-item-${uniqueIdentifier} .file-progress`);
        const fileSize = document.querySelector(`#file-item-${uniqueIdentifier} .file-size`);

        // Formatting the uploading or total file size into KB or MB accordingly
        const formattedFileSize = file.size >= 1024 * 1024 ? `${(e.loaded / (1024 * 1024)).toFixed(2)} MB / ${(e.total / (1024 * 1024)).toFixed(2)} MB` : `${(e.loaded / 1024).toFixed(2)} KB / ${(e.total / 1024).toFixed(2)} KB`;

        const progress = Math.round((e.loaded / e.total) * 100);
        fileProgress.style.width = `${progress}%`;
        fileSize.innerText = formattedFileSize;
    });

    // Opening connection to the server API endpoint "api.php" and sending the form data
    xhr.open("POST", "upload_file_s.php", true);
    xhr.send(formData);

    return xhr;
}

// Function to handle selected files
const handleSelectedFiles = ([...files]) => {
    if (files.length === 0) return; // Check if no files are selected
    if (files.length > 40) { // Set the maximal number of file here
        Swal.fire({
            title: "Uploading error",
            html: "You are trying to upload more than 40 files at a time, please try again with fewer files (" + files.length + " files).",
            icon: "error",
        });
        return;
    }  // Check if more than 40 files are selected
    totalFiles += files.length;

    files.forEach((file, index) => {
        // console.log(file.size);
        totalSize += file.size;
        if (totalSize > 50 * 1024 * 1024) { // Set the maximum size here
            let sSize;
            switch (true) {
                case totalSize > 1024 * 1024 * 1024:
                    sSize = parseInt(totalSize / 1024 / 1024 / 1024) + " GB";
                    break;
                case totalSize > 1024 * 1024:
                    sSize = parseInt(totalSize / 1024 / 1024) + " MB";
                    break;
                case totalSize > 1024:
                    sSize = parseInt(totalSize / 1024) + " KB";
                    break;
                default:
                    sSize = parseInt(totalSize) + " octets";
            }
            Swal.fire({
                title: "Uploading error",
                html: "The total size of your file(s) is more than the limit set to 50 MB, your total size is: " + sSize + ".",
                icon: "error",
            });
            // alert("The total size of your file(s) is more than the limit set to 50 MB, your total size is: " + sSize);
            return;
        }
        const uniqueIdentifier = Date.now() + index;
        const fileItemHTML = createFileItemHTML(file, uniqueIdentifier);
        // Inserting each file item into file list
        fileList.insertAdjacentHTML("afterbegin", fileItemHTML);
        const currentFileItem = document.querySelector(`#file-item-${uniqueIdentifier}`);
        const cancelFileUploadButton = currentFileItem.querySelector(".cancel-button");

        const xhr = handleFileUploading(file, uniqueIdentifier);

        // Update file status text and change color of it 
        const updateFileStatus = (status, color) => {
            currentFileItem.querySelector(".file-status").innerText = status;
            currentFileItem.querySelector(".file-status").style.color = color;
        }

        xhr.addEventListener("readystatechange", () => {
            // Handling completion of file upload
            // console.log("on passe par là");
            if ((xhr.readyState === XMLHttpRequest.DONE) && (xhr.status === 200)) {
                completedFiles++;
                cancelFileUploadButton.remove();
                updateFileStatus("Completed", "#00B125");
                fileCompletedStatus.innerText = `${completedFiles} / ${totalFiles} files completed`;
                updateTree();
            } else {
                updateFileStatus("Error", "#E3413F");
                Swal.fire({
                    title: "Did it work?",
                    html: "An error MIGHT have occurred during the file upload but we're not sure. Be careful!",
                    icon: "warning",
                });
            }
        });

        // Handling cancellation of file upload
        cancelFileUploadButton.addEventListener("click", () => {
            xhr.abort(); // Cancel file upload
            updateFileStatus("Cancelled", "#E3413F");
            cancelFileUploadButton.remove();
        });

        // Show Alert if there is any error occured during file uploading
        xhr.addEventListener("error", () => {
            updateFileStatus("Error", "#E3413F");
            Swal.fire({
                title: "Uploading error",
                html: "An error occurred during the file upload!",
                icon: "error",
            });
        });
    });


    fileCompletedStatus.innerText = `${completedFiles} / ${totalFiles} files completed`;
}

// Function to handle file drop event
fileUploadBox.addEventListener("drop", (e) => {
    e.preventDefault();
    handleSelectedFiles(e.dataTransfer.files);
    fileUploadBox.classList.remove("active");
    fileUploadBox.querySelector(".file-instruction").innerText = "Drag files here or";
});

// Function to handle file dragover event
fileUploadBox.addEventListener("dragover", (e) => {
    e.preventDefault();
    fileUploadBox.classList.add("active");
    fileUploadBox.querySelector(".file-instruction").innerText = "Release to upload or";
});

// Function to handle file dragleave event
fileUploadBox.addEventListener("dragleave", (e) => {
    e.preventDefault();
    fileUploadBox.classList.remove("active");
    fileUploadBox.querySelector(".file-instruction").innerText = "Drag files here or";
});

fileBrowseInput.addEventListener("change", (e) => handleSelectedFiles(e.target.files));
fileBrowseButton.addEventListener("click", () => fileBrowseInput.click());
