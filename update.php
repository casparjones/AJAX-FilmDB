<?php
/* FilmDB (based on php4flicks) */

// update.php - update db values

session_start();
// if(!isset($_SESSION['user'])){
// }

require_once('config/config.php');

moviequery('UPDATE movies');
killpeople($_POST['fid']);
addpeople($_POST['fid']);

function addpeople($fid){
	// adds people in $_POST[x], where x={actor,director,writer}.
	// (IGNOREs duplicates).
	if(!isset($_POST['director'])) $_POST['director'] = array();
	if(!isset($_POST['actor'])) $_POST['actor'] = array();
	if(!isset($_POST['writer'])) $_POST['writer'] = array();

	$peoplevalues = '';

	// directors:
	$values = '';
	for($i=0; $i<sizeof($_POST['director']); $i++){
		if($_POST['director'][$i]['name']!='' && $_POST['director'][$i]['id']!= ''){
			$values .= ",('$fid','".$_POST['director'][$i]['id']."')";
			$peoplevalues .= ",('".$_POST['director'][$i]['id']."','".addslashes($_POST['director'][$i]['name'])."')";
		}
	}
	if($values!=''){
		$values = substr($values,1); // 1 ',' too much
		mysql_query("INSERT IGNORE INTO directs(movie_fid,people_id) VALUES $values") or die(mysql_error());
	}

	// actors:
	$values = '';
	for($i=0; $i<sizeof($_POST['actor']); $i++){
		if($_POST['actor'][$i]['name']!='' && $_POST['actor'][$i]['id']!= ''){
			$values .= ",('$fid','".$_POST['actor'][$i]['id']."')";
			$peoplevalues .= ",('".$_POST['actor'][$i]['id']."','".addslashes($_POST['actor'][$i]['name'])."')";
		}
	}
	if($values!=''){
		$values = substr($values,1); // 1 ',' too much
		mysql_query("INSERT IGNORE INTO plays_in(movie_fid,people_id) VALUES $values") or die(mysql_error());
	}

	// and writers...
	$values = '';
	for($i=0; $i<sizeof($_POST['writer']); $i++){
		if($_POST['writer'][$i]['name']!='' && $_POST['writer'][$i]['id']!= ''){
			$values .= ",('$fid','".$_POST['writer'][$i]['id']."')";
			$peoplevalues .= ",('".$_POST['writer'][$i]['id']."','".addslashes($_POST['writer'][$i]['name'])."')";
		}
	}
	if($values!=''){
		$values = substr($values,1); // 1 ',' too much
		mysql_query("INSERT IGNORE INTO writes(movie_fid,people_id) VALUES $values") or die(mysql_error());
	}

	// finally, insert into people table:
	if($peoplevalues != ''){
		$values = substr($peoplevalues,1);
		mysql_query("INSERT IGNORE INTO people VALUES $values");
	}
}
function killpeople($movieid){
	$pers = array();

	$result = mysql_query("SELECT people_id FROM directs WHERE movie_fid = $movieid UNION SELECT people_id FROM writes WHERE movie_fid = $movieid UNION SELECT people_id FROM plays_in WHERE movie_fid = $movieid") or die(mysql_error());  //UNION is supported as of version 4
	while($row = mysql_fetch_row($result))
		$pers[] = $row[0];

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
}
function moviequery($what){
	// updates table.
	// return value: 0

	global $cfg;

	if($_POST['title']=='' || $_POST['nr']=='' || !isset($_POST['imdbid']) || $_POST['imdbid']=='')
		die('some important information is missing! abort');

	if(!in_array($_POST['medium'],$cfg['medium']))
		$_POST['medium'] = $cfg['medium'][0];   //default value

	if(!isset($_POST['lang_array']))
		$_POST['lang_array'] = array($cfg['lang'][0]);  //default value

	$query = $what.' SET ';
	$query .= 'name=\''.addslashes($_POST['title']);
	$query .= '\',local=\''.addslashes($_POST['local']);
	$query .= '\',aka='.($_POST['aka']!=''?('\''.addslashes($_POST['aka']).'\''):'NULL');
	$query .= ',country='.($_POST['country']!=''?('\''.addslashes($_POST['country']).'\''):'NULL');
	$query .= ',cat='.($_POST['cat']!=''?('\''.addslashes($_POST['cat']).'\''):'NULL');
	$query .= ',nr=\''.$_POST['nr'];
	$query .= '\',id=\''.$_POST['imdbid'];
	$query .= '\',runtime=\''.($_POST['runtime']==''?'0':$_POST['runtime']);
	$query .= '\',year='.($_POST['year']!=''?('\''.addslashes($_POST['year']).'\''):'NULL');
	$query .= ',lang=\''.addslashes(implode(',',$_POST['lang_array']));
	$query .= '\',ratio=\''.addslashes($_POST['ratio']);
	$query .= '\',format=\''.addslashes($_POST['format']);
	$query .= '\',medium=\''.addslashes($_POST['medium']);
	$query .= '\',audio=\''.addslashes($_POST['audio']);
	$query .= '\',type=\''.addslashes($_POST['type']);
	$query .= '\',container=\''.addslashes($_POST['container']);
	$query .= '\',video=\''.addslashes($_POST['video']);
	$query .= '\',channel=\''.addslashes($_POST['channel']);
	$query .= '\',herz=\''.addslashes($_POST['herz']);
	$query .= '\',width=\''.($_POST['width']==''?'0':$_POST['width']);
	$query .= '\',height=\''.($_POST['height']==''?'0':$_POST['height']);
	$query .= '\',disks=\''.($_POST['disks']==''?'1':$_POST['disks']);
	$query .= '\',rating=\''.($_POST['rating']==''?'0':$_POST['rating']);
	$query .= '\',avail=\''.($_POST['avail']==''?'1':$_POST['avail']);
	$query .= '\',lentsince=\''.($_POST['lentsince']==''?'':$_POST['lentsince']);
	$query .= '\',lentto=\''.($_POST['lentto']==''?'0':$_POST['lentto']);
	$query .= '\',comment='.($_POST['comment']!=''?('\''.addslashes($_POST['comment']).'\''):'NULL');
	$query .= isset($_POST['genre_array'])?',genre=\''.addslashes(implode(',',$_POST['genre_array'])).'\'':'';

	if($_POST['setposter'] != 'false' && $_POST['setposter'] != ''){
		// pic must be updated, was stored in session data
		if(!$cfg['use_blob']) {
			if(is_writable($cfg['poster_path'])) {
				$file=$cfg['poster_path'].'/'.$_POST['fid'].'.pic';
				$fsp = fopen($file,"wb");
				if($fsp) {
					fwrite($fsp, $_SESSION['image'][$_POST['imdbid']]);
					fclose($fsp);
				}
			}
		}else {
			$query .= ',poster=\''.addslashes($_SESSION['image'][$_POST['imdbid']]).'\'';
		}
		unset($_SESSION['image']);
	} else if ($_POST['setposter'] == 'false'){
		$query .= ',poster=NULL';
		$file=$cfg['poster_path'].'/'.$_POST['fid'].'.pic';
		if(is_readable($file)) {
			unlink($file);
		}
	} // else poster remains unaffected or in case of insert is set to NULL

	$query .= ' WHERE fid=\''.$_POST['fid'].'\'';

	mysql_query($query) or die(mysql_error());
	return mysql_insert_id();
}
header('location: list.php?'.$_SESSION['tmpstr']);
?>
