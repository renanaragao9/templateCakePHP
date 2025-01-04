$("#select-all").on("change", function () {
    $(".permission-checkbox").prop("checked", this.checked);
});

$(".select-group").on("change", function () {
    var group = $(this).data("group");
    $('.permission-checkbox[data-group="' + group + '"]').prop(
        "checked",
        this.checked
    );
});
