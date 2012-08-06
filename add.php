<?php
/* FilmDB (based on php4flicks) */

session_start();
// if(!isset($_SESSION['user'])){
// }

/*	add.php - display search form, get information from imdb and display it. 
	uses fetch_movie class. pml fetch class is used to fetch data from imdb. 
	available vars of doFetch():

	"Title",			string
	"Year",				int
	"Poster",			url
	"Director",			array of array(string'id',string'name')
	"Credits",			array of array(string'id',string'name')
	"Genre",			array of string
	"Rating",			int (real)
	"Starring",			array of array(string'id',string'name')
	"Plot",				string
	"Release",			date (1999-03-07)
	"Runtime",			int
	"imdbid",			string
	"aka",				string
	"Country"			string
*/

require_once('config/config.php');
require_once('imdb/fetch_movie.php');
require_once("imdbphp/imdb.class.php");
require_once("imdbphp/MyImdb.php");
require_once("imdbphp/pilot.class.php");
require_once("imdbphp/imdbMapper.class.php");

$FetchClass = new fetch_movie($cfg['searchLimit'],$cfg['actorLimit']);

if(!isset($_GET['action'])) $_GET['action']=''; //default-value 

switch($_GET['action']) {
	case '':
		// display form to enter movie title
?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/edit/k1.png" width="8" height="8" border="0"></td><td background="images/edit/k2.png"></td><td><img src="images/edit/k3.png" width="8" height="8" border="0"></td>
	</tr><tr>
		<td background="images/edit/k4.png"></td><td background="images/edit/k5.png" bgcolor="#dee3cb">
			<div ID="innereditreq">
		<form name="titleform" action="javascript:ajaxpage('add.php?title='+document.titleform.title.value+'&lh='+document.titleform.lh.value+'&action=search','editreqsource');fillRequest('editreq');" method="GET">
			<table border="0" cellpadding="2" cellspacing="0">
				<tr><td valign="top" class="txt" nowrap>
					<h2><b><?= $trans['add_title']?>:</b></h2><br><br>
					<strong><small><?= $trans['add_info']?><br></small></strong>
				</td></tr>
				<tr><td class="txt">
					<input onClick="get_listheight();" type="text" size="30" name="title" style="min-width:200px;">
					<input type="hidden" name="action" value="search">
					<input type="hidden" name="lh" value="<?= $cfg['listheight']?>">
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
		<button name="add" type="button" value="ADD" onClick="if(document.titleform.title.value==''){alert('<?= $trans['js_enter_title']?>');return false;}document.titleform.submit();">&nbsp;<b><?= $trans['b_search']?></b>&nbsp;</button>
	</td></tr>
</table>
<?
		break;

	case 'search':
		// search IMDB for movie title entered in form above!
		$temp = $_GET['title'];
		if($cfg['autoheight']==true){
			$list_height = (isset($_GET['lh'])?$_GET['lh']:$cfg['listheight']);
		}else {
			$list_height = $cfg['listheight'];
		}
		// $fp = fopen('debug.log',"a");
		// fwrite( $fp, $temp."\n" );
		// fclose( $fp );
		
		$ret = $FetchClass->DoSearch($out, $temp, "add.php?action=fetch"); 
		//function doSearch(&$out, $SearchString, $EntryUrl) {
		//Where $FormUrl is for the search-again-form
		//and $EntryUrl the link for the found entries
		if($ret==PML_FETCH_SEARCHERROR){
			die($trans['add_search_error'].'<br><button name="ok" type="button" value="OK" style="cursor:pointer;width:100%;text-align:center;" onClick="showRequest(false,'.'\'editreq\''.',true);">&nbsp;&nbsp;<b>OK</b>&nbsp;&nbsp;</button>');
		}
		//search sucessfully done, the found items are displayed as links 
		// now the user has to select one
		if(($ret==PML_FETCH_SEARCHDONE) || ($ret==PML_FETCH_EXACTMATCH)){
?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="images/edit/k1.png" width="8" height="8" border="0"></td><td background="images/edit/k2.png"></td><td><img src="images/edit/k3.png" width="8" height="8" border="0"></td>
	</tr><tr>
		<td background="images/edit/k4.png"></td><td background="images/edit/k5.png" bgcolor="#dee3cb">
			<form name="titleform" action="add.php" method="GET">
			<table height="<?= $list_height ?>" style="min-width:320px;" border="0" cellpadding="2" cellspacing="0">
				<tr><td valign="top" class="txt">
					<nobr><b><?= $trans['add_results']?></b></nobr>
				</td></tr>
				<tr>
					<td style="min-width:320px;"><div id="listarea" style="height:<?= $list_height ?>px;"><?= $out;?></div></td>
				</tr>
			</table>
			</form>
		</td><td background="images/edit/k6.png"></td>
	</tr><tr>
		<td><img src="images/edit/k7.png" width="8" height="8" border="0"></td><td background="images/edit/k8.png"></td><td><img src="images/edit/k9.png" width="8" height="8" border="0"></td>
	</tr>
</table>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr><td align="center">
		<button name="back" type="button" value="BACK" onClick="ajaxpage('add.php','editreqsource');">&nbsp;<b><?= $trans['b_back']?></b>&nbsp;</button>
	</tr>
</table>
<?
		break;
		}
		//or else $ret must be PML_FETCH_EXACTMATCH - a exact match was found, the user doesn't have to do anything more //continue fetching:

	case 'fetch':
		if($_GET["FetchID"]=='') die($trans['add_search_error'].'<br><button name="ok" type="button" value="OK" style="cursor:pointer;width:100%;text-align:center;" onClick="showRequest(false,'.'\'editreq\''.',true);">&nbsp;&nbsp;<b>OK</b>&nbsp;&nbsp;</button>');
		
		$movie = new MyImdb($_GET["FetchID"]);
        $pilot = new pilot($_GET["FetchID"]);
		$movie->setid($_GET["FetchID"]);
		$pilot->setid($_GET["FetchID"]);

        // $data['imdbid']   = $movie->metaScore();
		$data['imdbid']   = $movie->imdbid();
		$data['title']    = $movie->title();
        $data['local']    = $pilot->title();
		$data['year']     = $movie->year();
		$data['poster']   = $movie->photo(true);
		$data['director'] = $movie->director();
		$data['writer']   = $movie->writing();
		$data['runtime']  = $movie->runtime();
		$data['country']  = $movie->country();
		$data['rating']   = ($movie->rating() * 10);
		$data['actor']    = $movie->cast();
		$data['aka']      = $movie->alsoknow();
		$data['sgenre']   = $movie->genres();
		$data['comment']  = $pilot->plot();
		$data['slang']    = $movie->languages();
		
		extract($data);
		
		
		$country = array_pop($country);
		$comment = utf8_decode(array_pop($comment));
		$aka     = imdbMapper::mapAka($aka);
		
		// var_dump($aka, $data['aka']); die();
		
		$actor    = imdbMapper::mapActors($actor);
		$director = imdbMapper::mapActors($director);
		$writer   = imdbMapper::mapActors($writer);
		
		//poster
		if($poster){
			//fetch poster: (=>$_SESSION['image'][_movieid_])
			if (function_exists('gd_info')) {
				$ver = gd_info();
				preg_match('/\d/', $ver['GD Version'], $match);
				if ($match[0]>=2){
					include('fetchimggd.php');
				}else {
					include('fetchimg.php');
				}
			}else {
				include('fetchimg.php');
			}
			fetchimg($imdbid,$poster);
			$setposter = true;
		} else {
			$setposter = false;
		}

		$referer= 'add.php?';

		$b_back 	= "show_Request(true,'editreq',true);";
		$b_cancel 	= "parent.window.document.remember.submit();";
		$b_delete 	= "";
		$new_title =  rawurlencode($title); // str_replace("'",'',$title);
		$b_save 	= "document.data.action='insert.php';if(check()){document.data.submit();this.onclick='return false';show_Request(true,'editreq','insertfilm.php?title=".$new_title."');}";

		include('filmform.php');
		break;
		
	case 'reload':
		$reload = true;		//if this is set, filmform gets its data from POST array
		$referer= 'add.php?';

		$b_back 	= "parent.window.document.remember.submit();";
		$b_delete 	= "";
		$b_save 	= "document.data.action='update.php';if(check()){document.data.submit();this.onclick='return false';}";

		include('filmform.php');
	}
?>
