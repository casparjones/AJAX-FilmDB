<?php
/* FilmDB (based on php4flicks) */

/* del_files.php - delete poster files on server */

require_once('../config/config.php');
require_once('../config/debug.php');

$debugging = false;

if(isset($_GET['i'])&&isset($_GET['f'])&&isset($_GET['t'])&&isset($_GET['cnt'])){
	if(isset($_GET['log'])&&$_GET['log']==true) $debugging = true;
	$i = $_GET['i']; $f = $_GET['f']; $t = $_GET['t']; $cnt = $_GET['cnt'];
	$foo = (100/$f)*$i; $n = round($foo,0); $s = round($foo,1); $ii = 0;
	if(@is_readable("../".$cfg['poster_path'])) {
		if ($handle = @opendir("../".$cfg['poster_path'])) {
			while (false !== ($file = @readdir($handle))) { 
				if ($file == "." || $file == ".." || !preg_match('#^([1-9]|[1-9][0-9]|[1-9][0-9][0-9]|[1-9][0-9][0-9][0-9]).pic$#', $file))  continue;
				if (@filetype("../".$cfg['poster_path'].'/'.$file) == "dir")  continue;
				$foo = explode(".", $file); $fid = $foo[0];
				if(@is_readable("../".$cfg['poster_path'].'/'.$file)) {
					$files[] = $file;
				}else {
					if($debugging) set2log('<strong>ERROR:</strong> id='.sprintf("%04d",$fid).' is NOT readable!'."\n");
				}
			}
			@closedir($handle);
			for($ii=0; $ii<$t; $ii++){
				if(@file_exists("../".$cfg['poster_path'].'/'.$files[$ii])) {
					$foo = explode(".", $files[$ii]); $fid = $foo[0];
					@unlink("../".$cfg['poster_path'].'/'.$files[$ii]);
					if($debugging) set2log('del_files: id='.sprintf("%04d",$fid)."\n");
				}
			}
			@clearstatcache(); 
		}else {
			if($debugging) set2log('<strong>ERROR:</strong> files in path "'.$cfg['poster_path'].'" are NOT readable!'."\n");
		}
	}else {
		if($debugging) set2log('<strong>ERROR:</strong> poster path "'.$cfg['poster_path'].'" is NOT readable!'."\n");
	}
	$i = $i+1;
?>
<html><body>
<script type="text/javascript" language="JavaScript">
<!--
parent.window.dothroughLoop(<?=$n.','.$s?>);
<?php if($i<=$f){?>
window.location.href = "del_files.php?i=<?= $i.'&f='.$f.'&t='.$t.'&cnt='.$cnt.'&log='.$debugging ?>";
<?php }else {
	clearstatcache();
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