<?php
/* FilmDB (based on php4flicks) */

/* show_help.php - get online-help */

require_once('config/config.php');

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
       "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="<?= $conttype ?>">
		<title><?= $trans['page_title']?>:Help</title>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<meta name="robots" content="noindex">
		<meta http-equiv="Content-Script-Type" content="text/javascript">
		<script type="text/javascript" language="JavaScript">
		<!--
<?php
	echo '			in_progress="<h2><nobr><b>'.$trans['work_in_progress'].'</b></nobr></h2><br><table width=\"100%\" height=\"16\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td height=\"16\" width=\"100%\" background=\"images/progress.gif\"><img src=\"images/space.gif\" width=\"16\" height=\"16\" border=\"0\"></td></tr></table>";';
	echo '			att_pic="<img src=\"images/attention.png\" alt=\"attention\" width=\"20\" height=\"18\" border=\"0\">&nbsp;";'."\n";
	echo '			login ="<img src=\"images/button/login_off.png\" title=\"'.$trans['log_in'].'\" alt=\"login/out\" width=\"30\" height=\"24\" border=\"0\" name=\"log_in\" onClick=\"change(\'log_in\',\'login_off\');showRequest(att_pic + \''.$trans['alert_title'].$trans['help_alert'].'\',\'textreq\',\'\');\" onmouseover=\"change(\'log_in\',\'login_on\')\" onmouseout=\"change(\'log_in\',\'login_off\')\">";'."\n";
	echo '			add_no ="<img src=\"images/button/plus_off.png\" title=\"'.$trans['add_film'].'\" alt=\"add\" width=\"30\" height=\"24\" border=\"0\" name=\"plus_film\" onClick=\"change(\'plus_film\',\'plus_off\');showRequest(att_pic + \''.$trans['alert_title'].$trans['help_alert'].'\',\'textreq\',\'\');\" onmouseover=\"change(\'plus_film\',\'plus_on\')\" onmouseout=\"change(\'plus_film\',\'plus_off\')\">";'."\n";
	echo '			import_no ="<img src=\"images/button/import_off.png\" title=\"'.$trans['import_film'].'\" alt=\"import\" width=\"30\" height=\"24\" border=\"0\" name=\"import_film\" onClick=\"change(\'import_film\',\'import_off\');showRequest(att_pic + \''.$trans['alert_title'].$trans['help_alert'].'\',\'textreq\',\'\');\" onmouseover=\"change(\'import_film\',\'import_on\')\" onmouseout=\"change(\'import_film\',\'import_off\')\">";'."\n";
?>
			film_off = new Image(); film_off.src = 'images/button/film_off.png';
			row_off = new Image(); row_off.src = 'images/button/row_off.png';
			poster_off = new Image(); poster_off.src = 'images/button/poster_off.png';
			list_off = new Image(); list_off.src = 'images/button/list_off.png';
			list_on = new Image(); list_on.src = 'images/button/list_on.png';

			function display_LCD(f){
				var div = parent.window.document.getElementById('lcd');
				var txt = "<nobr><?= $trans['version'].'&nbsp;<b>'.$cfg['filmdb_version'].'</b>&nbsp;&bull;&nbsp;'.$cfg['filmdb_release']?></nobr>";
				if(f){
					div.innerHTML = f;
				} else {
					txt = "<nobr><?= $trans['user_mode'].':&nbsp;<b>'.$trans['help_mode'].'</b>' ?></nobr>";
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
				resets_view(); display_LCD();
				var add = parent.window.document.getElementById('plus_film');
				var imp = parent.window.document.getElementById('import_film');
				var log = parent.window.document.getElementById('log_inout');
				add.innerHTML = add_no;
				imp.innerHTML = import_no;
				log.innerHTML = login;
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
			function show_sub(){
				var contentDiv = document.getElementById('subnavig');
				if(contentDiv.style.display != 'inline'){
					contentDiv.style.display = 'inline';
					contentDiv.style.visibility = 'visible';
				} else {
					contentDiv.style.display = 'none';
					contentDiv.style.visibility = 'hidden';
				}
			}
			function close_sub(){
				var contentDiv = document.getElementById('subnavig');
				if(contentDiv.style.display == 'inline'){
					contentDiv.style.display = 'none';
					contentDiv.style.visibility = 'hidden';
				}
			}
		-->
		</script>
		<meta http-equiv="Content-Style-Type" content="text/css">
		<link rel="stylesheet" type="text/css" href="config/<?php if(eregi('Win',$_SERVER['HTTP_USER_AGENT'])) { echo "win"; } else { echo "oos"; } ?>.css">
		<style type="text/css">
		<!--
<? if(isset($_COOKIE['prefs'])) { ?>
			html, body {
				font-size: <?= $cfg['fontsize'] ?>em;
				font-family:'<?= $cfg['fonttype'] ?>','Arial','Helvetica','sans-serif';
			}
<? } ?>
			body { margin: 0;}
			a { outline: none; text-decoration: none; font-weight: bold; color: #333333; }
			a:hover { text-decoration: none; font-weight: bold; color: #336699; cursor:pointer; }
			h1 { font-size:180%; color:#444; display:inline; }
			h1#item { font-size:160%; line-height:80%; color:#666; display:block; }
			h2 { font-size:160%; line-height:180%; color:#333; display:inline; }
			h2#item { font-size:140%; line-height:60%; color:#444; display:block; }
			h3 { font-size:140%; line-height:160%; color:#333; display:inline; }
			h4 { font-size:120%; line-height:140%; color:#333; display:inline; }
			h5 { font-size:100%; line-height:120%; color:#333; display:inline; }
			small { font-size:80%; }
			big { font-size:112%; }
			strong { color:#000000; }
			.mial { font-weight:bold; }
			.mial:before { content: " youcan[]gmx.net"; }
			.txt { font-size: 92%; }
			.green { color:#006600; }
			.blue { color:#000099; }
			.red { color:#990000; }
			.display {
				display:inline;
				font-size:11px; 
				width:160px;
				min-width:160px;
				height: auto;
				padding: 4px 8px 4px 8px;
				border-radius: 4px;
				-moz-border-radius: 4px;
				-khtml-border-radius: 4px;
				background-color: #bdcaac;
			}
			.tooltype { 
				border: solid 1px #B4BAC3;
				font-size: 10px;
				font-weight: bold;
				padding: 1px 4px 1px 4px;
				background-color: #FEFECA;
			}
			.button {
				border-width: 2px;
				border-color: lightgrey;
				border-style: outset;
				font-size: 10px;
				font-weight: bold;
				padding: 1px 8px 1px 8px;
				background-color: lightgrey;
			}
			#help_head {
				position: fixed;
				vertical-align: middle;
				padding: 0;
				margin: 0;
				top: 0px;
				left: 0px;
				width: 99%;
				height: 3em;
				min-height: 3em;
				border-radius: 8px 9px 9px 0px;
				-moz-border-radius: 8px 9px 9px 0px;
				-khtml-border-radius: 8px 9px 9px 0px;
				color: #333333;
				background-color: #bdcaac; /* dee3cb */
				opacity: 0.9;
				z-index: 4;
			}
			#help_navi {
				position: fixed;
				top: 3em;
				left: 0px;
				width: 8em;
				height: auto;
				min-height: 10em;
				border-radius: 0px 0px 9px 8px;
				-moz-border-radius: 0px 0px 9px 8px;
				-khtml-border-radius: 0px 0px 9px 8px;
				background-color: #bdcaac;
				opacity: 0.9;
				z-index: 4;
			}
			.colbox {
				width: 32px;
				height: 32px;
				margin: 0 1em 1em 0;
				border-radius: 8px;
				-moz-border-radius: 8px;
				-khtml-border-radius: 8px;
			}
			.foo {
				position: static;
				padding: 4px 16px 4px 10px;
				float: left;
			}
			#page {
				position: absolute;
				top: 4em;
				left: 9.7em;
				width: auto;
				height: auto;
				min-width: 24em;
				min-height: 16em;
				padding-right: 1em;
				color: #444444;
				background-color: transparent;
			}
			#navig {
				margin: 1em;
				color: #333333;
				font-size:100%;
				background-color: transparent;
			}
			#subnavig {
				display: none;
				visibility: hidden;
				font-size:86%;
				color: #333333;
				padding: 0;
				margin: 0;
			}
			#subnavig ul {
				list-style-type: disc;
				display: inline;
				color: red;
				padding: 0;
				margin: 0;
			}
			#subnavig li {
				padding: 0;
				margin: 0 0 0 1.4em;
			}
			#guru {
				position: fixed;
				top: 0;
				left: 0;
				padding: 4px;
				width: 99%;
				height: auto;
				text-align: center;
				background-color: black;
				z-index: 5;
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
			#printblock { }
			h1#print { display:none; }
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
	<body onload="set_LogButton();parent.window.ajaxhelp('help/<? if($cfg['language']=='de'){ echo 'de'; }else{ echo 'en'; }?>/print.php','page');">
		<noscript><div id="guru"><div><?= $trans['guru_noscript']?></div></div></noscript>
		<div id="help_head">
			<div class="foo">
				<img align="left" src="images/filmdb_small.png" alt="FilmDB" width="32" height="32" border="0">
				&nbsp;<b>AJAX-FilmDB</b><br><nobr><small>&nbsp;<?= $cfg['filmdb_version'].' ('.$cfg['filmdb_release'].')' ?></small></nobr>
			</div>
			<div class="foo">
				<h1><b><div id="titel"><?= $trans['prog_help'] ?></div></b></h1>
			</div>
		</div>
		<div id="help_navi">
			<div id="navig">
<? if($cfg['language']=='de') { ?>
				<a onClick="close_sub();document.getElementById('titel').innerHTML='Einf&uuml;hrung';parent.window.ajaxhelp('help/de/introduction.php','page');">Einf&uuml;hrung</a><br>
				<a onClick="close_sub();document.getElementById('titel').innerHTML='Konditionen';parent.window.ajaxhelp('help/de/conditions.php','page');">Konditionen</a><br>
				<a onClick="close_sub();document.getElementById('titel').innerHTML='Installation';parent.window.ajaxhelp('help/de/installation.php','page');">Installation</a><br>
				<a onClick="show_sub();document.getElementById('titel').innerHTML='Bedienung';parent.window.ajaxhelp('help/de/handling.php','page');">Bedienung...</a><br>
				<div id="subnavig"><ul>
					<li><a onClick="document.getElementById('titel').innerHTML='Bedienung / Ansicht';parent.window.ajaxhelp('help/de/views.php','page');">Ansicht</a></li>
					<li><a onClick="document.getElementById('titel').innerHTML='Bedienung / Infos';parent.window.ajaxhelp('help/de/infos.php','page');">Infos</a></li>
					<li><a onClick="document.getElementById('titel').innerHTML='Bedienung / Display';parent.window.ajaxhelp('help/de/display.php','page');">Display</a></li>
					<li><a onClick="document.getElementById('titel').innerHTML='Bedienung / Kn&ouml;pfe';parent.window.ajaxhelp('help/de/buttons.php','page');">Kn&ouml;pfe</a></li>
					<li><a onClick="document.getElementById('titel').innerHTML='Bedienung / Sortiere';parent.window.ajaxhelp('help/de/filter.php','page');">Sortiere</a></li>
					<li><a onClick="document.getElementById('titel').innerHTML='Bedienung / Anzeige';parent.window.ajaxhelp('help/de/navigate.php','page');">Anzeige</a></li>
					<li><a onClick="document.getElementById('titel').innerHTML='Bedienung / Suche';parent.window.ajaxhelp('help/de/search.php','page');">Suche</a></li>
					<li><a onClick="document.getElementById('titel').innerHTML='Bedienung / Auswahl';parent.window.ajaxhelp('help/de/selection.php','page');">Auswahl</a></li>
					<li><a onClick="document.getElementById('titel').innerHTML='Bedienung / Bearbeiten';parent.window.ajaxhelp('help/de/edit.php','page');">Bearbeiten</a></li>
					<li><a onClick="document.getElementById('titel').innerHTML='Bedienung / Admin';parent.window.ajaxhelp('help/de/admin.php','page');">Admin</a></li>
				</ul></div>
				<a onClick="close_sub();document.getElementById('titel').innerHTML='Probleme';parent.window.ajaxhelp('help/de/problems.php','page');">Probleme</a><br>
				<a onClick="close_sub();document.getElementById('titel').innerHTML='Copyrights';parent.window.ajaxhelp('help/en/copyright.php','page');">Copyrights</a><br>
				<a onClick="close_sub();document.getElementById('titel').innerHTML='Lizens';parent.window.ajaxhelp('help/en/license.php','page');">Lizens</a><br>
				<a onClick="close_sub();document.getElementById('titel').innerHTML='API(s)';parent.window.ajaxhelp('help/de/api.php','page');">API(s)</a><br>
<? } else { ?>
				<a onClick="close_sub();document.getElementById('titel').innerHTML='Introduction';parent.window.ajaxhelp('help/en/introduction.php','page');">Introduction</a><br>
				<a onClick="close_sub();document.getElementById('titel').innerHTML='Conditions';parent.window.ajaxhelp('help/en/conditions.php','page');">Conditions</a><br>
				<a onClick="close_sub();document.getElementById('titel').innerHTML='Installation';parent.window.ajaxhelp('help/en/installation.php','page');">Installation</a><br>
				<a onClick="show_sub();document.getElementById('titel').innerHTML='Handling';parent.window.ajaxhelp('help/en/handling.php','page');">Handling...</a><br>
				<div id="subnavig"><ul>
					<li><a onClick="document.getElementById('titel').innerHTML='Handling / Views';parent.window.ajaxhelp('help/en/views.php','page');">Views</a></li>
					<li><a onClick="document.getElementById('titel').innerHTML='Handling / Infos';parent.window.ajaxhelp('help/en/infos.php','page');">Infos</a></li>
					<li><a onClick="document.getElementById('titel').innerHTML='Handling / Display';parent.window.ajaxhelp('help/en/display.php','page');">Display</a></li>
					<li><a onClick="document.getElementById('titel').innerHTML='Handling / Buttons';parent.window.ajaxhelp('help/en/buttons.php','page');">Buttons</a></li>
					<li><a onClick="document.getElementById('titel').innerHTML='Handling / Sort';parent.window.ajaxhelp('help/en/filter.php','page');">Sort</a></li>
					<li><a onClick="document.getElementById('titel').innerHTML='Handling / Navigate';parent.window.ajaxhelp('help/en/navigate.php','page');">Navigate</a></li>
					<li><a onClick="document.getElementById('titel').innerHTML='Handling / Search';parent.window.ajaxhelp('help/en/search.php','page');">Search</a></li>
					<li><a onClick="document.getElementById('titel').innerHTML='Handling / Select';parent.window.ajaxhelp('help/en/selection.php','page');">Select</a></li>
					<li><a onClick="document.getElementById('titel').innerHTML='Handling / Edit';parent.window.ajaxhelp('help/en/edit.php','page');">Edit</a></li>
					<li><a onClick="document.getElementById('titel').innerHTML='Handling / Admin';parent.window.ajaxhelp('help/en/admin.php','page');">Admin</a></li>
				</ul></div>
				<a onClick="close_sub();document.getElementById('titel').innerHTML='Problems';parent.window.ajaxhelp('help/en/problems.php','page');">Problems</a><br>
				<a onClick="close_sub();document.getElementById('titel').innerHTML='Copyrights';parent.window.ajaxhelp('help/en/copyright.php','page');">Copyrights</a><br>
				<a onClick="close_sub();document.getElementById('titel').innerHTML='License';parent.window.ajaxhelp('help/en/license.php','page');">License</a><br>
				<a onClick="close_sub();document.getElementById('titel').innerHTML='API(s)';parent.window.ajaxhelp('help/en/api.php','page');">API(s)</a><br>
<? } ?>
			</div>
		</div>
		<div id="page">
		</div>
	</body>
</html>
