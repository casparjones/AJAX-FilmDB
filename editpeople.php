<?php
/* FilmDB (based on php4flicks) */

// this is used for editing people file

require('config/config.php');

?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/edit/k1.png" width="8" height="8" border="0"></td><td background="images/edit/k2.png"></td><td><img src="images/edit/k3.png" width="8" height="8" border="0"></td>
	</tr><tr>
		<td background="images/edit/k4.png"></td><td background="images/edit/k5.png" bgcolor="#dee3cb">
			<div ID="innereditreq">
			<form name="data" action="javascript:ajaxpage('savepeople.php?' + getPeople(),'editreqsource');" method="GET">
			<table border="0" cellpadding="2" cellspacing="0">
				<tr><td valign="top" class="txt">
					<h2><b><?= $trans['t_edit_people']?>:</b></h2><br><small><br></small>
				</td></tr>
				<tr><td class="txt" nowrap>
					<select name="pl" size="10" style="min-width:200px; width:100%;" onclick="document.data.edit.value=this.options[this.selectedIndex].text;document.data.id.value=this.selectedIndex;">
<?
for($i=1; $i<sizeof($lenton); $i++){
	if($i==1) {
		echo("<option value=\"$lenton[$i]\" selected>$lenton[$i]</option>"."\n");
	} else {
		echo("<option value=\"$lenton[$i]\">$lenton[$i]</option>"."\n");
	}
}
?>
					</select>
				</td></tr>
				<tr><td align="center" class="txt">
					<input type="hidden" name="id" value="0"><input type="text" name="edit" value="<?= $lenton[1]?>" size="20" maxlength="24" title="<?= $trans['edit_name']?>" style="width:200px;" onchange="document.data.pl.options[document.data.id.value].text=this.value;document.data.pl.options[document.data.id.value].value=this.value;"><br>
					<button name="add" type="button" value="Add" style="width:200px;" onClick="addPerson();">&nbsp;<b><?= $trans['b_add_person']?></b>&nbsp;</button>
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
