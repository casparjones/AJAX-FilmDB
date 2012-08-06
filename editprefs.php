<?php
/* FilmDB (based on php4flicks) */

// this is used for editing prefs file

session_start();
if(!isset($_SESSION['user'])){
	if($_SESSION['user']!='admin') exit;
} 

require('config/config.php');
require('config/prefs.php');

?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/edit/k1.png" width="8" height="8" border="0"></td><td background="images/edit/k2.png"></td><td><img src="images/edit/k3.png" width="8" height="8" border="0"></td>
	</tr><tr>
		<td background="images/edit/k4.png"></td><td background="images/edit/k5.png" bgcolor="#dee3cb">
			<div ID="innereditreq">
			<form name="data" action="javascript:ajaxpage('saveprefs.php?lang='+document.data.lang.options[document.data.lang.selectedIndex].value+'&nor='+document.data.nor.value+'&nop='+document.data.nop.value+'&noe='+document.data.noe.value+'&rlh='+document.data.rlh.value+'&upb='+document.data.upb.checked+'&ubi='+document.data.ubi.checked+'&nbt='+document.data.nbt.checked+'&npl='+document.data.npl.checked+'&obl='+document.data.obl.checked+'','editreqsource');" method="GET">
			<table border="0" cellpadding="2" cellspacing="0">
				<tr><td colspan="3" valign="top" class="txt">
					<h2><b><?= $trans['t_edit_prefs']?>:</b></h2><br><small><br></small>
				</td></tr>
				<tr><td colspan="2" align="right" class="txt" nowrap>
					<big><b><?= $trans['p_language']?></b></big>&nbsp;
				</td><td class="txt" nowrap>
					<select name="lang" size="1"><option value="en"<? if($cfg['language']=='en'){ echo ' selected';}?>><?= $trans['EN']?></option><option value="de"<? if($cfg['language']=='de'){ echo ' selected';}?>><?= $trans['DE']?></option><option value="nl"<? if($cfg['language']=='nl'){ echo ' selected';}?>><?= $trans['NL']?></option><option value="es"<? if($cfg['language']=='es'){ echo ' selected';}?>><?= $trans['ES']?></option><option value="it"<? if($cfg['language']=='it'){ echo ' selected';}?>><?= $trans['IT']?></option></select>
				</td></tr>
				<tr><td colspan="2" align="right" class="txt" nowrap>
					<big><b><?= $trans['row_view']?></b></big>&nbsp;
				</td><td class="txt" nowrap>
					<input type="text" size="4" name="nor" value="<?= $cfg['noofrows']?>" onblur="setvalue(this,this.value,2,32);">&nbsp;<?= $trans['p_visible']?>
				</td></tr>
				<tr><td colspan="2" align="right" class="txt" nowrap>
					<big><b><?= $trans['poster_view']?></b></big>&nbsp;
				</td><td class="txt" nowrap>
					<input type="text" size="4" name="nop" value="<?= $cfg['noofpics']?>" onblur="setvalue(this,this.value,10,96);">&nbsp;<?= $trans['p_visible']?>
				</td></tr>
				<tr><td colspan="2" align="right" class="txt" nowrap>
					<big><b><?= $trans['list_view']?></b></big>&nbsp;
				</td><td class="txt" nowrap>
					<input type="text" size="4" name="noe" value="<?= $cfg['noofentries']?>" onblur="setvalue(this,this.value,12,128);">&nbsp;<?= $trans['p_visible']?>
				</td></tr>
				<tr><td></td><td align="right" class="txt" nowrap>
					<big><b><?= $trans['list_height']?></b></big>&nbsp;
				</td><td class="txt" nowrap>
					<input type="text" size="4" name="rlh" value="<?= $cfg['listheight']?>" onblur="setvalue(this,this.value,160,400);">(px)&nbsp;<?= $trans['p_requester']?>
				</td></tr>
				<tr><td class="txt" valign=top">
					<input type="checkbox" name="upb" value="<?= $cfg['use_progress']?>"<? if($cfg['use_progress']=='true'){ echo ' checked';} ?>>
				</td><td colspan="2" class="txt">
					<?= $trans['use_progressbar']?>
				</td></tr>
				<tr><td class="txt" valign=top">
					<input type="checkbox" name="ubi" value="<?= $cfg['use_blob']?>"<? if($cfg['use_blob']=='true'){ echo ' checked';} ?>>
				</td><td colspan="2" class="txt">
					<?= $trans['use_blobposter']?>
				</td></tr>
				<tr><td class="txt" valign=top">
					<input type="checkbox" name="nbt" value="<?= $cfg['nobreaks']?>"<? if($cfg['nobreaks']=='true'){ echo ' checked';} ?>>
				</td><td colspan="2" class="txt">
					<?= $trans['no_wrapping']?>
				</td></tr>
				<tr><td class="txt" valign=top">
					<input type="checkbox" name="obl" value="<?= $cfg['original']?>"<? if($cfg['original']=='true'){ echo ' checked';} ?>>
				</td><td colspan="2" class="txt">
					<?= $trans['both_title']?>
				</td></tr>
				<tr><td class="txt" valign=top">
					<input type="checkbox" name="npl" value="<?= $cfg['noposter']?>"<? if($cfg['noposter']=='true'){ echo ' checked';} ?>>
				</td><td colspan="2" class="txt">
					<?= $trans['no_poster']?>
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
