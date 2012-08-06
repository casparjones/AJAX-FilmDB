<?php
/* FilmDB (based on php4flicks) */

	// index.php -- display container page for iframe with movie list

	require_once('config/config.php');
	if(is_dir('help/images')) $help=true;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
       "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?= $trans['page_title']?></title>
<meta http-equiv="content-type" content="<?= $conttype ?>">   
<link rel="alternate" type="application/rss+xml" title="<?= $trans['rss_title'] ?>" href="<?= eregi_replace("index.php", "", $_SERVER["HTTP_HOST"]) ?>rss/">
<link rel="icon" href="favicon.ico" type="image/ico">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="bookmark" type="text/html" title="FilmDB" href="">
<link rel="bookmark" type="text/xml" title="FilmDB-RSS" href="rss/">
<link rel="bookmark" type="text/html" title="FilmDB-Mobile" href="mobile/">
<meta http-equiv="imagetoolbar" content="no">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<script type="text/javascript" src="config/requester.js"></script>
<script type="text/javascript" src="config/helppage.js"></script>
<script type="text/javascript" src="config/md5.js"></script>
<script type="text/javascript" language="JavaScript">
<!--
<?php
	echo '	lenton=new Array(';
for($x=0; $x<count($lenton); $x++){
    echo '"'.$lenton[$x].'",';
}
	echo '"");'."\n";
	echo '	cur_date="'.date("Y-m-d").'";'."\n";
	echo '	noname="'.$trans['unnamed'].'";'."\n";
	echo '	in_progress="<h2><nobr><b>'.$trans['work_in_progress'].'</b></nobr></h2><br><br><table width=\"100%\" height=\"16\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td height=\"32\" width=\"100%\" align=\"center\"><img src=\"images/indicator.gif\" width=\"32\" height=\"32\" border=\"0\"></td></tr></table>";'."\n";
	// echo '	in_progress="<h2><nobr><b>'.$trans['work_in_progress'].'</b></nobr></h2><br><table width=\"100%\" height=\"16\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td height=\"16\" width=\"100%\" background=\"images/progress.gif\"><img src=\"images/space.gif\" width=\"16\" height=\"16\" border=\"0\"></td></tr></table>";'."\n";
	echo '	att_pic="<img src=\"images/attention.png\" alt=\"attention\" width=\"20\" height=\"18\" border=\"0\">&nbsp;";'."\n";
	echo '	adding_yes="<img src=\"images/button/plus_off.png\" title=\"'.$trans['add_film'].'\" alt=\"add\" width=\"30\" height=\"24\" border=\"0\" name=\"plus_film\" onClick=\"setGET_add();change(\'plus_film\',\'plus_off\');showRequest(true,\'editreq\',\'add.php\');\" onmouseover=\"change(\'plus_film\',\'plus_on\')\" onmouseout=\"change(\'plus_film\',\'plus_off\')\">";'."\n";
	echo '	adding_no ="<img src=\"images/button/plus_off.png\" title=\"'.$trans['add_film'].'\" alt=\"add\" width=\"30\" height=\"24\" border=\"0\" name=\"plus_film\" onClick=\"change(\'plus_film\',\'plus_off\');showRequest(att_pic + \''.$trans['alert_title'].$trans['login_alert'].'\',\'textreq\',\'\');\" onmouseover=\"change(\'plus_film\',\'plus_on\')\" onmouseout=\"change(\'plus_film\',\'plus_off\')\">";'."\n";
	echo '	login_src ="<img src=\"images/button/login_off.png\" title=\"'.$trans['log_in'].'\" alt=\"login/out\" width=\"30\" height=\"24\" border=\"0\" name=\"log_in\" onClick=\"setGET_add();change(\'log_in\',\'login_off\');showRequest(true,\'editreq\',\'login.php\');\" onmouseover=\"change(\'log_in\',\'login_on\')\" onmouseout=\"change(\'log_in\',\'login_off\')\">";'."\n";
	echo '	logout_src="<img src=\"images/button/logout_off.png\" title=\"'.$trans['log_out'].'\" alt=\"login/out\" width=\"30\" height=\"24\" border=\"0\" name=\"log_out\" onClick=\"setGET_add();change(\'log_out\',\'logout_off\');ajaxpage(\'logout.php\',\'editreqsource\');log_user_out();\" onmouseover=\"change(\'log_out\',\'logout_on\')\" onmouseout=\"change(\'log_out\',\'logout_off\')\">";'."\n";
	echo '	importing_yes="<img src=\"images/button/import_off.png\" title=\"'.$trans['import_film'].'\" alt=\"import\" width=\"30\" height=\"24\" border=\"0\" name=\"import_film\" onClick=\"setGET_add();change(\'import_film\',\'import_off\');showRequest(true,\'editreq\',\'importfilm.php\');\" onmouseover=\"change(\'import_film\',\'import_on\')\" onmouseout=\"change(\'import_film\',\'import_off\')\">";'."\n";
	echo '	importing_no ="<img src=\"images/button/import_off.png\" title=\"'.$trans['import_film'].'\" alt=\"import\" width=\"30\" height=\"24\" border=\"0\" name=\"import_film\" onClick=\"change(\'import_film\',\'import_off\');showRequest(att_pic + \''.$trans['alert_title'].$trans['login_alert'].'\',\'textreq\',\'\');\" onmouseover=\"change(\'import_film\',\'import_on\')\" onmouseout=\"change(\'import_film\',\'import_off\')\">";'."\n";
?>
	film_off = new Image(); film_off.src = 'images/button/film_off.png';
	film_on = new Image(); film_on.src = 'images/button/film_on.png';
	row_off = new Image(); row_off.src = 'images/button/row_off.png';
	row_on = new Image(); row_on.src = 'images/button/row_on.png';
	poster_off = new Image(); poster_off.src = 'images/button/poster_off.png';
	poster_on = new Image(); poster_on.src = 'images/button/poster_on.png';
	list_off = new Image(); list_off.src = 'images/button/list_off.png';
	list_on = new Image(); list_on.src = 'images/button/list_on.png';
	info_off = new Image(); info_off.src = 'images/button/info_off.png';
	info_on = new Image(); info_on.src = 'images/button/info_on.png';
	help_off = new Image(); help_off.src = 'images/button/help_off.png';
	help_on = new Image(); help_on.src = 'images/button/help_on.png';
	plus_off = new Image(); plus_off.src = 'images/button/plus_off.png';
	plus_on = new Image(); plus_on.src = 'images/button/plus_on.png';
	search_off = new Image(); search_off.src = 'images/button/search_off.png';
	search_on = new Image(); search_on.src = 'images/button/search_on.png';
	print_off = new Image(); print_off.src = 'images/button/print_off.png';
	print_on = new Image(); print_on.src = 'images/button/print_on.png';
	prefs_off = new Image(); prefs_off.src = 'images/button/prefs_off.png';
	prefs_on = new Image(); prefs_on.src = 'images/button/prefs_on.png';
	login_off = new Image(); login_off.src = 'images/button/login_off.png';
	login_on = new Image(); login_on.src = 'images/button/login_on.png';
	logout_off = new Image(); logout_off.src = 'images/button/logout_off.png';
	logout_on = new Image(); logout_on.src = 'images/button/logout_on.png';
	import_off = new Image(); import_off.src = 'images/button/import_off.png';
	import_on = new Image(); import_on.src = 'images/button/import_on.png';

function change(imgID,imgObjName) {
	if(imgID != '')  {
		document.images[imgID].src = eval(imgObjName + ".src");
	}
}
function reset_view(){
	document.film_view.src = film_off.src;
	document.row_view.src = row_off.src;
	document.poster_view.src = poster_off.src;
	document.list_view.src = list_off.src;
}
function to_film_view(){
	reset_view();
	var title_should = "<?= $trans['page_title']?>:List";
	var title_is = mainframe.document.title;
	if(title_is != title_should){
		document.list_view.src = list_on.src;
		document.remember.submit();
	} else {
		document.film_view.src = film_on.src;
		mainframe.document.filterform.view.value = 'film';
		mainframe.document.filterform.submit();
	}
}
function to_row_view(){
	reset_view();
	var title_should = "<?= $trans['page_title']?>:List";
	var title_is = mainframe.document.title;
	if(title_is != title_should){
		document.list_view.src = list_on.src;
		document.remember.submit();
	} else {
		document.row_view.src = row_on.src;
		mainframe.document.filterform.view.value = 'row';
		mainframe.document.filterform.submit();
	}
}
function to_poster_view(){
	reset_view();
	var title_should = "<?= $trans['page_title']?>:List";
	var title_is = mainframe.document.title;
	if(title_is != title_should){
		document.list_view.src = list_on.src;
		document.remember.submit();
	} else {
		document.poster_view.src = poster_on.src;
		mainframe.document.filterform.view.value = 'poster';
		mainframe.document.filterform.submit();
	}
}
function to_list_view(){
	reset_view();
	var title_should = "<?= $trans['page_title']?>:List";
	var title_is = mainframe.document.title;
	if(title_is != title_should){
		document.list_view.src = list_on.src;
		document.remember.submit();
	} else {
		document.list_view.src = list_on.src;
		mainframe.document.filterform.view.value = 'list';
		mainframe.document.filterform.submit();
	}
}
function displayLCD(f) {
	var div = document.getElementById('lcd');
	var txt = "<nobr><?= $trans['version'].'&nbsp;<b>'.$cfg['filmdb_version'].'</b>&nbsp;&bull;&nbsp;'.$cfg['filmdb_release']?></nobr>";
	if(f){
		div.innerHTML = f;
	} else {
		div.innerHTML = txt;
	}
}
function showRequest(f,n,d){
	var requestBox = document.getElementById('locker');
	var boxContent = document.getElementById(n);
	var contentDiv = document.getElementById(n+'source');
	if(f){
		var tmp = typeof(f); var cls = typeof(d);
		if(cls!='boolean'){
			if(tmp=='boolean'){
				ajaxpage(d,n+'source');
			} else {
				contentDiv.innerHTML = f;
			}
		}
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
function fillRequest(n){
	var div = document.getElementById(n+'source');
	div.innerHTML = in_progress;
}
function closeRequest(n){
	var div = document.getElementById(n+'source');
	div.innerHTML = '';
}
function dothroughLoop(n,f){
	var val = parseInt(n);
    if(val == NaN) val = 0;
    if(val>100) val = 100;
    var n_of_x = document.getElementById('n_of_x');
	var g_of_x = document.getElementById('g_of_x');
	n_of_x.innerHTML = f;
	g_of_x.width = (val*2);
}
function doafterLoop(err){
	var val = parseInt(err);
    var obj = document.getElementById('stop_b');
    var ofx = document.getElementById('n_of_x')
    var img = document.getElementById('g_of_x');
   	var txt = document.getElementById('done_t');
    ofx.innerHTML = 100; img.width = 200;
    txt.style.display = 'block';
    if(val==0){
    	// txt.innerHTML = "<small><?= $trans['done_alert']?></small>";
    } else if(val==1) {
    	txt.innerHTML = "<strong><small><?= $trans['none_alert']?></small></strong>";
    } else {
    	txt.innerHTML = "<strong><small><?= $trans['fs_alert']?></small></strong>";
    }
    obj.style.display = 'block';
}
function readCookie(cookieName) {
	var theCookie=""+document.cookie;
	var ind=theCookie.indexOf(cookieName);
	if (ind==-1 || cookieName=="") return ""; 
		var ind1=theCookie.indexOf(';',ind);
	if (ind1==-1) ind1=theCookie.length; 
		return unescape(theCookie.substring(ind+cookieName.length+1,ind1));
}
// login.php logout.php functions
function catch_logging_in(){
	var nix = readCookie('userpref');
	if (nix == 1) {
		log_user_in();
	} else {
		showRequest(att_pic + '<?= $trans['alert_title'].$trans['logging_alert']?>','textreq','');
	}
}
function catch_logging_out(){
	var title_should = "<?= $trans['page_title']?>:List";
	var title_is = mainframe.document.getElementsByTagName("title")[0].text;
	if(title_is != title_should){
		document.remember.submit();
	} else {
		mainframe.document.filterform.login.value = '0';
		mainframe.document.filterform.submit();
	}
	showRequest(att_pic + '<?= $trans['alert_title'].$trans['logout_alert']?>','textreq','');
}
function get_user_pass(u,p){
	showRequest(false,'editreq','');
	var tmp = 'login.php?action=login&user=' + u + '&pass=' + p;
	window.setTimeout('catch_logging_in()', 1000);
	ajaxpage(tmp,'editreqsource');
}
function log_user_in(){
	var aad = window.document.getElementById('plus_film');
	var imp = window.document.getElementById('import_film');
	var log = window.document.getElementById('log_inout');
	aad.innerHTML = adding_yes;
	imp.innerHTML = importing_yes;
	log.innerHTML = logout_src;
	mainframe.document.filterform.login.value = '1';
	mainframe.document.filterform.submit();
}
function log_user_out(){
	var aad = window.document.getElementById('plus_film');
	var imp = window.document.getElementById('import_film');
	var log = window.document.getElementById('log_inout');
	aad.innerHTML = adding_no;
	imp.innerHTML = importing_no;
	log.innerHTML = login_src;
	displayLCD();
	window.setTimeout('catch_logging_out()', 1000);
}
function submitenter(myfield,e){
	var keycode;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
	else return true;
	if (keycode == 13){
		myfield.form.submit();
		return false;
	}else return true;
}
// add.php function
function get_listheight(){
	var lh = <?= $cfg['listheight']?>;
<? 
if($cfg['autoheight']==true) {
echo '    if(document.body.offsetHeight) lh=document.body.offsetHeight-216;'."\n"; 
} 
?>
	document.titleform.lh.value = lh;
}
// print.php function
function print_page(){
	var title_should = "<?= $trans['page_title']?>:List";
	var title_could = "<?= $trans['page_title']?>:Help";
	var title_is = mainframe.document.title;
	var url = 'print.php';
	if(title_is == title_should){
		var a = '?view=' + mainframe.document.filterform.view.value;
		if(mainframe.document.filterform.filtertitle.value=='#') {
			var b = '&filtertitle=!';
		} else {
			var b = '&filtertitle=' + mainframe.document.filterform.filtertitle.value;
		}
		var c = '&filter=' + mainframe.document.filterform.filter.value;
		var d = '&genres=' + mainframe.document.filterform.genres.value;
		var e = '&sorter=' + mainframe.document.filterform.sorter.value;
		var f = '&tosearch=' + mainframe.document.filterform.tosearch.value;
		var g = '&searchin=' + mainframe.document.filterform.searchin.value;
		var h = '&sortby[0]=' + mainframe.document.filterform['sortby[0]'].value;
		var i = '&sortby[1]=' + mainframe.document.filterform['sortby[1]'].value;
		var j = '&sortby[2]=' + mainframe.document.filterform['sortby[2]'].value;
		url = encodeURI('print.php' + a + b + c + d + e + f + g + h + i + j);
	} else if(title_is == title_could){
		url = 'print_help.php';
	} else {
		var a = '?view=' + document.remember.view.value;
		if(document.remember.filtertitle.value=='#') {
			var b = '&filtertitle=!';
		} else {
			var b = '&filtertitle=' + document.remember.filtertitle.value;
		}
		var c = '&filter=' + document.remember.filter.value;
		var d = '&genres=' + document.remember.genres.value;
		var e = '&sorter=' + document.remember.sorter.value;
		var f = '&tosearch=' + document.remember.tosearch.value;
		var g = '&searchin=' + document.remember.searchin.value;
		var h = '&sortby[0]=' + document.remember['sortby[0]'].value;
		var i = '&sortby[1]=' + document.remember['sortby[1]'].value;
		var j = '&sortby[2]=' + document.remember['sortby[2]'].value;
		url = encodeURI('print.php' + a + b + c + d + e + f + g + h + i + j);
	}
	window.open(url,'_blank','toolbar=yes,menubar=yes,location=no,status=yes,resizable=yes,scrollbars=yes');
}
// getperson.php function
function setperson(id,name){
	var cat = document.tmpvars.cat.value;
	var idx = document.tmpvars.idx.value;
	var foa = cat + '[' + idx + '][id]';
	var fob = cat + '[' + idx + '][name]';
	var xxx = mainframe.document.getElementsByName(foa)[0];
	var yyy = mainframe.document.getElementsByName(fob)[0];
	xxx.value = id;
	yyy.value = name;
	showRequest(false,'editreq','');
}
/* editposter.php functions
function set_poster(){
	if(document.posterdata.noposter.checked){
		setnoposter();
	}
	showRequest(false,'editreq','');
}
function setposter(pid){
	var xxx = document.posterdata.url.value;
	var zzz = document.posterdata.noposter.checked;
	if(zzz != false){ 
		ajaxpage('resetposter.php?id=' + pid,'editreqsource');
	} else {
		ajaxpage('getposter.php?id=' + pid + '&url=' + xxx,'editreqsource');
	}
}
function disableposter(){
	if(document.posterdata.noposter.checked){
		document.posterdata.url.disabled = true;
	} else {
		document.posterdata.url.disabled = false;
	}
}
*/
function setnoposter(){
	mainframe.document.images['posterimg'].src = 'images/noposter.gif';
	mainframe.document.data.setposter.value = false;
	var obj = mainframe.document.getElementById("bytes");
	obj.innerHTML = '';
}
function settheposter(id){
	mainframe.document.images['posterimg'].src = 'imgget.php?for=' + id + '&from=session&foo='+(new Date()).getTime();
	mainframe.document.data.setposter.value = true;
	var obj = mainframe.document.getElementById("bytes");
	obj.innerHTML = '...';
}
function setavail(lent){
	if(!lent){
		document.data.lentto.value = 0;
		document.data.lentto.text = '-';
		document.data.lentto.selectedIndex = 0;
		document.data.lentsince.value = '0000-00-00';
		document.data.avail.value = '1';
	} else {
		document.data.lentsince.value = cur_date;
		document.data.avail.value = '0';
	}
}
function setNewStyle(fid,id,nx,avail,lentto,lentsince){
	var ls = lentsince.slice(8, 10) + '-' + lentsince.slice(5, 7) + '-' + lentsince.slice(0, 4);
	var lk = "editlent.php?fid=" + fid + "&id=" + id + "&nx=" + nx;
	var tt = "<?= $trans['t_lent'].' '.$trans['t_to'] ?> " + lenton[lentto] + " <?= $trans['t_at'] ?> " + ls;
	var td = "c_" + id; var tr = "r_" + nx + "_" + id; var imn = "avail_" + id;
	var obj = mainframe.document.getElementById(tr);
	var row = mainframe.document.getElementById('o_'+fid);
	var pic = mainframe.document.getElementById(td); var mark = true;
	if(obj.style.backgroundImage==""||obj.style.backgroundImage=="none") mark = false;
	var is_off = "<img title=\"" + tt + "\" onclick=\"fill_Request(\'editreq\');show_Request(true,\'editreq\',\'" + lk + "\');\" name=\"" + imn + "\" onmouseover=\"swap(\'" + imn + "\',\'avail_on\')\" onmouseout=\"swap(\'" + imn + "\',\'avail_no\')\" src=\"images/table/avail_no.png\" alt=\"+\" width=\"14\" height=\"14\" border=\"0\">";
	var is_on  = "<img onclick=\"fill_Request(\'editreq\');show_Request(true,\'editreq\',\'" + lk + "\');\" name=\"" + imn + "\" onmouseover=\"swap(\'" + imn + "\',\'avail_on\')\" onmouseout=\"swap(\'" + imn + "\',\'avail_is\')\" title=\"<?= $trans['available'] ?>\" src=\"images/table/avail_is.png\" alt=\"+\" width=\"14\" height=\"14\" border=\"0\">";
	if(avail==0) {
		if(!mark) {
			obj.style.backgroundColor = "#ffe3db";
		} else {
			obj.style.backgroundColor = "#ff867f";
			row.style.backgroundColor = "#ff867f";
		}	
		pic.innerHTML = is_off;
	} else {
		if(!mark) {
			if(nx==0) {
				obj.style.backgroundColor = "#ebf3ff";
			} else {
				obj.style.backgroundColor = "#ffffff";
			}
		} else {
			obj.style.backgroundColor = "#97d599";
			row.style.backgroundColor = "#97d599";
		}
		pic.innerHTML = is_on;
	}
}
function getPeople(){
	var x = document.data.pl.length;
	var t = 'cnt=' + x + '&id[0]=-';
	for(i=0;i<x;i++){
		t = t + '&id[' + (i+1) + ']=' + document.data.pl.options[i].value;
	}
	return t;
}
function addPerson(){
	var x = document.data.pl.length;
	document.data.pl.options[x] = new Option(noname,noname);
	document.data.pl.options[x].selected = true;
	document.data.edit.value = noname;
	document.data.id.value   = x;
}
function getUsers(){
	var x = document.data.ul.length;
	var t = 'cnt=' + x;
	for(i=0;i<x;i++){
		t = t + '&md[' + i + ']=' + document.data.ul.options[i].value + '&nm[' + i + ']=' + document.data.ul.options[i].text;
	}
	return t;
}
function addUser(){
	var x = document.data.ul.length;
	var now = new Date();
	document.data.ul.options[x] = new Option(noname,noname);
	document.data.ul.options[x].selected = true;
	document.data.ul.options[x].value = MD5(now.getTime());
	document.data.md5.value  = document.data.ul.options[x].value;
	document.data.name.value = noname;
	document.data.pass.value = '********';
	document.data.id.value   = x;
}
function delUser(l){
	if(l!=0) {
		document.data.ul.options[l] = null;
		document.data.ul.options[0].selected = true;
		document.data.md5.value  = document.data.ul.options[0].value;
		document.data.name.value = document.data.ul.options[0].text;
		document.data.pass.value = '********';
		document.data.id.value   = 0;
	}
}
function setvalue(obj,t,min,max){
	var v = parseInt(t);
	if(isNaN(v)) { v = max; }
	if(v > max){
		obj.value = max;
	} else if(v < min){
		obj.value = min;
	} else {
		obj.value = v;
	}
}
function setGET_add(){
	var title_should = "<?= $trans['page_title']?>:List";
	var title_is = mainframe.document.title;
	if(title_is == title_should){
		setGET();
	}
	fillRequest('editreq');
}
function setGET(){
	document.remember.page.value = mainframe.document.filterform.page.value;
	document.remember.view.value = mainframe.document.filterform.view.value;
	document.remember.filtertitle.value = mainframe.document.filterform.filtertitle.value;
	document.remember.filter.value = mainframe.document.filterform.filter.value;
	document.remember['sortby[0]'].value = mainframe.document.filterform['sortby[0]'].value;
	document.remember['sortby[1]'].value = mainframe.document.filterform['sortby[1]'].value;
	document.remember['sortby[2]'].value = mainframe.document.filterform['sortby[2]'].value;
	document.remember.sorter.value = mainframe.document.filterform.sorter.value;
	document.remember.genres.value = mainframe.document.filterform.genres.value;
	document.remember.tosearch.value = mainframe.document.filterform.tosearch.value;
	document.remember.searchin.value = mainframe.document.filterform.searchin.value;
}
function showLHRequest(url){
	var lh = <?= $cfg['listheight']?>;
<? 
if($cfg['autoheight']==true) {
echo '    		if(document.body.offsetHeight) lh=document.body.offsetHeight-216;'."\n"; 
} ?>
	theUrl = url+'?lh='+lh;
	fillRequest('editreq');
	showRequest(true,'editreq',theUrl);
}
function getLogging(){
	if(mainframe.logged_in==1){
		showLHRequest('askprefs.php');
	}else{
		showRequest(true,'editreq','editconfig.php');
	}
}
function getMatch(info){
	var txt = "<?= $trans['js_enter_file']?>";
	if(document.filename.upload_file.value==''){
		alert(txt);
		return false;
	}
	txt = "<?= $trans['js_enter_pattern']?>";
	// var path = document.filename.upload_file.value.split("/");
	// var file = path[path.length-1];
	var file = document.filename.upload_file.value;
	if(info=="uploaddbase.php"){
		if(!file.match(/filmdb_dbase_[0-9][0-9][0-1][0-9][0-3][0-9]-[0-2][0-9][0-5][0-9][0-5][0-9]\.zip$/)){
			alert(txt);
			return false;
		}
	}else{
		if(!file.match(/filmdb_poster_[0-9][0-9][0-1][0-9][0-3][0-9]-[0-2][0-9][0-5][0-9][0-5][0-9]\.zip$/)){
			alert(txt);
			return false;
		}
	}
	return true;
}
-->
</script>
<meta http-equiv="Content-Style-Type" content="text/css">
<link rel="stylesheet" type="text/css" href="config/<?php if(eregi('Win',$_SERVER['HTTP_USER_AGENT'])) { echo "win"; } else { echo "oos"; } ?>.css">
<style type="text/css">
<!--
	html, body { height:100%; overflow:auto; padding:0; margin:0; }
<? if(isset($_COOKIE['prefs'])) { ?>
	html, body, button, input, select, option, textarea { font-size: <?= $cfg['fontsize'] ?>em; }
	html, body {font-family:'<?= $cfg['fonttype'] ?>','Arial','Helvetica','sans-serif';}
<? } ?>
	small { font-size:80%; }
	big { font-size:120%; }
	strong { color: #990000; }
	dfn { font-style: normal; font-weight: bold; color: #006600; }
	var { font-style: normal; font-weight: bold; color: #000099; }
	h2 { font-size:160%; color:#666; display:inline; text-shadow: grey 3px 3px 4px; }
	h4 { font-size:120%; color:#333; display:inline; text-shadow: grey 2px 2px 3px; }
	h5 { font-size:100%; color:#666; display:inline; text-shadow: grey 1px 1px 2px; }
	button {
		background-color:#ccc;
		background-image:url(images/button/pattern.png);
		background-repeat: repeat-x;
		background-position: bottom;
		margin-top:8px;
		cursor:pointer;
	}
	input:focus { background: #ffe3db; color: black; }
	a { outline: none; text-decoration: none; font-weight: bold; color: #333333; }
	a:hover { text-decoration: none; font-weight: bold; color: #336699; }
	.txt { font-size:86%; }
	.thiny { margin-bottom: -<?= ($cfg['fontsize']*0.75) ?>em; }
	.display { font-size:11px; min-width:160px; width:100%; padding:0px 4px 0px 4px; }
	.row_0 { background-color: #EBF3FF; }
	.row_1 { background-color: #FFFFFF; }
	.mial { font-weight:bold; }
	.mial:before { content: " youcan[]gmx.net"; }
	.nobreak { overflow:hidden; display:none; visibility:hidden; }
	.no_progress {border-width:1px; border-style:solid; border-left-color:#707070; border-bottom-color:#eeeeee; border-right-color:#eeeeee; margin: 0px; margin-top: 2px; padding: 0px; width:200px; height:16px; background-image: url(images/progress.gif); background-repeat: repeat-x;}
	.progress {border-width:1px; border-style:solid; border-left-color:#707070; border-bottom-color:#eeeeee; border-right-color:#eeeeee; margin: 0px; margin-top: 2px; padding: 0px; width:200px; height:16px; background-image: url(images/progress_bg.gif); background-repeat: repeat-x;}
	#tosearch { width:80%; margin:0; padding:0; border:none; display:inline; }
	#wrapper { width:100%; height:100%; min-width:600px; min-height:400px; }
	#mainframe { width:100%; height:100%; min-height:240px; padding:0px; margin:0px; }
	#uploadframe { position:absolute; width:1px; height:1px; max-width:1px; max-height:1px; left:-100px; top:-100px; }
	#locker { display:none; visibility:hidden; z-index:999; position:absolute; top:0px; left:0px; width:100%; height:100%; }
	#request { overflow:visible; min-width:160px; min-height:100px; }
	#textreq { display:none; visibility:hidden; margin:32px 48px 24px 48px; min-width:100px; min-height:60px; }
	#editreq { display:none; visibility:hidden; margin:32px 48px 24px 48px; min-width:100px; min-height:60px; }
	#textreqsource { margin:16px; }
	#innereditreq { margin:16px; }
	#listarea {
		height: <?= $cfg['listheight']?>px;
		width: auto;
		min-width: <?php if(eregi('Opera',$_SERVER['HTTP_USER_AGENT'])) { echo "270"; }else { echo "320"; } ?>px;
		max-width: 640px;
		overflow: auto;
		border-width: 2px;
		border-style: solid;
		border-top-color: #d0d0d0;
		border-right-color: #f0f0f0;
		border-bottom-color: #f0f0f0;
		border-left-color: #d0d0d0;
		background-color:#ffffff;
	}
	#logarea {
		height: <?= $cfg['listheight']?>px;
		min-height: 160px;
		width: 480px;
		max-width: 640px;
		overflow: auto;
		border-width: 2px;
		border-style: solid;
		border-top-color: #d0d0d0;
		border-right-color: #f0f0f0;
		border-bottom-color: #f0f0f0;
		border-left-color: #d0d0d0;
		background-color:#ffffff;
		font-family:'Courier','Courier new','monospace';
	}
	#icell { width:100%; height:100%; }
-->
</style>
<!--[if gt IE 6]>
<style type="text/css">
	#icell { width:99%; height: expression(parseInt(document.body.offsetHeight-98)); }
	#listarea {
		height: <?= $cfg['listheight']?>px;
		width: 320px;
		min-width: 270px;
		max-width: 640px;
		overflow: auto;
		border-width: 2px;
		border-style: solid;
		border-top-color: #d0d0d0;
		border-right-color: #f0f0f0;
		border-bottom-color: #f0f0f0;
		border-left-color: #d0d0d0;
		background-color:#ffffff;
	} 
</style>
<![endif]-->
<!--[if lt IE 7]>
<style type="text/css">
	img, td { behavior: url(config/iepngfix.htc); }
	#icell { width:100%; height: expression(parseInt(document.body.offsetHeight-98)); }
	#listarea {
		height: <?= $cfg['listheight']?>px;
		width: 300px;
		min-width: 270px;
		max-width: 640px;
		overflow: auto;
		border-width: 2px;
		border-style: solid;
		border-top-color: #d0d0d0;
		border-right-color: #f0f0f0;
		border-bottom-color: #f0f0f0;
		border-left-color: #d0d0d0;
		background-color:#ffffff;
	}
</style>
<![endif]-->
</head>
<body background="images/backgrnd.png" bgcolor="#B8B8B8" text="#333333" vlink="#333333" alink="#336699" link="#333333" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="if(window.XMLHttpRequest||window.ActiveXObject){fillRequest('editreq');showRequest(true,'editreq','about.php');}">
<table id="wrapper" border="0" cellspacing="0" cellpadding="0" width="100%" height="100%">
	<tr>
		<td><img src="images/space.gif" width="24" height="48" border="0"></td><td></td>
		<td valign="bottom" width="100%">
			<table align="center" border="0" cellpadding="0" cellspacing="0">
				<tr><td valign="bottom">
					<img src="images/button/film_off.png" title="<?= $trans['film_view']?>" alt="film-view" width="25" height="24" border="0" name="film_view" id="film_view" onclick="to_film_view();">
				</td><td valign="bottom">
					<img src="images/button/row_off.png" title="<?= $trans['row_view']?>" alt="row-view" width="26" height="24" border="0" name="row_view" id="row_view" onclick="to_row_view();">
				</td><td valign="bottom">
					<img src="images/button/poster_off.png" title="<?= $trans['poster_view']?>" alt="poster-view" width="26" height="24" border="0" name="poster_view" id="poster_view" onclick="to_poster_view();">
				</td><td valign="bottom">
					<img src="images/button/list_on.png" title="<?= $trans['list_view']?>" alt="list-view" width="26" height="24" border="0" name="list_view" id="list_view" onclick="to_list_view();">
				</td><td><img src="images/space.gif" width="12" height="24" border="0"></td>
				<td valign="bottom" nowrap>
					<img onClick="fillRequest('editreq');showRequest(true,'editreq','ajax.php');" src="images/ajax.png" alt="AJAX" title="<?= $trans['ajax']?>" width="20" height="20" border="0">&nbsp;<img onClick="fillRequest('editreq');showRequest(true,'editreq','about.php');" src="images/<?= $cfg['titlelogo']?>" alt="<?= $trans['page_title']?>" title="<?= $trans['about']?>" width="90" height="20" border="0">
				</td><td width="20%"><img src="images/space.gif" width="12" height="24" border="0"></td>
				<td valign="bottom" nowrap>
					<table width="172" height="24" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td><img src="images/info/g1.png" width="6" height="6" border="0"></td><td background="images/info/g2.png"></td><td><img src="images/info/g3.png" width="6" height="6" border="0"></td>
					</tr><tr>
						<td background="images/info/g4.png"></td>
						<td id="lcd" class="display" background="images/info/g5.png" bgcolor="#bdcaac" align="center" nowrap><?= $trans['version']?>&nbsp;<b><?= $cfg['filmdb_version']?></b>&nbsp;&bull;&nbsp;<?= $cfg['filmdb_release']?></td>
						<td background="images/info/g6.png"></td>
					</tr><tr>
						<td><img src="images/info/g7.png" width="6" height="6" border="0"></td><td background="images/info/g8.png"></td><td><img src="images/info/g9.png" width="6" height="6" border="0"></td>
					</tr>
					</table>
				</td><td width="8"><img src="images/space.gif" width="8" height="24" border="0"></td>
				<td valign="bottom" width="30" id="plus_film">
					<img src="images/button/plus_off.png" title="<?= $trans['add_film']?>" alt="add" width="30" height="24" border="0" name="plus_film" onClick="change('plus_film','plus_off');showRequest(att_pic + '<?= $trans['alert_title'].$trans['login_alert']?>','textreq','');" onmouseover="change('plus_film','plus_on')" onmouseout="change('plus_film','plus_off')">
				</td><td><img src="images/space.gif" width="4" height="24" border="0"></td>
				<td valign="bottom" width="30" id="import_film">
					<img src="images/button/import_off.png" title="<?= $trans['import_film']?>" alt="import" width="30" height="24" border="0" name="import_film" onClick="change('import_film','import_off');showRequest(att_pic + '<?= $trans['alert_title'].$trans['login_alert']?>','textreq','');" onmouseover="change('import_film','import_on')" onmouseout="change('import_film','import_off')">
				</td><td width="20%"><img src="images/space.gif" width="4" height="24" border="0"></td>
				<td valign="bottom" width="30">
					<img src="images/button/print_off.png" title="<?= $trans['print_dbase']?>" alt="print-db" width="30" height="24" border="0" name="print_db" onClick="fillRequest('editreq');change('print_db','print_off');showRequest(true,'editreq','askprint.php?title=' + mainframe.document.title);" onmouseover="change('print_db','print_on')" onmouseout="change('print_db','print_off')">
				</td><td><img src="images/space.gif" width="4" height="24" border="0"></td>
				<td valign="bottom" width="30">
					<img src="images/button/info_off.png" title="<?= $trans['db_info']?>" alt="db-info" width="30" height="24" border="0" name="db_info" onClick="fillRequest('editreq');change('db_info','info_off');showRequest(true,'editreq','info.php');" onmouseover="change('db_info','info_on')" onmouseout="change('db_info','info_off')">
				</td><td><img src="images/space.gif" width="4" height="24" border="0"></td>
				<td valign="bottom" width="30">
					<img src="images/button/prefs_off.png" title="<?= $trans['edit_prefs']?>" alt="edit-prefs" width="30" height="24" border="0" name="edit_pref" onClick="setGET_add();change('edit_pref','prefs_off');getLogging();" onmouseover="change('edit_pref','prefs_on')" onmouseout="change('edit_pref','prefs_off')">
				</td><td><img src="images/space.gif" width="4" height="24" border="0"></td>
				<td valign="bottom" width="30" id="log_inout">
					<img src="images/button/login_off.png" title="<?= $trans['log_in']?>" alt="login/out" width="30" height="24" border="0" name="log_inout" onClick="setGET_add();change('log_inout','login_off');showRequest(true,'editreq','login.php');" onmouseover="change('log_inout','login_on')" onmouseout="change('log_inout','login_off')">
				</td>
<? if(isset($help)) { ?>
				<td width="8"><img src="images/space.gif" width="8" height="24" border="0"></td>
				<td valign="bottom" width="24">
					<a href="show_help.php" target="mainframe"><img src="images/button/help_off.png" title="<?= $trans['prog_help']?>" alt="help" width="24" height="24" border="0" name="help" onClick="setGET_add();" onmouseover="change('help','help_on');window.status=' ';return true;" onmouseout="change('help','help_off')"></a>
				</td></tr>
				<tr><td colspan="22" height="8"></td></tr>
<? } else { ?>
				</tr><tr><td colspan="20" height="8"></td></tr>
<? } ?>
			</table>
		</td>
		<td></td><td><img src="images/space.gif" width="24" height="48" border="0"></td>
	</tr><tr>
		<td></td><td><img src="images/frame/lt.png" width="13" height="13" border="0"></td><td background="images/frame/t.png"></td><td><img src="images/frame/rt.png" width="13" height="13" border="0"></td><td></td>
	</tr><tr>
		<td></td><td background="images/frame/l.png"></td><td id="icell" bgcolor="#ffffff">
<iframe id="mainframe" name="mainframe" src="list.php" width="100%" height="100%" frameborder="0" scrolling="auto"></iframe>
		</td><td background="images/frame/r.png"></td><td></td>
	</tr><tr>
		<td></td><td><img src="images/frame/lb.png" width="13" height="13" border="0"></td><td background="images/frame/b.png"></td><td><img src="images/frame/rb.png" width="13" height="13" border="0"></td><td></td>
	</tr><tr>
		<td><img src="images/space.gif" width="24" height="24" border="0"></td><td></td><td align="center"></td><td></td><td><img src="images/space.gif" width="24" height="24" border="0"></td>
	</tr>
</table>
<div id="locker">
<table id="request" width="10%" height="10%" align="center" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="background:url(images/request/sl.png);"></td><td background="images/request/pattern.png" bgcolor="#ffffff" width="100%" height="100%" align="center" valign="middle">
			<div id="textreq">
				<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td><img src="images/view/p1.png" width="10" height="10" border="0"></td>
						<td background="images/view/p2.png"></td>
						<td><img src="images/view/p3.png" width="10" height="10" border="0"></td>
					</tr><tr>
						<td background="images/view/p4.png"></td>
						<td background="images/view/p5.png" bgcolor="#f0f0f0" align="left">
							<div id="textreqsource"></div>
						</td>
						<td background="images/view/p6.png"></td>
					</tr><tr>
						<td><img src="images/view/p7.png" width="10" height="10" border="0"></td>
						<td background="images/view/p8.png"></td>
						<td><img src="images/view/p9.png" width="10" height="10" border="0"></td>
					</tr>
				</table>
				<button name="ok" type="button" value="OK" style="cursor:pointer;" onClick="showRequest(false,'textreq','');">&nbsp;&nbsp;<b><?= $trans['b_ok']?></b>&nbsp;&nbsp;</button>
			</div>
			<div id="editreq"><div id="editreqsource" align="left"></div></div>
		</td><td style="background:url(images/request/sr.png);"></td>
	</tr><tr>
		<td><img src="images/request/slb.png" width="8" height="8" border="0"></td><td style="background:url(images/request/sb.png);"></td><td><img src="images/request/srb.png" width="8" height="8" border="0"></td>
	</tr>
</table>
</div>
<form class="nobreak" name="remember" target="mainframe" action="list.php" method="GET">
<input type="hidden" name="page" value="0">
<input type="hidden" name="view" value="list">
<input type="hidden" name="filtertitle" value="*">
<input type="hidden" name="filter" value="">
<input type="hidden" name="sortby[0]" value="inserted_DESC">
<input type="hidden" name="sortby[1]" value="nr ASC">
<input type="hidden" name="sortby[2]" value="local ASC">
<input type="hidden" name="sorter" value="inserted_DESC">
<input type="hidden" name="genres" value="">
<input type="hidden" name="tosearch" value="">
<input type="hidden" name="searchin" value="movies.name,aka">
</form>
</body>
</html>
