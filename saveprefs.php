<?php
/* FilmDB (based on php4flicks) */

// this is used for saving prefs file

require_once('config/config.php');

$file  ='<?php'."\n";
$file .='$cfg[\'language\'] = "'.$_GET['lang'].'";'."\n";
$file .='$cfg[\'noofrows\'] = '.$_GET['nor'].";\n";
$file .='$cfg[\'noofpics\'] = '.$_GET['nop'].";\n";
$file .='$cfg[\'noofentries\'] = '.$_GET['noe'].";\n";
$file .='$cfg[\'listheight\'] = '.$_GET['rlh'].";\n";
$file .='$cfg[\'use_progress\'] = '.$_GET['upb'].";\n";
$file .='$cfg[\'use_blob\'] = '.$_GET['ubi'].";\n";
$file .='$cfg[\'nobreaks\'] = '.$_GET['nbt'].";\n";
$file .='$cfg[\'original\'] = '.$_GET['obl'].";\n";
$file .='$cfg[\'noposter\'] = '.$_GET['npl'].";\n";
$file .='?>'."\n";

$path = dirname($_SERVER['SCRIPT_FILENAME']);
$success = false;
if(is_writable("config/prefs.php")) { 
	$fp = fopen($path."/config/prefs.php","w");
	if($fp===false) {
		$message = $trans['saved_error'].'<small><br>[<b>config/prefs.php</b>]<small>';
	} else {
		$message = $trans['saved_alert'];
		$success = true;
		fputs($fp, $file);
		fclose($fp);
	}
} else {
	$message = $trans['saved_error'].'<small><br>[<b>config/prefs.php</b>]<small>';
}

?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/edit/k1.png" width="8" height="8" border="0"></td><td background="images/edit/k2.png"></td><td><img src="images/edit/k3.png" width="8" height="8" border="0"></td>
	</tr><tr>
		<td background="images/edit/k4.png"></td><td background="images/edit/k5.png" bgcolor="#dee3cb">
			<div ID="innereditreq"><nobr><?= $trans['the_prefs'].'</nobr>'.$message ?></div>
		</td><td background="images/edit/k6.png"></td>
	</tr><tr>
		<td><img src="images/edit/k7.png" width="8" height="8" border="0"></td><td background="images/edit/k8.png"></td><td><img src="images/edit/k9.png" width="8" height="8" border="0"></td>
	</tr>
</table>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr><td align="center">
<? if($cfg['language']==$_GET['lang']||$cfg['use_blob']==$_GET['ubi']){ ?>
		<button name="ok" type="button" value="OK" style="cursor:pointer;" onClick="<? if($success==true){echo 'document.remember.submit();';}?>showRequest(false,'editreq','');">&nbsp;<b><?= $trans['b_ok']?></b>&nbsp;</button>
<? } else { ?>
		<a href="index.php"><button name="ok" type="button" value="OK" style="cursor:pointer;" onClick="showRequest(false,'editreq','');">&nbsp;<b><?= $trans['b_ok']?></b>&nbsp;</button></a>
<? } ?>
	</td></tr>
</table>

