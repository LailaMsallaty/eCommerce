
$(document).ready( function(){

  'use strict';


  // switch between login & signup

  $('.login-page h1 span').click(function(){


    $(this).addClass('selected').siblings().removeClass('selected');
    $('.login-page form').hide();
    $( '.' + $(this).data('class')).fadeIn(100)



  });
  
// convert password field to text field on hover

 var PassField = $('.eye');

    $('.show-pass').hover( function(){
        
        PassField.attr('type','text');

    }, function(){

        PassField.attr('type','password');

    });

 

  // trigger the selectboxit

  $("select").selectBoxIt({


     autoWidth : false
     
  });


	// Hide Placeholder on form focus

	$('input[placeholder]').on("focus",function(){

    $(this).attr("data-text", $(this).attr("placeholder"));
    $(this).attr("placeholder","");

	}).on("blur",function(){
     
    $(this).attr("placeholder", $(this).attr("data-text"));

	});

	// Add asterisk on required field 

	$('input').each(function() {

       if ($(this).attr('required') === 'required') {

         $(this).after('<span class="asterisk">*</span>');

       }

	});
	
	
	// confirmation message on button

	$('.confirm').click(function(){

     return confirm(' Are you sure ? / هل أنت متأكد ؟');


	});

  $('.live').keyup( function(){

     $($(this).data('class')).text($(this).val());


  });
  
 function imagepreview(input){

      if(input.files && input.files[0]) {

        var filerd = new FileReader();

        filerd.onload = function(e){

          $('#idForm + #imagepreview').remove();
          $('#imagepreview').attr('src',e.target.result);
         


        };

        filerd.readAsDataURL(input.files[0]);
      }

   }

$('#idupload').change(function(){

    imagepreview(this);

});
 
});
