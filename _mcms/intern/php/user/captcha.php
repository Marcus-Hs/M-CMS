<?php
function prepare_captcha() {
	global $external_functions;
	$external_functions['rechen-captcha.php']	= 'rechencaptcha';
}
function do_captcha() {
	return '<label for="sc"><img src="/rechen-captcha.php"><input id="sc" type="text" name="sicherheitscode" size="5"></label>';
}
function check_captcha() {
	global $error,$sub_tpl;
	test_session(true);
	if (!empty($_POST["sicherheitscode"])) {
		$sicherheits_eingabe = encrypt($_POST["sicherheitscode"], "29hhjfkuuud921");
		$sicherheits_eingabe = str_replace("=", "", $sicherheits_eingabe);
		if(isset($_SESSION['rechen_captcha_spam']) AND $sicherheits_eingabe == $_SESSION['rechen_captcha_spam']){
			unset($_SESSION['rechen_captcha_spam']);
			return true;
		}
		if (!empty($sub_tpl['err_captcha']))
			$error['err_captcha'] = $sub_tpl['err_captcha'];
	}
	return false;
}
function rechencaptcha() {
	test_session(true);
	unset($_SESSION['rechen_captcha_spam']);
	$zahl1 = rand(10,20); //Erste Zahl 10-20
	$zahl2 = rand(1,10);  //Zweite Zahl 1-10
	$operator = rand(1,2); // + oder -

	if($operator == "1"){
	   $operatorzeichen = " + ";
	   $ergebnis = $zahl1 + $zahl2;
	}else{
	   $operatorzeichen = " - ";
	   $ergebnis = $zahl1 - $zahl2;
	}

	$_SESSION['rechen_captcha_spam'] = encrypt($ergebnis, "29hhjfkuuud921"); //Key
	$_SESSION['rechen_captcha_spam'] = str_replace("=", "", $_SESSION['rechen_captcha_spam']);


	$loc = loc('captcha.png');
	header("Content-Type: " . $loc['mimetype']);
	header("Content-Disposition: attachment;filename=\"".$loc['name']."\";");
	header("Content-Transfer-Encoding: ".$loc['encode']);
	header("Content-Length: " . filesize($file));

	$rechnung = $zahl1.$operatorzeichen.$zahl2." = ?";
	$img = imagecreatetruecolor(95,20);
	$schriftfarbe = imagecolorallocate($img,13,28,91);
	$hintergrund = imagecolorallocate($img,162,162,162);
	imagefill($img,0,0,$hintergrund);
	imagestring($img, 4, 4, 0, $rechnung, $schriftfarbe);
	imagepng($img);
	imagedestroy($img);

	return true;
 }
function encrypt($string, $key) {
	$result = '';
	for($i=0; $i<strlen($string); $i++) {
	   $char = substr($string, $i, 1);
	   $keychar = substr($key, ($i % strlen($key))-1, 1);
	   $char = chr(ord($char)+ord($keychar));
	   $result.=$char;
	}
	return base64_encode($result);
}
?>