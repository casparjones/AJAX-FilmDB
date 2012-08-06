<?php
/* FilmDB (based on php4flicks) */

// this is used for editing cookie prefs

require('config/config.php');

if(!isset($cfg['fontsize'])) {
	$cfg['fontsize'] = 1;
}
if(!isset($cfg['fonttype'])) {
	$cfg['fonttype'] = 'Tahamo';
}
?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/edit/k1.png" width="8" height="8" border="0"></td><td background="images/edit/k2.png"></td><td><img src="images/edit/k3.png" width="8" height="8" border="0"></td>
	</tr><tr>
		<td background="images/edit/k4.png"></td><td background="images/edit/k5.png" bgcolor="#dee3cb">
			<div ID="innereditreq">
			<form name="data" action="javascript:ajaxpage('saveconfig.php?lang='+document.data.lang.options[document.data.lang.selectedIndex].value+'&ftt='+(document.data.ftt.value)+'&fsz='+(document.data.fsz.value/100)+'&nor='+document.data.nor.value+'&nop='+document.data.nop.value+'&noe='+document.data.noe.value+'&rlh='+document.data.rlh.value+'&nbt='+document.data.nbt.checked+'&npl='+document.data.npl.checked+'&obl='+document.data.obl.checked+'','editreqsource');" method="GET">
			<table border="0" cellpadding="2" cellspacing="0">
				<tr><td colspan="3" valign="top" class="txt">
					<h2><b><?= $trans['t_edit_prefs']?>:</b></h2><br><small><br></small>
				</td></tr>
				<tr><td colspan="2" align="right" class="txt" nowrap>
					<big><b><?= $trans['p_language']?></b></big>&nbsp;
				</td><td class="txt" align="left" nowrap>
					<select name="lang" size="1">
					<option value="en"<? if($cfg['language']=='en'){ echo ' selected';}?>><?= $trans['EN']?></option>
					<option value="de"<? if($cfg['language']=='de'){ echo ' selected';}?>><?= $trans['DE']?></option>
					<option value="es"<? if($cfg['language']=='es'){ echo ' selected';}?>><?= $trans['ES']?></option>
					<option value="nl"<? if($cfg['language']=='nl'){ echo ' selected';}?>><?= $trans['NL']?></option>
					<option value="it"<? if($cfg['language']=='it'){ echo ' selected';}?>><?= $trans['IT']?></option>
					</select>
				</td></tr>
				<tr><td colspan="2" align="right" class="txt" nowrap>
					<big><b><?= $trans['p_fonttype']?></b></big>&nbsp;
				</td><td class="txt" align="left" nowrap>
					<select name="ftt" size="1">
					<option style="font-family: arial, sans-serif;" value="Arial"<? if($cfg['fonttype']=='Arial'){ echo ' selected';}?>>Arial</option>
					<option style="font-family: 'comic sans ms', 'comic sans', sans-serif;" value="Comic Sans MS"<? if($cfg['fonttype']=='Comic Sans MS'){ echo ' selected';}?>>Comic Sans MS</option>
					<option style="font-family: georgia, serif;" value="Georgia"<? if($cfg['fonttype']=='Georgia'){ echo ' selected';}?>>Georgia</option>
					<option style="font-family: helvetica, sans-serif;" value="Helvetica"<? if($cfg['fonttype']=='Helvetica'){ echo ' selected';}?>>Helvetica</option>
					<option style="font-family: impact, sans-serif;" value="Impact"<? if($cfg['fonttype']=='Impact'){ echo ' selected';}?>>Impact</option>
					<option style="font-family: tahoma, sans-serif;" value="Tahoma"<? if($cfg['fonttype']=='Tahoma'){ echo ' selected';}?>>Tahoma</option>
					<option style="font-family: times, serif;" value="Times"<? if($cfg['fonttype']=='Times'){ echo ' selected';}?>>Times</option>
					<option style="font-family: 'times new roman', serif;" value="Times New Roman"<? if($cfg['fonttype']=='Times New Roman'){ echo ' selected';}?>>Times New Roman</option>
					<option style="font-family: 'trebuchet ms', trebuchet, sans-serif;" value="Trebuchet ms"<? if($cfg['fonttype']=='Trebuchet ms'){ echo ' selected';}?>>Trebuchet ms</option>
					<option style="font-family: verdana, sans-serif;" value="Verdana"<? if($cfg['fonttype']=='Verdana'){ echo ' selected';}?>>Verdana</option>
					</select>
				</td></tr>
				<tr><td colspan="2" align="right" class="txt" nowrap>
					<big><b><?= $trans['p_fontsize']?></b></big>&nbsp;
				</td><td class="txt" align="left" nowrap>
					<input type="text" size="4" name="fsz" value="<?= $cfg['fontsize']*100 ?>" onblur="setvalue(this,this.value,50,200);">%
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
					<big><b<? if($cfg['autoheight']==true){echo ' style="color:grey;"';} ?>><?= $trans['list_height']?></b></big>&nbsp;
				</td><td class="txt" nowrap>
					<input <? if($cfg['autoheight']==true){echo 'readonly';} ?> type="text" size="4" name="rlh" value="<?= $cfg['listheight']?>" onblur="setvalue(this,this.value,160,400);"><span<? if($cfg['autoheight']==true){echo ' style="color:grey;"';} ?>>(px)&nbsp;<?= $trans['p_requester']?></span>
				</td></tr>
				<tr><td class="txt" valign=top">
					<input type="checkbox" name="nbt" value="<?= $cfg['nobreaks']?>"<? if($cfg['nobreaks']=='true'){ echo ' checked';} ?>>
				</td><td colspan="2" align="left" class="txt">
					<?= $trans['no_wrapping']?>
				</td></tr>
				<tr><td class="txt" valign=top">
					<input type="checkbox" name="obl" value="<?= $cfg['original']?>"<? if($cfg['original']=='true'){ echo ' checked';} ?>>
				</td><td colspan="2" align="left" class="txt">
					<?= $trans['both_title']?>
				</td></tr>
				<tr><td class="txt" valign=top">
					<input type="checkbox" name="npl" value="<?= $cfg['noposter']?>"<? if($cfg['noposter']=='true'){ echo ' checked';} ?>>
				</td><td colspan="2" align="left" class="txt">
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
		<button name="save" type="button" value="Save" onClick="document.data.submit();">&nbsp;<b><?= $trans['b_save_cookie']?></b>&nbsp;</button>
	</td></tr>
</table>
