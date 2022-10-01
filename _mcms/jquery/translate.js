function do_translate_all(from,to) {
	$('.transate textarea').each(function(){
		do_translate('#'+this.id,from,to);
	});
}
function do_translate(id,from,to) {
	var callbackFunctions = {
		success: function(data,status) {
			 $(id).val(data);
		 }
	}
	$.bingTranslate('F89645182DA919100430CA6600F0E26126C8B9C0',$(id).val(),from,to,callbackFunctions);
}

jQuery.bingTranslate = function(BingAppId, textToTranslate, fromLanguage, toLanguage,callbackFunctions) {
	var data = {
		appid   : BingAppId,
		to      : toLanguage,
		from    : fromLanguage,
		text    : textToTranslate
	};
	var defaultCallbacks = {
		success  : function(data, status) {
						jQuery.log('success (status: '+status+')');
						jQuery.log('data: '+data);
					}
	}
	callbackFunctions = jQuery.extend({}, defaultCallbacks, callbackFunctions);

	jQuery.ajax({
			url             : 'http://api.microsofttranslator.com/V2/Ajax.svc/Translate',
			data            : data,
			dataType        : 'jsonp',
			jsonp           : 'oncomplete',
			jsonpCallback   : callbackFunctions.jsonpCallback,
			success         : callbackFunctions.success,
			complete        : callbackFunctions.complete,
			error           : callbackFunctions.error
	});
}