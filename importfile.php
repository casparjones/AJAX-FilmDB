<?php
/* FilmDB (based on php4flicks) */

/*importfile.php - display upload form. */

session_start();
if(!isset($_SESSION['user'])){
	if($_SESSION['user']!='admin') exit;
}

require('config/config.php');

if(isset($_GET['script'])){ 
	$script = $_GET['script'];
	if(isset($_GET['info'])){
		$info = $trans[$_GET['info']];
		$mus = ini_get('upload_max_filesize');
		$mps = ini_get('post_max_size');
		$umf = (int)str_replace("M","",($mps<$mus?$mps:$mus));
		if($umf<=256) $umf = ($umf*1048576);
		$umm = round((($umf/1024)/1024),2);
	} else {
		die('error: no info');
	}
} else {
	die('error: no script');
}

?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/edit/k1.png" width="8" height="8" border="0"></td><td background="images/edit/k2.png"></td><td><img src="images/edit/k3.png" width="8" height="8" border="0"></td>
	</tr><tr>
		<td background="images/edit/k4.png"></td><td background="images/edit/k5.png" bgcolor="#dee3cb">
			<div ID="innereditreq">
			<form name="filename" target="uploadframe" action="<?= $script ?>" method="POST" enctype="multipart/form-data">
			<table border="0" cellpadding="2" cellspacing="0">
				<tr><td valign="top" class="txt" nowrap>
					<h2><b><?= $trans['import_file']?>:</b></h2><br><br>
					<strong><small><?= $info ?><br></small></strong>
				</td></tr>
				<tr><td class="txt">
					<input type="file" id="upload_file" name="upload_file" maxlength="<?= $umf ?>" accept="application/zip">
					<div id="bar" class="no_progress" style="min-width:240px; margin-bottom:-0.5em; display:none;"></div>
					<small><br>upload_max_filesize: <b><?= $umm ?> MB</b> (<?= $umf ?> Bytes)<br></small>
					<input type="hidden" id="max_length" name="max_length" value="<?= $umf ?>">
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
		<button id="cancel_b" name="cancel" type="button" value="Cancel" onClick="showRequest(false,'editreq','');">&nbsp;<b><?= $trans['b_cancel']?></b>&nbsp;</button>
	</td><td width="100%" align="center">&#160;</td><td align="right">
		<button id="upload_b" name="upload" type="button" value="Upload" onClick="if(getMatch('<?= $script ?>')==true){document.getElementById('upload_file').style.display='none';document.getElementById('bar').style.display='block';document.getElementById('cancel_b').style.display='none';document.filename.submit();document.getElementById('upload_b').style.display='none';}">&nbsp;<b><?= $trans['b_upload']?></b>&nbsp;</button>
	</td></tr>
</table>
