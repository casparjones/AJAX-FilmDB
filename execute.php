<?php
/* FilmDB (based on php4flicks) */

/*	execute.php - display execution form. */

session_start();
if(!isset($_SESSION['user'])){
	if($_SESSION['user']!='admin') exit;
}

require('config/config.php');

if(isset($_GET['script'])){ 
	$script = $_GET['script']; 
	if(isset($_GET['info'])){
		$info 	= $trans[$_GET['info']]; 
	} else {
		die('error: no info');
	}
	if(isset($_GET['loop'])){
		$loop 	= $_GET['loop']; 
	} else {
		$loop 	= false;
	}	
	if($cfg['use_progress']==true&&$loop==true){ 
		$foo = ''; 
	}else { 
		$foo = "document.getElementById('bar').className='no_progress';";
	}
} else {
	die('error: no script');
}
?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/edit/k1.png" width="8" height="8" border="0"></td><td background="images/edit/k2.png"></td><td><img src="images/edit/k3.png" width="8" height="8" border="0"></td>
	</tr><tr>
		<td background="images/edit/k4.png"></td><td background="images/edit/k5.png" bgcolor="#dee3cb">
			<div ID="innereditreq">
			<form name="scriptname" action="admin/<?= $script ?>" target="uploadframe" method="POST">
			<table border="0" cellpadding="2" cellspacing="0">
				<tr><td valign="top" class="txt">
					<h2><b><nobr><?= $trans['work_in_progress']?></nobr></b></h2><br>
					<br><strong><?= $info ?><br></strong>
				</td></tr>
				<tr><td align="center" valign="bottom" class="txt">
					<small><br><span><b><span id="n_of_x">0</span></b>% <?= $trans['x_of_x']?> 100% <?= $trans['done']?></span></small><br>
					<div id="bar" class="progress"><img id="g_of_x" align="left" style="margin:0; padding:0;" src="images/progress_fg.gif" width="0" height="16" border="0"></div>
					<span id="done_t" style="display:none;"><small><?= $trans['done_alert']?></small></span>
				</td></tr>
				<tr><td valign="top" class="txt">
					<span id="log_it"><input type="checkbox" name="log" value="true"><small>&#160;<?= $trans['save_log']?></small></span>
					<input type="hidden" id="first_time" name="first_time" value="1">
					<iframe id="uploadframe" name="uploadframe" src=""></iframe>
				</td></tr>
			</table>
			</form></div>
		</td><td background="images/edit/k6.png"></td>
	</tr><tr>
		<td><img src="images/edit/k7.png" width="8" height="8" border="0"></td><td background="images/edit/k8.png"></td><td><img src="images/edit/k9.png" width="8" height="8" border="0"></td>
	</tr>
</table>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr><td id="cancel_b" align="left">
		<button name="cancel" type="button" value="Cancel" onClick="showRequest(false,'editreq','');">&nbsp;<b><?= $trans['b_cancel']?></b>&nbsp;</button>
	</td><td width="50%">&#160;</td><td align="center">
		<button id="stop_b" name="ok" style="display:none;" type="button" value="OK" style="cursor:pointer;" onClick="document.remember.submit();showRequest(false,'editreq','');">&nbsp;&nbsp;<b><?= $trans['b_ok']?></b>&nbsp;&nbsp;</button>
	</td><td width="50%">&#160;</td><td id="execute_b" align="right">
		<button name="execute" type="button" value="Execute" onClick="<?= $foo ?>document.getElementById('log_it').style.display='none';document.getElementById('cancel_b').style.display='none';document.scriptname.submit();document.getElementById('execute_b').style.display='none';">&nbsp;<b><?= $trans['b_start']?></b>&nbsp;</button>
	</td></tr>
</table>