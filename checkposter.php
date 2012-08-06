<?php
/* FilmDB (based on php4flicks) */

session_start();
// if(!isset($_SESSION['user'])){
// }

/*	checkposter.php -  */

require('config/config.php');

if($_GET['error']==0){
	$tmp = explode('.',$_GET['file']); $form = $tmp[1];
	$tmp = explode('_',$tmp[0]); $tmp = explode('-',$tmp[2]); 
	$date = substr($tmp[0], 4, 2).'-'.$trans[substr($tmp[0], 2, 2)].'-20'.substr($tmp[0], 0, 2); 
	$time = substr($tmp[1], 0, 2).':'.substr($tmp[1], 2, 2).':'.substr($tmp[1], 4, 2);
	$import_file = dirname($_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF']).$cfg['uploads'];
?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/edit/k1.png" width="8" height="8" border="0"></td><td background="images/edit/k2.png"></td><td><img src="images/edit/k3.png" width="8" height="8" border="0"></td>
	</tr><tr>
		<td background="images/edit/k4.png"></td><td background="images/edit/k5.png" bgcolor="#dee3cb">
			<div ID="innereditreq"><img src="images/attention.png" alt="attention" width="20" height="18" border="0">&nbsp;<?= $trans['alert_title'].$trans['restore_poster'].'<h2><b>'.$_GET['file']?></b></h2>
			<small><br><br></small><?= $trans['file_date'].': <b>'.$date.' '.$time ?></b><br>
			<?= $trans['file_type'].': <b>'.$_GET['type']?></b><br>
			<?= $trans['file_size'].': <b>'.$_GET['size']?></b> Bytes</div>
			<iframe id="uploadframe" name="uploadframe" src=""></iframe>
		</td><td background="images/edit/k6.png"></td>
	</tr><tr>
		<td><img src="images/edit/k7.png" width="8" height="8" border="0"></td><td background="images/edit/k8.png"></td><td><img src="images/edit/k9.png" width="8" height="8" border="0"></td>
	</tr>
</table>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr><td align="left">
		<button name="cancel" type="button" value="Cancel" onClick="ajaxpage('clearupload.php','editreqsource');">&nbsp;<b><?= $trans['b_cancel']?></b>&nbsp;</button>
	</td><td align="right">
		<button name="restore" type="button" value="Restore" onClick="ajaxpage('execute.php?script=res_poster.php&info=l_res_poster','editreqsource');">&nbsp;<b><?= $trans['b_restore']?></b>&nbsp;</button>
	</td></tr>
</table>
<? }else { ?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/edit/k1.png" width="8" height="8" border="0"></td><td background="images/edit/k2.png"></td><td><img src="images/edit/k3.png" width="8" height="8" border="0"></td>
	</tr><tr>
		<td background="images/edit/k4.png"></td><td background="images/edit/k5.png" bgcolor="#dee3cb">
			<div ID="innereditreq">
			<table border="0" cellpadding="2" cellspacing="0">
				<tr><td valign="top" class="txt" nowrap>
					<img src="images/attention.png" alt="attention" width="20" height="18" border="0">&nbsp;<?= $trans['alert_title']?>
					<b><big><?= $_GET['file']?></big><br><small><br></small><?= $trans['not_loaded'] ?></b><br><small><br></small>
					<?= $trans['file_type'].': <b>'.$_GET['type']?></b><br>
					<?= $trans['file_size'].': <b>'.$_GET['size']?></b> Bytes
				</td></tr>
				<tr><td class="txt">
					<strong><small><?= $trans[$_GET['error']]; ?></small></strong>
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
		<button name="cancel" type="button" value="Cancel" onClick="showRequest(false,'editreq','');">&nbsp;<b><?= $trans['b_ok']?></b>&nbsp;</button>
	</td></tr>
</table>
<? }?>