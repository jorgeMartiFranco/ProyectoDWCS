var baseurl = '/';

$("document").ready(function () {

    $("#next").click(function () {
        var institution = $('#registerTab a[href="#institution"]');
        institution.removeClass("disabled");
        institution.tab('show');
        
        var ceo = $('#ceoTab');
        ceo.removeClass("disabled");
        ceo.tab('show');
    });

});


//REGISTER FORMS

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
        {type: "select", placeholder: "Select country...", name: "country", url: baseurl + 'controller/json.php?countries'},
        {type: "select", placeholder: "Select institution type...", name: "institutionType", url: baseurl + 'controller/json.php?institutionTypes'}
    ];
    
    createFormStruct(form, arrayColumns);
}


function createFormRegisterEnterprise(){
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
        {type: "text", placeholder: "Ceo post", name: "ceoPost", id: "ceoPost"},
        {type: "select", placeholder: "Select enterprise type...", name: "enterpriseType", url: baseurl + 'controller/json.php?enterpriseTypes'},
        {type: "select", placeholder: "Select country...", name: "country", url: baseurl + 'controller/json.php?countries'}
    ];
    
    createFormStruct(form, arrayColumns);
}

function createFormRegisterCEO(){
    var form = $("#ceo");
    var arrayColumns = [
        {type: "email", placeholder: "Email", name: "email", id: "email", required: true},
        {type: "text", placeholder: "First name", name: "fName", id: "fName", required: true},
        {type: "text", placeholder: "Last name", name: "lName", id: "lName", required: true},
        {type: "text", placeholder: "Phone", name: "phone", id: "phone"}
    ];
    
    createFormStruct(form, arrayColumns);
}

function createFormInsertStudent(){
    
    var form = $("#student");
    var arrayColumns = [
        {type: "text", placeholder: "First name", name: "fName", id: "fname", required: true},
        {type: "text", placeholder: "Last name", name: "lName", id: "lName", required: true},
        {type: "date", placeholder: "Birth date", name: "birthDate", id: "birthDate", required: true},
        {type: "text", placeholder: "VAT", name: "sVat", id: "sVat"}
     ];
    
    
    createFormStruct(form, arrayColumns);
}
    
function createFormRegisterEnterpriseType(){
    var form = $("#enterpriseType");
    var arrayColumns = [
        {type: "text", placeholder: "Type", name: "type", id: "type", required: true},
        {type: "text", placeholder: "Description", name: "description", id: "description"}
     ];
     
     createFormStruct(form, arrayColumns);
}

function createFormRegisterInstitutionType(){
    var form = $("#institutionType");
    var arrayColumns = [
        {type: "text", placeholder: "Type", name: "type", id: "type", required: true},
        {type: "text", placeholder: "Description", name: "description", id: "description"}
     ];
     
     createFormStruct(form, arrayColumns);
}

function createFormInsertSpecialty(){
    var form = $("#specialty");
    var arrayColumns = [
        {type: "text", placeholder: "Name", name: "type", id: "type", required: true},
        {type: "text", placeholder: "Description", name: "description", id: "description"}
     ];
     
     createFormStruct(form,arrayColumns);
}

//EDIT FORMS

async function createFormEditEnterprise(id){
    var form = $("#enterprise");

    var enterprise = await getJsonData(baseurl + 'controller/json.php?enterprise&id='+ id);

    var arrayColumns = [
        {type: "text", placeholder: "Name", name: "eName", id: "ename", required: true},
        {type: "email", placeholder: "Email", name: "eEmail", id: "eEmail", required: true},
        {type: "phone", placeholder: "Phone", name: "ePhone", id: "ePhone", required: true},
        {type: "text", placeholder: "VAT", name: "eVat", id: "eVat"},
        {type: "text", placeholder: "Postal Code", name: "postalCode", id: "postalCode", required: true},
        {type: "text", placeholder: "Location", name: "location", id: "location", required: true},
        {type: "text", placeholder: "Web", name: "web", id: "web"},
        {type: "text", placeholder: "Description", name: "description", id: "description"},
        {type: "text", placeholder: "Ceo post", name: "ceoPost", id: "ceoPost"},
        {type: "select", name: "enterpriseType", url: baseurl + 'controller/json.php?enterpriseTypes'},
        {type: "select", name: "country", url: baseurl + 'controller/json.php?countries'}
    ];

    for(col of arrayColumns) {
        for(property in enterprise){
            if(col.name === property) {
                col.value = enterprise[property];
            }
        }
    }

    createFormStruct(form, arrayColumns);
}

async function createFormEditPartner(id) {
    var form = $("#partner");

    var partner = await getJsonData(baseurl + 'controller/json.php?profile&id='+ id);

    var arrayColumns = [
        {type: "text", placeholder: "First name", name: "fName", id: "fName", required: true},
        {type: "text", placeholder: "Last name", name: "lName", id: "lName", required: true},
        {type: "text", placeholder: "Username", name: "username", id: "username", required: true},
        {type: "email", placeholder: "Email", name: "email", id: "email", required: true},
        {type: "phone", placeholder: "Phone", name: "phone", id: "phone", required: true},
        {type: "text", placeholder: "VAT", name: "vat", id: "vat"},
        {type: "text", placeholder: "Department", name: "department", id: "department", required: true},
        {type: "text", placeholder: "Post", name: "post", id: "post", required: true},
        {type: "select", name: "country", url: baseurl + 'controller/json.php?countries'}
    ];

    for(col of arrayColumns) {
        for(property in partner){
            if(col.name === property) {
                col.value = partner[property];
            }
        }
    }

    createFormStruct(form, arrayColumns);
}

async function createFormEditStudent(id){
    var form = $("#student");

    var student = await getJsonData(baseurl + 'controller/json.php?student&id=' + id);
    
    var arrayColumns = [
        {type: "text", placeholder: "First name", name: "fName", id: "fname", required: true},
        {type: "text", placeholder: "Last name", name: "lName", id: "lName", required: true},
        {type: "date", placeholder: "Birth date", name: "birthDate", id: "birthDate", required: true},
        {type: "text", placeholder: "VAT", name: "sVat", id: "sVat"}
    ];
    
     for(col of arrayColumns) {
        for(property in student){
            if(col.name === property) {
                col.value = student[property];
            }
        }
    }
    
    createFormStruct(form, arrayColumns);
}

//JSON SUPPORT

async function getJsonData($url){
    request = await fetch($url);
    return await request.json();
}
/*




}

function createFormInsertEnterpriseMobility(){
    var form = $("#enterpriseMobility");
    var arrayColumns = [
        {type: "date", placeholder: "", name: "startDate", id: "startDate", required: true},
        {type: "date", placeholder: "", name: "estimatedEndDate", id: "estimatedEndDate", required: true}
     ];
     
     createFormStruct(form,arrayColumns,2);
}

*/