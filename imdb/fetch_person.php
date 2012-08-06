<?php
// fetch_person.php: search imdb for person id, given name
// return found items as a table. clicking on person changes value in filmform.php and closes window.
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// js function setperson(id, name) must be defined in caller!!!!

//first check if the class exists allready, if so return and don't include it again
if(class_exists('fetch_person')) return;

require_once('fetch.php');

class fetch_person extends pml_fetch {

	var $searchLimit;
	var $_actorName = '';
	function fetch_person($searchLimit,$cats){
		$this->searchLimit = $searchLimit; $this->cats = $cats;
	}
	
	function doSearch(&$out, $SearchString) {
		// SearchString: the name to search form
		// $out: the resulting HTML code
		// $data = "/find?s=nm;mx=$this->searchLimit;q=".rawurlencode($SearchString);
		
		//$searchData = 'occupation='.implode($this->cats,'&occupation=').'&name='.urlencode($SearchString).'&mx='.$this->searchLimit;
		//$searchData = 'occupation='.urlencode("All professions").'&name='.urlencode($SearchString).'&mx='.$this->searchLimit;
		
		//http://www.imdb.com/search/name?name=diesel&view=simple
		$searchData = 'realm=name&name='.urlencode($SearchString).'&view=simple';
		
		//$site = $this->post('/search','www.imdb.com:80','www.imdb.com/find/',$searchData); 
		$site = $this->post('/search/process','www.imdb.com','www.imdb.com/search/name',$searchData); 
		
		//when you use the search-form on imdb.com and you search for a person that was exactly found
		//imdb uses a 302-found-page to redirect to the page of this person. something like
		//302 page found location: http://us.imdb.com/Name?lastname,+firstname
		if(strstr($site, 'HTTP/1.0 302') || strstr($site, 'HTTP/1.1 302')) { //exact match?
			// x[0]: location: http://us.imdb.com/Name?lastname,+firstname
			// x[1]: lastname,+firstname 
			//preg_match("#location: /search/name\?([^\s]*)\s#i", $site, $x);
			//x[0]: Location: /search/name?count=&name=Roland%20Emerich&view=simple
			//x[1]: count=&name=Roland%20Emerich&view=simple
			preg_match("#Location: /search/name\?count=&name=(.+?)&view=simple#i", $site, $x);
			$site = $this->FetchCachedUrl('/search/name?count=&name='.$x[1].'&view=simple','www.imdb.com','http://www.imdb.com/search/name');
			// here imdb will return another 302-found page of the form
			// HTTP/1.1 302 Found ... Location: /name/nm0000206/
			//	$x[1] = urldecode($x[1]);
			//	$start = strpos($x[1],',');
			//	$this->_actorName = $x[1]; //str_replace('"','\'',substr($x[1],$start+2).' '.substr($x[1],0,$start)); 
			//	preg_match("#Location: http://www\.imdb\.com[:0-9]*/name/nm([0-9]{7})#i", $site, $x);
			//	$this->FetchID = $x[1];	      //save the id in $FetchID
			//	return(PML_FETCH_EXACTMATCH); //return to editentry that it can fetch now the data - search is already done
		}
		//$y=spliti('<h3><a NAME="([^"]*)">', $site);
		// split according to categories (actor, director etc)
		$found = 0;
		// always display all 'most popular'
		//$site = $y[0];
		$out .= "<table width=\"100%\" border=\"0\" bordercolor=\"#D9D9D9\" cellpadding=\"2\" cellspacing=\"0\">\n";
		$start = strpos($site,'Most Popular');
		$none = strpos($site,'No results.')||0;
		$once = strpos($site,'1 names.')||0;
		//$out .= "<tr><td>".$start."</td></tr>";
		//$out .= "<tr><td>".$ende."</td></tr>";
		if($start>0){
			// $out.="<tr><td class=\"rowtitle\">Most Popular</td><td style=\"width: 28px\"/></tr>\n";
			$site = substr($site,$start);
			$brow = true;
			//while(eregi('<a href="/name/nm([0-9]{7})/">([^<]*)</a>(.*?)<span class="description">(.*?)</span>', $site, $x)) { 
			//while(eregi('<a href="/name/nm([0-9]{7})/">([^<]*)</a>', $site, $x)) { 
			while(preg_match('#<a href="\/name\/nm([0-9]{7})\/"[^<]*>([^<]*)<\/a>(.*?)<span class="description">(.*?)(,|<\/)#is', $site, $x)) {
				$x[2] = str_replace('"','\'',$x[2]); //html does not cope well with doubleqoutes, so replace them with single quotes.
				$x[4] = str_replace('"','\'',$x[4]);
				// id in x[1], name in x[2]
				$found ++;
				$site = substr($site,strpos($site,$x[0])+strlen($x[0]));
				$out .= "<tr class=\"".($brow?'row_0':'row_1')."\"><td class=\"txt\" width=\"90%\" nowrap><a style=\"cursor:pointer;\" onClick=\"setperson('$x[1]','$x[2]')\">$x[2]</a> <i>($x[4])</i></td><td><a target=\"_blank\" href=\"http://www.imdb.com/name/nm$x[1]/\"><img src=\"images/imdb.gif\" alt=\"IMDb\" width=\"28\" height=\"14\" border=\"0\"></a></td></tr>\n";
				$brow = !$brow;
				//$tempor = nl2br(htmlentities(print_r($x,true)));
				//$out .= "<tr><td>".$tempor."</td></tr>";
			}
		}
		//if($once>0) {$out = ''; $this->FetchID = $x[1];	$this->_actorName = $x[2]; return(PML_FETCH_EXACTMATCH); }
		if($found==0) {
			$out .= "<tr><td><strong>Sorry, but nobody was found!</strong></td></tr>";
			/* DEBUG
				$out .= "<tr><td>".$site."</td></tr>";
				$tempor = nl2br(htmlentities(print_r($x,true)));
				$out .= "<tr><td>".$tempor."</td></tr>";
			DEBUG */
		}
		$out .= '</table>';

		return(PML_FETCH_SEARCHDONE);
	}
}
?>
