<?php
/* FilmDB (based on php4flicks) */

// about.php

require_once('config/config.php');

?>
<table border="0" cellpadding="0" cellspacing="0"><tr>
<td><img src="images/info/g1.png" width="6" height="6" border="0"></td><td background="images/info/g2.png"></td>
<td><img src="images/info/g3.png" width="6" height="6" border="0"></td></tr><tr>
<td background="images/info/g4.png"></td><td background="images/info/g5.png" bgcolor="#bdcaac">
<div ID="innereditreq">
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center" valign="top" class="txt">
			<img src="images/filmdb.png" alt="filmdb" width="64" height="64" border="0"><br>
			<br><small><?= $trans['version']?></small>
			<br><b><?= $cfg['filmdb_version']?></b>
			<br><small><?= $cfg['filmdb_release']?></small>
		</td>
		<td width="20">&nbsp;&nbsp;&nbsp;</td>
		<td class="txt" align="left">
<nobr>Copyright (c) 2005-2010 by Christian Effenberger.</nobr><br>
<small><nobr>AJAX-FilmDB is distributed under the terms of the GNU GPL.<span class="mial"></span></nobr>
<br><br class="thiny">
<b>AJAX-FilmDB is based on php4flicks</b> (c) by 2003-2004 David Fuchs.
I've modified and extended the php4flicks code heavily.
<br><br class="thiny">
<b>IMDB fetch scripts</b> where taken from PowerMovieList.
Copyright (c) 1998-2003 by Niko. All Rights Reserved.
<br><br class="thiny">
<b>zip.lib 2.4</b> where taken from phpMyAdmin.
Copyright (c) 2004 by Eric Mueller and Denis125. All Rights Reserved.
<br><br class="thiny">
<b>unzip.lib 1.2</b> where taken from phpMyAdmin.
Copyright (c) 2003 by Holger Boskugel. All Rights Reserved.
<br><br class="thiny">
<b>Javascript tooltip implementation</b> "wz_tooltip.js" 3.38.
Copyright (c) 2002-2005 Walter Zorn. All rights reserved.
<br><br class="thiny">
<b>Javascript MD5 implementation</b> of the RSA Data Security, Inc.
MD5 Message-Digest Algorithm.
Copyright (c) 1996 by Henri Torgemane. All Rights Reserved.
<br><br class="thiny">
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.
<br><br class="thiny">
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
<a target="_blank" title="receive a copy of the GNU General Public License" href="http://www.gnu.org/copyleft/gpl.html">GNU General Public License</a> for more details.
</small>
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
