var baseurl = '/www/';

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
    createFormStruct(form, arrayColumns);
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
        {type: "text", placeholder: "Description", name: "description", id: "description"},
        {type: "select", placeholder: "Select country...", name: "country"},
        {type: "select", placeholder: "Select institution type...", name: "institutionType"}
    ];

    var urls = [baseurl + 'controller/json.php?countries'];
    
    
    createFormStruct(form, arrayColumns, urls);
    
    
}


function createFormInsertEnterprise(){
    
    var form = $("#enterprise");
    var arrayColumns = [
        {type: "text", placeholder: "Name", name: "eName", id: "ename", required: true},
        {type: "email", placeholder: "Email", name: "eEmail", id: "eEmail", required: true},
        {type: "phone", placeholder: "Phone", name: "ePhone", id: "ePhone", required: true},
        {type: "text", placeholder: "VAT", name: "eVat", id: "eVat"},
        {type: "text", placeholder: "Postal Code", name: "postalCode", id: "postalCode", required: true},
        {type: "text", placeholder: "Location", name: "location", id: "location", required: true},
        {type: "text", placeholder: "Web", name: "web", id: "web"},
        {type: "text", placeholder: "Description", name: "description", id: "description"},
        {type: "text", placeholder: "Ceo post", name: "ceoPost", id: "ceoPost"}
        
        
    ];
    
    
    createFormStruct(form,arrayColumns,2);

}
function createFormInsertStudent(){
    
    var form = $("#student");
    var arrayColumns = [
        {type: "text", placeholder: "First name", name: "fName", id: "fname", required: true},
        {type: "text", placeholder: "Last name", name: "lName", id: "lName", required: true},
        {type: "date", placeholder: "", name: "birthDate", id: "birthDate", required: true},
        {type: "text", placeholder: "VAT", name: "sVat", id: "sVat"}
     ];
    
    
    createFormStruct(form,arrayColumns,2);
}

function createFormInsertEnterpriseMobility(){
    var form = $("#enterpriseMobility");
    var arrayColumns = [
        {type: "date", placeholder: "", name: "startDate", id: "startDate", required: true},
        {type: "date", placeholder: "", name: "estimatedEndDate", id: "estimatedEndDate", required: true}
     ];
     
     createFormStruct(form,arrayColumns,2);
}

function createFormInsertSpecialty(){
    var form = $("#specialty");
    var arrayColumns = [
        {type: "text", placeholder: "Name", name: "type", id: "type", required: true},
        {type: "text", placeholder: "Description", name: "description", id: "description"}
     ];
     
     createFormStruct(form,arrayColumns,2);
}