<?php
/* FilmDB (based on php4flicks) */

/* clearupload.php - clears the upload file */

session_start();
if(!isset($_SESSION['user'])) exit;
if($_SESSION['user']!='admin') exit;

require('config/config.php');

$file = dirname($_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF']).$cfg['uploads'];

if(@is_writable($file)) { 
	$fp = @fopen($file,'w');
	@fwrite($fp, '');
	@fclose($fp);
	@clearstatcache();
}
?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/edit/k1.png" width="8" height="8" border="0"></td><td background="images/edit/k2.png"></td><td><img src="images/edit/k3.png" width="8" height="8" border="0"></td>
	</tr><tr>
		<td background="images/edit/k4.png"></td><td background="images/edit/k5.png" bgcolor="#dee3cb">
			<div ID="innereditreq"><?= $trans['the_file'].'<nobr><h4><b>upload.tmp</b></h4></nobr>'.$trans['cleared_alert'] ?></div>
		</td><td background="images/edit/k6.png"></td>
	</tr><tr>
		<td><img src="images/edit/k7.png" width="8" height="8" border="0"></td><td background="images/edit/k8.png"></td><td><img src="images/edit/k9.png" width="8" height="8" border="0"></td>
	</tr>
</table>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr><td align="center">
		<button name="ok" type="button" value="OK" onClick="showRequest(false,'editreq','');"><b><?= $trans['b_ok']?></b></button>
	</td></tr>
</table>