$("#addNewItemModal form").on("submit", function (event) {
    var $button = $("#saveButton");
    $button.prop("disabled", true);
    $button.html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Salvando...'
    );
});

$('form[id^="editForm-"]').on("submit", function (event) {
    var $button = $(this).find('button[type="submit"]');
    $button.prop("disabled", true);
    $button.html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Editando...'
    );
});

$("a.btn-danger").on("click", function (event) {
    var $button = $(this);
    var configId = $button.data("id");
    $button.prop("disabled", true);
    $button.html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Excluindo...'
    );
});
