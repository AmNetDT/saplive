// JavaScript Document
 $(document).ready(function(){
	 
	 
	 
	$('#search_outlets').click(function(e) { 

	     $("#loaders").show();
		 
         var appDate = $("#dates_sarch").val();
		 
         if(appDate==""){
			 
			  $("#loaders").hide();
			 alert("Enter Outlet URNO"); 
			 
		 }else{	 
		 
		 
		 var Stringnifys = {
		    'urls':appDate
	    }
		
		$.ajax({
		type: "POST",
		url: "outlet_result.php",
		data: Stringnifys,	
		success: function(xhtR){
	     //alert(xhtR);
	 	 $(".oulets_query_result").show().html(xhtR);
		 $("#loaders").hide();
	   }
	});
		 }
	return false;
		
    });
	
	
	
    $('#Esearch').click(function(e) { 

	    //alert("p"); 
		$("#loader").show();
		var pass = $("#Upass").val();
		var pin = $("#Upin").val();
		
		if(pass=="" || pin==""){
			
			 $("#loader").hide();
			 alert("Enter Password and Pin"); 
			
		}else{
			
			 var Stringnifys = {
		       'pass':pass,
			   'pin':pin
	         }
			 
			 
			$.ajax({
				
				type: "POST",
				url: "outlet_results.php",
				data: Stringnifys,	
				success: function(xhtR){
				$(".oulets_query_results").show().html(xhtR);
				$("#loader").hide();
				}
			});
		}
		
	   return false;
    });
	
	
	

	$(document).on('click','.using_click', function(){
   
		$(".loader"+employee_outlet_id).show();
		
		var employee_outlet_id  = $(this).attr('id');
		var outlet_id = $("#input"+employee_outlet_id).val();
		
        if(outlet_id==""){
			$(".loader"+employee_outlet_id).hide();
			alert("Enter Enter OUTLET ID"); 
		}else{
			
			var Stringnifys = {
		       'outlet_id':outlet_id,
			   'employee_outlet_id':employee_outlet_id
	         }
			
			$.ajax({
				
				type: "POST",
				url: "outlet_resultr.php",
				data: Stringnifys,	
				success: function(xhtR){
					
				if(xhtR==200){
					//alert(outlet_id);
				  $("#dlete"+outlet_id).hide();
				  $(".loader"+employee_outlet_id).hide();
		          $("#filterid"+employee_outlet_id).hide();
				}
			  }
			});	
		}	
	    return false;
    });
  
	 
	
	
	
})





