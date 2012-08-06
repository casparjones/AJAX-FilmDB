<?php
/* FilmDB (based on php4flicks) */

session_start();
// if(!isset($_SESSION['user'])){
// }

/*	import.php - display upload form. */

require('config/config.php');

if($_GET['error']==0){
	$import_file = dirname($_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF']).$cfg['uploads'];
	$tmp = file_get_contents($import_file);
	preg_match('#<title>(.*)</title>#i', $tmp, $tt);
	preg_match('#<local>(.*)</local>#i', $tmp, $tl);
	preg_match('#<imdb>([0-9]{7})</imdb>#i', $tmp, $imdbid);
	$movietitle = (isset($tt[1])?str_replace("&amp;","&",$tt[1]):"***");
	$movielocal = (isset($tl[1])?str_replace("&amp;","&",$tl[1]):"***");
	$result = mysql_query("SELECT SQL_CALC_FOUND_ROWS fid FROM movies WHERE id like '$imdbid[1]'") or die(mysql_error());
	$row = mysql_fetch_row($result);
	if(isset($row[0])){
		$found = '<br><strong><small><br>'.$trans['97'].'. IMDb: <a target="_blank" title="'.$trans['show_imdbpage'].'" href="http://www.imdb.com/title/tt'.$imdbid[1].'">'.$imdbid[1].'</a></small></strong>';
	}else {
		$found = '';
	}
?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/edit/k1.png" width="8" height="8" border="0"></td><td background="images/edit/k2.png"></td><td><img src="images/edit/k3.png" width="8" height="8" border="0"></td>
	</tr><tr>
		<td background="images/edit/k4.png"></td><td background="images/edit/k5.png" bgcolor="#dee3cb">
			<div ID="innereditreq"><img src="images/attention.png" alt="attention" width="20" height="18" border="0">&nbsp;<?= $trans['alert_title'].$trans['import_alert'].'<h4><b>'.htmlentities($movielocal).'</b></h4><br><h5><i>'.htmlentities($movietitle).'</i></h5>'.$found ?></div>
			<form name="filename" action="import.php" target="mainframe" method="POST"></form>
		</td><td background="images/edit/k6.png"></td>
	</tr><tr>
		<td><img src="images/edit/k7.png" width="8" height="8" border="0"></td><td background="images/edit/k8.png"></td><td><img src="images/edit/k9.png" width="8" height="8" border="0"></td>
	</tr>
</table>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr><td align="left">
		<button name="cancel" type="button" value="Cancel" onClick="showRequest(false,'editreq','');">&nbsp;<b><?= $trans['b_cancel']?></b>&nbsp;</button>
	</td><td align="right">
		<button name="import" type="button" value="Import" onClick="document.filename.submit();showRequest(false,'editreq','');">&nbsp;<b><?= $trans['b_import']?></b>&nbsp;</button>
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
					<?= $trans['file_type'].': <b>'.$_GET['type']?></b><br>					<?= $trans['file_size'].': <b>'.$_GET['size']?></b> Bytes
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