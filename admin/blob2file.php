<?php
/* FilmDB (based on php4flicks) */

/*	blob2file.php - set posters from db to directory. */

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
	if(@is_writable("../".$cfg['poster_path'])) {
		while($item = mysql_fetch_array($res)){
			$ii = $ii+1;
			$file="../".$cfg['poster_path'].'/'.$item['fid'].'.pic';
			$fsp = @fopen($file,"wb");
			if($fsp) {
				@fwrite($fsp, $item['poster']);
				@fclose($fsp);
				if(@is_readable($file)) {
					if(strlen($item['poster'])>=filesize($file)) {
						mysql_query('UPDATE movies SET poster=NULL WHERE fid=\''.$item['fid'].'\'') or die(mysql_error());
						if($debugging) set2log('copy_b2f: id='.sprintf("%04d",$item['fid'])."\n");
					}else {
						if($debugging) set2log('<strong>ERROR:</strong> id='.sprintf("%04d",$item['fid']).' blobsize is UNEQUAL to filesize!'."\n");
					}
				}else {
					if($debugging) set2log('<strong>ERROR:</strong> "'.$item['fid'].'.pic" is NOT readable!'."\n");
				}
			}else {
				if($debugging) set2log('<strong>ERROR:</strong> "'.$item['fid'].'.pic" is NOT writable!'."\n");
			}
		}
		@clearstatcache();
	}else {
		if($debugging) set2log('<strong>ERROR:</strong> poster path "'.$cfg['poster_path'].'" is NOT writable!'."\n");
	}
	$i = $i+1;
?>
<html><body>
<script type="text/javascript" language="JavaScript">
<!--
parent.window.dothroughLoop(<?=$n.','.$s?>);
<?php if($i<=$f){?>
window.location.href = "blob2file.php?i=<?= $i.'&f='.$f.'&t='.$t.'&cnt='.$cnt.'&log='.$debugging ?>";
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