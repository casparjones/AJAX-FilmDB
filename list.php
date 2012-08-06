<?php
/* FilmDB (based on php4flicks) */

	// list.php -- display frame page with movie list
	
	require_once('config/config.php');
	
	$gpc = get_magic_quotes_gpc();
	$gpc = ($gpc == true) ? 1 : 0;

	// columns to be listed
	$cols = ' DISTINCT CONCAT(cat,nr)as nr,movies.name,local,year,runtime,medium,movies.id,fid,container,disks,type,video,audio,lang,ratio,format,channel,herz,width,height,country,rating,avail,lentto,lentsince,inserted,aka,cat,genre,comment ';

	// check if user is logged in
	$loggedin = false; $loging = 0; $loguser = '';
	if(!isset($_POST['login']) || $_POST['login'] != '0'){
		session_start();
		if(!isset($_SESSION['user'])){
			session_unset(); 
			session_destroy();
		} else {
			$loggedin = true; $loging = 1;
			$loguser = $_SESSION['user'];
		}
	}

	// default query (overwritten below if filter posted)
	$query = "SELECT SQL_CALC_FOUND_ROWS $cols FROM movies ";
		
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
	} else {
		$via_GET = true;
		
		$_POST['page'] = (isset($_GET['page'])?$_GET['page']:'0');
		$_POST['view'] = (isset($_GET['view'])?$_GET['view']:'list');
		if(!isset($_GET['filtertitle'])) {
			$_POST['filtertitle']='*';
		} else if($_GET['filtertitle']=='!') {
			$_POST['filtertitle']='#';
		} else {
			$_POST['filtertitle']=$_GET['filtertitle'];
		}
		$_POST['filter'] = (isset($_GET['filter'])?$_GET['filter']:'');
		$_POST['sortby'][0] = (isset($_GET['sortby'][0])?$_GET['sortby'][0]:'local ASC');
		$_POST['sortby'][1] = (isset($_GET['sortby'][1])?$_GET['sortby'][1]:'nr ASC');
		$_POST['sortby'][2] = (isset($_GET['sortby'][2])?$_GET['sortby'][2]:'year ASC');
		$_POST['sorter'] = (isset($_GET['sorter'])?$_GET['sorter']:'local_ASC');
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
		$query .= ' LIMIT '.$_POST['page'].','.$cfg['nooffilms'];
	} else if($_POST['view']=='row') {
		$query .= ' LIMIT '.$_POST['page'].','.$cfg['noofrows'];
	} else if($_POST['view']=='poster') {
		$query .= ' LIMIT '.$_POST['page'].','.$cfg['noofpics'];
	} else {
		$query .= ' LIMIT '.$_POST['page'].','.$cfg['noofentries'];
	}

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
			$out .= '<nobr><a title="'.$text.'" target="_blank" href="http://www.imdb.com/name/nm'.$row[0].'/">'.$row[1].'</a></nobr>';
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
		<title><?= $trans['page_title']?>:List</title>
		<link rel="icon" href="favicon.ico" type="image/ico">
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<meta http-equiv="imagetoolbar" content="no">
		<meta http-equiv="Content-Script-Type" content="text/javascript">
		<script type="text/javascript" language="JavaScript">
		<!--
<?php
	echo '			mq_gpc = '.$gpc.';'."\n";
	echo '			logged_in = '.$loging.';'."\n";
	echo '			in_progress="<h2><nobr><b>'.$trans['work_in_progress'].'</b></nobr></h2><br><br><table width=\"100%\" height=\"16\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td height=\"32\" width=\"100%\" align=\"center\"><img src=\"images/indicator.gif\" width=\"32\" height=\"32\" border=\"0\"></td></tr></table>";'."\n";
	// echo '			in_progress="<h2><nobr><b>'.$trans['work_in_progress'].'</b></nobr></h2><br><table width=\"100%\" height=\"16\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td height=\"16\" width=\"100%\" background=\"images/progress.gif\"><img src=\"images/space.gif\" width=\"16\" height=\"16\" border=\"0\"></td></tr></table>";'."\n";
	echo '			att_pic = "<img src=\"images/attention.png\" alt=\"attention\" width=\"20\" height=\"18\" border=\"0\">&nbsp;";'."\n";
	echo '			login = "<img src=\"images/button/login_off.png\" title=\"'.$trans['log_in'].'\" alt=\"login/out\" width=\"30\" height=\"24\" border=\"0\" name=\"log_in\" onClick=\"setGET_add();change(\'log_in\',\'login_off\');fillRequest(\'editreq\');showRequest(true,\'editreq\',\'login.php\');\" onmouseover=\"change(\'log_in\',\'login_on\')\" onmouseout=\"change(\'log_in\',\'login_off\')\">";'."\n";
	echo '			logout = "<img src=\"images/button/logout_off.png\" title=\"'.$trans['log_out'].'\" alt=\"login/out\" width=\"30\" height=\"24\" border=\"0\" name=\"log_out\" onClick=\"setGET_add();change(\'log_out\',\'logout_off\');ajaxpage(\'logout.php\',\'editreqsource\');log_user_out();\" onmouseover=\"change(\'log_out\',\'logout_on\')\" onmouseout=\"change(\'log_out\',\'logout_off\')\">";'."\n";
	echo '			add_no = "<img src=\"images/button/plus_off.png\" title=\"'.$trans['add_film'].'\" alt=\"add\" width=\"30\" height=\"24\" border=\"0\" name=\"plus_film\" onClick=\"change(\'plus_film\',\'plus_off\');showRequest(att_pic + \''.$trans['alert_title'].$trans['login_alert'].'\',\'textreq\',\'\');\" onmouseover=\"change(\'plus_film\',\'plus_on\')\" onmouseout=\"change(\'plus_film\',\'plus_off\')\">";'."\n";
	echo '			add_yes = "<img src=\"images/button/plus_off.png\" title=\"'.$trans['add_film'].'\" alt=\"add\" width=\"30\" height=\"24\" border=\"0\" name=\"plus_film\" onClick=\"setGET_add();change(\'plus_film\',\'plus_off\');showRequest(true,\'editreq\',\'add.php\');\" onmouseover=\"change(\'plus_film\',\'plus_on\')\" onmouseout=\"change(\'plus_film\',\'plus_off\')\">";'."\n";
	echo '			importing_yes="<img src=\"images/button/import_off.png\" title=\"'.$trans['import_film'].'\" alt=\"import\" width=\"30\" height=\"24\" border=\"0\" name=\"import_film\" onClick=\"setGET_add();change(\'import_film\',\'import_off\');showRequest(true,\'editreq\',\'importfilm.php\');\" onmouseover=\"change(\'import_film\',\'import_on\')\" onmouseout=\"change(\'import_film\',\'import_off\')\">";'."\n";
	echo '			importing_no ="<img src=\"images/button/import_off.png\" title=\"'.$trans['import_film'].'\" alt=\"import\" width=\"30\" height=\"24\" border=\"0\" name=\"import_film\" onClick=\"change(\'import_film\',\'import_off\');showRequest(att_pic + \''.$trans['alert_title'].$trans['login_alert'].'\',\'textreq\',\'\');\" onmouseover=\"change(\'import_film\',\'import_on\')\" onmouseout=\"change(\'import_film\',\'import_off\')\">";'."\n";
?>
			first_on = new Image(); first_on.src = 'images/table/first_on.png';
			first_off = new Image(); first_off.src = 'images/table/first_off.png';
			prev_on = new Image(); prev_on.src = 'images/table/prev_on.png';
			prev_off = new Image(); prev_off.src = 'images/table/prev_off.png';
			next_on = new Image(); next_on.src = 'images/table/next_on.png';
			next_off = new Image(); next_off.src = 'images/table/next_off.png';
			last_on = new Image(); last_on.src = 'images/table/last_on.png';
			last_off = new Image(); last_off.src = 'images/table/last_off.png';
			search_on = new Image(); search_on.src = 'images/table/search_on.png';
			search_off = new Image(); search_off.src = 'images/table/search_off.png';
			asc_on = new Image(); asc_on.src = 'images/table/asc_on.png';
			asc_off = new Image(); asc_off.src = 'images/table/asc_off.png';
			desc_on = new Image(); desc_on.src = 'images/table/desc_on.png';
			desc_off = new Image(); desc_off.src = 'images/table/desc_off.png';
			film_on = new Image(); film_on.src = 'images/button/film_on.png';
			film_off = new Image(); film_off.src = 'images/button/film_off.png';
			row_off = new Image(); row_off.src = 'images/button/row_off.png';
			row_on = new Image(); row_on.src = 'images/button/row_on.png';
			poster_off = new Image(); poster_off.src = 'images/button/poster_off.png';
			poster_on = new Image(); poster_on.src = 'images/button/poster_on.png';
			list_off = new Image(); list_off.src = 'images/button/list_off.png';
			list_on = new Image(); list_on.src = 'images/button/list_on.png';
			edit_off = new Image(); edit_off.src = 'images/table/edit_off.png';
			edit_on = new Image(); edit_on.src = 'images/table/edit_on.png';
			avail_is = new Image(); avail_is.src = 'images/table/avail_is.png';
			avail_no = new Image(); avail_no.src = 'images/table/avail_no.png';
			avail_on = new Image(); avail_on.src = 'images/table/avail_on.png';
			import_off = new Image(); import_off.src = 'images/button/import_off.png';
			import_on = new Image(); import_on.src = 'images/button/import_on.png';
			export_off = new Image(); export_off.src = 'images/table/export_off.png';
			export_on = new Image(); export_on.src = 'images/table/export_on.png';
			
			if(parent.window.document.getElementById('plus_film') == null) 
			{ noframe = true; } else { noframe = false; }
			
			function swap(imgID,imgObjName){
				if(imgID != '') {
					document.images[imgID].src = eval(imgObjName + ".src");
				}
			}
			function display_LCD(f){
				var div = parent.window.document.getElementById('lcd');
				var txt = "<nobr><?= $trans['version'].'&nbsp;<b>'.$cfg['filmdb_version'].'</b>&nbsp;&bull;&nbsp;'.$cfg['filmdb_release']?></nobr>";
				if(f){
					div.innerHTML = f;
				} else {
					if(logged_in > 0){
						txt = "<nobr><?= $trans['login_user'].':&nbsp;<b>'.$loguser.'</b>' ?></nobr>";
					}
					div.innerHTML = txt;
				}
			}
			function set_LogButton(){
				if(!noframe){
					var add = parent.window.document.getElementById('plus_film');
					var imp = parent.window.document.getElementById('import_film');
					var log = parent.window.document.getElementById('log_inout');
					if(logged_in > 0){
						add.innerHTML = add_yes;
						imp.innerHTML = importing_yes;
						log.innerHTML = logout;
					} else {
						add.innerHTML = add_no;
						imp.innerHTML = importing_no;
						log.innerHTML = login;
					}
					display_LCD();
<? if($via_GET){ ?>
					resets_view();
					set_view(document.filterform.view.value);
<? } ?>
				}
			}
			function set_view(v){
				if(v == 'film'){
					parent.window.document.film_view.src = film_on.src;
				} else if(v == 'row'){
					parent.window.document.row_view.src = row_on.src;
				} else if(v == 'poster'){
					parent.window.document.poster_view.src = poster_on.src;
				} else {
					parent.window.document.list_view.src = list_on.src;
				}
			}
			function resets_view(){
				parent.window.document.row_view.src = row_off.src;
				parent.window.document.poster_view.src = poster_off.src;
				parent.window.document.list_view.src = list_off.src;
				parent.window.document.film_view.src = film_off.src;
			}
			function close_Request(n){
				var div = parent.window.document.getElementById(n+'source');
				div.innerHTML = '';
			}
			function fill_Request(n){
				var div = parent.window.document.getElementById(n+'source');
				div.innerHTML = in_progress;
			}
			function show_Request(f,n,d){
				var requestBox = parent.window.document.getElementById('locker');
				var boxContent = parent.window.document.getElementById(n);
				var contentDiv = parent.window.document.getElementById(n+'source');
				if(f){
					var tmp = typeof(f); 
					if(tmp=='boolean'){
						parent.window.ajaxpage(d,n+'source');
					} else {
						contentDiv.innerHTML = f;
					}
					parent.window.focus();
					requestBox.style.display = 'block';
					requestBox.style.visibility = 'visible';
					boxContent.style.display = 'block';
					boxContent.style.visibility = 'visible';
				} else {
					requestBox.style.display = 'none';
					requestBox.style.visibility = 'hidden';
					boxContent.style.display = 'none';
					boxContent.style.visibility = 'hidden';
					var cls = typeof(d);
					if(cls=='boolean'){
						contentDiv.innerHTML = '';
					}
				}
			}
			function tfilter(f,typ){
				//sets the filter to title=f,genre=... and submits filterform.
				if(typ==null || typ=='') { typ = 'movies.name,aka'; }
				var allgenres=true;
				var query='SELECT SQL_CALC_FOUND_ROWS _COLS_ FROM ';
				switch(typ){
					case 'directs.movie_fid = movies.fid AND directs.people_id = people.id AND people.name':
						query += 'movies,directs,people';
						break;
					case 'writes.movie_fid = movies.fid AND writes.people_id = people.id AND people.name':
						query += 'movies,writes,people';
						break;
					case 'plays_in.movie_fid = movies.fid AND plays_in.people_id = people.id AND people.name':
						query += 'movies,plays_in,people';
						break;
					default:
						query += 'movies';
				}
				query += ' WHERE ';
				document.filterform.genres.value = '';
				if(f!='#'){
					document.filterform.tosearch.value = f;
				} else {
					document.filterform.tosearch.value = '';
				}
				gquery='';
				for(i=0;;i++){
					if(!(cur=document.getElementById('genres_'+i))) {
						break;
					}
					if(cur.checked){
						document.filterform.genres.value += ','+cur.value;
						if(gquery == '') {
							gquery += 'FIND_IN_SET(\''+cur.value+'\',genre)>0';
						} else {
							gquery += ' OR FIND_IN_SET(\''+cur.value+'\',genre)>0';
						}
					} else {
						allgenres = false;
					}
				}
				if(allgenres){
					document.filterform.genres.value = '';
				} else {
					if(gquery==''){
						gquery='FIND_IN_SET(\',Action\',genre)>0';
					}
					query += '('+gquery+')';
				}
				if(f=='' && allgenres) query += '1';
				if(f!='' && !allgenres) query += ' AND ';
				rExp = /\'/gi;
				f = f.replace(rExp,'\\\'');
				if(f=='#'){
					document.filterform['filter'].value = query+'local REGEXP \'^[^a-zA-Z]\'';
					document.filterform.filtertitle.value = '#';
					typ = 'movies.name,aka';
				} else if(f=='?'){
					document.filterform['filter'].value = query+'(YEAR(inserted) = YEAR(CURRENT_DATE) AND MONTH(inserted) = MONTH(CURRENT_DATE))';
					document.filterform.filtertitle.value = '?';
				} else if((f.length == 1)&&(typ!='avail')&&(typ!='disks')){
					document.filterform['filter'].value = query+'local like \''+f+'%\'';
					document.filterform.filtertitle.value = f.toLowerCase();
					typ = 'movies.name,aka';
				} else if(f!=''){
					if(typ=='movies.name,aka') {
						document.filterform['filter'].value = query+'MATCH(movies.name,aka) AGAINST(\''+f+'\' IN BOOLEAN MODE)';
						document.filterform.filtertitle.value = f.toLowerCase();
					} else {
						document.filterform['filter'].value = query+typ+' like \'%'+f+'%\'';
						document.filterform['searchin'].value = typ;
					}
				} else {
					document.filterform['filter'].value = query;
					document.filterform.filtertitle.value = '*';
					typ = 'movies.name,aka';
				}
				document.filterform.page.value = '0';
				if(typ=='movies.name,aka') {
					document.filterform.type.options[document.filterform.type.selectedIndex].selected = false;
					document.filterform.type.options[0].selected = true;
					document.filterform['searchin'].value = typ;
				} else {
					document.filterform.filtertitle.value = '*';
				}
				// alert(document.filterform['filter'].value); //debug
				document.filterform.submit();
			}
			function sortby(s){
				var theBlank = s.indexOf('_');
				for(i=0; i<<?= $sortsize-1 ?>;i++)
					if(document.filterform['sortby['+i+']'].value.substring(0,theBlank) == s.substring(0,theBlank))
						break;
				for(i;i>0;i-=1)
					document.filterform['sortby['+i+']'].value = document.filterform['sortby['+(i-1)+']'].value;
				document.filterform['sortby[0]'].value = s.replace('_',' ');;
				document.filterform['sorter'].value = s;
				document.filterform.submit();
			}
			function showall(){
				document.filterform.genres.value = '';
				document.filterform['filter'].value = '';
				document.filterform.filtertitle.value = '*';
				document.filterform['tosearch'].value = '';
				document.filterform['searchin'].value = 'movies.name,aka';
				document.filterform.page.value = '0';
				document.filterform.submit();
			}
			function setpage(p){
				document.filterform.page.value = p;
				document.filterform.submit();
			}
			function show_film(t){
				resets_view();
				parent.window.document.film_view.src = film_on.src;
				document.filterform.page.value = t;
				document.filterform.view.value = 'film';
				document.filterform.submit();
			}
			function showOptions(f){
				var optionBox = document.getElementById('searchBox');
				var tmp = optionBox.style.visibility;
				if(f == '-'){
					if(tmp == '' || tmp == 'hidden'){
						f = 'on';
					} else {
						f = 'off';
					}
				}
				if(f == 'on'){
					optionBox.style.display = 'block';
					optionBox.style.visibility = 'visible';
				} else if(f == 'off'){
					optionBox.style.display = 'none';
					optionBox.style.visibility = 'hidden';
				}
			}
			function checkGenres(val){
				for(i=0;;i++){
					if(!(cur=document.getElementById('genres_'+i)))
						break;
					else
						cur.checked = val;
				}
			}
			function browseGenre(name){
				for(i=0;;i++){
					if(!(cur=document.getElementById('genres_'+i)))
						break;
					if(cur.value == name)
						cur.checked = true;
					else
						cur.checked = false;
				}
				tfilter('');
			}
			function submitenter(e){
				var keycode;
				if (window.event) keycode = window.event.keyCode;
				else if (e) keycode = e.which;
				else return true;
				if (keycode == 13){
					// tfilter(document.getElementById('title').value);
					tfilter(document.filterform.title.value,document.filterform.type.options[document.filterform.type.selectedIndex].value);
				}else return true;
			}
			function set_GET_edit(){
				if(!noframe){
					set_GET();
					parent.window.document.film_view.src=film_off.src;
				}
			}
			function set_GET(){
				parent.window.document.remember.page.value = document.filterform.page.value;
				parent.window.document.remember.view.value = document.filterform.view.value;
				parent.window.document.remember.filtertitle.value = document.filterform.filtertitle.value;
				parent.window.document.remember.filter.value = document.filterform.filter.value;
				parent.window.document.remember['sortby[0]'].value = document.filterform['sortby[0]'].value;
				parent.window.document.remember.sorter.value = document.filterform.sorter.value;
				parent.window.document.remember.genres.value = document.filterform.genres.value;
				parent.window.document.remember.tosearch.value = document.filterform.tosearch.value;
				parent.window.document.remember.searchin.value = document.filterform.searchin.value;
			}
			function set_MARK(fid,id,nx,avail){ 
				var tr = "r_" + nx + "_" + id; 
				var obj = document.getElementById(tr);
				var row = document.getElementById('o_'+fid);
				var cel = document.getElementById('p_'+fid);
				if(obj.style.backgroundImage==""||obj.style.backgroundImage=="none") {
					row.style.display = "table-row";
					cel.style.display = "table-cell";
					cel.style.fontSize = 100 + "%";
					if(avail==0||obj.style.backgroundColor=="rgb(255, 227, 219)") {
						obj.style.backgroundColor = "#ff867f";
						row.style.backgroundColor = "#ff867f";
					} else {
						obj.style.backgroundColor = "#97d599"; 
						row.style.backgroundColor = "#97d599"; 
					}
					obj.style.backgroundImage = "url(images/marked.png)";
					obj.style.backgroundRepeat = "repeat-x";
					document.getElementById('show_ON_'+id).style.display = "none";;
					document.getElementById('show_OFF_'+id).style.display = "block";;
				} else {
					cel.style.display = "none"; row.style.display = "none";
					if(avail==0||obj.style.backgroundColor=="rgb(255, 134, 127)") {
						obj.style.backgroundColor = "#ffe3db";
					} else {
						if(nx==0) {
							obj.style.backgroundColor = "#ebf3ff";
						} else {
							obj.style.backgroundColor = "#ffffff";
						}
					}
					obj.style.backgroundImage = "none";
					document.getElementById('show_OFF_'+id).style.display = "none";;
					document.getElementById('show_ON_'+id).style.display = "block";;
				}
			}			
		-->
		</script>
		<meta http-equiv="Content-Style-Type" content="text/css">
		<link rel="stylesheet" type="text/css" href="config/<?php if(eregi('Win',$_SERVER['HTTP_USER_AGENT'])) { echo "win"; } else { echo "oos"; } ?>.css">
		<style type="text/css">
		<!--
<? if(isset($_COOKIE['prefs'])) { ?>
			html, body, button, input, select, option, textarea {
				font-size: <?= $cfg['fontsize'] ?>em;
			}
			html, body {
				font-family:'<?= $cfg['fonttype'] ?>','Arial','Helvetica','sans-serif';
			}
<? } ?>
			a { outline: none; text-decoration: none; font-weight: bold; color: #333333; }
			a:hover { text-decoration: none; font-weight: bold; color: #336699; }
			td, th {
				padding: 2px 4px 2px 4px; 
				font-size: 86%; 
			}
			th { text-align: left; }
			.txt { font-size:100%; }
			.bit { padding: 4px 4px 4px 4px; }
			.pic { padding: 2px 2px 2px 2px; text-align: center; }
			h3 { font-size:150%; display:inline; text-shadow: grey 2px 2px 3px; }
			small { font-size:80%; }
			big { font-size:120%; }
			strong { color:#990000; }
			button  { 
				background-color:#ccc;
				background-image:url(images/button/pattern.png);
				background-repeat: repeat-x;
				background-position: bottom;
				padding: 0px 8px 0px 8px;
				cursor:pointer;
			}
			.active {
				background-color: #9DCFFF;
				background-image:url(images/table/col_on.png);
				background-repeat: repeat-x;
				background-position: center;
			}
			.passive {
				background-color: #ffffff;
				background-image:url(images/table/col_off.png);
				background-repeat: repeat-x;
				background-position: center;
			}
			.title_line { font-size:86%; }
			.nobreak { overflow: hidden; padding: 0; margin: 0;}
			.sub_line { font-size:75%; font-style:italic; color:#333333; }
			.row_na{ background-color: #ffe3db; background-image: none; }
			.row_0 { background-color: #EBF3FF; background-image: none; }
			.row_1 { background-color: #FFFFFF; background-image: none; }
			.poster { 
				margin:0px;
				display:inline;
				float:left;
				min-width:116px;
				min-height:180px;
				height:auto;
				text-align:center;
			}
			.edit {
				display: block;
				float: left;
				overflow: hidden;
				position: relative;
				left: 0px;
				height: 14px;
				width: 14px;
				top: -28px;
				padding: 0;
				margin: 0;
				margin-bottom: -14px;
			}
			.export {
				display: block;
				float: left;
				overflow: hidden;
				position: relative;
				left: 0px;
				height: 14px;
				width: 14px;
				top: -14px;
				padding: 0;
				margin: 0;
				margin-bottom: -14px;
			}
			#rank {
				display:inline;
				border:none;
			}
			#rank td {
				margin: 0px;
				padding: 0px;
			}
			#searchBox {
				display:none;
				visibility:hidden;
				font-size:86%;
			}
			#panel {
				position: fixed;
				bottom: 0px;
				left: 0px;
				width: 100%;
				height: auto;
				min-height: 16px;
				background-color: transparent;
				z-index:10;
				opacity: 0.9;
				padding: 0px;
				margin: 0px;
			}
			#guru {
				padding: 4px;
				width: 99%;
				height: auto;
				text-align: center;
				background-color: black;
			}
			#guru div {
				border: solid 3px red;
				padding: 4px;
				font-family: monospace;
				font-size: 100%;
				width: auto;
				height: auto;
				color: red;
				text-align: center;
				text-decoration: blink;
			}
		-->
		</style>
<!--[if (gt IE 6)&(lt IE 8)]>
		<link rel="stylesheet" type="text/css" href="config/iefixes.css">
		<script type="text/javascript" src="config/fixed.js"></script>
<![endif]-->
<!--[if lt IE 7]>
		<link rel="stylesheet" type="text/css" href="config/iefixes.css">
		<script type="text/javascript" src="config/fixed.js"></script>
		<style type="text/css">
		 img { behavior: url(config/iepngfix.htc); }
		</style>
<![endif]-->
	</head>
	<body onload="set_LogButton(); if(document.filterform.genres.value=='') checkGenres(true);" bgcolor="#ffffff" text="#333333" vlink="#333333" alink="#336699" link="#333333" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<noscript><div id="guru"><div><?= $trans['guru_noscript']?></div></div></noscript>
	<script type="text/javascript" language="JavaScript">
	<!--
	if(!window.XMLHttpRequest&&!window.ActiveXObject){document.writeln('<div id=\"guru\"><div><?= $trans['guru_noobject']?></div></div>');}
	if(mq_gpc!=0){document.writeln('<div id=\"guru\"><div><?= $trans['guru_mqgpcon']?></div></div>');}
	-->
	</script>
<? if($_POST['view']!='list') { ?>
		<table style="margin-bottom:4px; border-color:#D9D9D9;" bordercolor="#D9D9D9" border="1" frame="below" rules="cols" cellspacing="0" cellpadding="0" width="100%">
			<colgroup>
				<col width="2%">
				<col width="2%">
				<col width="8%">
				<col width="36%">
				<col width="8%">
				<col width="10%">
				<col width="12%">
				<col width="11%">
				<col width="11%">
			</colgroup>
			<thead><tr bgcolor="#ffffff" style="border-bottom:solid 1px #D9D9D9;">
<? if($_POST['sorter']=='avail_ASC'){ ?>
				<th class="active" nowrap>&nbsp;<a style="cursor:pointer;" title="<?= $trans['is_available']?>">?</a></th>
<? }else{ ?>
				<th class="passive" nowrap>&nbsp;<a style="cursor:pointer;" onclick="sortby('avail_ASC')" title="<?= $trans['is_available']?>">?</a></th>
<? } ?>
<? if($_POST['sorter']=='rating_DESC'){ ?>
				<th class="active" nowrap>&nbsp;<a style="cursor:pointer;" title="<?= $trans['imdb_rating']?>">!</a></th>
<? }else{ ?>
				<th class="passive" nowrap>&nbsp;<a style="cursor:pointer;" onclick="sortby('rating_DESC')" title="<?= $trans['imdb_rating']?>">!</a>&nbsp;</th>
<? } ?>
<? if(($_POST['sorter']=='nr_ASC')||($_POST['sorter']=='nr_DESC')){ ?>
				<th class="active" nowrap>
<? }else{ ?>
				<th class="passive" nowrap><a style="cursor:pointer;" onclick="sortby('nr_ASC')" title="<?= $trans['sort_to_asc']?>">ID</a></th>
<? } ?>
<? if($_POST['sorter']=='nr_DESC'){ ?>
					<img name="nr_ASC" onclick="sortby('nr_ASC')" onmouseover="swap('nr_ASC','asc_on')" onmouseout="swap('nr_ASC','asc_off')" align="right" src="images/table/asc_off.png" title="<?= $trans['sort_to_asc']?>" alt="asc" width="12" height="14" border="0">ID</th>
<? } ?>
<? if($_POST['sorter']=='nr_ASC'){ ?>
					<img name="nr_DESC" onclick="sortby('nr_DESC')" onmouseover="swap('nr_DESC','desc_on')" onmouseout="swap('nr_DESC','desc_off')" align="right" src="images/table/desc_off.png" title="<?= $trans['sort_to_desc']?>" alt="desc" width="12" height="14" border="0">ID</th>
<? } ?>
<? if(($_POST['sorter']=='local_ASC')||($_POST['sorter']=='local_DESC')||($_POST['sorter']=='name_ASC')||($_POST['sorter']=='name_DESC')){ ?>
				<th class="active" style="text-transform:capitalize" nowrap>
<? }else{ ?>
				<th class="passive" style="text-transform:capitalize" nowrap><?= $trans['t_title']?>&nbsp;<a style="cursor:pointer;" onclick="sortby('local_ASC')" title="<?= $trans['sort_to_asc']?>"><?= $trans['t_local']?></a>&nbsp;<a style="cursor:pointer;" onclick="sortby('name_ASC')" title="<?= $trans['sort_to_asc']?>"><?= $trans['t_original']?></a></th>
<? } ?>
<? if($_POST['sorter']=='local_DESC'){ ?>
					<img name="local_ASC" onclick="sortby('local_ASC')" onmouseover="swap('local_ASC','asc_on')" onmouseout="swap('local_ASC','asc_off')" align="right" src="images/table/asc_off.png" title="<?= $trans['sort_to_asc']?>" alt="asc" width="12" height="14" border="0"><?= $trans['t_title']?>&nbsp;<?= $trans['t_local']?>&nbsp;<a style="cursor:pointer; font-weight:normal;" onclick="sortby('name_ASC')" title="<?= $trans['sort_to_asc']?>"><?= $trans['t_original']?></a></th>
<? } ?>
<? if($_POST['sorter']=='local_ASC'){ ?>
					<img name="local_DESC" onclick="sortby('local_DESC')" onmouseover="swap('local_DESC','desc_on')" onmouseout="swap('local_DESC','desc_off')" align="right" src="images/table/desc_off.png" title="<?= $trans['sort_to_desc']?>" alt="desc" width="12" height="14" border="0"><?= $trans['t_title']?>&nbsp;<?= $trans['t_local']?>&nbsp;<a style="cursor:pointer; font-weight:normal;" onclick="sortby('name_ASC')" title="<?= $trans['sort_to_asc']?>"><?= $trans['t_original']?></a></th>
<? } ?>
<? if($_POST['sorter']=='name_DESC'){ ?>
					<img name="name_ASC" onclick="sortby('name_ASC')" onmouseover="swap('name_ASC','asc_on')" onmouseout="swap('name_ASC','asc_off')" align="right" src="images/table/asc_off.png" title="<?= $trans['sort_to_asc']?>" alt="asc" width="12" height="14" border="0"><?= $trans['t_title']?>&nbsp;<?= $trans['t_original']?>&nbsp;<a style="cursor:pointer; font-weight:normal;" onclick="sortby('local_ASC')" title="<?= $trans['sort_to_asc']?>"><?= $trans['t_local']?></a></th>
<? } ?>
<? if($_POST['sorter']=='name_ASC'){ ?>
					<img name="name_DESC" onclick="sortby('name_DESC')" onmouseover="swap('name_DESC','desc_on')" onmouseout="swap('name_DESC','desc_off')" align="right" src="images/table/desc_off.png" title="<?= $trans['sort_to_desc']?>" alt="desc" width="12" height="14" border="0"><?= $trans['t_title']?>&nbsp;<?= $trans['t_original']?>&nbsp;<a style="cursor:pointer; font-weight:normal;" onclick="sortby('local_ASC')" title="<?= $trans['sort_to_asc']?>"><?= $trans['t_local']?></a></th>
<? } ?>
<? if(($_POST['sorter']=='year_ASC')||($_POST['sorter']=='year_DESC')){ ?>
				<th class="active" style="text-transform:capitalize" nowrap>
<? }else{ ?>
				<th class="passive" style="text-transform:capitalize" nowrap><a style="cursor:pointer;" onclick="sortby('year_ASC')" title="<?= $trans['sort_to_asc']?>"><?= $trans['t_year']?></a></th>
<? } ?>
<? if($_POST['sorter']=='year_DESC'){ ?>
					<img name="year_ASC" onclick="sortby('year_ASC')" onmouseover="swap('year_ASC','asc_on')" onmouseout="swap('year_ASC','asc_off')" align="right" src="images/table/asc_off.png" title="<?= $trans['sort_to_asc']?>" alt="asc" width="12" height="14" border="0"><?= $trans['t_year']?></th>
<? } ?>
<? if($_POST['sorter']=='year_ASC'){ ?>
					<img name="year_DESC" onclick="sortby('year_DESC')" onmouseover="swap('year_DESC','desc_on')" onmouseout="swap('year_DESC','desc_off')" align="right" src="images/table/desc_off.png" title="<?= $trans['sort_to_desc']?>" alt="desc" width="12" height="14" border="0"><?= $trans['t_year']?></th>
<? } ?>
<? if(($_POST['sorter']=='runtime_ASC')||($_POST['sorter']=='runtime_DESC')){ ?>
				<th class="active" style="text-transform:capitalize" nowrap>
<? }else{ ?>
				<th class="passive" style="text-transform:capitalize" nowrap><a style="cursor:pointer;" onclick="sortby('runtime_ASC')" title="<?= $trans['sort_to_asc']?>"><?= $trans['t_runtime']?></a></th>
<? } ?>
<? if($_POST['sorter']=='runtime_DESC'){ ?>
					<img name="runtime_ASC" onclick="sortby('runtime_ASC')" onmouseover="swap('runtime_ASC','asc_on')" onmouseout="swap('runtime_ASC','asc_off')" align="right" src="images/table/asc_off.png" title="<?= $trans['sort_to_asc']?>" alt="asc" width="12" height="14" border="0"><?= $trans['t_runtime']?></th>
<? } ?>
<? if($_POST['sorter']=='runtime_ASC'){ ?>
					<img name="runtime_DESC" onclick="sortby('runtime_DESC')" onmouseover="swap('runtime_DESC','desc_on')" onmouseout="swap('runtime_DESC','desc_off')" align="right" src="images/table/desc_off.png" title="<?= $trans['sort_to_desc']?>" alt="desc" width="12" height="14" border="0"><?= $trans['t_runtime']?></th>
<? } ?>
<? if(($_POST['sorter']=='medium_ASC')||($_POST['sorter']=='medium_DESC')){ ?>
				<th class="active" style="text-transform:capitalize" nowrap>
<? }else{ ?>
				<th class="passive" style="text-transform:capitalize" nowrap><a style="cursor:pointer;" onclick="sortby('medium_ASC')" title="<?= $trans['sort_to_asc']?>"><?= $trans['t_medium']?></a></th>
<? } ?>
<? if($_POST['sorter']=='medium_DESC'){ ?>
					<img name="medium_ASC" onclick="sortby('medium_ASC')" onmouseover="swap('medium_ASC','asc_on')" onmouseout="swap('medium_ASC','asc_off')" align="right" src="images/table/asc_off.png" title="<?= $trans['sort_to_asc']?>" alt="asc" width="12" height="14" border="0"><?= $trans['t_medium']?></th>
<? } ?>
<? if($_POST['sorter']=='medium_ASC'){ ?>
					<img name="medium_DESC" onclick="sortby('medium_DESC')" onmouseover="swap('medium_DESC','desc_on')" onmouseout="swap('medium_DESC','desc_off')" align="right" src="images/table/desc_off.png" title="<?= $trans['sort_to_desc']?>" alt="desc" width="12" height="14" border="0"><?= $trans['t_medium']?></th>
<? } ?>
<? if(($_POST['sorter']=='inserted_ASC')||($_POST['sorter']=='inserted_DESC')){ ?>
				<th class="active" style="text-transform:capitalize" nowrap>
<? }else{ ?>
				<th class="passive" style="text-transform:capitalize" nowrap><a style="cursor:pointer;" onclick="sortby('inserted_DESC')" title="<?= $trans['sort_to_desc']?>"><?= $trans['t_since']?></a></th>
<? } ?>
<? if($_POST['sorter']=='inserted_DESC'){ ?>
					<img name="inserted_ASC" onclick="sortby('inserted_ASC')" onmouseover="swap('inserted_ASC','asc_on')" onmouseout="swap('inserted_ASC','asc_off')" align="right" src="images/table/asc_off.png" title="<?= $trans['sort_to_asc']?>" alt="asc" width="12" height="14" border="0"><?= $trans['t_since']?></th>
<? } ?>
<? if($_POST['sorter']=='inserted_ASC'){ ?>
					<img name="inserted_DESC" onclick="sortby('inserted_DESC')" onmouseover="swap('inserted_DESC','desc_on')" onmouseout="swap('inserted_DESC','desc_off')" align="right" src="images/table/desc_off.png" title="<?= $trans['sort_to_desc']?>" alt="desc" width="12" height="14" border="0"><?= $trans['t_since']?></th>
<? } ?>
<? if($_POST['sorter']=='poster_ASC'){ ?>
				<th class="active" style="text-transform:capitalize" nowrap><a style="cursor:pointer;" title="<?= $trans['imdb_poster']?>"><?= $trans['t_poster']?></a></th>
<? }else{ ?>
				<th class="passive" style="text-transform:capitalize" nowrap><a style="cursor:pointer;" onclick="sortby('poster_ASC')" title="<?= $trans['imdb_poster']?>"><?= $trans['t_poster']?></a></th>
<? } ?>
			</tr></thead>
		</table>
<? } ?>
<? if($_POST['view']=='film') { /* FILM-VIEW */ ?>
		<table border="0" style="border-color:#D9D9D9;" cellspacing="0" cellpadding="2" width="100%">
<?
$brow = true;
while($row = mysql_fetch_array($result)){
	$directors = ''; $actors = ''; $writers = ''; $tmp = $trans['show_imdbperson'];
	getpeople($directors,'directs',$row['fid'],$tmp,', ');
	getpeople($writers,'writes',$row['fid'],$tmp,', ');
	getpeople($actors,'plays_in',$row['fid'],$tmp,', ');
?>
			<tr><td class="bit" width="100" valign="top" align="center">
					<img src="images/space.gif" width="100" height="1" border="0">
					<a title="<?= $trans['show_imdbpage']?>" href="http://www.imdb.com/title/tt<?= $row['id']?>" target="_blank"><img src="imgget.php?for=<?= $row['fid']?>" align="center" width="95" height="140" border="0"></a>
					<img class="export" title="<?= $trans['export_moviedata']?>" onClick="fill_Request('editreq');show_Request(true,'editreq','exportfilm.php?fid=<?= $row['fid']?>&title=<?= rawurlencode($row['name'])?>&local=<?= rawurlencode($row['local'])?>');" name="export_<?= $i ?>" src="images/table/export_off.png" onmouseover="swap('export_<?= $i ?>','export_on')" onmouseout="swap('export_<?= $i ?>','export_off')" alt="export" width="14" height="14" border="0">
					<br><br>
					<b>ID <?= '['.$row['nr'].']' ?></b>
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
					<br><br>
<? if(isset($_SESSION['user'])) { ?>
					<a onclick="set_GET_edit();" onmouseover="parent.window.status=' ';return true;" href="edit.php?fid=<?= $row['fid']?>"><button name="edit" type="button" value="EDIT" style="cursor:pointer;">&nbsp;<b><?= $trans['b_edit']?></b>&nbsp;</button></a>
<? } else { ?>
					<button name="edit" type="button" value="EDIT" onClick="show_Request(att_pic + '<?= $trans['alert_title'].$trans['login_alert']?>','textreq','')">&nbsp;<b><?= $trans['b_edit']?></b>&nbsp;</button>

<? } ?>		</td><td class="bit" rowspan="2" valign="top" width="100%">
				<table frame="box" rules="cols" style="border-color:#D9D9D9;" border="0" cellspacing="0" cellpadding="2" width="100%"><tr>
					<td style="text-transform:capitalize" valign="top" align="right" valign="bottom" nowrap><big><?= $trans['t_original']?>&nbsp;<b><?= $trans['t_title']?></b></big>:</td>
					<td class="row_1" width="100%"><h3><?= $row['name'].' ('.$row['year'].')' ?></h3></td>
				</tr><tr>
					<td style="text-transform:capitalize" valign="top" align="right" nowrap><big><?= $trans['t_local'] ?>&nbsp;<b><?= $trans['t_title'] ?></b>:</big></td>
					<td class="row_0" width="100%"><big><b><?= $row['local'] ?></b></big></td>
				</tr><tr>
					<td style="text-transform:capitalize" valign="top" align="right" nowrap><big><?= $trans['t_alias'] ?>&nbsp;<b><?= $trans['t_title'] ?></b>:</big></td>
					<td class="row_1" width="100%"><big><?= str_replace("\n",'&bull; ',$row['aka']) ?></big></td>
<? if($row['avail']!='1'){ ?>
				</tr><tr>
					<td style="text-transform:capitalize; color:#666666;" valign="top" align="right" nowrap><big><b><?= $trans['t_lent']?></b></big></td>
					<td class="row_na" width="100%"><big><?= $trans['t_to'].' "<b>'.$lenton[$row['lentto']].'</b>" '.$trans['t_at'].' '.substr($row['lentsince'], -2, 2).'-'.$trans[substr($row['lentsince'], 5, 2)].'-'.substr($row['lentsince'], 0, 4) ?></big></td>
<? } ?>
				</tr><tr>
					<td style="text-transform:capitalize" valign="top" align="right" nowrap><big><b><?= $trans['t_rating']?>:</b></big></td>
					<td style="background-color:#EBF3FF;" width="100%"><table id="rank" height="15" border="0" cellspacing="0" cellpadding="0"><tr><td width="4" height="15"><img  src="images/rank/left_r.png" alt="<" width="4" height="15" border="0"></td><td width="100" height="15" background="images/rank/grnd_r.png" nowrap><img  src="images/rank/fg_r.png" alt="-" width="<?= $row['rating'] ?>" height="15" border="0"><img  src="images/space.gif" width="<?= 100-$row['rating'] ?>" height="15" border="0"></td><td width="4" height="15"><img  src="images/rank/right_r.png" alt=">" width="4" height="15" border="0"></td><td height="15" nowrap>&nbsp;<big><?= $row['rating'] ?>&nbsp;<?= $trans['x_of_x'] ?>&nbsp;100</big></td></tr></table></td>
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
					<td class="row_0" width="100%"><div style="-moz-column-width: 8em; -moz-column-count: 3; -moz-column-gap: 1em;"><big><?= $actors?></big></div></td>
				</tr><tr>
					<td style="text-transform:capitalize" valign="top" align="right" nowrap><big><b><?= $trans['t_medium']?>:</b></big></td>
					<td class="row_1" width="100%"><big><?= $row['disks'].' x '.$row['medium'].' ['.$row['type'].'] ('.$row['container'].' '.$trans['t_container'].')' ?></big></td>
				</tr><tr>
					<td style="text-transform:capitalize" valign="top" align="right" nowrap><big><b><?= $trans['t_video']?>:</b></big></td>
					<td class="row_0" width="100%"><big><?= $row['video'].' &bull; '.$row['width'].'x'.$row['height'].' &bull; '.$row['format'].' &bull; '.$row['ratio']?></big></td>
				</tr><tr>
					<td style="text-transform:capitalize" valign="top" align="right" nowrap><big><b><?= $trans['t_audio']?>:</b></big></td>
					<td class="row_1" width="100%"><big><?= $row['audio'].' &bull; '.$trans[$row['channel']].' &bull; '.$row['herz'].' KHz' ?></big></td>
				</tr><tr>
					<td style="text-transform:capitalize" valign="top" align="right" nowrap><big><b><?= $trans['t_date']?>:</b></big></td>
					<td class="row_0" width="100%"><big><?= substr($row['inserted'], -2, 2).'-'.$trans[substr($row['inserted'], 5, 2)].'-'.substr($row['inserted'], 0, 4) ?></big></td>
<? if($row['comment']!=''){ ?>
				</tr><tr>
					<td style="text-transform:capitalize" valign="top" align="right" nowrap><big><b><?= $trans['t_comment']?>:</b></big></td>
					<td class="row_1" width="100%"><big><?= $row['comment']?></big></td>
<? } ?>
				</tr></table>
			</td></tr>
			<tr><td valign="bottom" align="center">
			</td></tr>
<?
	$brow = !$brow;
}
if($rowcount==0){
	echo '				<tr><td class="bit" bgcolor="#ffe3db" colspan="2" align="center"><b>'.$trans['no_matches'].'</b></td></tr>'."\n";
}
?>
		</table>
		<br>
<? }else if($_POST['view']=='row') { /* ROW-VIEW */ ?>
		<table border="0" style="border-color:#D9D9D9;" bordercolor="#D9D9D9" cellspacing="0" cellpadding="2" width="100%">
<?
$brow = true; $pge = ((integer)$_POST['page']); $foo = 0; $i = 0;
while($row = mysql_fetch_array($result)){
	$i++; $foo = $pge + $i; $k = '';
	$directors = ''; $actors = ''; $writers = ''; $tmp = $trans['show_imdbperson'];
	getpeople($directors,'directs',$row['fid'],$tmp,', ');
	getpeople($actors,'plays_in',$row['fid'],$tmp,', ');
	getpeople($writers,'writes',$row['fid'],$tmp,', ');
	$l=explode(",",$row['lang']); for($x=0;$x<count($l);$x++){ $k .= $trans[$l[$x]]." "; }
?>
			<tr><td class="bit" valign="top" align="center" width="100">
				<img src="images/space.gif" width="100" height="1" border="0">
				<a title="<?= $trans['show_imdbpage']?>" href="http://www.imdb.com/title/tt<?= $row['id']?>" target="_blank"><img src="imgget.php?for=<?= $row['fid']?>" align="center" width="95" height="140" border="0"></a>
				<img class="export" title="<?= $trans['export_moviedata']?>" onClick="fill_Request('editreq');show_Request(true,'editreq','exportfilm.php?fid=<?= $row['fid']?>&title=<?= rawurlencode($row['name'])?>&local=<?= rawurlencode($row['local'])?>');" name="export_<?= $i ?>" src="images/table/export_off.png" onmouseover="swap('export_<?= $i ?>','export_on')" onmouseout="swap('export_<?= $i ?>','export_off')" alt="export" width="14" height="14" border="0">
<? if(isset($_SESSION['user'])) { ?>
				<a onclick="set_GET_edit();" onmouseover="parent.window.status=' ';return true;" href="edit.php?fid=<?= $row['fid']?>"><button name="edit" type="button" value="EDIT" style="margin-top:2px;">&nbsp;<b><?= $trans['b_edit']?></b>&nbsp;</button></a>
<? } ?>
			</td><td class="bit" valign="top" width="100%">
				<table style="border-bottom:solid 1px #D9D9D9;border-color:#D9D9D9;" frame="box" rules="cols" bordercolor="#D9D9D9" border="0" cellspacing="0" cellpadding="2" width="100%"><tr>
					<td style="text-transform:capitalize" valign="top" align="right" bgcolor="#f0f0f0" nowrap><?= $trans['t_original']?>&nbsp;<big><b><?= $trans['t_title']?></b></big>:</td>
					<td width="100%"><big><a title="<?= $trans['show_moviedata']?>" style="cursor:pointer;" onclick="show_film('<?= $foo-1 ?>');"><?= $row['name'].' ('.$row['year'].')' ?></a></big></td>
				</tr><tr>
					<td style="text-transform:capitalize" valign="top" align="right" bgcolor="#eeeeee" nowrap><?= $trans['t_local'] ?>&nbsp;<b><?= $trans['t_title'] ?></b>:</td>
					<td class="row_0" width="100%"><b><?= $row['local'] ?></b></td>
				</tr><tr>
					<td style="text-transform:capitalize" valign="top" align="right" bgcolor="#eeeeee" nowrap><?= $trans['t_alias'] ?>&nbsp;<b><?= $trans['t_title'] ?></b>:</td>
					<td width="100%"><?= str_replace("\n",'&bull; ',$row['aka']) ?></td>
<? if($row['avail']!='1'){ ?>
				</tr><tr>
					<td style="text-transform:uppercase; color:#666666;" bgcolor="#eeeeee" valign="top" align="right" nowrap><b><?= $trans['t_lent']?></b></td>
					<td class="row_na" width="100%"><?= $trans['t_to'].' "<b>'.$lenton[$row['lentto']].'</b>" '.$trans['t_at'].' '.substr($row['lentsince'], -2, 2).'-'.$trans[substr($row['lentsince'], 5, 2)].'-'.substr($row['lentsince'], 0, 4) ?></td>
<? } ?>
				</tr><tr>
					<td style="text-transform:uppercase" valign="top" align="right" bgcolor="#eeeeee" nowrap><?= $trans['t_filminfo']?>:</td>
					<td class="row_0" width="100%"><?= '['.$row['nr'].'] &bull; '.$row['country'].' &bull; '.$row['year'].' &bull; '.$row['runtime'].'&nbsp;'.$trans['t_minutes'].' &bull; '.$k.'&bull; '.$row['rating'].' '.$trans['x_of_x'].' 100 &bull; '.substr($row['inserted'], -2, 2).'-'.$trans[substr($row['inserted'], 5, 2)].'-'.substr($row['inserted'], 0, 4) ?></td>
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
					<td width="100%"><div style="-moz-column-width: 6em; -moz-column-count: 4; -moz-column-gap: 1em;"><?= $actors ?></div></td>
<? if($row['comment']!=''){ ?>
				</tr><tr>
					<td style="text-transform:uppercase" valign="top" align="right" bgcolor="#eeeeee" nowrap><?= $trans['t_comment']?>:</td>
					<td class="row_0" width="100%"><?= $row['comment']?></td>
<? } ?>
				</tr></table>
			</td></tr><tr><td colspan="2"></td></tr>
<?
	$brow = !$brow;
}
if($rowcount==0){
	echo '				<tr><td class="bit" bgcolor="#ffe3db" colspan="2" align="center"><b>'.$trans['no_matches'].'</b></td></tr>'."\n";
}
?>
		</table>
		<br>
<? }else if($_POST['view']=='poster') { /* POSTER-VIEW */ ?>
<?
$brow = true; $pge = ((integer)$_POST['page']); $foo = 0; $i = 0;
while($row = mysql_fetch_array($result)){
	$i++; $foo = $pge + $i;
?>
		<table class="poster" width="116" height="180" border="0" cellspacing="0" cellpadding="0">
			<tr><td valign="bottom" class="pic" align="center" width="116" height="140"><a title="<?= $trans['show_imdbpage']?>" href="http://www.imdb.com/title/tt<?= $row['id']?>" target="_blank">
			<img src="imgget.php?for=<?= $row['fid']?>" width="95" height="140" border="0"></a>
			<img class="export" title="<?= $trans['export_moviedata']?>" onClick="fill_Request('editreq');show_Request(true,'editreq','exportfilm.php?fid=<?= $row['fid']?>&title=<?= rawurlencode($row['name'])?>&local=<?= rawurlencode($row['local'])?>');" name="export_<?= $i ?>" src="images/table/export_off.png" onmouseover="swap('export_<?= $i ?>','export_on')" onmouseout="swap('export_<?= $i ?>','export_off')" alt="export" width="14" height="14" border="0">
<? if(isset($_SESSION['user'])) { ?>
			<a href="edit.php?fid=<?= $row['fid']?>" onmouseover="parent.window.status=' ';return true;" title="<?= $trans['edit_moviedata']?>" style="cursor:pointer;" onclick="set_GET_edit();"><img class="edit" name="edit_<?= $i ?>" src="images/table/edit_off.png" onmouseover="swap('edit_<?= $i ?>','edit_on')" onmouseout="swap('edit_<?= $i ?>','edit_off')" alt="edit" width="14" height="14" border="0"></a>
<? } ?>
			</td></tr>
			<tr><td valign="top" class="pic" <? if($row['avail']!='1'){ echo 'bgcolor="#ffe3db"'; } ?> align="center" height="40"><a title="<?= $trans['show_moviedata']?>" style="cursor:pointer;" onclick="show_film('<?= $foo-1 ?>');"><small style="line-height:95%;"><? if(($_POST['sorter']=='name_ASC')||($_POST['sorter']=='name_DESC')){ echo $row['name']; }else{ echo $row['local']; }?></small></a></td></tr>
		</table>
<?
	$brow = !$brow;
}
if($rowcount==0){
	echo '			<table border="0" cellspacing="0" cellpadding="0" width="100%">'."\n";
	echo '				<tr><td class="bit" bgcolor="#ffe3db" colspan="7" align="center"><b>'.$trans['no_matches'].'</b></td></tr>'."\n";
	echo '			</table>'."\n";
} else {
	echo '		<br style="clear:left;" clear="all"><br>'."\n";
}
?>
<? } else { /* LIST-VIEW */ ?>
		<table border="1" style="border-color:#D9D9D9;" bordercolor="#D9D9D9" frame="void" rules="cols" cellspacing="0" cellpadding="0" width="100%">
			<colgroup>
				<col width="1%">
				<col width="1%">
				<col width="5%">
				<col width="36%">
				<col width="14%">
				<col width="4%">
				<col width="8%">
				<col width="8%">
				<col width="12%">
				<col width="9%">
				<col width="2%">
			</colgroup>
			<thead><tr bgcolor="#ffffff" style="border-bottom:solid 1px #D9D9D9;">
<? if($_POST['sorter']=='avail_ASC'){ ?>
				<th class="active" nowrap>&nbsp;<a style="cursor:pointer;" title="<?= $trans['is_available']?>">?</a></th>
<? }else{ ?>
				<th class="passive" nowrap>&nbsp;<a style="cursor:pointer;" onclick="sortby('avail_ASC')" title="<?= $trans['is_available']?>">?</a></th>
<? } ?>
<? if($_POST['sorter']=='rating_DESC'){ ?>
				<th class="active" nowrap>&nbsp;<a style="cursor:pointer;" title="<?= $trans['imdb_rating']?>">!</a></th>
<? }else{ ?>
				<th class="passive" nowrap>&nbsp;<a style="cursor:pointer;" onclick="sortby('rating_DESC')" title="<?= $trans['imdb_rating']?>">!</a></th>
<? } ?>
<? if(($_POST['sorter']=='nr_ASC')||($_POST['sorter']=='nr_DESC')){ ?>
				<th class="active" nowrap>
<? }else{ ?>
				<th class="passive" nowrap><a style="cursor:pointer;" onclick="sortby('nr_ASC')" title="<?= $trans['sort_asc']?>">ID</a></th>
<? } ?>
<? if($_POST['sorter']=='nr_DESC'){ ?>
					<img name="nr_ASC" onclick="sortby('nr_ASC')" onmouseover="swap('nr_ASC','asc_on')" onmouseout="swap('nr_ASC','asc_off')" align="right" src="images/table/asc_off.png" title="<?= $trans['sort_asc']?>" alt="asc" width="12" height="14" border="0">ID</th>
<? } ?>
<? if($_POST['sorter']=='nr_ASC'){ ?>
					<img name="nr_DESC" onclick="sortby('nr_DESC')" onmouseover="swap('nr_DESC','desc_on')" onmouseout="swap('nr_DESC','desc_off')" align="right" src="images/table/desc_off.png" title="<?= $trans['sort_desc']?>" alt="desc" width="12" height="14" border="0">ID</th>
<? } ?>
<? if(($_POST['sorter']=='local_ASC')||($_POST['sorter']=='local_DESC')||($_POST['sorter']=='name_ASC')||($_POST['sorter']=='name_DESC')){ ?>
				<th class="active" style="text-transform:capitalize" nowrap>
<? }else{ ?>
				<th class="passive" style="text-transform:capitalize" nowrap><?= $trans['t_title']?>&nbsp;<a style="cursor:pointer;" onclick="sortby('local_ASC')" title="<?= $trans['sort_asc']?>"><?= $trans['t_local']?></a>&nbsp;<a style="cursor:pointer;" onclick="sortby('name_ASC')" title="<?= $trans['sort_asc']?>"><?= $trans['t_original']?></a></th>
<? } ?>
<? if($_POST['sorter']=='local_DESC'){ ?>
					<img name="local_ASC" onclick="sortby('local_ASC')" onmouseover="swap('local_ASC','asc_on')" onmouseout="swap('local_ASC','asc_off')" align="right" src="images/table/asc_off.png" title="<?= $trans['sort_asc']?>" alt="asc" width="12" height="14" border="0"><?= $trans['t_title']?>&nbsp;<?= $trans['t_local']?>&nbsp;<a style="cursor:pointer; font-weight:normal; font-style:italic;" onclick="sortby('name_ASC')" title="<?= $trans['sort_asc']?>"><?= $trans['t_original']?></a></th>
<? } ?>
<? if($_POST['sorter']=='local_ASC'){ ?>
					<img name="local_DESC" onclick="sortby('local_DESC')" onmouseover="swap('local_DESC','desc_on')" onmouseout="swap('local_DESC','desc_off')" align="right" src="images/table/desc_off.png" title="<?= $trans['sort_desc']?>" alt="desc" width="12" height="14" border="0"><?= $trans['t_title']?>&nbsp;<?= $trans['t_local']?>&nbsp;<a style="cursor:pointer; font-weight:normal; font-style:italic;" onclick="sortby('name_ASC')" title="<?= $trans['sort_asc']?>"><?= $trans['t_original']?></a></th>
<? } ?>
<? if($_POST['sorter']=='name_DESC'){ ?>
					<img name="name_ASC" onclick="sortby('name_ASC')" onmouseover="swap('name_ASC','asc_on')" onmouseout="swap('name_ASC','asc_off')" align="right" src="images/table/asc_off.png" title="<?= $trans['sort_asc']?>" alt="asc" width="12" height="14" border="0"><?= $trans['t_title']?>&nbsp;<?= $trans['t_original']?>&nbsp;<a style="cursor:pointer; font-weight:normal; font-style:italic;" onclick="sortby('local_ASC')" title="<?= $trans['sort_asc']?>"><?= $trans['t_local']?></a></th>
<? } ?>
<? if($_POST['sorter']=='name_ASC'){ ?>
					<img name="name_DESC" onclick="sortby('name_DESC')" onmouseover="swap('name_DESC','desc_on')" onmouseout="swap('name_DESC','desc_off')" align="right" src="images/table/desc_off.png" title="<?= $trans['sort_desc']?>" alt="desc" width="12" height="14" border="0"><?= $trans['t_title']?>&nbsp;<?= $trans['t_original']?>&nbsp;<a style="cursor:pointer; font-weight:normal; font-style:italic;" onclick="sortby('local_ASC')" title="<?= $trans['sort_asc']?>"><?= $trans['t_local']?></a></th>
<? } ?>
				<th class="passive" style="text-transform:capitalize" nowrap><?= $trans['t_director']?></th>
				<th class="passive" style="text-transform:capitalize" nowrap><?= $trans['t_country']?></th>
<? if(($_POST['sorter']=='year_ASC')||($_POST['sorter']=='year_DESC')){ ?>
				<th class="active" style="text-transform:capitalize" nowrap>
<? }else{ ?>
				<th class="passive" style="text-transform:capitalize" nowrap><a style="cursor:pointer;" onclick="sortby('year_ASC')" title="<?= $trans['sort_asc']?>"><?= $trans['t_year']?></a></th>
<? } ?>
<? if($_POST['sorter']=='year_DESC'){ ?>
					<img name="year_ASC" onclick="sortby('year_ASC')" onmouseover="swap('year_ASC','asc_on')" onmouseout="swap('year_ASC','asc_off')" align="right" src="images/table/asc_off.png" title="<?= $trans['sort_asc']?>" alt="asc" width="12" height="14" border="0"><?= $trans['t_year']?></th>
<? } ?>
<? if($_POST['sorter']=='year_ASC'){ ?>
					<img name="year_DESC" onclick="sortby('year_DESC')" onmouseover="swap('year_DESC','desc_on')" onmouseout="swap('year_DESC','desc_off')" align="right" src="images/table/desc_off.png" title="<?= $trans['sort_desc']?>" alt="desc" width="12" height="14" border="0"><?= $trans['t_year']?></th>
<? } ?>
<? if(($_POST['sorter']=='runtime_ASC')||($_POST['sorter']=='runtime_DESC')){ ?>
				<th class="active" style="text-transform:capitalize" nowrap>
<? }else{ ?>
				<th class="passive" style="text-transform:capitalize" nowrap><a style="cursor:pointer;" onclick="sortby('runtime_ASC')" title="<?= $trans['sort_asc']?>"><?= $trans['t_runtime']?></a></th>
<? } ?>
<? if($_POST['sorter']=='runtime_DESC'){ ?>
					<img name="runtime_ASC" onclick="sortby('runtime_ASC')" onmouseover="swap('runtime_ASC','asc_on')" onmouseout="swap('runtime_ASC','asc_off')" align="right" src="images/table/asc_off.png" title="<?= $trans['sort_asc']?>" alt="asc" width="12" height="14" border="0"><?= $trans['t_runtime']?></th>
<? } ?>
<? if($_POST['sorter']=='runtime_ASC'){ ?>
					<img name="runtime_DESC" onclick="sortby('runtime_DESC')" onmouseover="swap('runtime_DESC','desc_on')" onmouseout="swap('runtime_DESC','desc_off')" align="right" src="images/table/desc_off.png" title="<?= $trans['sort_desc']?>" alt="desc" width="12" height="14" border="0"><?= $trans['t_runtime']?></th>
<? } ?>
<? if(($_POST['sorter']=='medium_ASC')||($_POST['sorter']=='medium_DESC')){ ?>
				<th class="active" style="text-transform:capitalize" nowrap>
<? }else{ ?>
				<th class="passive" style="text-transform:capitalize" nowrap><a style="cursor:pointer;" onclick="sortby('medium_ASC')" title="<?= $trans['sort_asc']?>"><?= $trans['t_medium']?></a></th>
<? } ?>
<? if($_POST['sorter']=='medium_DESC'){ ?>
					<img name="medium_ASC" onclick="sortby('medium_ASC')" onmouseover="swap('medium_ASC','asc_on')" onmouseout="swap('medium_ASC','asc_off')" align="right" src="images/table/asc_off.png" title="<?= $trans['sort_asc']?>" alt="asc" width="12" height="14" border="0"><?= $trans['t_medium']?></th>
<? } ?>
<? if($_POST['sorter']=='medium_ASC'){ ?>
					<img name="medium_DESC" onclick="sortby('medium_DESC')" onmouseover="swap('medium_DESC','desc_on')" onmouseout="swap('medium_DESC','desc_off')" align="right" src="images/table/desc_off.png" title="<?= $trans['sort_desc']?>" alt="desc" width="12" height="14" border="0"><?= $trans['t_medium']?></th>
<? } ?>
<? if(($_POST['sorter']=='inserted_ASC')||($_POST['sorter']=='inserted_DESC')){ ?>
				<th class="active" style="text-transform:capitalize" nowrap>
<? }else{ ?>
				<th class="passive" style="text-transform:capitalize" nowrap><a style="cursor:pointer;" onclick="sortby('inserted_DESC')" title="<?= $trans['sort_desc']?>"><?= $trans['t_since']?></a></th>
<? } ?>
<? if($_POST['sorter']=='inserted_DESC'){ ?>
					<img name="inserted_ASC" onclick="sortby('inserted_ASC')" onmouseover="swap('inserted_ASC','asc_on')" onmouseout="swap('inserted_ASC','asc_off')" align="right" src="images/table/asc_off.png" title="<?= $trans['sort_asc']?>" alt="asc" width="12" height="14" border="0"><?= $trans['t_since']?></th>
<? } ?>
<? if($_POST['sorter']=='inserted_ASC'){ ?>
					<img name="inserted_DESC" onclick="sortby('inserted_DESC')" onmouseover="swap('inserted_DESC','desc_on')" onmouseout="swap('inserted_DESC','desc_off')" align="right" src="images/table/desc_off.png" title="<?= $trans['sort_desc']?>" alt="desc" width="12" height="14" border="0"><?= $trans['t_since']?></th>
<? } ?>
<? if($_POST['sorter']=='poster_ASC'){ ?>
				<th class="active" nowrap>&nbsp;<a style="cursor:pointer;" title="<?= $trans['imdb_poster']?>">*</a></th>
<? }else{ ?>
				<th class="passive" nowrap>&nbsp;<a style="cursor:pointer;" onclick="sortby('poster_ASC')" title="<?= $trans['imdb_poster']?>">*</a></th>
<? } ?>
			</tr></thead>
			<tbody>
<?
$brow = true; $pge = ((integer)$_POST['page']); $foo = 0; $i = 0; $nr = 0;
while($row = mysql_fetch_array($result)){
	$director = ''; directorsearch($director,$row['fid']);
	$i++; $foo = $pge + $i; $k = ''; $nr = $brow?'0':'1';
	$directors = ''; $actors = ''; $writers = ''; $tmp = $trans['show_imdbperson'];
	getpeople($directors,'directs',$row['fid'],$tmp,', ');
	getpeople($actors,'plays_in',$row['fid'],$tmp,', ');
	getpeople($writers,'writes',$row['fid'],$tmp,', ');
	$l=explode(",",$row['lang']); for($x=0;$x<count($l);$x++){ $k .= $trans[$l[$x]]." "; }
	
if(isset($_SESSION['user'])) { if($row['avail']!='1') { ?>
				<tr class="row_na" id="r_<?= $nr ?>_<?= $i ?>">
					<td align="center" id="c_<?= $i ?>" nowrap><img onclick="fill_Request('editreq');show_Request(true,'editreq','editlent.php?fid=<?= $row['fid'].'&id='.$i.'&nx='.$nr ?>');" name="avail_<?= $i ?>" title="<?= $trans['t_lent'].' '.$trans['t_to'].' '.$lenton[$row['lentto']].' '.$trans['t_at'].' '.substr($row['lentsince'], -2, 2).'-'.$trans[substr($row['lentsince'], 5, 2)].'-'.substr($row['lentsince'], 0, 4) ?>" src="images/table/avail_no.png" onmouseover="swap('avail_<?= $i ?>','avail_on')" onmouseout="swap('avail_<?= $i ?>','avail_no')" alt="-" width="14" height="14" border="0"></td>
<? }else { ?>
				<tr class="row_<?= $nr ?>" id="r_<?= $nr ?>_<?= $i ?>">
					<td align="center" id="c_<?= $i ?>" nowrap><img onclick="fill_Request('editreq');show_Request(true,'editreq','editlent.php?fid=<?= $row['fid'].'&id='.$i.'&nx='.$nr ?>');" name="avail_<?= $i ?>" title="<?= $trans['available'] ?>" src="images/table/avail_is.png" onmouseover="swap('avail_<?= $i ?>','avail_on')" onmouseout="swap('avail_<?= $i ?>','avail_is')" alt="+" width="14" height="14" border="0"></td>
<? } }else { if($row['avail']!='1') {?>
				<tr class="row_na" id="r_<?= $nr ?>_<?= $i ?>">
					<td align="center" nowrap><img title="<?= $trans['t_lent'].' '.$trans['t_to'].' '.$lenton[$row['lentto']].' '.$trans['t_at'].' '.substr($row['lentsince'], -2, 2).'-'.$trans[substr($row['lentsince'], 5, 2)].'-'.substr($row['lentsince'], 0, 4) ?>" src="images/table/avail_no.png" alt="-" width="14" height="14" border="0"></td>
<? }else { ?>
				<tr class="row_<?= $nr ?>" id="r_<?= $nr ?>_<?= $i ?>">
					<td align="center" nowrap><img title="<?= $trans['available'] ?>" src="images/table/avail_is.png" alt="+" width="14" height="14" border="0"></td>
<? } } ?>
					<td nowrap><?= $row['rating']?></td>
					<td nowrap><span style="cursor:help;" title="<?= $row['fid'] ?>"><?= $row['nr']?></span></td>
					<td<? if($cfg['nobreaks']) echo " nowrap"; ?>>
					<img title="<?= $trans['export_moviedata']?>" onClick="fill_Request('editreq');show_Request(true,'editreq','exportfilm.php?fid=<?= $row['fid']?>&title=<?= rawurlencode($row['name'])?>&local=<?= rawurlencode($row['local'])?>');" name="export_<?= $i ?>" src="images/table/export_off.png" <? if((!$cfg['nobreaks'])||($cfg['original'])) echo 'align="right"'; ?> onmouseover="swap('export_<?= $i ?>','export_on')" onmouseout="swap('export_<?= $i ?>','export_off')" alt="export" width="14" height="14" border="0">
<? if(isset($_SESSION['user'])) { ?>
					<a href="edit.php?fid=<?= $row['fid']?>" onmouseover="parent.window.status=' ';return true;" title="<?= $trans['edit_moviedata']?>" style="cursor:pointer;" onclick="set_GET_edit();">
					<img name="edit_<?= $i ?>" src="images/table/edit_off.png" <? if((!$cfg['nobreaks'])||($cfg['original'])) echo 'align="right"'; ?> onmouseover="swap('edit_<?= $i ?>','edit_on')" onmouseout="swap('edit_<?= $i ?>','edit_off')" alt="edit" width="14" height="14" border="0"></a>
<? } ?>
					<img style="display:none;" id="show_OFF_<?= $i ?>" name="show_OFF_<?= $i ?>" onclick="set_MARK(<?= $row['fid'].','.$i.','.$nr.','.$row['avail'] ?>);" onmouseover="swap('show_OFF_<?= $i ?>','asc_on')" onmouseout="swap('show_OFF_<?= $i ?>','asc_off')" align="right" src="images/table/asc_off.png" title="<?= $trans['close_movieinfo']?>" alt="" width="12" height="14" border="0">
					<img id="show_ON_<?= $i ?>" name="show_ON_<?= $i ?>" onclick="set_MARK(<?= $row['fid'].','.$i.','.$nr.','.$row['avail'] ?>);" onmouseover="swap('show_ON_<?= $i ?>','desc_on')" onmouseout="swap('show_ON_<?= $i ?>','desc_off')" align="right" src="images/table/desc_off.png" title="<?= $trans['show_movieinfo']?>" alt="" width="12" height="14" border="0">
<? if(($cfg['original'])&&($row['local']!=$row['name'])) {
if(($_POST['sorter']=='name_ASC')||($_POST['sorter']=='name_DESC')) { ?>
					<span class="title_line"><a title="<?= $trans['show_moviedata']?>" style="cursor:pointer;" onclick="show_film('<?= $foo-1 ?>');"><?= $row['name'] ?></a></span><br><span class="sub_line"><?= $row['local'] ?></span>
<? }else { ?>
					<span class="title_line"><a title="<?= $trans['show_moviedata']?>" style="cursor:pointer;" onclick="show_film('<?= $foo-1 ?>');"><?= $row['local'] ?></a></span><br><span class="sub_line"><?= $row['name'] ?></span>
<? } }else if(($_POST['sorter']=='name_ASC')||($_POST['sorter']=='name_DESC')) { ?>
					<a title="<?= $trans['show_moviedata']?>" style="cursor:pointer;" onclick="show_film('<?= $foo-1 ?>');"><?= $row['name'] ?></a>
<? }else { ?>
					<a title="<?= $trans['show_moviedata']?>" style="cursor:pointer;" onclick="show_film('<?= $foo-1 ?>');"><?= $row['local'] ?></a>
<? } ?>
					</td>
					<td nowrap><?= $director?></td>
					<td nowrap><span style="cursor:help;" title="<? $l=explode(",",$row['lang']); for($x=0;$x<count($l);$x++){ echo $trans[$l[$x]]." "; }?>"><? getcountry($row['country']); ?></span></td>
					<td nowrap><?= $row['year']?></td>
					<td nowrap><?= $row['runtime']?>&nbsp;<?= $trans['t_minutes']?></td>
					<td nowrap><span style="cursor:help;" title="<?= $row['container'].':'.$row['video'].'/'.$row['audio'] ?>"><?= $row['medium']?><? if($row['disks']>1){echo '<small><sup>'.$row['disks'].'</sup></small>';} ?></span></td>
					<td nowrap><?= substr($row['inserted'], -2, 2).'-'.$trans[substr($row['inserted'], 5, 2)].'-'.substr($row['inserted'], 2, 2) ?></td>
<? if(!$cfg['noposter']){ ?>
					<td nowrap><a onmouseover="return escape('<img src=\'imgget.php?for=<?= $row['fid']?>\' border=\'0\'><br><?= $trans['click_imdbpage']?>');" title="<?= $trans['show_imdbpage']?>" href="http://www.imdb.com/title/tt<?= $row['id']?>" target="_blank"><img src="imgget.php?for=<?= $row['fid']?>" width="10" height="14" border="0" alt="*"></a></td>
<? }else{ ?>
					<td nowrap><a title="<?= $trans['show_imdbpage']?>" href="http://www.imdb.com/title/tt<?= $row['id']?>" target="_blank"><img src="images/link.png" width="14" height="14" border="0" alt="*"></a></td>
<? } ?>
				</tr>
				<tr id="o_<?= $row['fid']?>" style="display:none;"><td id="p_<?= $row['fid']?>" colspan="11">
					<table border="0" style="background-color:#ffffff;border-color:#D9D9D9;" bordercolor="#D9D9D9" cellspacing="0" cellpadding="0" width="100%">
						<tr><td class="bit" valign="top" align="center" width="100">
							<img src="images/space.gif" width="100" height="1" border="0">
							<a title="<?= $trans['show_imdbpage']?>" href="http://www.imdb.com/title/tt<?= $row['id']?>" target="_blank"><img src="imgget.php?for=<?= $row['fid']?>" align="center" width="95" height="140" border="0"></a>
						</td><td class="bit" valign="top" width="100%">
							<table style="border-bottom:solid 1px #D9D9D9;border-color:#D9D9D9;" frame="box" rules="cols" bordercolor="#D9D9D9" border="0" cellspacing="0" cellpadding="2" width="100%"><tr>
<? if((!$cfg['original'])&&($row['local']!=$row['name'])) { ?>
								<td style="text-transform:capitalize" valign="top" align="right" bgcolor="#f0f0f0" nowrap><?= $trans['t_original']?>&nbsp;<big><b><?= $trans['t_title']?></b></big>:</td>
								<td width="100%"><big><a title="<?= $trans['show_moviedata']?>" style="cursor:pointer;" onclick="show_film('<?= $foo-1 ?>');"><?= $row['name'].' ('.$row['year'].')' ?></a></big></td>
							</tr><tr>
<? } ?>			
								<td style="text-transform:capitalize" valign="top" align="right" bgcolor="#eeeeee" nowrap><?= $trans['t_alias'] ?>&nbsp;<b><?= $trans['t_title'] ?></b>:</td>
								<td width="100%"><?= str_replace("\n",'&bull; ',$row['aka']) ?></td>
<? if($row['avail']!='1'){ ?>
							</tr><tr>
								<td style="text-transform:uppercase; color:#666666;" bgcolor="#eeeeee" valign="top" align="right" nowrap><b><?= $trans['t_lent']?></b></td>
								<td class="row_na" width="100%"><?= $trans['t_to'].' "<b>'.$lenton[$row['lentto']].'</b>" '.$trans['t_at'].' '.substr($row['lentsince'], -2, 2).'-'.$trans[substr($row['lentsince'], 5, 2)].'-'.substr($row['lentsince'], 0, 4) ?></td>
<? } ?>
							</tr><tr>
								<td style="text-transform:uppercase" valign="top" align="right" bgcolor="#eeeeee" nowrap><?= $trans['t_filminfo']?>:</td>
								<td class="row_0" width="100%"><?= '['.$row['nr'].'] &bull; '.$row['country'].' &bull; '.$row['year'].' &bull; '.$row['runtime'].'&nbsp;'.$trans['t_minutes'].' &bull; '.$k.'&bull; '.$row['rating'].' '.$trans['x_of_x'].' 100 &bull; '.substr($row['inserted'], -2, 2).'-'.$trans[substr($row['inserted'], 5, 2)].'-'.substr($row['inserted'], 0, 4) ?></td>
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
								<td width="100%"><div style="-moz-column-width: 6em; -moz-column-count: 4; -moz-column-gap: 1em;"><?= $actors ?></div></td>
<? if($row['comment']!=''){ ?>
							</tr><tr>
								<td style="text-transform:uppercase" valign="top" align="right" bgcolor="#eeeeee" nowrap><?= $trans['t_comment']?>:</td>
								<td class="row_0" width="100%"><?= $row['comment']?></td>
<? } ?>
							</tr></table>
						</td></tr>
					</table>
				</td></tr>
<?
	$brow = !$brow;
}
if($rowcount==0){
	echo '				<tr><td bgcolor="#ffe3db" colspan="11" align="center"><b>'.$trans['no_matches'].'</b></td></tr>'."\n";
}
?>
			</tbody>
		</table>
		<br clear="all">
<? } ?>
		<div id="panel">
		<form class="nobreak" name="filterform" action="list.php" method="post">
			<input type="hidden" name="page" value="<?= isset($_POST['page'])?$_POST['page']:'0' ?>">
			<input type="hidden" name="view" value="<?= isset($_POST['view'])?$_POST['view']:'list'?>">
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
			<div id="searchBox">
			<table style="padding:0; border-top:solid 1px #D9D9D9; border-bottom:solid 1px #D9D9D9;" bgcolor="#ffe3db" width="100%" cellspacing="0" cellpadding="0" border="0">
				<tr>
					<td colspan="5" nowrap><big><b><?= $trans['search_genres']?></b></big></td>
					<td colspan="5" align="right" nowrap><?= $trans['all_genres']?> <a style="cursor:pointer;" onclick="checkGenres(true);"><?= $trans['link_on']?></a>/<a style="cursor:pointer;" onclick="checkGenres(false);"><?= $trans['link_off']?></a></td>
				</tr>
<?
				$sgenre = explode(',',$_POST['genres']);
				$i=0;
				echo '<tr>';
				foreach($cfg['genre'] as $m){
					if($i%10==0 && $i!=0)
						echo '</tr><tr>';
					echo '<td nowrap><input type="checkbox" id="genres_'.$i.'" value="'.$m.'"'.(in_array($m,$sgenre)?'checked="checked"':'').'/>'.$m.'</td>';
					$i++;
				}
				while(1){
					$i++;
					if($i%10==0) break;
				}
?>
					<td colspan="4"></td><td colspan="5" valign="bottom"><?= $trans['is_equal_to']?></td></tr>
				<tr>
					<td colspan="4" class="txt" align="right" nowrap><big><b><?= $trans['search_for']?></b></big>
&nbsp;<select id="type" name="type">
<option value=""<? if(($_POST['searchin']=='movies.name,aka')||($_POST['searchin']=='')) { echo ' selected';} ?>><?= $trans['o_all_title']?></option>
<option value="name"<?= ($_POST['searchin']=='name'?' selected':'') ?>><?= $trans['o_name']?></option>
<option value="local"<?= ($_POST['searchin']=='local'?' selected':'') ?>><?= $trans['o_local']?></option>
<option value="directs.movie_fid = movies.fid AND directs.people_id = people.id AND people.name"<?= ($_POST['searchin']=='directs.movie_fid = movies.fid AND directs.people_id = people.id AND people.name'?' selected':'') ?>><?= $trans['o_director']?></option>
<option value="writes.movie_fid = movies.fid AND writes.people_id = people.id AND people.name"<?= ($_POST['searchin']=='writes.movie_fid = movies.fid AND writes.people_id = people.id AND people.name'?' selected':'') ?>><?= $trans['o_writer']?></option>
<option value="plays_in.movie_fid = movies.fid AND plays_in.people_id = people.id AND people.name"<?= ($_POST['searchin']=='plays_in.movie_fid = movies.fid AND plays_in.people_id = people.id AND people.name'?' selected':'') ?>><?= $trans['o_actor']?></option>
<!-- type,lentto,lentsince,inserted,cat -->
<option value="avail"<?= ($_POST['searchin']=='avail'?' selected':'') ?>><?= $trans['o_avail']?></option>
<option value="rating"<?= ($_POST['searchin']=='rating'?' selected':'') ?>><?= $trans['o_rate']?></option>
<option value="id"<?= ($_POST['searchin']=='id'?' selected':'') ?>><?= $trans['o_imdb']?></option>
<option value="nr"<?= ($_POST['searchin']=='nr'?' selected':'') ?>><?= $trans['o_id']?></option>
<option value="country"<?= ($_POST['searchin']=='country'?' selected':'') ?>><?= $trans['o_country']?></option>
<option value="year"<?= ($_POST['searchin']=='year'?' selected':'') ?>><?= $trans['o_year']?></option>
<option value="runtime"<?= ($_POST['searchin']=='runtime'?' selected':'') ?>><?= $trans['o_runtime']?></option>
<option value="lang"<?= ($_POST['searchin']=='lang'?' selected':'') ?>><?= $trans['o_lang']?></option>
<option value="comment"<?= ($_POST['searchin']=='comment'?' selected':'') ?>><?= $trans['o_comment']?></option>
<option value="medium"<?= ($_POST['searchin']=='medium'?' selected':'') ?>><?= $trans['o_medium']?></option>
<option value="disks"<?= ($_POST['searchin']=='disks'?' selected':'') ?>><?= $trans['o_disks']?></option>
<option value="container"<?= ($_POST['searchin']=='container'?' selected':'') ?>><?= $trans['o_container']?></option>
<option value="video"<?= ($_POST['searchin']=='video'?' selected':'') ?>><?= $trans['o_video']?></option>
<option value="width"<?= ($_POST['searchin']=='width'?' selected':'') ?>><?= $trans['o_width']?></option>
<option value="height"<?= ($_POST['searchin']=='height'?' selected':'') ?>><?= $trans['o_height']?></option>
<option value="format"<?= ($_POST['searchin']=='format'?' selected':'') ?>><?= $trans['o_format']?></option>
<option value="ratio"<?= ($_POST['searchin']=='ratio'?' selected':'') ?>><?= $trans['o_ratio']?></option>
<option value="audio"<?= ($_POST['searchin']=='audio'?' selected':'') ?>><?= $trans['o_audio']?></option>
<option value="channel"<?= ($_POST['searchin']=='channel'?' selected':'') ?>><?= $trans['o_channel']?></option>
<option value="herz"<?= ($_POST['searchin']=='herz'?' selected':'') ?>><?= $trans['o_herz']?></option>
</select>&nbsp;<big><b><?= $trans['x_with']?></b></big>
					</td>
					<td colspan="4" class="txt" align="left" nowrap>
						<input style="width:100%" type="text" id="title" value="<?= isset($_POST['tosearch'])?$_POST['tosearch']:''?>" onkeydown="submitenter(event);">
					</td><td colspan="2" class="txt" nowrap>
						<button type="button" onClick="tfilter(document.filterform.title.value,document.filterform.type.options[document.filterform.type.selectedIndex].value);">&nbsp;<b><?= $trans['do_search']?></b>&nbsp;</button>
					</td>
				</tr>
				<tr><td colspan="10" height="4"></td></tr>
			</table>
			</div>
		</form>
		<table border="0" style="border-top:1px solid #D9D9D9;border-bottom:1px solid #D9D9D9;" cellspacing="0" cellpadding="0" width="100%">
			<tr><td style="padding:0;">
			<table width="100%" border="0" style="border-color:#D9D9D9;" bordercolor="#D9D9D9" frame="void" rules="cols" cellspacing="0" cellpadding="0">
				<tr bgcolor="#ffffff">
<? if($_POST['view']=='film') { ?>
<? if($_POST['page']!='0'){ ?>
					<td class="passive" align="center" width="20"><a onclick="setpage(0);"><img src="images/table/first_on.png" title="<?= $trans['the_first'].$trans['x_film'] ?>" alt="|&lt;" width="10" height="10" border="0" name="first" onmouseover="swap('first','first_off')" onmouseout="swap('first','first_on')"></a></td>
<? }else{ ?>
					<td class="passive" align="center" width="20"><img src="images/table/first_off.png" alt="|&lt;" width="10" height="10" border="0"></td>
<? } ?>
<? if($_POST['page']!='0'){if(((integer)$_POST['page'])<$cfg['nooffilms']){$tmp=0;}else{$tmp=((integer)$_POST['page'])-$cfg['nooffilms'];} ?>
					<td class="passive" align="center" width="20"><a onclick="setpage(<?= $tmp ?>);"><img src="images/table/prev_on.png" title="<?= $trans['the_prev'].$trans['x_film'] ?>" alt="&lt;" width="10" height="10" border="0" name="prev" onmouseover="swap('prev','prev_off')" onmouseout="swap('prev','prev_on')"></a></td>
<? }else{ ?>
					<td class="passive" align="center" width="20"><img src="images/table/prev_off.png" alt="&lt;" width="10" height="10" border="0"></td>
<? } ?>
					<td class="passive" align="center" width="20" nowrap><nobr><? if($rowcount==0) {echo '<b>0-0</b> '.$trans['x_of_x'].' <b>0</b>';} else {echo '<b>'; echo $_POST['page']+1; echo '-'; echo $_POST['page']+min($cfg['nooffilms'],$rowcount-$_POST['page']); echo '</b> '.$trans['x_of_x'].' <b>'.$rowcount.'</b>';} ?></nobr></td>
<? $tmp=((integer)$_POST['page'])+$cfg['nooffilms']; if($rowcount > $tmp){ ?>
					<td class="passive" align="center" width="20"><a onclick="setpage(<?= $tmp ?>);"><img src="images/table/next_on.png" title="<?= $trans['the_next'].$trans['x_film'] ?>" alt="&gt;" width="10" height="10" border="0" name="next" onmouseover="swap('next','next_off')" onmouseout="swap('next','next_on')"></a></td>
<? }else{ ?>
					<td class="passive" align="center" width="20"><img src="images/table/next_off.png" alt="&gt;" width="10" height="10" border="0"></td>
<? } ?>
<? if($rowcount > $tmp){ $end = --$rowcount - (($rowcount) % $cfg['nooffilms']); ?>
					<td class="passive" align="center" width="20"><a onclick="setpage(<?= $end ?>);"><img src="images/table/last_on.png" title="<?= $trans['the_last'].$trans['x_film'] ?>" alt="&gt;|" width="10" height="10" border="0" name="last" onmouseover="swap('last','last_off')" onmouseout="swap('last','last_on')"></a></td>
<? }else{ ?>
					<td class="passive" align="center" width="20"><img src="images/table/last_off.png" alt="&gt;|" width="10" height="10" border="0"></td>
<? } ?>
					<td class="<? if((!preg_match('/^[a-zA-Z#]$/',$_POST['filtertitle']) && $_POST['tosearch']!='') || ($_POST['filtertitle']=="*" && $_POST['genres']!='')) {echo 'active';}else{echo 'passive';} ?>" align="center" width="20"><img src="images/table/search_off.png" alt="search" title="<?= $trans['search_info'] ?>" width="14" height="14" border="0" name="search" onclick="showOptions('-');" onmouseover="swap('search','search_on')" onmouseout="swap('search','search_off')"></td>
					<td class="<? if($_POST['filtertitle']=='*' && $_POST['genres']=='' && $_POST['searchin']=='movies.name,aka'){echo 'active';}else{echo 'passive';} ?>" align="center" width="20" style="text-transform:capitalize; cursor:pointer;"><a title="<?= $trans['filter_all']?>" onclick="showall()"><?= $trans['x_all'] ?></a></td>
					<td class="<? if($_POST['filtertitle']=='#' && $_POST['genres']=='' && $_POST['searchin']=='movies.name,aka'){echo 'active';}else{echo 'passive';} ?>" align="center" width="20" style="cursor:pointer;"><a title="<?= $trans['filter_0-9']?>" onclick="checkGenres(true);tfilter('#');"><nobr>0-9</nobr></a></td>
<?
for ($i = 97; $i < 123; $i++) {
	if($_POST['filtertitle']==chr($i)){$tmp='active';}else{$tmp='passive';}
	echo '					<td class="'.$tmp.'" style="text-transform:capitalize; cursor:pointer;" align="center" width="20"><a title="'.$trans['filter_a-z'].'" onclick="checkGenres(true);tfilter(\''.chr($i).'\');">'.chr($i).'</a></td>'."\n"; 
}
?>
<? } else if($_POST['view']=='row') { ?>
<? if($_POST['page']!='0'){ ?>
					<td class="passive" align="center" width="20"><a onclick="setpage(0);"><img src="images/table/first_on.png" title="<?= $trans['show_first'].$cfg['noofrows'].$trans['x_films'] ?>" alt="|&lt;" width="10" height="10" border="0" name="first" onmouseover="swap('first','first_off')" onmouseout="swap('first','first_on')"></a></td>
<? }else{ ?>
					<td class="passive" align="center" width="20"><img src="images/table/first_off.png" alt="|&lt;" width="10" height="10" border="0"></td>
<? } ?>
<? if($_POST['page']!='0'){if(((integer)$_POST['page'])<$cfg['noofrows']){$tmp=0;}else{$tmp=((integer)$_POST['page'])-$cfg['noofrows'];} ?>
					<td class="passive" align="center" width="20"><a onclick="setpage(<?= $tmp ?>);"><img src="images/table/prev_on.png" title="<?= $trans['show_prev'].$cfg['noofrows'].$trans['x_films'] ?>" alt="&lt;" width="10" height="10" border="0" name="prev" onmouseover="swap('prev','prev_off')" onmouseout="swap('prev','prev_on')"></a></td>
<? }else{ ?>
					<td class="passive" align="center" width="20"><img src="images/table/prev_off.png" alt="&lt;" width="10" height="10" border="0"></td>
<? } ?>
					<td class="passive" align="center" width="20" nowrap><nobr><? if($rowcount==0) {echo '<b>0-0</b> '.$trans['x_of_x'].' <b>0</b>';} else {echo '<b>'; echo $_POST['page']+1; echo '-'; echo $_POST['page']+min($cfg['noofrows'],$rowcount-$_POST['page']); echo '</b> '.$trans['x_of_x'].' <b>'.$rowcount.'</b>';} ?></nobr></td>
<? $tmp=((integer)$_POST['page'])+$cfg['noofrows']; if($rowcount > $tmp){ ?>
					<td class="passive" align="center" width="20"><a onclick="setpage(<?= $tmp ?>);"><img src="images/table/next_on.png" title="<?= $trans['show_next'].$cfg['noofrows'].$trans['x_films'] ?>" alt="&gt;" width="10" height="10" border="0" name="next" onmouseover="swap('next','next_off')" onmouseout="swap('next','next_on')"></a></td>
<? }else{ ?>
					<td class="passive" align="center" width="20"><img src="images/table/next_off.png" alt="&gt;" width="10" height="10" border="0"></td>
<? } ?>
<? if($rowcount > $tmp){ $end = --$rowcount - (($rowcount) % $cfg['noofrows']); ?>
					<td class="passive" align="center" width="20"><a onclick="setpage(<?= $end ?>);"><img src="images/table/last_on.png" title="<?= $trans['show_last'].$cfg['noofrows'].$trans['x_films'] ?>" alt="&gt;|" width="10" height="10" border="0" name="last" onmouseover="swap('last','last_off')" onmouseout="swap('last','last_on')"></a></td>
<? }else{ ?>
					<td class="passive" align="center" width="20"><img src="images/table/last_off.png" alt="&gt;|" width="10" height="10" border="0"></td>
<? } ?>
					<td class="<? if((!preg_match('/^[a-zA-Z#]$/',$_POST['filtertitle']) && $_POST['tosearch']!='') || ($_POST['filtertitle']=="*" && $_POST['genres']!='')) {echo 'active';}else{echo 'passive';} ?>" align="center" width="20"><img src="images/table/search_off.png" alt="search" title="<?= $trans['search_info'] ?>" width="14" height="14" border="0" name="search" onclick="showOptions('-');" onmouseover="swap('search','search_on')" onmouseout="swap('search','search_off')"></td>
					<td class="<? if($_POST['filtertitle']=='*' && $_POST['genres']=='' && $_POST['searchin']=='movies.name,aka'){echo 'active';}else{echo 'passive';} ?>" align="center" width="20" style="text-transform:capitalize; cursor:pointer;"><a title="<?= $trans['filter_all']?>" onclick="showall()"><?= $trans['x_all'] ?></a></td>
					<td class="<? if($_POST['filtertitle']=='#' && $_POST['genres']=='' && $_POST['searchin']=='movies.name,aka'){echo 'active';}else{echo 'passive';} ?>" align="center" width="20" style="cursor:pointer;"><a title="<?= $trans['filter_0-9']?>" onclick="checkGenres(true);tfilter('#');"><nobr>0-9</nobr></a></td>
<?
for ($i = 97; $i < 123; $i++) {
	if($_POST['filtertitle']==chr($i)){$tmp='active';}else{$tmp='passive';}
	echo '					<td class="'.$tmp.'" style="text-transform:capitalize; cursor:pointer;" align="center" width="20"><a title="'.$trans['filter_a-z'].'" onclick="checkGenres(true);tfilter(\''.chr($i).'\');">'.chr($i).'</a></td>'."\n"; 
}
?>
<? } else if($_POST['view']=='poster') { ?>
<? if($_POST['page']!='0'){ ?>
					<td class="passive" align="center" width="20"><a onclick="setpage(0);"><img src="images/table/first_on.png" title="<?= $trans['show_first'].$cfg['noofpics'].$trans['x_films'] ?>" alt="|&lt;" width="10" height="10" border="0" name="first" onmouseover="swap('first','first_off')" onmouseout="swap('first','first_on')"></a></td>
<? }else{ ?>
					<td class="passive" align="center" width="20"><img src="images/table/first_off.png" alt="|&lt;" width="10" height="10" border="0"></td>
<? } ?>
<? if($_POST['page']!='0'){if(((integer)$_POST['page'])<$cfg['noofpics']){$tmp=0;}else{$tmp=((integer)$_POST['page'])-$cfg['noofpics'];} ?>
					<td class="passive" align="center" width="20"><a onclick="setpage(<?= $tmp ?>);"><img src="images/table/prev_on.png" title="<?= $trans['show_prev'].$cfg['noofpics'].$trans['x_films'] ?>" alt="&lt;" width="10" height="10" border="0" name="prev" onmouseover="swap('prev','prev_off')" onmouseout="swap('prev','prev_on')"></a></td>
<? }else{ ?>
					<td class="passive" align="center" width="20"><img src="images/table/prev_off.png" alt="&lt;" width="10" height="10" border="0"></td>
<? } ?>
					<td class="passive" align="center" width="20" nowrap><nobr><? if($rowcount==0) {echo '<b>0-0</b> '.$trans['x_of_x'].' <b>0</b>';} else {echo '<b>'; echo $_POST['page']+1; echo '-'; echo $_POST['page']+min($cfg['noofpics'],$rowcount-$_POST['page']); echo '</b> '.$trans['x_of_x'].' <b>'.$rowcount.'</b>';} ?></nobr></td>
<? $tmp=((integer)$_POST['page'])+$cfg['noofpics']; if($rowcount > $tmp){ ?>
					<td class="passive" align="center" width="20"><a onclick="setpage(<?= $tmp ?>);"><img src="images/table/next_on.png" title="<?= $trans['show_next'].$cfg['noofpics'].$trans['x_films'] ?>" alt="&gt;" width="10" height="10" border="0" name="next" onmouseover="swap('next','next_off')" onmouseout="swap('next','next_on')"></a></td>
<? }else{ ?>
					<td class="passive" align="center" width="20"><img src="images/table/next_off.png" alt="&gt;" width="10" height="10" border="0"></td>
<? } ?>
<? if($rowcount > $tmp){ $end = --$rowcount - (($rowcount) % $cfg['noofpics']); ?>
					<td class="passive" align="center" width="20"><a onclick="setpage(<?= $end ?>);"><img src="images/table/last_on.png" title="<?= $trans['show_last'].$cfg['noofpics'].$trans['x_films'] ?>" alt="&gt;|" width="10" height="10" border="0" name="last" onmouseover="swap('last','last_off')" onmouseout="swap('last','last_on')"></a></td>
<? }else{ ?>
					<td class="passive" align="center" width="20"><img src="images/table/last_off.png" alt="&gt;|" width="10" height="10" border="0"></td>
<? } ?>
					<td class="<? if((!preg_match('/^[a-zA-Z#]$/',$_POST['filtertitle']) && $_POST['tosearch']!='') || ($_POST['filtertitle']=="*" && $_POST['genres']!='')) {echo 'active';}else{echo 'passive';} ?>" align="center" width="20"><img src="images/table/search_off.png" alt="search" title="<?= $trans['search_info'] ?>" width="14" height="14" border="0" name="search" onclick="showOptions('-');" onmouseover="swap('search','search_on')" onmouseout="swap('search','search_off')"></td>
					<td class="<? if($_POST['filtertitle']=='*' && $_POST['genres']=='' && $_POST['searchin']=='movies.name,aka'){echo 'active';}else{echo 'passive';} ?>" align="center" width="20" style="text-transform:capitalize; cursor:pointer;"><a title="<?= $trans['filter_all']?>" onclick="showall()"><?= $trans['x_all'] ?></a></td>
					<td class="<? if($_POST['filtertitle']=='#' && $_POST['genres']=='' && $_POST['searchin']=='movies.name,aka'){echo 'active';}else{echo 'passive';} ?>" align="center" width="20" style="cursor:pointer;"><a title="<?= $trans['filter_0-9']?>" onclick="checkGenres(true);tfilter('#');"><nobr>0-9</nobr></a></td>
<?
for ($i = 97; $i < 123; $i++) {
	if($_POST['filtertitle']==chr($i)){$tmp='active';}else{$tmp='passive';}
	echo '					<td class="'.$tmp.'" style="text-transform:capitalize; cursor:pointer;" align="center" width="20"><a title="'.$trans['filter_a-z'].'" onclick="checkGenres(true);tfilter(\''.chr($i).'\');">'.chr($i).'</a></td>'."\n"; 
}
?>
<? } else { ?>
<? if($_POST['page']!='0'){ ?>
					<td class="passive" align="center" width="20"><a onclick="setpage(0);"><img src="images/table/first_on.png" title="<?= $trans['show_first'].$cfg['noofentries'].$trans['x_films'] ?>" alt="|&lt;" width="10" height="10" border="0" name="first" onmouseover="swap('first','first_off')" onmouseout="swap('first','first_on')"></a></td>
<? }else{ ?>
					<td class="passive" align="center" width="20"><img src="images/table/first_off.png" alt="|&lt;" width="10" height="10" border="0"></td>
<? } ?>
<? if($_POST['page']!='0'){if(((integer)$_POST['page'])<$cfg['noofentries']){$tmp=0;}else{$tmp=((integer)$_POST['page'])-$cfg['noofentries'];} ?>
					<td class="passive" align="center" width="20"><a onclick="setpage(<?= $tmp ?>);"><img src="images/table/prev_on.png" title="<?= $trans['show_prev'].$cfg['noofentries'].$trans['x_films'] ?>" alt="&lt;" width="10" height="10" border="0" name="prev" onmouseover="swap('prev','prev_off')" onmouseout="swap('prev','prev_on')"></a></td>
<? }else{ ?>
					<td class="passive" align="center" width="20"><img src="images/table/prev_off.png" alt="&lt;" width="10" height="10" border="0"></td>
<? } ?>
					<td class="passive" align="center" width="20" nowrap><nobr><? if($rowcount==0) {echo '<b>0-0</b> '.$trans['x_of_x'].' <b>0</b>';} else {echo '<b>'; echo $_POST['page']+1; echo '-'; echo $_POST['page']+min($cfg['noofentries'],$rowcount-$_POST['page']); echo '</b> '.$trans['x_of_x'].' <b>'.$rowcount.'</b>';} ?></nobr></td>
<? $tmp=((integer)$_POST['page'])+$cfg['noofentries']; if($rowcount > $tmp){ ?>
					<td class="passive" align="center" width="20"><a onclick="setpage(<?= $tmp ?>);"><img src="images/table/next_on.png" title="<?= $trans['show_next'].$cfg['noofentries'].$trans['x_films'] ?>" alt="&gt;" width="10" height="10" border="0" name="next" onmouseover="swap('next','next_off')" onmouseout="swap('next','next_on')"></a></td>
<? }else{ ?>
					<td class="passive" align="center" width="20"><img src="images/table/next_off.png" alt="&gt;" width="10" height="10" border="0"></td>
<? } ?>
<? if($rowcount > $tmp){ $end = --$rowcount - (($rowcount) % $cfg['noofentries']); ?>
					<td class="passive" align="center" width="20"><a onclick="setpage(<?= $end ?>);"><img src="images/table/last_on.png" title="<?= $trans['show_last'].$cfg['noofentries'].$trans['x_films'] ?>" alt="&gt;|" width="10" height="10" border="0" name="last" onmouseover="swap('last','last_off')" onmouseout="swap('last','last_on')"></a></td>
<? }else{ ?>
					<td class="passive" align="center" width="20"><img src="images/table/last_off.png" alt="&gt;|" width="10" height="10" border="0"></td>
<? } ?>
					<td class="<? if((!preg_match('/^[a-zA-Z#]$/',$_POST['filtertitle']) && $_POST['tosearch']!='') || ($_POST['filtertitle']=="*" && $_POST['genres']!='')) {echo 'active';}else{echo 'passive';} ?>" align="center" width="20"><img src="images/table/search_off.png" alt="search" title="<?= $trans['search_info'] ?>" width="14" height="14" border="0" name="search" onclick="showOptions('-');" onmouseover="swap('search','search_on')" onmouseout="swap('search','search_off')"></td>
					<td class="<? if($_POST['filtertitle']=='*' && $_POST['genres']=='' && $_POST['searchin']=='movies.name,aka'){echo 'active';}else{echo 'passive';} ?>" align="center" width="20" style="text-transform:capitalize; cursor:pointer;"><a title="<?= $trans['filter_all']?>" onclick="showall()"><?= $trans['x_all'] ?></a></td>
					<td class="<? if($_POST['filtertitle']=='#' && $_POST['genres']=='' && $_POST['searchin']=='movies.name,aka'){echo 'active';}else{echo 'passive';} ?>" align="center" width="20" style="cursor:pointer;"><a title="<?= $trans['filter_0-9']?>" onclick="checkGenres(true);tfilter('#');"><nobr>0-9</nobr></a></td>
<?
for ($i = 97; $i < 123; $i++) {
	if($_POST['filtertitle']==chr($i)){$tmp='active';}else{$tmp='passive';}
	echo '					<td class="'.$tmp.'" style="text-transform:capitalize; cursor:pointer;" align="center" width="20"><a title="'.$trans['filter_a-z'].'" onclick="checkGenres(true);tfilter(\''.chr($i).'\');">'.chr($i).'</a></td>'."\n"; 
}
?>
<? } ?>
				</tr></table>
			</td></tr>
		</table>
		</div>
<? if(!$cfg['noposter']){ ?>
		<script type="text/javascript" language="JavaScript" src="config/tooltip.js"></script>
<? } ?>
	</body>
</html>
