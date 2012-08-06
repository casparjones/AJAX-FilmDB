<?php
/* FilmDB (based on php4flicks) */
	
/*	res_poster.php - restore posters from backup zip. */

session_start();
if(!isset($_SESSION['user'])) exit;
if($_SESSION['user']!='admin') exit;
	
require_once('../config/config.php');
if(!$cfg['restore_cmd']) exit;
require_once('../config/debug.php');
require_once('../config/unzip.lib.php');
	
/* $filename = dirname($_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF']).$cfg['uploads']; */
/* $savepath = dirname($_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF']).'/'.$cfg['poster_path'].'/'; */
$filename = "..".$cfg['uploads'];
$savepath = "../".$cfg['poster_path'].'/'; 

$debugging = false;

if(isset($_POST['first_time'])){
	if(isset($_POST['log'])&&$_POST['log']==true) $debugging = true;
	if($debugging){
		set2log("\n".'<dfn>LOG:</dfn> '.date("d-M-Y H:i:s")."\n".'<dfn>CMD:</dfn> "'.$trans['l_res_poster'].'"'."\n");
	}
	if(@is_writable("../".$cfg['poster_path'])) {
		$file = @fopen($filename,'rb');	
		if($file){
			$test = @fread($file, 4); @fclose($file);
			if($test=="PK\003\004"&&@function_exists('gzinflate')) {
				$handle = new SimpleUnzip();
				$handle->ReadFile($filename);
				$cnt = $handle->Count();
				if($cnt>0 && $handle->GetError(0)==0) {
					$error = 0;	
					@set_time_limit($cfg['time_limit']);
					for($i=0; $i<$cnt; $i++){
						$name = $handle->GetName($i);
						$data = $handle->GetData($i);
						$foo = explode(".", $name); $fid = $foo[0];
						$fwp = @fopen($savepath.$name, "wb");
						if($fwp){
							@fwrite($fwp, $data);							@fclose($fwp);
							if($debugging) set2log('res_poster: id='.sprintf("%04d",$fid)."\n");
						}else {
							if($debugging) set2log('<strong>ERROR:</strong> id='.sprintf("%04d",$fid).' is NOT writable!'."\n");
						}
					}
					@set_time_limit(ini_get('max_execution_time'));
					$fp = @fopen($filename,'w');
					@fwrite($fp, '');
					@fclose($fp);
					@clearstatcache();
				}else {
					$error = 1;
					if($debugging) set2log('<var>WARNING:</var> NO poster files in zip archive!'."\n");
				}				
			}else {
				$error = 1; 
				if($debugging) set2log('<var>WARNING:</var> Server do NOT support zlib!'."\n");
			}				
		}else {
			$error = 2;
			if($debugging) set2log('<strong>ERROR:</strong> zip archive is NOT readable!'."\n");
		}
	}else {
		$error = 2;
		if($debugging) set2log('<strong>ERROR:</strong> poster path "'.$cfg['poster_path'].'" is NOT writable!'."\n");
	}
?>
<html><body onLoad="parent.window.doafterLoop(<?= $error ?>);"></body></html>
<?php
}else {
	exit;
}
?>
