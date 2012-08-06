<?php
/* FilmDB (based on php4flicks) */

// delete.php - delete film from db

session_start();
// if(!isset($_SESSION['user'])){
// }

/*	rescan.php - get information from imdb and display it. 
	pml fetch class is used to fetch data from imdb. 
	available vars of doFetch():

	"Title",			string
	"Year",				int
	"Poster",			url
	"Director",			array of array(string'id',string'name')
	"Credits",			array of array(string'id',string'name')
	"Genre",			array of string
	"Rating",			int (real)
	"Starring",			array of array(string'id',string'name')
	"Plot",				string 
	"Release",			date (1999-03-07)
	"Runtime",			int
	"imdbid",			string
	"aka",				string
	"Country"			string
*/

require_once('config/config.php');
require_once('imdb/fetch_movie.php');
require_once("imdbphp/imdb.class.php");
require_once("imdbphp/pilot.class.php");
require_once("imdbphp/imdbMapper.class.php");

$FetchClass = new fetch_movie($cfg['searchLimit'],$cfg['actorLimit']);

// <a target="mainframe" href="rescan.php?action=rescan&fid=000&FetchID=0371626"></a>

switch($_GET['action']) {
	case 'rescan':
	
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
	
		// get all the imdb data and display it
		$movie = new imdb($imdbid);
        $pilot = new pilot($imdbid);
		$movie->setid($imdbid);
		$pilot->setid($imdbid);
		
		$data['imdbid']   = $movie->imdbid();
		$data['title']    = $movie->title();
        $data['locale']   = $pilot->title();
		$data['year']     = $movie->year();
		$data['poster']   = $movie->photo(true);
		$data['director'] = $movie->director();
		$data['writer']   = $movie->writing();
		$data['runtime']  = $movie->runtime();
		$data['country']  = $movie->country();
		$data['rating']   = ($movie->rating() * 10);
		$data['actor']    = $movie->cast();
		$data['aka']      = $movie->alsoknow();
		$data['sgenre']   = $movie->genres();
		$data['comment']  = $pilot->plot();
		
		extract($data);
		
		
		$country = array_pop($country);
		$comment = utf8_decode(array_pop($comment));
		$aka     = imdbMapper::mapAka($aka);
		
		// var_dump($aka, $data['aka']); die();
		
		$actor    = imdbMapper::mapActors($actor);
		$director = imdbMapper::mapActors($director);
		$writer   = imdbMapper::mapActors($writer);
		
		//poster
		if($poster){
			//fetch poster: (=>$_SESSION['image'][_movieid_])
			if (function_exists('gd_info')) {
				$ver = gd_info();
				preg_match('/\d/', $ver['GD Version'], $match);
				if ($match[0]>=2){
					include('fetchimggd.php');
				}else {
					include('fetchimg.php');
				}
			}else {
				include('fetchimg.php');
			}
			fetchimg($imdbid,$poster);
			$setposter = true;
		} else {
			$setposter = false;
		}

		// now show it!
		$referer= 'rescan.php?';

		$new_title =  rawurlencode($row['name']); // str_replace("'",'',$title);
		$new_local =  rawurlencode($row['local']); // str_replace("'",'',$local);
		$b_back 	= "parent.window.document.remember.submit();";
		$b_cancel 	= "parent.window.document.remember.submit();";
		$b_rescan 	= "show_Request(true,'editreq','rescanfilm.php?fid=".$fid."&title=".$new_title."&local=".$new_local."')";
		$b_delete 	= "show_Request(true,'editreq','deletefilm.php?fid=".$fid."&title=".$new_title."&local=".$new_local."')";
		$b_save 	= "document.data.action='update.php';if(check()){document.data.submit();this.onclick='return false';show_Request(true,'editreq','updatefilm.php?title=".$new_title."&local=".$new_local."');}";

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
