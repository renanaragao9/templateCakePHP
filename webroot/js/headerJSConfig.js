// scripts.js
$(document).ready(function () {
    // Mostrar loader no carregamento da página
    $("#loader").show();
    $(window).on("load", function () {
        $("#loader").hide();
    });

    // Mostrar loader em requisições AJAX
    $(document)
        .ajaxStart(function () {
            $("#loader").show();
        })
        .ajaxStop(function () {
            $("#loader").hide();
        });

    // Mostrar loader ao enviar formulários
    $("form").on("submit", function () {
        $("#loader").show();
    });

    $("#searchInput").on("input", function () {
        const query = $(this).val();
        if (query.length >= 5 || query.length === 0) {
            searchTableBody(query);
        }
    });

    $("#addNewItemModal form").on("submit", function () {
        var $button = $("#saveButton");
        $button.prop("disabled", true);
        $button.html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Salvando...'
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

    $('form[id^="editForm-"]').on("submit", function () {
        var $button = $(this).find('button[type="submit"]');
        $button.prop("disabled", true);
        $button.html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Editando...'
        );
    });
});
