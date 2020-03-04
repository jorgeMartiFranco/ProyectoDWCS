

function createFormStructRegister(columns) {
    var form = $('#partner');

    var arrayColumns = [{type: "text", placeholder: "First name", required: true},
        {type: "text", placeholder: "Last name", required: true},
        {type: "text", placeholder: "Username", required: true},
        {type: "email", placeholder: "Email", required: true},
        {type: "password", placeholder: "Password", required: true},
        {type: "password", placeholder: "Confirm password", required: true},
        {type: "phone", placeholder: "Phone", required: true},
        {type: "text", placeholder: "VAT"},
        {type: "text", placeholder: "Department", required: true},
        {type: "text", placeholder: "Post", required: true}];

    var i = 0;
    while (i < arrayColumns.length) {
        let row = $("<div>");
        row.addClass('form-row justify-content-center');
        
        for (var j = 0; j < columns; j++) {
            let column = $("<div>");
            column.addClass('form-col mx-3 my-2 my-md-3');
            let input = $('<input>');
            input.addClass('form-control');
            input.attr("type", arrayColumns[i]["type"]);
            input.attr("placeholder", arrayColumns[i]["placeholder"]);
            if (arrayColumns[i]["required"]) {
                input.attr("required", "");
            }
            column.append(input);
            row.append(column);
            i++;
        }
        form.append(row);
    }


}




$("document").ready(function () {

    $("#next").click(function (e) {
        e.preventDefault();
        var institution = $('#registerTab a[href="#institution"]');
        console.log(institution);
        institution.removeClass("disabled");
        institution.tab('show');
        
    });

});



