if (top.location != self.location) {top.location = self.location.href;}
var id = '';
var upsize  = new Array();
var upcount = 1;
if ($('meta').attr('charset') == 'utf-8')	var utf8 = true;
else										var utf8 = false;
var togx = new Array();

$(function() {
	$("form input[type=submit]").click(function() {
//		var scrollPosition = $(window).scrollTop();
//		localStorage.setItem("scrollPosition", scrollPosition);
		$("input[type=submit]", $(this).parents("form")).removeAttr("clicked");
		$(this).attr("clicked", "true");
	});
	if ($(document).width()<760)			$('.toggle_visible').removeClass('toggle_visible');
	if ($('textarea').length>0)				build_textareas();
//   if(localStorage.scrollPosition) {
//		$(window).scrollTop(localStorage.getItem("scrollPosition"));
//   }
	if ($("*[maxlength]").length>0)			lengthInit();
	if ($('#cloud').length>0)				domore();
	if ($('#move_tr').length>0)				move_tr();
	document.addEventListener("keydown", function(e) {process_keypress(e)});
	$(".trigger").on('click',function()  {mod_session(this.id);});
	if ($('input[type=file]').length>0)		process_uploads();
	init_togs();
	if (typeof tooltip === "function" && $('.tooltip').length>0)	$('.tooltip, #cloudtext a').tooltip({track: true, delay: 0, showURL: false, showBody: " - ", fade: 250,top:10 });
});
function init_togs() {
	$('.tog_chk').click(function() {
		var x = $(this).attr('class').split(' ')[1];
		if ($("input.chk."+x).is(":checked"))	$("input.chk."+x).prop("checked",false);
		else									$("input.chk."+x).prop("checked",true);
	});
	$('.tog_chkx').click(function() {
		var x = $(this).attr('class').split(' ')[1];
		if ($("input.chkx."+x).is(":checked"))	$("input.chkx."+x).prop("checked",false);
		else if (confirm("%%GANZ_SICHER%%"))	$("input.chkx."+x).prop("checked",true);
	});
	$('.tog_chky').click(function() {
		var x = $(this).attr('class').split(' ')[1];
		if (!$("input.chky."+x).is(":checked"))	$("input.chky."+x).prop("checked",true);
		else if (confirm("%%GANZ_SICHER%%"))	$("input.chky."+x).prop("checked",false);
	});
	$('.tog_sel').click(function() {
		if (confirm("%%GANZ_SICHER%%")) {
			var x = $(this).attr('class').split(' ')[1];
			var val = $('select.'+x+' option:checked').val();
			$('select.'+x+' option[value="'+val+'"]').prop("selected", true);
		}
	});
	$('.tog_txt').click(function() {
		if (confirm("%%GANZ_SICHER%%")) {
			var x = $(this).attr('class').split(' ')[1];
			$("input."+x).val($("input."+x+":first").val());
		}
	});
}
function process_keypress(e) {
	c = e.which ? e.which : e.keyCode;
	if ((c == 115 || c == 19 || c == 83) && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
		e.preventDefault();
		$('<input />').attr('type', 'hidden').attr('name', 'send').attr('value', 1).appendTo($("form").last());
		$("form").last().submit();
		return false;
}	}
function process_uploads() {
	var mfs = $('#max_file_size').val();
	var mfu = $('#max_file_uploads').val();
	$(document).on('change', 'input[type=file]', function() {
		var id = $(this).attr('id');
		$(this).addClass('uploadintent');
		upcount = $('.uploadintent').length;
		if (upcount > 1 && upcount > mfu)	{
			alert('%%ZU_VIELE_UPLOADS%%' .replace('#UPCOUNT#',upcount).replace('#MFU#',mfu));
			file_input(id);
		} else if (window.File && window.FileReader && window.FileList && this.files[0] != undefined) {
			var file = this.files[0];
			upsize[id]= file.size;
			uptotal = 0;
			for (key in upsize) {uptotal += upsize[key];}
			if	(uptotal > mfs) {
				alert('%%UPLOAD_ZU_GROSS%%' .replace('#SIZE#',bytesToSize(uptotal)).replace('#ALLOWED#','#MFS#').replace('#MFS#',bytesToSize(mfs)));
				file_input(id);
			} else {
				var fileTypes = ['webp', 'jpg', 'jpeg', 'png', 'gif'];  //acceptable file types
				var ext = file.name.split('.').pop().toLowerCase(),  //file extension from input file
				isSuccess = fileTypes.indexOf(ext) > -1;  //is extension in acceptable types
				if (file.size < 5000000 || confirm('%%DATEI_SEHR_GROSS%%'.replace('#SIZE#',bytesToSize(file.size)))) {
					var reader = new FileReader();
					var part_id = id.split('_').pop();
					reader.onload = function (event) {
						var name = id.split('_bild_')[0];
						var nbr = name.match(/\d+/g);
						if (nbr == null) nbr = '';
						if (imgtitlerpl != null &&  imgtitlerpl != '0') {
							var tid = id.replace(name+'_bild_',imgtitlerpl+nbr+'_');
							if ($('#'+tid).length>0 && $('#'+tid).val()=='')	$('#'+tid).val(file.name.replace('.'+ext,''));
						}
						src = event.target.result;
						file_input(id,file.size);
						var name = urldecode(file.name)
						var html = '<div class="admin_bild small" id="newimg_'+id+'" style="margin:6px 0 10px 0">'+
										'<em title="%%DATEI_DURCH_DIESE_ERSETZEN%%">%%UPLOAD%%</em>'+
										'<input type="hidden" id="size_'+id+'" value="'+file.size+'" /><br />';
						if (ext == 'webp' || ext == 'jpg' || ext == 'jpeg' || ext == 'png' || ext == 'gif') {
							var fname = id.toLowerCase().split('_');
							if (fname[1]!==undefined)	subkey = fname[0]+'_'+fname[1];
							else						subkey = fname[0];
							html += '<input type="hidden" class="data_url" name="data_url['+part_id+']['+subkey+'][Dateiname]" value="'+name+'" />';
							html += '<input type="hidden" class="data_url" name="data_url['+part_id+']['+subkey+'][data_url]" value="'+src+'" />';
							var img = new Image();
							img.src = src;
					/*		var canvas = $( '<canvas id="tmp_canvas" width="150" />');
							var context = canvas[0].getContext('2d');
							var maxWidth = 450;
							var maxHeight = 300;
							if (context) {
								var ratio = 1;
								if		(img.width  > maxWidth)		ratio = maxWidth / img.width;
								else if (img.height > maxHeight)	ratio = maxHeight / img.height;
								canvas[0].width  = img.width  * ratio;
								canvas[0].height = img.height * ratio;
								context.drawImage(img,0,0,canvas[0].width,canvas[0].height);
								src = canvas[0].toDataURL("image/jpeg");
								$('#tmp_canvas').remove();
							}
					*/		html += '<a class="lb tooltip" href="'+src+'" target="_blank" title="'+name+' - '+img.width+'px x '+img.height+'px"><img id="nimg_'+part_id+'" src="'+src+'" alt="" title="'+name+' - '+img.width+'px x '+img.height+'px" /></a>';
					//		html += '<a class="lb tooltip" href="'+src+'" target="_blank" title="%%PREVIEW%% - '+name+' - '+img.width+'px x '+img.height+'px">'+name+'</a> ('+bytesToSize(file.size)+')';
					//		html += '<br /><a class="tooltip" onclick="fckaddpart(\'nimg_'+part_id+'\',\''+name+'\')" title="%%IN_TEXT_EINFUEGEN%%">'+name+'</a> ('+bytesToSize(file.size)+')';
						} else if (ext != 'mp4' || ext != 'm4v' || ext != 'avif' || ext != 'webp' || ext != 'webm' || ext != 'ogg'){
							html += '<a class="tooltip" href="'+src+'" target="_blank" title="%%PREVIEW%% - '+name+'">'+name+'</a> ('+bytesToSize(file.size)+')';
						}
						html += '<a href="javascript:" onclick="file_input(\''+id+'\');return false;" class="tooltip red flr" title="%%DATEI_NICHT_HOCHLADEN%%">%%ENTFERNEN%%</a></div>'
						$('#newimg_'+id).remove();
						$('#'+id).after(html);
						if (typeof tooltip === "function" && $('.tooltip').length>0) $('#newimg_'+id+' em, #newimg_'+id+' a, #newimg_'+id+' img').tooltip({track: true, delay: 0, showURL: false, showBody: " - ", fade: 250,top:10 });
						$('.admin_bild #newimg_'+id+' .lb').magnificPopup({type:'image',titleSrc:'title',gallery:{enabled:true}});
					}
					if (isSuccess)	reader.readAsDataURL(file);
				} else {file_input(id);}
		}	}
	});
}
function urldecode(url) {
  return unescape(url.replace(/\+/g, ' '));
}
function bytesToSize(bytes,dec) {
	var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
	if (bytes == 0) return 'n/a';
	if (dec==undefined) dec = 100;
	else				dec = 10^dec
	var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
	return Math.round(bytes*dec / Math.pow(1024, i))/dec + ' ' + sizes[[i]];
};
function file_input(id,size) {
	if (size == undefined) {
		$('#newimg_'+id).remove();
		$('#'+id).replaceWith("<input type='file' id='"+id+"' name='"+$('#'+id).attr('name')+"' />");
	}
};
function mod_session(id) {
	var id = id.replace('trigger','toggle');
	if ($('.'+id).length>0) id = '.'+id;
	else					id = '#'+id;
	var display = $(id).css('display');
	if (display != 'none')	{show = false;	$(id).hide();}
	else					{
		show = true;	$(id).show();
		var display = $(id).css('display');
		if (typeof autogrow === "function") {
			$(id+' textarea').each(function(){$(this).autogrow();});
		}
	}
	var PHPSESSID = $('#PHPSESSID').val();
	url = '/mod_session.php?field=addstyles&id=' + id.replace('#','') + "&show=" + show +"&display=" + display + "&PHPSESSID=" + PHPSESSID;
	$.ajax({url: url, cache: false});
}
function build_textareas() {
	if ($('.codemirror').length>0)	do_codemirror();
	if ($('.fck, .fck2, .fck3').length>0)	do_fck();
	else 							$('textarea').filter(":visible").autogrow();
}
function do_fck() {
	if ($('#PHPSESSID').length>0  && $('#PHPSESSID').val() != '')	PHPSESSID	 = $('#PHPSESSID').val();
	else															PHPSESSID	 = '';
	if ($('#ta_direction').val()!='ltr') 							var ta_class = ck_config['BodyClass'] + ' ' + $('#ta_direction').val();
	else															var ta_class = ck_config['BodyClass'];
	if ($('#ta_height').length>0 && $('#ta_height').val() != '') 	var ta_height = $('#ta_height').val();
	else															var ta_height = '600';

	if ($('html').attr('lang').length>0 && $('html').attr('lang') != 'de' && $('html').attr('lang') != 'ch') 	var lang = 'en';
	else																										var lang = 'de';
	var config = {
		language: $('html').attr('lang'),
		removePlugins: 'elementspath,liststyle,tableselection,scayt,exportpdf',
		docType : '<!DOCTYPE html>',
		filebrowserBrowseUrl: 		'admin/file_manager/file_manager.php?f=d&PHPSESSID='+PHPSESSID, // 'admin//JASFinder/index.html', //
		filebrowserImageBrowseUrl: 	'admin/file_manager/file_manager.php?f=i&PHPSESSID='+PHPSESSID,
	//	filebrowserImageBrowseUrl:	'admin/ImageManager/manager.php?PHPSESSID='+PHPSESSID,
		filebrowserImageWindowWidth:  '800',
		filebrowserImageWindowHeight: '600',
		disableContextMenu:	true,
		autoGrow_onStartup:	false,
		linkShowAdvancedTab:true,
		allowedContent : true,
		bodyClass:			ta_class,
		contentsCss:		ck_config['CSS'],
		defaultLanguage:	lang,
		dialog_noConfirmCancel: true,
		entities:	false,
		height:		ta_height,
		toolbar:	ck_config['ToolbarSet_1'],
		startupOutlineBlocks:ck_config['StartupShowBlocks'],
//		stylesSet: 'styles:../../ck_styles',
		format_tags: ck_config['FontFormats'],
		tabSpaces: 4,
		justifyClasses: [ 'left', 'center', 'right', 'justify' ],
		extraPlugins : 'justify,floatpanel,panelbutton,colorbutton,codemirror',
		colorButton_colors : ck_config['colorButton_colors'],
		image_previewText: CKEDITOR.tools.repeat( '&middot; ', 400 )
	};
	$( '.fck' ).each(function() {
		var id = $(this).attr('id');
		if ($('#id_'+id).val()	 != undefined)	config.bodyId = $('#id_'+id).val();
		else									config.bodyId = ck_config['BodyId'];
		$( '#'+id ).ckeditor(function(e){upd_dc(e.id);},config);
	});
	var config2 = config;
	$( '.fck2, .fck3').each(function() {
		var id = $(this).attr('id');
		if ($('#height_'+id).length>0 && $('#height_'+id).val() != '')	config2.height 	= $('#height_'+id).val();
		else															config2.height 	= '150';
		if ($('#class_'+id).val()!= undefined)							config2.bodyClass = ta_class + ' ' + $('#class_'+id).val();
		else															config2.bodyClass = ta_class;
		if ($(this).attr('class')=='fck2')	config2.toolbar = ck_config['ToolbarSet_2'];
		else								config2.toolbar = ck_config['ToolbarSet_3'];	
		$( '#'+id ).ckeditor(config2);
	});
	for (var i in CKEDITOR.instances) {
		CKEDITOR.instances[i].on('change',function(){
      upd_dc(i);
      $('form').addClass('dirty');
      });
	}
	if (typeof autogrow === "function") {
		$('textarea').not('.fck, .fck2, .fck3').filter(":visible").autogrow().tabby();
	}
}
function do_codemirror() {
	var config = {
		extraPlugins: 'codemirror',
		autoGrow_onStartup:	true,
		showFormatButton: false,
		styleActiveLine: false, 
		toolbar: 'codemirror',
		startupMode : 'source',
		removePlugins: 'elementspath,scayt,exportpdf'
	};
	$('.codemirror').each(function(){
		config.height = 1.3*$(this).prop('scrollHeight');
		$(this).ckeditor(config);
	});
}
function move_tr() {
	$("#move_tr").tableDnD({onDrop: reorder	});
	$('table tbody a.control').on('click', function (e) {
		e.preventDefault();
		var tr = $(this).closest('tr'); // This allows the TR element itself to be the control if desired
		var iterations = 0;
		if ($(this).attr('rel') == 'up' && tr.prev().length) {
			tr.fadeTo('medium', 0.1, function () {
				tr.insertBefore(tr.prev()).fadeTo('fast', 1);
				reorder();
			});
		} else if ($(this).attr('rel') == 'down' && tr.next().length) {  // Same as above only this is for moving elements down instead of up
			tr.fadeTo('fast', 0.1, function () {
				tr.insertAfter(tr.next()).fadeTo('fast', 1);
				reorder();
			});
		}
		return false;
	});
}
if ($('input.pos').length && $('input.pos').first().val()!='' && $('input.pos').first().val()!=0)	var position = $('input.pos').first().val();
else if ($('input.pos').first().val()=='')						var position = $('input.pos:eq(1)').val();
else															var position = 1;
function reorder() {
	var pos = position;
	if (pos == 0) pos++;
	$('.sortTable>tbody>tr').each(function () {
		if ($('#'+this.id+'_position').val()!='') $('#'+this.id+'_position').val((pos++));
	});
}
function domore() {
	$('#ueberschrift').on("keyup", upd_dc);
	$('#beschreibung').on("keyup", upd_dc);
	$('#Titel').on("keyup", upd_dc);
	if ($('input[type="date"]').length>0) {
		var i = document.createElement("input");
		i.setAttribute("type", "date");
		if (i.type == "text") {
			$("input[type='date']").each(function(){
			  var name = $(this).attr('name'); 	// grab name of original
			  var value = $(this).attr('value');// grab value of original
			  var html = '<input type="text" class="date-pick" name="'+name+'" value="'+value+'" />';	  /* create new visible input */
			  $(this).after(html).remove(); // add new, then remove original input
			});
			Date.format = 'yyyy-mm-dd';
			$('.date-pick').datePicker({startDate:'1990-01-01'});
	}	}
	if ($('input[type="color"]').length>0) {
		var i = document.createElement("input");
		i.setAttribute("type", "color");
		if (i.type == "text") {
			$('input[type="color"]').spectrum({
				showPalette: true,
				showSelectionPalette: true,
				palette: [ ],
				localStorageKey: "spectrum.homepage",
				showInput: true,
				showAlpha: true,
				clickoutFiresChange: true,
				showInitial: true,
				preferredFormat: "hex",
			});
}	}	}
function FCKeditor_OnComplete(editorInstance) {
	if (editorInstance.Events.addEventListener)	{
		editorInstance.Events.addEventListener('OnSelectionChange', upd_dc);
		editorInstance.Events.addEventListener('OnPaste', upd_dc);
	} else {
		editorInstance.Events.AttachEvent('OnSelectionChange', upd_dc);
		editorInstance.Events.AttachEvent('OnPaste', upd_dc);
	}
	upd_dc(editorInstance);
}
function upd_dc(id) {
	for (var i in CKEDITOR.instances) {
 		CKEDITOR.instances[i].updateElement();
		$(i).attr("value",CKEDITOR.instances[i].getData());
	}
	$('.btn.preview, .card.preview').css('visibility','visible');
	if ($('#cloudtext').length>0) {
		cloudtext = $('#'+id).val();
		if ($('#ueberschrift').length>0)	cloudtext += $('#ueberschrift').val();
		if ($('#beschreibung').length>0)	cloudtext += ' '+$('#beschreibung').val();
		if ($('#Titel').length>0)			cloudtext += ' '+$('#Titel').val();
		$('#cloudtext').html(cloudtext);
		$("#cloudtext").dynaCloud('#cloud');
		if (typeof tooltip === "function")
			$('#cloud a').tooltip({track: true, delay: 0, showURL: false, showBody: " - ", top:-30 });
}	}
function fckfind(highlight) {
	if (highlight!='') {
		var r = new RegExp(highlight, "g");
	//	$('#beschreibung').caret(r); $('#ueberschrift').caret(r); $('#Menu').caret(r); $('#Titel').caret(r);
		var html = $('#textarea').val().replace(/<font[^>]*>/ig,'')
									   .replace(r,'<font style="color:#fff;background-color:navy">'+highlight+'</font>');
		$('#textarea').val(html);
}	}
function fckaddpart(id,name) {
	var src = $('#'+id).attr('src');
	if (src != undefined) {
		if (name == undefined)	name='';
		CKEDITOR.instances.textarea.insertHtml('<img src="'+src+'" alt="'+name+'" />');
}	}
function lengthInit(){
	$("*[maxlength]").each(function() {
		var obj = $(this);
		var id	 = obj.attr('id');
		if ($('#ta_'+id).length==0 && obj.attr('class') != 'fck' && obj.attr('maxlength') < 10240){
			obj.keyup(function(event) {maxLength($(this));});
			obj.after('<span style="float:right;clear:right;font-size:.8rem;" id="ta_'+id+'">('+obj.val().length+'/'+obj.attr('maxlength')+')</span>');
		}
	});
}
function maxLength(o2){
	var id2	= o2.attr('id');
	var maxLength = parseInt(o2.attr('maxlength'));
	var str	= o2.val();
	l = str.length - lineBreakCount(str);
	if(l > maxLength){
		o2.val(str.substring(0,maxLength));
		alert('%%MAXZEICHEN%%'.replace('#MAXLENGTH#',maxLength));
	}
	$('#ta_'+id2).html('('+l+'/'+maxLength+')');
}
function lineBreakCount(str){
	try			{return((str.match(/[^\n]*\n[^\n]*/gi).length));}
	catch(e)	{return 0;}
}
function clean_submit() {
//	if ($("input[type=submit]").attr("clicked") )
	$('.data_url').remove();
	$('form').removeClass('dirty');
	$('input[type=file]').each(function() {
		if ($(this).val()==undefined || $(this).val()=='') {$(this).remove();}
	});
}
$("a.preview, .preview>a").click(function (e) {
	if (e.shiftKey) {
		url = '/process_preview.php?PHPSESSID='+$('#PHPSESSID').val();
		form =  $("form").serializeArray();
		$.ajax({
			type: "POST",
			data : form,
			cache: false,
			url: url,
			traditional: true,
			success: function(result) {
				preview_window = window.open('vorschau.php?page_id='+$('#page_id').val()+'&PHPSESSID='+$('#PHPSESSID').val(),"Vorschau","toolbar=no,width=1000,height=750,directories=no,scrollbars,status=no,menubar=no,resizable=yes");
				preview_window.focus();
			}
		});
	} else {
		vorschau();
	}
	return false;
});
function vorschau() {
	if ($('#order_by').length)				var order_by		= $('#order_by').val();
	else									var order_by		= '';
	if ($('#tpl_id').length)				var tpl_id			= $('#tpl_id').val();
	else									var tpl_id			= $('#tpl_id2').val();
	if ($('.fck').length>0 )				var text			= $('.fck').val();
	else if ($('.fck3').length>0 )			var text			= $('.fck3').val();
	if ($('#ueberschrift').length>0 )		var ueberschrift	= $('#ueberschrift').val().replace(/"/g,'&amp;quot;');
	else if ($('.ueberschrift').length>0 )	var ueberschrift	= $('.ueberschrift').val().replace(/"/g,'&amp;quot;');
	else									var ueberschrift	= '';
	if ($('#beschreibung').length>0 )		var beschreibung	= $('#beschreibung').val().replace(/"/g,'&amp;quot;');
	else									var beschreibung	= '';
	if ($('#Menu').length>0 )				var Menu			= $('#Menu').val().replace(/"/g,'&amp;quot;');
	else									var Menu			= '';
	if ($('#Titel').length>0 )				var Titel			= $('#Titel').val().replace(/"/g,'&amp;quot;');
	else if ($('.Titel').length>0 )			var Titel			= $('.Titel').val().replace(/"/g,'&amp;quot;');
	else									var Titel		 	= '';
//	$('.data_url').remove();
	vorschau_window = window.open('',"Vorschau","toolbar=no,width=1000,height=750,directories=no,scrollbars,status=no,menubar=no,resizable=yes");
	vorschau_window.document.writeln('<html><head><title>Vorschau</title></head><body onload="document.vorschau.submit();return true;">');
	vorschau_window.document.writeln('<form style="display:none" action="vorschau.php?PHPSESSID='+$('#PHPSESSID').val()+'" method="post" name="vorschau" id="vorschau">');
	vorschau_window.document.writeln('<input name="page_id"		value="'+$('#page_id').val()+'" />');
	vorschau_window.document.writeln('<input name="parent_id"	value="'+$('#parent_id option:selected').val()+'" />');
	vorschau_window.document.writeln('<input name="lang_id"		value="'+$('#lang_id').val()+'" />');
	vorschau_window.document.writeln('<input name="tpl_id"		value="'+tpl_id+'" />');
	vorschau_window.document.writeln('<input name="order_by"	value="'+order_by+'" />');
	vorschau_window.document.writeln('<input name="Ueberschrift" value="'+component(ueberschrift)+'" />');
	vorschau_window.document.writeln('<input name="Beschreibung" value="'+component(beschreibung)+'" />');
	vorschau_window.document.writeln('<input name="Menu"		value="'+component(Menu)+'" />');
	vorschau_window.document.writeln('<input name="Titel"		value="'+component(Titel)+'" />');
	vorschau_window.document.writeln('<textarea name="text" style="width:100%;height:25%">'+component(text)+'</textarea>');
	if ($('#vorlage').length>0) {
		$('#vorlage textarea[name]').each(function(i) {
			if (this.value != '') {
				if (this.className == 'fck2') this.value = fckUpdated(this.id,false);
				if (this.value.replace(/[\r\n]+/g,'')!='<p><br /></p>') vorschau_window.document.writeln('<textarea style="width:100%;height:100px" name="'+this.name+'">'+component(this.value)+'</textarea>');
			}
		});
		$('#vorlage select[name]').each(function(i) {
			if ($(this).val() != '') vorschau_window.document.writeln('<input name="'+$(this).attr('name')+'" value="'+$(this).val()+'" />');
		});
		$('#vorlage input[name]').each(function(i) {
			var type = $(this).attr('type');
			if ($(this).attr('checked') || (type != 'submit' && type != 'checkbox' && $(this).val() != '')) vorschau_window.document.writeln('<input name="'+$(this).attr('name')+'" value="'+component($(this).val())+'" />');
		});
	}
	vorschau_window.document.writeln('</form></body></html>');
	vorschau_window.document.close();
	vorschau_window.focus();
}
function component(data) {
	if (utf8)	data = encodeURIComponent(data);
	else		data = escape(data);
	return data;
}
function fckUpdated(ta,format) {
	return $('#'+ta).val();
}
function addslashes(str) {
	return str.replace(/\\/g,'\\\\').replace(/\'/g,'\\\'').replace(/\"/g,'\\"').replace(/\0/g,'\\0');
}
function stripslashes(str) {
	return str.replace(/\\'/g,'\'').replace(/\\"/g,'"').replace(/\\0/g,'\0').replace(/\\\\/g,'\\');
}
function confirmSubmit() {
	var agree=confirm("%%GANZ_SICHER%%");
	if (agree) 	return true ;
	else 		return false ;
}
function page_remove(id) {
	var reply = confirm("%%GANZ_SICHER%%");
	if(reply) 	window.location.href = $('#'+id).attr('href');
}
function changelink(id,name,target) {
	var obj = $('#'+id+' option:selected');
	var new_id = obj.val();
	if (target==undefined) {
		if (id.indexOf('_tpl')>0)	target = 'page=2_templates&amp;tmpl[TPL_ID]';
		else						target = 'page=1_pages&pages[PAGE_ID]';
	}
	if (name==undefined)	name = obj.text().replace(/-/,'');
	$('#link_'+id).html(' <a id="link_'+id+'" href="/login.php?'+target+'='+new_id+'&PHPSESSID='+$('#PHPSESSID').val()+'" class="tooltip" title="%%BEARBEITEN%%">'+name+'</a>');
}
function BrowseServer(txtUrl) {
	window.open( 'admin/file_manager/file_manager.php' + '?PHPSESSID='+$('#PHPSESSID').val()+'&txtUrl='+txtUrl, 'ServerBrowseWindow', "toolbar=no,width=700,height=500,directories=no,scrollbars,status=no,menubar=no,resizable=yes") ;
}
function BrowseLinks(txtUrl) {
	window.open( 'alleseiten.php' + '?PHPSESSID='+$('#PHPSESSID').val()+'&txtUrl='+txtUrl, 'LinksBrowseWindow', "toolbar=no,width=300,height=200,directories=no,scrollbars,status=no,menubar=no,resizable=yes") ;
}
jQuery.fn.filterByText = function(textbox) {
	return this.each(function() {
		var select = this;
		var options = [];
		$(select).find('option').each(function() {options.push({value: $(this).val(),
																text: $(this).text(),
																title: $(this).attr('title'),
																label: $(this).attr('label'),
																selected: $(this).attr('selected')});});
		$(select).data('option', options);
		$(textbox).on('change keyup', function() {
			var options = $(select).empty().data('option');
			var search = $.trim($(this).val());
			var regex = new RegExp(search,"gi");
			$.each(options, function(i) {
				var option = options[i];
				if(option.text.match(regex) !== null) {
					$(select).append($('<option>').text(option.text).val(option.value).attr('label',option.label).attr('title',option.title).attr('selected',option.selected));
}	});	});	});	};