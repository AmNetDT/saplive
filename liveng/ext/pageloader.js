$(document).ready(function(){
	
  $("#loader_httpFeeds").hide();
   $('._mc a').click(function(e){ 
	//Pssing values to nextPage 
	var rsData     =  "eQvmTfgfru"; 
	var dataString =  "rsData="+ rsData;
	
	$("#loader_httpFeeds").show();
	     $.ajax({
           type: "POST",
	       url: $(this).attr('id')+"/",
		   data: dataString,
	       cache: false,
             success: function(msg){
		       $("#loader_httpFeeds").hide();  
             $("#contentbar_inner").scrollTop(0).html(msg);
	       
	       }		
	  });
     return false;
  });
  })