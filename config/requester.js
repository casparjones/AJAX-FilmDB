// rawly basic XMLHttpRequest implementation

function ajaxpage(url, containerid){
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
	
	var timeoutid = window.setTimeout(
		function() {
			if(callinprogress(page_request)) {
				page_request.abort();
				reporttimeout();
			}
		},
		5000
	);	
	
	page_request.onreadystatechange = function(){loadpage(page_request, containerid, timeoutid);}
	page_request.open('GET', url, true);
	if(!callinprogress(page_request)) {
		page_request.send(null);
	}else {
		reportinprogress();
	}	
}

function callinprogress(page_request) {
	switch(page_request.readyState) {
		case 1, 2, 3:
			return true;
			break;
		default:
			return false;
			break;
	}
}

function reporttimeout() {
	alert("A request was timed out. Taking too long");
}

function reportinprogress() {
	alert("I'm busy. Wait a moment");
}

function loadpage(page_request, containerid, timeoutid){
	if (page_request.readyState == 3){
		window.clearTimeout(timeoutid);
	}else if (page_request.readyState == 4 && (page_request.status==200 || window.location.href.indexOf("http")==-1)){
		document.getElementById(containerid).innerHTML=page_request.responseText;
	}
}


