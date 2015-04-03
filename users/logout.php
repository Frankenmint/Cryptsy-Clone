<?php
//Ce fichier sert à déconnecter un utilisateur de manière sécurisée.
session_start();

//Suppression de toutes les variables session
$_SESSION = array();

//Redirection vers l'accueil
header("Location: ../index.php");
exit();

?>