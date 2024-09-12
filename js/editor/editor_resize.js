var resizer = document.getElementById("tree-resizer"),
    sidebar = document.querySelector("div.tree-actions");

function initResizerFn(resizer, sidebar) {

    function rs_mousedownHandler(e) {
        document.addEventListener("mousemove", rs_mousemoveHandler);
        document.addEventListener("mouseup", rs_mouseupHandler);
    }

    function rs_mousemoveHandler(e) {
        let x = e.clientX;

        if (x > 96) {
            sidebar.style.width = `${x}px`;
            $("#dTreeProject").height($("body").height() - $(".actions").height() - 40);
            $("#menu").width($("div.tree-actions").width());
        }
    }

    function rs_mouseupHandler() {
        document.removeEventListener("mouseup", rs_mouseupHandler);
        document.removeEventListener("mousemove", rs_mousemoveHandler);
    }

    resizer.addEventListener("mousedown", rs_mousedownHandler);
}

initResizerFn(resizer, sidebar);

// uses too much CPU with 'mousemove' event, because it executes when you move your cursor
document.getElementById("CodeBlock").addEventListener('mouseup', function() {
    $("#dTreeProject").height($("body").height() - $(".actions").height() - 40);
    $("#menu").width($("div.tree-actions").width());
    $("#log-messages").width($("#pdf-reader").width());
});

