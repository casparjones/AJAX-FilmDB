<?php
/* FilmDB (based on php4flicks) */

	// mobile.php -- display the newest movies for mobile phones
	
	require_once('../config/config.php');

	// columns to be listed
	$cols = ' DISTINCT CONCAT(cat,nr)as nr,movies.name,local,year,runtime,medium,movies.id,fid,container,disks,type,video,audio,lang,ratio,format,channel,herz,width,height,country,rating,avail,lentto,lentsince,inserted,aka,cat,genre,comment ';

	// check if user is logged in
	$loggedin = false; $loging = 0; $loguser = '';

	// default query (overwritten below if filter posted)
	$query = "SELECT SQL_CALC_FOUND_ROWS $cols FROM movies ";
		
	// if filter has been submitted, use it
		$via_GET = true; $cfg['mobileentries'] = '10';
		
		$_POST['page'] = (isset($_GET['page'])?$_GET['page']:'0');
		$_POST['view'] = 'list';
		$_POST['filtertitle'] = '*';
		$_POST['filter'] = '';
		$_POST['sortby'][0] = (isset($_GET['sortby'][0])?$_GET['sortby'][0]:'inserted DESC');
		$_POST['sortby'][1] = (isset($_GET['sortby'][1])?$_GET['sortby'][1]:'nr ASC');
		$_POST['sortby'][2] = (isset($_GET['sortby'][2])?$_GET['sortby'][2]:'year ASC');
		$_POST['sorter'] = (isset($_GET['sorter'])?$_GET['sorter']:'inserted_DESC');
		$_POST['genres'] = '';
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

		$sortsize = sizeof($sortarray);
		$sortby = implode($sortarray,',');
		$query .= " ORDER BY $sortby ";
	
	// LIMIT clause
	if(!isset($_POST['page']) || $_POST['page'] == '') {
		$_POST['page'] = '0';
	}

	$query .= ' LIMIT '.$_POST['page'].','.$cfg['mobileentries'];

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
		<title><?= $trans['page_title']?>:List</title>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	</head>
	<body bgcolor="#ffffff" text="#333333" vlink="#336699" alink="#996633" link="#336699" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	    <basefont color="#333333" face="tahoma,arial,helvetica,sans-serif" size="-2">
		<table bgcolor="#dddddd" cellspacing="0" cellpadding="2" border="0">
			<tbody><tr><td align="center" nowrap>
<? if($_POST['page']!='0'){ ?>
					<a href="index.php?page=0"><b>|&lt;</b></a>&nbsp;
<? }else{ ?>
					|&lt;&nbsp;
<? } ?>
<? if($_POST['page']!='0'){if(((integer)$_POST['page'])<$cfg['mobileentries']){$tmp=0;}else{$tmp=((integer)$_POST['page'])-$cfg['mobileentries'];} ?>
					<a href="index.php?page=<?= $tmp ?>"><b>&lt;</b></a>&nbsp;
<? }else{ ?>
					&lt;&nbsp;
<? } ?>
					<nobr><? if($rowcount==0) {echo '<b>0-0</b> / <b>0</b>';} else {echo '<b>'; echo $_POST['page']+1; echo '-'; echo $_POST['page']+min($cfg['mobileentries'],$rowcount-$_POST['page']); echo '</b> / <b>'.$rowcount.'</b>';} ?></nobr>&nbsp;
<? $tmp=((integer)$_POST['page'])+$cfg['mobileentries']; if($rowcount > $tmp){ ?>
					<a href="index.php?page=<?= $tmp ?>"><b>&gt;</b></a>&nbsp;
<? }else{ ?>
					&gt;&nbsp;
<? } ?>
<? if($rowcount > $tmp){ $end = --$rowcount - (($rowcount) % $cfg['mobileentries']); ?>
					<a href="index.php?page=<?= $end ?>"><b>&gt;|</b></a>
<? }else{ ?>
					&gt;|
<? } ?>
			</tr></tbody>
		</table>
		<table cellspacing="0" cellpadding="2" border="0" width="100%">
			<tbody>
<?
$brow = true; $pge = ((integer)$_POST['page']); $foo = 0; $i = 0; $nr = 0;
while($row = mysql_fetch_array($result)){
	$i++; $foo = $pge + $i; $nr = $brow?'0':'1';
	
if($row['avail']!='1'){ ?>
				<tr bgcolor="#ffe3db">
<? }else{ if($nr=='1'){ ?>
				<tr bgcolor="#FFFFFF">
<? }else{ ?>
				<tr bgcolor="#EBF3FF">
<? } } ?>
					<td><b><?= $row['name'] ?></b>
<? if($row['local']!=$row['name']) { ?>
					<i>(<?= $row['local'] ?>)</i>
<? } ?>
					&bull; <? getcountry($row['country']); ?> &bull; <?= $row['year']?> &bull; <?= $row['runtime']?>&nbsp;<?= $trans['t_minutes']?> &bull; <?= $row['disks'].'x '.$row['medium']?> &bull; <?= substr($row['inserted'], -2, 2).'-'.$trans[substr($row['inserted'], 5, 2)].'-'.substr($row['inserted'], 0, 4) ?></td>
				</tr>
<?
	$brow = !$brow;
}
if($rowcount==0){
	echo '				<tr><td bgcolor="#ffe3db" align="center"><b>'.$trans['no_matches'].'</b></td></tr>'."\n";
}
?>
			</tbody>
		</table>
	</body>
</html>
