function createFormStruct(form, data, columns) {
    var i = 0;
    while (i < data.length) {
        let row = $("<div>");
        row.addClass('form-row justify-content-center');
        
        for (var j = 0; j < columns; j++) {
            let column = $("<div>");
            column.addClass('form-col mx-3 my-2 my-md-3');
            let input = $('<input>');
            input.addClass('form-control');
            input.attr("type", data[i]["type"]);
            input.attr("placeholder", data[i]["placeholder"]);
            if (data[i]["required"]) {
                input.attr("required", "");
            }
            column.append(input);
            row.append(column);
            i++;
        }
        console.log(form);
        form.append(row);
    }
}