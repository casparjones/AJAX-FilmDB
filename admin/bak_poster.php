<?php
/* FilmDB (based on php4flicks) */

/*	bak_poster.php - create zip from posters and send as download. */
	
session_start();
if(!isset($_SESSION['user'])) exit;
if($_SESSION['user']!='admin') exit;
	
require_once('../config/config.php');
if(!$cfg['backup_cmd']) exit;
require_once('../config/zip.lib.php');

$us = ini_get('upload_max_filesize'); $ps = ini_get('post_max_size');
$umf = (int)str_replace("M","",($ps<$us?$ps:$us)); $size = 0;
if($umf<=256) $umf = ($umf*1048576); $mus = round((($umf/1024)/1024),2);

if(@is_readable("../".$cfg['poster_path'])) {	
	foreach (glob("../".$cfg['poster_path']."/{*.pic}", GLOB_BRACE) as $file) {		$size = $size + filesize($file);
	}
	$zipname = "filmdb_poster_".date("ymd-His").".zip"; 
	$zipfile = new zipfile(); $dump_buffer = '';
	if ($handle = @opendir("../".$cfg['poster_path'])) {
		while (false !== ($file = @readdir($handle))) { 
			if ($file == "." || $file == ".." || !preg_match('#^([1-9]|[1-9][0-9]|[1-9][0-9][0-9]|[1-9][0-9][0-9][0-9]).pic$#', $file))  continue;
			if (@filetype("../".$cfg['poster_path'].'/'.$file) == "dir")  continue;
			$f_tmp = @fopen("../".$cfg['poster_path'].'/'.$file,'r');
			if($f_tmp){				$dump_buffer = @fread($f_tmp, @filesize("../".$cfg['poster_path'].'/'.$file));				$zipfile -> addFile($dump_buffer, $file);				@fclose($f_tmp);			}		}
		@closedir($handle);
		if($size==0) {
			$dump_buffer = 'empty';
			$zipfile -> addFile($dump_buffer, 'empty.txt');
		}		$dump_buffer = $zipfile -> file();	}
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
