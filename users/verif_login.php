<?php
//Ce fichier servira à vérifier que les données entré dans le formulaire de login.php soit bonne
//Si oui, l'utilisateur est connecté puis redirigé vers l'acceuil
//Si non, il est redirigé sur la même page avec un message d'erreur.
require_once($_SERVER['DOCUMENT_ROOT']."/classes/BaseDonnee.class.php");
session_start();
session_regenerate_id();
//Si l'utilisateur viens juste d'être redirigé sur la page après son inscription, on supprime la variable session adéquate.

$bdd = BaseDonnee::connexion();

$pseudo = mysql_real_escape_string($_POST["pseudo"]);
$mdp = mysql_real_escape_string($_POST["mdp"]);
try{
	$success = BaseDonnee::mdpValide($bdd, $pseudo, $mdp);
	$sql = BaseDonnee::execQuery($bdd, "SELECT * FROM Users WHERE Username = '$pseudo'");
	if(!empty($sql)){
		if($sql[0]["Actif"] != "1"){
			$success = false;
		}
	}
}catch( PDOEXception $e ) {
             echo $e->getMessage(); // display bdd error
             exit();
         }


if($success){ //Si la connexion à réussie
	if(isset($_SESSION["erreur_login"])) unset($_SESSION["erreur_login"]);
	$_SESSION["pseudo"] = $pseudo; // On connecte l'user
	$_SESSION["token"] = time();

	$ip_client = getenv('HTTP_CLIENT_IP')?:
	getenv('HTTP_X_FORWARDED_FOR')?:
	getenv('HTTP_X_FORWARDED')?:
	getenv('HTTP_FORWARDED_FOR')?:
	getenv('HTTP_FORWARDED')?:
	getenv('REMOTE_ADDR');

	BaseDonnee::updateLastSignIn($bdd, $pseudo, $ip_client);
 	header("Location: ../index.php"); //Redirection vers l'accueil
 	exit();
}else{ //Echec de la connexion
	$_SESSION["erreur_login"] = "erreur";
	header("Location: ./login.php"); //Redirection vers la page de login
	exit();
}

?>