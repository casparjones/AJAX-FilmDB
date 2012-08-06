<?php
// script to fetch data on movies from IMDB, taken from www.powermovielist.com and modified
// http://www.powermovielist.com/phpwiki/index.php/FetchScripts

/************************************************************
*	available fields:
*	"Title"			string
*	"Year",			int
*	"Poster",		url
*	"Director",		array of array(string'id',string'name')
*	"Credits",		array of array(string'id',string'name')
*	"Genre",		array of strings
*	"Country"		array of strings
*	"Rating",		int (real)
*	"Starring",		array of array(string'id',string'name')
*	"Plot",			string
*	"Release",		date (1999-03-07)
*	"Runtime",		int
*	"imdbid",		string
*	"aka",			string
*************************************************************/

//first check if the class exists allready, if so return and don't include it again
if(class_exists('fetch_movie')) return;

require_once('fetch.php'); //base class

class fetch_movie extends pml_fetch {
	// regular expressions for imdb search	
	var $re = array(
		// find titles on search result page
		//'searchTitle' => '#<a href="/title/tt([0-9]{7})/[^>]*">([^<]*)</a>#i',
		'searchTitle' => '#<a href="/title/tt([0-9]{7})/[^>]*">([^<]*)</a>([^<]*)#i',
		'searchYear' => '#.*\(([0-9]{4})(/|\)).*#is',
		// movie title
		// title data until 24-Jul-2006
		//'title' => "#<title>(.*) \([0-9]{4}\).*</title>#is",
		// title data since 24-Jul-2006
		// 'title' => "#<title>(.*) \([0-9]{4}.*</title>#is",
		'title' => "#<title>(.*?) \([0-9]{4}.*</title>#is",
		// movie data...
		'year' => "#<title>.*\(([0-9]{4})\).*</title>#is",
		// poster data until 25-Jan-2006
		//'poster' => '#alt="cover" src="([^"]+)"#is',
		// poster data since 26-Jan-2006
		// ALTERNATE: #<a name="poster".+?<img .*?src="([^"]+)"#is
		//'poster' => '#<img border="0" id="primary-poster" alt="[^"]*" title="[^"]*" src="([^"]+)"#is',
		'poster' => '#/tt([0-9]{7})"><img src="([^"]+)"#is',
		//'director' => '#[^<]*<a href="\/name\/nm([0-9]{7})\/">([^<]*)<\/a>#i',
		// director data since 01-Jul-2009
		//'director' => '#[^<]*<a href="\/name\/nm([0-9]{7})\/"[^<]*>([^<]*)<\/a>#i',
		'director' => '#[^<]*href="\/name\/nm([0-9]{7})\/"[^<]*>([^<]*)<\/a>#i',
		// credits data until 18-Feb-2007
		//'credits' => '#[^<]*<a href="\/name\/nm([0-9]{7})\/">([^<]*)<\/a>#i',
		// credits data since 19-Feb-2007
		//'credits' => '#[^<]*<a href="\/name\/nm([0-9]{7})\/">([^<]*)<\/a>#i',
		// credits data since 01-Jul-2009
		'credits' => '#[^<]*href="\/name\/nm([0-9]{7})\/"[^<]*>([^<]*)<\/a>#i',
		// genreList data until 18-Feb-2007
		//'genreList' => '#Genre:</b>\n?(.*)(<a href="/Keywords)?#is',
		// genreList data since 19-Feb-2007
		//'genreList' => '#Genre:</h5>\n?(.*)(<a href="/Keywords)?#is',
		'genreList' => '#Genres:</h4>\n?(.*)</div>#is',
		//'genre' => "#<a href=\"/Sections/Genres/[a-zA-Z\\-]*/\">([a-zA-Z\\-]*)</a>#is",
		//'genre' => "#<a href=\"/genre/[a-zA-Z\\-]*/\">([a-zA-Z\\-]*)</a>#is",
		'genre' => '#<a href=\"/genre/[a-zA-Z\\-]*\">([^<]*)</a>#is',
		// rating data until 19-Feb-2007
		//'rating' => "<b>([0-9]).([0-9])/10</b> \([0-9,]+ votes\)",
		// rating data since 19-Feb-2007
		//'rating' => '<b>([0-9]).([0-9])/10</b> \(<a href="ratings',
		// rating data since 02-Mar-2007
		//'rating' => '<b>([0-9]).([0-9])/10</b>',
		'rating' => '<span class="rating-rating">([0-9]).([0-9])<span>',
		// actor data until 20-Jul-2006
		// 'actor' => '#<td valign="top"> ?<a href="/name/nm([0-9]{7})/">([^<]*)</a></td>#i',
		// actor data since 21-Jul-2006
		// actor data until 18-Feb-2007
		//'actor' => '#<td valign="middle"> ?<a href="/name/nm([0-9]{7})/">([^<]*)</a></td>#i',
		// actor data since 19-Feb-2007
		//'actor' => '#<td class="nm"> ?<a href="/name/nm([0-9]{7})/">([^<]*)</a></td>#i',
		// actor data since 01-Jul-2009
		//'actor' => '#<td class="nm"> ?<a href="/name/nm([0-9]{7})/"[^<]*>([^<]*)</a></td>#i',
		'actor' => '#<td class="name">(.+?)<a  href="/name/nm([0-9]{7})/"[^<]*>([^<]*)</a>#is',
		'plot' => '#<p class="plotpar">([^<]*)</p>#is',
		'plotOutline' => "#Plot \w+:</b>([^<]*)#",
		'tagline' => "#Tagline:</b>([^<]*)#",
		'date' => '#<a href="/BusinessThisDay[^>]*>([0-9]+) ([A-Za-z]+)</a>#is',
		// 'year' => '#<a href="/Sections/Years[^>]*>([^<]*)</a>#is',
		'year' => '#<a href="/year[^>]*>([^<]*)</a>#is',
		// runtime data until 18-Feb-2007
		//'runtime' => '#<b class="ch">Runtime:</b>\n(.*:)?([0-9]+) min#i',
		// runtime data since 19-Feb-2007
		//'runtime' => '#<h5>Runtime:</h5>\n(.*:)?([0-9]+) min#is',
		// runtime data since 16-Nov-2009
		//'runtime' => '#<h5>Runtime:</h5>\n<div class="info-content">\n(.*:)?([0-9]+) min#is',
		//'runtime' => '#<h5>Runtime:</h5><div class="info-content">(.*:)?([0-9]+) min#is',
		'runtime' => '#Runtime:</h4>(.+?)([0-9]+) min#is',
		// aka data until 18-Feb-2007
		//'aka' => '#<b class="ch">Also Known As:</b><br>(.*)#i',
		// aka data since 19-Feb-2007
		//'aka' => '#<h5>Also Known As:</h5>(.*) <br>#i',
		// aka data since 16-Nov-2009
		//'aka' => '#<h5>Also Known As:</h5><div class="info-content">(.*?)<a class="tn15more"#i',
		'aka' => '#Also Known As:</h4>(.*?)<span class#is',
		// countryList data until 18-Feb-2007
		//'countryList' => '#Country:</b>\n?(.*)(\n<br)?#is',
		// countryList data since 19-Feb-2007				
		//'countryList' => '#<h5>Country:</h5>\n?(.*)(\n<br)?#is',
		//'countryList' => '#Country:</h5>\n?(.*)(</div)?#is',
		//'countryList' => '#<h5>Country:</h5><div class="info-content">\n?(.*)</div>#is',
		'countryList' => '#Country:</h4>\n?(.*)</div>#is',
		//'countryList' => '#<h5>Country:</h5>\n<div class="info-content">\n?(.*)(\n</div)?#is',
		//'country' => '#<a href=\"/Sections/Countries/([^<]*)/">#is',
		'country' => '#<a href=\"/country/[a-zA-Z\\-]*\">([^<]*)</a>#is'
	);
	var $actorLimit,$searchLimit;
	// constructor 
	function fetch_movie($searchLimit,$actorLimit){
		$this->searchLimit = $searchLimit; $this->actorLimit = $actorLimit;
	}
	function doSearch(&$out, $SearchString, $EntryUrl) {
		// SearchString: the movie title to search for
		// $out: the resulting HTML code
		// EntryUrl: if set to 'blah', if >1 movies found they will be linked with <a href=blah&FetchID=...>
		
		global $cfg;
		
		// check whether cache is enabled and search results have been cached
		$outvar = $out;
		if($cfg['cache']){
			if(isset($_SESSION['cache'][$SearchString])){
				if(isset($_SESSION['cache'][$SearchString]['id'])){
					// $this->FetchID = $_SESSION['cache'][$SearchString]['id'];
					$out .= $_SESSION['cache'][$SearchString]['out'];
					return PML_FETCH_EXACTMATCH;
				} else {
					$out .= $_SESSION['cache'][$SearchString]['out'];
					return PML_FETCH_SEARCHDONE;
				}
			}
			unset($_SESSION['cache']);
			$_SESSION['cache'][$SearchString]['out'] = '';
			$outvar = &$_SESSION['cache'][$SearchString]['out'];
		}
		
		$outvar .= "<table width=\"100%\" border=\"0\" bordercolor=\"#D9D9D9\" cellpadding=\"2\" cellspacing=\"0\">\n";
		
		//fetchCachedUrl(url, host, referer)
		$data = "/find?s=tt;mx=$this->searchLimit;q=".rawurlencode($SearchString);
		$site = $this->fetchCachedUrl($data,'www.imdb.com:80','http://www.imdb.com/');

		//when you use the search-form on www.imdb.com and you search for a title that was exactly found
		//imdb uses a 302-found-page to redirect to the Title-page of this movie.
		//if this happens, we can use this imdb-id too
		
		if(strstr($site, 'HTTP/1.0 302') || strstr($site, 'HTTP/1.1 302')) { //exact match?
			preg_match("#Location: .*/title/tt([0-9]*)#i", $site, $x);

			if(!isset($x[1])) {
				$outvar .= "<tr><td><strong>Sorry, but nothing was found!</strong></td></tr>\n";
				// return(PML_FETCH_ERROR);
			/* DEBUG
				$outvar .= "<tr><td>".$site."</td></tr>";
				$tempor = nl2br(htmlentities(print_r($x,true)));
				$outvar .= "<tr><td>".$tempor."</td></tr>";
			DEBUG */
			} else {
				// $this->FetchID = $x[1];	      //save the id in $FetchID
				$outvar .= "<tr class=\"row_0\"><td width=\"90%\" class=\"txt\"><a target=\"mainframe\" href=\"$EntryUrl&amp;FetchID=$x[1]\" onClick=\"showRequest(false,'editreq','')\" onmouseover=\"parent.window.status=' ';return true;\">$SearchString</a></td><td valign=\"top\"><a target=\"_blank\" href=\"http://www.imdb.com/title/tt$x[1]/\"><img src=\"images/imdb.gif\" alt=\"IMDb\" width=\"28\" height=\"14\" border=\"0\"></a></td></tr>\n";
			}
			$outvar .= '</table>';

			if($cfg['cache']) {
				$out .= $_SESSION['cache'][$SearchString]['out'];
				// $_SESSION['cache'][$SearchString]['id'] = $x[1];
			}
			return(PML_FETCH_EXACTMATCH); //return to editentry that it can fetch now the data - search is allready done
		}
		
		$found = 0;
		$brow = true;
	
		while(preg_match($this->re['searchTitle'], $site, $x)) { 
				// id in x[1], name in x[2], year in y[1]
				$found ++;
				$site = substr($site,strpos($site,$x[0])+strlen($x[0]));
				preg_match($this->re['searchYear'], $x[3], $y);
                if(!isset($y[1])) $y[1] = '';
				$outvar .= "<tr class=\"".($brow?'row_0':'row_1')."\"><td width=\"90%\" class=\"txt\"><a target=\"mainframe\" href=\"$EntryUrl&amp;FetchID=$x[1]\" onClick=\"showRequest(false,'editreq','')\" onmouseover=\"parent.window.status=' ';return true;\">$x[2]</a>&nbsp;<sup>(<dfn>$y[1]</dfn>)</sup></td><td valign=\"top\"><a target=\"_blank\" href=\"http://www.imdb.com/title/tt$x[1]/\"><img src=\"images/imdb.gif\" alt=\"IMDb\" width=\"28\" height=\"14\" border=\"0\"></a></td></tr>\n";
				$brow = !$brow;
		}
		if($found==0) {
			$outvar .= "<tr><td><strong>Sorry, but nothing was found!</strong></td></tr>";
		}
		
		$outvar .= '</table>';
		if($cfg['cache'])
			$out .= $_SESSION['cache'][$SearchString]['out'];
		return(PML_FETCH_SEARCHDONE);
	}
	function DoFetch(&$ret,$FieldName) {
		/* DoFetch - perform the search on the page to fetch from
		@param string the fetched value (return-string)
		@param string the FieldName
		@access public
		@return const PML_FETCH_ERROR, PML_FETCH_OK or PML_FETCH_ITEMNOTFOUND*/
		
		switch($FieldName) {
		
			case 'Title': //fetch Title
				// get this url, cached if allready used:
				$site = $this->fetchCachedUrl("/title/tt$this->FetchID/", 'www.imdb.com:80', 'http://www.imdb.com');
				// regular-expresstion to filter out the field
				// i: case insensitive, s: match whole text (not per line only)

				if(!preg_match($this->re['title'], $site, $x))
					return(PML_FETCH_ERROR);

				// remove possible artifacts caused by chunking of html source
				$ret = preg_replace('#\n[0-9abcdef]*\n#is','',$x[1]);
				break;
			
			case 'Year':
				$site = $this->fetchCachedUrl("/title/tt$this->FetchID/", 'www.imdb.com:80', 'http://www.imdb.com');
			
				if(!preg_match($this->re['year'], $site, $x))
					return(PML_FETCH_ERROR);
				
				$ret = $x[1];
				if($ret=='') $ret=0;
				break;
				
			case 'Poster':
				$site = $this->fetchCachedUrl("/title/tt$this->FetchID/", 'www.imdb.com:80', 'http://www.imdb.com');

				/* $re['poster'] = '#alt="'.$re['title_str'].'" title="'.$re['title_str'].'" src="([^"]+)"#is'; */

				// old: alt="cover" src="http://ia.imdb.com/..."
				// new: alt="filmname" title="filmname" src="http://ia.imdb.com/..." 
				// even newer: src="http://ia.media-imdb.com/..." 

				if(!preg_match($this->re['poster'], $site, $x))
					return(PML_FETCH_ERROR);

				// remove possible artifacts caused by chunking of html source
				
				$ret = preg_replace('#\n[0-9abcdef]*\n#is','',$x[2]);
				$ret = $x[2];

				break;
				
			case 'Director':
				$site = $this->fetchCachedUrl("/title/tt$this->FetchID/", 'www.imdb.com:80', 'http://www.imdb.com');

				$start = strpos($site, 'Director');
				$len = strpos($site, 'Writer')-$start;
				$site = substr($site,$start,$len);
				if(!preg_match_all($this->re['director'], $site, $x,PREG_SET_ORDER)) {
					return(PML_FETCH_ERROR);
				}
				$ret = array();
				foreach($x as $dir){
					$ret[] = array('id'=>$dir[1],'name'=>$dir[2]);
				}		
				break;

			case 'Credits':
				$site = $this->fetchCachedUrl("/title/tt$this->FetchID/", 'www.imdb.com:80', 'http://www.imdb.com');

				$start = strpos($site, 'Writer'); // Release Date
				$len = strpos($site, '</div>',$start)-$start;
				//$len = strpos($site, '</table>',$start)-$start;
				$site = substr($site,$start,$len);
				if(!preg_match_all($this->re['credits'], $site, $x,PREG_SET_ORDER))
					return(PML_FETCH_ERROR);

				$ret = array();
				foreach($x as $dir){
					$ret[] = array('id'=>$dir[1],'name'=>$dir[2]);
				}
				break;

			case 'Genre':
				$site = $this->fetchCachedUrl("/title/tt$this->FetchID/", 'www.imdb.com:80', 'http://www.imdb.com');

				if(!preg_match($this->re['genreList'], $site, $gen))
					return(PML_FETCH_ERROR);

				$gen = $gen[1];
				$ret = array();
				while(preg_match($this->re['genre'], $gen, $x)) {
					$gen = substr($gen,strpos($gen,$x[0])+strlen($x[0]));
					$ret[] = $x[1];
				}
				if(sizeof($ret)==0) {
					return(PML_FETCH_ERROR);
				}
				break;
				
			case 'Country':
				$site = $this->fetchCachedUrl("/title/tt$this->FetchID/", 'www.imdb.com:80', 'http://www.imdb.com');
				
				if(!preg_match($this->re['countryList'], $site, $gen)) {
					return(PML_FETCH_ERROR);
				}
				$gen = $gen[1]; $ret = '';
				/*
				$ret = '';
				preg_match_all($this->re['country'], $gen, $x);
				foreach($x[1] as $t){
					$ret .= $t."/";
				}		
				$ret = substr($ret, 0, strlen($ret)-1);
				*/
				while(preg_match($this->re['country'], $gen, $x)) {
					$gen = substr($gen,strpos($gen,$x[0])+strlen($x[0]));
					$ret .= $x[1]."/";
				}
				$ret = substr($ret, 0, strlen($ret)-1);
				break;
				
			case 'Rating':
				$site = $this->fetchCachedUrl("/title/tt$this->FetchID/", 'www.imdb.com:80', 'http://www.imdb.com');
				
				if(!eregi($this->re['rating'], $site, $x)) {
					return(PML_FETCH_ERROR);
				}
				$ret = $x[1].$x[2];
				// $ret = $ret/10; float
				$ret = $ret/1;
				break;
				
			case 'Starring':
				$site = $this->fetchCachedUrl("/title/tt$this->FetchID/", 'www.imdb.com:80', 'http://www.imdb.com');
				$ret = array();
				$i=0;
				
				while( ($i < $this->actorLimit) && preg_match($this->re['actor'], $site, $x)) {
					$site = substr($site,strpos($site,$x[0])+strlen($x[0]));
					$ret[] = array('id'=>$x[2],'name'=>$x[3]);
					$i++;
				}

				if(sizeof($ret)==0)
					return(PML_FETCH_ERROR);
				break;
			
			case 'Plot':
				$site = $this->fetchCachedUrl("/title/tt$this->FetchID/plotsummary/", 'www.imdb.com:80', "http://us.imdb.com/title/tt$this->FetchID/");
				
				if(preg_match($this->re['plot'], $site, $x)) {
					//plot exists:
					$ret = $x[1];
				} else {
					//plot doesn't exist, use plot-outline from title-page:
					$site = $this->fetchCachedUrl("http://www.imdb.com/title/tt$this->FetchID/", 'www.imdb.com:80', "http://www.imdb.com");
					preg_match($this->re['plotOutline'], $site, $x);
					$ret = $x[1];
					// if there's no plot outline fetch tagline.
					if(!$ret) {
						$x = array();
						if(!preg_match($this->re['tagline'], $site, $x))
							return(PML_FETCH_ERROR);
						$ret = $x[1];
					}
				}
				break;
				
			case 'Release':
				$site = $this->fetchCachedUrl("/title/tt$this->FetchID/releaseinfo", 'www.imdb.com:80', "http://us.imdb.com/title/tt$this->FetchID/");

				$convert['January']='01';
				$convert['February']='02';
				$convert['March']='03';
				$convert['April']='04';
				$convert['May']='05';
				$convert['June']='06';
				$convert['July']='07';
				$convert['August']='08';
				$convert['September']='09';
				$convert['October']='10';
				$convert['November']='11';
				$convert['December']='12';

				if(!preg_match($this->re['date'], $site, $date))
					return(PML_FETCH_ERROR);

				if(!preg_match($this->re['year'], $site, $year))
					return(PML_FETCH_ERROR);

				$ret = $year[1] . "-" . $convert[$date[2]] . "-" . $date[1];
				break;
				
			case 'imdbid':
				$ret = $this->FetchID;
				break;
				
			case 'Runtime':
				$site = $this->fetchCachedUrl("/title/tt$this->FetchID/", 'www.imdb.com:80', 'http://www.imdb.com');

				if(!preg_match($this->re['runtime'], $site,$x)) {
					// set runtime to 0, so no crap is returned if FETCH_ERROR not caught
					$ret = 0;
					return(PML_FETCH_ERROR);
				}
				$ret = $x[2];
				break;

			case 'aka':
				$site = $this->fetchCachedUrl("/title/tt$this->FetchID/", 'www.imdb.com:80', 'http://www.imdb.com');

				if(!preg_match($this->re['aka'], $site,$x)) {
					return(PML_FETCH_ERROR);
				}
				$x[1] = trim($x[1]); 
				$x[1] = str_replace('<br>',"\n",$x[1]);
				$x[1] = str_replace('&#32;','',$x[1]);
				$x[1] = str_replace('</em>','',$x[1]);
				$x[1] = str_replace('<em>','',$x[1]);
				$ret = $x[1];
				break;

			default:
				return(PML_FETCH_ITEMNOTFOUND);
		}//end switch $FieldName
		
		return(PML_FETCH_OK);
	}
}
?>
