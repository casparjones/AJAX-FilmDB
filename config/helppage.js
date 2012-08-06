// rawly basic XMLHttpRequest implementation

function ajaxhelp(url, containerid){
	var page_request = false;
	if(window.XMLHttpRequest) {
		page_request = new XMLHttpRequest();
	} else if(window.ActiveXObject) {
		try {
			page_request = new ActiveXObject("Msxml2.XMLHTTP");
		} catch(e) {
			try {
				page_request = new ActiveXObject("Microsoft.XMLHTTP");
			} catch(e) {
			}
		}
	} else {
		return false;
	}
	page_request.onreadystatechange = function(){loadhelp(page_request, containerid);}
	page_request.open('POST', url, true);
	page_request.send(null);
}

function loadhelp(page_request, containerid){
	if (page_request.readyState == 4 && (page_request.status==200 || window.location.href.indexOf("http")==-1)){
		mainframe.document.getElementById(containerid).innerHTML=page_request.responseText;
	}
}