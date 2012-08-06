<?php
/* 
debug.php - writes to "debug.log" 
require_once('config/debug.php');
*/

function set2log($str){
	if(@is_writable("debug.log")) { 
		$dl = @fopen("debug.log","a");
		if($dl) {
			@fputs($dl, $str);
			@fclose($dl);
		}
	}
}		
?>