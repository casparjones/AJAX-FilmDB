<?

// Installation script for AJAX-FilmDB is based on the
// original (c) by Mario Sansone (msansone@gmx.de)
// (www.c-worker.ch) for his "Txt-Db-API" package
//
// This script will search for FilmDB zip-packages in the current
// directory and will guide you through the installation. If there are
// more versions of FilmDB packages in the current directory the
// most current version will be installed. If the named MySQL database
// does not exist it will be created, the tables accordingly also.


$VERSION = "1.0.0";

checkForImages();

session_start();

$SID = '';
if(!ini_get('session.use_trans_sid'))
	$SID = "&".session_name()."=".session_id();

$lang = isset($_GET['lang'])?$_GET['lang']:'en';
initLanguages($lang);

$step = isset($_GET['step'])?$_GET['step']:0;
$lastStep = isset($_GET['laststep'])?$_GET['laststep']:0;

$nextStep = $step + 1;
$prevStep = (($step - 1) < 0) ? 0 : ($step - 1);

if ($step == 1 && checkVersion() == 0) {
	printHeader();
	print "<td colspan=\"2\" valign=\"top\" style=\"padding: 15px;\">";
	print "<br><font color=\"red\"><b>".$text['error']."</b>:</font><br><br>".$text['download'];
	print "</td>";
	printFooter();
	exit;
}

if ($step == 0) {
//--------------------------- step 0 - begin -------------------------------

	$_SESSION['PRGDIR'] = 'filmdb';
	$_SESSION['version'] = '';
	$_SESSION['help'] = 0;
	$_SESSION['sql_host'] = 'localhost';
	$_SESSION['sql_user'] = 'name';
	$_SESSION['sql_pass'] = 'pass';
	$_SESSION['sql_db'] = 'filmdb';
	
	printHeader();
?>
	<td colspan="2" valign="top" align="center" style="padding: 20px;">
		<br><br><br><br>Bitte w&auml;hlen Sie die Sprache.<br>Please, choose the language.<br><br>
		<b><a href="<?=$_SERVER['PHP_SELF']?>?step=<?=$nextStep?>&laststep=<?=$step?>&lang=de<?=$SID?>">Deutsch</a>&nbsp;&nbsp;|&nbsp;&nbsp;  
		<a href="<?=$_SERVER['PHP_SELF']?>?step=<?=$nextStep?>&laststep=<?=$step?>&lang=en<?=$SID?>">English</a></b>
	</td>
<?
//--------------------------- step 0 - end ---------------------------------
} else if ($step == 1) {
//--------------------------- step 1 - begin -------------------------------
printHeader();
?>
	<td colspan="2" valign="top" style="padding: 15px;">
		<?=$text['welcome']?><br>
		<table border="0"><tr valign="top">
		<td width="20"><img src="<?=$_SERVER['PHP_SELF']?>?image=item.png"></td><td><?=$text['feat1']?></td>
		</tr><tr valign="top">
		<td width="20"><img src="<?=$_SERVER['PHP_SELF']?>?image=item.png"></td><td><?=$text['feat2']?></td>
		</tr><tr valign="top">
		<td width="20"><img src="<?=$_SERVER['PHP_SELF']?>?image=item.png"></td><td><?=$text['feat3']?></td>
		</tr><tr valign="top">
		<td width="20"><img src="<?=$_SERVER['PHP_SELF']?>?image=item.png"></td><td><?=$text['feat4']?></td>
		</tr>
		</table>
	</td>
<?
	printNextButton();
//--------------------------- step 1 - end ---------------------------------
} else if ($step == 2) {
//--------------------------- step 2 - begin -------------------------------
printHeader();

	$prgdir = @$_SESSION['PRGDIR'];

?>
	<td colspan="2" valign="top" style="padding: 15px;">
		<?=$text['selectpaths']?><br><br>
		<form id="paths" action="<?=$_SERVER['PHP_SELF']?>?step=<?=$nextStep?>&laststep=<?=$step?>&lang=<?=$lang?><?=$SID?>" method="post">
		<?=$text['prgdir']?><br>
		<?=$_SERVER['DOCUMENT_ROOT']?>/ <input type="text" name="apidir" value="<?=$prgdir?>" style="width: 200px; vertical-align : middle;"><br>
		</form>
	</td>
</tr></table>
<table width="550" height="15" cellspacing="0" cellpadding="0" border="0">
<tr>
	<td valign="bottom" align="right">
		<a href="<?=$_SERVER['PHP_SELF']?>?step=<?=$prevStep?>&laststep=<?=$step?>&lang=<?=$lang?><?=$SID?>">
		<img src="<?=$_SERVER['PHP_SELF']?>?image=goon.png" align="absmiddle" hspace="5" border="0"><b><?=$text['back']?></b></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="javascript: document.getElementById('paths').submit();">
		<img src="<?=$_SERVER['PHP_SELF']?>?image=goon.png" align="absmiddle" hspace="5" border="0"><b><?=$text['next']?></b></a>&nbsp;&nbsp;&nbsp;
	</td>
<?
//--------------------------- step 2 - end ---------------------------------
} else if ($step == 3) {
//--------------------------- step 3 - begin -------------------------------	
printHeader();
	
	$prgdir = isset($_POST['apidir']) ? $_POST['apidir'] : $_SESSION['PRGDIR'];

	// prepare paths
	$prgdir = preg_replace("/^((\.){0,2}\/)*/i", "", $prgdir);
	$prgdir = preg_replace("/(\/(\.){0,2}(\/){0,1})*$/i", "", $prgdir);
	$prgdir = str_replace(array("/../", "/./", "//"), array("/", "/", "/"), $prgdir);

	$_SESSION['PRGDIR'] = $prgdir;
	
	$prgdirParts = array($_SERVER['DOCUMENT_ROOT']);

	foreach (explode('/', $prgdir) as $part) {
		$prgdirParts[] = end($prgdirParts) . '/' . $part;
	}
	
	$prgdirFailed = '';
	
	foreach ($prgdirParts as $dir) {
		clearstatcache();
		if (!file_exists($dir)) {
			clearstatcache();
			if(!is_writeable(dirname($dir))) {
				$prgdirFailed = dirname($dir);
				break;
			}
			break;
		}
	}

?>
	<td colspan="2" valign="top" style="padding: 15px;">
		<?=$text['paths_checked']?><br><br>
		<?=$text['prgdir']?><br>
		<?
			if ($prgdirFailed != '') {
				?><img src="<?=$_SERVER['PHP_SELF']?>?image=notoc.png" align="absmiddle" hspace="5" border="0"><?
			} else {
				?><img src="<?=$_SERVER['PHP_SELF']?>?image=ok.gif" align="absmiddle" hspace="5" border="0"><?			
			}
			echo $_SERVER['DOCUMENT_ROOT']."/".$prgdir."<br>";
			if ($prgdirFailed != '')
				print "<font color=\"red\">".$text['nopermission'].$prgdirFailed."</font>";

		?>
		<br><br>
	</td>
<?
	if ($prgdirFailed != '')
		printBackNextButton(1,0);
	else
		printBackNextButton();
//--------------------------- step 3 - end ---------------------------------
} else if ($step == 4) {
//--------------------------- step 4 - begin -------------------------------
printHeader();

	$doc_checked = ($_SESSION['help'] == 1) ? "checked=\"checked\"" : "";

?>

	<td colspan="2" valign="top" style="padding: 15px;">
		<?=$text['selectoptions']?><br><br>
		<form id="installoptions" action="<?=$_SERVER['PHP_SELF']?>?step=<?=$nextStep?>&laststep=<?=$step?>&lang=<?=$lang?><?=$SID?>" method="post">
		&nbsp;&nbsp;&nbsp;<input type="checkbox" name="install[]" value="help" <?=$doc_checked?>>&nbsp;<?=$text['doc']?><br>
		</form>
	</td>
</tr></table>
<table width="550" height="15" cellspacing="0" cellpadding="0" border="0">
<tr>
	<td valign="bottom" align="right">
		<a href="<?=$_SERVER['PHP_SELF']?>?step=<?=$prevStep?>&laststep=<?=$step?>&lang=<?=$lang?><?=$SID?>">
		<img src="<?=$_SERVER['PHP_SELF']?>?image=goon.png" align="absmiddle" hspace="5" border="0"><b><?=$text['back']?></b></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="javascript: document.getElementById('installoptions').submit();">
		<img src="<?=$_SERVER['PHP_SELF']?>?image=goon.png" align="absmiddle" hspace="5" border="0"><b><?=$text['next']?></b></a>&nbsp;&nbsp;&nbsp;
	</td>
<?
//--------------------------- step 4 - end ---------------------------------
} else if ($step == 5) {
//--------------------------- step 5 - begin -------------------------------
printHeader();

	if (isset($_POST['install'])) {
		$install = $_POST['install'];
		$_SESSION['help'] = in_array('help', $install) ? 1 : 0;
	}
	
	$sql_host = $_SESSION['sql_host'];
	$sql_user = $_SESSION['sql_user'];
	$sql_pass = $_SESSION['sql_pass'];
	$sql_db   = $_SESSION['sql_db'];
?>
	<td colspan="2" valign="top" style="padding: 15px;">
		<?=$text['mysqllogin']?><br><br>
		<form id="paths" action="<?=$_SERVER['PHP_SELF']?>?step=<?=$nextStep?>&laststep=<?=$step?>&lang=<?=$lang?><?=$SID?>" method="post">
		<table border="0"><tr>
		<td width="80"><?=$text['db_server']?>:</td>
		<td><input type="text" name="sql_host" value="<?=$sql_host?>" style="width: 200px; vertical-align : middle;"></td>
		</tr><tr>
		<td width="80"><?=$text['username']?>:</td>
		<td><input type="text" name="sql_user" value="<?=$sql_user?>" style="width: 200px; vertical-align : middle;"></td>
		</tr><tr>
		<td width="80"><?=$text['password']?>:</td>
		<td><input type="text" name="sql_pass" value="<?=$sql_pass?>" style="width: 200px; vertical-align : middle;"></td>
		</tr><tr>
		<td width="80"><?=$text['db_name']?>:</td>
		<td><input type="text" name="sql_db" value="<?=$sql_db?>" style="width: 200px; vertical-align : middle;"></td>
		</tr></table></form>
	</td>
</tr></table>
<table width="550" height="15" cellspacing="0" cellpadding="0" border="0">
<tr>
	<td valign="bottom" align="right">
		<a href="<?=$_SERVER['PHP_SELF']?>?step=<?=$prevStep?>&laststep=<?=$step?>&lang=<?=$lang?><?=$SID?>">
		<img src="<?=$_SERVER['PHP_SELF']?>?image=goon.png" align="absmiddle" hspace="5" border="0"><b><?=$text['back']?></b></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="javascript: document.getElementById('paths').submit();">
		<img src="<?=$_SERVER['PHP_SELF']?>?image=goon.png" align="absmiddle" hspace="5" border="0"><b><?=$text['next']?></b></a>&nbsp;&nbsp;&nbsp;
	</td>
<?
//--------------------------- step 5 - end ---------------------------------
} else if ($step == 6) {
//--------------------------- step 6 - begin -------------------------------
printHeader();

		if (isset($_POST['install'])) {
			$install = $_POST['install'];
			$_SESSION['help'] = in_array('help', $install) ? 1 : 0;
		}
		
		$_SESSION['sql_host'] = isset($_POST['sql_host']) ? $_POST['sql_host'] : '';
		$_SESSION['sql_user'] = isset($_POST['sql_user']) ? $_POST['sql_user'] : '';
		$_SESSION['sql_pass'] = isset($_POST['sql_pass']) ? $_POST['sql_pass'] : '';
		$_SESSION['sql_db']   = isset($_POST['sql_db'])   ? $_POST['sql_db']   : '';
?>
	<td colspan="2" valign="top" style="padding: 15px;">
	<?=$text['installtext']?>
	</td>
</tr></table>
<table width="550" height="15" cellspacing="0" cellpadding="0" border="0">
<tr>
	<td valign="bottom" align="right">
		<a href="<?=$_SERVER['PHP_SELF']?>?step=<?=$prevStep?>&laststep=<?=$step?>&lang=<?=$lang?><?=$SID?>">
		<img src="<?=$_SERVER['PHP_SELF']?>?image=goon.png" align="absmiddle" hspace="5" border="0"><b><?=$text['back']?></b></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="<?=$_SERVER['PHP_SELF']?>?step=<?=$nextStep?>&laststep=<?=$step?>&lang=<?=$lang?><?=$SID?>">
		<img src="<?=$_SERVER['PHP_SELF']?>?image=goon.png" align="absmiddle" hspace="5" border="0"><b><?=$text['install']?></b></a>&nbsp;&nbsp;&nbsp;
	</td>

<?
//--------------------------- step 6 - end ---------------------------------
} else if ($step == 7) {
//--------------------------- step 7 - begin -------------------------------
printHeader();
?>
	<td colspan="2" valign="top" style="padding: 15px;">
<?
		// Here the actual installation begins
		flush();

		$unzip = new unzipfile("filmdb_".$_SESSION['version'].".zip");
		$unzip->extract();

		$prgdir = @$_SESSION['PRGDIR'];
		
		$prgdirParts = array($_SERVER['DOCUMENT_ROOT']);

		foreach (explode('/', $prgdir) as $part) {
			$prgdirParts[] = end($prgdirParts) . '/' . $part;
		}
		
		foreach ($prgdirParts as $dir) {
			if (!file_exists($dir))
				mkdir($dir);
		}
		
		$exclude = array();
		if ($_SESSION['help'] == 0) $exclude[] = 'help';
		
		$finalPrgDir = end($prgdirParts);
		
		// copy all files to the final location
		if (file_exists("filmdb_".$_SESSION['version']."/filmdb_".$_SESSION['version']))
			cp("filmdb_".$_SESSION['version']."/filmdb_".$_SESSION['version'], $finalPrgDir, $exclude);
		else		
			cp("filmdb_".$_SESSION['version'], $finalPrgDir, $exclude);
			
		deldir("filmdb_".$_SESSION['version']);

		/* set entered username/password to mysql config file */
		if (file_exists($finalPrgDir . "/config/mysql.php")) {
			$content = implode('', file($finalPrgDir . "/config/mysql.php"));
			$content = preg_replace("/^.cfg\['mysql_host'\][^\n]*\n/m", "\$cfg['mysql_host'] = \"".$_SESSION['sql_host']."\";\n", $content);
			$content = preg_replace("/^.cfg\['mysql_user'\][^\n]*\n/m", "\$cfg['mysql_user'] = \"".$_SESSION['sql_user']."\";\n", $content);
			$content = preg_replace("/^.cfg\['mysql_pass'\][^\n]*\n/m", "\$cfg['mysql_pass'] = \"".$_SESSION['sql_pass']."\";\n", $content);
			$content = preg_replace("/^.cfg\['mysql_db'\][^\n]*\n/m" ,  "\$cfg['mysql_db']   = \"".$_SESSION['sql_db']."\";\n", $content);
			$fp = fopen($finalPrgDir."/config/mysql.php", "w");
			fwrite($fp, $content);
			fclose($fp);
		}
		
		/* set entered language to prefs file */
		if (file_exists($finalPrgDir . "/config/prefs.php")) {
			$content = implode('', file($finalPrgDir . "/config/prefs.php"));
			$content = preg_replace("/^.cfg\['language'\][^\n]*\n/m" ,  "\$cfg['language']   = \"".$lang."\";\n", $content);
			$fp = fopen($finalPrgDir."/config/prefs.php", "w");
			fwrite($fp, $content);
			fclose($fp);
		}
	
	print '<img src="'.$_SERVER['PHP_SELF'].'?image=ok.gif" align="absmiddle" hspace="5" border="0">';
	print $text['progcompleted']."<br><br>";

	/* mysql installation part */
		
	$table['movies'] = <<<EOF
CREATE TABLE `movies` (
  `fid` smallint(5) unsigned NOT NULL auto_increment,
  `id` mediumint(7) unsigned zerofill NOT NULL default '0000000',
  `nr` smallint(4) unsigned zerofill NOT NULL default '0000',
  `runtime` smallint(4) unsigned NOT NULL default '0',
  `inserted` date default NULL,
  `year` year(4) default NULL,
  `genre` set('Action','Adult','Adventure','Animation','Comedy','Crime','Documentary','Drama','Family','Fantasy','Film-Noir','Horror','Music','Musical','Mystery','Romance','Sci-Fi','Short','Thriller',' War','Western') default NULL,
  `lang` set('DE','EN','ES','FR','IT','RU','TR','?') default 'EN',
  `audio` enum('AC3','DTS','MP2','MP3','AAC','ATRAC','AMR','OGG','WMA') NOT NULL default 'AC3',
  `channel` enum('1.0','1/1','2.0','2.1','3.0','3.1','4.0','5.1','6.1','7.1') NOT NULL default '5.1',
  `herz` enum('24.0','32.0','44.1','48.0','96.0') NOT NULL default '48.0',
  `video` enum('MPEG-1','MPEG-2','MPEG-4','DivX','Xvid','3ivx','h263','h264','WMV') NOT NULL default 'MPEG-2',
  `width` mediumint(4) unsigned default NULL,
  `height` mediumint(4) unsigned default NULL,
  `container` enum('MPEG-1','MPEG-2','MP4','AVI','ASF','MOV','OGG','3GP','MKV') NOT NULL default 'MPEG-2',
  `ratio` enum('16:9','4:3','LetterBox','Pan&Scan','Flexibly') NOT NULL default '16:9',
  `format` enum('PAL','NTSC','FILM','15','20','24','25','30','50','60') NOT NULL default 'PAL',
  `medium` enum('VideoDVD','ISO-DVD','MiniDVD','ISO-CD','VideoCD','SuperVCD','UMD','BD','HD-DVD','Disk','Stick','Card') NOT NULL default 'VideoDVD',
  `type` enum('-R','+R','-RW','+RW','Ram','Rom','Worm','-') NOT NULL default '-R',
  `disks` tinyint(2) unsigned NOT NULL default '1',
  `rating` tinyint(2) unsigned default NULL,
  `name` varchar(100) NOT NULL default '',
  `local` varchar(100) default NULL,
  `aka` varchar(200) default NULL,
  `country` varchar(200) default NULL,
  `cat` varchar(10) default NULL,
  `comment` varchar(200) default NULL,
  `avail` tinyint(1) unsigned default '1',
  `lentsince` date default NULL,
  `lentto` tinyint(2) unsigned default NULL,
  `poster` blob,
  PRIMARY KEY  (`fid`),
  KEY `nr` (`nr`),
  FULLTEXT KEY `name` (`name`,`local`,`aka`)
) TYPE=MyISAM;
EOF;

$table['people'] = <<<EOF
CREATE TABLE `people` (
  `id` mediumint(7) unsigned zerofill NOT NULL default '0000000',
  `name` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
EOF;

$table['plays_in'] = <<<EOF
CREATE TABLE `plays_in` (
  `movie_fid` smallint(5) unsigned NOT NULL default '0',
  `people_id` mediumint(7) unsigned zerofill NOT NULL default '0000000',
  PRIMARY KEY  (`movie_fid`,`people_id`)
) TYPE=MyISAM;
EOF;

$table['writes'] = <<<EOF
CREATE TABLE `writes` (
  `movie_fid` smallint(5) unsigned NOT NULL default '0',
  `people_id` mediumint(7) unsigned zerofill NOT NULL default '0000000',
  PRIMARY KEY  (`movie_fid`,`people_id`)
) TYPE=MyISAM;
EOF;

$table['directs'] = <<<EOF
CREATE TABLE `directs` (
  `movie_fid` smallint(5) unsigned NOT NULL default '0',
  `people_id` mediumint(7) unsigned zerofill NOT NULL default '0000000',
  PRIMARY KEY  (`movie_fid`,`people_id`)
) TYPE=MyISAM;
EOF;

	$conn = mysql_connect($_SESSION['sql_host'],$_SESSION['sql_user'],$_SESSION['sql_pass']);
	$TestLink = "http://".$_SERVER['HTTP_HOST']."/".$prgdir."/";
	if($conn) {
		$db = mysql_select_db($_SESSION['sql_db']);
		if(!$db) {
			$db = mysql_query('CREATE DATABASE `'.$_SESSION['sql_db'].'`');
			if($db) {
				$result = mysql_query("SHOW TABLES FROM ".$_SESSION['sql_db']);
				$row = mysql_fetch_row($result);
				if($row[0]!='') {
					print '<img src="'.$_SERVER['PHP_SELF'].'?image=ok.gif" align="absmiddle" hspace="5" border="0">';
					print $text['sqlcompleted']."<br><br>".$text['removeinstaller']."<br><br><br><b><a href=\"".$TestLink."\">".$text['testinstall']."</a></b><br>\n";
				} else {
					$db = mysql_select_db($_SESSION['sql_db']);
					if(mysql_query($table['movies'])) { $mo = true; }
					if(mysql_query($table['people'])) { $pp = true; }
					if(mysql_query($table['plays_in'])) { $pl = true; }
					if(mysql_query($table['writes'])) { $ws = true; }
					if(mysql_query($table['directs'])) { $ds = true; }
					if(isset($mo) && isset($pp) && isset($pl) && isset($ws) && isset($ds)) { 
						print '<img src="'.$_SERVER['PHP_SELF'].'?image=ok.gif" align="absmiddle" hspace="5" border="0">';
						print $text['sqlcompleted']."<br><br>".$text['removeinstaller']."<br><br><br><b><a href=\"".$TestLink."\">".$text['testinstall']."</a></b><br>\n";
					} else {
						print '<img src="'.$_SERVER['PHP_SELF'].'?image=notoc.png" align="absmiddle" hspace="5" border="0">';
						print "<font color=\"red\">".$text['sqlnotables']."</font><br><br>".$text['sqlincomplet']."<br>";
					}
				}
			} else {
				print '<img src="'.$_SERVER['PHP_SELF'].'?image=notoc.png" align="absmiddle" hspace="5" border="0">';
				print "<font color=\"red\">".$text['sqlnodatabase']."</font><br><br>".$text['sqlincomplet']."<br>";
			}
		} else {
			print '<img src="'.$_SERVER['PHP_SELF'].'?image=ok.gif" align="absmiddle" hspace="5" border="0">';
			print $text['sqlcompleted']."<br><br>".$text['removeinstaller']."<br><br><br><b><a href=\"".$TestLink."\">".$text['testinstall']."</a></b><br>\n";
		}
	} else {
		print '<img src="'.$_SERVER['PHP_SELF'].'?image=notoc.png" align="absmiddle" hspace="5" border="0">';
		print "<font color=\"red\">".$text['sqlnoconnect']."</font><br><br>".$text['sqlincomplet']."<br>";
	}
?>
	</td>
<?

//--------------------------- step 7 - end ---------------------------------
}

printFooter();

function checkVersion() {
	$zips = array();
	if ($dh = opendir(".")) { 
		while (($file = readdir($dh)) !== false) { 
			if (preg_match("/^filmdb_(.*)\.zip/i", $file, $matches))
				$zips[] = array($file, $matches[1]); 
		}
		closedir($dh);
	} 
	if (count($zips) == 0) {
		return 0;
	} else {
		$maxVersion = 0;
		$installVersion = '';
		foreach ($zips as $zip) {
			if (preg_match("/([0-9]+)\.([0-9]+)\.([0-9]+)[-]{0,1}(alpha|beta|pre){0,1}[-]{0,1}([0-9]*)/i", $zip[1], $matches)) {
				$version = 10000000*$matches[1] + 100000*$matches[2] + 1000*$matches[3];
				if ($matches[4] == 'pre')
					$version += 100 * 1;
				else if ($matches[4] == 'alpha')
					$version += 100 * 2;
				else if ($matches[4] == 'beta')
					$version += 100 * 3;
				else
					$version += 100 * 9;

				if ($matches[5] != '')
					$version += $matches[5];
				else
					$version += 99;

				if ($version > $maxVersion) {
					$maxVersion = $version;
					$installVersion = $zip[0];
					$_SESSION['version'] = $matches[0];
				}
			}
		}
		return 1;
	}
}

// cp() copies a file or directory
function cp($wf, $wto, $exclude = array()) {
	if (!file_exists($wf))
		return;
	if (!file_exists($wto))
		mkdir($wto);
	$arr = ls_a($wf);
	foreach ($arr as $fn){
		if (in_array($fn, $exclude))
			continue;
		if ($fn) {
			$fl = "$wf/$fn";
			$flto = "$wto/$fn";
			if (is_dir($fl))
				cp($fl, $flto);
			else
				copy($fl, $flto);
		}
	}
}

// ls_a() lists a directory
function ls_a($wh) { 
	$files = '';
	if ($handle = opendir($wh)) {
		while (false !== ($file = readdir($handle))) { 
			if ($file != "." && $file != ".." ) { 
				if($files == '')
					$files = "$file";
				else
					$files = "$file\n$files"; 
			} 
		}
		closedir($handle); 
	}
	$arr = explode("\n",$files);
	return $arr;
}

function deldir($dir) {
	$current_dir = opendir($dir);
	while($entryname = readdir($current_dir)) {
		if(($entryname != "." && $entryname != "..") && is_dir("$dir/$entryname") ) {
			deldir("${dir}/${entryname}");
		} elseif ($entryname != "." && $entryname != "..") {
			unlink("${dir}/${entryname}");
		}
	}
	closedir($current_dir);
	rmdir($dir);
}

function checkForImages() {
	$image = @$_GET["image"];
	
	if ($image == "") return;
	
	if ($image == "background.png") {

		$image = <<<EOF
pngiVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAIAAAD8GO2jAAAABGdBTUEAANbY1E9YMgAAABl0RVh0
U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAC+SURBVHjaYnnz5g0DLQFAADEx0BgABBAL
ENDUAoAAorkPAAKI5c+fPzS1ACCAaO4DgACieRwABBDNfQAQQDSPA4AAorkPAAKI5nEAEEA09wFA
ANE8DgACiOY+AAggmscBQADR3AcAAUTzOAAIIJr7ACCAaB4HAAFEcx8ABBDN4wAggGjuA4AAonkc
AAQQzX0AEEA0jwOAAKK5DwACiOZxABBANPcBQADRPA4AAojmPgAIIJrHAUAA0dwHAAEGAGWNGDES
4qkiAAAAAElFTkSuQmCC
EOF;
	} else if ($image == "setup.png") {

		$image = <<<EOF
pngiVBORw0KGgoAAAANSUhEUgAAAEYAAABGCAYAAABxLuKEAAAABGdBTUEAANbY1E9YMgAAABl0RVh0
U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAp4SURBVHjaYvz//z/DKMAEAAHECMQH0Pik
gEtQWg+L3GIgXgjEe3Dohcn/x4JhwACIJxBwWwkQX0DS+w8qPh+IFfDoxWs/QACxALE9BQHLAqWt
sMidAGIeILbDoRcm/xeI/yBhBqTAESDCfclAXAk15zfUDFkgjiegD6/9AAHEQmGKY8Ujxw3EIkTI
/wTi71D8H8lxxKZgByzmOBKhD6/9AAFEacBwoCV9ZMAHxFJ49PJD5b8C8QeoOX+hmJSCTx2I1YD4
FdQcBiIDBq/9AAHERGHAsEExNgBKpmJ49MLkhYCYFxrIzGSUc7CAEAViQWhKsCNCD177AQIIX4rZ
BcX/kAo19MIRJJaPQz8ntIxgICAPMuMLNFsykRkwRkB8Hoh/QVOqLBF68NoPEEAsBMoPDmiegxVq
sKSGHDD/8ejnJGA+SJ4dyVHkpmANaEoBYUMSykec9gMEEAuBqvw/NFC+QfPiTyj/P1LA/Majn4mA
+UxIsURKSnkOxJJIfElomfERiM2wqL8FLYdwuQHDfoAAwhcwoDaEHFJ1BkstsFTSD8Q3oMmX3uA+
WsDACuHn0GyFDE5Byx6SAEAA4QsYAQJlBAs0b/4dgIC5i6XtBEoRN4FYHE0cFHmWWMzAW/MBBBAl
tRILtBQfCABqc7xAE1MGYm0sam/jyaY4AwcggCgJGH5oVTcQgQPy0D00MSksBe83LAFIVIoBCCB8
WekB1PJ/SM3lf0h9kd/QgGEZoFRzB0t20sNS6LKSEzAAAUQoYPZDA+QXFP9GKnx/Qy1lHKAUc4kI
dfegKfo/qQEDEEBMRDgA1jn7Ac3b36D4O1Ts3wClmL/QFMFAIHKZyEkxAAHEQoTloLbLZyD+BA2Q
X9DAgMn9IdNjikDsATUT2fzfSIGtgEf/P2iNo4ZD/ge0/8RIYt8LDAACiIVAavkDtQDk6DfQBtQP
pPbMHzwNPEJAgYDHiclO14DYj0Bq+UdOqgYIIEIp5h80hXyDBsp7aAv4L1L/aSDaMbBUcJVANvpP
Rm8dDAACiImIgPkLDZwf0ED5Cm3YfYUG2L8BChiY+y7jaR3/Q+vCEA0AAoiJyCT7D6lLgDzaRVZs
UDlgLuAoX54hZXWSIw8ggBihVRoTtFpjhdJMUMO/QA3+idSBRA8MKWgvlRlaFsFapueA+AoQO0NT
3F+k8Rs2aHdDmUAtwYTkKUYk+hPUfb+gagSROoTMULmr0MDZC+33CUDVgNzKBcSPoF0IUPHwFIrf
QHPCH4AAYqRhjH+HjpEchXbkfkEdBcO6QJxJh9QF8uhyIF4JjWg+aMOUGxpZH6Ct4+fQQAIVD38A
AoiRTlkBNFMwDxqTLNCUqQ/EZXTMfqDU0Q1NKdxQN/yBpr7X6LUuQAAx0clRLkDcB8Ty0Fh7B40d
egLQsMQEaIr5CQ2Et1C3fEZqhoATCkAAMdHRYRJA3Axt2H2BOobeADTO2wn1/Hdo4HyAugfWWAUH
DEAAMQ2Aw2qhPfOBaP/Ahif8kAr232j9QDAACCCmAXAYKOVUMEDGWgcKBEPLGXa0YRP4YD9AADEN
kMNsgNhiAANGDDp2ww9NxbAAgo8UAAQQ0wA6zoNhYIExtG3DB23XsCGHB0AAsQygwwRIVL8IqWmB
PAEPapNIA7EpieYpQVMLL7TKhs2CgGsmgAAiNWD2oLVSOaAtX2U6BORdtB49+nQuqAUfToJ53NCG
JoxmhzbuwG07gAAiNWAOI/Wb/iANP4CSImiY0YkB/yQbpaN2sGGQb1AaFkAgz2wEYnMShjIYoY08
dmgEsyKXMwABxESG42ADVF+gbQBQA+kxEK8G4l6oo2kBYEMgX6ENM1Az/gnUbhjeQ6KZsP4hKwNi
1gMcMAABxEKB45AbRn+hZoGa1aAFOek0ChjYrOgHpBbrL6hnkDuxxABY55kJqeMMn5EECCAWMlIM
zHHvoY77Ck3izNCSfQG0ASVJg6yEnFo/QvFPpJ61KAnmvcMyjAEHAAHEREaswfL5Z6SYewPtiL2E
JvGVNMxOf5AGzmCD87DBMxsSev5XkGq2vwxoKzkAAoiFAsfBViJ9hToSlixBYidoXEPBBs+Qx3Nn
QvthxICjSJXIbwbEag746g2AAGKh0GHII3qwJAliH6NBYNhDAx1W6MN6xHLQJj6xE/egIuAMUpmF
PggHDmiAAGKhUTnwcpC2lL9Da8+vaNnxO5QP710DBBATjZI5KHAOMAwu8AxaYz6Bpo7vSMMfyK1e
MAAIIBYaFpKDaWX1ZqTsA5sO+gTNkh8ZUCcSwe4GCCBadiIHU8CARhB9oR1G5Br1PTSAvqOPxwAE
ENMICBQGaDfFBIhzGCDrgr9AA+QTUnmDMvsBEEBMDCMLgAIoEIhTkQpbrNkeIIBGWsDAgDsQJ0E7
j+wMqPNpYAAQQLQcjxGgsnn38GRbIQbSFyCmMUAm4y4jtXp/wtgAAUTLgDGisnmLkFq6f5HYsGwA
GvoADZd6kWAmaINGC5aW9F+AAKJVwAjSwExY++gXNGaRywhYi3Y9VC6QSDNBfSsRbF0DgACiVcAY
03jYAbbI6CdadwRURoD2ILlBR+YIAVAqA81rn4JW47D58L8AAUSrgHGh8UDVO2g75CvSeAysMgEN
fVyHVs/EANCKrBtIVTi4sQcQQCw0ykZpNMpKyCu83kHpX2i1LAsDaavVeRkQKyA4YTUUQADRImDK
aVjG/EPq53yFtmB/og04gapdLRLMhaUy5KqbCSCAWGgQKOV0GIdBLizRU0c6iU0FWCpDGfsFCCBS
A0YFmhdB6/UloDWBKnRMBLRASGmAG26hQNxOoh7YIBszUiOPESCASA2Y5AH0NK6Bqj/QCAFFjCIZ
5r5DyoZwDBBAAzkT+YsB97ZBWg1UYQN3kbIpHAME0ED2la4Mgj7TVSytXnBrGiCABipgnjHgXoZK
T3AWS2EO7m4ABNBABAyonNgyCMZs7kGzESxQUAbFAQJoIAIGFChPGAZuRRUscjYzoC7uhm0aAY/k
AQQQywCklMsMiEmzgQIgd7xlQOyqgU3YwRcKAAQQCx3LFFhK+cOAmEEciJQCmj65w4A6U/AJWv3D
xn7/AwQQrQPmKjQvn2FA3fcEcgg/nQMEVNAeYUDMtX+HuuM9FCO3i/4DBBA1AwZmwTMovgt1BPpG
jS9QdbQKmHtQTz+H0k+hKRU2noM89/4OmqWQe+rg6hoggBihHSd+aDMf1LQXg/I5yOjHIDeUkDdl
IO9eQZ7P+Q1t5AkzQFZHCEN7u2wUBMx/tH4V+gaRn1B3wLYZvYWykWcLGAACiAVtZAy22wzWhyDX
QX+Rsg5sxO0bA2Lm7zOU/58BsbfgCzRA/jHgP36FGHdgixxYBH1HiqCPSG5BmVcCCCAWpHEO2Epp
WJ5kJTNg0BtMPxlQ54iRq0XYYp0v0JT7F8pmoULAIO/+Rd7wirx85DtSuYIyrwQQQCxII2NfoGJf
oTHHTIGjkGPqNwPqLlzkJRdMSB24v9BYRFlWSkFWQs5CyG5Bdg8s0NBPOWEACCBGpMEdVqijWBjQ
5ljIdBR63sY2ss+IbSyEgfIty/+x9IH+orkJ3S0oACDAAJcqqYQCV5V0AAAAAElFTkSuQmCC
EOF;
	} else if ($image == "1x1.gif") {
		
		$image = <<<EOF
gifR0lGODlhAQABAID/AMDAwAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==
EOF;
	} else if ($image == "item.png") {
		
		$image = <<<EOF
pngiVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAANbY1E9YMgAAABl0RVh0
U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAPYSURBVHjaYjSd8JCRgYGBCYhZkDArlAaJ
g8A/IP4LxL+B+A8Ug/h/AQKIBUkzGxCzAzEHEHOyMIHZLMxMDEx//4E1/P7zj+E7kAbhH0D8C2Qy
QACxIGnmBGIedhZGfg4WBn5OFkZeNmYGLhYmRqZ//xl+//r3//P33/8//vzD8OHb7/+fgGpBLmcA
CCCYASDbeLhYGYX52BklRLmZZEQ4GaV42BkFgYawgmz++uv/m3c//j96/fXfE+YfDMyff/4Hewsg
gGAGcLADbeVjZ5CQ4WXQEOf4qfPuyV3FX//+Cv//+4eViYXlx7//jK/kFFRvcTKzXWT4z/AX6K2f
QJf8BgggWIBxsjMzCghz/JcTY/uld3rfYX1ZFV0pdxtVDh5OJuZP3/793bb/hsSdnXv5rN3s///g
5Pj87Q/Dx2+/Gb4CBBDYBaAA42T5zyfEwSD79OYVtcOsJjLu/Hw8J598ZRHhYWF48+UPwydRCbZD
zzkVZS5f+iyiZfLw9TeGJ5+ZGd8DBBAoBpiYmRhZOZn+cXMw/BK7dP6J2E8mTq4Hb/+zHH3KxLj/
ERMjiAbxfzFx8p4790iK4/8vcaB6LlZmRmaAAGKBxPI/pv9//rD9+/mD59WHf9wiBnwsMmLsjByc
bAzsrMwMfL//Mvz4zsn47MdPltcf/vH+/v6N799vdrb/fxiZAAJwSMcoAMIwFEB/Sgoiiuji6v0P
5lIHN+tvTBSv8Hj6J/HHvTF4E/Ngon0n25SxLhkfLNgExwnsxcDRUr1qckqIa7wCCOQFYIj+A+r9
+/XL119fVOS5fzI+v/VfS4yRQYOfgUGem5FBCYi1RBkZfj6++V9Vjvvn1y8/v/z4+fv7n7//fgME
AEEAvv8CAAAA+/z8//f3+Pvw8PL45xMWG+0R68D60crV/wL59wANAfkABP33ALe8zf8Q6L35ExYb
7O7y9+n19vrz+fv9+QIAQQC+/wQAAAD8AAIC9vn8/e3x+Pre///72hgaHRDj1MIWmdPEBvf0+AEI
Cgf/Av75+iAeIers8fvZ9AD53/gK//AABwP5AghiAAvr91+M7G+BcXvnz7efp78x/Gbl4BDW4GJm
EBLg/c/27x8wGP78e/vmw68r3//9O/2bg/3ud3bGD4xsHL8AAogFmqt+MTAzffnOwPbo719mpp8/
vn398vf3YyaGv9KM//5z/mdg+PafkeEJMHiv/mNnv/qLieMpUPM3kOUAAQQzgIGBi+87MK7+/frz
6zfQvvdMv//d+f/7Dz8Tw392YGb6ycjM/PYvG8dLRg6+NwycvF8Z+IR/gvQCBBgAttiiF38tmDMA
AAAASUVORK5CYII=
EOF;
	} else if ($image == "goon.png") {
		
		$image = <<<EOF
pngiVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAANbY1E9YMgAAABl0RVh0
U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAJpSURBVHjaYmRiYmLJzs6e5+fn5/v//39G
IGYgBJiZmf/v2bPnQE9PTyRAADGwsbGJbNu27fvv37////z5E45//PiBE//58+f//v37/woICKgA
BBALIyMj779///5+//6dAUgz/Pr1C2QDAysrK8Pfv38ZsLkIKvcbqJcHIIBYgHwWkKb3798zAAUY
bt++zfD8+XMGNTU1BgkJCbChIIOQAQsLCwPQlUDljCwAAcQCDAMGoPPBBoBsfvDgAcPx48cZTp48
CTbExMSEgZeXF+wymGugBoDZAAEEcgHYgA8fPoAlHj58yHDp0iUGdnZ2hjNnzjAAA4vB3t6ewcjI
CGwBzIsgGmQ5QACBwoABGCgMnz59AgUow5MnTxiuXbvGwMXFBbbh5s2bDIcPH2bQ09Nj8Pf3Z1BW
VgaLg/SAAEAAgV0A8idIAGTy58+fGb58+QLGyODAgQMMHz9+ZKiurgarA+kBWQ4QQCwwP3FycoIx
KISxhbq3tzdDYGAgAzc3N1gMFGugMAEIIBaYAj4+PrCzYU6HAUdHR4bo6GiwF0CxAXIpyO8wFwIE
ENgAkN+BiQIc2iBJEDA2NmZITU1lcHBwALsQmIDANoKcDcJv374FqwMIILgLQAaAvGBqasqgpKTE
EBkZCXYVLIFxcHCANcAMAMUSCAAEEAvIVCCHEWQASCI2NhYsCYpnkJNBrkMGIDUgANIDAgABxAI0
/R8w5P+BNIAkQQZ++/YNZ0aCGQBUwwhMC78AAgjEEwOmtnpDQ0Oz/8RkRSAAhhPjlStXLh87dqwW
IIBABvAAsQkQKzIQD0D6HgHxKYAAAwB2MCPzz3T3yQAAAABJRU5ErkJggg==
EOF;
	} else if ($image == "notoc.png") {
	
		$image = <<<EOF
pngiVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAANbY1E9YMgAAABl0RVh0
U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAMzSURBVHjaYvj//z8DNvz1wwPhc7vr7l49
PnMOLjUgDBBALL9+vGVAB6zs/IwPrqyZqmVhqPT+1VuFNy/unBKRUJkF0oAOAAKI8e/fn6gCjEwM
j65tSWVmeTNLRoWV4dfP/wzXTr1+IasdqikkIv8B3RCAAGL68/MjAwJ/YPgHNPD/34/F0kqCDAzM
3xjYuL4zSMnzSbx/dqWFkZERwwUAAcT0798fBhhmYGBieHpnVyq/0Fe1//+fM+zYcpHh1uXbDGJy
3xgYGW6nf/r4NoSJiYkBZBAMAwQQEyuHEAMECzP8+PJK+OPLy1P4xTgZf377zDB//jGGg4duA13y
lkFY5C3Lw2ubKkC2gnwBC0SAAGL6/ukeAwj//PKQ4ePr82UKWlJsTEwfGJgY/zCIiXIyiIuzMzD8
/cHAy/OJgYv1jvG7V/cLmJgQLgAIICZ2LnEGdm4JBiZWIYEfX+/m8Qh8A2r4DjTgB4OIEDODtMhP
hj+v7zL8fHOOQUzwJsPz+zurfv/+LwYLD4AAYgI6huH3jzcsj6+v2cAvwsbB8PsTw5+v7xj+fXvN
ICrwj0GY5zfD35/fGf79Z2Jg/veEgenXSdHHt/dMggUiQAAxff14neHDq8ve7Kzv7MXEmIGa3zP8
+/2DgRHoPzsLMQZhIQ6Gv/+AzgUG8L9/vxmkpX8zfHiyPeT71y/qIFcABBATv5g5UMP3WgkZToa/
vz4AEwIzKDEw/P37n+Hj598Mr978ZAAGPAMk8JgZWP7dYhAVfc/8+PauxcCwZAQIIKZnNzdU/Pp2
2ZiNDRj//5mgiYmB4fef/wyrNj5kuHbrIwMrCxM8kf399Z1BgPMaw4/3h0xfPb6UDxBAjOd25f3S
tTJkZfl7B2jrH4b//34CE9M3cMj//P6ZgYXpO1DsOwMDEP8Hiv0D0iAXvXijyfD1r801gABi+f3j
Pev371wMrMymQDv+MvxnBGKm30Dr/jCw8gET2N9fYMzAAExooMT2/y8wQP8ysHC9Z/jx/DErQAAx
vn5ypPnGqZVOb57c+sHEDAwrBuTkygjxD5TNCKX//WVgFJKU/S2uZD4TIIAYseUwUgBAgAEAZ7WJ
gC7ArQ0AAAAASUVORK5CYII=
EOF;
	} else if ($image == "top.png") {
	
		$image = <<<EOF
pngiVBORw0KGgoAAAANSUhEUgAAABYAAAAWCAIAAABL1vtsAAAABGdBTUEAANbY1E9YMgAAABl0RVh0
U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAClSURBVHjaYvz58ycDZQAggFi+fftGoREA
AcRCuSsAAojl379/FBoBEEBMDBQDgACighEAAUQFjwAEEMv///8pNAIggFCMALIZGRkxFeEXBwgg
dI/gchQecYAAooJHAAKICsEJEEBUMAIggKhgBEAAUcEIgACiQnACBBDL379/KTQCIICo4BGAAEIx
grzUCRBAVPAIQABRwSMAAcRy6NAhCo0ACDAA6KJV7QOe/70AAAAASUVORK5CYII=
EOF;
	} else if ($image == "ok.gif") {
	
		$image = <<<EOF
gifR0lGODlhEAAQANU4AADpAADKAADPAADTAADbAADVAADdAACuAAaeBgCsAIXOgQjtCKbHplqvWgr1
CnGecT6kPhB3EGi2aEuwS0WsRTemNyqEKgB4AAHAASmfKQC+AFm0WQDgAFSDVADaAGK1Yih4KADx
ABi5GMPUwxvOG1O7Ux+9HxK1EgDuALvjuQD+AACyAADzAEGdQTuuOyF1IQu+CxmnGWGoYQCxAGK2
YsPkwwiWCACDAP///wAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAADgALAAAAAAQABAAAAZUQJxw
SCwaj8gkLqXYKHG1CgVHyyRLMclQ5DJOSKbiaQEZfjAOmLHBMrRkM4DqcGQEQoMCCmBLIggeHAI3
ShYBAhoRTw8rCS9POCMXIJBCHZWYmUJBADs=
EOF;
	}
	
	$type = substr($image, 0, 3);
	$image = substr($image, 3);
	switch ($type) {
		case "png":
			header("Content-Type: image/png"); break;
		case "jpg":
			header("Content-Type: image/jpeg"); break;
		case "gif":
			header("Content-Type: image/gif"); break;
	}
	header("Content-Disposition: inline");
	echo base64_decode($image);
	exit;
}

function printHeader() {

?>
<html>
<head>
<style>
body, p, td, tr, table, input { font-family: verdana, arial, helvetica; color: #444444; font-size: 12px;}
.title { font-size: 26px; font-weight: bold;}
a { text-decoration: none; color : #0B5979; }
a:hover { color : #0B5979; text-decoration: underline; }
</style>
</head>
<body>
	<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td align="center" valign="middle">
				<div style="margin: 0px; text-align: left; border: solid #999 1px; width: 550px; height: 402px; background-image:url(<?=$_SERVER['PHP_SELF']?>?image=background.png);">
					<table width="550" height="22" cellspacing="0" cellpadding="0" border="0">
					<tr><td background="<?=$_SERVER['PHP_SELF']?>?image=top.png" height="22" align="center">
						<b>Online-Installation</b>
					</td></tr>
					</table>
					<table width="550" height="80" cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td width="100" height="78" valign="top">
							<img style="margin: 8px 0 0 17px;" src="<?=$_SERVER['PHP_SELF']?>?image=setup.png">
						</td>
						<td width="450" valign="top">
							<img src="<?=$_SERVER['PHP_SELF']?>?image=1x1.gif" height="30"><br>
							<span class="title">AJAX-FilmDB Installation</span><br>
							&nbsp;<? if (isset($_SESSION['version']) && $_SESSION['version'] != '') print "Version ".$_SESSION['version']; ?>
						</td>
					</tr>
					</table>
					<table width="550" height="275" style="overflow:auto;" cellspacing="0" cellpadding="0" border="0">
					<tr>
<? }

function printNextButton() {
	global $text, $lang, $nextStep, $step, $SID;

?>
</tr></table>
<table width="550" height="16" cellspacing="0" cellpadding="0" border="0">
<tr>
	<td valign="bottom" align="right">
		<a href="<?=$_SERVER['PHP_SELF']?>?step=<?=$nextStep?>&laststep=<?=$step?>&lang=<?=$lang?><?=$SID?>">
		<img src="<?=$_SERVER['PHP_SELF']?>?image=goon.png" align="absmiddle" hspace="5" border="0"><b><?=$text['next']?></b></a>&nbsp;&nbsp;&nbsp;
	</td>
<? }

function printBackNextButton($backActive = 1, $nextActive = 1) {
	global $text, $lang, $nextStep, $prevStep, $step, $SID;

?>
</tr></table>
<table width="550" height="16" cellspacing="0" cellpadding="0" border="0">
<tr>
	<td valign="bottom" align="right">
<?
			if ($backActive) {
				print "<a href=\"".$_SERVER['PHP_SELF']."?step=".$prevStep."&laststep".$step."&lang=".$lang.$SID."\">";
				print "<img src=\"".$_SERVER['PHP_SELF']."?image=goon.png\" align=\"absmiddle\" hspace=\"5\" border=\"0\"><b>".$text['back']."</b></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			} else {
				print "<img src=\"".$_SERVER['PHP_SELF']."?image=goon.png\" align=\"absmiddle\" hspace=\"5\" border=\"0\"><b><font color=\"#CCCCCC\">".$text['back']."</font></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			if ($nextActive) {
				print "<a href=\"".$_SERVER['PHP_SELF']."?step=".$nextStep."&laststep=".$step."&lang=".$lang.$SID."\">";
				print "<img src=\"".$_SERVER['PHP_SELF']."?image=goon.png\" align=\"absmiddle\" hspace=\"5\" border=\"0\"><b>".$text['next']."</b></a>&nbsp;&nbsp;&nbsp;";
			} else {
				print "<img src=\"".$_SERVER['PHP_SELF']."?image=goon.png\" align=\"absmiddle\" hspace=\"5\" border=\"0\"><b><font color=\"#CCCCCC\">".$text['next']."</font></b>&nbsp;&nbsp;&nbsp;";
			}
?>
	</td>
<? } 
function printFooter() { 
?>
					</tr>
					</table>
				</div>
			</td>
		</tr>
	</table>
</body>
</html>

<? }

class unzipfile {
	var $zipname;
	
	function unzipfile($zipname) {
		$this->zipname = $zipname;
	}

	function extract() {
		$fp = @fopen($this->zipname, "rb");
		
		@fseek($fp, filesize($this->zipname)-18);
	
		$centralDir = unpack('vdisk/vdisk_start/vdisk_entries/ventries/Vsize/Voffset/vcomment_size', @fread($fp, 18));
		
		$pos = $centralDir['offset'];
		
		for ($i = 0, $extracted = 0; $i < $centralDir['entries']; $i++) {
			
			@rewind($fp);
			@fseek($fp, $pos);
			
			$data = unpack('Vid', @fread($fp, 4));
			if ($data['id'] != 0x02014b50)
				return -1;

			$fileHeader = unpack('vversion/vversion_extracted/vflag/vcompression/vmtime/vmdate/Vcrc/Vcompressed_size/Vsize/vfilename_len/vextra_len/vcomment_len/vdisk/vinternal/Vexternal/Voffset', @fread($fp, 42));
			
			$fileHeader['filename'] = fread($fp, $fileHeader['filename_len']);
			$fileHeader['extra'] = ($fileHeader['extra_len'] > 0) ? fread($fp, $fileHeader['extra_len']) : '';
			$fileHeader['comment'] = ($fileHeader['comment_len'] > 0) ? fread($fp, $fileHeader['comment_len']) : '';
			
			$isDirectory = 0;
			if (substr($fileHeader['filename'], -1) == '/')
				$isDirectory = 1;

			$fileHeader['mtime'] = $this->toUnixTimeStamp($fileHeader['mdate'], $fileHeader['mtime']);
				
			$pos = ftell($fp);
			
			@rewind($fp);
			@fseek($fp, $fileHeader['offset']);
			
			// ----- File entry
			$data = unpack('Vid', @fread($fp, 4));
			if ($data['id'] != 0x04034b50)
				return -1;

			$fileHeader = unpack('vversion/vflag/vcompression/vmtime/vmdate/Vcrc/Vcompressed_size/Vsize/vfilename_len/vextra_len', @fread($fp, 26));
			
			$fileHeader['filename'] = fread($fp, $fileHeader['filename_len']);
			$fileHeader['extra'] = ($fileHeader['extra_len'] > 0) ? fread($fp, $fileHeader['extra_len']) : '';
			
			$fileHeader['mtime'] = $this->toUnixTimeStamp($fileHeader['mdate'], $fileHeader['mtime']);
						
			// ----- Do the extraction (if not a directory)
			if (!$isDirectory) {
			
				$dirs = explode('/', $fileHeader['filename']);
				array_pop($dirs);
				$path ='';
				
				// ----- Create directories which are necessary to store file
				foreach ($dirs as $dir) {
					$path .= $dir;
					if (!file_exists($path) || !is_dir($path))
						mkdir($path);
						
					$path .= '/';
				}
			
				// ----- Look for not compressed file
				if ($fileHeader['compression'] == 0) {
					if (($destFile = @fopen($fileHeader['filename'], 'wb')) == 0)  
						return -1;

					$fsize = $fileHeader['compressed_size'];
					while ($fsize != 0) {
						$readSize = ($fsize < 2048 ? $fsize : 2048);
						$buffer = fread($fp, $readSize);
						@fwrite($destFile, pack('a'.$readSize, $buffer), $readSize);
						$fsize -= $readSize;
					}

					fclose($destFile);

					touch($fileHeader['filename'], $fileHeader['mtime']);

				} else {

					if (($destFile = @fopen($fileHeader['filename'], 'wb')) == 0)
						return -1;

					$buffer = @fread($fp, $fileHeader['compressed_size']);

					// ----- Decompress the file
					$fileContent = gzinflate($buffer);
					unset($buffer);

					// ----- Write the uncompressed data
					@fwrite($destFile, $fileContent, $fileHeader['size']);
					unset($fileContent);

					@fclose($destFile);

					// ----- Change the file mtime
					touch($fileHeader['filename'], $fileHeader['mtime']);
				}
			}
		}
	}
	
	function toUnixTimeStamp ($mdate, $mtime) {
		if ($mdate && $mtime) {
			$hour = ($mtime & 0xF800) >> 11;
			$minute = ($mtime & 0x07E0) >> 5;
			$second = ($mtime & 0x001F) * 2;
			$year = (($mdate & 0xFE00) >> 9) + 1980;
			$month = ($mdate & 0x01E0) >> 5;
			$day = $mdate & 0x001F;
			return mktime($hour, $minute, $second, $month, $day, $year);
		} else
			return time();
	}
}

function initLanguages($lang) {
	global $text;
	$prog = "FilmDB";
	$source = "www.netzgesta.de/archive/";
	if ($lang == 'de') {
		$text['error'] = "Fehler";
		$text['download'] = "Die Installation kann nicht fortgesetzt werden. Es wurde kein Installations Zipfile im aktuellen Verzeichnis gefunden.<br><br>Bitte laden Sie sich die aktuelle <b>$prog</b> Version von <a href=\"http://$source\" target=\"_blank\">$source</a> herunter und kopieren sie das Zipfile in das Verzeichnis, in dem auch dieses Installationsskript liegt. Danach k&ouml;nnen Sie das Installationsskript erneut aufrufen.";  
		$text['welcome'] = "Willkommen zur Installation von <b>$prog</b><br><br>Dieses kleine Setup wird Sie schnell mit ein paar Schritten zum Ziel f&uuml;hren, um danach sofort mit $prog arbeiten zu k&ouml;nnen. Hier nochmal die Hauptmerkmale von $prog:<br>";
		$text['feat1'] = "Komfortable FilmDatenBank mit automatischer Ermittlung aller relevanten Film-Informationen <i>(inkl. Poster, Darsteller, Regie u.s.w.)</i>.";
		$text['feat2'] = "Aussehen und Handhabung orientieren sich an Mac OS-X und dank AJAX <i>(<b>A</b>syncronious <b>J</b>avascript <b>A</b>nd <b>X</b>ML)</i> auch die Bedienung.";
		$text['feat3'] = "Alle Einstellungen <i>(z.B. die Benutzerspezifischen)</i> lassen sich sehr bequem erledigen, ohne das Programm verlassen zu m&uuml;ssen.";
		$text['feat4'] = "Funktioniert auf allen Browsern mit <b>Gecko</b> oder <b>KHTML/Webkit</b> Rendering Engine <i>(z.B. SeaMonkey/Mozilla/Firefox/Netscape/Safari/Konqueror usw.)</i>.";
		$text['next'] = "Weiter";
		$text['back'] = "Zur&uuml;ck";
		$text['selectpaths'] = "W&auml;hlen Sie bitte den Pfad.<br><br>Der absolute Pfad des Hauptverzeichnisses Ihres Webservers wurde ermittelt und bereits vor dem Eingabefeld ausgegeben.<br><br>Wenn Sie nicht wissen, was Sie hier eintragen sollen, dann verwenden Sie bitte den vorgegebenen Wert.";
		$text['prgdir'] = "Verzeichnis, in das die Dateien von <b>$prog</b> abgelegt werden sollen:<br>";
		$text['paths_checked'] = "Der eingegebene Pfad wurde gepr&uuml;ft.<br><br>Zusammenfassung:";
		$text['nopermission'] = "Keine Schreibberechtigung im folgenden Verzeichnis<br>";
		$text['selectoptions'] = "W&auml;hlen Sie bitte aus, ob diese Komponente installiert werden soll.";
		$text['doc'] = "Dokumentation &nbsp;<i>(<b>$prog</b> Online-Hilfe und PDF: 9.5 MB)</i>";
		$text['mysqllogin'] = "Hier m&uuml;ssen Sie nun die Zugangsdaten des <b>MySQL 4.x</b> Servers eingeben, der von <b>$prog</b> genutzt werden soll.<br>Bitte geben Sie den Host, Benutzer, Passwort und einen Datenbanknamen ein."; 
		$text['db_server'] = "Datenbankserver";
		$text['username'] = "Benutzername";
		$text['password'] = "Passwort";
		$text['db_name'] = "Datenbankname";
		$text['installtext'] = "Es wurden alle n&ouml;tigen Informationen eingegeben und die Installation kann nun abgeschlossen werden.<br><br>Dieser Vorgang kann einige Sekunden dauern."; 
		$text['install'] = "Installieren";
		$text['installation'] = "Installation";
		$text['testinstall'] = "...testen Sie die AJAX-FilmDB doch mal...";
		$text['removeinstaller'] = "<b><u><font color=\"red\">WICHTIG</font></u></b>:<br>Sie sollten nun dieses Installationsskript (".basename(@$_SERVER['PHP_SELF']).") von ihrem Webserver entfernen, um einen Missbrauch zu verhindern.";
		$text['sqlnodatabase'] = "Die MySQL-Datenbank konnte NICHT eingerichtet werden.";
		$text['sqlnotables']   = "Die MySQL-Tabellen konnten NICHT erzeugt werden.";
		$text['sqlnoconnect']  = "Die MySQL-Zugangsdaten sind NICHT korrekt!";
		$text['progcompleted'] = "Die Programm-Installation wurde erfolgreich abgeschlossen.";
		$text['sqlcompleted']  = "Die MySQL-Installation wurde erfolgreich abgeschlossen.";
		$text['installcompleted'] = "Die Installation wurde erfolgreich abgeschlossen.";
		$text['sqlincomplet']  = "Die MySQL-Installation konnte nicht abgeschlossen werden. Um den Betrieb des Programmes sicherzustellen ist eine manuelle Einrichtung der MySQL-Datenbank (wie im PDF beschrieben) notwendig!";
	} else if ($lang == 'en') { 
		$text['error'] = "Error";
		$text['download'] = "The installation cannot be continued. No installation zip file was found in the current directory.<br><br>Please download the latest version of <b>$prog</b> from <a href=\"http://$source\" target=\"_blank\">$source</a> and copy the zip file in the same directory which contains this installation script. Then you can call again the installations script.";  
		$text['welcome'] = "Welcome to the installation of <b>$prog</b><br><br>This little setup will guide you quickly with few steps through the installation process, so that you can work with $prog immediately. Here again the main features of $prog:<br>";
		$text['feat1'] = "Comfortable film database with automatic determination of all relevant film information <i>(incl. Poster, Actors, Director etc.)</i>.";
		$text['feat2'] = "Appearance is oriented at Mac OS-X and owing to AJAX <i>(<b>A</b>syncronious <b>J</b>avascript <b>A</b>nd <b>X</b>ML)</i> also the handling.";
		$text['feat3'] = "All program configurations can be settled very comfortably online. You don't need to leave the browser.";
		$text['feat4'] = "All browsers with <b>Gecko</b> or <b>KHTML/Webkit</b> Rendering engine are supported <i>(e.g. SeaMonkey/Mozilla/Firefox/Netscape/Safari/Konqueror etc.)</i>.";
		$text['next'] = "Next";
		$text['back'] = "Back";
		$text['selectpaths'] = "Please specify the path.<br><br>The absolute path to the root directory of your webserver was detected and was already printed out in front of the input field.<br><br>If you don't know, what to enter here, then please use the pre-defined value.";
		$text['prgdir'] = "Directory, where the files of <b>$prog</b> will be copied to:<br>";
		$text['paths_checked'] = "The entered path was verified.<br><br>Result:";
		$text['nopermission'] = "No write access in the following directory:<br>";
		$text['selectoptions'] = "Please select the component which shall be installed additionally.";
		$text['doc'] = "Documentation &nbsp;<i>(<b>$prog</b> Online-Help and PDF: 9.5 MB)</i>";
		$text['mysqllogin'] = "Now you must enter the access data of the <b>MySQL 4.x</b> server used by <b>$prog</b>.<br>Please enter the hostname, username, password and a database name.";
		$text['db_server'] = "Databaseserver";
		$text['password'] = "Password";
		$text['username'] = "Username";
		$text['db_name'] = "Databasename";
		$text['installtext'] = "The required information was entered correctly and the installation can be completed now.<br><br>This process can take a few seconds."; 
		$text['install'] = "Install";
		$text['installation'] = "Installation";
		$text['testinstall'] = "...test the AJAX-FilmDB for fun...";
		$text['removeinstaller'] = "<b><u><font color=\"red\">IMPORTANT</font></u></b>:<br>You should now remove this installation script (".basename(@$_SERVER['PHP_SELF']).") from your webserver to avoid any abuse.";
		$text['progcompleted'] = "The program installation has been completed successfully.";
		$text['sqlcompleted'] = "The MySQL installation has been completed successfully.";
		$text['installcompleted'] = "The installation has been completed successfully.";
		$text['sqlnodatabase'] = "The MySQL database could NOT be created.";
		$text['sqlnotables']   = "The MySQL tables could NOT be generated.";
		$text['sqlnoconnect']  = "The MySQL access data is NOT correkt!";
		$text['sqlincomplet']  = "The MySQL installation was not successful. To get the program running the MySQL database must be installed manually (as described in the PDF/README)!";
	}
}
?>