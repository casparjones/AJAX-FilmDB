<?php
	require('mysql.php');  	// DONOT EDIT
	require('prefs.php');  	// DONOT EDIT
	if(isset($_COOKIE['prefs'])) {
		$temp = explode(":", $_COOKIE['prefs']);
		for ($i = 0; $i < sizeof($temp); $i++) {
			$val = explode("=", $temp[$i]);
			$cfg[$val[0]] = $val[1];
		}
		if(!isset($cfg['fontsize'])) {
			$cfg['fontsize'] = 1;
		}
		if(!isset($cfg['fonttype'])) {
			$cfg['fonttype'] = 'Tahoma';
		}
		if(!isset($cfg['use_blob'])) {
			$cfg['use_blob'] = true;
		}
		if(!isset($cfg['use_progress'])) {
			$cfg['use_progress'] = false;
		}
		$cfg['nobreaks'] = ($cfg['nobreaks']==0?false:true);
		$cfg['original'] = ($cfg['original']==0?false:true);
		$cfg['noposter'] = ($cfg['noposter']==0?false:true);
	} else {
		if(!isset($cfg['fontsize'])) {
			$cfg['fontsize'] = 1;
		}
		if(!isset($cfg['fonttype'])) {
			$cfg['fonttype'] = 'Tahoma';
		}
		if(!isset($cfg['use_blob'])) {
			$cfg['use_blob'] = true;
		}
		if(!isset($cfg['use_progress'])) {
			$cfg['use_progress'] = false;
		}
	}
	require('users.php');  	// DONOT EDIT
	require('people.php'); 	// DONOT EDIT
	
	/* AJAX-FilmDB 'main' configuration *******************************************
	** DO NOT EDIT ABOVE THIS LINE                                               **
	******************************************************************************/
	
	// default sort order; must NOT be empty! the max # of rows by which
	// can be sorted is the size of this array. ASC/DESC MUST be specified!
	$cfg['defaultsort'] = array('local ASC','nr ASC','year ASC'); // BETTER DONOT EDIT
	
	/* imdb scripts configuration *************************************************
	** configures fetching of data from imdb                                     **
	******************************************************************************/
	
	$cfg['actorLimit'] = 12;		// saved actors per movie (max)
	$cfg['searchLimit'] = 30;		// imdb search for movies (max)
	$cfg['actSearchLimit'] = 999;	// imdb search for people (max)
	
	// which categories to search for people:
	$cfg['actCats'] = array('actors','actresses','directors','writers'); // DONOT EDIT
	// independent of $actCats and $actSearchLimit, all 'most popular' matches will always be shown
	
	$cfg['cache'] = true;			// BETTER DONOT EDIT
	// whether or not to cache last search results
	
	$cfg['autoheight'] = true;			
	// whether or not to determine requester list-height automatically or set manually
	
	$cfg['http_cache_size'] = 0;	// BETTER DONOT EDIT
	// number of html-pages kept in session cache.
	// should be switched off in general, useful when testing app since it reduces traffic from imdb
	
	$cfg['http_compress'] = false;	// BETTER DONOT EDIT
	// whether or not to use gzipped html.
	// set to false if you have problems fetching data from imdb (php versions <4.3.x)
	
	/* media configuration ********************************************************
	******************************************************************************/
	
	$cfg['cats'] = array(
		// an array to automatically choose category depending on medium. 
		// max length for category name is 10 chars.
		'Tape' 		=> 'X',
		'Card' 		=> 'X',
		'Stick' 	=> 'X',
		'Disk' 		=> 'X',
		'UMD' 		=> 'U',
		'BD'		=> 'B',
		'HD-DVD'	=> 'H',
		'VideoDVD' 	=> 'D',
		'ISO-DVD' 	=> 'I',
		'MiniDVD' 	=> 'M',
		'ISO-CD' 	=> 'C',
		'VideoCD' 	=> 'V',
		'SuperVCD' 	=> 'S'
	);
	
	/* file path configuration ********************************************************
	******************************************************************************/
		
	// here you coul'd also insert a regular URL like...
	// http://your.favorit.domain.com/dtd/ajax_filmdb.dtd
	// ...otherwise your install path will be used.
	$cfg['dtd_path']	= '/config/ajax_filmdb.dtd';
	// here you coul'd change the regular poster path
	// where the posters will be stored as files if
	// $cfg['use_blob'] is set to false.
	// HINT: This path is hard coded in 
	// "imgget.php" to sped up execution.
	$cfg['poster_path']	= 'poster';
	
	/* admin configuration ********************************************************
	******************************************************************************/
		
	// Allow or deny the admin to execute the following commands...
	// Extract all Posters from DataBase and save to Server!
	// Extract all Posters from Server and save to DataBase!
	// Copy all Posters from DataBase to Server!
	// Copy all Posters from Server to DataBase!
	// Clear all Posters in the DataBase!
	// Delete all Posters on the Server!
	$cfg['server_cmd']	= true;
	// Allow or deny the admin to execute the following commands...
	// Backup the whole DataBase as SQL to zip!
	// Backup Poster files from Server to zip!
	$cfg['backup_cmd']	= true;
	// Allow or deny the admin to execute the following commands...
	// Restore the whole DataBase from Backup zip!
	// Restore Posters on Server from Backup zip!
	$cfg['restore_cmd']	= true;
	// Set the maximum execution time on server
	$cfg['time_limit']	= 300; // seconds
		
	/* ****************************************************************************
	** DO NOT EDIT BELOW THIS LINE                                               **
	******************************************************************************/

	// get available options for media, language, etc directly from mysql table definition.
	// DO NOT CHANGE config below this line. to change options, directly edit mysql definitions.
	
	require('language-'.$cfg['language'].'.php'); // DONOT EDIT
	$cfg['titlelogo'] = 'logo.png'; // DONOT EDIT
	// $cfg['titlelogo'] = 'logo_'.$cfg['language'].'.png';
	
	$cfg['filmdb_version'] = '1.2.4'; // DONOT EDIT
	$cfg['filmdb_release'] = '08-'.$trans['09'].'-2010'; // DONOT EDIT
	
	$cfg['nooffilms'] 	= 1;	// movies per page (film view) DONOT EDIT
	$cfg['uploads']  	= '/config/upload.tmp'; // DONOT EDIT
	
	mysql_connect($cfg['mysql_host'],$cfg['mysql_user'],$cfg['mysql_pass']) or die(mysql_error());
	mysql_select_db($cfg['mysql_db']) or die(mysql_error());
	
	set_magic_quotes_runtime(0);	// get rid of that plague
	
	// ALTER TABLE `movies` ADD `marked` tinyint(1) unsigned default '0', AFTER `comment`
	
	// option columns must be of type set or enum ('medium','lang','format','ratio','sound','genre')
	$options = array('type','medium','format','ratio','container','video','herz','channel','audio','lang','genre');
	
	foreach($options as $o){
		$result = mysql_query("describe movies $o") or die(mysql_error());
		$row = mysql_fetch_array($result);
		$type = $row['Type'];
		preg_match_all("#\'([^,\']{1,})\'#",$type,$matches,PREG_PATTERN_ORDER);
		$cfg[$o] = $matches[1];
	}
?>
