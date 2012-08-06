<?php
/* FilmDB (based on php4flicks) */

// this is used for saving lending data

require_once('config/config.php');

$fid = (isset($_GET['fid'])?$_GET['fid']:'');
$id = (isset($_GET['id'])?$_GET['id']:'');
$nx = (isset($_GET['nx'])?$_GET['nx']:'0');
$avail = (isset($_GET['avail'])?$_GET['avail']:'1');
$lentsince = (isset($_GET['lentsince'])?$_GET['lentsince']:'0000-00-00');
$lentto = (isset($_GET['lentto'])?$_GET['lentto']:'0');

$success = false;
$message = $trans['not_saved'];
if(isset($fid)&&isset($id)) {
	$result = mysql_query('UPDATE movies SET avail=\''.$avail.'\', lentsince=\''.$lentsince.'\', lentto=\''.$lentto.'\' WHERE fid=\''.$fid.'\'') or die(mysql_error());
	if(isset($result)&&$result==1) {
		$success = true;
		$message = $trans['saved_alert'];
	}
}

?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/edit/k1.png" width="8" height="8" border="0"></td><td background="images/edit/k2.png"></td><td><img src="images/edit/k3.png" width="8" height="8" border="0"></td>
	</tr><tr>
		<td background="images/edit/k4.png"></td><td background="images/edit/k5.png" bgcolor="#dee3cb">
			<div ID="innereditreq"><nobr><?= $trans['the_status'].'</nobr>'.$message ?></div>
		</td><td background="images/edit/k6.png"></td>
	</tr><tr>
		<td><img src="images/edit/k7.png" width="8" height="8" border="0"></td><td background="images/edit/k8.png"></td><td><img src="images/edit/k9.png" width="8" height="8" border="0"></td>
	</tr>
</table>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr><td align="center">
		<button name="ok" type="button" value="OK" style="cursor:pointer;" onClick="setNewStyle(<?= $fid.','.$id.','.$nx.','.$avail.','.$lentto.',' ?>'<?= $lentsince ?>');showRequest(false,'editreq','');">&nbsp;<b><?= $trans['b_ok']?></b>&nbsp;</button>
	</td></tr>
</table>
