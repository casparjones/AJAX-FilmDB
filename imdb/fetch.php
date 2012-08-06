<?php
/* FetchScripts BaseClass
   Generic functions for FetchScripts*/

//search-return-constant
define("PML_FETCH_SEARCHERROR",0);
define("PML_FETCH_SEARCHDONE",1);
define("PML_FETCH_EXACTMATCH",2);

//fetch-return-constant
define("PML_FETCH_ERROR",0);
define("PML_FETCH_OK",1);
define("PML_FETCH_ITEMNOTFOUND",2);

class pml_fetch {

	//Returns the currenlty set FetchID for this FetchScript (or '' if not def)
	function getFetchID() {
		return($this->FetchID);
	}

	//Sets the FetchID for this fetch-script
	function setFetchID($FetchID) {
		$this->FetchID = $FetchID;
	}

	var $FetchID = '';
	var $site = '';
	var $site_url = '';

	function fetchCachedUrl($Url, $Host, $Referer=''){
		global $cfg;
		
		// check if the site already has been fetched from imdb
		if($this->site_url == $Url) return $this->site;
		$this->site_url = $Url;
		
		if(isset($_SESSION['http_cache'][$Url])){
			$this->site = &$_SESSION['http_cache'][$Url];
			return $_SESSION['http_cache'][$Url];
		}
		
		// fetch site from imdb:
		
		// construct request
		$data = "GET $Url HTTP/1.0\r\n";
		$data .= "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.5) Gecko/20070508 Firefox/1.5.0.12\r\n";
		$data .= "Accept: text/html, image/png, image/x-xbitmap, image/gif, image/jpeg, */*\r\n";
		$data .= "Accept-Language: en, de\r\n";
		if($cfg['http_compress'])
			$data .= "Accept-Encoding: gzip, deflate, identity, chunked;q=0, *;q=0\r\n";
		else
			$data .= "Accept-Encoding: identity, chunked;q=0, *;q=0\r\n";
		$data .= "Referer: $Referer\r\n";  //with given referer
		$data .= "Host: $Host\r\n";
		//$data .= "Keep-Alive: 300\r\n";		
		//$data .= "Connection: Keep-Alive\r\n";
		$data .= "Cache-Control: no-cache\r\n";
		$data .= "\r\n";
				
		if($cfg['http_cache_size']>0){
			$this->FetchPage($data, $Host, $_SESSION['http_cache'][$Url]);
			$this->site = &$_SESSION['http_cache'][$Url];
			$this->manageCache($Url);
		} else {	
			$this->FetchPage($data, $Host, $this->site);
		}
		
		return $this->site;
	}
	function FetchPage($RequestHeader, $Server, &$result){
		global $cfg;
		$psplit = split(':',$Server);
		$pserver = $psplit[0];
		if(isset($psplit[1])) {
			$pport = $psplit[1];
		}else {
			$pport = 80; //default-http-port
		}
 		$timeout = 10; // Timeout in seconds
		$fp = @fsockopen($pserver, $pport, $errno, $errstr, $timeout);

		if(!$fp) {				
			die('<b>Error</b> connecting to:<br>'.$pserver.':'.$pport.'<br><button name="ok" type="button" value="OK" style="cursor:pointer;width:100%;text-align:center;" onClick="showRequest(false,'.'\'editreq\''.',true);">&nbsp;&nbsp;<b>OK</b>&nbsp;&nbsp;</button>');
		}
		
		fputs($fp, $RequestHeader);
		stream_set_blocking($fp, FALSE );
		stream_set_timeout($fp, $timeout);
		$info = stream_get_meta_data($fp);
		
		$result = '';
		while((!feof($fp)) && (!$info['timed_out'])) {
			$result .= fgets($fp, 1024);
        	$info = stream_get_meta_data($fp);
			@ob_flush(); 
			flush(); 
		}
		
		fclose ($fp);
				
		if($info['timed_out']) { 
			die('<b>Connection</b> timed out at:<br>'.$pserver.':'.$pport.'<br><button name="ok" type="button" value="OK" style="cursor:pointer;width:100%;text-align:center;" onClick="showRequest(false,'.'\'editreq\''.',true);">&nbsp;&nbsp;<b>OK</b>&nbsp;&nbsp;</button>');
		} 
		
		if($cfg['http_compress']){
			// support for gzipped html
			if(strpos($result,'Content-Encoding: gzip')>0){
				// strip http header
				$pos = strpos($result,"\r\n\r\n")+14;
				// and decode gz
				$result = gzinflate(substr($result,$pos));
			}
		}
		
		return;
	}
	function post($Url, $Host, $Referer, $poststr){
		$data = "POST $Url HTTP/1.0\r\n";
		$data .= "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.5) Gecko/20070508 Firefox/1.5.0.12\r\n";
		$data .= "Accept: text/html, image/png, image/x-xbitmap, image/gif, image/jpeg, */*\r\n";
		$data .= "Referer: $Referer\r\n";
		$data .= "Accept-Language: en, de\r\n";
		$data .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$data .= "Host: $Host\r\n";
		$data .= "Content-Length: ".strlen($poststr)."\r\n";
		$data .= "\r\n";
		$data .= $poststr;
		
		$this->site_url = $Url;
		$this->FetchPage($data, $Host, $this->site);
		return $this->site;
	}
	function manageCache($newUrl){
		// stores which urls are in cache, frees oldest
		// SESSION[http_cache_urls] contains all cached urls
		// SESSION[http_cache_oldest] points to oldest entry which will be overwritten
		// SESSION[http_cache][_URL_] contains actual page
		
		global $cfg;
		
		if(!isset($_SESSION['http_cache_oldest'])){
			$_SESSION['http_cache_oldest'] = -1;
		} else if($_SESSION['http_cache_oldest'] == $cfg['http_cache_size']-1){
			// cache is full!
			$_SESSION['http_cache_oldest'] -= $cfg['http_cache_size'];
		}
				
		@$oldurl = $_SESSION['http_cache_urls'][++$_SESSION['http_cache_oldest']];
		unset($_SESSION['http_cache'][$oldurl]);
		
		$_SESSION['http_cache_urls'][$_SESSION['http_cache_oldest']] = $newUrl;
	}
}
?>
