var tmp='',nof=9;
function $(v) {return document.getElementById(v);}
window.addEventListener("DOMContentLoaded",domready,false);
window.scrollTo(0,0.9);
window.onorientationchange=updateResize;
if(typeof(window.orientation)==="undefined") {
	window.onresize=updateResize;
}
window.onunload=savestorage;
window.onload=function() {
	settitle();
	setsorter();
	setsearcher();
	setselector();
	if(navigator.userAgent.indexOf('WebKit')>-1) {$("go").style.bottom="1px";}
};
function domready() {
	//NOP
}
function getResolution() {
	return (parseInt(window.innerWidth/(100+3+3),10)*parseInt((window.innerHeight-40-40)/(100+8+12),10));
}
function updateResize() {
	savestorage();
	nof=getResolution();
	loadstorage();
	window.location.href='index.php'+tmp;
	return false;
}

function savestorage() {
	if(window.localStorage) {
		try {
			localStorage.view=document.filterform.view.value||'poster';
			localStorage.page=document.filterform.page.value||0;
			localStorage.filtertitle=document.filterform.filtertitle.value||'';
			localStorage.sorter=document.filterform.sorter.value||'inserted_DESC';
			localStorage.genres=document.filterform.genres.value||'';
			localStorage.sortby0=document.filterform['sortby[0]'].value||'inserted DESC';
			localStorage.sortby1=document.filterform['sortby[1]'].value||'nr ASC';
			localStorage.sortby2=document.filterform['sortby[2]'].value||'year ASC';
			localStorage.tosearch=document.filterform.tosearch.value||'';
			localStorage.searchin=document.filterform.searchin.value||'movies.name,aka';
			localStorage.filter=document.filterform.filter.value||'';
			localStorage.count=document.filterform.count.value||nof;
		} catch (e) {
		}
	}
}			
function loadstorage() {
	if(window.localStorage) {
		try {
			tmp='?view='+(localStorage.view||'poster');
			tmp+='&page='+(localStorage.page||0);
			tmp+='&filtertitle='+(localStorage.filtertitle||'');
			tmp+='&sorter='+(localStorage.sorter||'inserted_DESC');
			tmp+='&genres='+(localStorage.genres||'');
			tmp+='&sortby[0]='+(localStorage.sortby0||'inserted DESC');
			tmp+='&sortby[1]='+(localStorage.sortby1||'nr ASC');
			tmp+='&sortby[2]='+(localStorage.sortby2||'year ASC');
			tmp+='&tosearch='+(localStorage.tosearch||'');
			tmp+='&searchin='+(localStorage.searchin||'movies.name,aka');
			tmp+='&filter='+(localStorage.filter||'');
			tmp+='&count='+(nof||localStorage.count);
		} catch (e) {
			tmp='';
		}
	}
}			
function setfilm(v) {
	document.filterform.page.value=parseInt(v,10);
	document.filterform.view.value='film';
	document.filterform.submit();
}
function setposter(v) {
	document.filterform.page.value=parseInt(v,10);
	document.filterform.view.value='poster';
	document.filterform.submit();
}
function setpage(v) {
	if(document.filterform.view.value=='film') {
		setfilm(v);
	}else {
		setposter(v);
	}
}
function settitle() {
	if(document.filterform.view.value=='film') {
		$("the_id").innerHTML=cur_id||'?0000';
	}else {
		$("the_id").innerHTML='FilmDB';
	}
}
function openconf(v) {
	var ele=$(v||'conf');
	var obj=$('view');
	if(ele&&obj) {
		ele.minHeight=obj.clientHeight+'px';
		ele.style.visibility='visible';
	}
	return false;
}
function closeconf(v) {
	var ele=$(v||'conf');
	if(ele) {ele.style.visibility='hidden';}
	return false;
}
function switchconf(to,tc) {
	$(to).style.display='block';
	$(tc).style.display='none';
	return false;
}
function setsorter() {
	var ele=$(document.filterform.sorter.value);
	if(ele) {$('sorter').innerHTML=ele.innerHTML;}
}
function setsearcher() {
	var ele='',tmp=document.filterform.searchin.value;
	if(tmp==''||tmp=='movies.name,aka') {
		ele=$('st_all');
	}else if(tmp=='directs.movie_fid = movies.fid AND directs.people_id = people.id AND people.name') {
		ele=$('st_directs');
	}else if(tmp=='writes.movie_fid = movies.fid AND writes.people_id = people.id AND people.name') {
		ele=$('st_writes');
	}else if(tmp=='plays_in.movie_fid = movies.fid AND plays_in.people_id = people.id AND people.name') {
		ele=$('st_plays');
	}else {
		ele=$('st_'+tmp);
	}
	if(ele) {$('searchin').innerHTML=ele.innerHTML;}
}
function setselector() {
	var ele='',tmp=document.filterform.filtertitle.value;
	if(tmp=='*') {
		ele=$('sb_all');
	}else if(tmp=='#') {
		ele=$('sb_0-9');
	}else {
		ele=$('sb_'+tmp);
	}
	if(ele) {$('selector').innerHTML=ele.innerHTML;}
}
function addClass(ele,className) {
	if(!hasClass(ele,className)) {ele.className+=" "+className;}
}
function hasClass(ele,className) {
	return ele.className.match(new RegExp('(\\s|^)'+className+'(\\s|$)'));
}
function toogleClass(ele,className) {
	if(hasClass(ele,className)) {removeClass(ele,className); return false;} addClass(ele,className); return true;
}
function removeClass(ele,className) {
	if(hasClass(ele,className)) {var reg=new RegExp('(\\s|^)'+className+'(\\s|$)'); ele.className=ele.className.replace(reg,' ');}
}
function switchCheckbox(ele) { var onClass='selected',offClass='unselected';
	if(hasClass(ele,onClass)) {
		removeClass(ele,onClass); 
		addClass(ele,offClass);
		ele.getElementsByTagName("input")[0].checked=false;
	}else if(hasClass(ele,offClass)) {
		removeClass(ele,offClass); 
		addClass(ele,onClass);
		ele.getElementsByTagName("input")[0].checked=true;
	}
}
function sortby(s) {
	var theBlank=s.indexOf('_'); var onClass='selected',offClass='unselected';
	var ele=$(document.filterform.sorter.value);
	if(ele) {
		removeClass(ele,onClass); 
		addClass(ele,offClass);
	}
	ele=$(s);
	if(ele) {
		removeClass(ele,offClass); 
		addClass(ele,onClass);
	}
	for(var i=0; i<s_size-1; i++) {
		if(document.filterform['sortby['+i+']'].value.substring(0,theBlank)==s.substring(0,theBlank)) {
			break;
		}
	}
	for(i;i>0;i-=1) {
		document.filterform['sortby['+i+']'].value=document.filterform['sortby['+(i-1)+']'].value;
	}
	document.filterform['sortby[0]'].value=s.replace('_',' ');
	document.filterform['sorter'].value=s;
	document.filterform.submit();
}
function searchat(s,v){
	var ele='',onClass='selected',offClass='unselected'; 
	var tmp=document.filterform.searchin.value;
	if(tmp==''||tmp=='movies.name,aka') {
		ele=$('st_all');
	}else if(tmp=='directs.movie_fid = movies.fid AND directs.people_id = people.id AND people.name') {
		ele=$('st_directs');
	}else if(tmp=='writes.movie_fid = movies.fid AND writes.people_id = people.id AND people.name') {
		ele=$('st_writes');
	}else if(tmp=='plays_in.movie_fid = movies.fid AND plays_in.people_id = people.id AND people.name') {
		ele=$('st_plays');
	}else {
		ele=$('st_'+tmp);
	}
	if(ele) {
		removeClass(ele,onClass); 
		addClass(ele,offClass);
	}
	ele=$(s);
	if(ele) {
		removeClass(ele,offClass); 
		addClass(ele,onClass);
		$('searchin').innerHTML=ele.innerHTML;
	}
	document.filterform['searchin'].value=v;
	switchconf('level_0','level_3-1');
}
function selectby(s) { 
	var onClass='selected',offClass='unselected';
	for(var i=97; i<123; i++) {ele=$('sb_'+String.fromCharCode(i));
		if(hasClass(ele,onClass)) {removeClass(ele,onClass); addClass(ele,offClass);}
	}
	var ele=$('sb_all');
	if(hasClass(ele,onClass)) {removeClass(ele,onClass); addClass(ele,offClass);}
	var ele=$('sb_0-9');
	if(hasClass(ele,onClass)) {removeClass(ele,onClass); addClass(ele,offClass);}
	var ele=$(s);
	if(hasClass(ele,offClass)) {removeClass(ele,offClass); addClass(ele,onClass);}
}
			
function tfilter(f,typ){
	if(typ==null||typ=='') {typ='movies.name,aka'; }
	var allgenres=true;
	var query='SELECT SQL_CALC_FOUND_ROWS _COLS_ FROM ';
	switch(typ){
		case 'directs.movie_fid = movies.fid AND directs.people_id = people.id AND people.name':
			query+='movies,directs,people';
			break;
		case 'writes.movie_fid = movies.fid AND writes.people_id = people.id AND people.name':
			query+='movies,writes,people';
			break;
		case 'plays_in.movie_fid = movies.fid AND plays_in.people_id = people.id AND people.name':
			query+='movies,plays_in,people';
			break;
		default:
			query+='movies';
	}
	query+=' WHERE ';
	document.filterform.genres.value='';
	if(f!='#') {
		document.filterform.tosearch.value=f;
	}else {
		document.filterform.tosearch.value='';
	}
	gquery='';
	for(i=0;;i++) {
		if(!(cur=$('genres_'+i))) {
			break;
		}
		if(cur.checked) {
			document.filterform.genres.value+=','+cur.value;
			if(gquery=='') {
				gquery+='FIND_IN_SET(\''+cur.value+'\',genre)>0';
			} else {
				gquery+=' OR FIND_IN_SET(\''+cur.value+'\',genre)>0';
			}
		}else {
			allgenres=false;
		}
	}
	if(allgenres) {
		document.filterform.genres.value='';
	}else {
		if(gquery==''){
			gquery='FIND_IN_SET(\',Action\',genre)>0';
		}
		query+='('+gquery+')';
	}
	if(f==''&&allgenres) query+='1';
	if(f!=''&&!allgenres) query+=' AND ';
	rExp=/\'/gi;
	f=f.replace(rExp,'\\\'');
	if(f=='#'){
		document.filterform['filter'].value=query+'local REGEXP \'^[^a-zA-Z]\'';
		document.filterform.filtertitle.value='#';
		typ='movies.name,aka';
	} else if(f=='?'){
		document.filterform['filter'].value=query+'(YEAR(inserted) = YEAR(CURRENT_DATE) AND MONTH(inserted) = MONTH(CURRENT_DATE))';
		document.filterform.filtertitle.value='?';
	} else if((f.length==1)&&(typ!='avail')&&(typ!='disks')){
		document.filterform['filter'].value=query+'local like \''+f+'%\'';
		document.filterform.filtertitle.value=f.toLowerCase();
		typ='movies.name,aka';
	} else if(f!=''){
		if(typ=='movies.name,aka') {
			document.filterform['filter'].value=query+'MATCH(movies.name,aka) AGAINST(\''+f+'\' IN BOOLEAN MODE)';
			document.filterform.filtertitle.value=f.toLowerCase();
		} else {
			document.filterform['filter'].value=query+typ+' like \'%'+f+'%\'';
			document.filterform['searchin'].value=typ;
		}
	} else {
		document.filterform['filter'].value=query;
		document.filterform.filtertitle.value='*';
		typ='movies.name,aka';
	}
	document.filterform.page.value='0';
	if(typ=='movies.name,aka') {
		document.filterform['searchin'].value=typ;
	} else {
		document.filterform.filtertitle.value='*';
	}
	document.filterform.submit();
}
function checkGenres(val) {var ele='',lio='',onClass='selected',offClass='unselected';
	for(i=0;;i++) {
		if(!(ele=$('genres_'+i))) {break;}
		else {ele.checked=val; lio=ele.parentNode;
			if(val) {
				removeClass(lio,offClass); 
				addClass(lio,onClass);
			}else {
				removeClass(lio,onClass); 
				addClass(lio,offClass);
			}
		}
	}
}
function showall() {
	document.filterform.genres.value='';
	document.filterform['filter'].value='';
	document.filterform.filtertitle.value='*';
	document.filterform['tosearch'].value='';
	document.filterform['searchin'].value='movies.name,aka';
	document.filterform.page.value='0';
	document.filterform.submit();
}
function submitenter(e) {
	if(e.which==13) {
		tfilter(document.filterform.title.value,document.filterform.searchin.value);
	}else {
		return true;
	}
}
