// JavaScript Document
 $(document).ready(function(){
	 
	 
	 
	$('#popupoutlets').click(function(e) { 							  

	    var appDate = $("#dates").val();
		var Stringnifys = {
		    'Datess':appDate
	    }
		
	  $("#loaders").show();
		
	  $.ajax({
		type: "POST",
		url: "load_outlets.php",
		data: Stringnifys,	
		success: function(xhtR){
		 if(xhtR.trim()==="ok"){
			$("#loaders").hide();
			alert("SUCCESSFUL");
		 }
	   }
	});
		return false;
    });
  
	 
	 
	 
   $('#logB').click(function(e) { 							  
    $("#loaders").show();	
    $.ajax({
    type: "POST",
	  url: "sduser2.php",
	dataType: "json",
	data: $('#formUserAuth').serialize(),	
	success: function(xhtR){
	 	if(parseInt(xhtR.status)===400){
			$(".err_status").show().html(xhtR.responce);
	 	}else if(parseInt(xhtR.status)===200){
	    	window.location=xhtR.url; 
	 	}
	  $("#loaders").hide();
	 }
    });
    return false;
  });
	 


//Application view scroll
	$(".cen_c_c").on("scroll",function(){
	    var docViewTop = $(this).scrollTop();
	   //$("#scrolls").html(docViewTop);
	    var f = $("#cont_widget_fd").val(); //field
	    if(parseInt(docViewTop) > 50){
			if(parseInt(f)==1){
			  $("#scrolls").show();
			}else if(parseInt(f)==2){
			  $("#scrolls_tms").show();
			}else if(parseInt(f)==3){
			  $("#scrolls_audits").show(); 
			}else if(parseInt(f)==4){
			  $("#scrolls_competition").show(); 
			}
			
		}else{
			if(parseInt(f)==1){
			  $("#scrolls").hide();
			}else if(parseInt(f)==2){
			  $("#scrolls_tms").hide();
			}else if(parseInt(f)==3){
			  $("#scrolls_audits").hide();
			}else if(parseInt(f)==4){
			  $("#scrolls_competition").hide(); 
			}
		    
		}
	})
	 

  //fetch region for each modules........
  $('#rxx').change(function(e){
	$("#loaders").show();
    var b = $(this).val();
	var c = $("#users_id_hidden").val();
	var g = "b="+ b  + '&c='+ c;
	if(parseInt(b)>0){
	  	$.ajax({
		type: "POST",
		url: "liveregionpulls.php",
		data: g,
        cache: false,		
		success: function(xhtR){
	 	 $("#rxqq_pulls").html(xhtR);
		 $(".load_live_data").hide();
		 /*$("#metric_clock_in").show().html("");
		 $("#metric_clock_out").show().html("");
		 $("#metric_percent_covered").show().html("");*/
		 $("#rxqq_division").html('<option value="0" selected="selected">Select Division</option>');
	     $("#loaders").hide();
	   }
    });	
	}else{
	    $("#rxqq_pulls").html('<option value="0" selected="selected">Select Region</option>');
		$("#rxqq_division").html('<option value="0" selected="selected">Select Division</option>');
		$(".load_live_data").hide();
	    $("#loaders").hide();
		/*
		$("#metric_clock_in").show().html("");
		$("#metric_clock_out").show().html("");
		$("#metric_percent_covered").show().html("");*/
	}
    return false;
  });	
  
  
    $('#rxqq_pulls').change(function(e){
	$("#loaders").show();
    var c = $("#rxx").val();
	var g = "c="+ c;
	if(parseInt(c)>0){
	  	$.ajax({
			
		type: "POST",
		url: "livedivisionpulls.php",
		data: g,
        cache: false,		
		success: function(xhtR){
	 	 $("#rxqq_division").html(xhtR);
		 $(".load_live_data").hide();
		 $("#metric_clock_in").show().html("");
		 $("#metric_clock_out").show().html("");
		 $("#metric_percent_covered").show().html("");
	     $("#loaders").hide();
		 
	   }
    });	
	}else{
		
	    $("#rxqq_division").html('<option value="0" selected="selected">Select Division</option>');
		$(".load_live_data").hide();
	    $("#loaders").hide();
		$("#metric_clock_in").show().html("");
		$("#metric_clock_out").show().html("");
		$("#metric_percent_covered").show().html("");
	}
    return false;
  });	
  
  
  
  
 
  //pull result of search.......
  $("#rxqq_division").change(function(e) {
	
	var d = $(this).val();
	var r = $("#rxqq_pulls").val();
	var c = $("#rxx").val();
	var f = $("#cont_widget_fd").val(); //field

	
	if(parseInt(f)==1){
		if(parseInt(r)===0){
			$("#loaders").hide();
		}else{
			live_sales_performance(c,r,f,d);
			metrics(c,r,f,d);
			return false;
		}
	}else if(parseInt(f)==2){
		if(parseInt(r)===0){
			$("#loaders").hide();
		}else{
			live_tm_performance(c,r,f,d);
			tm_metrics(c,r,f,d);
			return false;
		}
	}else if(parseInt(f)==4){
		
		if(parseInt(r)===0){
			$("#loaders").hide();
		}else{
			live_pricing_performance(c,r,f);
			//metrics(c,r,f);
			return false;
		}
	}
   });	
   
   
   //node auto fetch details.....
   setInterval(function(){ 
   
   	   var d = $("#rxqq_division").val();
       var c = $("#rxx").val(); //company
	   var r = $("#rxqq_pulls").val(); //regions
	   var f = $("#cont_widget_fd").val(); //field
	   
	   if(f==1){
		   if(parseInt(r)!==0){
		  live_sales_performance(c,r,f,d);
		  metrics(c,r,f,d);
		  return false;
	     }
	   }else if(f==2){
		 if(parseInt(r)!==0){
		  live_tm_performance(c,r,f,d);
		  tm_metrics(c,r,f,d);
		  return false;
	     }
	   }else if(f==4){
		 if(parseInt(r)!==0){
		  live_pricing_performance(c,r,f);
		  //tm_metrics(c,r,f);
		  return false;
	     }
	   }
       
   }, 15*60*1000);
   
   //code to change select field
   $('.cont_widget').change(function(e){
	   
	    var cont = parseInt($(this).val());
		if(cont==1){
			$('.sales_modules_keys').show();
			$('.tm_modules_keys').hide();
			$('.auditor_modules_keys').hide();
			$('.auditor_modules_keys').hide();
			//header
			$('.sales_rep_module').show();
			$('.tms_module').hide();
			$('.auditor_module').hide();
			$('.compitation_module').hide();
			//span
			$('.sales_sales_rep').show();
			$('.sales_tm').hide();
			$('.field_auditor').hide();
			$('.compitations_auditor').hide();
		}else if(cont==2){
			$('.sales_modules_keys').hide();
			$('.tm_modules_keys').show();
			$('.auditor_modules_keys').hide();
			$('.auditor_modules_keys').hide();
			//header
			$('.sales_rep_module').hide();
			$('.tms_module').show();
			$('.auditor_module').hide();
			$('.compitation_module').hide();
			//span
			$('.sales_sales_rep').hide();
			$('.sales_tm').show();
			$('.field_auditor').hide();
			$('.compitations_auditor').hide();
		}else if(cont==3){
			$('.sales_modules_keys').hide();
			$('.tm_modules_keys').hide();
			$('.auditor_modules_keys').show();
			$('.auditor_modules_keys').hide();
			//header
			$('.sales_rep_module').hide();
			$('.tms_module').hide();
			$('.auditor_module').show();
			$('.compitation_module').hide();
			//span
			$('.sales_sales_rep').hide();
			$('.sales_tm').hide();
			$('.field_auditor').show();
			$('.compitations_auditor').hide();
		}else if(cont==4){
			$('.sales_modules_keys').hide();
			$('.tm_modules_keys').hide();
			$('.auditor_modules_keys').hide();
			$('.auditor_modules_keys').show();
			//header
			$('.sales_rep_module').hide();
			$('.tms_module').hide();
			$('.auditor_module').hide();
			$('.compitation_module').show();
			//span
			$('.sales_sales_rep').hide();
			$('.sales_tm').hide();
			$('.field_auditor').hide();
			$('.compitation_modules_keys').show();
		}else{
			 //content
        	$('.sales_modules_keys').hide();
			$('.tm_modules_keys').hide();
			$('.auditor_modules_keys').hide();
			$('.auditor_modules_keys').hide();
			//header
			$('.sales_rep_module').hide();
			$('.tms_module').hide();
			$('.auditor_module').hide();
			$('.compitation_module').hide();
			//span
			$('.sales_sales_rep').hide();
			$('.sales_tm').hide();
			$('.field_auditor').hide();
			$('.compitations_auditor').hide();
		}

   })
   

});



function live_sales_performance($company, $region, $field, $division){
	
	
	var Stringnifys = {
		    'd': $division,
		    'c':$company, 
			'r':$region,
			'delimiter':$field
	}
		
		
	  $("#loaders").show();
		
	  $.ajax({
		type: "POST",
		url: "livesalesserver.php",
		data: Stringnifys,	
		success: function(xhtR){
	     //alert(xhtR);
	 	 $(".load_live_data").show().html(xhtR);
		 $("#loaders").hide();
	   }
	});
}


function live_pricing_performance($company, $region, $field){
	
	var Stringnifys = {
		    'c':$company, 
			'r':$region,
			'delimiter':$field
	}
		
		
	  $("#loaders").show();
		
	  $.ajax({
		type: "POST",
		url: "livesalesserver.php",
		data: Stringnifys,	
		success: function(xhtR){
	     //alert(xhtR);
	 	 $(".load_live_data_competition").show().html(xhtR);
		 $("#loaders").hide();
	   }
	});
}


function live_tm_performance($company, $region, $field, $division){
	
	var Stringnifys = {
		
		    'd':$division,
		    'c':$company, 
			'r':$region,
			'delimiter':$field
	}
		
	  $("#loaders").show();
		
	  $.ajax({
		type: "POST",
		url: "livesalesserver.php",
		data: Stringnifys,	
		success: function(xhtR){
	 	 $(".load_live_data_tm").show().html(xhtR);
		 $("#loaders").hide();
	   }
	});
}





function metrics($company, $region, $field, $division){
	
	 var Stringnifys = {
		    'd':$division,
		    'c':$company, 
			'r':$region,
			'delimiter':$field
	 }
	 $.ajax({
		type: "POST",
		url: "livesalesmetric.php",
		data: Stringnifys,
		dataType: "json",
        cache: false,		
		success: function(xhtR){
         $("#metric_clock_in").show().html(xhtR.clockintime);
		 $("#metric_clock_out").show().html(xhtR.clockouttime);
		 $("#metric_percent_covered").show().html(xhtR.percovered);
		 $("#metric_server_date").show().html(xhtR.serverdate);
		 $("#load_active_sales_rep").show().html(xhtR.activerep);
	   }
	});
}


function tm_metrics($company, $region, $field, $division){
	
	 var Stringnifys = {
		    'd': $division,
		    'c':$company, 
			'r':$region,
			'delimiter':$field
	 }
	 
	 $.ajax({
		type: "POST",
		url: "live_tm_visit_metric.php",
		data: Stringnifys,
		dataType: "json",
        cache: false,		
		success: function(xhtR){
		 $("#metric_server_date").show().html(xhtR.serverdate);
		 $("#load_active_tm_modules").show().html(xhtR.activerep_tm_call);
		 $("#metric_clock_in_tm").show().html(xhtR.clockintime);
		 $("#metric_clock_out_tm").show().html(xhtR.clockouttime);
		 $("#metric_percent_covered_modules_tm").show().html(xhtR.total_tm_visited_outlet);
	   }
	});
	
	
function competition($company, $region, $field){
		
	 var Stringnifys = {
		    'c':$company, 
			'r':$region,
			'delimiter':$field
	 }	
}
	
	
}





