<?php

class imdbMapper {
	public static function mapActors($actors) {
		foreach($actors as $nr => $actor) {
			if($nr<12) {
				$newActors[$nr] = $actor;
				$newActors[$nr]['id'] = $actor['imdb'];
			}
		}
		
		return $newActors;
	}
	
	public static function mapAka($akas) {
		$newakas = array(); $c = 0;
		foreach($akas as $nr => $akas) {
			if($c<6 && !in_array($akas['title'], $newakas)) {
				$newakas[] = utf8_decode($akas['title']);
				$c++;
			}
		}
		
		return implode("\r\n", $newakas);
	}
}

?>
