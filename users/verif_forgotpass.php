<?php 
session_start();
session_regenerate_id();

require_once($_SERVER['DOCUMENT_ROOT']."/includes/swiftmailer/swift_required.php");
require_once($_SERVER['DOCUMENT_ROOT']."/classes/BaseDonnee.class.php");

$bdd = BaseDonnee::connexion();

if(isset($_POST["pseudo"]) && isset($_POST["mail"])){
	$username = mysql_escape_string($_POST["pseudo"]);
	$mail = mysql_escape_string($_POST["mail"]);
	$sql = BaseDonnee::execQuery($bdd, "SELECT * FROM Users WHERE Username = '$username' AND Email = '$mail'");
	//user n'existe pas
	if(empty($sql)){
		$_SESSION["erreur_forgotpass"] = "error";
		header("Location: ./forgotpass.php");
		exit();
	}else{
	//user existe, on lui envoi un mail avec un nouveau mot de passe
		$generatedKey = sha1(mt_rand(10000,99999).time().$mail);
		$link = "http://www.crypto-maniac.com/users/forgotpass.php?usr=".$username."&key=".$generatedKey;
     		// Sujet
		$subject = 'Crypto-maniac - Forgotpass request';

    		// message
		$message = '
		<html>
		<head>
		<title>Crypto-maniac - Forgotpass request</title>
		</head>
		<body>
		<h3>Hello '.$username.'</h3>
		<p> You asked for a new password for your crypto-maniac account </p>
		<p> Please click on this <a href="'.$link.'"> reset link </a> for generate a new password</p>
		</body>
		</html>
		';

   		// Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    		// En-têtes additionnels
		$headers .= 'To: '.$username.' <'.$mail.'>' . "\r\n";
		$headers .= 'From: Crypto-maniac <forgotpass@crypto-maniac.com>' . "\r\n";

		 // Envoi
   		if(mail($mail, $subject, $message, $headers)){
   			BaseDonnee::editKeyPassword($bdd, $username, $generatedKey);
   			$_SESSION["success_forgotpass"] = "success";
   		}else{
   			$_SESSION["erreur_forgotpass"] = "Mail service in maintenance, please retry later";
   		};
		header("Location: ./forgotpass.php");
		exit();
	}
}



?>