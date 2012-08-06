var tmp='';
window.addEventListener("DOMContentLoaded",domready,false);
window.scrollTo(0,0.9);
window.onorientationchange=updateOrientation;
if(typeof(window.orientation)==="undefined") {
	window.onresize=checkOrientation;
}
window.onunload=savestorage;
window.onload=function() {
	settitle();
	setsorter();
	setsearcher();
	setselector();
	tmp=$("scrollthumb");
	if(tmp&&typeof(window.orientation)==="undefined") {
		setupscroller();
		setscroller();
	}else {
		tmp.style.display="none";
	}
};
function domready() {
	tmp=$("wrapper");
	if(typeof(window.orientation)==="undefined") {
		tmp.style.height=window.innerHeight+'px';
	}else{
		tmp.style.height=1230+'px';
		tmp.style.maxHeight=1230+'px';
		document.body.style.background='black';
	}
}
function $(v) {return document.getElementById(v);}
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
		} catch (e) {
			tmp='';
		}
	}
}			
function checkOrientation() {
	var w=window.innerWidth,h=window.innerHeight;
	if(w<h && window.location.href!='portrait.php') {
		window.orientation=0;
		updateOrientation();
	}else if(w>h && window.location.href!='landscape.php') {
		window.orientation=90;
		updateOrientation();
	}return false;
}
function updateOrientation() {
	savestorage();
	loadstorage();
	switch(window.orientation) {
		case 0:   // Portrait
		case 180: // Upside-down Portrait
			if(window.location.href!='portrait.php') {
				window.location.href='portrait.php'+tmp;
			}
		break;
		case -90: // Landscape: turned 90 degrees counter-clockwise
		case 90:  // Landscape: turned 90 degrees clockwise
			if(window.location.href!='landscape.php') {
				window.location.href='landscape.php'+tmp;
			}
		break;
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
	if(typeof(window.orientation)==="undefined") {
		setscroller();
	}
	return false;
}
function closeconf(v) {
	var ele=$(v||'conf');
	if(ele) {ele.style.visibility='hidden';}
	if(typeof(window.orientation)==="undefined") {
		setscroller();
	}
	return false;
}
function switchconf(to,tc) {
	$(to).style.display='block';
	$(tc).style.display='none';
	if(typeof(window.orientation)==="undefined") {
		setscroller();
	}
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
function setscrollbar(obj) {
	var a=$("view"),b=$("conf"),ele='',eo=0,so=0;
	if(a&&b&&obj) {
		ele=(b.style.visibility!='hidden'?b:a);
		eo=Math.min(ele.offsetHeight-obj.maxheight,Math.max(0,Math.floor(obj.curY*obj.factorE)));
		so=Math.ceil(eo*obj.factorS);
		ele.style.top=(eo*-1)+'px';
		obj.style.top=so+'px';
	}
}
function setscroller() {
	var a=$("view"),b=$("conf"),obj=$("scrollthumb"),par=$("wrapper"),zero=false,ele='',h=0,y=0,f=1,k=1;
	if(a&&b&&obj&&par) {
		obj.style.opacity=0.0; 
		zero=(b.style.visibility!='hidden'?true:false);
		ele=(zero?b:a);
		f=par.offsetHeight/ele.offsetHeight;
		k=ele.offsetHeight/par.offsetHeight;
		h=Math.min(par.offsetHeight,Math.max(10,Math.floor(par.offsetHeight*f)));
		y=Math.min(par.offsetHeight-h,Math.max(0,Math.floor(par.offsetTop*f)));
		if(zero) {obj.curY=0; y=0;}
		obj.style.top=y+'px';
		obj.style.height=h+'px';
		obj.style.opacity=(h==par.offsetHeight?0.0:0.3);
		obj.maxheight=par.offsetHeight;
		obj.objheight=h;
		obj.offsetY=y;
		obj.factorE=k;
		obj.factorS=f;
		setscrollbar(obj);
	}
}
function setupscroller() {
	var obj=$("scrollthumb");
	if(obj) {
		obj.dragging=false; 
		obj.offsetY=0;
		obj.deltaY=0; 
		obj.evtY=0;
		obj.curY=0;
		obj.setAttribute('touchcancel','');
		if(typeof obj['touchcancel']=='function') {
			obj.touchstart=_isTouched;
			obj.touchmove=_isMoved;
			obj.touchend=_isCanceled;
			obj.touchcancel=_isCanceled;
		}else {
			obj.oncontextmenu=function() {return false;};
			obj.onmousedown=_isPressed; 
			obj.onmousemove=_isDragged; 
			obj.onmouseup=_isReleased; 
			obj.onmouseout=_isReleased; 
		}
	}
}

function _isTouched(e) {
		e.preventDefault();
		this.dragging=true; 
		this.style.opacity=0.75;
		this.evtY=e.touches[0].pageY-this.offsetY; 
		this.deltaY=this.evtY-this.curY;
		//window.document.title='pressed evtY:'+this.evtY+' deltaY:'+this.deltaY;
		return false;
}
function _isMoved(e) {
		e.preventDefault();
		if(!this.dragging) {return false;}
		this.evtY=e.touches[0].pageY-this.offsetY;
		this.curY=Math.min(this.maxheight-this.objheight,Math.max(0,this.evtY-this.deltaY));
		this.style.top=this.curY+'px';
		setscrollbar(this);
		//window.document.title='dragged evtY:'+this.evtY+' curY:'+this.curY;
		return false;
}	
function _isCanceled(e) {
		e.preventDefault();
		if(!this.dragging) {return false;}
		this.dragging=false; 
		this.style.opacity=0.3;
		//window.document.title='released';
		return false;
}

function _isPressed(e) {
		this.dragging=true; 
		this.style.cursor='ns-resize'; 
		this.style.opacity=0.75;
		this.evtY=e.pageY-this.offsetY; 
		this.deltaY=this.evtY-this.curY;
		//console.log('pressed evtY:'+this.evtY+' deltaY:'+this.deltaY);
		return false;
}
function _isDragged(e) {
		if(!this.dragging) {return false;}
		this.evtY=e.pageY-this.offsetY;
		this.curY=Math.min(this.maxheight-this.objheight,Math.max(0,this.evtY-this.deltaY));
		this.style.top=this.curY+'px';
		setscrollbar(this);
		//console.log('dragged evtY:'+this.evtY+' curY:'+this.curY);
		return false;
}	
function _isReleased(e) {
		if(!this.dragging) {return false;}
		this.dragging=false; 
		this.style.cursor='auto'; 
		this.style.opacity=0.3;
		//console.log('released');
		return false;
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
