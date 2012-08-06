<?php
/* FilmDB (based on php4flicks) */

// this is used for login only

require_once('config/config.php');

session_start();

if(!isset($_GET['action'])) $_GET['action'] = '';

switch($_GET['action']){
	case 'login':
	// username, password were submitted
	// check if username, pw are in user-array
	foreach($cfg['users'] as $u){  // strtolower() md5()
		if ($u['user'] == $_GET['user'] && $u['md5pass'] == $_GET['pass']){
			//username, pw ok!
			$_SESSION['user'] = $_GET['user'];
			break;
		}
	}
	if(isset($_SESSION['user'])){
		setcookie ("userpref", "1");
	} else {
		setcookie ("userpref", "0");
	}
	break; 

	default:
?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/edit/k1.png" width="8" height="8" border="0"></td><td background="images/edit/k2.png"></td><td><img src="images/edit/k3.png" width="8" height="8" border="0"></td>
	</tr><tr>
		<td background="images/edit/k4.png"></td><td background="images/edit/k5.png" bgcolor="#dee3cb">
			<div ID="innereditreq">
			<form name="data" action="javascript:get_user_pass(document.data.user.value,MD5(document.data.pass.value));" method="GET">
			<table border="0" cellpadding="2" cellspacing="0">
				<tr><td colspan="2" valign="top" class="txt">
					<h2><b><?= $trans['log_title']?>:</b></h2><br><br>
				</td></tr>
				<tr><td align="right" class="txt" nowrap>
					<big><b><?= $trans['log_user']?></b></big>&nbsp;
				</td><td class="txt">
					<input type="text" size="20" name="user" value="username">
				</td></tr>
				<tr><td align="right" class="txt" nowrap>
					<big><b><?= $trans['log_pw']?></b></big>&nbsp;
				</td><td class="txt">
					<input type="password" size="20" name="pass" value="password" onkeydown="submitenter(this,event);">
				</td></tr>
			</table>
			</form></div>
		</td><td background="images/edit/k6.png"></td>
	</tr><tr>
		<td><img src="images/edit/k7.png" width="8" height="8" border="0"></td><td background="images/edit/k8.png"></td><td><img src="images/edit/k9.png" width="8" height="8" border="0"></td>
	</tr>
</table>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr><td align="left">
		<button name="cancel" type="button" value="Cancel" style="cursor:pointer;" onClick="showRequest(false,'editreq','');"><b><?= $trans['b_cancel']?></b></button>
	</td><td align="right">
		<button name="ok" type="button" value="OK" style="cursor:pointer;" onClick="document.data.submit();">&nbsp;&nbsp;<b><?= $trans['b_ok']?></b>&nbsp;&nbsp;</button>
	</td></tr>
</table>
<? 
} // end switch