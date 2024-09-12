const notifications = document.querySelector(".notifications");
// const buttons = document.querySelectorAll(".buttons .btn");

// var time = 5000; // Also set in the css animation

// Object containing details for different types of toasts
const toastDetails = {
    // timer: 5000,

    success: {
        icon: 'bxs-check-circle',
        // text: '<span class="bold">Success!</span> This is a success toast.',
    },
    error: {
        icon: 'bxs-x-circle',
        // text: '<span class="bold">Error!</span> This is an error toast.',
    },
    warning: {
        icon: 'bxs-alarm-exclamation',
        // text: '<span class="bold">Warning!</span> This is a warning toast.',
    },

    info: {
        icon: 'bxs-info-circle',
        // text: '<span class="bold">Info!</span> This is an information toast.',
    }
}

const removeToast = (toast) => {
    toast.classList.add("hide");

    if (toast.timeoutId) clearTimeout(toast.timeoutId); // Clearing the timeout for the toast
    setTimeout(() => toast.remove(), 500); // Removing the toast after 500ms
}

const createToast = (id, textArg, time) => {
    var success_info = document.getElementById("success-info-toast").checked;
    var error_warning = document.getElementById("error-warning-toast").checked;
    if (((id === "success") || (id === "info")) && !success_info) {
        return;
    }
    if (((id === "warning") || (id === "error")) && !error_warning) {
        return;
    }

    // Getting the icon and text for the toast based on the id passed
    const { icon } = toastDetails[id];
    const toast = document.createElement("li"); // Creating a new 'li' element for the toast
    toast.className = `toast ${id}`; // Setting the classes for the toast
    // Setting the inner HTML for the toast
    toast.innerHTML = `<div class="column">
                         <i class="bx bx-lg ${icon}"></i>
                         <span>${textArg}</span>
                      </div>
                      <i class="bx bx-x bx-sm" onclick="removeToast(this.parentElement)"></i>`;
    notifications.appendChild(toast); // Append the toast to the notification ul
    // Setting a timeout to remove the toast after the specified duration
    toast.timeoutId = setTimeout(() => removeToast(toast), time);
}

