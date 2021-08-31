$(document).ready(function(){
	
   $('._mc').click(function(e){ 
	//$("#loader_httpFeeds").show();
	     $.ajax({
           type: "POST",
	       url: $(this).attr('id'),
		  // data: dataString,
	       cache: false,
             success: function(msg){
		     //$("#loader_httpFeeds").hide();  
             $(".cen_c_c").scrollTop(0).html(msg);
	       
	       }		
	  });
     return false;
  });
  })