<?php
session_start();
session_regenerate_id();
require_once($_SERVER['DOCUMENT_ROOT']."/classes/BaseDonnee.class.php");
require_once($_SERVER['DOCUMENT_ROOT']."/classes/Wallet.class.php");

if($_SESSION["pseudo"] != "admin"){
	header('HTTP/1.0 404 Not Found');
	exit("<h1>404 Not Found</h1>\nThe page that you have requested could not be found.");
}

$bdd = BaseDonnee::connexion();
$erreurs = false;

//AJOUTER UN VOTE
if(isset($_POST["addVote"])){
	$acr = strtoupper(mysql_escape_string($_POST["Acronymn"]));
	$name = mysql_escape_string($_POST["Name"]);
	//Verification
	$sql = BaseDonnee::execQuery($bdd, "SELECT * FROM Votes WHERE Acronymn = '$acr' OR Name = '$name'");
	//Si le vote existe déjà, onredirige avec une erreur
	if(!empty($sql)){
		$erreurs = true;
		$_SESSION["error"]["general"] = "You already have got a vote for this couple";
		header("Location: ./adminvote.php");
		exit();
	}

	//SInon, on génere une address bitcoin et on l'assigne à ce couple
	$walletid = BaseDonnee::execQuery($bdd, "SELECT Id FROM Wallets WHERE Acronymn = 'BTC'")[0]["Id"];
	$wallet = new Wallet($walletid);
	try{
		$address = $wallet->Client->getnewaddress("vote");
	}catch(Exception $e){
		$error = true;
		$_SESSION["error"]["general"] = "Cannot connect to BTC wallet";
	}

	if($error){
		header("Location: ./adminvote.php");
		exit();
	}

	try{
		BaseDonnee::addVote($bdd, $acr, $name, $address);
	}catch(Exception $e){
		$error = true;
		$_SESSION["error"]["general"] = "Cannot connect to BTC wallet";
	}
	
	header("Location: ./adminvote.php");
	exit();
}

//CHANGER ETAT VOTE
if(isset($_POST["updateVote"])){
	unset($_POST["updateVote"]);
	try{
		foreach ($_POST as $key => $value) {
			if($value == "Activer"){
				BaseDonnee::setVote($bdd, $key, 1);
			}else{
				BaseDonnee::setVote($bdd, $key, 0);
			}
		}
	}catch(Exception $e){
		echo $e->getMessage();
		die();
	}
	
	header("Location: ./adminvote.php");
	exit();
}


?>