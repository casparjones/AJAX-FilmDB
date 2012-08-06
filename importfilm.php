<?php
/* FilmDB (based on php4flicks) */

session_start();
// if(!isset($_SESSION['user'])){
// }

/*	importfilm.php - display upload form. */

require('config/config.php');

?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/edit/k1.png" width="8" height="8" border="0"></td><td background="images/edit/k2.png"></td><td><img src="images/edit/k3.png" width="8" height="8" border="0"></td>
	</tr><tr>
		<td background="images/edit/k4.png"></td><td background="images/edit/k5.png" bgcolor="#dee3cb">
			<div ID="innereditreq">
			<form name="filename" action="uploadfilm.php" target="uploadframe" method="POST" enctype="multipart/form-data">
			<table border="0" cellpadding="2" cellspacing="0">
				<tr><td valign="top" class="txt" nowrap>
					<h2><b><?= $trans['import_title']?>:</b></h2><br><br>
					<strong><small><?= $trans['import_info']?><br></small></strong>
				</td></tr>
				<tr><td class="txt">
					<input type="file" name="upload_file" maxlength="50000" accept="text/*">
					<input type="hidden" name="action" value="">
					<input type="hidden" id="first_time" name="first_time" value="1">
					<iframe id="uploadframe" name="uploadframe" src=""></iframe>
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
		<button name="import" type="button" value="Import" onClick="if(document.filename.upload_file.value==''){alert('<?= $trans['js_enter_file']?>');return false;}document.filename.submit();">&nbsp;<b><?= $trans['b_import']?></b>&nbsp;</button>
	</td></tr>
</table>