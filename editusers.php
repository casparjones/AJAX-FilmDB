<?php
/* FilmDB (based on php4flicks) */

// this is used for editing users file

session_start();
if(!isset($_SESSION['user'])){
	if($_SESSION['user']!='admin') exit;
}

require('config/config.php');

?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/edit/k1.png" width="8" height="8" border="0"></td><td background="images/edit/k2.png"></td><td><img src="images/edit/k3.png" width="8" height="8" border="0"></td>
	</tr><tr>
		<td background="images/edit/k4.png"></td><td background="images/edit/k5.png" bgcolor="#dee3cb">
			<div ID="innereditreq">
			<form name="data" action="javascript:ajaxpage('saveusers.php?' + getUsers(),'editreqsource');" method="GET">
			<table border="0" cellpadding="2" cellspacing="0">
				<tr><td colspan="2" valign="top" class="txt">
					<h2><b><?= $trans['t_edit_users']?>:</b></h2><br><small><br></small>
				</td></tr>
				<tr><td colspan="2" class="txt" nowrap>
					<select name="ul" size="8" style="min-width:180px; width:100%;" onclick="document.data.md5.value=this.options[this.selectedIndex].value;document.data.name.value=this.options[this.selectedIndex].text;document.data.id.value=this.selectedIndex;document.data.pass.value='********';">
<?
for($i=0; $i<sizeof($cfg['users']); $i++){
	if($i==0) {
		echo('<option value='.$cfg['users'][0]['md5pass'].' selected>admin</option>'."\n");
	} else {
		echo('<option value='.$cfg['users'][$i]['md5pass'].'>'.$cfg['users'][$i]['user'].'</option>'."\n");
	}
}
?>
					</select>
				</td></tr>
				<tr><td align="right">
					<b><?= $trans['log_user']?></b>&nbsp;
				</td><td class="txt">
					<input type="hidden" name="id" value="0">
					<input type="text" name="name" value="<?= $cfg['users'][0]['user']?>" size="14" maxlength="12" title="<?= $trans['edit_name']?>" onchange="if(document.data.id.value!=0){document.data.ul.options[document.data.id.value].text=this.value;}else{this.value='admin';}">
				</td></tr>
				<tr><td align="right">
					<b><?= $trans['log_pw']?></b>&nbsp;
				</td><td class="txt">
					<input type="hidden" name="md5" value="<?= $cfg['users'][0]['md5pass']?>">
					<input type="password" name="pass" value="********" size="14" maxlength="20" title="<?= $trans['edit_pass']?>" onchange="document.data.md5.value=MD5(this.value);document.data.ul.options[document.data.id.value].value=document.data.md5.value;">
				</td></tr>
				<tr><td align="left" class="txt">
					<button name="delete" type="button" value="Delete" onClick="delUser(document.data.ul.selectedIndex);">&nbsp;<b><?= $trans['b_delete']?></b>&nbsp;</button>
				</td><td width="80%" align="right" class="txt">
					<button name="add" type="button" value="Add" onClick="addUser();">&nbsp;<b><?= $trans['b_insert']?></b>&nbsp;</button>
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
		<button name="cancel" type="button" value="Cancel" onClick="showRequest(false,'editreq','');">&nbsp;<b><?= $trans['b_cancel']?></b>&nbsp;</button>
	</td><td align="right">
		<button name="save" type="button" value="Save" onClick="document.data.submit();">&nbsp;<b><?= $trans['b_save']?></b>&nbsp;</button>
	</td></tr>
</table>
