<?php
/* FilmDB (based on php4flicks) */

// this is used for updating films only

require_once('config/config.php');

session_start();

// allow title to be passed via GET or POST method
if(isset($_GET['title'])){
	$movietitle = $_GET['title'];
	if(isset($_GET['local'])){
		$movielocal = $_GET['local'];
	}
} else if(isset($_POST['title'])){
	$movietitle = $_POST['title'];
	if(isset($_POST['local'])){
		$movielocal = $_POST['local'];
	}
} else {
	die('error: no movie title');
}
?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/edit/k1.png" width="8" height="8" border="0"></td><td background="images/edit/k2.png"></td><td><img src="images/edit/k3.png" width="8" height="8" border="0"></td>
	</tr><tr>
		<td background="images/edit/k4.png"></td><td background="images/edit/k5.png" bgcolor="#dee3cb">
			<div ID="innereditreq"><?= $trans['the_movie'].'<nobr><h4><b>'.htmlentities($movielocal).'</b></h4></nobr><br><h5><i>'.htmlentities($movietitle).'</i></h5>'.$trans['updated_alert'] ?></div>
		</td><td background="images/edit/k6.png"></td>
	</tr><tr>
		<td><img src="images/edit/k7.png" width="8" height="8" border="0"></td><td background="images/edit/k8.png"></td><td><img src="images/edit/k9.png" width="8" height="8" border="0"></td>
	</tr>
</table>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr><td align="center">
		<button name="ok" type="button" value="OK" onClick="showRequest(false,'editreq','');"><b><?= $trans['b_ok']?></b></button>
	</td></tr>
</table>
