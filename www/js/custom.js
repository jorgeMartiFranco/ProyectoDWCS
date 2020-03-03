


$('form').ready(function(){
    
    
    
    
    
    
});

function createFormStructRegister(form, input){
    var type,placeholder;
    
    var arrayColumns=[{type:"text", placeholder:"First name"},
                      {type:"text", placeholder:"Last name"},
                      {type:"text", placeholder:"Username"},
                      {type:"email", placeholder:"Email"},
                      {type:"password", placeholder:"Password"},
                      {type:"password", placeholder:"Confirm password"},
                      {type:"phone", placeholder:"Phone"},
                      {type:"text", placeholder:"VAT"},
                      {type:"text", placeholder:"Department"},
                      {type:"text", placeholder:"Post"}];
                  
                  
     for(const column of arrayColumns){
         
         
         
         
     }
    

}

function createColumns(number, data){
    var html;
    for(var i = 0; i < number; i++) {
        html = '<div class="form-col mx-3 my-2 my-md-3">'
                                   +'<input class="form-control" ' + 'type="' + data
                                +'</div>';
    }
    
    return html;
}