<?php
/* FilmDB (based on php4flicks) */

/*	bak_dbase.php - create zip from database and send as download. */

session_start();
if(!isset($_SESSION['user'])) exit;
if($_SESSION['user']!='admin') exit;
	
require_once('../config/config.php');
if(!$cfg['backup_cmd']) exit;
require_once('../config/zip.lib.php');

$filename = "filmdb.sql"; 
$zipname = "filmdb_dbase_".date("ymd-His").".zip";
$dbase = $cfg['mysql_db']; $slf = "\n"; $dlf = "\n\n";

$dump_buffer = '# AJAX-FilmDB'.$slf;$dump_buffer .= '# Version '.$cfg['filmdb_version'].' '.$cfg['filmdb_release'].$slf;
$dump_buffer .= '# http://sourceforge.net/projects/ajaxfilmdb/'.$slf.'#'.$slf;$dump_buffer .= '# Host: '.$_SERVER["HTTP_HOST"].$slf;$dump_buffer .= '# Creation Date: '.date("d-M-Y H:i:s").$slf;
$dump_buffer .= '# Server Version: '.mysql_get_server_info().$slf;$dump_buffer .= '# PHP-Version: '.phpversion().$slf;
$dump_buffer .= '#'.$slf.'# Charset: `'.$sqltype.'`'.$slf;$dump_buffer .= '#'.$slf.'# Database: `'.$dbase.'`'.$dlf;$dump_buffer .= '# --------------------------------------------------------'.$slf;

// $query = 'SHOW TABLES FROM '.$dbase.'';
// Access denied for user 'sql11490'@'%' to database 'filmdb'
// $result = mysql_query($query); // or die(mysql_error());
// $noe = mysql_num_rows($result);

$table = array('movies','people','directs','writes','plays_in');
$noe = count($table);

if($noe > 0) {
	/* mysql_query('LOCK TABLES directs WRITE, movies WRITE, people WRITE, plays_in WRITE, writes WRITE') or die(mysql_error()); */
	for($i=0; $i<$noe; $i++){
		// $tmp = mysql_fetch_row($result);
		// $table[$i] = $tmp[0];
		$query = 'SHOW CREATE TABLE '.$table[$i].'';
		$reso = mysql_query($query) or die(mysql_error());
		if(mysql_num_rows($reso) > 0) {
			$src = mysql_fetch_array($reso);
			$dump_buffer .= $slf.'# create table structure `'.$table[$i].'`'.$dlf;			$dump_buffer .= 'DROP TABLE IF EXISTS `'.$table[$i].'`;'.$slf;
			if($table[$i]=='movies'){
				$check = 'SELECT max(fid) AS fid FROM `movies`';
				$res = mysql_query($check) or die(mysql_error());
				$fid = mysql_fetch_array($res);
				$dump_buffer .= implode("",explode("\n", $src[1]))." AUTO_INCREMENT=".($fid[0]+1).";".$dlf;
			 	// $dump_buffer .= $src[1]." AUTO_INCREMENT=".($fid[0]+1).";".$dlf;
			}else {
				$dump_buffer .= implode("",explode("\n", $src[1])).";".$dlf;
				// $dump_buffer .= $src[1].";".$dlf;
			}
			if($table[$i]!='movies'){
				$querie = 'SELECT * FROM '.$table[$i].' '; // LIMIT 10
				$res = mysql_query($querie) or die(mysql_error());
				$noi = mysql_num_rows($res);
				if($noi > 0) {
					if($table[$i]!='people'){
						for($j=0; $j<$noi; $j++){
							$scr = mysql_fetch_row($res);
							$dump_buffer .= 'INSERT INTO `'.$table[$i].'` VALUES ('.$scr[0].', '.$scr[1].');'.$slf;
						}
					}else {
						for($j=0; $j<$noi; $j++){
							$scr = mysql_fetch_row($res);
							$dump_buffer .= 'INSERT INTO `'.$table[$i].'` VALUES ('.$scr[0].', \''.addslashes($scr[1]).'\');'.$slf;
						}
					}
				}
			}else {
				$querie = 'SELECT * FROM '.$table[$i].' ORDER BY fid '; // LIMIT 10
				$res = mysql_query($querie) or die(mysql_error());
				$noi = mysql_num_rows($res);
				if($noi > 0) {
					for($j=0; $j<$noi; $j++){
						$scr = mysql_fetch_row($res);
						$nos = count($scr);
						$dump_buffer .= 'INSERT INTO `'.$table[$i].'` VALUES (';
						for($k=0; $k<($nos-1); $k++){
							if(($k>=0&&$k<=3)||$k==12||$k==13||$k==19||$k==20||$k==27||$k==29){
								$dump_buffer .= (strlen($scr[$k])==0?"NULL":$scr[$k]).', ';
							}else {
								if($k==21||$k==22||$k==23||$k==26){
									$dump_buffer .= (strlen($scr[$k])==0?"NULL":'\''.preg_replace("!\r\n|\r|\n!", '\r\n', addslashes($scr[$k])).'\'').', ';
								}else {
									$dump_buffer .= (strlen($scr[$k])==0?"NULL":'\''.$scr[$k].'\'').', ';
								}
							}
						}
						$dump_buffer .= (strlen($scr[$k])==0?"NULL":'0x'.bin2hex($scr[$k])).');'.$slf;
					}
				}
			}
		}
	}
	/* mysql_query('UNLOCK TABLES') or die(mysql_error()); */
}

$zipfile = new zipfile(); 
$zipfile ->addFile($dump_buffer, $filename); 
$dump_buffer = $zipfile -> file(); 
header('Content-type: application/zip');
header('Expires: '.gmdate('D, d M Y H:i:s').' GMT');
header('Content-Description: FilmDB Poster Export');
header('Content-length: '.strlen($dump_buffer));
if(preg_match('@MSIE ([0-9].[0-9]{1,2})@', $_SERVER["HTTP_USER_AGENT"])) {
	header('Content-Disposition: inline; filename="'.$zipname.'"');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
} else {
	header('Content-Disposition: attachment; filename="'.$zipname.'"');
	header('Pragma: no-cache');
}
echo $dump_buffer;
$dump_buffer = '';
	
exit;
?>
