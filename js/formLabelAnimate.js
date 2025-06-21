$(document).ready(function() {
    $(".form-control").click(function() {
        $(this).parent().addClass("label-animate");
    });

    $(".form-control").focus(function() {
        $(this).parent().addClass("label-animate");
    });

    $(window).click(function() {
        if (!$(event.target).is('.form-control')) {
            $(".form-control").each(function() {
                if ($(this).val() == '') {
                    $(this).parent().removeClass("label-animate");
                }
            });
        }
    });
});