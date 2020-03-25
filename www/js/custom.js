var debug = true;

$(document).ready(function() {
    $("#sidenavCollapse").click(function(){
        var sidenav = $('#sidenav');
        sidenav.toggleClass("collapsed");
    });
});

function createFormStruct(form, data) {
    var row = $("<div>");
    row.addClass('form-row justify-content-center');
    
    //Creates the form columns.
    for (const col of data) {
        let column = $("<div>");
        column.addClass('col-12 col-sm-10 col-md-5 col-lg-4 mx-md-3 my-2 my-md-3');

        let element;
        if (col["type"] === "select") {          //Checks if the next element is a select and treats it like a select element.
            element = $('<select>');

            //Checks if a placeholder exists and adds it if so.
            if(typeof col["placeholder"] !== "undefined") {
                placeholder = $('<option>');
                placeholder.text(col["placeholder"]);
                placeholder.attr('disabled', '');
                placeholder.attr('selected', '');
                element.append(placeholder);        //Adds the select placeholder (some kind of description).
            }
            
            //Gets json data form the url asynchronously.
            fetch(col["url"]).then(response => response.json()).then(options => {
                if(options){
                    //Adds the options to the select.
                    for(let data of options) {
                        let option = $('<option>');
                        option.val(data['value']);
                        option.text(data['text']);

                        if(typeof col["value"] !== "undefined" && col["value"] === data["value"]) {
                            option.attr('selected', '');
                        }

                        element.append(option);
                    }
                }
            });
        } else {                            //If it's not a select we will treat the data like an input element.
            element = $('<input>');
            element.attr("type", col["type"]);
            element.attr("placeholder", col["placeholder"]);
            
            if (col["required"]) {
                element.attr("required", "");
            }

            if (typeof col["value"] !== "undefined") {
                element.val(col["value"]);
            }
        }
        //Those are common attributes
        element.attr("name", col["name"]);
        element.attr("id", col["id"]);
        element.addClass('form-control');

        column.append(element);
        row.append(column);
    }
    
    form.prepend(row);
}
