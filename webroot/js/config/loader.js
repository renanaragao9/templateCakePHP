$(document).ready(function () {
    let loaderTimeout;

    $("#loader").show();
    loaderTimeout = setTimeout(function () {
        $("#loader").hide();
    }, 5000);

    $(window).on("load", function () {
        clearTimeout(loaderTimeout);
        $("#loader").hide();
    });

    $(document)
        .ajaxStart(function () {
            $("#loader").show();
            loaderTimeout = setTimeout(function () {
                $("#loader").hide();
            }, 5000);
        })
        .ajaxStop(function () {
            clearTimeout(loaderTimeout);
            $("#loader").hide();
        });

    $("form").on("submit", function (event) {
        $("#loader").show();
        loaderTimeout = setTimeout(function () {
            $("#loader").hide();
        }, 5000);
    });

    $("#searchInput").on("input", function () {
        const query = $(this).val();
        if (query.length >= 5 || query.length === 0) {
            searchTableBody(query);
        }
    });
});
