$(document).ready(function (e) {
    /* demo samples */
    $('.demo').autoNumeric('init');
	
    $('.adkeydemo').bind('blur focusout keypress keyup', function () {
        var demoGet = parseFloat($(this).autoNumeric('get'));
		var comdemo = parseFloat($('#comdemo').autoNumeric('get'));
		var asdemon = parseFloat($('#asdemon').autoNumeric('get'));
		var casdemo = parseFloat($('#casdemo').autoNumeric('get'));
		var sunretu = casdemo + demoGet;
		var sum     = sunretu-comdemo-asdemon;
        $('.sumdemo').autoNumeric('set',sum);
    });
	
	
	$('#comdemo').bind('blur focusout keypress keyup', function () {
        var demoGet = parseFloat($('.adkeydemo').autoNumeric('get'));
		var comdemo = parseFloat($(this).autoNumeric('get'));
		var asdemon = parseFloat($('#asdemon').autoNumeric('get'));
		var casdemo = parseFloat($('#casdemo').autoNumeric('get'));
		var sunretu = casdemo + demoGet;
		var sum     = sunretu-comdemo-asdemon;
        $('.sumdemo').autoNumeric('set',sum);
    });
	
	
	$('#asdemon').bind('blur focusout keypress keyup', function () {
        var demoGet = parseFloat($('.adkeydemo').autoNumeric('get'));
		var comdemo = parseFloat($('#comdemo').autoNumeric('get'));
		var asdemon = parseFloat($(this).autoNumeric('get'));
		var casdemo = parseFloat($('#casdemo').autoNumeric('get'));
		var sunretu = casdemo + demoGet;
		var sum     = sunretu-comdemo-asdemon;
        $('.sumdemo').autoNumeric('set',sum);
    });
	
	
	$('#casdemo').bind('blur focusout keypress keyup', function () {
        var demoGet = parseFloat($('.adkeydemo').autoNumeric('get'));
		var comdemo = parseFloat($('#comdemo').autoNumeric('get'));
		var asdemon = parseFloat($('#asdemon').autoNumeric('get'));
		var casdemo = parseFloat($(this).autoNumeric('get'));
		var sunretu = casdemo + demoGet;
		var sum     = sunretu-comdemo-asdemon;
        $('.sumdemo').autoNumeric('set',sum);
    });
	

});