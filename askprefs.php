<?php
/* FilmDB (based on php4flicks) */

// askprefs.php - ask for what to edit

session_start();

require('config/config.php');

if($cfg['autoheight']==true){
	$list_height = (isset($_GET['lh'])?($_GET['lh']-($cfg['fontsize']*48)):$cfg['listheight']);
}else {
	$list_height = ($cfg['listheight']-($cfg['fontsize']*48));
}

?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/edit/k1.png" width="8" height="8" border="0"></td><td background="images/edit/k2.png"></td><td><img src="images/edit/k3.png" width="8" height="8" border="0"></td>
	</tr><tr>
		<td background="images/edit/k4.png"></td><td background="images/edit/k5.png" bgcolor="#dee3cb">
<? if(isset($_SESSION['user']) && ($_SESSION['user']=='admin')) { ?>
			<div id="innereditreq" style="margin: 4px;"><span class="txt"><h2><b><?= $trans['prefs_title']?>:</b></h2></span><br>
				<div class="txt" style="margin-top: 0.5em; margin-bottom: 2px;"><?= $trans['admin_info'] ?><br></div>
				<div id="listarea" style="width:<?php if(eregi('Opera',$_SERVER['HTTP_USER_AGENT'])) { echo "270px"; }else { echo "auto"; } ?>; height: <?= $list_height ?>px;"> 
					<table width="100%" border="0" bordercolor="#D9D9D9" cellpadding="2" cellspacing="0">
						<tr class="row_0"><td width="90%" class="txt" style="cursor:pointer;"><a onClick="ajaxpage('editusers.php','editreqsource');" onmouseover="parent.window.status=' ';return true;"><?= $trans['l_edit_list']?></a></td><td>&#160;</td><td valign="top"><img src="images/config.png" alt="config" width="14" height="14" border="0"></td></tr>
						<tr class="row_1"><td width="90%" class="txt" style="cursor:pointer;"><a onClick="ajaxpage('editprefs.php','editreqsource');" onmouseover="parent.window.status=' ';return true;"><?= $trans['l_edit_config']?></a></td><td>&#160;</td><td valign="top"><img src="images/config.png" alt="config" width="14" height="14" border="0"></td></tr>
						<tr class="row_0"><td width="90%" class="txt" style="cursor:pointer;"><a onClick="ajaxpage('editconfig.php','editreqsource');" onmouseover="parent.window.status=' ';return true;"><?= $trans['l_edit_program']?></a></td><td>&#160;</td><td valign="top"><img src="images/config.png" alt="config" width="14" height="14" border="0"></td></tr>
						<tr class="row_1"><td width="90%" class="txt" style="cursor:pointer;"><a onClick="ajaxpage('editpeople.php','editreqsource');" onmouseover="parent.window.status=' ';return true;"><?= $trans['l_edit_borrower']?></a></td><td>&#160;</td><td valign="top"><img src="images/config.png" alt="config" width="14" height="14" border="0"></td></tr>
<? if($cfg['server_cmd']&&!ini_get('safe_mode')) { ?>
						<tr><td colspan="3" style="background-color: silver; height:2px; margin:0; padding:0;"> </td></tr>
						<tr class="row_0"><td width="90%" class="txt" style="cursor:pointer;"><a onClick="ajaxpage('execute.php?script=copy_b2f.php&info=b2f_copy','editreqsource');" onmouseover="parent.window.status=' ';return true;"><?= $trans['l_copy_b2f']?></a></td><td>&#160;</td><td valign="top"><img src="images/util.png" alt="util" width="14" height="14" border="0"></td></tr>
						<tr class="row_1"><td width="90%" class="txt" style="cursor:pointer;"><a onClick="ajaxpage('execute.php?script=copy_f2b.php&info=f2b_copy','editreqsource');" onmouseover="parent.window.status=' ';return true;"><?= $trans['l_copy_f2b']?></a></td><td>&#160;</td><td valign="top"><img src="images/util.png" alt="util" width="14" height="14" border="0"></td></tr>
						<tr class="row_0"><td width="90%" class="txt" style="cursor:pointer;"><a onClick="ajaxpage('execute.php?script=init_b2f.php&loop=true&info=b2f_info','editreqsource');" onmouseover="parent.window.status=' ';return true;"><?= $trans['l_blob2file']?></a></td><td>&#160;</td><td valign="top"><img src="images/tool.png" alt="tool" width="14" height="14" border="0"></td></tr>
						<tr class="row_1"><td width="90%" class="txt" style="cursor:pointer;"><a onClick="ajaxpage('execute.php?script=init_f2b.php&loop=true&info=f2b_info','editreqsource');" onmouseover="parent.window.status=' ';return true;"><?= $trans['l_file2blob']?></a></td><td>&#160;</td><td valign="top"><img src="images/tool.png" alt="tool" width="14" height="14" border="0"></td></tr>
						<tr class="row_0"><td width="90%" class="txt" style="cursor:pointer;"><a onClick="ajaxpage('execute.php?script=del_abdb.php&loop=true&info=blob_del','editreqsource');" onmouseover="parent.window.status=' ';return true;"><?= $trans['l_del_blobs']?></a></td><td>&#160;</td><td valign="top"><img src="images/delete.png" alt="delete" width="14" height="14" border="0"></td></tr>
						<tr class="row_1"><td width="90%" class="txt" style="cursor:pointer;"><a onClick="ajaxpage('execute.php?script=del_afos.php&loop=true&info=file_del','editreqsource');" onmouseover="parent.window.status=' ';return true;"><?= $trans['l_del_files']?></a></td><td>&#160;</td><td valign="top"><img src="images/delete.png" alt="delete" width="14" height="14" border="0"></td></tr>
<? } ?>
<? if($cfg['backup_cmd']&&@function_exists('gzcompress')) { ?>
						<tr><td colspan="3" style="background-color: silver; height:2px; margin:0; padding:0;"> </td></tr>
						<tr class="row_0"><td width="90%" class="txt" style="cursor:pointer;"><a onClick="ajaxpage('askfiles.php?script=bak_dbase.php&info=dbase','editreqsource');" onmouseover="parent.window.status=' ';return true;"><?= $trans['l_bak_dbase']?></a></td><td>&#160;</td><td valign="top"><img src="images/backup.png" alt="backup" width="14" height="14" border="0"></td></tr>
						<tr class="row_1"><td width="90%" class="txt" style="cursor:pointer;"><a onClick="ajaxpage('askfiles.php?script=bak_poster.php&info=posters','editreqsource');" onmouseover="parent.window.status=' ';return true;"><?= $trans['l_bak_poster']?></a></td><td>&#160;</td><td valign="top"><img src="images/backup.png" alt="backup" width="14" height="14" border="0"></td></tr>
<? } ?>
<? if($cfg['restore_cmd']&&@function_exists('gzinflate')&&!ini_get('safe_mode')) { ?>
						<tr><td colspan="3" style="background-color: silver; height:2px; margin:0; padding:0;"> </td></tr>
						<tr class="row_0"><td width="90%" class="txt" style="cursor:pointer;"><a onClick="ajaxpage('importfile.php?script=uploaddbase.php&info=select_dbase','editreqsource');" onmouseover="parent.window.status=' ';return true;"><?= $trans['l_res_dbase']?></a></td><td>&#160;</td><td valign="top"><img src="images/restore.png" alt="restore" width="14" height="14" border="0"></td></tr>
						<tr class="row_1"><td width="90%" class="txt" style="cursor:pointer;"><a onClick="ajaxpage('importfile.php?script=uploadposter.php&info=select_poster','editreqsource');" onmouseover="parent.window.status=' ';return true;"><?= $trans['l_res_poster']?></a></td><td>&#160;</td><td valign="top"><img src="images/restore.png" alt="restore" width="14" height="14" border="0"></td></tr>
<? } ?>						
					</table>
				</div>
<? }else { ?>
			<div id="innereditreq"><span class="txt"><h2><b><?= $trans['prefs_title']?>:</b></h2></span><br>
				<?= $trans['prefs_info'] ?>
<? } ?>
			</div>
		</td><td background="images/edit/k6.png"></td>
	</tr><tr>
		<td><img src="images/edit/k7.png" width="8" height="8" border="0"></td><td background="images/edit/k8.png"></td><td><img src="images/edit/k9.png" width="8" height="8" border="0"></td>
	</tr>
</table>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr><td align="left">
		<button name="cancel" type="button" value="Cancel" onClick="showRequest(false,'editreq','');">&nbsp;<b><?= $trans['b_cancel']?></b>&nbsp;</button>
<? if(isset($_SESSION['user']) && ($_SESSION['user']=='admin')) { ?>
	</td width="80%"><td>&nbsp;</td><td align="right">
		<button name="show_log" type="button" value="Log" onClick="ajaxpage('showlog.php?lh=<?= $list_height ?>','editreqsource');">&nbsp;<b><?= $trans['b_showlog']?></b>&nbsp;</button>
<? }else { ?>
	</td><td>&nbsp;</td><td width="80%" align="center">
		<button name="edit_prefs" type="button" value="Prefs" onClick="ajaxpage('editconfig.php','editreqsource');">&nbsp;<b><?= $trans['b_program']?></b>&nbsp;</button>
	</td><td>&nbsp;</td><td align="right">
		<button name="edit_lent" type="button" value="Lent" onClick="ajaxpage('editpeople.php','editreqsource');">&nbsp;<b><nobr><?= $trans['b_borrower']?></nobr></b>&nbsp;</button>
<? } ?>		
	</td></tr>
</table>
