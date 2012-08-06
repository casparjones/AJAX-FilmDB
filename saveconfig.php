<?php
/* FilmDB (based on php4flicks) */

// this is used for saving cookie prefs

require_once('config/config.php');

$expires = time()+60*60*24*365; $washere = false;
if(isset($_COOKIE['prefs'])) {
	setcookie("prefs", false, $expires);
	$washere = true;
}

$nbt = ($_GET['nbt']=='true'?1:0); $obl = ($_GET['obl']=='true'?1:0); $npl = ($_GET['npl']=='true'?1:0);
$defaults = 'language='.$_GET['lang'].':fonttype='.$_GET['ftt'].':fontsize='.$_GET['fsz'].':noofrows='.$_GET['nor'].':noofpics='.$_GET['nop'].':noofentries='.$_GET['noe'].':listheight='.$_GET['rlh'].':nobreaks='.$nbt.':noposter='.$npl.':original='.$obl;
$success = setcookie("prefs", $defaults, $expires);

if(!$success) {
	$message = $trans['cookie_error'];
	$success = false;
} else {
	if(isset($_COOKIE['prefs'])||$washere==false) {
		$message = $trans['saved_alert'];
		$success = true;
	} else {
		$message = $trans['cookie_error'];
		$success = false;
	}
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
<? if($success==false) { ?>
		<button name="ok" type="button" value="OK" style="cursor:pointer;" onClick="showRequest(false,'editreq','');">&nbsp;<b><?= $trans['b_ok']?></b>&nbsp;</button>
<? } else if($cfg['language']!=$_GET['lang'] || $cfg['fontsize']!=$_GET['fsz']){ ?>
		<a href="index.php"><button name="ok" type="button" value="OK" style="cursor:pointer;" onClick="showRequest(false,'editreq','');">&nbsp;<b><?= $trans['b_ok']?></b>&nbsp;</button></a>
<? } else { ?>
		<button name="ok" type="button" value="OK" style="cursor:pointer;" onClick="<? if($success==true){echo 'document.remember.submit();';}?>showRequest(false,'editreq','');">&nbsp;<b><?= $trans['b_ok']?></b>&nbsp;</button>
<? } ?>
	</td></tr>
</table>
