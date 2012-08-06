<?php
/* FilmDB (based on php4flicks) */

/* del_blobs.php - clear data base blobs and OPTIMIZE table movies */

require_once('../config/config.php');
require_once('../config/debug.php');

$debugging = false;

if(isset($_GET['i'])&&isset($_GET['f'])&&isset($_GET['t'])&&isset($_GET['cnt'])){
	if(isset($_GET['log'])&&$_GET['log']==true) $debugging = true;
	$i = $_GET['i']; $f = $_GET['f']; $t = $_GET['t']; $cnt = $_GET['cnt'];
	$foo = (100/$f)*$i; $n = round($foo,0); $s = round($foo,1); $ii = 0;
	$res = mysql_query('SELECT SQL_CALC_FOUND_ROWS fid,poster FROM movies WHERE poster IS NOT NULL ORDER BY fid LIMIT '.$t.'') or die(mysql_error());
	$ires = mysql_query('SELECT FOUND_ROWS()') or die(mysql_error());
	$item = mysql_fetch_row($ires);
	while($item = mysql_fetch_array($res)){
		$ii = $ii+1;
		mysql_query('UPDATE movies SET poster=NULL WHERE fid=\''.$item['fid'].'\'') or die(mysql_error());
		if($debugging) set2log('del_blobs: id='.sprintf("%04d",$item['fid'])."\n");
	}
	$i = $i+1;
?>
<html><body>
<script type="text/javascript" language="JavaScript">
<!--
parent.window.dothroughLoop(<?=$n.','.$s?>);
<?php if($i<=$f){?>
window.location.href = "del_blobs.php?i=<?= $i.'&f='.$f.'&t='.$t.'&cnt='.$cnt.'&log='.$debugging ?>";
<?php }else {
	mysql_query('OPTIMIZE TABLE movies') or die(mysql_error());
?>
parent.window.doafterLoop(0);
<?php }?>	
-->
</script>
</body></html>
<?php
	if($i>$f){
		exit;
	}
}else {
	exit;
}
?>