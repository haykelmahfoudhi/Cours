
<?php

include __DIR__."/../../Connecteur/base.php";
require_once __DIR__."/../pdooci/PDOOCI/PDO.php";

$username= "proginfo";
$password= "qlzM9zr3M";
$dbc = new PDOOCI\PDO("$host;charset=utf8", $username , $password);

?>
