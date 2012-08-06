<?php
/* FilmDB (based on php4flicks) */

/*	res_dbase.php - restore data base from backup zip. */

session_start();
if(!isset($_SESSION['user'])) exit;
if($_SESSION['user']!='admin') exit;
	
require_once('../config/config.php');
if(!$cfg['restore_cmd']) exit;
require_once('../config/debug.php');
require_once('../config/unzip.lib.php');
	
/* $filename = dirname($_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF']).$cfg['uploads']; */
$filename = "..".$cfg['uploads']; 

$debugging = false;

if(isset($_POST['first_time'])){
	if(isset($_POST['log'])&&$_POST['log']==true) $debugging = true;
	if($debugging){
		set2log("\n".'<dfn>LOG:</dfn> '.date("d-M-Y H:i:s")."\n".'<dfn>CMD:</dfn> "'.$trans['l_res_dbase'].'"'."\n");
	}
	$file = @fopen($filename,'rb');	
	if($file){	
		@fclose($file);
		$handle = new SimpleUnzip();
		$handle->ReadFile($filename);
		$cnt = $handle->Count();
		if($cnt>0 && $handle->GetError(0)==0) {
			$data = explode("\n", $handle->GetData(0));
			if(sizeof($data)>=39){
				$error = 0;			
				foreach($data as $key => $value) {
					if(preg_match('!^(#.*|[ ]*)$!i', $value)) unset($data[$key]);				}
				if(sizeof($data)>=10){
					$data = array_values($data);
					@set_time_limit($cfg['time_limit']);
					foreach($data as $key => $value) {
						$query = substr($data[$key],0,strlen($data[$key])-1);
						if(mysql_query($query)) {
							if($debugging) set2log('res_dbase: "'.substr($value, 0, 48).'..."'."\n");
							unset($data[$key]);
						}else {
							if($debugging) set2log('<strong>ERROR:</strong> "'.substr($value, 0, 48).'..." is NOT executable!'."\n");
						}					}
					@set_time_limit(ini_get('max_execution_time'));
					$fp = @fopen($filename,'w');
					@fwrite($fp, '');
					@fclose($fp);
					@clearstatcache();
				}else {
					$error = 1;
					if($debugging) set2log('<var>WARNING:</var> NO commands in sql file!'."\n");
				}
			}else {
				$error = 1;
				if($debugging) set2log('<var>WARNING:</var> NOT enough commands in sql file!'."\n");
			}
		}else {
			$error = 1;
			if($debugging) set2log('<var>WARNING:</var> NO sql file in zip archive!'."\n");
		}
	}else {
		$error = 2;
		if($debugging) set2log('<strong>ERROR:</strong> archive/file is NOT readable!'."\n");
	}
?>
<html><body onLoad="parent.window.doafterLoop(<?= $error ?>);"></body></html>
<?php
}else {
	exit;
}
?>
