<?php
if(!isset($_SESSION["pseudo"])){
  header("Location: /index.php");
  exit();
}
$username = $_SESSION["pseudo"];
//We update user's lasttimeseen 
BaseDonnee::updateLastTimeSeen($bdd, $username);

?>