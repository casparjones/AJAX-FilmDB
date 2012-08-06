<?php
/* FilmDB (based on php4flicks) */

// this is used for editing the lending status

require('config/config.php');

if(isset($_GET['fid'])) $fid = $_GET['fid'];
if(isset($_GET['id'])) $id = $_GET['id'];
if(isset($_GET['nx'])) $nx = $_GET['nx'];

if(isset($fid)&&isset($id)) {
		$result = mysql_query('SELECT name,local,avail,lentto,lentsince FROM movies WHERE fid=\''.$fid.'\'') or die(mysql_error());
		$row = mysql_fetch_array($result);
		$title = htmlspecialchars($row['name']);
		$local = htmlentities($row['local']);
		$avail = $row['avail'];
		$lentsince = $row['lentsince'];
		$lentto = $row['lentto'];
} else {
	if(!isset($title)) $title = 'Unknown';
	if(!isset($local)) $local = 'Unknown';
	if(!isset($avail)) $avail = '1';
	if(!isset($lentsince)) $lentsince = '0000-00-00';
	if(!isset($lentto)) $lentto = '0';
}

?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/edit/k1.png" width="8" height="8" border="0"></td><td background="images/edit/k2.png"></td><td><img src="images/edit/k3.png" width="8" height="8" border="0"></td>
	</tr><tr>
		<td background="images/edit/k4.png"></td><td background="images/edit/k5.png" bgcolor="#dee3cb">
			<div ID="innereditreq">
			<form name="data" action="javascript:ajaxpage('savelent.php?fid=<?= $fid ?>&id=<?= $id ?>&nx=<?= $nx ?>&avail='+document.data.avail.value+'&lentto='+document.data.lentto.options[document.data.lentto.selectedIndex].value+'&lentsince='+document.data.lentsince.value+'','editreqsource');" method="GET">
			<table border="0" cellpadding="2" cellspacing="0">
				<tr><td colspan="2" valign="top" class="txt">
					<h2><b><nobr><?= $trans['lent_title']?>:</nobr></b></h2><br><small><br></small>
					<nobr><h4><b><?= $local ?></b></h4></nobr>
					<br><h5><i><?= $title ?></i></h5><br><small><br></small>
				</td></tr>
				<tr><td align="right" class="txt" nowrap>
					<big><b><?= $trans['t_lent']?></b></big>&nbsp;
				</td><td class="txt">
					<input type="checkbox" name="test" onClick="setavail(this.checked);"<? if($avail!='1'){ echo ' checked';} ?>><input type="hidden" name="avail" value="<?= $avail ?>">
				</td></tr>
				<tr><td align="right" class="txt" nowrap>
					<big><b><?= $trans['t_to']?></b></big>&nbsp;
				</td><td class="txt" nowrap>
<select class="obj" name="lentto">
<? for($i=0; $i<sizeof($lenton); $i++){
	echo("<option value=\"$i\"".($lentto==$i?' selected="selected"':'').">$lenton[$i]</option>");
} ?>
</select>
				</td></tr>
				<tr><td align="right" class="txt" nowrap>
					<big><b><?= $trans['t_at']?></b></big>&nbsp;
				</td><td class="txt" nowrap>
					<input type="text" value="<?= $lentsince; ?>" size="10" maxlength="10" name="lentsince">
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
		<button name="save" type="button" value="Save" onClick="document.data.submit();">&nbsp;<b><?= $trans['b_save']?></b>&nbsp;</button>
	</td></tr>
</table>
