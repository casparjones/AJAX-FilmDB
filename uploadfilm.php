<?php
/* FilmDB (based on php4flicks) */

session_start();
// if(!isset($_SESSION['user'])){
// }

/*	uploadfilm.php - get information from import and display it. */

require_once('config/config.php');

$upload_files = dirname($_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF']).$cfg['uploads']; $upload_error = 0;

if(isset($_POST['first_time'])){
	if(@is_uploaded_file($_FILES['upload_file']['tmp_name'])){
		if($_FILES['upload_file']['error']==0){ // no error
			if($_FILES['upload_file']['type']=="text/xml"||$_FILES['upload_file']['type']=="application/xml"){ // is xml
				if($_FILES['upload_file']['size']>1000){ // > 1000 bytes
					if($_FILES['upload_file']['size']<50000){ // < 50000 bytes
						if(@move_uploaded_file($_FILES['upload_file']['tmp_name'],$upload_files)){
							if(@is_readable($upload_files)){
								$tmp = @file_get_contents($upload_files);
								if(!preg_match('#.*AJAX-FilmDB.*#', $tmp)){
									$upload_error = 95; 
								}else if(!preg_match('#<imdb>([0-9]{7})</imdb>#is', $tmp)){
									$upload_error = 96; 
								}
							}else{$upload_error = 93; }
						}else {$upload_error = 94; }
					}else {$upload_error = 2; }
				}else {$upload_error = 92; }
			}else {$upload_error = 91; }
		}else {$upload_error = $_FILES['upload_file']['error']; }
	}else {$upload_error = 4; }
?>
<html><body onLoad="parent.window.ajaxpage('importcheck.php?error=<?= $upload_error; ?>&file=<?= $_FILES['upload_file']['name']; ?>&size=<?= $_FILES['upload_file']['size']; ?>&type=<?= $_FILES['upload_file']['type']; ?>','editreqsource');"></body></html>
<?php
}else {
	exit;
}
?>