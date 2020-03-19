var debug = true;

$(document).ready(function() {
    $("#sidenavCollapse").click(function(){
        var sidenav = $('#sidenav');
        sidenav.toggleClass("collapsed");
        if(sidenav.hasClass("collapsed")) {
            $("#wrapper").css("background-color", "rgba(0,0,0,0.3)");
        }
        
    });
});



function createFormStructV1(form, data, columns) {
    var i = 0;
    var pair;
    var count=0;
    var entries=data.length;
    if(entries%columns==0){
        pair=true;
    }
    else {
        pair=false;
    }
    
    while (i < entries) {
        let row = $("<div>");
        row.addClass('form-row justify-content-center');
        
        for (var j = 0; j < columns; j++) {
            if(count==entries&&pair==false){
                break;
            }
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
            count++;

        }
        
        form.append(row);
    }
}

function createFormStruct(form, data, urls) {
    var selectCount = 0;    //Counts the next select options array to fill.

    var row = $("<div>");
    row.addClass('form-row justify-content-center');
    
    //Creates the form columns.
    for (const col of data) {
        let column = $("<div>");
        column.addClass('col-12 col-sm-10 col-md-5 col-lg-4 mx-md-3 my-2 my-md-3');

        let element;
        if(col["type"] === "select") {          //Checks if the next element is a select and treats it like a select element.
            element = $('<select>');
            placeholder = $('<option>');
            placeholder.text(col["placeholder"]);
            placeholder.attr('disabled', '');
            placeholder.attr('selected', '');
            element.append(placeholder);        //Adds the select placeholder (some kind of description).


            let url = urls[selectCount];

            if(url){
                fetch(url).then(response => response.json()).then(options => {
                    //Adds the options to the select.
                    for(let data of options) {
                        let option = $('<option>');
                        option.val(data['value']);
                        option.text(data['text']);
    
                        element.append(option);
                    }
                });
            } else if(debug) {
                console.error('There are missing urls, you passed ' + urls.length + ' urls to the function but there are ' + (selectCount+1) + ' selects.');
            }

            selectCount++;
        } else {                            //If it's not a select we will treat the data like an input element.
            element = $('<input>');
            element.attr("type", col["type"]);
            element.attr("placeholder", col["placeholder"]);
            
            if (col["required"]) {
                element.attr("required", "");
            }
        }
        //Those are common attributes
        element.attr("name", col["name"]);
        element.attr("id", col["id"]);
        element.addClass('form-control');

        column.append(element);
        row.append(column);
    }
    
    form.append(row);
}
