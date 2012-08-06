<?php
/* FilmDB (based on php4flicks) */

// delete.php - delete film from db

session_start();
// if(!isset($_SESSION['user'])){
// }

require_once('config/config.php');

// allow id to be passed via GET or POST method
if(isset($_GET['fid'])) $movieid = $_GET['fid'];
elseif(isset($_POST['fid'])) $movieid = $_POST['fid'];
else die('error: no movie id');

// delete movie:
mysql_query("DELETE FROM movies WHERE fid=$movieid") or die(mysql_error());
$file=$cfg['poster_path'].'/'.$movieid.'.pic';
if(is_readable($file)) {
	unlink($file);
}

$pers = array();

// UNION is supported as of version 4
$result = mysql_query("SELECT people_id FROM directs WHERE movie_fid = $movieid UNION SELECT people_id FROM writes WHERE movie_fid = $movieid UNION SELECT people_id FROM plays_in WHERE movie_fid = $movieid") or die(mysql_error());
while($row = mysql_fetch_row($result)){
	$pers[] = $row[0];
}
// delete all of it...
mysql_query("DELETE FROM directs WHERE movie_fid = $movieid") or die(mysql_error());
mysql_query("DELETE FROM plays_in WHERE movie_fid = $movieid") or die(mysql_error());
mysql_query("DELETE FROM writes WHERE movie_fid = $movieid") or die(mysql_error());

// ...and delete in people table, if necessary:
foreach($pers as $p){
	// check if other references to this person exist
	$result = mysql_query("SELECT people_id FROM directs WHERE people_id = $p UNION SELECT people_id FROM writes WHERE people_id = $p UNION SELECT people_id FROM plays_in WHERE people_id = $p") or die(mysql_error());
	if(mysql_num_rows($result)==0) mysql_query("DELETE FROM people WHERE id = $p") or die(mysql_error());
}
header('location: list.php?'.$_SESSION['tmpstr']);
?>
