<?php
include "config.php";
include "session.php";

if($user_login == 'ok'){
	include "functions.php";
?>
<html>
	<head>
		<meta name="viewport" content="width=device-width, minimum-scale=0.75, initial-scale=1">
		<title>Rename</title>
	</head>
	<body>
	<script language="javascript">
	<?php
	if($_POST['o'] != $_POST['n']){
		if(rename($_POST['cf'].'/'.$_POST['o'], $_POST['cf'].'/'.$_POST['n'])){
			if($_POST['t'] == 'd'){
				echo "alert('Ordner wurde umbenannt von \"{$_POST['o']}\" in \"{$_POST['n']}\"');";
			}else{
				echo "alert('Datei wurde umbenannt von \"{$_POST['o']}\" in \"{$_POST['n']}\"');";
			}
		} else{
			echo "alert('Fehler beim Umbenennen'); window.parent.location.href = window.parent.location.href;";
	}	}
	?>
	</script>
	</body>
</html>
<?php
}
?>