<?php
include(dirname(__FILE__) . '/../config/config.php');

/* Connect to an ODBC database using driver invocation */
$dsn = 'mysql:dbname=' . $cfg['mysql_db'] . ';host=' . $cfg['mysql_host'];
$user = $cfg['mysql_user'];
$password = $cfg['mysql_pass'];

function filterResponse($aData) {
	var_dump($aData); die();
}

try {
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql = 'SELECT * FROM movies ORDER BY updated DESC';
	$aExec = array();
	if(isset($_GET['last'])) $oLast = date_create($_GET['last']);
	if(isset($oLast)) {
		$aExec = array(':lastSync' => $oLast->format('Y-m-d H:i:s'));
		$sql = 'SELECT * FROM movies WHERE updated >= :lastSync ORDER BY updated DESC';
	}

	$sth = $dbh->prepare($sql);
	$sth->execute($aExec);
	$aMovies = $sth->fetchAll(PDO::FETCH_ASSOC);
	foreach($aMovies as &$aMovie) {
		$aMovie['poster'] = base64_encode($aMovie['poster']);
		$aMovie['aka'] = strip_tags($aMovie['aka']);
	}

	echo(json_encode($aMovies));

} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}


?>