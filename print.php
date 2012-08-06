<?php
/* FilmDB (based on php4flicks) */

	// print.php -- print page with movie list
	
	require_once('config/config.php');

	function directorsearch(&$out, $movieid){
		$res = mysql_query("SELECT people.name FROM directs,people WHERE directs.movie_fid = $movieid AND directs.people_id = people.id;") or die(mysql_error());
		if($row = mysql_fetch_row($res)) // while
			($out ==''?$out .= $row[0] : $out .= ', '.$row[0]);
		return;
	}

	function getpeople(&$out,$table,$movieid,$text){
		$res = mysql_query("SELECT people.id,people.name FROM $table,people WHERE $table.movie_fid = $movieid AND $table.people_id = people.id ORDER BY people.id;") or die(mysql_error());
		while($row = mysql_fetch_row($res)){
			if($out != '') $out .= ', ';
			$out .= '<nobr>'.$row[1].'</nobr>';
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
	
	$res = mysql_query('SELECT COUNT(*) FROM movies') or die(mysql_error());
	$moviecount = mysql_fetch_row($res);
	$moviecount = $moviecount[0];

	// columns to be listed
	$cols = ' DISTINCT CONCAT(cat,nr)as nr,movies.name,local,year,runtime,medium,movies.id,fid,container,disks,type,video,audio,lang,ratio,format,channel,herz,width,height,country,rating,avail,lentto,lentsince,inserted,aka,cat,genre,comment ';

	// default query (overwritten below if filter posted)
	$query = "SELECT SQL_CALC_FOUND_ROWS $cols FROM movies ";
	
	$_GET['page'] = '0';
	
	if(!isset($_GET['view'])) $_GET['view']='list';
	if(!isset($_GET['filtertitle'])) {
		$_GET['filtertitle']='*';
	} else if($_GET['filtertitle']=='!') {
		$_GET['filtertitle']='#';
	}
	if(!isset($_GET['filter'])) $_GET['filter']='';
	// if(!isset($_GET['sortby'][0])) $_GET['sortby'][0]='local ASC';
	if(!isset($_GET['sorter'])) $_GET['sorter']='local_ASC';
	if(!isset($_GET['genres'])) $_GET['genres']='';
	if(!isset($_GET['sortby'])) $_GET['sortby']='';
	if(!isset($_GET['tosearch'])) $_GET['tosearch']='';
	if(!isset($_GET['searchin'])) $_GET['searchin']='movies.name,aka';
	
	if(strlen($_GET['filter'])<=0){
		$_GET['filter']=''; // 'SELECT SQL_CALC_FOUND_ROWS _COLS_ FROM';
	} else {
		// WHERE clause
		if(strlen($_GET['filter'])>0){
			// where clause was submitted
			// check if it is a select and not malicious SQL
			if(substr($_GET['filter'],0,38) != 'SELECT SQL_CALC_FOUND_ROWS _COLS_ FROM')
				die('don\'t try that.');
			$query = str_replace('_COLS_',$cols,$_GET['filter']);
		}
	}
	if(sizeof($_GET['sortby'])>1){
		// ORDER BY clause
		$sortsize = sizeof($_GET['sortby']);
		for($i=0; $i<$sortsize; $i++){
			$sortarray[$i] = $_GET['sortby'][$i];
			if($sortarray[$i]=='') break;
		}
		// fill rest of sort array with default values
		for($j=0; $j<$sortsize-$i; $j++){
			if(!isset($cfg['defaultsort'][$j])) break;
			$sortarray[$i] = $cfg['defaultsort'][$j];
			$i++;
		}
	} else {
		$sortarray = $cfg['defaultsort'];
	}
		$sortsize = sizeof($sortarray);
		$sortby = implode($sortarray,',');
		$query .= " ORDER BY $sortby ";

	// $query .= ' LIMIT '.$_GET['page'].',80'; // 2 5 30 42

	$result = mysql_query($query) or die(mysql_error());
	
	$rowresult = mysql_query('SELECT FOUND_ROWS()') or die(mysql_error());
	$row = mysql_fetch_row($rowresult);
	$rowcount = $row[0];

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
       "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="<?= $conttype ?>">
		<title><?= $trans['page_title'].': '.$trans['print_page'].' ['.$trans[ $_GET['view'].'_view'].']' ?></title>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		</script>
		<meta http-equiv="Content-Style-Type" content="text/css">
		<link rel="stylesheet" type="text/css" href="config/<?php if(eregi('Win',$_SERVER['HTTP_USER_AGENT'])) { echo "win"; } else { echo "oos"; } ?>.css">
		<style type="text/css">
		<!--
		@media print, screen, all {
<? if(isset($_COOKIE['prefs'])) { ?>
			html, body {
				font-family:'<?= $cfg['fonttype'] ?>','Arial','Helvetica','sans-serif';
			}
<? } ?>
			a { text-decoration: none; font-weight: bold; color: #333333; }
			td, th {
				page-break-inside: avoid;
				padding: 2px 4px 2px 4px; 
				font-size: 86%; 
			}
			th { text-align: left; }
			.bit { padding: 4px 4px 4px 4px; }
			.pic { padding: 2px 2px 2px 2px; text-align: center; }
			h3 { font-size:150%; display:inline; }
			small { font-size:80%; }
			big { font-size:120%; }
			strong { color:#990000; }
			button  { background-color:#ccc; padding: 0px 8px 0px 8px; }
			.active {
				background-color: #cccccc;
				background-repeat: repeat-x;
				background-position: center;
			}
			.passive {
				background-color: #ffffff;
				background-repeat: repeat-x;
				background-position: center;
			}
			.title_line { font-size:86%; }
			.sub_line { font-size:72%; font-style:italic; color:#333333; }
			.row_0 { background-color: #f0f0f0; }
			.row_1 { background-color: #ffffff; }
			.poster { 
				margin: 0px 0px 0px 0px;
				display:inline;
				float:left;
				min-width:116px;
				min-height:180px;
				height:auto;
				text-align:center;
				page-break-inside:avoid;
			}
			#printblock {
				min-width: 700px;
				width: 100%;
			}
		}
		-->
		</style>
	</head>
	<body bgcolor="#ffffff" text="#333333" vlink="#333333" alink="#333333" link="#333333" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? if($_GET['view']=='film') { /* FILM-VIEW */ ?>
<?
$brow = true; $i = 0;
while($row = mysql_fetch_array($result)){
	$i++;
	$directors = ''; $actors = ''; $writers = ''; $tmp = $trans['show_imdbperson'];
	getpeople($directors,'directs',$row['fid'],$tmp);
	getpeople($actors,'plays_in',$row['fid'],$tmp);
	getpeople($writers,'writes',$row['fid'],$tmp);
?>
		<table id="printblock" style="page-break-inside:avoid" border="0" bordercolor="#D9D9D9" cellspacing="0" cellpadding="2" width="100%"><tbody>
			<tr><td class="bit" width="100" valign="top" align="center">
					<img src="images/space.gif" width="100" height="1" border="0">
					<img src="imgget.php?for=<?= $row['fid']?>" align="center" width="95" height="140" border="0">
					<br><br>
					<b><?= '['.$row['nr'].']' ?></b>
					<br><br>
					<nobr><?= $trans['t_film']?> <b><?= $i ?></b> <?= $trans['x_of_x']?> <b><?= $moviecount ?></b></nobr>
					<br><br>
<? if($row['medium']=='Disk'){ ?>
					<img src="images/disk.png" alt="Disk" width="85" height="60" border="0">
<? } else if($row['medium']=='Stick'){ ?>
					<img src="images/stick.png" alt="Stick" width="85" height="50" border="0">
<? } else if($row['medium']=='Card'){ ?>
					<img src="images/card.png" alt="Card" width="85" height="60" border="0">
<? } else if($row['medium']=='UMD'){ ?>
					<img src="images/umd.png" alt="UMD" width="85" height="42" border="0">
<? } else if($row['medium']=='BD'){ ?>
					<img src="images/bd.png" alt="BD" width="85" height="42" border="0">
<? } else if($row['medium']=='HD-DVD'){ ?>
					<img src="images/hddvd.png" alt="HD-DVD" width="85" height="42" border="0">
<? } else if($row['medium']=='VideoDVD' || $row['medium']=='ISO-DVD'){ ?>
					<img src="images/dvd.png" alt="DVD" width="85" height="42" border="0">
<? } else { ?>
					<img src="images/cd.png" alt="CD" width="85" height="42" border="0">
<? } ?>
			</td><td class="bit" valign="top" width="100%">
				<table frame="box" rules="cols" bordercolor="#D9D9D9" border="0" cellspacing="0" cellpadding="2" width="100%"><tr>
					<td style="text-transform:capitalize" valign="top" align="right" valign="bottom" nowrap><big><?= $trans['t_original']?>&nbsp;<b><?= $trans['t_title']?></b></big>:</td>
					<td class="row_1" width="100%"><h3><?= $row['name'].' ('.$row['year'].')' ?></h3></td>
				</tr><tr>
					<td style="text-transform:capitalize" valign="top" align="right" nowrap><big><?= $trans['t_local'] ?>&nbsp;<b><?= $trans['t_title'] ?></b>:</big></td>
					<td class="row_0" width="100%"><big><b><?= $row['local'] ?></b></big></td>
				</tr><tr>
					<td style="text-transform:capitalize" valign="top" align="right" nowrap><big><?= $trans['t_alias'] ?>&nbsp;<b><?= $trans['t_title'] ?></b>:</big></td>
					<td class="row_1" width="100%"><big><?= str_replace("\n",'&bull; ',$row['aka']) ?></big></td>
				</tr><tr>
					<td style="text-transform:capitalize" valign="top" align="right" nowrap><big><b><?= $trans['t_rating']?>:</b></big></td>
					<td class="row_0" width="100%"><big><?= $row['rating'] ?>&nbsp;<?= $trans['x_of_x'] ?>&nbsp;100</big></td>
				</tr><tr>
					<td style="text-transform:capitalize" valign="top" align="right" nowrap><big><b><?= $trans['t_country']?>:</b></big></td>
					<td class="row_1" width="100%"><big><?= str_replace("\n",'/',$row['country']) ?></big></td>
				</tr><tr>
					<td style="text-transform:capitalize" valign="top" align="right" nowrap><big><b><?= $trans['t_year']?>:</b></big></td>
					<td class="row_0" width="100%"><big><?= $row['year']?></big></td>
				</tr><tr>
					<td style="text-transform:capitalize" valign="top" align="right" nowrap><big><b><?= $trans['t_runtime']?>:</b></big></td>
					<td class="row_1" width="100%"><big><?= $row['runtime'].' '.$trans['t_minutes'].' ['.sprintf("%02d",($row['runtime']/60)).':'.sprintf("%02d",($row['runtime']%60)).']' ?></big></td>
				</tr><tr>
					<td style="text-transform:capitalize" valign="top" align="right" nowrap><big><b><?= $trans['t_language']?>:</b></big></td>
					<td class="row_0" style="text-transform:capitalize" width="100%"><big><? $l=explode(",",$row['lang']); for($x=0;$x<count($l);$x++){ echo '<img src="images/flag/'.($l[$x]=="?"?"xx":strtolower($l[$x])).'.png" width="14" height="9" align="bottom" alt="'.$l[$x].'"> '.$trans[$l[$x]]." "; }?></big></td>
				</tr><tr>
					<td style="text-transform:capitalize" valign="top" align="right" nowrap><big><b><?= $trans['t_category']?>:</b></big></td>
					<td class="row_1" width="100%"><big><?= str_replace(",",' &bull; ',$row['genre'])?></big></td>
				</tr><tr>
					<td style="text-transform:capitalize" valign="top" align="right" nowrap><big><b><?= $trans['t_director']?>:</b></big></td>
					<td class="row_0" width="100%"><big><?= $directors?></big></td>
				</tr><tr>
					<td style="text-transform:capitalize" valign="top" align="right" nowrap><big><b><?= $trans['t_writer']?>:</b></big></td>
					<td class="row_1" width="100%"><big><?= $writers?></big></td>
				</tr><tr>
					<td style="text-transform:capitalize" valign="top" align="right" nowrap><big><b><?= $trans['t_actor']?>:</b></big></td>
					<td class="row_0" width="100%"><div style="-moz-column-width: 10em; -moz-column-count: 3; -moz-column-gap: 1em;"><big><?= $actors?></big></div></td>
				</tr><tr>
					<td style="text-transform:capitalize" valign="top" align="right" nowrap><big><b><?= $trans['t_medium']?>:</b></big></td>
					<td class="row_1" width="100%"><big><?= $row['disks'].' x '.$row['medium'].' ['.$row['type'].'] ('.$row['container'].' '.$trans['t_container'].')' ?></big></td>
				</tr><tr>
					<td style="text-transform:capitalize" valign="top" align="right" nowrap><big><b><?= $trans['t_video']?>:</b></big></td>
					<td class="row_0" width="100%"><big><?= $row['video'].' &bull; '.$row['width'].'x'.$row['height'].' &bull; '.$row['format'].' &bull; '.$row['ratio']?></big></td>
				</tr><tr>
					<td style="text-transform:capitalize" valign="top" align="right" nowrap><big><b><?= $trans['t_audio']?>:</b></big></td>
					<td class="row_1" width="100%"><big><?= $row['audio'].' &bull; '.$row['channel'].' &bull; '.$row['herz'].' KHz' ?></big></td>
				</tr><tr>
					<td style="text-transform:capitalize" valign="top" align="right" nowrap><big><b><?= $trans['t_date']?>:</b></big></td>
					<td class="row_0" width="100%"><big><?= substr($row['inserted'], -2, 2).'-'.$trans[substr($row['inserted'], 5, 2)].'-'.substr($row['inserted'], 0, 4) ?></big></td>
				</tr><tr>
					<td style="text-transform:capitalize" valign="top" align="right" nowrap><big><b><?= $trans['t_comment']?>:</b></big></td>
					<td class="row_1" width="100%"><big><?= $row['comment']?></big></td>
				</tr></table>
			</td></tr></tbody>
		</table><br>
<?
	$brow = !$brow;
}
?>
<? }else if($_GET['view']=='row') { /* ROW-VIEW */ ?>
<?
$brow = true; $pge = ((integer)$_GET['page']); $foo = 0; $i = 0;
while($row = mysql_fetch_array($result)){
	$i++; $foo = $pge + $i;
	$directors = ''; $actors = ''; $writers = ''; $tmp = $trans['show_imdbperson'];
	getpeople($directors,'directs',$row['fid'],$tmp);
	getpeople($actors,'plays_in',$row['fid'],$tmp);
	getpeople($writers,'writes',$row['fid'],$tmp);
?>
		<table id="printblock" style="page-break-inside:avoid" border="0" bordercolor="#D9D9D9" cellspacing="0" cellpadding="2" width="100%"><tbody>
			<tr><td class="bit" valign="top" align="center" width="100">
				<img src="images/space.gif" width="100" height="1" border="0">
				<img src="imgget.php?for=<?= $row['fid']?>" align="center" width="95" height="140" border="0"><br>
				<br><small><nobr><?= $trans['t_film']?> <b><?= $i ?></b> <?= $trans['x_of_x']?> <?= $moviecount ?></nobr></small>
			</td><td class="bit" valign="top" width="100%">
				<table style="border-bottom:solid 1px #D9D9D9" frame="box" rules="cols" bordercolor="#D9D9D9" border="0" cellspacing="0" cellpadding="2" width="100%"><tr>
					<td style="text-transform:capitalize" valign="top" align="right" bgcolor="#f0f0f0" nowrap><?= $trans['t_original']?>&nbsp;<big><b><?= $trans['t_title']?></b></big>:</td>
					<td width="100%"><big><b><?= $row['name'].' ('.$row['year'].')' ?></b></big></td>
				</tr><tr>
					<td style="text-transform:capitalize" valign="top" align="right" bgcolor="#eeeeee" nowrap><?= $trans['t_local'] ?>&nbsp;<b><?= $trans['t_title'] ?></b>:</td>
					<td class="row_0" width="100%"><b><?= $row['local'] ?></b></td>
				</tr><tr>
					<td style="text-transform:capitalize" valign="top" align="right" bgcolor="#eeeeee" nowrap><?= $trans['t_alias'] ?>&nbsp;<b><?= $trans['t_title'] ?></b>:</td>
					<td width="100%"><?= str_replace("\n",'&bull; ',$row['aka']) ?></td>
				</tr><tr>
					<td style="text-transform:uppercase" valign="top" align="right" bgcolor="#eeeeee" nowrap><?= $trans['t_filminfo']?>:</td>
					<td class="row_0" width="100%"><?= '['.$row['nr'].'] &bull; '.$row['country'].' &bull; '.$row['year'].' &bull; '.$row['runtime'].'&nbsp;'.$trans['t_minutes'].' &bull; '.str_replace(",",'/',$row['lang']).' &bull; '.$row['rating'].' '.$trans['x_of_x'].' 100 &bull; '.substr($row['inserted'], -2, 2).'-'.$trans[substr($row['inserted'], 5, 2)].'-'.substr($row['inserted'], 0, 4) ?></td>
				</tr><tr>
					<td style="text-transform:uppercase" valign="top" align="right" bgcolor="#eeeeee" nowrap><?= $trans['t_medium']?>:</td>
					<td width="100%"><?= $row['disks'].' x '.$row['medium'].' ['.$row['type'].'] ('.$row['container'].' '.$trans['t_container'].') &bull; '.$row['video'].' '.$row['width'].'x'.$row['height'].' '.$row['format'].' '.$row['ratio'].' &bull; '.$row['audio'].' '.$row['channel'].' '.$row['herz'].' KHz' ?></td>
				</tr><tr>
					<td style="text-transform:uppercase" valign="top" align="right" bgcolor="#eeeeee" nowrap><?= $trans['t_category']?>:</td>
					<td class="row_0" width="100%"><?= str_replace(",",' &bull; ',$row['genre']) ?></td>
				</tr><tr>
					<td style="text-transform:uppercase" valign="top" align="right" bgcolor="#eeeeee" nowrap><?= $trans['t_director']?>:</td>
					<td width="100%"><?= $directors ?></td>
				</tr><tr>
					<td style="text-transform:uppercase" valign="top" align="right" bgcolor="#eeeeee" nowrap><?= $trans['t_writer']?>:</td>
					<td class="row_0" width="100%"><?= $writers ?></td>
				</tr><tr>
					<td style="text-transform:uppercase" valign="top" align="right" bgcolor="#eeeeee" nowrap><?= $trans['t_actor']?>:</td>
					<td width="100%"><div style="-moz-column-width: 8em; -moz-column-count: 4; -moz-column-gap: 1em;"><?= $actors ?></div></td>
<? if($row['comment']!=''){ ?>
				</tr><tr>
					<td style="text-transform:uppercase" valign="top" align="right" bgcolor="#eeeeee" nowrap><?= $trans['t_comment']?>:</td>
					<td class="row_0" width="100%"><?= $row['comment']?></td>
<? } ?>
				</tr></table>
			</td></tr></tbody>
		</table>
<?
	$brow = !$brow;
}
?>
<? }else if($_GET['view']=='poster') { /* POSTER-VIEW */ ?>
	<table id="printblock" border="0" cellspacing="0" cellpadding="0" width="100%"><tr><td>
<?
$brow = true; $pge = ((integer)$_GET['page']); $foo = 0; $i = 0;
while($row = mysql_fetch_array($result)){
	$i++; $foo = $pge + $i;
?>
		<table class="poster" width="116" height="180" border="0" cellspacing="0" cellpadding="0">
			<tr><td valign="bottom" class="pic" align="center" width="116" height="140"><img src="imgget.php?for=<?= $row['fid']?>" width="95" height="140" border="0"></td></tr>
			<tr><td valign="top" class="pic" align="center" height="40"><small><? if(($_GET['sorter']=='name_ASC')||($_GET['sorter']=='name_DESC')){ echo $row['name']; }else{ echo $row['local']; }?></small></td></tr>
		</table>
<?
	$brow = !$brow;
}
echo '		<br style="clear:left;" clear="all"><br>'."\n";
?>
	</td></tr></table>
<? } else { /* LIST-VIEW */ ?>
		<table id="printblock" border="1" bordercolor="#D9D9D9" rules="cols" cellspacing="0" cellpadding="0" width="100%">
			<thead><tr style="border-bottom:solid 1px #D9D9D9;">
				<th class="passive" style="text-transform:capitalize" nowrap><?= $trans['t_no']?></th>
<? if($_GET['sorter']=='rating_DESC'){ ?>
				<th class="active" nowrap>&nbsp;!</th>
<? }else{ ?>
				<th class="passive" nowrap>&nbsp;!</th>
<? } ?>
<? if(($_GET['sorter']=='nr_ASC')||($_GET['sorter']=='nr_DESC')){ ?>
				<th class="active" nowrap>
<? }else{ ?>
				<th class="passive" nowrap>ID</th>
<? } ?>
<? if($_GET['sorter']=='nr_DESC'){ ?>
					<img align="right" src="images/table/asc_on.png" alt="asc" width="12" height="14" border="0">ID</th>
<? } ?>
<? if($_GET['sorter']=='nr_ASC'){ ?>
					<img align="right" src="images/table/desc_on.png" alt="desc" width="12" height="14" border="0">ID</th>
<? } ?>
<? if(($_GET['sorter']=='local_ASC')||($_GET['sorter']=='local_DESC')||($_GET['sorter']=='name_ASC')||($_GET['sorter']=='name_DESC')){ ?>
				<th class="active" style="text-transform:capitalize" nowrap>
<? }else{ ?>
				<th class="passive" style="text-transform:capitalize" nowrap><?= $trans['t_title']?>&nbsp;<small><?= $trans['t_local']?>&nbsp;<?= $trans['t_original']?></small></th>
<? } ?>
<? if($_GET['sorter']=='local_DESC'){ ?>
					<img align="right" src="images/table/asc_on.png" alt="asc" width="12" height="14" border="0"><?= $trans['t_title']?>&nbsp;<small><?= $trans['t_local']?></small></th>
<? } ?>
<? if($_GET['sorter']=='local_ASC'){ ?>
					<img align="right" src="images/table/desc_on.png" alt="desc" width="12" height="14" border="0"><?= $trans['t_title']?>&nbsp;<small><?= $trans['t_local']?></small></th>
<? } ?>
<? if($_GET['sorter']=='name_DESC'){ ?>
					<img align="right" src="images/table/asc_on.png" alt="asc" width="12" height="14" border="0"><?= $trans['t_title']?>&nbsp;<small><?= $trans['t_original']?></small></th>
<? } ?>
<? if($_GET['sorter']=='name_ASC'){ ?>
					<img align="right" src="images/table/desc_on.png" alt="desc" width="12" height="14" border="0"><?= $trans['t_title']?>&nbsp;<small><?= $trans['t_original']?></small></th>
<? } ?>
				<th class="passive" style="text-transform:capitalize" nowrap><?= $trans['t_director']?></th>
				<th class="passive" style="text-transform:capitalize" nowrap><?= $trans['t_country']?></th>
<? if(($_GET['sorter']=='year_ASC')||($_GET['sorter']=='year_DESC')){ ?>
				<th class="active" style="text-transform:capitalize" nowrap>
<? }else{ ?>
				<th class="passive" style="text-transform:capitalize" nowrap><?= $trans['t_year']?></th>
<? } ?>
<? if($_GET['sorter']=='year_DESC'){ ?>
					<img align="right" src="images/table/asc_on.png" alt="asc" width="12" height="14" border="0"><?= $trans['t_year']?></th>
<? } ?>
<? if($_GET['sorter']=='year_ASC'){ ?>
					<img align="right" src="images/table/desc_on.png" alt="desc" width="12" height="14" border="0"><?= $trans['t_year']?></th>
<? } ?>
<? if(($_GET['sorter']=='runtime_ASC')||($_GET['sorter']=='runtime_DESC')){ ?>
				<th class="active" style="text-transform:capitalize" nowrap>
<? }else{ ?>
				<th class="passive" style="text-transform:capitalize" nowrap><?= $trans['t_runtime']?></th>
<? } ?>
<? if($_GET['sorter']=='runtime_DESC'){ ?>
					<img align="right" src="images/table/asc_on.png" alt="asc" width="12" height="14" border="0"><?= $trans['t_runtime']?></th>
<? } ?>
<? if($_GET['sorter']=='runtime_ASC'){ ?>
					<img align="right" src="images/table/desc_on.png" alt="desc" width="12" height="14" border="0"><?= $trans['t_runtime']?></th>
<? } ?>
<? if(($_GET['sorter']=='medium_ASC')||($_GET['sorter']=='medium_DESC')){ ?>
				<th class="active" style="text-transform:capitalize" nowrap>
<? }else{ ?>
				<th class="passive" style="text-transform:capitalize" nowrap><?= $trans['t_medium']?></th>
<? } ?>
<? if($_GET['sorter']=='medium_DESC'){ ?>
					<img align="right" src="images/table/asc_on.png" alt="asc" width="12" height="14" border="0"><?= $trans['t_medium']?></th>
<? } ?>
<? if($_GET['sorter']=='medium_ASC'){ ?>
					<img align="right" src="images/table/desc_on.png" alt="desc" width="12" height="14" border="0"><?= $trans['t_medium']?></th>
<? } ?>
<? if(($_GET['sorter']=='inserted_ASC')||($_GET['sorter']=='inserted_DESC')){ ?>
				<th class="active" style="text-transform:capitalize" nowrap>
<? }else{ ?>
				<th class="passive" style="text-transform:capitalize" nowrap><?= $trans['t_since']?></th>
<? } ?>
<? if($_GET['sorter']=='inserted_DESC'){ ?>
					<img align="right" src="images/table/asc_on.png" alt="asc" width="12" height="14" border="0"><?= $trans['t_since']?></th>
<? } ?>
<? if($_GET['sorter']=='inserted_ASC'){ ?>
					<img align="right" src="images/table/desc_on.png" alt="desc" width="12" height="14" border="0"><?= $trans['t_since']?></th>
<? } ?>
			</tr></thead>
			<tbody>
<?
$brow = true; $pagebreak = false; $pge = ((integer)$_GET['page']); $foo = 0; $i = 0;
while($row = mysql_fetch_array($result)){
	$directors = ''; directorsearch($directors,$row['fid']);
	$i++; $foo = $pge + $i; ;
	// if(fmod($i, 40)==0) { $pagebreak = true; } else { $pagebreak = false; }
?>
				<tr class="row_<?= $brow?'0':'1'?>" <? if($pagebreak==true) {echo 'style="page-break-after:always;"';} ?>>
					<td align="right" nowrap><?= $i ?></td>
					<td nowrap><?= $row['rating']?></td>
					<td nowrap><?= $row['nr']?></td>
					<td<? if($cfg['nobreaks']) echo " nowrap"; ?>>
<? if(($cfg['original'])&&($row['local']!=$row['name'])) {
if(($_GET['sorter']=='name_ASC')||($_GET['sorter']=='name_DESC')) { ?>
<span class="title_line"><b><?= $row['name'] ?></b></span><br><span class="sub_line"><?= $row['local'] ?></span></td>
<? }else{ ?>
<span class="title_line"><b><?= $row['local'] ?></b></span><br><span class="sub_line"><?= $row['name'] ?></span></td>
<? } }else if(($_GET['sorter']=='name_ASC')||($_GET['sorter']=='name_DESC')) { ?>
<b><?= $row['name'] ?></b></td>
<? }else{ ?>
<b><?= $row['local'] ?></b></td>
<? } ?>
					<td nowrap><?= $directors?></td>
					<td nowrap><? getcountry($row['country']); ?></td>
					<td nowrap><?= $row['year']?></td>
					<td nowrap><?= $row['runtime']?>&nbsp;<?= $trans['t_minutes']?></td>
					<td nowrap><?= $row['medium']?><? if($row['disks']>1){echo '<small><sup>'.$row['disks'].'</sup></small>';} ?></td>
					<td nowrap><?= substr($row['inserted'], -2, 2).'-'.$trans[substr($row['inserted'], 5, 2)].'-'.substr($row['inserted'], 0, 4) ?></td>
				</tr>
<?
	$brow = !$brow;
}
?>
			</tbody>
		</table>
<? } ?>
	</body>
</html>
