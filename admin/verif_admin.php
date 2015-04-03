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
//AJOUTER UN WALLET
if(isset($_POST["addName"])){
	if(!empty($_POST["addName"]) && !empty($_POST["addAcronymn"]) && !empty($_POST["addIP"])
		&& !empty($_POST["addUsername"]) && !empty($_POST["addPassword"]) && !empty($_POST["addPort"])){
		$name = ucfirst(strtolower($_POST["addName"]));
	$acronymn = strtoupper($_POST["addAcronymn"]);
		//Ajout des nouveau pair dans la table Markets
	$wallets = BaseDonnee::execQuery($bdd, "SELECT * FROM Wallets");
	//On génére les pairs seulement avec DOGE, BTC et LTC
	$generateWallet = array("BTC", "LTC", "DOGE");
	foreach ($wallets as $wallet) {
		if(in_array($wallet["Acronymn"], $generateWallet)){
			$pair = $acronymn."/".$wallet["Acronymn"];
			BaseDonnee::addPair($bdd, $pair);
		}
	}
	$success= BaseDonnee::addWallet($bdd, $name, $acronymn, $_POST["addIP"], $_POST["addUsername"], $_POST["addPassword"], $_POST["addPort"]);
		//Creation d'une balance pour chaque users:
	$sql = BaseDonnee::execQuery($bdd, "SELECT * FROM Users");
	$walletid = BaseDonnee::execQuery($bdd, "SELECT Id FROM Wallets WHERE Acronymn = '$acronymn'")[0]["Id"];
	foreach ($sql as $user) {
		BaseDonnee::addBalance($bdd, $user["Username"], $acronymn, $walletid);
	}


	if(!$success){
		echo "Probleme de connexion à la base de donnée";
		die();
	}else{
		header("Location: ./admin.php");
		exit();
	}
}else{
	header("Location: ./admin.php");
	exit();
} 
}


//Pour activer ou desactiver un portefeuille
if(isset($_POST["activerWallet"])){
	BaseDonnee::setState($bdd, $_SESSION["walletName"], 0);
	unset($_SESSION["walletName"]);
	header("Location: ./activewallet.php");
	exit();
}
if(isset($_POST["desactiverWallet"])){
	BaseDonnee::setState($bdd, $_SESSION["walletName"], 1);
	unset($_SESSION["walletName"]);
	header("Location: ./activewallet.php");
	exit();
}

//Update des renseignement d'un wallet
if(isset($_POST["setWallets"])){
	unset($_POST["setWallets"]);
	unset($_POST["updatewallet"]);
	$success = true;
	foreach ($_POST as $key => $value) {
		$row = strstr($key, "-", true);
		$coin = substr(strstr($key, "-"), 1);
		$walletid = BaseDonnee::execQuery($bdd, "SELECT * FROM Wallets WHERE Acronymn='$coin'")[0]["Id"];
		if($row == "txFee") continue;
		if($value == "Inactif"){
			$value = '1';
			BaseDonnee::setWallet($bdd, "Market", $coin, 0);
		}
		if($value == "Actif") $value = '0';
		BaseDonnee::setWallet($bdd, $row, $coin, $value);
	}
	
	foreach ($_POST as $key => $value) {
		$row = strstr($key, "-", true);
		$coin = substr(strstr($key, "-"), 1);
		if($row == "txFee"){
			$walletid = BaseDonnee::execQuery($bdd, "SELECT * FROM Wallets WHERE Acronymn='$coin'")[0]["Id"];
			
			$newfee = (float)sprintf("%.8f", $_POST["txFee-".$coin]); 
			BaseDonnee::setWallet($bdd, "txFee", $coin, $newfee);
			$walletname = BaseDonnee::execQuery($bdd, "SELECT Name FROM Wallets WHERE Id = '$walletid'")[0]["Name"];

			try{
				$wallet = new Wallet($walletid);
				$wallet->Client->settxfee($newfee);
			}catch(Exception $e){
				BaseDonnee::setState($bdd, $walletname, 1);
			}
		}
	}
	header("Location: ./addwallet.php");
	exit();
}

//Modification d'une currency principale
if(isset($_POST["setMarkets"])){
	unset($_POST["setMarkets"]);
	$wallets = BaseDonnee::execQuery($bdd, "SELECT * FROM Wallets");
	foreach ($wallets as $wallet) {
		if(!empty($_POST[$wallet["Name"]]) && $wallet["disabled"] != '1'){
			BaseDonnee::setWallet($bdd, "Market", $wallet["Acronymn"], 1);
		}else{
			//Si on desactive un market, on desactive toutes les pairs associées
			$markets = BaseDonnee::execQuery($bdd, "SELECT * FROM Markets");
			foreach ($markets as $market) {
				$coin1 = strstr($market["Pair"], "/", true);
				$coin2 = substr(strstr($market["Pair"], "/"), 1);
				//Si le market qu'on desactive fait parti d'une pair, on doit vérifier si le wallet de la deuxieme partie 
				//de celle ci est actif. Si oui, on fait rien, si non on le desactive. 
				if ($coin1 == $wallet["Acronymn"]){
					foreach ($wallets as $key) {
						if($key["Acronymn"] == $coin2 && $key["Market"] == "0"){
							BaseDonnee::setMarketState($bdd, $market["Pair"], 1);
						}
					}
				}else if($coin2 == $wallet["Acronymn"]){
					foreach ($wallets as $key) {
						if($key["Acronymn"] == $coin1 && $key["Market"] == "0"){
							BaseDonnee::setMarketState($bdd, $market["Pair"], 1);
						}
					}
				}
			}
			BaseDonnee::setWallet($bdd, "Market", $wallet["Acronymn"], 0);
		}
	}
	header("Location: ./activemarket.php");
	exit();
}

//Modification trade pairs visible
if(isset($_POST["setPairs"])){
	unset($_POST["setPairs"]);
	$markets = BaseDonnee::execQuery($bdd, "SELECT * FROM Markets");
	foreach ($markets as $market) {
		//Activer une pair trade (Un des marchés associés doit être actifs)
		if(!empty($_POST[$market["Pair"]])){
			$coin1 = strstr($market["Pair"], "/", true);
			$coin2 = substr(strstr($market["Pair"], "/"), 1);
			$isdisabled = BaseDonnee::execQuery($bdd, "SELECT * FROM Wallets WHERE Market = '1' AND (Acronymn = '$coin1' OR Acronymn = '$coin2')");
			$actif1 = BaseDonnee::execQuery($bdd, "SELECT * FROM Wallets WHERE Acronymn = '$coin1'")[0]["disabled"];
			$actif2 = BaseDonnee::execQuery($bdd, "SELECT * FROM Wallets WHERE Acronymn = '$coin2'")[0]["disabled"];
			if(!empty($isdisabled) && ($actif1 != '1') && ($actif2 != '1')) {
				$fee = (float)sprintf("%.8f", $_POST["fee".$market["Pair"]]);
				BaseDonnee::setMarketFee($bdd, $market["Pair"], $fee);
				BaseDonnee::setMarketState($bdd, $market["Pair"], 0);
			}else{
				BaseDonnee::setMarketState($bdd, $market["Pair"], 1);
			}
		}else{
		//Desactiver une pair trade
			BaseDonnee::setMarketState($bdd, $market["Pair"], 1);
		}
	}
	header("Location: ./activepair.php");
	exit();
}



//Cette boucle va mettre à jour toute la BDD en fonction des choix de l'administrateur (activer ou desactiver une certaine currency)
// foreach ($lines as $line){

// 	try{
// 		$actif = ($_POST["actif".$line["name"]] == "Actif") ? '1' : '0';
// 		$fee = $_POST["fee".$line["name"]];
// 		BaseDonnee::setState($bdd, $line["name"], $actif);
// 		BaseDonnee::setFees($bdd, $line["name"], $fee);
// 	}catch(Exception $e){
// 		$_SESSION["addErreur"] = $e->getMessage();
// 	}

// }
// //AJOUTER UNE PAIR DE CURRENCY
// if(isset($_POST["addpair"], $_POST["addfee"], $_POST["addstate"])){
// 	if(empty($_POST["addpair"]) || empty($_POST["addfee"]) || empty($_POST["addstate"])){
// 		header("Location: ./settings_admin.php");
// 		exit();
// 	}else{
// 		$state = '0';
// 		if($_POST["addstate"] == "Actif") $state = '1';

// 		if (strpos($_POST["addpair"], '/') === false){
// 			$_SESSION["addErreur"] = "Please insert a valid couple (AAA/BBB)";
// 			header("Location: ./settings_admin.php");
// 			exit();
// 		}else{
// 			$success = BaseDonnee::addPair($bdd, $_POST["addpair"], $_POST["addfee"], $state);
// 			if($success){
// 				unset($_SESSION["addErreur"]);
// 			}else{
// 				$_SESSION["addErreur"] = "Probleme d'insertion en base de donnée";
// 			}
// 			header("Location: ./settings_admin.php");
// 			exit();
// 		}

// 	}
// }else{
// 	header("Location: ./settings_admin.php");
// 	exit();
// }



?>
