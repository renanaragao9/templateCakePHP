function updateInputType(selectElement) {
    var selectedOption = $(selectElement).find("option:selected");
    var type = selectedOption.data("type");
    var valueInput = $(selectElement)
        .closest(".form-group.row")
        .find('input[name="values[]"]');
    var value2Input = $(selectElement)
        .closest(".form-group.row")
        .find('input[name="values2[]"]');

    if (type === "date") {
        valueInput.attr("type", "date");
        value2Input.attr("type", "date");
    } else {
        valueInput.attr("type", "text");
        value2Input.attr("type", "text");
    }
}

function toggleBetweenInput(selectElement) {
    var value2Container = $(selectElement)
        .closest(".form-group.row")
        .find("#value2-container");
    if ($(selectElement).val() === "BETWEEN") {
        value2Container.show();
    } else {
        value2Container.hide();
    }
}

function removeCondition(button) {
    $(button).closest(".form-group.row").remove();
}

$("#add-condition").on("click", function () {
    var container = $("#conditions-container");
    var newCondition = $(`
            <div class="form-group row">
    <div class="col-md-3">
        <label for="field">Campo</label>
        <select class="form-control" name="fields[]" id="field" onchange="updateInputType(this)">
            <?php foreach ($fields as $field => $data): ?>
                <option value="<?=$field?>" data-type="<?=$data['type']?>"><?=$data['label']?></option>
            <?php endforeach;?>
        </select>
    </div>
    <div class="col-md-3">
        <label for="condition">Condição</label>
        <select class="form-control" name="conditions[]" id="condition" onchange="toggleBetweenInput(this)">
            <?php foreach ($conditions as $condition => $label): ?>
                <option value="<?=$condition?>"><?=$label?></option>
            <?php endforeach;?>
        </select>
    </div>
    <div class="col-md-3">
        <label for="value">Valor</label>
        <input type="text" class="form-control" name="values[]" id="value" placeholder="Valor">
    </div>
    <div class="col-md-3" style="display: none;" id="value2-container">
        <label for="value2">Valor 2</label>
        <input type="text" class="form-control" name="values2[]" id="value2" placeholder="Valor 2">
    </div>
     <div class="col-md-1 d-flex align-items-end">
            <button type="button" class="btn btn-danger btn-sm w-100 mt-4 mt-md-0" onclick="removeCondition(this)">
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>
</div>
        `);
    container.append(newCondition);
});
