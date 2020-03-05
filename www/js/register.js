$("document").ready(function () {

    $("#next").click(function () {
        var institution = $('#registerTab a[href="#institution"]');
        institution.removeClass("disabled");
        institution.tab('show');
    });

});


function createFormRegisterPartner() {
    var form = $("#partner");
    var arrayColumns = [
        {type: "text", placeholder: "First name", name: "fName", id: "fName", required: true},
        {type: "text", placeholder: "Last name", name: "lName", id: "lName", required: true},
        {type: "text", placeholder: "Username", name: "username", id: "username", required: true},
        {type: "email", placeholder: "Email", name: "email", id: "email", required: true},
        {type: "password", placeholder: "Password", name: "password", id: "password", required: true},
        {type: "password", placeholder: "Confirm password", id: "password2", required: true},
        {type: "phone", placeholder: "Phone", name: "phone", id: "phone", required: true},
        {type: "text", placeholder: "VAT", name: "vat", id: "vat"},
        {type: "text", placeholder: "Department", name: "department", id: "department", required: true},
        {type: "text", placeholder: "Post", name: "post", id: "post", required: true}
    ];
    createFormStruct(form, arrayColumns, 2);
}



function createFormRegisterInstitution(){
    var form = $("#institution");
    var arrayColumns = [
        {type: "text", placeholder: "Name", name: "iName", id: "iname", required: true},
        {type: "email", placeholder: "Email", name: "iEmail", id: "iEmail", required: true},
        {type: "phone", placeholder: "Phone", name: "iPhone", id: "iPhone", required: true},
        {type: "text", placeholder: "VAT", name: "iVat", id: "iVat"},
        {type: "text", placeholder: "Postal Code", name: "postalCode", id: "postalCode", required: true},
        {type: "text", placeholder: "Location", name: "location", id: "location", required: true},
        {type: "text", placeholder: "Web", name: "web", id: "web"},
        {type: "text", placeholder: "Description", name: "description", id: "description"}
    ];
    
    
    createFormStruct(form,arrayColumns,2);
    
    
}