     
$(function() 
{
//initialize form elements
if($("#lang").length){ $("#lang").select2();} 
if($('.bootstrap-select').length){$('.bootstrap-select').selectpicker();}
   
/*language create */  
 $("#language_create").submit(function(e)
    {
        e.preventDefault();   
        
        var languages        =   $("[name='languages']").val().trim();  
        var a = 0;
         
       //languages
        if(languages == 'select')
        {  
            a=0; 
            $( "#language_error" ).addClass( "has-error" ); 
            $("#language_error .help-block").html('<label id="default_select-error" class="validation-error-label" for="default_select">This field is required.</label>');
        }
        else
        {   a=1; 
            $( "#language_error" ).removeClass( "has-error" );
            $("#language_error .help-block").html(' ');
        }
        
        if(a==1)
        {
              var data=  new FormData($('#language_create')[0]); 
               var action=   $("#language_create").attr('action');
               $.ajax({
                    type: "POST",
                    url:action,
                    dataType: "json",
                    async: false, 
                    data: data,
                    processData: false,
                    contentType: false, 
                    success: function(response)
                    {     
                         if(response.status==true){window.location.href = response.url; }
                         else{location.reload();}
                    },
                    error: function (request, textStatus, errorThrown) {
  
                    }

                });
        }
        
         
        return false;
        
    });

/* language create end */  



/* ************************************************************************* */  
/* ****************************** function end ***************************** */  
/* ************************************************************************* */    
   
   
});
