<?php
/* FilmDB (based on php4flicks) */

	// info.php -- display db-info in inforeq
	
	require_once('config/config.php');

	$res = mysql_query('SELECT COUNT(*) FROM movies') or die(mysql_error());
	$moviecount = mysql_fetch_row($res);
	$moviecount = $moviecount[0];
	
	$res = mysql_query('SELECT SQL_CALC_FOUND_ROWS disks FROM movies') or die(mysql_error());
	$mediacount = 0;
	while($cnt = mysql_fetch_row($res)) {
		$mediacount = $mediacount + $cnt[0];
	}
	
	$res = mysql_query('SELECT SQL_CALC_FOUND_ROWS poster FROM movies') or die(mysql_error());
	$postersize = 0; $blobcnt = 0;
	while($cnt = mysql_fetch_row($res)) {
		$postersize = $postersize + strlen($cnt[0]);
		$blobcnt = $blobcnt + 1;
	}
	$postersize /= 1024;
	$blobsize = ($postersize/1024 >= 1)?round(($postersize/1024),2).'</b> MB':round($postersize,0).'</b> KB';

	$postersize = 0; $filecnt = 0;
	
	foreach ((array)glob($cfg['poster_path']."/{*.pic}", GLOB_BRACE) as $file) {
	//foreach (glob($cfg['poster_path']."/{*.pic}", GLOB_BRACE) as $file) {		$postersize = $postersize + filesize($file);
		$filecnt = $filecnt + 1;
	}
	$postersize /= 1024;
	$filesize = ($postersize/1024 >= 1)?round(($postersize/1024),2).'</b> MB':round($postersize,0).'</b> KB';

	$res = mysql_query('SELECT COUNT(*) FROM people') or die(mysql_error());
	$peoplecount = mysql_fetch_row($res);
	$peoplecount = $peoplecount[0];

	$res = mysql_query('SELECT DISTINCT people_id FROM directs') or die(mysql_error());
	$dircount = mysql_num_rows($res);

	$res = mysql_query('SELECT DISTINCT people_id FROM plays_in') or die(mysql_error());
	$actcount = mysql_num_rows($res);

	$res = mysql_query('SELECT DISTINCT people_id FROM writes') or die(mysql_error());
	$wrcount = mysql_num_rows($res);

	// calculate db size
	$res = mysql_query('SHOW TABLE STATUS') or die(mysql_error());
	$dbsize = 0;
	while($row = mysql_fetch_array($res)){
		$dbsize += $row['Data_length'] + $row['Index_length'];
	}
	$dbsize /= 1024;
	$dbsize = ($dbsize/1024 >= 1)?round(($dbsize/1024),2).'</b> MB':round($dbsize,0).'</b> KB';
?>
<table border="0" cellpadding="0" cellspacing="0"><tr>
<td><img src="images/info/g1.png" width="6" height="6" border="0"></td><td background="images/info/g2.png"></td>
<td><img src="images/info/g3.png" width="6" height="6" border="0"></td></tr><tr>
<td background="images/info/g4.png"></td><td background="images/info/g5.png" bgcolor="#bdcaac">
<div ID="innereditreq">
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center" valign="top" class="txt">
			<img src="images/filmdb.png" alt="filmdb" width="64" height="64" border="0"><br>
			<br><small><?= $trans['version']?></small>
			<br><b><?= $cfg['filmdb_version']?></b>
			<br><small><?= $cfg['filmdb_release']?></small>
		</td>
		<td width="20">&nbsp;&nbsp;&nbsp;</td>
		<td class="txt" nowrap><big><b><?= $trans['statistic']?></b></big><br>
			<br><?= $trans['total_films']?>: <b><?= $moviecount ?></b>
			<br><?= $trans['total_media']?>: <b><?= $mediacount ?></b>
			<br><?= $trans['db_size']?>: <b><?= $dbsize ?></b><br>
			<br><?= $trans['poster_size']?>
			<br><?= $trans['blob_size']?>: <?= $blobcnt ?>=<b><?= $blobsize ?></b>
			<br><?= $trans['post_size']?>: <?= $filecnt ?>=<b><?= $filesize ?></b><br>
			<br><?= $trans['i_writers']?>: <b><?= $wrcount ?></b>
			<br><?= $trans['i_directors']?>: <b><?= $dircount ?></b>
			<br><?= $trans['i_actors']?>: <b><?= $actcount ?></b>
			<br><b><?= $peoplecount ?></b> <?= $trans['total_people']?><br>
		</td>
	</tr>
</table>
</div>
</td><td background="images/info/g6.png"></td></tr><tr><td><img src="images/info/g7.png" width="6" height="6" border="0"></td>
<td background="images/info/g8.png"></td><td><img src="images/info/g9.png" width="6" height="6" border="0"></td>
</tr></table>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr><td align="center">
		<button name="ok" type="button" value="OK" style="cursor:pointer;" onClick="showRequest(false,'editreq','');">&nbsp;&nbsp;<b><?= $trans['b_ok']?></b>&nbsp;&nbsp;</button>
	</tr>
</table>
