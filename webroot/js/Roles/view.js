$("#PermissionsSearchInput").on("keyup", function () {
    var input, filter, table, tr, td, i, j, txtValue, found;
    input = $("#PermissionsSearchInput");
    filter = input.val().toUpperCase();
    table = $("#PermissionsTable");
    tr = table.find("tr");
    found = false;

    tr.each(function (index) {
        if (index === 0) return;
        $(this).hide();
        td = $(this).find("td");
        for (j = 0; j < td.length; j++) {
            txtValue = td.eq(j).text();
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                $(this).show();
                found = true;
                break;
            }
        }
    });

    $("#PermissionsNoResultsMessage").toggle(!found);
});

$("#UsersSearchInput").on("keyup", function () {
    var input, filter, table, tr, td, i, j, txtValue, found;
    input = $("#UsersSearchInput");
    filter = input.val().toUpperCase();
    table = $("#UsersTable");
    tr = table.find("tr");
    found = false;

    tr.each(function (index) {
        if (index === 0) return;
        $(this).hide();
        td = $(this).find("td");
        for (j = 0; j < td.length; j++) {
            txtValue = td.eq(j).text();
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                $(this).show();
                found = true;
                break;
            }
        }
    });
    $("#UsersNoResultsMessage").toggle(!found);
});
