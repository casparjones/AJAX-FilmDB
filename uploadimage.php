<?php
/* FilmDB (based on php4flicks) */

session_start();
// if(!isset($_SESSION['user'])){
// }

/*	uploadimage.php - get information from import and display it. */

require_once('config/config.php');

$upload_files = dirname($_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF']).$cfg['uploads']; $upload_error = 0;

if(isset($_POST['first_time'])){
	if(@is_uploaded_file($_FILES['upload_file']['tmp_name'])){
		if($_FILES['upload_file']['error']==0){ 
			if(substr($_FILES['upload_file']['type'],0,6)=="image/"){ 
				if($_FILES['upload_file']['size']>1000){
					if($_FILES['upload_file']['size']<200000){ 
						if(@move_uploaded_file($_FILES['upload_file']['tmp_name'],$upload_files)){
							if(@is_readable($upload_files)){
								$tmp = @file_get_contents($upload_files);
								$typ = bin2hex(substr($tmp,0,4));
								if($typ=="ffd8ffe0"||$typ=="47494638"){
								}else{
									$upload_error = 90; 
								}
							}else{$upload_error = 93; }
						}else {$upload_error = 94; }
					}else {$upload_error = 2; }
				}else {$upload_error = 92; }
			}else {$upload_error = 90; }
		}else {$upload_error = $_FILES['upload_file']['error']; }
	}else {$upload_error = 4; }
?>
<html><body onLoad="parent.window.ajaxpage('getposter.php?id=<?= $_POST['pid'] ?>&err=<?= $upload_error ?>','editreqsource');"></body></html>
<?php
}else {
	exit;
}
?>