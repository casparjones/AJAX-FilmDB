<?php
/* FilmDB (based on php4flicks) */

// insert.php - insert values from form into db

session_start();
// if(!isset($_SESSION['user'])){
// }

require_once('config/config.php');

$insertid = moviequery('INSERT INTO movies');
addpeople($insertid);
if(!$cfg['use_blob']&&$_POST['setposter']!='false'&&$_POST['setposter']!=''){
	if(is_writable($cfg['poster_path'])) {
		$file=$cfg['poster_path'].'/'.$insertid.'.pic';
		$fsp = fopen($file,"wb");
		if($fsp) {
			fwrite($fsp, $_SESSION['image'][$_POST['imdbid']]);
			fclose($fsp);
		}
	}
}
unset($_SESSION['image']);

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
function moviequery($what){
	// inserts into table. $what must be 'INSERT INTO ...' or 'UPDATE ...'
	// return value: newly generated fid for inserts (auto increment)

	global $cfg;

	if($_POST['title']=='' || $_POST['nr']=='' || !isset($_POST['imdbid']) || $_POST['imdbid']=='')
		die('Some important information is missing!<br><button name="ok" type="button" value="OK" style="cursor:pointer;width:100%;text-align:center;" onClick="showRequest(false,'.'\'editreq\''.',true);">&nbsp;&nbsp;<b>OK</b>&nbsp;&nbsp;</button>');

	if(!in_array($_POST['medium'],$cfg['medium']))
		$_POST['medium'] = $cfg['medium'][0];   //default value

	if(!isset($_POST['lang_array']))
		$_POST['lang_array'] = array($cfg['lang'][0]);  //default value

	$query = $what.' SET ';
	$query .= 'name=\''.addslashes($_POST['title']);
	$query .= '\',local='.($_POST['local']!=''?('\''.addslashes($_POST['local']).'\''):('\''.addslashes($_POST['title']).'\''));
	$query .= ',aka='.($_POST['aka']!=''?('\''.addslashes($_POST['aka']).'\''):'NULL');
	$query .= ',country='.($_POST['country']!=''?('\''.addslashes($_POST['country']).'\''):'NULL');
	$query .= ',cat='.($_POST['cat']!=''?('\''.addslashes($_POST['cat']).'\''):'NULL');
	$query .= ',nr=\''.$_POST['nr'];
	$query .= '\',id=\''.$_POST['imdbid'];
	$query .= '\',width=\''.($_POST['width']==''?'0':$_POST['width']);
	$query .= '\',height=\''.($_POST['height']==''?'0':$_POST['height']);
	$query .= '\',disks=\''.($_POST['disks']==''?'1':$_POST['disks']);
	$query .= '\',rating=\''.($_POST['rating']==''?'0':$_POST['rating']);
	$query .= '\',avail=\''.($_POST['avail']==''?'1':$_POST['avail']);
	$query .= '\',lentsince=\''.($_POST['lentsince']==''?'':$_POST['lentsince']);
	$query .= '\',lentto=\''.($_POST['lentto']==''?'0':$_POST['lentto']);
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
	$query .= '\',comment='.($_POST['comment']!=''?('\''.addslashes($_POST['comment']).'\''):'NULL');
	$query .= isset($_POST['genre_array'])?',genre=\''.addslashes(implode(',',$_POST['genre_array'])).'\'':'';

	$query .= ',inserted=CURDATE()';

	if($_POST['setposter'] != 'false' && $_POST['setposter'] != ''){
		// pic must be updated, was stored in session data
		if(!$cfg['use_blob']) {
			$query .= ',poster=NULL';
		}else {
			$query .= ',poster=\''.addslashes($_SESSION['image'][$_POST['imdbid']]).'\'';
		}
	} else if ($_POST['setposter'] == 'false'){
		$query .= ',poster=NULL';
	} // else poster remains unaffected or in case of insert is set to NULL

	mysql_query($query) or die(mysql_error());
	return mysql_insert_id();
}
header('location: list.php?'.$_SESSION['tmpstr']);
?>
