$(function(){ 

    $('#save_continue').click(function(e){ 
        var btn_name = (this.value);
        $('#btn_name').val(btn_name);
        $('#save_continue').submit();
    });

    var commission=0;
    $('#product_category').on('change', function() {
       commission = $('#'+this.value).val();
       $('#commission').val(commission) ;
       $('.commission').show();
       
    });
    
    // product title and meta title
    $('input[name="product_title"]').keyup(function(){

        $('input[name="meta_title"]').val(this.value);
    });

    $("input#store_price").keyup(function(){
        
        var commission_id =  $('#product_category option:selected').val();
        var commission = $('#'+commission_id).val();
        $('#commission').val(commission) ;
        $('.commission').show('slow');
        var store_price = this.value;
        
        var mrp = parseFloat(store_price)+(store_price*commission)/100;
        $('#price').val(mrp.toFixed(2));
        updateDiscount();

    });

    $('#discount_type').on('change', function() {
        var discount_type =  $('#discount_type option:selected').val();
        var store_price = $('#price').val();

        if(discount_type=='fixed'){
            var discount = $('#discount').val();

        }else{
            var discount = $('#discount').val();
            discount = (store_price*discount)/100;
        } 
         

        var mrp = parseFloat(store_price)-discount;
        $('#discount_price').val(mrp.toFixed(2));
    });

    $("input#discount").keyup(function(){
        
        var discount_type =  $('#discount_type option:selected').val();
        var store_price = $('#price').val();

        if(discount_type=='fixed'){
            var discount = $('#discount').val();

        }else{
            var discount = $('#discount').val();
            discount = (store_price*discount)/100;
        } 

        if(parseInt(store_price)<parseInt(discount)){
            bootbox.alert('Discount should not be greater than store price');
            $('#discount').val('0');
            return false;
        }

        var mrp = parseFloat(store_price)-discount;
        $('#discount_price').val(mrp.toFixed(2));

    }); 
});


function updateDiscount(){
    var discount_type =  $('#discount_type option:selected').val();
    var store_price = $('#price').val();
    
    if(discount_type=='fixed'){
        var discount = $('#discount').val();

    }else{
        var discount = $('#discount').val();
        discount = (store_price*discount)/100;
    } 

      if(parseInt(store_price)<parseInt(discount)){
        bootbox.alert('Discount should not be greater than store price');
        $('#discount').val('0');
        return false;
    }

    var mrp = parseFloat(store_price)-discount;
    $('#discount_price').val(mrp.toFixed(2));
}

function popupAlert(url,id){
    bootbox.confirm({
    title: "Destroy default category?",
    message: "Do you want to delete the default category? This cannot be undone.",
    buttons: {
        cancel: {
            label: '<i class="fa fa-times"></i> Cancel'
        },
        confirm: {
            label: '<i class="fa fa-check"></i> Confirm'
        }
    },
    callback: function (result) {
        if(result){
            $('#'+id).attr('href',url); 
            window.location.href = url;
        }

    }
});
}
  
$(function(){ 

$('#saveBtn').removeAttr('disabled');
$('.legitRipple').removeAttr('disabled');

    /*
    Method : Delete particulare record
    @param : id,status
    Author : Kundan
    Description : delete particular record from dataBase
    */
    $('button[name="remove_levels"]').on('click', function(e){
    //    bootbox.confirm('hello');
       var self = $(this);   
        var form = $(this).closest('form'); 
        e.preventDefault(); 
        
       bootbox.confirm('<b><h3>Are you sure you want to delete?</h3></b>',function(result){
      if(result)
      {
             var id = self.attr('id');
             
          $('#deleteForm_'+id).submit();
      }   
      
       });
    }); 

});


 


function popupAlert(url,id){
    bootbox.confirm({
    title: "Destroy default category?",
    message: "Do you want to delete the default category? This cannot be undone.",
    buttons: {
        cancel: {
            label: '<i class="fa fa-times"></i> Cancel'
        },
        confirm: {
            label: '<i class="fa fa-check"></i> Confirm'
        }
    },
    callback: function (result) {
        if(result){
            $('#'+id).attr('href',url); 
            window.location.href = url;
        }

    }
});
}

/* 
Method : changeStatus
@param : id,controllerName (example user)
Author : Kundan Roy
Description : Change the status of record to activate or deactivate
*/
function changeStatus(id,method)
{
    var status =  $('#'+id).attr('data'); 
    $.ajax({
        type: "GET",
        data: {id: id,status:status},
        url: url+'/admin/'+method,
        beforeSend: function() {
           $('#'+id).html('Processing');
        },
        success: function(response) {
            
	  //bootbox.alert('Activated');            
		if(response==1)
            {
                $('#'+id).html('Active'); 
                $('#'+id).attr('data',response);
                $('#'+id).removeClass('label label-warning status').addClass('label label-success status');
                
               //  console.log(response);
                 $('#btn'+id).removeAttr('disabled');
            }else
            {
                $('#'+id).html('Inactive'); 
                $('#'+id).attr('data',response);
                $('#'+id).removeClass('label label-success status').addClass('label label-warning status');
               // $('#btn'+id).attr('disabled','disabled');
            }
        }
    });
}
/* 
Method : changeAllStatus
@param : id,controllerName (example user)
Author : Kundan Roy
Description : Change the status of all record to activate or deactivate
*/

function changeAllStatus(id,method,status)
{
    //var status =  $('#'+id).attr('data');
    //alert(url); return false;
    $.ajax({
        type: "GET",
        data: {id: id,status:status},
        url: url+'/'+method,
        beforeSend: function() {
           $('#'+id).html('Processing')
        },
        success: function(response) {
            
            if(response==1)
            {
                $('#'+id).html('Approved'); 
                $('#'+id).attr('data',response);
                $('#'+id).removeClass('label label-warning status').addClass('label label-success status');
                
                  
                
            }else if(response==2)
            {
                $('#'+id).html('Not Approve'); 
                $('#'+id).attr('data',response);
                $('#'+id).removeClass('label label-success status').addClass('label label-warning status');
                
            }
            else
            {
                $('#'+id).html('Yet not Approve'); 
                $('#'+id).attr('data',response);
                $('#'+id).removeClass('label label-success status').addClass('label label-warning status');
                
            }
        }
    });


}
/************28/12/2015[Ismael]***************/
var Title1='This field is required';
$(document).ready(function(){
$("#group_title").validate({          
        errorClass: 'error', // default input error message class        
        rules: {
            Title: {
                required: true,                    
            }
        },
        // Specify the validation error messages
        messages: {
            Title: {
                required: Title1               
                },           
        },
        submitHandler: function(event) {
             $("#group_title").submit();
         }
    });

/***********for users**************/
var firstname_msg="First Name is required."; 
var email_msg="Email Should be Validate.";
var pwd_msg="Password is required.";

 

$("#users_form1").validate({          
        errorClass: 'error', // default input error message class        
        rules: {
            first_name: {
                required: true,                    
            },
            
            email: {
                required: true,
                email: true
            },            
            password: {
                required: true,
            }     
        },
        // Specify the validation error messages
        messages: {
           	first_name: {
                required: firstname_msg               
                },  
            email: {
                required: email_msg               
                },
            password: {
                required: pwd_msg,
                },     
        },
        submitHandler: function(event) {
	    
             $("#users_form").submit();
             return false;
         }
    });

/***************for package*******************/
var namefr="NameFR Should be filled.";
var nameen="NameEN Should be filled.";
var price="Price Should be filled and must be numeric";
var month="Month Should be filled.";
$("#package").validate({          
        errorClass: 'error', // default input error message class        
        rules: {
            NameFR: {
                required: true,                    
            },
            NameEN: {
                required: true,                    
            }
            ,
            Price: {
                required: true, 
                            
            }
            ,
            Month: {
                required: true,                    
            }
        },
        // Specify the validation error messages
        messages: {
            NameFR: {
                required: namefr               
                }, 
            NameEN: {
                required: nameen               
                }, 
            Price: {
                required: price 
                             
                },
            Month: {
                required: month               
                },           
        },
        submitHandler: function(event) {
             $("#package").submit();
         }
    });
/*****************building**********************/
var Title_img="Title Should be filled.";
var file_name="File name Should be filled.";
$("#building").validate({          
        errorClass: 'error', // default input error message class        
        rules: {
            Title: {
                required: true,                    
            },
            File_name: {
                required: true,                    
            }                    
        },
        // Specify the validation error messages
        messages: {
            Title: {
                required: Title_img               
                }, 
            File_name: {
                required: file_name               
                }       
        },
        submitHandler: function(event) {
             $("#building").submit();
         }
    });

var price_by_month1="Price by month Should be filled.";
$("#building_rent").validate({          
        errorClass: 'error', // default input error message class        
        rules: {
            price_by_month: {
                required: true,                    
            }                  
        },
        // Specify the validation error messages
        messages: {
            price_by_month: {
                required: price_by_month1               
                }      
        },
        submitHandler: function(event) {
             $("#building_rent").submit();
         }
    });
var inclusion="Inclusion Should be filled.";
$("#building_inc").validate({          
        errorClass: 'error', // default input error message class        
        rules: {
            Inclusion: {
                required: true,                    
            }                  
        },
        // Specify the validation error messages
        messages: {
            Inclusion: {
                required: inclusion               
                }      
        },
        submitHandler: function(event) {
             $("#building_inc").submit();
         }
    });

var exclusion="Exclusion Should be filled.";
$("#building_exc").validate({          
        errorClass: 'error', // default input error message class        
        rules: {
            Exclusion: {
                required: true,                    
            }                  
        },
        // Specify the validation error messages
        messages: {
            Exclusion: {
                required: exclusion               
                }      
        },
        submitHandler: function(event) {
             $("#building_exc").submit();
         }
    });

});

 
 

function getHora() {
    date = new Date();
    return date.getHours()+':'+date.getMinutes()+':'+date.getSeconds();
};




$(function(){
     $("#user-form2").validate({
        errorLabelContainer: '.error-loc',
         errorClass:'myClass',
        rules: {
            category_group_name: {
                required: true, 
            } 
        },
        // Specify the validation error messages
        messages: {
            category_group_name: {
                required: "category group name is required."
            },
             
        },
        submitHandler: function(event) {
            $("#user-form").submit();
        }
    });
});

function checkAll(ele) {
     var checkboxes = document.getElementsByTagName('input');
     if (ele.checked) {
         for (var i = 0; i < checkboxes.length; i++) {
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = true;
             }
         }
     } else {
         for (var i = 0; i < checkboxes.length; i++) {
            // console.log(i)
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = false;
             }
         }
     }
 }

 function checkAllContact(ele) {
     var checkboxes = document.getElementsByTagName('input');
     if (ele.checked) {
         for (var i = 0; i < checkboxes.length; i++) {
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = true;
             }
         }
     } else {
         for (var i = 0; i < checkboxes.length; i++) {
            // console.log(i)
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = false;
             }
         }
     }
 }



 function deleteRow(tableID) {
     try {
         var table = document.getElementById(tableID);
         var rowCount = table.rows.length;

         for (var i = 1; i < rowCount; i++) {
             var row = table.rows[i];
             var chkbox = row.cells[0].childNodes[0];
             if (null != chkbox && true == chkbox.checked) {
                 table.deleteRow(i);
                 rowCount--;
                 i--;
             }
         }
     } catch (e) {
         alert(e);
     }
 }



function createGroup(Url,action) {
    var createGroup=0;
    var name ='';
     try {
        var checkValues = $('input[name=checkAll]:checked').map(function()
            {
                return $(this).val();
            }).get(); 
        //alert(action);
         if(checkValues.length==0){
             $('#error_msg').html('Please select contact to create group').css('color','red');
             $('#csave').hide();
             return false;
           }else{
                if(action=='save'){
                   name =  ($('#contact_group').val()).replace(/^\s+|\s+$/gm,'');
                   if(name.length==0){
                        $('#error_msg').html('Please enter group name.').css('color','red');
                        return false;
                     }else{
                        $('#error_msg').html('');
                        $('#csave').show();
                        createGroup =1;
                     }
               }else{
                     $('#error_msg').html('');
                        $('#csave').show();
               } 
           }  
            
            if(createGroup==1){
                $.ajax({
                    url: Url,
                    type: 'get',
                    data: { ids: checkValues,groupName:name },
                     dataType: "json",
                    success:function(data){
                         if(data.status==0){
                            $('#error_msg').html(data.message).css('color','red');
                            return false;
                         }else{
                             $('#responsive').modal('hide');
                             bootbox.alert('Group name created successfully',function(){
                                 var u =url+'/admin/contactGroup';
                               //  console.log(u);
                                 window.location.assign(u);
                             });
                             
                         }
                        
                    }
                }); 
            }else{
                $('#responsive').modal('hide');
            }


     } catch (e) {
         alert(e);
     }
 }

 

    $(document).ready(function(){
        var action = "admin/contact/import";
        
     
            $("#import_contact").on('submit',(function(e){
                e.preventDefault();
                $.ajax({
                url: url+'/'+action,
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(datas){
                  //  console.log(datas);
                    var data = JSON.parse(datas); 
                    if(data.status==0){
                        $('#error_msg2').html(data.message).css('color','red');
                        return false;
                     }else{
                         $('#responsive2').modal('hide');
                         bootbox.alert('Contact imported successfully',function(){
                             var u =url+'/admin/contact';
                           //  console.log(u);
                             setTimeout(function(){ window.location.assign(u);},100);
                             
                         });
                     }
                },
                error: function(){}             
                });
            })); 
    });

    function updateGroup(Url,id) {
        createGroup=0;
        var name =$('form#updateGroup_'+id+' input#contact_group').val().replace(/^\s+|\s+$/gm,'');  
       // console.log(id,name,'form#updateGroup_'+id+' input#contact_group');
        var parent_id = $('form#updateGroup_'+id+' input#parent_id').val();
        try {
        var checkValues = $('form#updateGroup_'+id+' input[name=checkAll]:checked').map(function()
            {
                return $(this).val();
            }).get(); 
        
         if(checkValues.length==0){
             $('form#updateGroup_'+id+' #error_msg').html('Please select contact from list').css('color','red');
            
             return false;
           }else{
                if(name.length==0){
                    $('form#updateGroup_'+id+' #error_msg').html('Please enter group name.').css('color','red');
                    return false;
                 }else{
                    $('form#updateGroup_'+id+' #error_msg').html('');
                    createGroup =1;
                 }
           }  
            if(createGroup==1){
                $.ajax({
                    url: Url,
                    type: 'get',
                    data: { ids: checkValues,groupName:name,parent_id:parent_id },
                     dataType: "json",
                    success:function(data){
                        //return false;
                         if(data.status==0){
                            $('#error_msg').html(data.message).css('color','red');
                            return false;
                         }else{
                             $('#responsive_'+id).modal('hide');
                             bootbox.alert('Group updated successfully',function(){
                                 var u =url+'/admin/contactGroup';
                               //  console.log(u);
                                 //window.location.assign(u);
                                setTimeout(function(){ location.reload();},100);
                                
                             });
                             
                         }
                        
                    }
                }); 
            }else{
                $('#responsive').modal('hide');
            }


     } catch (e) {
         //alert(e);
     }
 }
 
// import csv
    $(document).ready(function(){
        var action = $('#url_action').val();  
        var redirect_action = $('#redirect_action').val();
        
        $("#import_csv").on('submit',(function(e){
            e.preventDefault();
            $.ajax({
            url: url+'/'+action,
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(datas){
                console.log(datas);
               // return false;
                var data = JSON.parse(datas); 
                if(data.status==0){
                    $('#error_msg2').html(data.message).css('color','red');
                    return false;
                 }else{
                     $('#responsive2').modal('hide');
                     bootbox.alert('Csv imported successfully',function(){
                         var u =url+'/'+redirect_action;
                        // console.log(u);

                       //  setTimeout(function(){ window.location.assign(u);},100);
                         
                     });
                 }
            },
            error: function(){}             
            });
        })); 
    });




function deleteAll(url,table){

  var checkValues = $('input[name=checkAll]:checked').map(function()
            {
                return $(this).val();
            }).get();

  if(checkValues.length==0){
      
    bootbox.confirm({
    title: "Delete "+table,
    message: "There is no "+table+' selected to delete',
    buttons: {
        cancel: {
                label: '<i class="fa fa-times"></i> Cancel'
            },
            confirm: {
                label: '<i class="fa fa-check"></i> Ok'
            }
        },
        callback: function (result) {
            if(result){
 
            }

        }
    });

      return false;
  }
    bootbox.confirm({
    title: "Delete "+table,
    message: "Do you want to delete? This cannot be undone.",
    buttons: {
        cancel: {
            label: '<i class="fa fa-times"></i> Cancel'
        },
        confirm: {
            label: '<i class="fa fa-check"></i> Confirm'
        }
    },
    callback: function (result) {
        if(result){

          var checkValues = $('input[name=checkAll]:checked').map(function()
            {
                return $(this).val();
            }).get(); 
           $.ajax({
                url: url+'/delete/all',
                type: 'post',
                data: { ids: checkValues,table:table},
                success:function(response){ 
                      bootbox.alert(table+' deleted successfully',function(){
                             window.location.reload(true);
                      }); 
                }
            }); 
        }

    }
});
}


$(document).ready(function(){

    $("#startdate").datepicker({
        todayBtn:  1,
        autoclose: true,
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#enddate').datepicker('setStartDate', minDate);
    });

    $("#enddate").datepicker()
        .on('changeDate', function (selected) {
            var maxDate = new Date(selected.date.valueOf());
            $('#startdate').datepicker('setEndDate', maxDate);
        });

     $( "#taskdate" ).datepicker();
     var regExp = /[a-z]/i;
      $('#taskdate,#startdate,#enddate').on('keydown keyup', function(e) {
        var value = String.fromCharCode(e.which) || e.key;

        // No letters
        if (regExp.test(value)) {
          e.preventDefault();
          return false;
        }
      });

});


//Add New File Box
$(document).ready(function() {
    $(".btn-success").click(function(){ 
        var html = $(".clone").html();
        $(".increment").after(html);
    });

    $("body").on("click",".btn-danger",function(){ 
        $(this).parents(".control-group").remove();
    });

  });