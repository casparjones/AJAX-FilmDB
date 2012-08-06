<?php
/* FilmDB (based on php4flicks) */

/*	bak_poster.php - create zip from posters and send as download. */
	
session_start();
if(!isset($_SESSION['user'])) exit;
if($_SESSION['user']!='admin') exit;

require_once('../config/config.php');
if(!$cfg['backup_cmd']) exit;
require_once('../config/zip.lib.php');

if(isset($_GET['name'])&&isset($_GET['noi'])&&isset($_GET['sti'])){
	$zipname = $_GET['name']; $stt = $_GET['sti']; $cnt = $_GET['noi']; $dump_buffer = '';
}else if(isset($_POST['val'])&&isset($_POST['noi'])&&isset($_POST['sti'])){
	$zipname = $_POST['val']; $stt = $_POST['sti']; $cnt = $_POST['noi']; $dump_buffer = '';
}else {
	exit;
}

if(@is_readable("../".$cfg['poster_path'])) {	
	foreach (glob("../".$cfg['poster_path']."/{*.pic}", GLOB_BRACE) as $file) {		$pic[] = basename($file);
	}
	$zipfile = new zipfile(); $x = $stt;
	for($i=0; $i<$cnt; $i++){
		$f_tmp = @fopen("../".$cfg['poster_path'].'/'.$pic[$x],'r');
		if($f_tmp){			$dump_buffer = @fread($f_tmp, @filesize("../".$cfg['poster_path'].'/'.$pic[$x]));			$zipfile -> addFile($dump_buffer, $pic[$x]);			@fclose($f_tmp);		}
		$x += 1;
	}
	$dump_buffer = $zipfile -> file();
	header('Content-type: application/zip');
	header('Expires: '.gmdate('D, d M Y H:i:s').' GMT');
	header('Content-Description: FilmDB Poster Export');
	header('Content-length: '.strlen($dump_buffer));
	if (preg_match('@MSIE ([0-9].[0-9]{1,2})@', $_SERVER["HTTP_USER_AGENT"])) {
		header('Content-Disposition: inline; filename="'.$zipname.'"');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
	} else {
		header('Content-Disposition: attachment; filename="'.$zipname.'"');
		header('Pragma: no-cache');
	}
	echo $dump_buffer;
	$dump_buffer = '';
}	
exit;
?>
