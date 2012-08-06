<?php
$cfg['mysql_host'] = "127.0.0.1";
$cfg['mysql_user'] = "";
$cfg['mysql_pass'] = "";
$cfg['mysql_db']   = "";

if($_SERVER['HTTP_HOST'] == 'pumi.muhviz.local') {
	$cfg['mysql_host'] = "127.0.0.1";
}

?>
