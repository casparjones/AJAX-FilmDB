<?php
/* FilmDB (based on php4flicks) */

// this is used for saving users file

require_once('config/config.php');

$file  ='<?php'."\n";
$file .='// define any number of users here; DO NOT DELETE the admin!'."\n";
$file .='// users[i][md5pass] must contain the md5-encrypted password'."\n";
for($i=0; $i<$_GET['cnt']; $i++){
	$file .='$cfg[\'users\']['.$i.'][\'user\'] = "'.$_GET['nm'][$i].'";'."\n";
	$file .='$cfg[\'users\']['.$i.'][\'md5pass\'] = "'.$_GET['md'][$i].'";'."\n";
}
$file .='?>'."\n";

$path = dirname($_SERVER['SCRIPT_FILENAME']);
$success = false;
if(is_writable("config/users.php")) { 
	$fp = fopen($path."/config/users.php","w");
	if($fp===false) {
		$message = $trans['saved_error'].'<small><br>[<b>config/users.php</b>]<small>';
	} else {
		$success = true;
		$message = $trans['saved_alert'];
		fputs($fp, $file);
		fclose($fp);
	}
} else {
	$message = $trans['saved_error'].'<small><br>[<b>config/users.php</b>]<small>';
}

?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/edit/k1.png" width="8" height="8" border="0"></td><td background="images/edit/k2.png"></td><td><img src="images/edit/k3.png" width="8" height="8" border="0"></td>
	</tr><tr>
		<td background="images/edit/k4.png"></td><td background="images/edit/k5.png" bgcolor="#dee3cb">
			<div ID="innereditreq"><nobr><?= $trans['the_u_list'].'</nobr>'.$message ?></div>
		</td><td background="images/edit/k6.png"></td>
	</tr><tr>
		<td><img src="images/edit/k7.png" width="8" height="8" border="0"></td><td background="images/edit/k8.png"></td><td><img src="images/edit/k9.png" width="8" height="8" border="0"></td>
	</tr>
</table>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr><td align="center">
		<button name="ok" type="button" value="OK" style="cursor:pointer;" onClick="<? if($success==true){ echo 'document.remember.submit();'; } ?>showRequest(false,'editreq','');">&nbsp;<b><?= $trans['b_ok']?></b>&nbsp;</button>
	</td></tr>
</table>

