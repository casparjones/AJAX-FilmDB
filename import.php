<?php
/* FilmDB (based on php4flicks) */

session_start();
// if(!isset($_SESSION['user'])){
// }

/*	import.php - get  information from import and display it. */

require_once('config/config.php');

/* xmlize() is by Hans Anderson, me@hansanderson.com */
function xmlize($data, $WHITE=1, $encoding='iso-8859-1'){
    $data = trim($data);
    $vals = $index = $array = array();
    $parser = xml_parser_create($encoding);
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, $WHITE);
    xml_parse_into_struct($parser, $data, $vals, $index);
    xml_parser_free($parser);
    $i = 0;
    $tagname = $vals[$i]['tag'];
    if (isset($vals[$i]['attributes'])){
        $array[$tagname]['@'] = $vals[$i]['attributes'];
    } else {
        $array[$tagname]['@'] = array();
    }
    $array[$tagname]["#"] = xml_depth($vals, $i);
    return $array;
}
function xml_depth($vals, &$i){
    $children = array();
    if (isset($vals[$i]['value'])){
        array_push($children, $vals[$i]['value']);
    }
    while (++$i < count($vals)) {
        switch ($vals[$i]['type']) {

           case 'open':
                if (isset($vals[$i]['tag'])){
                    $tagname = $vals[$i]['tag'];
                } else {
                    $tagname = '';
                }
                if (isset($children[$tagname])){
                    $size = sizeof($children[$tagname]);
                } else {
                    $size = 0;
                }
                if (isset($vals[$i]['attributes'])){
                    $children[$tagname][$size]['@'] = $vals[$i]["attributes"];

                }
                $children[$tagname][$size]['#'] = xml_depth($vals, $i);
            break;

            case 'cdata':
                array_push($children, $vals[$i]['value']);
            break;

            case 'complete':
                $tagname = $vals[$i]['tag'];
                if(isset($children[$tagname])){
                    $size = sizeof($children[$tagname]);
                } else {
                    $size = 0;
                }
                if(isset( $vals[$i]['value'])){
                    $children[$tagname][$size]["#"] = $vals[$i]['value'];
                } else {
                    $children[$tagname][$size]["#"] = '';
                }
                if (isset($vals[$i]['attributes'])){
                    $children[$tagname][$size]['@'] = $vals[$i]['attributes'];
                }
            break;

            case 'close':
                return $children;
            break;
        }
    }
    return $children;
}
function traverse_xmlize($array, $arrName = "array", $level = 0) {
    foreach($array as $key=>$val){
        if ( is_array($val) ){
            traverse_xmlize($val, $arrName . "[" . $key . "]", $level + 1);
        } else {
            $GLOBALS['traverse_array'][] = '$' . $arrName . '[' . $key . '] = "' . $val . "\"\n";
        }
    }
    return 1;
}

if(!isset($_POST['action'])) $_POST['action']=''; //default-value 

switch($_POST['action']) {
	case '':
		// get all the import data and read it
		
		$import_file = dirname($_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF']).$cfg['uploads'];
		$xml_data = file_get_contents($import_file);
		
		$xml = xmlize($xml_data);
		/*
		traverse_xmlize($xml, 'xml_');
		print '<pre>'.implode("",$traverse_array).'</pre>'."\n";
		*/
				
		if(isset($xml['film']['#']['properties'][0]['#']['cat'][0]['#'])) {
			$cat = $xml['film']['#']['properties'][0]['#']['cat'][0]['#'];
		}else if(isset($xml['film']['#']['properties'][0]['#']['medium'][0]['#'])) {
			$cat = $cfg['cats'][$xml['film']['#']['properties'][0]['#']['medium'][0]['#']];
		}
		if(isset($xml['film']['#']['properties'][0]['#']['medium'][0]['#'])) {
			$smedium = $xml['film']['#']['properties'][0]['#']['medium'][0]['#'];
			$res = mysql_query("SELECT MAX(nr)+1 as free FROM movies WHERE cat='".$cfg['cats'][$smedium]."' GROUP BY cat") or die(mysql_error());
			$row = mysql_fetch_row($res);
			$nr = $row[0];
		}	
		if(isset($xml['film']['#']['properties'][0]['#']['imdb'][0]['#'])) {
			$imdbid = $xml['film']['#']['properties'][0]['#']['imdb'][0]['#'];
		}
		if(isset($xml['film']['#']['properties'][0]['#']['title'][0]['#'])) {
			$title = $xml['film']['#']['properties'][0]['#']['title'][0]['#'];
		}					
		if(isset($xml['film']['#']['properties'][0]['#']['local'][0]['#'])) {
			$local = $xml['film']['#']['properties'][0]['#']['local'][0]['#'];
		}
		if(isset($xml['film']['#']['properties'][0]['#']['aka'][0]['#'])) {
			$tmp = $xml['film']['#']['properties'][0]['#']['aka'][0]['#'];
			$aka = str_replace("|","\r\n",$tmp);
		}
		if(isset($xml['film']['#']['properties'][0]['#']['comment'][0]['#'])) {
			$comment = $xml['film']['#']['properties'][0]['#']['comment'][0]['#'];
		}
		if(isset($xml['film']['#']['properties'][0]['#']['country'][0]['#'])) {
			$country = $xml['film']['#']['properties'][0]['#']['country'][0]['#'];
		}
		if(isset($xml['film']['#']['properties'][0]['#']['rating'][0]['#'])) {
			$rating = $xml['film']['#']['properties'][0]['#']['rating'][0]['#'];
		}
		if(isset($xml['film']['#']['properties'][0]['#']['year'][0]['#'])) {
			$year = $xml['film']['#']['properties'][0]['#']['year'][0]['#'];
		}
		if(isset($xml['film']['#']['properties'][0]['#']['runtime'][0]['#'])) {
			$runtime = $xml['film']['#']['properties'][0]['#']['runtime'][0]['#'];
		}
		if(isset($xml['film']['#']['properties'][0]['#']['lang'][0]['#'])) {
			$slang = explode(",", $xml['film']['#']['properties'][0]['#']['lang'][0]['#']);
		}
		if(isset($xml['film']['#']['properties'][0]['#']['genre'][0]['#'])) {
			$sgenre = explode(",", $xml['film']['#']['properties'][0]['#']['genre'][0]['#']);
		}			
		if(isset($xml['film']['#']['properties'][0]['#']['disks'][0]['#'])) {
			$disks = $xml['film']['#']['properties'][0]['#']['disks'][0]['#'];
		}
		if(isset($xml['film']['#']['properties'][0]['#']['type'][0]['#'])) {
			$stype = $xml['film']['#']['properties'][0]['#']['type'][0]['#'];
		}
		if(isset($xml['film']['#']['properties'][0]['#']['container'][0]['#'])) {
			$scontainer = $xml['film']['#']['properties'][0]['#']['container'][0]['#'];
		}
		if(isset($xml['film']['#']['properties'][0]['#']['video'][0]['#'])) {
			$svideo = $xml['film']['#']['properties'][0]['#']['video'][0]['#'];
		}
		if(isset($xml['film']['#']['properties'][0]['#']['width'][0]['#'])) {
			$width = $xml['film']['#']['properties'][0]['#']['width'][0]['#'];
		}
		if(isset($xml['film']['#']['properties'][0]['#']['height'][0]['#'])) {
			$height = $xml['film']['#']['properties'][0]['#']['height'][0]['#'];
		}
		if(isset($xml['film']['#']['properties'][0]['#']['format'][0]['#'])) {
			$sformat = $xml['film']['#']['properties'][0]['#']['format'][0]['#'];
		}
		if(isset($xml['film']['#']['properties'][0]['#']['ratio'][0]['#'])) {
			$sratio = $xml['film']['#']['properties'][0]['#']['ratio'][0]['#'];
		}
		if(isset($xml['film']['#']['properties'][0]['#']['audio'][0]['#'])) {
			$saudio = $xml['film']['#']['properties'][0]['#']['audio'][0]['#'];
		}
		if(isset($xml['film']['#']['properties'][0]['#']['channel'][0]['#'])) {
			$schannel = $xml['film']['#']['properties'][0]['#']['channel'][0]['#'];
		}
		if(isset($xml['film']['#']['properties'][0]['#']['herz'][0]['#'])) {
			$sherz = $xml['film']['#']['properties'][0]['#']['herz'][0]['#'];
		}	
		if(isset($xml['film']['#']['people'][0]['#']['director'])) {
			$folks = $xml['film']['#']['people'][0]['#']['director'];
			for($i = 0; $i < sizeof($folks); $i++) {
				$person = $folks[$i];
				$director[$i]['id'] = $person['#']['id'][0]['#'];	
				$director[$i]['name'] = $person['#']['name'][0]['#'];
			}
		}else {
			$director[0]['id'] = ''; $director[0]['name'] = '';
		}
		if(isset($xml['film']['#']['people'][0]['#']['writer'])) {
			$folks = $xml['film']['#']['people'][0]['#']['writer'];
			for($i = 0; $i < sizeof($folks); $i++) {
				$person = $folks[$i];
				$writer[$i]['id'] = $person['#']['id'][0]['#'];	
				$writer[$i]['name'] = $person['#']['name'][0]['#'];
			}
		}else {
			$writer[0]['id'] = ''; $writer[0]['name'] = '';
		}
		if(isset($xml['film']['#']['people'][0]['#']['actor'])) {
			$folks = $xml['film']['#']['people'][0]['#']['actor'];
			for($i = 0; $i < sizeof($folks); $i++) {
				$person = $folks[$i];
				$actor[$i]['id'] = $person['#']['id'][0]['#'];	
				$actor[$i]['name'] = $person['#']['name'][0]['#'];
			}
		}else {
			$actor[0]['id'] = ''; $actor[0]['name'] = '';
		}
		$setposter = false;
		if(isset($xml['film']['#']['poster'][0]['#'])) {
			if($xml['film']['#']['poster'][0]['#']!=''){
				$img = base64_decode($xml['film']['#']['poster'][0]['#']);
				$typ = bin2hex(substr($img,0,4));
				if($typ=="ffd8ffe0"||$typ=="47494638"){
					unset($_SESSION['image']);
					$_SESSION['image'][$imdbid] = $img;
					$setposter = true;
				}
			}
		}

		$referer= 'import.php?';

		$b_back 	= "";
		$b_cancel 	= "parent.window.document.remember.submit();";
		$b_delete 	= "";
		$new_title =  rawurlencode($title); // str_replace("'",'',$title);
		$b_save 	= "document.data.action='insert.php';if(check()){document.data.submit();this.onclick='return false';show_Request(true,'editreq','insertfilm.php?title=".$new_title."');}";

		include('filmform.php');

		break;
		
	case 'reload':
		$reload = true;	// if this is set, filmform gets its data from POST array
		$referer= 'import.php?';

		$b_back 	= "parent.window.document.remember.submit();";
		$b_delete 	= "";
		$b_save 	= "document.data.action='update.php';if(check()){document.data.submit();this.onclick='return false';}";

		include('filmform.php');
	}
?>
