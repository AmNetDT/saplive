// JavaScript Document
$(document).ready(function(){
	

$(".log_b").click(function(){
  
  $("#loaders").show();	
    $.ajax({
    type: "POST",
	url: "ejb/login",
	dataType: "json",
	data: $('.formUserAuth').serialize(),	
	success: function(xhtR){
	 	if(parseInt(xhtR.status)===400){
			alert(xhtR.responce);
	 	}else if(parseInt(xhtR.status)===200){
	    	window.location=xhtR.url; 
	 	}
	  $("#loaders").hide();
	 }
    });
    return false;
  
})



$('body').on('dblclick', '.secClick', function(e) {
   e.preventDefault();
    var b = $(this).attr('id');
	//var c = $(this).attr('dir');
	//var dataString =  "b="+ b + "&c=" + c; 
	var dataString =  "b="+ b;
	$.ajax({    
        type: "POST",
		url: "view/security",
		data: dataString,
		cache: false,
        success: function(msg){
			
		  new top.PopLayes({ 
           "title": "SECURITY AGENT ARRIVAL", 
           "content": msg
          });
	   
		}	
	   });
    return false;
})











})



