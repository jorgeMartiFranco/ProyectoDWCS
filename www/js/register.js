$("document").ready(function () {

    $("#next").click(function () {
        var institution = $('#registerTab a[href="#institution"]');
        console.log(institution);
        institution.removeClass("disabled");
        institution.tab('show');
    });

});


function createFormRegistro() {
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