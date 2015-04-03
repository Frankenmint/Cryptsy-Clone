<?php
require_once("../classes/BaseDonnee.class.php");
$bdd = BaseDonnee::connexion();


$username = $_GET["usr"];
$since = time() - 1800; // Depuis 30 minutes

$res = BaseDonnee::execQuery($bdd, "SELECT * FROM Chat ORDER BY Timestamp DESC LIMIT 20");

echo json_encode($res);


?>
