// JavaScript Document
function enableButtons(params){
	 if(params == parseInt(3)){
		$(".enables").attr("disabled","");
		$(".fxUp").attr("id","inputName");
		$(".fxq").attr("id","formInputsFiles");
	 }else{
	    $(".enables").attr("disabled","disabled");
		$(".fxUp").attr("id","inputNameDisable");
		$(".fxq").attr("id","formInputsFilesName");
	} 
}