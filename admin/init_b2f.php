<?php
/* FilmDB (based on php4flicks) */

/* init_b2f.php extract blobs to files and OPTIMIZE table movies */

session_start();
if(!isset($_SESSION['user'])) exit;
if($_SESSION['user']!='admin') exit;
	
require_once('../config/config.php');
if(!$cfg['server_cmd']) exit;
require_once('../config/debug.php');

$debugging = false;

if(isset($_POST['first_time'])){
	if(isset($_POST['log'])&&$_POST['log']==true) $debugging = true;
	$foo = mysql_query('SELECT COUNT(poster) FROM movies WHERE poster IS NOT NULL') or die(mysql_error());
	$cnt = mysql_fetch_row($foo); $cnt = $cnt[0];
	if($debugging){
		set2log("\n".'<dfn>LOG:</dfn> '.date("d-M-Y H:i:s")."\n".'<dfn>CMD:</dfn> "'.$trans['l_blob2file'].'"'."\n");
	}
	if($cfg['use_progress']==true&&$cnt>50){
		if(@is_writable("../".$cfg['poster_path'])) {
			@clearstatcache();		
			$f = ($cnt>1000?15:31); $t = floor($cnt/$f); $r = ($cnt%$f); if($r>0) $f = $f+1;
			header('location: blob2file.php?i=1&f='.$f.'&t='.$t.'&cnt='.$cnt.'&log='.$debugging);
		}
	 }else {
		$res = mysql_query('SELECT SQL_CALC_FOUND_ROWS fid,poster FROM movies WHERE poster IS NOT NULL ORDER BY fid') or die(mysql_error());
		$ires = mysql_query('SELECT FOUND_ROWS()') or die(mysql_error());
		$item = mysql_fetch_row($ires);	$cnt = $item[0];
		if($cnt>0) {
			if(@is_writable("../".$cfg['poster_path'])) {
				$error = 0;
				while($item = mysql_fetch_array($res)){
					$file="../".$cfg['poster_path'].'/'.$item['fid'].'.pic';
					$fsp = @fopen($file,"wb");
					if($fsp) {
						@fwrite($fsp, $item['poster']);
						@fclose($fsp);
						if(@is_readable($file)) {
							if(strlen($item['poster'])>=@filesize($file)) {
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
				mysql_query('OPTIMIZE TABLE movies') or die(mysql_error());
			}else {
				$error = 2;
				if($debugging) set2log('<strong>ERROR:</strong> poster path "'.$cfg['poster_path'].'" is NOT writable!'."\n");
			}
		}else {
			$error = 1;
			if($debugging) set2log('<var>WARNING:</var> NO poster blobs in data base!'."\n");
		}
?>
<html><body onLoad="parent.window.doafterLoop(<?= $error ?>);"></body></html>
<?php }
}else {
	exit;
}
?>