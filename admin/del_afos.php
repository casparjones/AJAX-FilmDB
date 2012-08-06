<?php
/* FilmDB (based on php4flicks) */

/* del_afos.php delete all poster files on server */

session_start();
if(!isset($_SESSION['user'])) exit;
if($_SESSION['user']!='admin') exit;
	
require_once('../config/config.php');
if(!$cfg['server_cmd']) exit;
require_once('../config/debug.php');

$debugging = false;

if(isset($_POST['first_time'])){
	if(isset($_POST['log'])&&$_POST['log']==true) $debugging = true;
	$cnt = count(glob("../".$cfg['poster_path']."/{*.pic}", GLOB_BRACE));
	if($debugging){
		set2log("\n".'<dfn>LOG:</dfn> '.date("d-M-Y H:i:s")."\n".'<dfn>CMD:</dfn> "'.$trans['l_del_files'].'"'."\n");
	}
	if($cfg['use_progress']==true&&$cnt>50){
		if(@is_readable("../".$cfg['poster_path'])) {
			@clearstatcache();		
			$f = ($cnt>1000?15:31); $t = floor($cnt/$f); $r = ($cnt%$f); if($r>0) $f = $f+1;
			header('location: del_files.php?i=1&f='.$f.'&t='.$t.'&cnt='.$cnt.'&log='.$debugging);
		}
	 }else {
		if(@is_readable("../".$cfg['poster_path'])) {
			if($cnt>0) {
				@clearstatcache();
				if ($handle = @opendir("../".$cfg['poster_path'])) {
					$error = 0;
					while (false !== ($file = @readdir($handle))) { 
						if ($file == "." || $file == ".." || !preg_match('#^([1-9]|[1-9][0-9]|[1-9][0-9][0-9]|[1-9][0-9][0-9][0-9]).pic$#', $file))  continue;
						if (@filetype("../".$cfg['poster_path'].'/'.$file) == "dir")  continue;
						if(@is_readable("../".$cfg['poster_path'].'/'.$file)) {
							$foo = explode(".", $file); $fid = $foo[0];							@unlink("../".$cfg['poster_path'].'/'.$file);
							if($debugging) set2log('del_files: id='.sprintf("%04d",$fid)."\n");
						}else {
							if($debugging) set2log('<strong>ERROR:</strong> id='.sprintf("%04d",$fid).' is NOT readable!'."\n");
						}
					}
					@closedir($handle);
					@clearstatcache();
				}else {
					$error = 2;
					if($debugging) set2log('<strong>ERROR:</strong> files in path "'.$cfg['poster_path'].'" are NOT readable!'."\n");
				}
			}else {
				$error = 1;
				if($debugging) set2log('<var>WARNING:</var> NO files in poster path "'.$cfg['poster_path'].'"!'."\n");
			}
		}else {
			$error = 2;
			if($debugging) set2log('<strong>ERROR:</strong> poster path "'.$cfg['poster_path'].'" is NOT readable!'."\n");
		}
?>
<html><body onLoad="parent.window.doafterLoop(<?= $error ?>);"></body></html>
<?php }
}else {
	exit;
}
?>