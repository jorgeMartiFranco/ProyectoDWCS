function createFormStruct(form, data, columns) {
    var i = 0;
    while (i < data.length) {
        let row = $("<div>");
        row.addClass('form-row justify-content-center');
        
        for (var j = 0; j < columns; j++) {
            let column = $("<div>");
            column.addClass('col-12 col-sm col-md-5 col-lg-4 mx-md-3 my-2 my-md-3');
            let input = $('<input>');
            input.addClass('form-control');
            input.attr("type", data[i]["type"]);
            input.attr("placeholder", data[i]["placeholder"]);
            input.attr("name", data[i]["name"]);
            input.attr("id", data[i]["id"]);
            if (data[i]["required"]) {
                input.attr("required", "");
            }
            column.append(input);
            row.append(column);
            i++;
        }
        
        form.append(row);
    }
}