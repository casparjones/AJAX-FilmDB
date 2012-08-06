<?php
/* FilmDB (based on php4flicks) */

require('config/config.php');

// getposter.php - allows to edit an image file for a movie

session_start();
// if(!isset($_SESSION['user'])){
// }

if (function_exists('gd_info')) {
	$ver = gd_info();
	preg_match('/\d/', $ver['GD Version'], $match);
	if ($match[0]>=2){
		include_once('fetchimggd.php'); 
	}else {
		include_once('fetchimg.php');
	}
}else {
	include_once('fetchimg.php');
}

if(!isset($_GET['url'])) {
	$pid = $_GET['id']; $uri = '...';
	if($_GET['err']=='0') {
		$res = fetchimg($pid,'',dirname($_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF']).$cfg['uploads']);
	}else {
		$res = $trans[$_GET['err']];
	}
}else {
	$pid = $_GET['id']; $uri = $_GET['url'];
	$res = fetchimg($pid,$uri,dirname($_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF']).$cfg['uploads']);
}

if($res == ''){
?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/edit/k1.png" width="8" height="8" border="0"></td><td background="images/edit/k2.png"></td><td><img src="images/edit/k3.png" width="8" height="8" border="0"></td>
	</tr><tr>
		<td background="images/edit/k4.png"></td><td background="images/edit/k5.png" bgcolor="#dee3cb">
			<div ID="innereditreq">
			<table border="0" cellpadding="2" cellspacing="0">
				<tr><td valign="top" class="txt" nowrap>
					<h2><b><?= $trans['edit_poster']?>:</b></h2><br><br>
					<strong><small><?= $trans['do_store']?>?</small></strong>
<?php if(isset($_GET['url'])) {?>
					<br><br><h4><b><?= basename($uri) ?></b></h4>
<?php } ?>					
				</td></tr>
			</table>
			</div>
		</td><td background="images/edit/k6.png"></td>
	</tr><tr>
		<td><img src="images/edit/k7.png" width="8" height="8" border="0"></td><td background="images/edit/k8.png"></td><td><img src="images/edit/k9.png" width="8" height="8" border="0"></td>
	</tr>
</table>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr><td align="left">
		<button name="cancel" type="button" value="Cancel" style="cursor:pointer;" onClick="showRequest(false,'editreq','');">&nbsp;<b><?= $trans['b_cancel']?></b>&nbsp;</button>
	</td><td align="right">
		<button name="ok" type="button" value="OK" style="cursor:pointer;" onClick="settheposter('<?= $_GET['id']?>');showRequest(false,'editreq','');">&nbsp;<b><?= $trans['b_ok']?></b>&nbsp;</button>
	</td></tr>
</table>
<?
	exit;
} else { // error occured
?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/edit/k1.png" width="8" height="8" border="0"></td><td background="images/edit/k2.png"></td><td><img src="images/edit/k3.png" width="8" height="8" border="0"></td>
	</tr><tr>
		<td background="images/edit/k4.png"></td><td background="images/edit/k5.png" bgcolor="#dee3cb">
			<div ID="innereditreq">
			<table border="0" cellpadding="2" cellspacing="0">
				<tr><td valign="top" class="txt" nowrap>
					<h2><b><?= $trans['edit_poster']?>:</b></h2><br><br>
					<?= $trans['error_info']?>
					<br><br><strong><small><?= $res ?></small></strong>
				</td></tr>
			</table>
			</div>
		</td><td background="images/edit/k6.png"></td>
	</tr><tr>
		<td><img src="images/edit/k7.png" width="8" height="8" border="0"></td><td background="images/edit/k8.png"></td><td><img src="images/edit/k9.png" width="8" height="8" border="0"></td>
	</tr>
</table>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr><td align="center">
		<button name="ok" type="button" value="OK" style="cursor:pointer;" onClick="showRequest(false,'editreq','');">&nbsp;<b><?= $trans['b_ok']?></b>&nbsp;</button>
	</td></tr>
</table>
<? } ?>
