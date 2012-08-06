<?php
/* FilmDB (based on php4flicks) */

// this is used for downloading archives only

session_start();
if(!isset($_SESSION['user'])){
	if($_SESSION['user']!='admin') exit;
}

require('config/config.php');

function getSum($val){
	if($val>=1024){
		$val /= 1024; $val = ($val/1024 >= 1)?'<b>'.round(($val/1024),2).'</b>&#160;MB':'<b>'.round($val,0).'</b>&#160;KB';
		return $val;
	} else {
		return '<b>'.$val.'</b>&#160;B';
	}
}

if(isset($_GET['script'])){ 
	$script = $_GET['script']; 
	if(isset($_GET['info'])){
		$us = ini_get('upload_max_filesize'); $ps = ini_get('post_max_size');
		$umf = (int)str_replace("M","",($ps<$us?$ps:$us)); $single = true;
		if($umf<=256) $umv = ($umf*1048000); $umf = ($umf*1048576); 
		$ums = round((($umf/1024)/1024),2);	
		if($_GET['info']=='posters'){
			$file = "filmdb_poster_".date("ymd-His").".zip"; $size = 0;
			foreach (glob($cfg['poster_path']."/{*.pic}", GLOB_BRACE) as $fid) {				$size = $size + filesize($fid);
				$test[] = filesize($fid);
			}
			$pms = $size; $nof = count($test);
			$size /= 1024; $size = ($size/1024 >= 1)?round(($size/1024),2).'</b> MB':round($size,0).'</b> KB';
			if($pms>$umv){
				$single = false; $script = 'bak_multi.php';
				$t = floor($pms/$umv); $cnt = $t; $r = ($pms%$umv); if($r>0) $cnt = $cnt+1;
			}
		} else {
			$file = "filmdb_dbase_".date("ymd-His").'.zip'; $poster = 0; $cnt = 0; $dbase = 0; $size = 0;
			$res = mysql_query('SHOW TABLE STATUS') or die(mysql_error()); 
			while($row = mysql_fetch_array($res)){
				$dbase += $row['Data_length'] + $row['Index_length'];
			}
			$res = mysql_query('SELECT SQL_CALC_FOUND_ROWS poster FROM movies') or die(mysql_error()); 
			while($cnt = mysql_fetch_row($res)) {
				$poster = $poster + strlen($cnt[0]);
			}
			if($poster==0) {$size = ($dbase*0.4); }else {$size = $dbase; }
			$size /= 1024; $size = ($size/1024 >= 1)?round(($size/1024),2).'</b> MB':round($size,0).'</b> KB';
		} 
	} else {
		die('error: no info');
	}	
} else {
	die('error: no script');
}
?>
<form action="admin/<?= $script ?>" method="POST">
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/edit/k1.png" width="8" height="8" border="0"></td><td background="images/edit/k2.png"></td><td><img src="images/edit/k3.png" width="8" height="8" border="0"></td>
	</tr><tr>
		<td background="images/edit/k4.png"></td><td background="images/edit/k5.png" bgcolor="#dee3cb">
<?php if(!$single){ ?>
			<div id="innereditreq" style="margin:4px;"><img src="images/attention.png" alt="attention" width="20" height="18" border="0">&nbsp;<?= $trans['alert_title']?>
				<div class="txt" style="margin-top:-0.5em; margin-bottom: 2px;"><?= $trans['multiple_alert'].' (max. <b>'.$ums.' MB</b>)!' ?><br></div>
				<div id="listarea" style="width:<?php if(eregi('Opera',$_SERVER['HTTP_USER_AGENT'])) { echo "270px"; }else { echo "auto"; } ?>; height: <?= ($cfg['fontsize']*100) ?>px;"> 
					<table width="100%" border="0" bordercolor="#D9D9D9" cellpadding="2" cellspacing="0">
<?php 
$brow = true; $sti = 0; $ii = 0;
for($i=1; $i<$cnt+1; $i++){
	$file = "filmdb_poster_".date("ymd-Hi").sprintf("%02d",$i).".zip"; 
	$sti += $ii; $size = 0; $ii = 0; $noi = 0;  
	for($x=$sti; $x<$nof; $x++){
		if(($size+$test[$x]) > $umv) break;
		$size += $test[$x];
		$ii += 1;
	}
	$nr = $brow?'0':'1'; $noi = $ii; $brow = !$brow; 
	echo '<tr class="row_'.$nr.'"><td width="90%" class="txt" style="cursor:pointer;"><a onmouseover="parent.window.status=\' \';return true;" title="'.$trans['tt_download'].'" href="admin/bak_multi.php?name='.$file.'&noi='.$noi.'&sti='.$sti.'">'.$file.'</a></td><td>&#160;</td><td align="right" class="txt">'.getSum($size).'</td></tr>'."\n";
	/* echo '<tr class="row_'.$nr.'"><td width="90%" class="txt" style="cursor:pointer;"><a onClick="setDownload(\''.$file.'\','.$noi.','.$sti.');" title="'.$trans['tt_download'].'">'.$file.'</a></td><td>&#160;</td><td align="right" class="txt">'.getSum($size).'</td></tr>'."\n"; */
}
?>
					</table>
				</div>
<?php }else { ?>
			<div id="innereditreq"><img src="images/attention.png" alt="attention" width="20" height="18" border="0">&nbsp;<?= $trans['alert_title']?>
			<?= $trans['archive_alert'].'<h4><b>'.$file.'</b></h4>' ?>
			<br><br><nobr><strong><?= $trans['pro_file_size'] ?>:</strong>&nbsp;&nbsp;<?= $size?></nobr>
			<small><br>upload_max_filesize: <b><?= $ums ?> MB</b> (<?= $umf ?> Bytes)</small>
<?php } ?>
			</div>
		</td><td background="images/edit/k6.png"></td>
	</tr><tr>
		<td><img src="images/edit/k7.png" width="8" height="8" border="0"></td><td background="images/edit/k8.png"></td><td><img src="images/edit/k9.png" width="8" height="8" border="0"></td>
	</tr>
</table>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
<?php if(!$single){ ?>
	<tr><td width="50%">&#160;</td><td align="center">
		<button name="ok" type="button" value="OK" onClick="showRequest(false,'editreq','');"><b><?= $trans['b_ok']?></b></button>
	</td><td width="50%">&#160;
<?php }else { ?>
	<tr><td align="left">
		<button name="cancel" type="button" value="Cancel" onClick="showRequest(false,'editreq','');"><b><?= $trans['b_cancel']?></b></button>
	</td><td align="right">
		<button type="submit" name="submit" value="Start" onClick="showRequest(false,'editreq','');"><b><?= $trans['b_start']?></b></button>
<?php } ?>
	</td></tr>
</table>
</form>
