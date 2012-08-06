<?php
/* FilmDB (based on php4flicks) */

// this script is called when the value of an actor, director, 
// or writer field in the filmform-form is changed.
// it automatically searches for matching names in the 
// imdb and enters the selected name in the form.
// fetch_person.php is used to do the searching.

require_once('imdb/fetch_person.php');
require_once('config/config.php');

	if($cfg['autoheight']==true){
		$list_height = (isset($_GET['lh'])?$_GET['lh']:$cfg['listheight']);
	}else {
		$list_height = $cfg['listheight'];
	}

	$FetchPerson = new fetch_person($cfg['actSearchLimit'],$cfg['actCats']);

	switch($_GET['cat']){
		case 'actor':
			$FetchPerson->cats = array('actors','actresses'); break;
		case 'director':
			$FetchPerson->cats = array('directors'); break;
		case 'writer':
			$FetchPerson->cats = array('writers'); break;
		default: 
			// default value is set in fetch_person.php and is ('Actor','Actress','Director','Writer')
			break;
	}

	$ret = $FetchPerson->DoSearch($out, $_GET['name']);
	// function doSearch(&$out, $SearchString, $EntryUrl) {
	// Where $FormUrl is for the search-again-form
	// and $EntryUrl the link for the found entries
	if($ret==PML_FETCH_SEARCHERROR) die('search-error');
	if($ret==PML_FETCH_SEARCHDONE){ 
	// search sucessfully done, the found items are displayed as links - now the user has to select one
	// display all persons: fetch_person generates a table with all found results, if >1 match found
?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/edit/k1.png" width="8" height="8" border="0"></td><td background="images/edit/k2.png"></td><td><img src="images/edit/k3.png" width="8" height="8" border="0"></td>
	</tr><tr>
		<td background="images/edit/k4.png"></td><td background="images/edit/k5.png" bgcolor="#dee3cb">
			<table height="<?= $list_height ?>" style="min-width:320px;" border="0" cellpadding="2" cellspacing="0">
				<tr><td valign="top" class="txt">
					<nobr><b><?= $trans['show_people']?></b></nobr>
				</td></tr>
				<tr>
					<td style="min-width:320px;"><div id="listarea" style="height:<?= $list_height ?>px;"><?= $out;?></div></td>
				</tr>
			</table>
		</td><td background="images/edit/k6.png"></td>
	</tr><tr>
		<td><img src="images/edit/k7.png" width="8" height="8" border="0"></td><td background="images/edit/k8.png"></td><td><img src="images/edit/k9.png" width="8" height="8" border="0"></td>
	</tr>
</table>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr><td align="center">
		<button name="cancel" type="button" value="Cancel" style="cursor:pointer;" onClick="showRequest(false,'editreq','');">&nbsp;<b><?= $trans['b_cancel']?></b>&nbsp;</button>
	</td></tr>
</table>
<form name="tmpvars">
	<input type="hidden" name="cat"  value="<?= $_GET['cat'] ?>">
	<input type="hidden" name="idx"  value="<?= $_GET['idx'] ?>">
</form>
<?	
	exit;
	}
	// or else $ret must be PML_FETCH_EXACTMATCH - a exact match was found, 
	// the user doesn't have to do anything more
	// so just enter the value in the form.
?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/edit/k1.png" width="8" height="8" border="0"></td><td background="images/edit/k2.png"></td><td><img src="images/edit/k3.png" width="8" height="8" border="0"></td>
	</tr><tr>
		<td background="images/edit/k4.png"></td><td background="images/edit/k5.png" bgcolor="#dee3cb">
			<table border="0" cellpadding="2" cellspacing="0">
				<tr><td valign="top" class="txt">
					<nobr><b><?= $trans['show_person']?></b></nobr>
				</td></tr>
			</table>
		</td><td background="images/edit/k6.png"></td>
	</tr><tr>
		<td><img src="images/edit/k7.png" width="8" height="8" border="0"></td><td background="images/edit/k8.png"></td><td><img src="images/edit/k9.png" width="8" height="8" border="0"></td>
	</tr>
</table>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr><td align="left">
		<button name="cancel" type="button" value="Cancel" style="cursor:pointer;" onClick="showRequest(false,'editreq','');">&nbsp;<b><?= $trans['b_cancel']?></b>&nbsp;</button>
	</td><td align="right">
		<button name="ok" type="button" value="OK" style="cursor:pointer;" onClick="setperson('<?= $FetchPerson->FetchID?>','<?= $FetchPerson->_actorName?>');">&nbsp;<b><?= $trans['b_ok']?></b>&nbsp;</button>
	</td></tr>
</table>
<form name="tmpvars">
	<input type="hidden" name="cat"  value="<?= $_GET['cat'] ?>">
	<input type="hidden" name="idx"  value="<?= $_GET['idx'] ?>">
</form>
