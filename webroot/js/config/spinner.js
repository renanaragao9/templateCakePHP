$(document).ready(function () {
    $("#refreshButton").on("click", function (event) {
        event.preventDefault();
        var $button = $(this);
        var $icon = $("#refreshIcon");
        var $spinner = $("#refreshSpinner");

        $icon.hide();
        $spinner.show();
        $button.html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Atualizando...'
        );

        setTimeout(function () {
            window.location.href = $button.attr("href");
        }, 1000);
    });

    /**
     * @param {JQuery.ClickEvent} event
     */
    $(".modalAdd").on("click", function (event) {
        var $button = $(this);
        $button.html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Salvando...'
        );
    });

    /**
     * @param {JQuery.ClickEvent} event
     */
    $(".modalEdit").on("click", function (event) {
        var $button = $(this);
        $button.html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Editando...'
        );
    });

    /**
     * @param {JQuery.ClickEvent} event
     */
    $(".modalDelete").on("click", function (event) {
        var $button = $(this);
        var configId = /** @type {number} */ ($button.data("id"));
        $button.prop("disabled", true);
        $button.html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Excluindo...'
        );
    });

    /**
     * @param {JQuery.ClickEvent} event
     */
    $(".btn-refresh").on("click", function (event) {
        var $button = $(this);
        $button.prop("disabled", true);
        $button.html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Atualizando...'
        );
    });
});
