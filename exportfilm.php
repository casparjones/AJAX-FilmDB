<?php
/* FilmDB (based on php4flicks) */

// this is used for exporting films only

require('config/config.php');

session_start();

// allow id to be passed via GET or POST method
if(isset($_GET['fid'])){ 
	$movieid = $_GET['fid'];
	if(isset($_GET['title'])){
		$movietitle = $_GET['title'];
	}
	if(isset($_GET['local'])){
		$movielocal = $_GET['local'];
	}
} else if(isset($_POST['fid'])){
	$movieid = $_POST['fid'];
} else {
	die('error: no movie id');
}
?>
<form action="export.php" method="POST">
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/edit/k1.png" width="8" height="8" border="0"></td><td background="images/edit/k2.png"></td><td><img src="images/edit/k3.png" width="8" height="8" border="0"></td>
	</tr><tr>
		<td background="images/edit/k4.png"></td><td background="images/edit/k5.png" bgcolor="#dee3cb">
			<div ID="innereditreq"><img src="images/attention.png" alt="attention" width="20" height="18" border="0">&nbsp;<?= $trans['alert_title'].$trans['export_alert'].'<h4><b>'.htmlentities($movielocal).'</b></h4><br><h5><i>'.htmlentities($movietitle).'</i></h5>' ?>
			<br><small><br>
			<input type="radio" name="dtd" value="internal">&#160;<b><?= $trans['dtd_internal']?></b><br>
			<input type="radio" name="dtd" value="external">&#160;<b><?= $trans['dtd_external']?></b><br>
			<input type="radio" name="dtd" value="" checked>&#160;<b><?= $trans['dtd_none']?></b></small></div>
		</td><td background="images/edit/k6.png"></td>
	</tr><tr>
		<td><img src="images/edit/k7.png" width="8" height="8" border="0"></td><td background="images/edit/k8.png"></td><td><img src="images/edit/k9.png" width="8" height="8" border="0"></td>
	</tr>
</table>
<input type="hidden" id="file_id" name="file_id" value="<?=$movieid?>">
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr><td align="left">
		<button name="cancel" type="button" value="Cancel" onClick="showRequest(false,'editreq','');"><b><?= $trans['b_cancel']?></b></button>
	</td><td align="right">
		<button type="submit" name="submit" value="Export" onClick="showRequest(false,'editreq','');"><b><?= $trans['b_export']?></b></button>
	</td></tr>
</table>
</form>
