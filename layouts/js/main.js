$(document).ready(function(){
	$(".col-3 input").val("");
	
	$(".input-effect input").focusout(function(){
		if($('.input').val() != ""){
			$(this).addClass("has-content");
		}else{
			$(this).removeClass("has-content");
		}
	})
	 function load_unseen_notification(view = '')
	 {
	  $.ajax({
	   url:"../admin/fetch.php",
	   method:"POST",
	   data:{view:view},
	   dataType:"json",
	   success:function(data)
	   {
	    $('.dropdown-menu').html(data.notification);
	    if(data.unseen_notification > 0)
	    {
	     $('.count').html(data.unseen_notification);
	    }
	   }
	  });
	 }
	 load_unseen_notification();
	 
	 // $('#comment_form').on('submit', function(event){
	 //  event.preventDefault();
	 //  if($('#subject').val() != '' && $('#comment').val() != '')
	 //  {
	 //   var form_data = $(this).serialize();
	 //   $.ajax({
	 //    url:"insert.php",
	 //    method:"POST",
	 //    data:form_data,
	 //    success:function(data)
	 //    {
	 //     $('#comment_form')[0].reset();
	 //     load_unseen_notification();
	 //    }
	 //   });
	 //  }
	 //  else
	 //  {
	 //   alert("Both Fields are Required");
	 //  }
	 // });
	 $(document).on('click', '.dropbtn', function(){
	  $('.count').html('');
	  load_unseen_notification('yes');
	 });
});