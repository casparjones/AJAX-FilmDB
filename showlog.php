<?php
/* FilmDB (based on php4flicks) */

// showlog.php - views the log file

session_start();
if(!isset($_SESSION['user'])){
	if($_SESSION['user']!='admin') exit;
} 

require('config/config.php');

if($cfg['autoheight']==true){
	$list_height = (isset($_GET['lh'])?($_GET['lh']+($cfg['fontsize']*44)):$cfg['listheight']);
}else {
	$list_height = ($cfg['listheight']+($cfg['fontsize']*44));
}

$str="";
clearstatcache();
if(@is_readable("admin/debug.log")) {
	$str=@file_get_contents("admin/debug.log"); 
}

?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/edit/k1.png" width="8" height="8" border="0"></td><td background="images/edit/k2.png"></td><td><img src="images/edit/k3.png" width="8" height="8" border="0"></td>
	</tr><tr>
		<td background="images/edit/k4.png"></td><td background="images/edit/k5.png" bgcolor="#dee3cb">
			<div id="innereditreq" style="margin: 0px;"><span class="txt"><h2><b><?= $trans['log_file']?>:</b></h2></span><br>
				<div id="logarea" style="height: <?= $list_height ?>px;"><pre><?= $str ?></pre></div>
			</div>
		</td><td background="images/edit/k6.png"></td>
	</tr><tr>
		<td><img src="images/edit/k7.png" width="8" height="8" border="0"></td><td background="images/edit/k8.png"></td><td><img src="images/edit/k9.png" width="8" height="8" border="0"></td>
	</tr>
</table>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr><td align="left">
		<button name="cancel" type="button" value="Cancel" onClick="showRequest(false,'editreq','');">&nbsp;<b><?= $trans['b_cancel']?></b>&nbsp;</button>
	</td><td>&nbsp;</td><td align="center" width="90%">
		<button name="back" type="button" value="Back" onClick="showRequest(true,'editreq','askprefs.php?lh=<?= $list_height+($cfg['fontsize']*4) ?>');">&nbsp;<b><?= $trans['b_back']?></b>&nbsp;</button>
	</td><td>&nbsp;</td><td align="right">
		<button name="clear" type="button" value="Clear" onClick="ajaxpage('clearlog.php','editreqsource');">&nbsp;<b><?= $trans['b_clear']?></b>&nbsp;</button>
	</td></tr>
</table>
