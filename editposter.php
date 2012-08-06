<?php
/* FilmDB (based on php4flicks) */

require('config/config.php');

// editposter.php - allows to edit an image file for a movie

session_start();
// if(!isset($_SESSION['user'])){
// }

$pid = $_GET['id'];

?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/edit/k1.png" width="8" height="8" border="0"></td><td background="images/edit/k2.png"></td><td><img src="images/edit/k3.png" width="8" height="8" border="0"></td>
	</tr><tr>
		<td background="images/edit/k4.png"></td><td background="images/edit/k5.png" bgcolor="#dee3cb">
			<div ID="innereditreq">
			<form enctype="multipart/form-data" name="posterdata" action="javascript:ajaxpage('getposter.php?id=<?= $pid ?>&url=' + document.posterdata.url.value,'editreqsource');" method="POST">
			<table border="0" cellpadding="2" cellspacing="0">
				<tr><td valign="top" class="txt" nowrap>
					<h2><b><?= $trans['edit_poster']?>:</b></h2><br><br>
					<strong><small><?= $trans['upload_url']?><br></small></strong>
				</td></tr><tr><td class="txt">
					<input style="width:264px;" type="text" size="30" name="url" value="http://">
				</td></tr>
			</table>
			</form></div>
		</td><td background="images/edit/k6.png"></td>
	</tr><tr>
		<td><img src="images/edit/k7.png" width="8" height="8" border="0"></td><td background="images/edit/k8.png"></td><td><img src="images/edit/k9.png" width="8" height="8" border="0"></td>
	</tr>
</table>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr><td align="left">
		<button name="cancel" type="button" value="Cancel" onClick="showRequest(false,'editreq','');">&nbsp;<b><?= $trans['b_cancel']?></b>&nbsp;</button>
	</td><td align="right">
		<button name="ok" type="button" value="OK" onClick="if(document.posterdata.url.value=='http://'){alert('<?= $trans['js_enter_url']?>');return false;}document.posterdata.submit();">&nbsp;<b><?= $trans['b_upload']?></b>&nbsp;</button>
	</td></tr>
</table>
