<?php
/* FilmDB (based on php4flicks) */

	// imgget.php - gets an image, given a movie id
	// if from=session is past in GET, $_SESSION is checked, 
	// else its fetched from db (default) or poster path.
	
if(!isset($_GET['from'])) $_GET['from'] = '';

switch($_GET['from']){
	case 'session':
		session_start();
		if(!isset($_SESSION['image'][$_GET['for']]) || $_SESSION['image'][$_GET['for']]==''){
			header('Location: images/noposter.gif'); 
			exit;
		}
		header("Cache-Control: no-cache, must-revalidate");
		if(substr($_SESSION['image'][$_GET['for']],0,3)=='GIF') {
			header('Content-Type: image/gif');
		} else {
			header('Content-Type: image/jpeg');
		}
		header('Content-Disposition: inline');
		echo $_SESSION['image'][$_GET['for']];
		exit;
		break;
		
	case 'db':
	default:
		require('config/config.php');
		$result = mysql_query('SELECT poster FROM movies WHERE movies.fid = \''.$_GET['for'].'\'') or die(mysql_error());
		$pic = mysql_fetch_row($result);
		$file='poster/'.$_GET['for'].'.pic';
		if(!is_readable($file)) $file="";
		if($pic[0]) {
			if(substr($pic[0],0,3)=='GIF') {
				header('Content-Type: image/gif');
			} else {
				header('Content-Type: image/jpeg');
			}
			header('Content-Disposition: inline');
			echo $pic[0];
		} else if($file!="") {
			$headers = apache_request_headers(); 
			if (isset($headers['If-Modified-Since']) && (strtotime($headers['If-Modified-Since']) == filemtime($file))) {
				header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($file)).' GMT', true, 304);
			} else {
				header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($file)).' GMT', true, 200);
				header('Content-Length: '.filesize($file));
				$dump = file_get_contents($file);
				if(substr($dump,0,3)=='GIF') {
					header('Content-Type: image/gif');
				} else {
					header('Content-Type: image/jpeg');
				}
				header('Content-Disposition: inline');					
				echo $dump;
			}
			/* header('Location: '.$file); */
		} else {
			header('Location: images/noposter.gif');
		}
		exit;
}
?>