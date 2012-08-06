<?php
/* FilmDB (based on php4flicks) */

	// iphone.php -- display the newest movies for apples mobile phone
	
	require_once('../config/config.php');

	// columns to be listed
	$cols = ' DISTINCT CONCAT(cat,nr)as nr,movies.name,local,year,runtime,medium,movies.id,fid,container,disks,type,video,audio,lang,ratio,format,channel,herz,width,height,country,rating,avail,lentto,lentsince,inserted,aka,cat,genre,comment ';

	// check if user is logged in
	$loggedin = false; $loging = 0; $loguser = '';

	// default query (overwritten below if filter posted)
	$query = "SELECT SQL_CALC_FOUND_ROWS $cols FROM movies ";
		
	if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== FALSE) { 
		$bigdev = TRUE; 
	}else { 
		$bigdev = FALSE; 
	} 
		
	// if filter has been submitted, use it
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$via_GET = false; 
		// WHERE clause
		if(strlen($_POST['filter'])>0){
			// where clause was submitted
			// check if it is a select and not malicious SQL
			if(substr($_POST['filter'],0,38) != 'SELECT SQL_CALC_FOUND_ROWS _COLS_ FROM')
				die('don\'t try that.');
			$query = str_replace('_COLS_',$cols,$_POST['filter']);
		}
		// ORDER BY clause
		$sortsize = sizeof($_POST['sortby']);
		for($i=0; $i<$sortsize; $i++){
			$sortarray[$i] = $_POST['sortby'][$i];
			if($sortarray[$i]=='') break;
		}
		// fill rest of sort array with default values
		for($j=0; $j<$sortsize-$i; $j++){
			if(!isset($cfg['defaultsort'][$j])) break;
			$sortarray[$i] = $cfg['defaultsort'][$j];
			$i++;
		}
	}else {
		$via_GET = true; 
		
		$_POST['page'] = (isset($_GET['page'])?$_GET['page']:'0');
		$_POST['view'] = (isset($_GET['view'])?$_GET['view']:'poster');
		if(!isset($_GET['filtertitle'])) {
			$_POST['filtertitle']='*';
		} else if($_GET['filtertitle']=='!') {
			$_POST['filtertitle']='#';
		} else {
			$_POST['filtertitle']=$_GET['filtertitle'];
		}
		$_POST['filter'] = (isset($_GET['filter'])?$_GET['filter']:'');
		$_POST['sortby'][0] = (isset($_GET['sortby'][0])?$_GET['sortby'][0]:'inserted DESC');
		$_POST['sortby'][1] = (isset($_GET['sortby'][1])?$_GET['sortby'][1]:'nr ASC');
		$_POST['sortby'][2] = (isset($_GET['sortby'][2])?$_GET['sortby'][2]:'year ASC');
		$_POST['sorter'] = (isset($_GET['sorter'])?$_GET['sorter']:'inserted_DESC');
		$_POST['genres'] = (isset($_GET['genres'])?$_GET['genres']:'');
		$_POST['tosearch'] = (isset($_GET['tosearch'])?$_GET['tosearch']:'');
		$_POST['searchin'] = (isset($_GET['searchin'])?$_GET['searchin']:'movies.name,aka');
		
		if(strlen($_POST['filter'])>0){
			if(substr($_POST['filter'],0,38) != 'SELECT SQL_CALC_FOUND_ROWS _COLS_ FROM')
				die('don\'t try that.');
			$query = str_replace('_COLS_',$cols,$_POST['filter']);
		}
		if(sizeof($_POST['sortby'])>0){
			$sortsize = sizeof($_POST['sortby']);
			for($i=0; $i<$sortsize; $i++){
				$sortarray[$i] = $_POST['sortby'][$i];
				if($sortarray[$i]=='') break;
			}
			for($j=0; $j<$sortsize-$i; $j++){
				if(!isset($cfg['defaultsort'][$j])) break;
				$sortarray[$i] = $cfg['defaultsort'][$j];
				$i++;
			}
		} else {
			$sortarray = $cfg['defaultsort'];
		}
	}
	$sortsize = sizeof($sortarray);
	$sortby = implode($sortarray,',');
	$query .= " ORDER BY $sortby ";
	
	// LIMIT clause
	if(!isset($_POST['page']) || $_POST['page'] == '') {
		$_POST['page'] = '0';
	}
	if($_POST['view']=='film') {
		$noe = 1;
	}else {
		if($bigdev==TRUE) {
			$noe = 30;
		}else {
			$noe = 9;
		}
	}
	$cfg['mobileentries'] = $noe;
	$query .= ' LIMIT '.$_POST['page'].','.$noe;

	if(isset($_SESSION['user'])){
		if($_POST['filtertitle']=='#'){
			$now = '!';
		} else {
			$now = $_POST['filtertitle'];
		}
		$nil = 'page='.$_POST['page'].'&view='.$_POST['view'].'&genres='.$_POST['genres'].'&tosearch='.$_POST['tosearch'].'&searchin='.$_POST['searchin'].'&sorter='.$_POST['sorter'].'&sortby[0]='.$_POST['sortby'][0].'&sortby[1]='.$_POST['sortby'][1].'&sortby[2]='.$_POST['sortby'][2].'&filtertitle='.$now.'&filter='.rawurlencode($_POST['filter']);
		$_SESSION['tmpstr'] = $nil;
	}
	
	$result = mysql_query($query) or die(mysql_error());
	
	$rowresult = mysql_query('SELECT FOUND_ROWS()') or die(mysql_error());
	$row = mysql_fetch_row($rowresult);
	$rowcount = $row[0];
	
	function directorsearch(&$out, $movieid){
		$res = mysql_query("SELECT people.name FROM directs,people WHERE directs.movie_fid = $movieid AND directs.people_id = people.id;") or die(mysql_error());
		if($row = mysql_fetch_row($res)) // while
			($out ==''?$out .= $row[0] : $out .= ', '.$row[0]);
		return;
	}
	function getpeople(&$out,$table,$movieid,$text,$atr){
		$res = mysql_query("SELECT people.id,people.name FROM $table,people WHERE $table.movie_fid = $movieid AND $table.people_id = people.id ORDER BY people.id;") or die(mysql_error());
		while($row = mysql_fetch_row($res)){
			if($out != '') $out .= $atr;
			/* $out .= '<nobr><a title="'.$text.'" target="_blank" href="http://www.imdb.com/name/nm'.$row[0].'/">'.$row[1].'</a></nobr>'; */
			$out .= '<nobr><i>'.$row[1].'</i></nobr>';
		}
		return;
	}	
	function getcountry($val){
		if(!strpos($val,"/")){
			$str = $val;
		} else {
			$str = substr($val,0,strpos($val,"/"));
		}
		$len = strlen($str);
		if($len > 3){
			echo substr($str,0,3).'.';
		} else {
			echo $str;
		}
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
       "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="<?= $conttype ?>">
		<meta name="viewport" content="width=device-width, height=device-height, user-scalable=no, initial-scale=1; maximum-scale=1; minimum-scale=1;" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<link rel="apple-touch-icon" href="apple-touch-icon.png"/>
		<title><?= $trans['page_title']?></title>
		<link rel="stylesheet" media="screen" href="portrait<? echo ($bigdev==TRUE?'_big':'') ?>.css" type="text/css" />		
		<!-- link rel="stylesheet" media="only screen and (max-device-width: 1024px)" href="portrait_big.css" type="text/css" / -->		
		<script type="text/javascript" src="device.js"></script>
		<script type="text/javascript"><!-- --></script>
	</head>
	<body><div id="wrapper"><div id="view">
		<div id="header" class="ctrl"><span id="the_id" class="titles">FilmDB</span><div class="gradient"></div>
		<div onclick="openconf('conf');" class="butt pref"></div>
<? if($_POST['view']=='film') { ?>
			<div onclick="setposter(<?= $_POST['page'] ?>);" class="butt post"></div>		 		
<? }?>
		</div>
<? if($_POST['view']=='poster') { ?>
<? if($bigdev==TRUE) { /* iPad */ ?>
		<div class="shelf_row"><div class="row_shade trans_50"></div><div class="row_horizontal"></div>
			<div class="row_inner">
<? for($i=0; $i<5; $i++) {if($rowcount>$i&&$noe>$i) {$row=mysql_fetch_array($result); $ava=$row['avail']!='1'?'notavail':'avail'; if($row['id']!='') {?>
				<div id="p_<?= $i?>" onclick="setfilm(<?= $_POST['page']+$i ?>);" class="row_entry indicator">
					<img class="poster" src="../imgget.php?for=<?= $row['fid']?>" border="0" alt="" />
					<img class="<?= $ava ?>" src="images/na.png" border="0" alt="" />
					<span class="name">&nbsp;<? if(($_POST['sorter']=='name_ASC')||($_POST['sorter']=='name_DESC')){ echo $row['name']; }else{ echo $row['local']; }?></span>
				</div>
<? }}}?>
			</div>
		</div>
		<div class="shelf_row"><div class="row_shade trans_60"></div><div class="row_horizontal"></div>
			<div class="row_inner">
<? for($i=5; $i<10; $i++) {if($rowcount>$i&&$noe>$i) {$row=mysql_fetch_array($result); $ava=$row['avail']!='1'?'notavail':'avail'; if($row['id']!='') {?>
				<div id="p_<?= $i?>" onclick="setfilm(<?= $_POST['page']+$i ?>);" class="row_entry indicator">
					<img class="poster" src="../imgget.php?for=<?= $row['fid']?>" border="0" alt="" />
					<img class="<?= $ava ?>" src="images/na.png" border="0" alt="" />
					<span class="name">&nbsp;<? if(($_POST['sorter']=='name_ASC')||($_POST['sorter']=='name_DESC')){ echo $row['name']; }else{ echo $row['local']; }?></span>
				</div>
<? }}}?>
			</div>
		</div>
		<div class="shelf_row"><div class="row_shade trans_70"></div><div class="row_horizontal"></div>
			<div class="row_inner">
<? for($i=10; $i<15; $i++) {if($rowcount>$i&&$noe>$i) {$row=mysql_fetch_array($result); $ava=$row['avail']!='1'?'notavail':'avail'; if($row['id']!='') {?>
				<div id="p_<?= $i?>" onclick="setfilm(<?= $_POST['page']+$i ?>);" class="row_entry indicator">
					<img class="poster" src="../imgget.php?for=<?= $row['fid']?>" border="0" alt="" />
					<img class="<?= $ava ?>" src="images/na.png" border="0" alt="" />
					<span class="name">&nbsp;<? if(($_POST['sorter']=='name_ASC')||($_POST['sorter']=='name_DESC')){ echo $row['name']; }else{ echo $row['local']; }?></span>
				</div>
<? }}}?>
			</div>
		</div>
		<div class="shelf_row"><div class="row_shade trans_80"></div><div class="row_horizontal"></div>
			<div class="row_inner">
<? for($i=15; $i<20; $i++) {if($rowcount>$i&&$noe>$i) {$row=mysql_fetch_array($result); $ava=$row['avail']!='1'?'notavail':'avail'; if($row['id']!='') {?>
				<div id="p_<?= $i?>" onclick="setfilm(<?= $_POST['page']+$i ?>);" class="row_entry indicator">
					<img class="poster" src="../imgget.php?for=<?= $row['fid']?>" border="0" alt="" />
					<img class="<?= $ava ?>" src="images/na.png" border="0" alt="" />
					<span class="name">&nbsp;<? if(($_POST['sorter']=='name_ASC')||($_POST['sorter']=='name_DESC')){ echo $row['name']; }else{ echo $row['local']; }?></span>
				</div>
<? }}}?>
			</div>
		</div>
		<div class="shelf_row"><div class="row_shade trans_90"></div><div class="row_horizontal"></div>
			<div class="row_inner">
<? for($i=20; $i<25; $i++) {if($rowcount>$i&&$noe>$i) {$row=mysql_fetch_array($result); $ava=$row['avail']!='1'?'notavail':'avail'; if($row['id']!='') {?>
				<div id="p_<?= $i?>" onclick="setfilm(<?= $_POST['page']+$i ?>);" class="row_entry indicator">
					<img class="poster" src="../imgget.php?for=<?= $row['fid']?>" border="0" alt="" />
					<img class="<?= $ava ?>" src="images/na.png" border="0" alt="" />
					<span class="name">&nbsp;<? if(($_POST['sorter']=='name_ASC')||($_POST['sorter']=='name_DESC')){ echo $row['name']; }else{ echo $row['local']; }?></span>
				</div>
<? }}}?>
			</div>
		</div>
		<div class="shelf_row"><div class="row_shade trans_100"></div><div class="row_horizontal"></div>
			<div class="row_inner">
<? for($i=25; $i<30; $i++) {if($rowcount>$i&&$noe>$i) {$row=mysql_fetch_array($result); $ava=$row['avail']!='1'?'notavail':'avail'; if($row['id']!='') {?>
				<div id="p_<?= $i?>" onclick="setfilm(<?= $_POST['page']+$i ?>);" class="row_entry indicator">
					<img class="poster" src="../imgget.php?for=<?= $row['fid']?>" border="0" alt="" />
					<img class="<?= $ava ?>" src="images/na.png" border="0" alt="" />
					<span class="name">&nbsp;<? if(($_POST['sorter']=='name_ASC')||($_POST['sorter']=='name_DESC')){ echo $row['name']; }else{ echo $row['local']; }?></span>
				</div>
<? }}}?>
			</div>
		</div>
<? }else { /* iPhone */ ?>
		<div class="shelf_row white_top"><div class="row_shade trans_60"></div><div class="row_horizontal"></div>
			<div class="row_inner">
<? for($i=0; $i<3; $i++) {if($rowcount>$i&&$noe>$i) {$row=mysql_fetch_array($result); $ava=$row['avail']!='1'?'notavail':'avail'; if($row['id']!='') {?>
			<div id="p_<?= $i?>" onclick="setfilm(<?= $_POST['page']+$i ?>);" class="row_entry indicator">
				<img class="poster" src="../imgget.php?for=<?= $row['fid']?>" border="0" alt="" />
				<img class="<?= $ava ?>" src="images/na.png" border="0" alt="" />
				<span class="name">&nbsp;<? if(($_POST['sorter']=='name_ASC')||($_POST['sorter']=='name_DESC')){ echo $row['name']; }else{ echo $row['local']; }?></span>
			</div>
<? }}}?>
			</div>
		</div>
		<div class="shelf_row"><div class="row_shade trans_80"></div><div class="row_horizontal"></div>
			<div class="row_inner">
<? for($i=3; $i<6; $i++) {if($rowcount>$i&&$noe>$i) {$row=mysql_fetch_array($result); $ava=$row['avail']!='1'?'notavail':'avail'; if($row['id']!='') {?>
			<div id="p_<?= $i?>" onclick="setfilm(<?= $_POST['page']+$i ?>);" class="row_entry indicator">
				<img class="poster" src="../imgget.php?for=<?= $row['fid']?>" border="0" alt="" />
				<img class="<?= $ava ?>" src="images/na.png" border="0" alt="" />
				<span class="name">&nbsp;<? if(($_POST['sorter']=='name_ASC')||($_POST['sorter']=='name_DESC')){ echo $row['name']; }else{ echo $row['local']; }?></span>
			</div>
<? }}}?>
			</div>
		</div>
		<div class="shelf_row black_bottom"><div class="row_shade trans_100"></div><div class="row_horizontal"></div>
			<div class="row_inner">
<? for($i=6; $i<9; $i++) {if($rowcount>$i&&$noe>$i) {$row=mysql_fetch_array($result); $ava=$row['avail']!='1'?'notavail':'avail'; if($row['id']!='') {?>
			<div id="p_<?= $i?>" onclick="setfilm(<?= $_POST['page']+$i ?>);" class="row_entry indicator">
				<img class="poster" src="../imgget.php?for=<?= $row['fid']?>" border="0" alt="" />
				<img class="<?= $ava ?>" src="images/na.png" border="0" alt="" />
				<span class="name">&nbsp;<? if(($_POST['sorter']=='name_ASC')||($_POST['sorter']=='name_DESC')){ echo $row['name']; }else{ echo $row['local']; }?></span>
			</div>
<? }}}?>
			</div>
		</div>
<? } ?>
<? } else { ?>
		<div class="shelf_area">
<?
	$row = mysql_fetch_array($result);
?>
<script type="text/javascript" language="JavaScript">
<!--
<?
	echo 'var cur_id="'.$row['nr'].'";'."\n";
?>
-->
</script>
<?
	if($row) {
		$directors = ''; $actors = ''; $writers = ''; $tmp = $trans['show_imdbperson'];
		getpeople($directors,'directs',$row['fid'],$tmp,', ');
		getpeople($writers,'writes',$row['fid'],$tmp,', ');
		getpeople($actors,'plays_in',$row['fid'],$tmp,', ');
?>
			<div class="cover"><img class="bigger" src="../imgget.php?for=<?= $row['fid']?>" border="0" alt="" /></div>
			<div class="info_area">
				<span class="type"><?= $trans['t_medium']?></span>				
				<span class="data"><?= '<b>'.$row['disks'].'</b> x <b>'.$row['medium'].'</b> [<b>'.$row['type'].'</b>] (<b>'.$row['container'].'</b>)' ?></span>
				<span class="type"><?= $trans['t_video']?></span>
				<span class="data"><?= '<b>'.$row['video'].'</b> &bull; <b>'.$row['width'].'</b>x<b>'.$row['height'].'</b> &bull; <b>'.$row['format'].'</b> &bull; <b>'.$row['ratio'].'</b>'?></span>
				<span class="type"><?= $trans['t_audio']?></span>
				<span class="data"><?= '<b>'.$row['audio'].'</b> &bull; <b>'.$trans[$row['channel']].'</b> &bull; <b>'.$row['herz'].'</b> <small>KHz</small>' ?></span>
			</div>
			<div class="block_area">
				<span class="type"><?= $trans['t_original'].' '.$trans['t_title']?></span>
				<span class="data headline"><?= '<b>'.$row['name'].'</b>'?></span>
				<span class="type"><?= $trans['t_local'].' '.$trans['t_title']?></span>
				<span class="data headline"><?= '<i>'.$row['local'].'</i>'?></span>
<? if($row['aka']!='') { ?>
				<span class="type"><?= $trans['t_alias'].' '.$trans['t_title']?></span>
				<span class="data"><?= '<b>'.str_replace("\n",'</b> &bull; <b>',$row['aka']).'</b>'?></span>
<? } ?>												
<? if($row['avail']!='1') { ?>
				<span class="type"><?= $trans['t_lent']?></span>
				<span class="data"><?= $trans['t_to'].' "<b>'.$lenton[$row['lentto']].'</b>" '.$trans['t_at'].' '.substr($row['lentsince'], -2, 2).'-'.$trans[substr($row['lentsince'], 5, 2)].'-'.substr($row['lentsince'], 0, 4) ?></span>			
<? } ?>
<? if($bigdev==TRUE) { /* iPad */ ?>
				<span class="type"><?= $trans['t_date']?></span>
				<span class="data"><?= '<b>'.substr($row['inserted'], -2, 2).'</b>-<b>'.$trans[substr($row['inserted'], 5, 2)].'</b>-<b>'.substr($row['inserted'], 0, 4).'</b>' ?></span>
				<span class="type"><?= $trans['t_rating']?></span>
				<span class="data"><table style="display:inline-block;" height="15" border="0" cellspacing="0" cellpadding="0"><tr><td colspan="4" height="3"><img src="../images/space.gif" width="1" height="3" border="0" /></td></tr><tr><td width="4" height="15"><img src="../images/rank/left_r.png" alt="" width="4" height="15" border="0"></td><td width="100" height="15" background="../images/rank/grnd_r.png" nowrap><img src="../images/rank/fg_r.png" alt="" width="<?= $row['rating'] ?>" height="15" border="0"><img src="../images/space.gif" width="<?= 100-$row['rating'] ?>" height="15" border="0"></td><td width="4" height="15"><img src="../images/rank/right_r.png" alt=">" width="4" height="15" border="0"></td><td height="15" nowrap><small>&nbsp;<strong><?= $row['rating'] ?></strong>%</small></td></tr></table>&nbsp;</span>
				<span class="type"><?= $trans['t_country']?></span>
				<span class="data"><?= '<b>'.str_replace("\n",'</b>/<b>',$row['country']).'</b>' ?></span>
				<span class="type"><?= $trans['t_year']?></span>
				<span class="data"><?= '<b>'.$row['year'].'</b>' ?></span>
				<span class="type"><?= $trans['t_runtime']?></span>
				<span class="data"><?= '<b>'.$row['runtime'].'</b> '.$trans['t_minutes'].' [<b>'.sprintf("%02d",($row['runtime']/60)).':'.sprintf("%02d",($row['runtime']%60)).'</b>]' ?></span>
				<span class="type"><?= $trans['t_language']?></span>
				<span class="data"><? $l=explode(",",$row['lang']); for($x=0;$x<count($l);$x++){ echo '<img src="../images/flag/'.($l[$x]=="?"?"xx":strtolower($l[$x])).'.png" width="14" height="9" align="bottom" alt="" /> <small>'.$trans[$l[$x]].'</small> '; }?></span>
<? }else {  /* iPhone */ ?>	
				<span class="type"><?= $trans['t_date'].' &bull; '.$trans['t_rating']?></span>
				<span class="data"><?= '<b>'.substr($row['inserted'], -2, 2).'</b>-<b>'.$trans[substr($row['inserted'], 5, 2)].'</b>-<b>'.substr($row['inserted'], 0, 4).'</b>' ?> &bull; <table style="display:inline-block;" height="15" border="0" cellspacing="0" cellpadding="0"><tr><td colspan="4" height="3"><img src="../images/space.gif" width="1" height="3" border="0" /></td></tr><tr><td width="4" height="15"><img src="../images/rank/left_r.png" alt="" width="4" height="15" border="0"></td><td width="100" height="15" background="../images/rank/grnd_r.png" nowrap><img src="../images/rank/fg_r.png" alt="" width="<?= $row['rating'] ?>" height="15" border="0"><img src="../images/space.gif" width="<?= 100-$row['rating'] ?>" height="15" border="0"></td><td width="4" height="15"><img src="../images/rank/right_r.png" alt=">" width="4" height="15" border="0"></td><td height="15" nowrap><small>&nbsp;<strong><?= $row['rating'] ?></strong>%</small></td></tr></table></span>
				<span class="type"><?= $trans['t_country'].' &bull; '.$trans['t_year'].' &bull; '.$trans['t_runtime'].' &bull; '.$trans['t_language']?></span>
				<span class="data"><?= '<b>'.str_replace("\n",'</b>/<b>',$row['country']).'</b> &bull; <b>'.$row['year'].'</b> &bull; <b>'.$row['runtime'].'</b> '.$trans['t_minutes'].' [<b>'.sprintf("%02d",($row['runtime']/60)).':'.sprintf("%02d",($row['runtime']%60)).'</b>]' ?> &bull; <? $l=explode(",",$row['lang']); for($x=0;$x<count($l);$x++){ echo '<img src="../images/flag/'.($l[$x]=="?"?"xx":strtolower($l[$x])).'.png" width="14" height="9" align="bottom" alt="" /> <small>'.$trans[$l[$x]].'</small> '; }?></span>
<? } ?>					
				<span class="type"><?= $trans['t_category']?></span>
				<span class="data"><?= '<b>'.str_replace(",",'</b> &bull; <b>',$row['genre']).'</b>'?></span>
				<span class="type"><?= $trans['t_director']?></span>
				<span class="data"><?= $directors?></span>
				<span class="type"><?= $trans['t_writer']?></span>
				<span class="data"><?= $writers?></span>
				<span class="type"><?= $trans['t_actor']?></span>
				<span class="data"><?= $actors?></span>
<? if($row['comment']!='') { ?>
				<span class="type"><?= $trans['t_comment']?></span>
				<span class="data"><i><?= $row['comment']?></i></span>			
<? } ?>
			</div>
<? if($bigdev==TRUE) { /* iPad */ ?>
			<div class="type_area">
<? if($row['medium']=='Disk') { ?>
					<img src="../images/disk.png" alt="Disk" width="85" height="60" border="0" />
<? } else if($row['medium']=='Stick'){ ?>
					<img src="../images/stick.png" alt="Stick" width="85" height="50" border="0" />
<? } else if($row['medium']=='Card'){ ?>
					<img src="../images/card.png" alt="Card" width="85" height="60" border="0" />
<? } else if($row['medium']=='UMD'){ ?>
					<img src="../images/umd.png" alt="UMD" width="85" height="42" border="0" />
<? } else if($row['medium']=='BD'){ ?>
					<img src="../images/bd.png" alt="BD" width="85" height="42" border="0" />
<? } else if($row['medium']=='HD-DVD'){ ?>
					<img src="../images/hddvd.png" alt="HD-DVD" width="85" height="42" border="0" />
<? } else if($row['medium']=='VideoDVD' || $row['medium']=='ISO-DVD'){ ?>
					<img src="../images/dvd.png" alt="DVD" width="85" height="42" border="0" />
<? } else { ?>
					<img src="../images/cd.png" alt="CD" width="85" height="42" border="0" />
<? } ?>
			</div>
<? }}?>
		</div>
<? }?>
		<div id="footer" class="ctrl _fixed"><span class="titles">
<? if($rowcount==0) {echo '<b>0 - 0</b> / <b>0</b>';} else {echo '<b>'.($_POST['page']+1).'&ndash;'.($_POST['page']+min($noe,$rowcount-$_POST['page'])).'</b>&nbsp;&frasl;&nbsp;<b>'.$rowcount.'</b>';} ?>
		</span><div class="gradient"></div>
<? if($_POST['page']!='0'){ ?>
		<div onclick="setpage(0);" class="butt first"></div>
<? }else{ ?>
		<div class="butt first trans_25"></div>
<? } ?>
<? if($_POST['page']!='0'){if(((integer)$_POST['page'])<$noe){$tmp=0;}else{$tmp=((integer)$_POST['page'])-$noe;} ?>
		<div onclick="setpage(<?= $tmp ?>);" class="butt prev"></div>
<? }else{ ?>
		<div class="butt prev trans_25"></div>
<? } ?>
<? $tmp=((integer)$_POST['page'])+$noe; if($rowcount > $tmp){ ?>
		<div onclick="setpage(<?= $tmp ?>);" class="butt next"></div>
<? }else{ ?>
		<div class="butt next trans_25"></div>
<? } ?>
<? if($rowcount > $tmp){ $end = --$rowcount - (($rowcount) % $noe); ?>
		<div onclick="setpage(<?= $end ?>);" class="butt last"></div>
<? }else{ ?>
		<div class="butt last trans_25"></div>
<? } ?>
		</div>
	</div>	
	<div id="conf" style="visibility:hidden;">
		<form name="filterform" action="portrait.php" method="post">
		<div id="level_0" class="inner">
			<div class="button" onclick="closeconf('conf');"><?= $trans['b_back']?></div>
			<fieldset>
				<legend><?= $trans['select_by']?>...</legend>
				<ul>
					<li onclick="switchconf('level_1-1','level_0');" class="single"><?= $trans['t_category']?></li>
					<li id="selector" onclick="switchconf('level_1-2','level_0');" class="single" style="text-transform:capitalize;"><?= $trans['x_all']?></li>
				</ul>
			</fieldset>
			<fieldset>
				<legend><?= $trans['sort_to']?>...</legend>
				<ul>
					<li id="sorter" onclick="switchconf('level_2-1','level_0');" class="single">&darr; <?= $trans['t_since']?></li>
					<li class="check"><big>&uarr;</big> == <?= $trans['ascending']?> &nbsp; &nbsp; <big>&darr;</big> == <?= $trans['descending']?></li>
				</ul>
			</fieldset>
			<fieldset>
				<legend><?= $trans['search_at']?>...</legend>
				<ul>
					<li id="searchin" onclick="switchconf('level_3-1','level_0');" class="single"><?= $trans['o_all_title']?></li>
				</ul>
			</fieldset>
			<fieldset style="margin-top: -1px;">
				<legend><?= $trans['search_for']?>...</legend>
				<ul>
					<li class="search" style=""><input type="text" id="title" placeholder="..." value="<?= isset($_POST['tosearch'])?$_POST['tosearch']:''?>" onkeydown="submitenter(event);" /></li>
				</ul>
			</fieldset>
			<div class="button go" onclick="tfilter(document.filterform.title.value,document.filterform.searchin.value);">&#9664;</div>
		</div>	
		<div id="level_1-1" class="inner" style="display:none;">
			<div class="button" onclick="switchconf('level_0','level_1-1');"><?= $trans['b_back']?></div>
			<div class="special">
				<span><?= $trans['all_genres']?></span>
				<div class="action left_butt" onclick="checkGenres(true);"><?= $trans['link_on']?></div>
				<div class="action right_butt" onclick="checkGenres(false);"><?= $trans['link_off']?></div>
			</div>
			<fieldset>
				<legend><?= $trans['select_by']?>...</legend>
				<ul>
<?
				if(strlen($_POST['genres'])>0) { 
					$sgenre=explode(',',$_POST['genres']); $i=0;
					foreach($cfg['genre'] as $m) {
						echo '					<li onclick="switchCheckbox(this);" class="checkbox '.(in_array($m,$sgenre)?'selected':'unselected').'">'.$m.'<input type="checkbox" id="genres_'.$i.'" value="'.$m.'" '.(in_array($m,$sgenre)?'checked="checked"':'').' /></li>';
						$i++;
					}
				}else {$i=0;
					foreach($cfg['genre'] as $m) {
						echo '					<li onclick="switchCheckbox(this);" class="checkbox selected">'.$m.'<input type="checkbox" id="genres_'.$i.'" value="'.$m.'" checked="checked" /></li>';
						$i++;
					}
				}
?>
				</ul>
			</fieldset>
		</div>	
		<div id="level_1-2" class="inner" style="display:none;">
			<div class="button" onclick="switchconf('level_0','level_1-2');"><?= $trans['b_back']?></div>
			<fieldset>
				<legend><?= $trans['select_by']?>...</legend>
				<ul>
					<li onclick="selectby(this.id);showall();" id="sb_all" class="radio <?= ($_POST['filtertitle']=='*'?'selected':'unselected') ?>" style="text-transform:capitalize;"><?= $trans['x_all']?></li>
<? if($bigdev==TRUE) { /* iPad */ ?>
					<li onclick="selectby(this.id);tfilter('#');" id="sb_0-9" class="radio <?= ($_POST['filtertitle']=='#'?'selected':'unselected') ?>">0-9</li>
<?
					for($i=97; $i<123; $i++) {
						echo '					<li id="sb_'.chr($i).'" class="radio '.($_POST['filtertitle']==chr($i)?'selected':'unselected').'" onclick="selectby(this.id);tfilter(\''.chr($i).'\');" style="text-transform:uppercase;">'.chr($i).'</li>'."\n"; 
					}
?>
<? }else { /* iPhone */ ?>
<?
					for($i=97; $i<123; $i++) {/* 97 */
						echo '					<li id="sb_'.chr($i).'" class="radio w25 fl '.($_POST['filtertitle']==chr($i)?'selected':'unselected').'" onclick="selectby(this.id);tfilter(\''.chr($i).'\');" style="text-transform:uppercase;">'.chr($i).'</li>'."\n"; 
					}
?>
					<li onclick="selectby(this.id);tfilter('#');" id="sb_0-9" class="radio w50 <?= ($_POST['filtertitle']=='#'?'selected':'unselected') ?>">0-9</li>
					<li class="dummy"><span style="color:white;">...</span><div class="box"></div></li> 
<? }?>
				</ul>
			</fieldset>
		</div>	
		<div id="level_2-1" class="inner" style="display:none;">
			<div class="button" onclick="switchconf('level_0','level_2-1');"><?= $trans['b_back']?></div>
			<fieldset>
				<legend><?= $trans['sort_to']?>...</legend>
				<ul>
					<li onclick="sortby('nr_ASC')" id="nr_ASC" class="radio <?= ($_POST['sorter']=='nr_ASC'?'selected':'unselected') ?>">&uarr; ID</li>
					<li onclick="sortby('nr_DESC')" id="nr_ASC" class="radio <?= ($_POST['sorter']=='nr_DESC'?'selected':'unselected') ?>">&darr; ID</li>
					<li onclick="sortby('avail_ASC')" id="avail_ASC" class="radio <?= ($_POST['sorter']=='avail_ASC'?'selected':'unselected') ?>">&uarr; <?= $trans['o_avail']?></li>
					<li onclick="sortby('rating_ASC')" id="rating_ASC" class="radio <?= ($_POST['sorter']=='rating_ASC'?'selected':'unselected') ?>">&uarr; <?= $trans['t_rating']?></li>
					<li onclick="sortby('rating_DESC')" id="rating_DESC" class="radio <?= ($_POST['sorter']=='rating_DESC'?'selected':'unselected') ?>">&darr; <?= $trans['t_rating']?></li>
					<li onclick="sortby('name_ASC')" id="name_ASC" class="radio <?= ($_POST['sorter']=='name_ASC'?'selected':'unselected') ?>">&uarr; <?= $trans['t_title'].'&nbsp;'.$trans['t_original']?></li>
					<li onclick="sortby('name_DESC')" id="name_DESC" class="radio <?= ($_POST['sorter']=='name_DESC'?'selected':'unselected') ?>">&darr; <?= $trans['t_title'].'&nbsp;'.$trans['t_original']?></li>
					<li onclick="sortby('local_ASC')" id="local_ASC" class="radio <?= ($_POST['sorter']=='local_ASC'?'selected':'unselected') ?>">&uarr; <?= $trans['t_title'].'&nbsp;'.$trans['t_local']?></li>
					<li onclick="sortby('local_DESC')" id="local_DESC" class="radio <?= ($_POST['sorter']=='local_DESC'?'selected':'unselected') ?>">&darr; <?= $trans['t_title'].'&nbsp;'.$trans['t_local']?></li>
					<li onclick="sortby('year_ASC')" id="year_ASC" class="radio <?= ($_POST['sorter']=='year_ASC'?'selected':'unselected') ?>">&uarr; <?= $trans['t_year']?></li>
					<li onclick="sortby('year_DESC')" id="year_DESC" class="radio <?= ($_POST['sorter']=='year_DESC'?'selected':'unselected') ?>">&darr; <?= $trans['t_year']?></li>
					<li onclick="sortby('runtime_ASC')" id="runtime_ASC" class="radio <?= ($_POST['sorter']=='runtime_ASC'?'selected':'unselected') ?>">&uarr; <?= $trans['t_runtime']?></li>
					<li onclick="sortby('runtime_DESC')" id="runtime_DESC" class="radio <?= ($_POST['sorter']=='runtime_DESC'?'selected':'unselected') ?>">&darr; <?= $trans['t_runtime']?></li>
					<li onclick="sortby('medium_ASC')" id="medium_ASC" class="radio <?= ($_POST['sorter']=='medium_ASC'?'selected':'unselected') ?>">&uarr; <?= $trans['t_medium']?></li>
					<li onclick="sortby('medium_DESC')" id="medium_DESC" class="radio <?= ($_POST['sorter']=='medium_DESC'?'selected':'unselected') ?>">&darr; <?= $trans['t_medium']?></li>
					<li onclick="sortby('inserted_ASC')" id="inserted_ASC" class="radio <?= ($_POST['sorter']=='inserted_ASC'?'selected':'unselected') ?>">&uarr; <?= $trans['t_since']?></li>
					<li onclick="sortby('inserted_DESC')" id="inserted_DESC" class="radio <?= ($_POST['sorter']=='inserted_DESC'?'selected':'unselected') ?>">&darr; <?= $trans['t_since']?></li>
				</ul>
			</fieldset>
		</div>
		<div id="level_3-1" class="inner" style="display:none;">
			<div class="button" onclick="switchconf('level_0','level_3-1');"><?= $trans['b_back']?></div>
			<fieldset>
				<legend><?= $trans['search_at']?>...</legend>
				<ul>
					<li onclick="searchat('st_all','movies.name,aka')" id="st_all" class="radio <?= ($_POST['searchin']=='movies.name,aka'||$_POST['searchin']==''?'selected':'unselected') ?>"><?= $trans['o_all_title']?></li>
					<li onclick="searchat('st_name','name')" id="st_name" class="radio <?= ($_POST['searchin']=='name'?'selected':'unselected') ?>"><?= $trans['o_name']?></li>
					<li onclick="searchat('st_local','local')" id="st_local" class="radio <?= ($_POST['searchin']=='local'?'selected':'unselected') ?>"><?= $trans['o_local']?></li>
					<li onclick="searchat('st_directs','directs.movie_fid = movies.fid AND directs.people_id = people.id AND people.name')" id="st_directs" class="radio <?= ($_POST['searchin']=='directs.movie_fid = movies.fid AND directs.people_id = people.id AND people.name'?'selected':'unselected') ?>"><?= $trans['o_director']?></li>
					<li onclick="searchat('st_writes','writes.movie_fid = movies.fid AND writes.people_id = people.id AND people.name')" id="st_writes" class="radio <?= ($_POST['searchin']=='writes.movie_fid = movies.fid AND writes.people_id = people.id AND people.name'?'selected':'unselected') ?>"><?= $trans['o_writer']?></li>
					<li onclick="searchat('st_plays','plays_in.movie_fid = movies.fid AND plays_in.people_id = people.id AND people.name')" id="st_plays" class="radio <?= ($_POST['searchin']=='plays_in.movie_fid = movies.fid AND plays_in.people_id = people.id AND people.name'?'selected':'unselected') ?>"><?= $trans['o_actor']?></li>
					<li onclick="searchat('st_avail','avail')" id="st_avail" class="radio <?= ($_POST['searchin']=='avail'?'selected':'unselected') ?>"><?= $trans['o_avail']?></li>
					<li onclick="searchat('st_rating','rating')" id="st_rating" class="radio <?= ($_POST['searchin']=='rating'?'selected':'unselected') ?>"><?= $trans['o_rate']?></li>
					<li onclick="searchat('st_id','id')" id="st_id" class="radio <?= ($_POST['searchin']=='id'?'selected':'unselected') ?>"><?= $trans['o_imdb']?></li>
					<li onclick="searchat('st_nr','nr')" id="st_nr" class="radio <?= ($_POST['searchin']=='nr'?'selected':'unselected') ?>"><?= $trans['o_id']?></li>
					<li onclick="searchat('st_country','country')" id="st_country" class="radio <?= ($_POST['searchin']=='country'?'selected':'unselected') ?>"><?= $trans['o_country']?></li>
					<li onclick="searchat('st_year','year')" id="st_year" class="radio <?= ($_POST['searchin']=='year'?'selected':'unselected') ?>"><?= $trans['o_year']?></li>
					<li onclick="searchat('st_runtime','runtime')" id="st_runtime" class="radio <?= ($_POST['searchin']=='runtime'?'selected':'unselected') ?>"><?= $trans['o_runtime']?></li>
					<li onclick="searchat('st_lang','lang')" id="st_lang" class="radio <?= ($_POST['searchin']=='lang'?'selected':'unselected') ?>"><?= $trans['o_lang']?></li>
					<li onclick="searchat('st_comment','comment')" id="st_comment" class="radio <?= ($_POST['searchin']=='comment'?'selected':'unselected') ?>"><?= $trans['o_comment']?></li>
					<li onclick="searchat('st_medium','medium')" id="st_medium" class="radio <?= ($_POST['searchin']=='medium'?'selected':'unselected') ?>"><?= $trans['o_medium']?></li>
					<li onclick="searchat('st_disks','disks')" id="st_disks" class="radio <?= ($_POST['searchin']=='disks'?'selected':'unselected') ?>"><?= $trans['o_disks']?></li>
					<li onclick="searchat('st_container','container')" id="st_container" class="radio <?= ($_POST['searchin']=='container'?'selected':'unselected') ?>"><?= $trans['o_container']?></li>
					<li onclick="searchat('st_width','width')" id="st_width" class="radio <?= ($_POST['searchin']=='width'?'selected':'unselected') ?>"><?= $trans['o_width']?></li>
					<li onclick="searchat('st_height','height')" id="st_height" class="radio <?= ($_POST['searchin']=='height'?'selected':'unselected') ?>"><?= $trans['o_height']?></li>
					<li onclick="searchat('st_format','format')" id="st_format" class="radio <?= ($_POST['searchin']=='format'?'selected':'unselected') ?>"><?= $trans['o_format']?></li>
					<li onclick="searchat('st_ratio','ratio')" id="st_ratio" class="radio <?= ($_POST['searchin']=='ratio'?'selected':'unselected') ?>"><?= $trans['o_ratio']?></li>
					<li onclick="searchat('st_video','video')" id="st_video" class="radio <?= ($_POST['searchin']=='video'?'selected':'unselected') ?>"><?= $trans['o_video']?></li>
					<li onclick="searchat('st_audio','audio')" id="st_audio" class="radio <?= ($_POST['searchin']=='audio'?'selected':'unselected') ?>"><?= $trans['o_audio']?></li>
					<li onclick="searchat('st_channel','channel')" id="st_channel" class="radio <?= ($_POST['searchin']=='channel'?'selected':'unselected') ?>"><?= $trans['o_channel']?></li>
					<li onclick="searchat('st_herz','herz')" id="st_herz" class="radio <?= ($_POST['searchin']=='herz'?'selected':'unselected') ?>"><?= $trans['o_herz']?></li>
				</ul>
			</fieldset>
		</div>
		<input type="hidden" name="page" value="<?= isset($_POST['page'])?$_POST['page']:'0' ?>">
		<input type="hidden" name="view" value="<?= isset($_POST['view'])?$_POST['view']:'poster'?>">
		<input type="hidden" name="filtertitle" value="<?= isset($_POST['filtertitle'])?$_POST['filtertitle']:'*'?>">
		<input type="hidden" name="filter" value="<?= $_POST['filter'] ?>">
<? for($i=0; $i<$sortsize; $i++) {?>
		<input type="hidden" name="sortby[<?= $i ?>]" value="<?= $sortarray[$i] ?>">
<? } ?>
		<input type="hidden" name="sorter" value="<?= $_POST['sorter'] ?>">
		<input type="hidden" name="genres" value="<?= $_POST['genres'] ?>">
		<input type="hidden" name="tosearch" value="<?= isset($_POST['tosearch'])?$_POST['tosearch']:''?>">
		<input type="hidden" name="searchin" value="<?= isset($_POST['searchin'])?$_POST['searchin']:'movies.name,aka'?>">
		<input type="hidden" name="login" value="<?= $loggedin?'1':'0' ?>">
	</form>
	</div>
	</div>	
	<div id="scroller"><div id="scrollthumb"></div></div>
<script type="text/javascript">
<!--
<? echo 'var s_size='.$sortsize.';'."\n"; ?>
-->
</script>
	</body>
</html>