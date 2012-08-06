<?php
/* FilmDB (based on php4flicks) */

// this is used for exporting films only

require('config/config.php');

// allow fid or imdbid to be passed via GET or POST method
// allow file to be written to disc or to be streamed

if(isset($_POST['file_id'])||isset($_POST['imdb_id'])){
	if(isset($_POST['file_id'])){
		$filmid = $_POST['file_id'];
	}
	if(isset($_POST['imdb_id'])){ 
		$searchid = $_POST['imdb_id'];
	}
	if(isset($_POST['stream'])){ 
		$streaming = true;
	}
	if(isset($_POST['dtd'])){
		if($_POST['dtd']!=''){
			$dtd_inc = $_POST['dtd'];
		}
	}
}else if(isset($_GET['file_id'])||isset($_GET['imdb_id'])){ 
	if(isset($_GET['file_id'])){ 
		$filmid = $_GET['file_id'];
	}
	if(isset($_GET['imdb_id'])){ 
		$searchid = $_GET['imdb_id'];
	} 
	if(isset($_GET['stream'])){ 
		$streaming = true;
	}
	if(isset($_GET['dtd'])){
		if($_GET['dtd']!=''){
			$dtd_inc = $_GET['dtd'];
		}
	}
} else {
	die('error: no movie id');
}

if(isset($searchid)){
	if(preg_match('#([0-9]{7})#',$searchid)){
		$result = mysql_query("SELECT SQL_CALC_FOUND_ROWS fid FROM movies WHERE id like '$searchid'") or die(mysql_error());
		$row = mysql_fetch_row($result);
		if(isset($row[0])){
			$filmid = $row[0];
		}
	}
}

if(isset($filmid)){
	function getpeople($table,$fid){
		$out = array();
		$res = mysql_query("SELECT people.id,people.name FROM $table,people WHERE $table.movie_fid =$fid AND $table.people_id = people.id ORDER BY people.id") or die(mysql_error());
		while($row = mysql_fetch_row($res)){
			$out[] = array('id'=>$row[0], 'name'=>$row[1]); 
		}
		return $out;
	}
	$director = getpeople('directs',$filmid);
	$writer = getpeople('writes',$filmid);
	$actor = getpeople('plays_in',$filmid);
	$result = mysql_query('SELECT name,local,year,runtime,medium,container,disks,type,video,audio,lang,ratio,format,channel,herz,width,height,country,rating,avail,lentto,lentsince,inserted,aka,id,fid,nr,cat,genre,comment FROM movies WHERE fid=\''.$filmid.'\'') or die(mysql_error());
	$row = mysql_fetch_array($result);
	
	$the_filename = "filmdb_export_".$row['id'].".xml"; 
	
	header( "Content-Description: FilmDB XML Export" );
	header( "Content-type: application/xhtml+xml; charset=$xmltype" );
	if(!isset($streaming)){
		header( "Content-Disposition: attachment; filename=$the_filename" );
        header("Pragma: no-cache");
	}	 
	echo "<?xml version='1.0' encoding='".$xmltype."'?>\n";
	
	if(isset($dtd_inc)){
		if($dtd_inc=="external"){
			if(!preg_match('!^http.*$!',$cfg["dtd_path"])){
				echo '<!DOCTYPE film SYSTEM "'.dirname($_SERVER['SCRIPT_URI']).$cfg["dtd_path"].'">'."\n";
			} else {
				echo '<!DOCTYPE film SYSTEM "'.$cfg["dtd_path"].'">'."\n";
			}	
		} else if($dtd_inc=="internal"){
			include('config/ajax_filmdb_inc.dtd');
		}
	}
		
	echo "<film id='".$row['id'].'-'.$row['fid']."' creator='AJAX-FilmDB' version='".$cfg['filmdb_version']."'>\n";
	echo "\t<properties>\n";
	
	echo "\t\t<fid>".$row['fid']."</fid>\n";
	echo "\t\t<imdb>".$row['id']."</imdb>\n";
	echo "\t\t<cat>".$row['cat']."</cat>\n";
	echo "\t\t<nr>".$row['nr']."</nr>\n";
	
	echo "\t\t<title>".str_replace("&","&amp;",$row['name'])."</title>\n";
	echo "\t\t<local>".str_replace("&","&amp;",$row['local'])."</local>\n";
	echo "\t\t<aka>".preg_replace("((\r\n|\n|\r)+)", "|", str_replace("&","&amp;",$row['aka']))."</aka>\n";
	
	echo "\t\t<inserted>".$row['inserted']."</inserted>\n";
	echo "\t\t<comment>".str_replace("&","&amp;",$row['comment'])."</comment>\n";
	echo "\t\t<rating>".$row['rating']."</rating>\n";
	echo "\t\t<country>".str_replace("&","&amp;",$row['country'])."</country>\n";
	echo "\t\t<year>".$row['year']."</year>\n";
	echo "\t\t<runtime>".$row['runtime']."</runtime>\n";
	echo "\t\t<lang>".$row['lang']."</lang>\n";
	echo "\t\t<genre>".$row['genre']."</genre>\n";
	
	echo "\t\t<disks>".$row['disks']."</disks>\n";
	echo "\t\t<medium>".$row['medium']."</medium>\n";
	echo "\t\t<type>".$row['type']."</type>\n";
	echo "\t\t<container>".$row['container']."</container>\n";
	
	echo "\t\t<video>".$row['video']."</video>\n";
	echo "\t\t<width>".$row['width']."</width>\n";
	echo "\t\t<height>".$row['height']."</height>\n";
	echo "\t\t<format>".$row['format']."</format>\n";
	echo "\t\t<ratio>".str_replace("&","&amp;",$row['ratio'])."</ratio>\n";
	
	echo "\t\t<audio>".$row['audio']."</audio>\n";
	echo "\t\t<channel>".$row['channel']."</channel>\n";
	echo "\t\t<herz>".$row['herz']."</herz>\n";
	
	echo "\t\t<lentsince>".$row['lentsince']."</lentsince>\n";
	echo "\t\t<lentto>".$row['lentto']."</lentto>\n";
	echo "\t\t<avail>".$row['avail']."</avail>\n";
	
	echo "\t</properties>\n";
	echo "\t<people>\n";
	
	for($i=0; $i<sizeof($director); $i++){
		echo "\t\t<director>\n";		echo "\t\t\t<name>".$director[$i]['name']."</name>\n";		echo "\t\t\t<id>".$director[$i]['id']."</id>\n";		echo "\t\t</director>\n";
	}
	for($i=0; $i<sizeof($writer); $i++){
		echo "\t\t<writer>\n";		echo "\t\t\t<name>".$writer[$i]['name']."</name>\n";		echo "\t\t\t<id>".$writer[$i]['id']."</id>\n";		echo "\t\t</writer>\n";
	}
	for($i=0; $i<sizeof($actor); $i++){
		echo "\t\t<actor>\n";		echo "\t\t\t<name>".$actor[$i]['name']."</name>\n";		echo "\t\t\t<id>".$actor[$i]['id']."</id>\n";		echo "\t\t</actor>\n";
	}
	echo "\t</people>\n";
	echo "<poster type='binary' format='base64'>\n";
	$result = mysql_query('SELECT poster FROM movies WHERE movies.fid = \''.$filmid.'\'') or die(mysql_error());
	$pic = mysql_fetch_row($result);
	$file=$cfg['poster_path'].'/'.$filmid.'.pic';
	if(!is_readable($file)) $file="";
	if($pic[0]) {
		echo chunk_split(base64_encode($pic[0]),76,"\r\n");
	}else if($file!="") {
		echo chunk_split(base64_encode(file_get_contents($file)),76,"\r\n");
	}
	echo "</poster>\n";
	echo "</film>\n";
	exit;
} else {
	die('error: unknown movie id');
}
?>
