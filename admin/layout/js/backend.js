
$(document).ready( function(){

  'use strict';

  // Dashboard

  $(".toggle-info").click(function(){

      $(this).toggleClass('selected').parent().next('.card-body').fadeToggle(100);

      if ($(this).hasClass('selected')) {

        $(this).html('<i class="fa fa-plus fa-lg"></i>');

      }else{

        $(this).html('<i class="fa fa-minus fa-lg"></i>');
      }



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
	
	// convert password field to text field on hover



		var PassField = $('.eye');

    $('.show-pass').hover( function(){
        
        PassField.attr('type','text');

    }, function(){

        PassField.attr('type','password');

    });

	// confirmation message on button

	$('.confirm').click(function(){

      return confirm(' Are you sure ?');


	});

   // category view option 

   $('.cat h3').click(function(){

      $(this).next('.full-view').fadeToggle(200);


   });
   $('.option span').click(function(){

      $(this).addClass('active').siblings('span').removeClass('active');

      if ($(this).data('view') === 'full') {


      	$('.cat .full-view').fadeIn(200);

      }else{

      	$('.cat .full-view').fadeOut(200);

      }

   });

  // show delete bottun on cats 
 
   $('.child-link').hover(function(){


     $(this).find('.show-delete').fadeIn(400);



   } , function(){


    $(this).find('.show-delete').fadeOut(400);


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
