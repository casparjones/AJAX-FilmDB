<?php
/* FilmDB (based on php4flicks) */

// askprint.php - ask for printing

require('config/config.php');

$title = $trans['page_title'].':List';
$info = $trans['print_info'].$trans['print_hint'];
if(isset($_GET["title"])){
	$title = $_GET["title"];
	if($title==$trans['page_title'].':Help'){
		$info = $trans['print_help'].$trans['print_hint'];	
	}	
}

?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/edit/k1.png" width="8" height="8" border="0"></td><td background="images/edit/k2.png"></td><td><img src="images/edit/k3.png" width="8" height="8" border="0"></td>
	</tr><tr>
		<td background="images/edit/k4.png"></td><td background="images/edit/k5.png" bgcolor="#dee3cb">
			<div ID="innereditreq"><span class="txt"><h2><b><?= $trans['print_title']?>:</b></h2></span><br><br><?= $info ?></div>
		</td><td background="images/edit/k6.png"></td>
	</tr><tr>
		<td><img src="images/edit/k7.png" width="8" height="8" border="0"></td><td background="images/edit/k8.png"></td><td><img src="images/edit/k9.png" width="8" height="8" border="0"></td>
	</tr>
</table>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr><td align="left">
		<button name="cancel" type="button" value="Cancel" style="cursor:pointer;" onClick="showRequest(false,'editreq','');">&nbsp;<b><?= $trans['b_cancel']?></b>&nbsp;</button>
	</td><td>&nbsp;</td><td align="right">
		<a target="_blank" onClick="showRequest(false,'editreq','');print_page();"><button name="print" type="button" value="Print">&nbsp;<b><?= $trans['b_print']?></b>&nbsp;</button></a>
	</td></tr>
</table>
