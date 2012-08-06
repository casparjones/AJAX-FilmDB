<?php
/* FilmDB (based on php4flicks) */

/*	file2blob.php - set posters from directory to db. */

require_once('../config/config.php');
require_once('../config/debug.php');

$debugging = false;

if(isset($_GET['i'])&&isset($_GET['f'])&&isset($_GET['t'])&&isset($_GET['cnt'])){
	if(isset($_GET['log'])&&$_GET['log']==true) $debugging = true;
	$i = $_GET['i']; $f = $_GET['f']; $t = $_GET['t']; $cnt = $_GET['cnt'];
	$foo = (100/$f)*$i; $n = round($foo,0); $s = round($foo,1); $ii = 0;
	if ($handle =@ opendir("../".$cfg['poster_path'])) {
		while (false !== ($file = @readdir($handle))) { 
			if ($file == "." || $file == ".." || !preg_match('#^([1-9]|[1-9][0-9]|[1-9][0-9][0-9]|[1-9][0-9][0-9][0-9]).pic$#', $file))  continue;
			if (@filetype("../".$cfg['poster_path'].'/'.$file) == "dir")  continue;
			if(@is_readable("../".$cfg['poster_path'].'/'.$file)) {
				$ii = $ii+1;
				$nix = explode(".", $file); $fid = $nix[0];				$fsl = filesize("../".$cfg['poster_path'].'/'.$file);
				$data = file_get_contents("../".$cfg['poster_path'].'/'.$file);
				if(strlen($data)>=$fsl) {
					if(mysql_query('UPDATE movies SET poster=\''.addslashes($data).'\' WHERE fid=\''.$fid.'\'')){
						@unlink("../".$cfg['poster_path'].'/'.$file);
						if($debugging) set2log('copy_f2b: id='.sprintf("%04d",$fid)."\n");
					}else {
						if($debugging) set2log('<strong>ERROR:</strong> id='.sprintf("%04d",$fid).' blob is NOT reachable!'."\n");
					}
				}else {
					if($debugging) set2log('<strong>ERROR:</strong> id='.sprintf("%04d",$fid).' filesize is UNEQUAL to blobsize!'."\n");
				}	
			}else {
				if($debugging) set2log('<strong>ERROR:</strong> id='.sprintf("%04d",$fid).' is NOT readable!'."\n");
			}
   			if ($ii==$t) break;		}
		@closedir($handle);
		@clearstatcache();
	}else {
		if($debugging) set2log('<strong>ERROR:</strong> files in path "'.$cfg['poster_path'].'" are NOT readable!'."\n");
	}
	$i = $i+1;
?>
<html><body>
<script type="text/javascript" language="JavaScript">
<!--
parent.window.dothroughLoop(<?=$n.','.$s?>);
<?php if($i<=$f){?>
window.location.href = "file2blob.php?i=<?= $i.'&f='.$f.'&t='.$t.'&cnt='.$cnt.'&log='.$debugging ?>";
<?php }else {?>
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