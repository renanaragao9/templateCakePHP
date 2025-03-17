window.searchTableBody = function (query) {
    $.ajax({
        url: searchUrl,
        method: "GET",
        data: {
            search: query,
        },
        success: function (response) {
            var tableBody = $(response).find("#TableBody").html();
            if (tableBody.trim() === "") {
                $("#TableBody").html(
                    '<tr><td colspan="9">Não foi possível encontrar resultados para "' +
                        query +
                        '"</td></tr>'
                );
            } else {
                $("#TableBody").html(tableBody);
            }
        },
        error: function () {
            console.log("Erro ao realizar a pesquisa.");
        },
    });
};

(function () {
    Object.freeze(window.searchTableBody);
})();
