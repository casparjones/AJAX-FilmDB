<?php
/* FilmDB (based on php4flicks) */

/* edit.php - get data from db and display form to edit it */

require('config/config.php');

session_start();
// if(!isset($_SESSION['user'])){
// }

if(!isset($_GET['action'])) $_GET['action'] = '';

$referer= 'edit.php?fid='.$_GET['fid'].'&';

$b_back 	= "parent.window.document.remember.submit();";
$b_delete 	= "show_Request(true,'editreq','deletefilm.php?fid=".$_GET['fid']."')";
$b_rescan 	= "show_Request(true,'editreq','rescanfilm.php?fid=".$_GET['fid']."')";
$b_export 	= "show_Request(true,'editreq','exportfilm.php?fid=".$_GET['fid']."')";
$b_save 	= "document.data.action='update.php';if(check()){document.data.submit();this.onclick='return false';}";


switch($_GET['action']){
	case '':
		require_once('config/config.php');
	
		// get data
		
		$result = mysql_query('SELECT name,local,aka,cat,nr,id,runtime,year,genre,container,disks,type,video,audio,lang,ratio,format,medium,channel,herz,width,height,country,rating,avail,lentto,lentsince,comment FROM movies WHERE fid=\''.$_GET['fid'].'\'') or die(mysql_error());
		$row = mysql_fetch_array($result);
		$title = htmlspecialchars($row['name']);
		$local = htmlspecialchars($row['local']);
		$aka = htmlspecialchars($row['aka']);
		$country = htmlspecialchars($row['country']);
		$year = $row['year'];
		$imdbid = $row['id'];
		$fid = $_GET['fid'];
		$runtime = $row['runtime'];
		$cat = $row['cat'];
		$nr = $row['nr'];
		$slang = explode(',',$row['lang']);
		$sgenre = explode(',',$row['genre']);
		$smedium = $row['medium'];
		$sformat = $row['format'];
		$sratio = $row['ratio'];
		$saudio = $row['audio'];
		$stype = $row['type'];
		$scontainer = $row['container'];
		$svideo = $row['video'];
		$schannel = $row['channel'];
		$sherz = $row['herz'];
		$width = $row['width'];
		$height = $row['height'];
		$disks = $row['disks'];
		$rating = $row['rating'];
		$avail = $row['avail'];
		$lentsince = $row['lentsince'];
		$lentto = $row['lentto'];
		$comment = $row['comment'];
		$setposter = false;
		//directors,actors,writers:
		$director = getpeople('directs');
		$writer = getpeople('writes');
		$actor = getpeople('plays_in');

		$new_title  =  rawurlencode($row['name']); // str_replace("'",'',$title);
		$new_local  =  rawurlencode($row['local']); // str_replace("'",'',$local);
		$b_export 	= "show_Request(true,'editreq','exportfilm.php?fid=".$fid."&title=".$new_title."&local=".$new_local."')";
		$b_rescan 	= "show_Request(true,'editreq','rescanfilm.php?fid=".$fid."&title=".$new_title."&local=".$new_local."')";
		$b_delete 	= "show_Request(true,'editreq','deletefilm.php?fid=".$fid."&title=".$new_title."&local=".$new_local."')";
		$b_save 	= "document.data.action='update.php';if(check()){document.data.submit();this.onclick='return false';show_Request(true,'editreq','updatefilm.php?title=".$new_title."&local=".$new_local."');}";

		// display it!
		include('filmform.php');
		break;
	
	case 'reload':
		// if this is set, filmform gets its data from POST array
		$reload = true;
		include('filmform.php');
	
	default: break;
}
function getpeople($table){
	global $fid;
	$out = array();
	$res = mysql_query("SELECT people.id,people.name FROM $table,people WHERE $table.movie_fid =$fid AND $table.people_id = people.id ORDER BY people.id") or die(mysql_error());
	while($row = mysql_fetch_row($res)){
		$out[] = array('id'=>$row[0], 'name'=>$row[1]); 
	}
	return $out;
}
?>
