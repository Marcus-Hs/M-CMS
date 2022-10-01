function gb_verify() {
	var verify = Math.random();
	if (document.getElementById('gb_verify')) document.getElementById('gb_verify').innerHTML ='<input type="hidden" name="verify" value="'+verify+'" />';
}
function fett() {edit("[b]","[/b]","fett");}
function italic() {edit("[i]","[/i]","italic");}
function uline() {edit("[u]","[/u]","uline");}
function vorschau(id) {
	if (id == '' || id == undefined)	id= 'gb_eintrag';
	popup('<pre>'+document.getElementById(id).value
		.replace( /\[b\](.+?)\[\/b]/gi, "<span style=\"font-weight: bolder;\">$1</span>")
		.replace( /\[u\](.+?)\[\/u]/gi, "<span style=\"text-decoration: underline;\">$1</span>")
		.replace( /\[i\](.+?)\[\/i]/gi, "<span style=\"font-style: italic;\">$1</span>")
		.replace( /\[(.+?)\]/gi, "<img src=\"/images/smilies/$1.gif\">")+'</pre>');
}
function addSmiley(id) {
	if (document.selection && document.selection.createRange().text != '') {
		document.selection.createRange().text = document.selection.createRange().text + "["+id+"]";
	} else {
		document.getElementsByTagName('textarea')[0].value += "["+id+"]";
		document.getElementsByTagName('textarea')[0].focus();
}	}
function edit(start,end,id) {
	var textfield = document.getElementsByTagName('textarea')[0];
	if (textfield.selectionStart || textfield.selectionStart == '0') {
		textfield.focus();
		var startPos = textfield.selectionStart;
		var endPos = textfield.selectionEnd;
		strSelection = start + textfield.value.substring(startPos, endPos)+ end;
		textfield.value = textfield.value.substring(0, startPos) + strSelection + textfield.value.substring(endPos, textfield.value.length);
	}
	else if (document.selection && document.selection.createRange().text != '') {
		document.selection.createRange().text = start + document.selection.createRange().text + end;
	} else {
		if (document.getElementById(id).style.color=="#aaa") {
			textfield.value += end;
			document.getElementById(id).style.color="blue";
		} else {
			textfield.value += start;
			document.getElementById(id).style.color="#aaa";
}	}	}