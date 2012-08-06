<?php
/* FilmDB (based on php4flicks) */

// clearupload.php - clears the log file

session_start();
if(!isset($_SESSION['user'])){
	if($_SESSION['user']!='admin') exit;
} 

require('../config/config.php');

if(@is_writable("..".$cfg['uploads'])) { 
	// @unlink("..".$cfg['uploads']);
	$fp = @fopen("..".$cfg['uploads'],'w');
	@fwrite($fp, '');
	@fclose($fp);
	@clearstatcache();
}
?>
