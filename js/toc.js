var nav = $("nav#toc");

$(document).ready(function() {
    $("#content-doc h1, #content-doc h2, #content-doc h3, #content-doc h4, #content-doc h5, #content-doc h6").each(function(i) {
        var current = $(this);
        if (!current.hasClass("invisible")) {
            var id = 'heading-' + i;
            current.attr('id', id);
            if (current.is("h1")) {
                nav.append('<a class="bold" href="#' + id + '"><i class="bx bx-fw bxs-circle" style="font-size: 8.5pt;"></i>' + current.text() + '</a><br>');
            } else if (current.is("h2")) {
                nav.append('<a style="margin-left: 30px; font-weight: 600;" href="#' + id + '"><i class="bx bx-fw bxs-chevron-right" style="font-size: 10pt;"></i>' + current.text() + '</a><br>');
            } else if (current.is("h3")) {
                nav.append('<a style="margin-left: 60px;" href="#' + id + '"><i class="bx bx-fw bx-minus" style="font-size: 10pt;"></i>' + current.text() + '</a><br>');
            } else if (current.is("h4")) {
                nav.append('<a style="margin-left: 90px;" href="#' + id + '">' + current.text() + '</a><br>');
            } else if (current.is("h5")) {
                nav.append('<a style="margin-left: 120px;" href="#' + id + '">' + current.text() + '</a><br>');
            } else if (current.is("h6")) {
                nav.append('<a style="margin-left: 150px;" href="#' + id + '">' + current.text() + '</a><br>');
            } else {
                nav.append('<a href="#' + id + '">' + current.text() + '</a><br>');
            }
        }
    });
});
