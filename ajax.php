<?php
/* FilmDB (based on php4flicks) */

// ajax.php

require_once('config/config.php');

$xxx = explode("-", mysql_get_server_info()); $mysql_version = $xxx[0];

if(function_exists('gd_info')){
	$xxx = gd_info(); $gd_version = $xxx["GD Version"];
}

$zlib_is = (@function_exists('gzcompress')&&@function_exists('gzinflate')?'is':'is not');

?>
<table border="0" cellpadding="0" cellspacing="0"><tr>
<td><img src="images/info/g1.png" width="6" height="6" border="0"></td><td background="images/info/g2.png"></td>
<td><img src="images/info/g3.png" width="6" height="6" border="0"></td></tr><tr>
<td background="images/info/g4.png"></td><td background="images/info/g5.png" bgcolor="#bdcaac">
<div ID="innereditreq">
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center" valign="top" class="txt">
			<img src="images/filmdb_small.png" alt="FilmDB" width="32" height="32" border="0">
		</td>
		<td width="20">&nbsp;&nbsp;&nbsp;</td>
		<td class="txt" align="left">
			<nobr><b>AJAX-FilmDB</b> is a practical example of an AJAX driven Program.</nobr>
			<br><nobr>Copyright (c) 2005-2010 by Christian Effenberger.</nobr>
		</td>
	</tr><tr><td colspan="2"><img src="images/space.gif" width="24" height="8" border="0"></td></tr><tr>
		<td align="center" valign="top" class="txt">
			<img src="images/sign/ajax.png" alt="AJAX" width="32" height="32" border="0">
		</td>
		<td width="20">&nbsp;&nbsp;&nbsp;</td>
		<td class="txt" align="left"><small>
			<b>Javascript implementation</b> of the XMLHTTPRequest-Object
			is based on the Informations at <a target="_blank" title="Apple Developer Connection" href="http://developer.apple.com/internet/webcontent/xmlhttpreq.html">Apple's Developer Connection Site</a>.
			<br><b>XMLHTTPRequest-Object</b> Browser support is a basic condition.
		</small></td>
	</tr><tr>
		<td align="center" valign="top" class="txt">
			<img src="images/sign/javascript.png" alt="JS" width="32" height="32" border="0">
		</td>
		<td width="20">&nbsp;&nbsp;&nbsp;</td>
		<td class="txt" align="left">
			<big><b>Javascript 1.5</b></big> Browser support is a basic condition.
		</td>
	</tr><tr>
		<td align="center" valign="top" class="txt">
			<img src="images/sign/css.png" alt="CSS" width="32" height="32" border="0">
		</td>
		<td width="20">&nbsp;&nbsp;&nbsp;</td>
		<td class="txt" align="left">
			<big><b>CSS 2.1</b></big> Browser support is a basic condition.
		</td>
	</tr><tr>
		<td align="center" valign="top" class="txt">
			<img src="images/sign/html.png" alt="HTML" width="32" height="32" border="0">
		</td>
		<td width="20">&nbsp;&nbsp;&nbsp;</td>
		<td class="txt" align="left">
			<big><b>HTML 4.x</b></big> Browser support is a basic condition.
		</td>
	</tr><tr>
		<td align="center" valign="top" class="txt">
			<img src="images/sign/php.png" alt="PHP" width="32" height="32" border="0">
		</td>
		<td width="20">&nbsp;&nbsp;&nbsp;</td>
		<td class="txt" align="left">
			<big><b>PHP 4.3.x</b></big> Server support is a basic condition.<br>
			<small><b>PHP</b> <strong><?= phpversion() ?></strong> is the current running version.<br>
<?php if(function_exists('gd_info')) {?>
			<b>GD Library</b> <strong><?= $gd_version ?></strong> is installed.<br>
<?php }else {?>
			<b>GD Library</b> <strong>is not</strong> installed.<br>
<?php }?>
			<b>zlib Library</b> <strong><?= $zlib_is ?></strong> installed.<br>
			<b>Magic Quotes</b> is <strong><?= (get_magic_quotes_runtime()?'on':'off') ?></strong> <i>(should be off)</i>.<br> 
			<b>Save Mode</b> is <strong><?= (ini_get('safe_mode')?'on':'off') ?></strong> <i>(should be off)</i>.</small>
		</td>
	</tr><tr>
		<td align="center" valign="top" class="txt">
			<img src="images/sign/mysql.png" alt="MySQL" width="32" height="32" border="0">
		</td>
		<td width="20">&nbsp;&nbsp;&nbsp;</td>
		<td class="txt" align="left">
			<big><b>MySQL 4.x</b></big> Server support is a basic condition.<br>
			<small><b>MySQL</b> <strong><?= $mysql_version ?></strong> is the current running version.</small>
		</td>
	</tr>
</table>
</div>
</td><td background="images/info/g6.png"></td></tr><tr><td><img src="images/info/g7.png" width="6" height="6" border="0"></td>
<td background="images/info/g8.png"></td><td><img src="images/info/g9.png" width="6" height="6" border="0"></td>
</tr></table>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr><td align="center">
		<button name="ok" type="button" value="OK" style="cursor:pointer;" onClick="showRequest(false,'editreq','');">&nbsp;&nbsp;<b><?= $trans['b_ok']?></b>&nbsp;&nbsp;</button>
	</tr>
</table>
