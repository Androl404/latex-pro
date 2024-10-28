document.querySelectorAll(".rename-project").forEach(element => {
    element.addEventListener("click", () => {
        let project_name;
        Swal.fire({
            title: "Enter the new name of your project",
            text: "The older project name cannot be recovered after the modification has been made.",
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
                project_name = login;
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                if (project_name != null) {
                    // console.log(element.getAttribute("idproject"));
                    // console.log(project_name);
                    // handleRequest('rename', { id_project: element.getAttribute("idproject"), new_name: project_name, });
                    $.ajax({
                        type: 'POST',
                        url: "rename_project.php",
                        async: true,
                        data: {
                            id_project: element.getAttribute("idproject"),
                            new_name: project_name,
                        },
                        success: function() {
                            window.location.reload();
                            // createToast("success", "<span class='bold'>Success!</span> " + "Project succesfully renamed.", 5000);
                        },
                        error: function() {
                            createToast("error", "<span class='bold'>Error!</span> " + "An error occured while renaming the project.", 10000);
                        },
                    });
                }
            }
        });
    });
});

