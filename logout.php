<?php
/* FilmDB (based on php4flicks) */

// this is used for logout only

require_once('config/config.php');

setcookie("userpref", "0");
session_start();
session_unset();
session_destroy();
?>
