<?php
/* FilmDB (based on php4flicks) */

/* script to display a form with all information found on a movie */

require_once('config/config.php');

// user is logged in
$loggedin = true; $loging = 1; $loguser = $_SESSION['user'];

if(isset($reload)){
	$reload = true;
	$title = htmlspecialchars(isset($_POST['title'])?$_POST['title']:'');
	$local = htmlspecialchars(isset($_POST['local'])?$_POST['local']:$_POST['title']);
	$year = (isset($_POST['year'])?$_POST['year']:'1999');
	$director = (isset($_POST['director'])?$_POST['director']:array());
	$writer = (isset($_POST['writer'])?$_POST['writer']:array());
	$runtime = (isset($_POST['runtime'])?$_POST['runtime']:'0');
	$actor = (isset($_POST['actor'])?$_POST['actor']:array());
	($imdbid = $_POST['imdbid']) or die('no movie id.');
	$setposter = $_POST['setposter'];
	$slang = $_POST['lang_array'];
	$sgenre = $_POST['genre_array'];
	$smedium = $_POST['medium'];
	$stype = $_POST['type'];
	$scontainer = $_POST['container'];
	$svideo = $_POST['video'];
	$sformat = $_POST['format'];
	$sratio = $_POST['ratio'];
	$saudio = $_POST['audio'];
	$schannel = $_POST['channel'];
	$sherz = $_POST['herz'];
	$width = (isset($_POST['width'])?$_POST['width']:'720');
	$height = (isset($_POST['height'])?$_POST['height']:'576');
	$disks = (isset($_POST['disks'])?$_POST['disks']:'1');
	$rating = (isset($_POST['rating'])?$_POST['rating']:'0');
	$avail = (isset($_POST['avail'])?$_POST['avail']:'1');
	$lentsince = (isset($_POST['lentsince'])?$_POST['lentsince']:'');
	$lentto = (isset($_POST['lentto'])?$_POST['lentto']:'0');
	$comment = (isset($_POST['comment'])?$_POST['comment']:'');
	$country = (isset($_POST['country'])?$_POST['country']:'');
	$aka = (isset($_POST['aka'])?$_POST['aka']:'');
	$nr = $_POST['nr'];
	$cat = $_POST['cat'];
	$fid = $_POST['fid'];
} else{
	if(!isset($local)) $local = $title;
	if(!isset($slang)) $slang = array();
	if(!isset($sgenre)) $sgenre = array();
	if(!isset($sformat)) $sformat = 'PAL';
	if(!isset($sratio)) $sratio = '16:9';
	if(!isset($smedium)) $smedium = 'BD';
	if(!isset($saudio)) $saudio = 'AC3';
	if(!isset($stype)) $stype = '-R';
	if(!isset($scontainer)) $scontainer = 'MPEG-2';
	if(!isset($svideo)) $svideo = 'MPEG-2';
	if(!isset($schannel)) $schannel = '5.1';
	if(!isset($sherz)) $sherz = '48.0';
	if(!isset($comment)) $comment = '';
	if(!isset($country)) $country = '';
	if(!isset($width)) $width = '720';
	if(!isset($height)) $height = '576';
	if(!isset($disks)) $disks = '1';
	if(!isset($rating)) $rating = '0';
	if(!isset($avail)) $avail = '1';
	if(!isset($lentsince)) $lentsince = '0000-00-00';
	if(!isset($lentto)) $lentto = '0';
	if(!isset($aka)) $aka = '';
	if(!isset($nr)) $nr = '';
	if(!isset($cat)) $cat = '';
	if(!isset($fid)) $fid = '';
}

$writersize = (isset($_GET['writersize'])?$_GET['writersize']:sizeof($writer));
$actorsize = (isset($_GET['actorsize'])?$_GET['actorsize']:sizeof($actor));
$directorsize = (isset($_GET['directorsize'])?$_GET['directorsize']:sizeof($director));

function imginfo($val,$path) {
	global $setposter, $imdbid, $cfg;
	if(isset($setposter)&&($setposter!=false && $setposter!='')){
		echo round(strlen($_SESSION['image'][$imdbid])/1024,3).' KB [<b>'.(!$cfg['use_blob']?"F":"B").'</b>]';
	}else {
		$result = mysql_query('SELECT poster FROM movies WHERE movies.fid = \''.$val.'\'') or die(mysql_error());
		$pic = mysql_fetch_row($result);
		$file=$path.'/'.$val.'.pic';
		if(!is_readable($file)) $file="";
		if($pic[0]) {
			echo round(strlen($pic[0])/1024,3).' KB [<b>B</b>]';
		}else if($file!="") {
			echo round(filesize($file)/1024,3).' KB [<b>F</b>]';
		}		
	}
}
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
       "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="<?= $conttype ?>">
		<title><?= $trans['page_title']?>:Edit</title>
		<link rel="icon" href="favicon.ico" type="image/ico">
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<meta http-equiv="imagetoolbar" content="no">
		<meta http-equiv="expires" content="0">
		<meta http-equiv="pragma" content="no-cache">
		<meta http-equiv="cache-control" content="no-cache">
		<meta http-equiv="Content-Script-Type" content="text/javascript">
		<script type="text/javascript" language="JavaScript">
		<!--
<?php
	echo '			logged_in = '.$loging.';'."\n";
	echo '			cur_date ="'.date("Y-m-d").'";'."\n";
	echo '			in_progress="<h2><nobr><b>'.$trans['work_in_progress'].'</b></nobr></h2><br><br><table width=\"100%\" height=\"16\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td height=\"32\" width=\"100%\" align=\"center\"><img src=\"images/indicator.gif\" width=\"32\" height=\"32\" border=\"0\"></td></tr></table>";'."\n";
	// echo '			in_progress="<h2><nobr><b>'.$trans['work_in_progress'].'</b></nobr></h2><br><table width=\"100%\" height=\"16\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td height=\"16\" width=\"100%\" background=\"images/progress.gif\"><img src=\"images/space.gif\" width=\"16\" height=\"16\" border=\"0\"></td></tr></table>";';
	echo '			att_pic="<img src=\"images/attention.png\" alt=\"attention\" width=\"20\" height=\"18\" border=\"0\">&nbsp;";'."\n";
	echo '			login ="<img src=\"images/button/login_off.png\" title=\"'.$trans['log_in'].'\" alt=\"login/out\" width=\"30\" height=\"24\" border=\"0\" name=\"log_in\" onClick=\"setGET_add();change(\'log_in\',\'login_off\');showRequest(true,\'editreq\',\'login.php\');\" onmouseover=\"change(\'log_in\',\'login_on\')\" onmouseout=\"change(\'log_in\',\'login_off\')\">";'."\n";
	echo '			logout="<img src=\"images/button/logout_off.png\" title=\"'.$trans['log_out'].'\" alt=\"login/out\" width=\"30\" height=\"24\" border=\"0\" name=\"log_out\" onClick=\"setGET_add();change(\'log_out\',\'logout_off\');ajaxpage(\'logout.php\',\'editreqsource\');log_user_out();\" onmouseover=\"change(\'log_out\',\'logout_on\')\" onmouseout=\"change(\'log_out\',\'logout_off\')\">";'."\n";
	echo '			add_no ="<img src=\"images/button/plus_off.png\" title=\"'.$trans['add_film'].'\" alt=\"add\" width=\"30\" height=\"24\" border=\"0\" name=\"plus_film\" onClick=\"change(\'plus_film\',\'plus_off\');showRequest(att_pic + \''.$trans['alert_title'].$trans['login_alert'].'\',\'textreq\',\'\');\" onmouseover=\"change(\'plus_film\',\'plus_on\')\" onmouseout=\"change(\'plus_film\',\'plus_off\')\">";'."\n";
	echo '			add_yes="<img src=\"images/button/plus_off.png\" title=\"'.$trans['add_film'].'\" alt=\"add\" width=\"30\" height=\"24\" border=\"0\" name=\"plus_film\" onClick=\"setGET_add();change(\'plus_film\',\'plus_off\');showRequest(true,\'editreq\',\'add.php\');\" onmouseover=\"change(\'plus_film\',\'plus_on\')\" onmouseout=\"change(\'plus_film\',\'plus_off\')\">";'."\n";
	echo '			importing_yes="<img src=\"images/button/import_off.png\" title=\"'.$trans['import_film'].'\" alt=\"import\" width=\"30\" height=\"24\" border=\"0\" name=\"import_film\" onClick=\"setGET_add();change(\'import_film\',\'import_off\');showRequest(true,\'editreq\',\'importfilm.php\');\" onmouseover=\"change(\'import_film\',\'import_on\')\" onmouseout=\"change(\'import_film\',\'import_off\')\">";'."\n";
	echo '			importing_no ="<img src=\"images/button/import_off.png\" title=\"'.$trans['import_film'].'\" alt=\"import\" width=\"30\" height=\"24\" border=\"0\" name=\"import_film\" onClick=\"change(\'import_film\',\'import_off\');showRequest(att_pic + \''.$trans['alert_title'].$trans['login_alert'].'\',\'textreq\',\'\');\" onmouseover=\"change(\'import_film\',\'import_on\')\" onmouseout=\"change(\'import_film\',\'import_off\')\">";'."\n";
?>
			film_off = new Image(); film_off.src = 'images/button/film_off.png';
			row_off = new Image(); row_off.src = 'images/button/row_off.png';
			poster_off = new Image(); poster_off.src = 'images/button/poster_off.png';
			list_off = new Image(); list_off.src = 'images/button/list_off.png';
			list_on = new Image(); list_on.src = 'images/button/list_on.png';
			if(parent.window.document.getElementById('plus_film') == null)
			{ noframe = true; } else { noframe = false; }

			function display_LCD(f){
				var div = parent.window.document.getElementById('lcd');
				var txt = "<nobr><?= $trans['version'].'&nbsp;<b>'.$cfg['filmdb_version'].'</b>&nbsp;&bull;&nbsp;'.$cfg['filmdb_release']?></nobr>";
				if(f){
					div.innerHTML = f;
				} else {
<? if($b_delete!=''){ ?>
						txt = "<nobr><?= $trans['user_mode'].':&nbsp;<b>'.$trans['edit_mode'].'</b>' ?></nobr>";
<? } else { ?>
						txt = "<nobr><?= $trans['user_mode'].':&nbsp;<b>'.$trans['add_mode'].'</b>' ?></nobr>";
<? } ?>
					div.innerHTML = txt;
				}
			}
			function resets_view(){
				parent.window.document.row_view.src = row_off.src;
				parent.window.document.poster_view.src = poster_off.src;
				parent.window.document.list_view.src = list_off.src;
				parent.window.document.film_view.src = film_off.src;
			}
			function set_LogButton(){
				if(!noframe){
					resets_view(); display_LCD();
					var add = parent.window.document.getElementById('plus_film');
					var imp = parent.window.document.getElementById('import_film');
					var log = parent.window.document.getElementById('log_inout');
					if(logged_in > 0){
						add.innerHTML = add_yes;
						imp.innerHTML = importing_yes;
						log.innerHTML = logout;
					} else {
						add.innerHTML = add_no;
						imp.innerHTML = importing_no;
						log.innerHTML = login;
					}
				}
			}
			function close_Request(n){
				var div = parent.window.document.getElementById(n+'source');
				div.innerHTML = '';
			}
			function show_Request(f,n,d){
				var requestBox = parent.window.document.getElementById('locker');
				var boxContent = parent.window.document.getElementById(n);
				var contentDiv = parent.window.document.getElementById(n+'source');
				if(f){
					var tmp = typeof(f); var cls = typeof(d);
					if(cls!='boolean'){
						if(tmp=='boolean'){
							parent.window.ajaxpage(d,n+'source');
						} else {
							contentDiv.innerHTML = f;
						}
					}
					parent.window.focus();
					requestBox.style.display = 'block';
					requestBox.style.visibility = 'visible';
					boxContent.style.display = 'block';
					boxContent.style.visibility = 'visible';
				} else {
					requestBox.style.display = 'none';
					requestBox.style.visibility = 'hidden';
					boxContent.style.display = 'none';
					boxContent.style.visibility = 'hidden';
					var cls = typeof(d);
					if(cls=='boolean'){
						contentDiv.innerHTML = '';
					}
				}
			}
			function fill_Request(n){
				var div = parent.window.document.getElementById(n+'source');
				div.innerHTML = in_progress;
			}
			// add.php function
			function getperson(s){
				var lh = <?= $cfg['listheight']?>;
<? 
if($cfg['autoheight']==true) {
echo '    		if(parent.window.document.body.offsetHeight) lh=parent.window.document.body.offsetHeight-216;'."\n"; 
} ?>
				theUrl = 'getperson.php?lh='+lh+'&'+s;
				parent.window.focus();
				fill_Request('editreq');
				show_Request(true,'editreq',theUrl);
			}
			function set_other(medium){
				switch(medium){
				case "UMD":
					document.data.container.value = 'MP4';
					document.data.video.value = 'H264';
					document.data.width.value = '480';
					document.data.height.value = '272';
					document.data.format.value = '30';
					document.data.ratio.value = '16:9';
					document.data.audio.value = 'ATRAC';
					document.data.channel.value = '2.0';
					document.data.herz.value = '48.0';
					document.data.container.selectedIndex = 2;
					document.data.video.selectedIndex = 6;
					document.data.format.selectedIndex = 7;
					document.data.ratio.selectedIndex = 0;
					document.data.audio.selectedIndex = 5;
					document.data.channel.selectedIndex = 2;
					document.data.herz.selectedIndex = 3;
					break;
				case "SuperVCD":
					document.data.container.value = 'MPEG-2';
					document.data.container.selectedIndex = 1;
					document.data.video.value = 'MPEG-2';
					document.data.video.selectedIndex = 1;
					document.data.width.value = '480';
					document.data.height.value = '576';
					document.data.format.value = 'PAL';
					document.data.format.selectedIndex = 0;
					document.data.ratio.value = 'LetterBox';
					document.data.ratio.selectedIndex = 2;
					document.data.audio.value = 'MP2';
					document.data.audio.selectedIndex = 2;
					document.data.channel.value = '2.0';
					document.data.channel.selectedIndex = 2;
					document.data.herz.value = '44.1';
					document.data.herz.selectedIndex = 2;
					break;
				case "VideoCD":
					document.data.container.value = 'MPEG-1';
					document.data.container.selectedIndex = 0;
					document.data.video.value = 'MPEG-1';
					document.data.video.selectedIndex = 0;
					document.data.width.value = '352';
					document.data.height.value = '288';
					document.data.format.value = 'PAL';
					document.data.format.selectedIndex = 0;
					document.data.ratio.value = 'LetterBox';
					document.data.ratio.selectedIndex = 2;
					document.data.audio.value = 'MP2';
					document.data.audio.selectedIndex = 2;
					document.data.channel.value = '2.0';
					document.data.channel.selectedIndex = 2;
					document.data.herz.value = '44.1';
					document.data.herz.selectedIndex = 2;
					break;
				case "ISO-DVD":
				case "ISO-CD":
					document.data.container.value = 'AVI';
					document.data.container.selectedIndex = 3;
					document.data.video.value = 'Xvid';
					document.data.video.selectedIndex = 4;
					document.data.width.value = '720';
					document.data.height.value = '400';
					document.data.format.value = 'PAL';
					document.data.format.selectedIndex = 0;
					document.data.ratio.value = 'Flexibly';
					document.data.ratio.selectedIndex = 4;
					document.data.audio.value = 'MP3';
					document.data.audio.selectedIndex = 3;
					document.data.channel.value = '2.0';
					document.data.channel.selectedIndex = 2;
					document.data.herz.value = '48.0';
					document.data.herz.selectedIndex = 3;
					break;
				case "BD":
				case "HD-DVD":
					document.data.container.value = 'MP4';
					document.data.container.selectedIndex = 2;
					document.data.video.value = 'H264';
					document.data.video.selectedIndex = 6;
					document.data.width.value = '1280';
					document.data.height.value = '720';
					document.data.format.value = 'PAL';
					document.data.format.selectedIndex = 0;
					document.data.ratio.value = '16:9';
					document.data.ratio.selectedIndex = 0;
					document.data.audio.value = 'AAC';
					document.data.audio.selectedIndex = 4;
					document.data.channel.value = '5.1';
					document.data.channel.selectedIndex = 7;
					document.data.herz.value = '48.0';
					document.data.herz.selectedIndex = 3;
					break;
				case "MiniDVD":
				default:
					document.data.container.value = 'MPEG-2';
					document.data.container.selectedIndex = 1;
					document.data.video.value = 'MPEG-2';
					document.data.video.selectedIndex = 1;
					document.data.width.value = '720';
					document.data.height.value = '576';
					document.data.format.value = 'PAL';
					document.data.format.selectedIndex = 0;
					document.data.ratio.value = '16:9';
					document.data.ratio.selectedIndex = 0;
					document.data.audio.value = 'AC3';
					document.data.audio.selectedIndex = 0;
					document.data.channel.value = '5.1';
					document.data.channel.selectedIndex = 7;
					document.data.herz.value = '48.0';
					document.data.herz.selectedIndex = 3;
					break;
				}
			}
			function set_height(medium,format){
				switch(medium){
				case "VideoCD":
					if(format!='PAL'){
						document.data.height.value = '240';
					} else {
						document.data.height.value = '288';
					}
					break;
				case "VideoDVD":
				case "SuperVCD":
				case "MiniDVD":
					if(format!='PAL'){
						document.data.height.value = '480';
					} else {
						document.data.height.value = '576';
					}
					break;
				default:
					break;
				}
			}
			function set_avail(lent){
				if(!lent){
					document.data.lentto.value = 0;
					document.data.lentto.text = '-';
					document.data.lentto.selectedIndex = 0;
					document.data.lentsince.value = '0000-00-00';
					document.data.avail.value = '1';
				} else {
					document.data.lentsince.value = cur_date;
					document.data.avail.value = '0';
				}
			}
<!-- function to automatically chose category when medium is selected -->
<? if(isset($cfg['cats'])){ ?>
			function setcat(medium){
				set_other(medium);
				var theCat = ''; var free = '';
				switch(medium){
<?
foreach($cfg['medium'] as $m){
	if(isset($cfg['cats'][$m])){
		echo 'case \''.$m.'\' : theCat = \''.$cfg['cats'][$m].'\';';
		$res = mysql_query("SELECT MAX(nr)+1 as free FROM movies WHERE cat='".$cfg['cats'][$m]."' GROUP BY cat") or die(mysql_error());
		$row = mysql_fetch_row($res);
		echo "free='$row[0]'; break;";
	}
}
?>
				}
				if(free == '') free = '0';
				document.data.cat.value = theCat;
				document.data.nr.value = free;
			}
<? } ?>
			function check(){
				if(document.data.title.value==''){
					alert('<?= $trans['js_title_alert']?>'); document.data.title.focus(); return false;
				}
				if(document.data.local.value==''){
					alert('<?= $trans['js_local_alert']?>'); document.data.local.focus(); return false;
				}
				if(document.data.nr.value==''){
					alert('<?= $trans['js_number_alert']?>'); document.data.nr.focus(); return false;
				}
				var langChecked = false;
				for(i=0;i<document.data['lang_array[]'].length;i++){
					if(document.data['lang_array[]'][i].checked)
						langChecked = true;
				}
				if(!langChecked){
					alert('<?= $trans['js_lang_alert']?>'); document.data['lang_array[]'][0].focus(); return false;
				}
				return true;
			}
			function set_value(obj,t,min,max){
				var v = parseInt(t,10);
				if(isNaN(v)) { v = max; }
				if(v > max){
					obj.value = max;
				} else if(v < min){
					obj.value = min;
				} else {
					obj.value = v;
				}
				return false;
			}
		-->
		</script>
		<meta http-equiv="Content-Style-Type" content="text/css">
		<link rel="stylesheet" type="text/css" href="config/<?php if(eregi('Win',$_SERVER['HTTP_USER_AGENT'])) { echo "win"; } else { echo "oos"; } ?>.css">
		<style type="text/css">
		<!--
<? if(isset($_COOKIE['prefs'])) { ?>
			html, body, button, input, select, option, textarea {
				font-size: <?= $cfg['fontsize'] ?>em;
			}
			html, body {
				font-family:'<?= $cfg['fonttype'] ?>','Arial','Helvetica','sans-serif';
			}
<? } ?>
			a { outline: none; text-decoration: none; font-weight: bold; color: #333333; }
			a:hover { text-decoration: none; font-weight: bold; color: #336699; }
			td, th {
				font-size: 86%; 
			}
			h3 { font-size:150%; display:inline; text-shadow: grey 2px 2px 3px; }
			small { font-size:80%; }
			big { font-size:120%; }
			strong { color:#990000; }
			button { 
				background-color:#ccc;
				background-image:url(images/button/pattern.png);
				background-repeat: repeat-x;
				background-position: bottom;
				padding: 0px 8px 0px 8px;
				opacity: 0.9;
				cursor:pointer;
			}
			.row_0 { background-color: #EBF3FF; }
			.row_1 { background-color: #FFFFFF; }
			.editheader {
				background-color: #ffffff;
				background-image:url(images/table/edit_head.png);
				background-repeat: repeat-x;
				background-position: center;
				font-weight: normal;
				height:12px;
			}
			.size {
				color: #444;
				text-align: right;
			}
			.obj { font-size:100%; }
			.edit { 
				display:inline;
				float:left;
				min-width:208px;
				min-height:180px;
				width:15.8em;
				height:13.0em;
				margin:0 6px 6px 0;
			}
			.hite {
				border: solid 1px #D9D9D9;
				min-width:200px;
				min-height:180px;
				height:13.0em;
				width:15.8em;
			}
			.wide {
				min-width:15em;
				width:15em;
			}
			.objwide {
				min-width:14em;
				width:20em;
				font-size:100%; 
			}
			.txtwide {
				min-width:14em;
				width:96%;
				font-size:100%; 
			}
			#panel{
				position: fixed;
				bottom: 0px;
				left: 0px;
				width: 99%;
				min-height: 16px;
				height: auto;
				background-color: transparent;
				z-index:10;
			}
			#guru {
				padding: 4px;
				width: 99%;
				height: auto;
				text-align: center;
				background-color: black;
			}
			#guru div {
				border: solid 3px red;
				padding: 4px;
				font-family: monospace;
				font-size: 100%;
				width: auto;
				height: auto;
				color: red;
				text-align: center;
				text-decoration: blink;
			}
		-->
		</style>
<!--[if gt IE 6]>
		<link rel="stylesheet" type="text/css" href="config/iefixes.css">
		<script type="text/javascript" src="config/fixed.js"></script>
<![endif]-->
<!--[if lt IE 7]>
		<link rel="stylesheet" type="text/css" href="config/iefixes.css">
		<script type="text/javascript" src="config/fixed.js"></script>
		<style type="text/css">
		 img { behavior: url(config/iepngfix.htc); }
		</style>
<![endif]-->
	</head>
	<body onload="set_LogButton(); <? if($cat=='' && isset($cfg['cats'])) echo 'setcat(\''.$cfg['medium'][0].'\');'?>">
		<form name="data" action="insert.php" method="post">
			<input type="hidden" value="<?= $fid; ?>" name="fid">
			<input type="hidden" value="<?= $imdbid; ?>" name="imdbid">
			<input type="hidden" value="<?= $setposter; ?>" name="setposter">
		<noscript><div id="guru"><div><?= $trans['guru_noscript']?></div></div></noscript>

		<div class="edit">
			<table class="hite" border="0" cellspacing="0" cellpadding="2">
				<tr>
					<th class="editheader" style="text-transform:capitalize" align="left" nowrap><b><?= $trans['t_medium'] ?></b></th>
				</tr><tr>
					<td height="99%" bgcolor="#D9D9D9" align="left" valign="top">
					<table class="wide" align="center" border="0" cellspacing="0" cellpadding="1">
					<tr>
					<td align="right" valign="top" style="text-transform:capitalize" nowrap><b><?= $trans['t_medium']?></b>&nbsp;</td>
					<td nowrap><input class="obj" value="<?= $disks; ?>" name="disks" style="background-color:#dee3cb; width:1.5em;" size="1" maxlength="2" type="text" onblur="set_value(this,this.value,1,99);">x<select class="obj" style="background-color:#dee3cb;" name="medium" <? if(isset($cfg['cats'])) echo "onchange=\"setcat(this.value);\"";?>>
<?
foreach($cfg['medium'] as $x)
	echo("<option value=\"$x\"".($smedium==$x?' selected="selected"':'').">$x</option>");
?>
					</select><select class="obj" style="background-color:#dee3cb;" name="type">
<?
foreach($cfg['type'] as $x)
	echo("<option value=\"$x\"".($stype==$x?' selected="selected"':'').">$x</option>");
?>
					</select></td>
				</tr><tr nowrap>
					<td align="right" valign="top" style="text-transform:capitalize" nowrap><b><?= $trans['t_datatype']?></b>&nbsp;</td>
					<td><select class="obj" style="background-color:#dee3cb;" name="container">
<?
foreach($cfg['container'] as $x)
	echo("<option value=\"$x\"".($scontainer==$x?' selected="selected"':'').">$x</option>");
?>
					</select>&nbsp;<span style="text-transform:capitalize"><?= $trans['t_container']?></span></td>
				</tr><tr>
					<td align="right" valign="top" style="text-transform:capitalize" nowrap><b><?= $trans['t_video']?></b>&nbsp;</td>
					<td><select class="obj" style="background-color:#dee3cb;" name="video">
<?
foreach($cfg['video'] as $x)
	echo("<option value=\"$x\"".($svideo==$x?' selected="selected"':'').">$x</option>");
?>
					</select>
					<input class="obj" value="<?= $width; ?>" name="width" style="background-color:#dee3cb; width:3em;" size="4" maxlength="4" type="text" onblur="set_value(this,this.value,120,1920);">x<input class="obj" value="<?= $height; ?>" name="height" style="background-color:#dee3cb; width:3em;" size="4" maxlength="4" type="text" onblur="set_value(this,this.value,80,1080);"><br><select class="obj" style="background-color:#dee3cb;" name="format" onchange="set_height(document.data.medium.value,this.value);">
<?
foreach($cfg['format'] as $x)
	echo("<option value=\"$x\"".($sformat==$x?' selected="selected"':'').">$x</option>");
?>
					</select><select class="obj" style="background-color:#dee3cb;" name="ratio">
<?
foreach($cfg['ratio'] as $x)
	echo("<option value=\"$x\"".($sratio==$x?' selected="selected"':'').">$x</option>");
?>
					</select></td>
				</tr><tr>
					<td align="right" valign="top" style="text-transform:capitalize" nowrap><b><?= $trans['t_audio']?></b>&nbsp;</td>
					<td><select class="obj" style="background-color:#dee3cb;" name="audio">
<?
foreach($cfg['audio'] as $x)
	echo("<option value=\"$x\"".($saudio==$x?' selected="selected"':'').">$x</option>");
?>
					</select><select class="obj" style="background-color:#dee3cb;" name="channel">
<?
foreach($cfg['channel'] as $x)
	echo("<option value=\"$x\"".($schannel==$x?' selected="selected"':'').">$x</option>");
?>
					</select><select class="obj" style="background-color:#dee3cb;" name="herz">
<?
foreach($cfg['herz'] as $x)
	echo("<option value=\"$x\"".($sherz==$x?' selected="selected"':'').">$x</option>");
?>
					</select></td>
				</tr><tr>
					<td align="right" valign="top" style="text-transform:capitalize" nowrap><b><?= $trans['t_languages']?></b>&nbsp;</td>
					<td valign="middle">
<?
foreach($cfg['lang'] as $x)
	echo('<input class="obj" style="background-color:#dee3cb;" type="checkbox" name="lang_array[]" value="'.$x.'"'.(in_array($x,$slang)?' checked="checked"':'').'>'.$x.' ');
?>
					</td>
				</tr>
				</table>
				</td></tr>
			</table>
		</div>
		
		<div class="edit">
			<table class="hite" border="0" bordercolor="#D9D9D9" cellspacing="0" cellpadding="2">
				<tr>
					<th class="editheader" style="text-transform:capitalize" align="left" nowrap><b><?= $trans['t_title']?></b></th>
				</tr><tr>
					<td height="99%" bgcolor="#D9D9D9" valign="top">
					<table class="wide" align="center" valign="top" border="0" cellspacing="0" cellpadding="1">
						<tr>
							<td style="text-transform:capitalize" nowrap><?= $trans['t_original']?>&nbsp;<b><?= $trans['t_title']?></b></td>
						</tr><tr>
							<td><input class="objwide" style="margin:1px; background-color:#dee3cb;" value="<?= $title; ?>" name="title" size="30" type="text"></td>
						</tr><tr>
							<td style="text-transform:capitalize" nowrap><?= $trans['t_local']?>&nbsp;<b><?= $trans['t_title']?></b></td>
						</tr><tr>
							<td><input class="objwide" style="margin:1px; background-color:#dee3cb;" value="<?= $local; ?>" name="local" size="30" type="text"></td>
						</tr><tr>
							<td style="text-transform:capitalize" nowrap><?= $trans['t_alias']?>&nbsp;<b><?= $trans['t_title']?></b></td>
						</tr><tr>
							<td><textarea class="objwide" style="margin:1px; background-color:#dee3cb;" name="aka" wrap="soft" rows="4" cols="30"><?= $aka ?></textarea></td>
						</tr>
					</table></td>
				</tr>
			</table>
		</div>
		
		<div class="edit">
			<table class="hite" border="0" bordercolor="#D9D9D9" cellspacing="0" cellpadding="2">
				<tr>
					<th class="editheader" style="text-transform:capitalize" align="left" nowrap><b><?= $trans['t_comment']?></b></th>
				</tr><tr valign="top">
					<td height="99%" bgcolor="#D9D9D9" align="center"><textarea class="txtwide" style="margin:1px; background-color:#dee3cb;" name="comment" wrap="soft" rows="9" cols="30"><?= $comment ?></textarea></td>
				</tr>
			</table>
		</div>
	
		<div class="edit">
			<table class="hite" border="0" bordercolor="#D9D9D9" cellspacing="0" cellpadding="2">
				<tr>
					<th class="editheader" style="text-transform:capitalize" align="left" nowrap><b><?= $trans['t_filmposter'] ?></b> &nbsp; <span id="bytes" class="size"><?= imginfo($fid,$cfg['poster_path']); ?></span></th>
				</tr><tr>
					<td height="99%" bgcolor="#D9D9D9" align="center">
					<table class="wide" style="min-height:140px;" align="center" border="0" cellspacing="0" cellpadding="1">
						<tr><td rowspan="3" align="center">
							<a title="<?= $trans['show_imdbpage']?>" href="http://www.imdb.com/title/tt<?= $imdbid ?>" target="_blank"><img id="posterimg" alt="poster" src="imgget.php?for=<?= ($setposter!=false && $setposter!='') ? $imdbid.'&amp;from=session' : $fid; ?>" width="95" height="140" border="0"></a>
						</td><td rowspan="3">&#160;</td><td valign="middle" align="center">
							<button name="url_poster" type="button" value="URL" title="<?= $trans['b_upload']?>" style="cursor:pointer;" onClick="fill_Request('editreq');show_Request(true,'editreq','editposter.php?id=<?= $imdbid ?>');"><img style="margin: 0px" src="images/poster/url.png" alt="url-upload" width="32" height="32" border="0"></button>
						</td></tr>
						<tr><td valign="middle" align="center">
							<button name="upload_poster" type="button" value="Upload" title="<?= $trans['b_upload']?>" style="cursor:pointer;" onClick="fill_Request('editreq');show_Request(true,'editreq','importposter.php?id=<?= $imdbid ?>');"><img style="margin: 0px" src="images/poster/upload.png" alt="file-upload" width="32" height="32" border="0"></button>
						</td></tr>
						<tr><td valign="middle" align="center">
							<button name="clear_poster" type="button" value="Clear" title="<?= $trans['b_clear']?>" style="cursor:pointer;" onClick="fill_Request('editreq');show_Request(true,'editreq','resetposter.php?id=<?= $imdbid ?>');"><img style="margin: 0px" src="images/poster/clear.png" alt="clear" width="32" height="32" border="0"></button>
						</td></tr>
					</table>
					</td>
				</tr>
			</table>
		</div>
				
		<div class="edit">
			<table class="hite" border="0" bordercolor="#D9D9D9" cellspacing="0" cellpadding="2">
				<tr>
					<th class="editheader" style="text-transform:capitalize" align="left" nowrap><b><?= $trans['t_category'] ?></b></th>
				</tr><tr>
					<td height="99%" bgcolor="#D9D9D9" align="left" valign="top"><table class="wide" align="center" border="0" cellspacing="0" cellpadding="1">
<?
$i=0;
echo '<tr>';
foreach($cfg['genre'] as $x){
	if($i%3==0 && $i!=0){
		echo '</tr><tr>';
	}
	echo '<td nowrap><input style="background-color:#dee3cb;" type="checkbox" name="genre_array[]" value="'.$x.'"'.(in_array($x,$sgenre)?' checked="checked"':'').'>'.$x.'</td>';
	$i++;
}
while(1){
	$i++;
	if($i%3==0) break;
}
?>
					</tr></table></td>
				</tr>
			</table>
		</div>
		
		<div class="edit">
			<table class="hite" border="0" bordercolor="#D9D9D9" cellspacing="0" cellpadding="2">
				<tr>
					<th class="editheader" style="text-transform:capitalize" align="left" nowrap><b><?= $trans['t_filminfo'] ?></b></th>
				</tr><tr>
					<td height="99%" bgcolor="#D9D9D9" align="left" valign="top">
					<table class="wide" align="center" border="0" cellspacing="0" cellpadding="1">
						<tr>
							<td colspan="4" style="text-transform:capitalize" nowrap><b><?= $trans['t_countries']?></b>&nbsp;</td>
						</tr><tr>
							<td colspan="4"><input class="objwide" style="margin:1px; background-color:#dee3cb;" value="<?= $country; ?>" name="country" size="30" maxlength="255" type="text"></td>
						</tr><tr>
							<td align="right" valign="middle" style="text-transform:capitalize;" nowrap><b><?= $trans['t_year']?></b>&nbsp;</td>
							<td nowrap><input class="obj" value="<?= $year; ?>" name="year" style="background-color:#dee3cb; width:3em;" size="4" maxlength="4" type="text" onblur="set_value(this,this.value,1888,2222);"></td>
							<td align="right" valign="middle" style="text-transform:capitalize;" nowrap>&nbsp;<b><?= $trans['t_runtime']?></b>&nbsp;</td>
							<td nowrap><input class="obj" value="<?= $runtime; ?>" name="runtime" style="background-color:#dee3cb; width:2.5em;" size="3" maxlength="4" type="text" onblur="set_value(this,this.value,0,9999);">&nbsp;<?= $trans['t_minutes']?></td>
						</tr><tr>
							<td align="right" valign="middle" style="text-transform:capitalize" nowrap><b><?= $trans['t_number']?></b>&nbsp;</td>
							<td nowrap><input class="obj" name="cat" value="<?= $cat ?>" type="text" style="background-color:#dee3cb; width:1.5em;" size="1" maxlength="1"><input class="obj" name="nr" value="<?= $nr ?>" type="text" style="background-color:#dee3cb; width:3em;" size="4" maxlength="4" onblur="set_value(this,this.value,0,9999);"></td>
							<td align="right" valign="middle" nowrap>&nbsp;<b><a title="<?= $trans['show_imdbpage']?>" href="http://www.imdb.com/title/tt<?= $imdbid ?>" target="_blank"><?= $trans['t_imdb']?></a></b>&nbsp;</td>
							<td><input class="obj" value="<?= $imdbid; ?>" name="imdbid" style="background-color:#dee3cb; width:5em;" size="7" maxlength="8" type="text"></td>
						</tr><td colspan="4" height="8"> </td><tr>
							<td style="background-color:#ffe3db;text-transform:capitalize;" align="right" nowrap><input style="background-color:#dee3cb;" type="checkbox" name="test" onClick="set_avail(this.checked);"<? if($avail!='1'){ echo ' checked';} ?>><input type="hidden" name="avail" value="<?= $avail ?>"></td>
							<td style="background-color:#ffe3db;text-transform:capitalize;" valign="middle" colspan="2"><b><?= $trans['t_lent']?></b></td>
							<td valign="middle" style="text-transform:capitalize;">&nbsp;<b><?= $trans['t_rating']?></b></td>
						</tr><tr>
							<td style="background-color:#ffe3db;" align="right" valign="middle"><?= $trans['t_to']?>&nbsp;</td>
							<td style="background-color:#ffe3db;" colspan="2">
<select class="obj" name="lentto">
<? for($i=0; $i<sizeof($lenton); $i++){
	echo("<option value=\"$i\"".($lentto==$i?' selected="selected"':'').">$lenton[$i]</option>");
} ?>
</select></td><td>&nbsp;<input class="obj" value="<?= $rating; ?>" name="rating" style="background-color:#dee3cb; width:4em;" size="4" maxlength="2" type="text" onblur="set_value(this,this.value,1,99);"></td>
							
						</tr><tr>
							<td style="background-color:#ffe3db;" align="right" valign="middle"><?= $trans['t_at']?>&nbsp;</td>
							<td style="background-color:#ffe3db;" colspan="2"><input class="obj" style="margin-bottom:3px;" type="text" value="<?= $lentsince; ?>" size="10" maxlength="10" name="lentsince"></td>
							<td valign="middle">&nbsp;<?= $trans['x_of_x']?>&nbsp;100</td>
						</tr>
					</table></td>
				</tr>
			</table>
		</div>
		
		<div class="edit">
			<table class="hite" border="0" bordercolor="#D9D9D9" cellspacing="0" cellpadding="2">
				<tr>
					<th class="editheader" style="text-transform:capitalize" align="left" nowrap><b><?= $trans['t_director']?></b></th>
				</tr><tr>
					<td height="99%" bgcolor="#D9D9D9" valign="top"><table class="wide" align="center" border="0" cellspacing="1" cellpadding="0">
<? if(sizeof($director) == 0){ ?>
					<tr><td>
						<input type="hidden" value="" name="director[0][id]">
						<input class="objwide" style="background-color:#dee3cb;" size="30" value="" name="director[0][name]" onchange="if(this.value!='') getperson('cat=director&amp;idx=0&amp;name='+this.value);" type="text">
					</td></tr>
<? } ?>
<? for($i=0; $i<sizeof($director); $i++){ ?>
					<tr><td>
						<input type="hidden" value="<?= $director[$i]['id'] ?>" name="director[<?=$i?>][id]">
						<input class="objwide" style="background-color:#dee3cb;" size="30" value="<?= $director[$i]['name'] ?>" name="director[<?=$i?>][name]" onchange="if(this.value!='') getperson('cat=director&amp;idx=<?=$i?>&amp;name='+this.value);" type="text">
					</td></tr>
<? } ?>
					</table></td>
				</tr>
			</table>
		</div>
		
		<div class="edit">
			<table class="hite" border="0" bordercolor="#D9D9D9" cellspacing="0" cellpadding="2">
				<tr>
					<th class="editheader" style="text-transform:capitalize" align="left" nowrap><b><?= $trans['t_writer']?></b></th>
				</tr><tr>
					<td height="99%" bgcolor="#D9D9D9" valign="top"><table class="wide" align="center" border="0" cellspacing="1" cellpadding="0">
<? if(sizeof($writer) == 0){ ?>
					<tr><td>
						<input type="hidden" value="" name="writer[0][id]">
						<input class="objwide" style="background-color:#dee3cb;" size="30" value="" name="writer[0][name]" onchange="if(this.value!='') getperson('cat=writer&amp;idx=0&amp;name='+this.value);" type="text">
					</td></tr>
<? } ?>
<? for($i=0; $i<sizeof($writer); $i++){ ?>
					<tr><td>
						<input type="hidden" value="<?= $writer[$i]['id'] ?>" name="writer[<?=$i?>][id]">
						<input class="objwide" style="background-color:#dee3cb;" size="30" value="<?= $writer[$i]['name'] ?>" name="writer[<?=$i?>][name]" onchange="if(this.value!='') getperson('cat=writer&amp;idx=<?=$i?>&amp;name='+this.value);" type="text">
					</td></tr>
<? } ?>
					</table></td>
				</tr>
			</table>
		</div>
		
		<div class="edit">
			<table class="hite" border="0" bordercolor="#D9D9D9" cellspacing="0" cellpadding="2">
				<tr>
					<th class="editheader" style="text-transform:capitalize" align="left" nowrap><b><?= $trans['t_actor']?></b></th>
				</tr><tr>
					<td height="99%" bgcolor="#D9D9D9" valign="top"><table class="wide" align="center" border="0" cellspacing="1" cellpadding="0">
<? if(sizeof($actor) == 0){ ?>
					<tr><td>
						<input type="hidden" value="" name="actor[0][id]">
						<input class="objwide" style="background-color:#dee3cb;" size="30" value="" name="actor[0][name]" onchange="if(this.value!='') getperson('cat=actor&amp;idx=0&amp;name='+this.value);" type="text">
					</td></tr>
<? } ?>
<? for($i=0; $i<sizeof($actor); $i++){ ?>
					<tr><td>
						<input type="hidden" value="<?= $actor[$i]['id'] ?>" name="actor[<?= $i?>][id]">
						<input class="objwide" style="background-color:#dee3cb;" size="30" value="<?= $actor[$i]['name'] ?>" name="actor[<?=$i?>][name]" onchange="if(this.value!='') getperson('cat=actor&amp;idx=<?=$i?>&amp;name='+this.value);" type="text">
					</td></tr>
<? } ?>
					</table></td>
				</tr>
			</table>
			<p><br></p>
		</div>
		
		</form>
		<br clear="all"><br>
		<div id="panel">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
<? if($b_delete!=''){ ?>
				<tr><td class="obj" align="left">
						<button name="back" type="button" onClick="<?= $b_back;?>">&nbsp;<b><?= $trans['b_cancel'] ?></b>&nbsp;</button>
<? if($b_rescan!=''){ ?>		
				</td><td class="obj" width="100%" align="center">
						<button name="export" type="button" onClick="fill_Request('editreq');<?= @$b_export;?>">&nbsp;<b><?= @$trans['b_export'] ?></b>&nbsp;</button>&nbsp;&nbsp;&nbsp;&nbsp;
						<button name="rescan" type="button" onClick="fill_Request('editreq');<?= @$b_rescan;?>">&nbsp;<b><?= @$trans['b_rescan'] ?></b>&nbsp;</button>&nbsp;&nbsp;&nbsp;&nbsp;
						<button name="delete" type="button" onClick="fill_Request('editreq');<?= @$b_delete;?>">&nbsp;<b><?= @$trans['b_delete'] ?></b>&nbsp;</button>
<? } else { ?>
				</td><td class="obj" width="100%" align="center">
						<button name="delete" type="button" onClick="fill_Request('editreq');<?= @$b_delete;?>">&nbsp;<b><?= @$trans['b_delete'] ?></b>&nbsp;</button>
<? } ?>
				</td><td class="obj" align="right">
						<button name="save" type="button" onClick="fill_Request('editreq');<?= @$b_save;?>">&nbsp;<b><?= @$trans['b_update'] ?></b>&nbsp;</button>
				</td></tr>
<? } else { ?>
				<tr><td class="obj" align="left">
						<button name="cancel" type="button" onClick="<?= $b_cancel;?>">&nbsp;<b><?= @$trans['b_cancel'] ?></b>&nbsp;</button>
				</td><td class="obj" width="100%" align="center">
<? if($b_back!=''){ ?>
						<button name="back" type="button" onClick="<?= $b_back;?>">&nbsp;<b><?= @$trans['b_back'] ?></b>&nbsp;</button>
<? } ?>
				</td><td class="obj" align="right">
						<button name="save" type="button" onClick="fill_Request('editreq');<?= $b_save;?>">&nbsp;<b><?= $trans['b_insert'] ?></b>&nbsp;</button>
				</td></tr>
<? } ?>
		</table>
		</div>
	</body>
</html>
