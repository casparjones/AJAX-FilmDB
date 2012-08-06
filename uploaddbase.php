<?php
/* FilmDB (based on php4flicks) */

session_start();
// if(!isset($_SESSION['user'])){
// }

/*	uploaddbase.php - check upload database file. */

require_once('config/config.php');

$upload_files = dirname($_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF']).$cfg['uploads']; 
$upload_error = 0;

if(isset($_POST['first_time'])){
	if(is_uploaded_file($_FILES['upload_file']['tmp_name'])){
		if($_FILES['upload_file']['error']==0){ 
			if($_FILES['upload_file']['size']>1000){ 
				if($_FILES['upload_file']['size']<$_POST['max_length']){ 
					if(move_uploaded_file($_FILES['upload_file']['tmp_name'],$upload_files)){
						if(@is_readable($upload_files)){
							if($_FILES['upload_file']['type']=="application/zip"||$_FILES['upload_file']['type']=="application/octetstream"||$_FILES['upload_file']['type']=="application/octet-stream"||$_FILES['upload_file']['type']=="application/x-zip-compressed") {
								$handle = @fopen($upload_files, "rb");
								if($handle){
									$tmp = @fread($handle,4);
									@fclose($handle);
									if($tmp!="PK\003\004") $upload_error = 95; 
								}
							}else {$upload_error = 99; }
						}else{$upload_error = 93; }
					}else {$upload_error = 94; }
				}else {$upload_error = 98; }
			}else {$upload_error = 92; }
		}else {$upload_error = $_FILES['upload_file']['error']; }
	}else {$upload_error = 4; } 
?>
<html><body onLoad="parent.window.ajaxpage('checkdbase.php?error=<?= $upload_error ?>&file=<?= $_FILES['upload_file']['name'] ?>&size=<?= $_FILES['upload_file']['size'] ?>&type=<?= $_FILES['upload_file']['type'] ?>','editreqsource');"></body></html>
<?php
}else {
	exit;
}
?>