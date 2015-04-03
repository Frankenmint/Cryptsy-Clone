<?php
session_start();
session_regenerate_id();
require_once($_SERVER['DOCUMENT_ROOT']."/classes/BaseDonnee.class.php");
require_once($_SERVER['DOCUMENT_ROOT']."/classes/Wallet.class.php");

//Test si l'user est bien connecté
if(isset($_SESSION["pseudo"]) && !empty($_SESSION["pseudo"])){
	$username = $_SESSION["pseudo"];
}else{
	header('HTTP/1.0 404 Not Found');
	exit("<h1>404 Not Found</h1>\nThe page that you have requested could not be found.");
}

$bdd = BaseDonnee::connexion();


//Pour supprimer un order
if(isset($_POST["cancelorder"])){
	unset($_POST["cancelorder"]);
	$pageorder = false;
	if(isset($_POST["orderpage"])){
		$pageorder = true;
		unset($_POST["orderpage"]);
	}
	foreach ($_POST as $key => $value) {
		$id = (int)preg_replace("/[^0-9]/","",$key);
		$pair = strtolower(preg_replace("/[^A-Z-]/","",$key));
		//edit le held for orders
		$helding1 = 0;
		$helding2 = 0;
		$order = BaseDonnee::execQuery($bdd, "SELECT * FROM Trades WHERE Id ='$id'")[0];
		$explodepair = explode('/', $order["Pair"]);
		$coin1 = $explodepair[0];
		$coin2 = $explodepair[1];
		$sqlbalance1 = BaseDonnee::execQuery($bdd, "SELECT * FROM balances WHERE Account='$username' AND Coin = '$coin1'")[0];
		$sqlbalance2 = BaseDonnee::execQuery($bdd, "SELECT * FROM balances WHERE Account='$username' AND Coin = '$coin2'")[0];
		$fee = (float)sprintf("%.8f", $order["Fee"]);
		$amount = (float)sprintf("%.8f", $order["Amount"]);
		$value = (float)sprintf("%.8f", $order["Value"]);
		$total = (float)sprintf("%.8f", ($amount*$value));
		if($order["Type"] == "BUY"){
			$helding2 += ($total + ($total * $fee / 100));
		}else{
			$helding2 += $total * $fee / 100;
			$helding1 += $amount;
		}
		$newhelding1 = round($sqlbalance1["Helding"], 8) - round($helding1, 8);
		$newhelding2 = round($sqlbalance2["Helding"], 8) - round($helding2, 8);
		BaseDonnee::setHelding($bdd, $username, $coin1, $newhelding1);
		BaseDonnee::setHelding($bdd, $username, $coin2, $newhelding2);
		
        //Envoi d'une notification
        $text = "Your order $id has been cancelled.";		
        BaseDonnee::addNotification($bdd, $username, "information", $text);
		//Envoi d'une notification end
		
		$c = BaseDonnee::deleteTrade($bdd, $id);
		if($pageorder){
			header("Location: /users/orders.php");
		}else{
			header("Location: /users/trades.php?market=".$pair);
		}
			
		exit();
	}
}


// Pour ajouter un order
if(isset($_POST["type"], $_POST["amount"], $_POST["price"], $_POST["pair"])){
	$username = $_SESSION["pseudo"];
	$erreurs = array(  "amount" => "", "value" => "", "price" => "", "general" => ""); 
	$error = false;
	//Verifications

	$pair = $_POST["pair"];
	$explodepair = explode('/', $pair);
	$coin1 = $explodepair[0];
	$coin2 = $explodepair[1];
	$verifcoin = BaseDonnee::execQuery($bdd, "SELECT * FROM Markets WHERE Pair = '$pair'")[0];
	if(empty($verifcoin)){
		header("Location: /users/index.php");
		exit();
	}else{
		if($_POST["fee"] != $verifcoin["Fee"]){
			$error = true;
			$erreurs["general"] = "Request error, please try again.";
			header("Location: /users/trades.php?market=".strtolower($coin1.'-'.$coin2));
			exit();
		}
		$fee = (float)sprintf("%.8f", $_POST["fee"]);
	}

	$type = $_POST["type"];
	if($type != "SELL" && $type != "BUY"){
		$error = true;
		$erreurs["general"] = "Request error, please try again.";
	}
	$verif_type = ($type == "SELL") ? "buy" : "sell";

	$amount = (float)sprintf("%.8f", $_POST["amount"]);
	if($amount <= 0){
		$error = true;
		$erreurs["general"] = "Please enter a valid amount and higher than 0.0";
	}

	$value = (float)sprintf("%.8f", $_POST["price"]);
	if($value <= 0){
		$error = true;
		$erreurs["general"] = "Please enter a valid price and higher than 0.0";
	}
	$value = number_format($value, 8, '.', '');

	$total = $amount * $value;
	$totalfee = $total * $fee/100; 

	$sqlbalance1 = BaseDonnee::execQuery($bdd, "SELECT * FROM balances WHERE Account='$username' AND Coin = '$coin1'")[0];
	$balance1 = floatval($sqlbalance1["Amount"]) - floatval($sqlbalance1["Helding"]);
	$sqlbalance2 = BaseDonnee::execQuery($bdd, "SELECT * FROM balances WHERE Account='$username' AND Coin = '$coin2'")[0];
	$balance2 = floatval($sqlbalance2["Amount"]) - floatval($sqlbalance2["Helding"]);
	//TODO: Test balance >= total
	if($type =="BUY"){
		if($balance2 < ($total+$totalfee)){
			$error = true;
			$erreurs["general"] .= "You haven't got enough ".$coin2." for process this order. ";
		}
	}else{
		//On verifie qu'il pourra donner les Coin1
		//La taxe (coin2) pourra être donnée lors de l'échange, donc on vérifie rien
		if($balance1 < $amount){
			$error = true;
			$erreurs["general"] .= "You haven't got enough ".$coin1." for process this order. ";
		}
	}

	if(!$error){
		try{
		//Premierement, on vérifie que l'order soit toujours pas fini, puis qu'il soit présent dans le type opposé
			$sql = BaseDonnee::execQuery($bdd, "SELECT * FROM Trades WHERE Finished = '0' AND type = '$verif_type' AND  Value = '$value' ORDER BY DATE ASC");
		}catch(Exception $e){
			header("Location: /users/trades.php?market=".strtolower($explodepair[0].'-'.$explodepair[1]));
			exit();
		}
		//Si le resultat de la requete est vide, on a pas d'équivalent dans le type opposé. On peut donc ajouter normalement l'order dans la table trades
		if(empty($sql)){
			BaseDonnee::addTrade($bdd, $type, $username, number_format($amount, 8, '.', ''), number_format($value, 8, '.', ''), $pair, $fee, $total);
			//On ajoute aussi le helding pour cet order
			$helding1 = 0.0;
			$helding2 = 0.0;
			if($type == "BUY"){
				$helding2 += (float)(( $total + ($total * $fee / 100)));
			}else{
				$helding2 += (float)($total * $fee / 100);
				$helding1 += (float)($amount);
			}
			$newhelding1 = floatval($sqlbalance1["Helding"]) + $helding1;
			$newhelding2 = floatval($sqlbalance2["Helding"]) + $helding2;
			BaseDonnee::setHelding($bdd, $username, $coin1, $newhelding1);
			BaseDonnee::setHelding($bdd, $username, $coin2, $newhelding2);
			header("Location: /users/trades.php?market=".strtolower($coin1.'-'.$coin2));
			exit();
		}else{
		//D'autres users recherchent au même prix, on les parcours et effectue le multi trade si besoin
			$coinDonne = ($type == "SELL") ? $coin1 : $coin2;
			$coinRecu = ($coinDonne == $coin1) ? $coin2 : $coin1;
			$walletid1= BaseDonnee::execQuery($bdd, "SELECT * FROM Wallets WHERE Acronymn='$coin1' AND disabled='0'")[0]["Id"];
			$walletid2= BaseDonnee::execQuery($bdd, "SELECT * FROM Wallets WHERE Acronymn='$coin2' AND disabled='0'")[0]["Id"];
			if(empty($walletid1) || empty($walletid2)){
				$erreurs["general"] = "Wallet maintenance, please retry later";
				$_SESSION["erreurs"] = $erreurs;
				header("Location: /users/trades.php?market=".strtolower($coin1.'-'.$coin2));
				exit();
			}

			//Creation des wallets
			$wallet1 = new Wallet($walletid1);
			$wallet2 = new Wallet($walletid2);
			try{
				$maintenance = $coin1;
				$wallet1->Client->getinfo();
				$maintenance = $coin2;
				$wallet2->Client->getinfo();
			}catch(Exception $e){
				$erreurs["general"] = $maintenance."'s wallet maintenance, please retry later";
				$_SESSION["erreurs"] = $erreurs;
				header("Location: /users/trades.php?market=".strtolower($coin1.'-'.$coin2));
				exit();
			}

			foreach ($sql as $order) {
				//Cas 0: notre amount est passé à 0, on sort de la boucle.
				if($amount == 0) break;
				$target = $order["Username"];
				$typeorder = ($order["Type"] == "BUY") ? "SELL" : "BUY";
				//if($username == $target) continue;

				$targetfee = floatval($order["Fee"]);

				$sqltargetbalance1 = BaseDonnee::execQuery($bdd, "SELECT * FROM balances WHERE Account='$target' AND Coin = '$coin1'")[0];
				$sqltargetbalance2 = BaseDonnee::execQuery($bdd, "SELECT * FROM balances WHERE Account='$target' AND Coin = '$coin2'")[0];
				$balancetarget1 = floatval($sqltargetbalance1["Amount"]);
				$balancetarget2 = floatval($sqltargetbalance2["Amount"]);
				$targethelding1 =floatval($sqltargetbalance1["Helding"]);
				$targethelding2 = floatval($sqltargetbalance2["Helding"]);
				
				$sqlbalance1 = BaseDonnee::execQuery($bdd, "SELECT * FROM balances WHERE Account='$username' AND Coin = '$coin1'")[0];
				$sqlbalance2 = BaseDonnee::execQuery($bdd, "SELECT * FROM balances WHERE Account='$username' AND Coin = '$coin2'")[0];
				$balanceuser1 = floatval($sqlbalance1["Amount"]);
				$balanceuser2 = floatval($sqlbalance2["Amount"]);
				
				$balanceadmin= 0;
				$tmphelding1 = 0.0;
				$tmphelding2 = 0.0;
				//Cas 1: l'amount de target est superieur -> on trade notre reste et on edit l'amount de l'user N
				if(floatval($order["Amount"]) > $amount){
					echo "amount de target est superieur           ";
					//Reste pour le target
					$amount = floatval($amount);
					$reste = floatval($order["Amount"]) - $amount;
					$total= (float)sprintf("%.8f", ($amount * $value));
					$totalfee = $total * $fee/100; 
					//On effectue le trade de cryptocurrency entre user et target
					//On effectue le trade de cryptocurrency entre user/target et l'admin.

					if($type =="BUY"){
						echo "<p>Donne ".$total." ".$coin2." a target</p>";
						$wallet2->Client->move($username, $target, $total);
						$balanceuser2 -= $total;
						$balancetarget2 += $total;
						echo "<p>Donne ".$totalfee." ".$coin2." a l'admin</p>";
						if($username != "admin"){
							$wallet2->Client->move($username, "admin", $totalfee);
							$balanceuser2 -= $totalfee;
							$balanceadmin += $totalfee;
						}
						echo '<p>Target donne '.($total*$targetfee/100)." ".$coin2." a l'admin</p>";
						
						$wallet2->Client->move($target, "admin", ($total*$targetfee/100));
						$tmphelding2 += ($total*$targetfee/100);
						$balanceadmin += ($total*$targetfee/100);
						
						echo '<p>Target donne '.$amount." ".$coin1." a user</p>";
						$wallet1->Client->move($target, $username, $amount);
						$balanceuser1 += $amount;
						$tmphelding1 += $amount;
						BaseDonnee::addTradeHistory($bdd, $pair, $typeorder, number_format($value, 8, '.', ''), number_format($amount, 8, '.', ''), $username, $target);
					}else{
						echo "<p>Donne ".$amount." ".$coin1." a target</p>";
						$wallet1->Client->move($username, $target, $amount);
						$balanceuser1 -= $amount;
						$balancetarget1 += $amount;
						echo "<p>Donne ".($total*$fee/100)." ".$coin2." a l'admin</p>";
						if($username != "admin"){
							$wallet2->Client->move($username, "admin", ($total*$fee/100));
							$balanceuser2 -= ($total*$fee/100);
							$balanceadmin += ($total*$fee/100);
						}
						echo '<p>Target donne '.($amount*$value*$targetfee/100)." ".$coin2." a l'admin</p>";
						
						$wallet2->Client->move($target, "admin", ($amount*$value*$targetfee/100));
						$tmphelding2 += $amount*$value*$targetfee/100;
						$balanceadmin += $amount*$value*$targetfee/100;

						echo '<p>Target donne '.$total." ".$coin2." a user</p>";
						$wallet2->Client->move($target, $username, $total);
						$balanceuser2 += $total;
						$tmphelding2 += $total;
						BaseDonnee::addTradeHistory($bdd, $pair, $typeorder, number_format($value, 8, '.', ''), number_format($amount, 8, '.', ''), $target, $username);
					}

					//edition de l'order de target (avec $reste)
					BaseDonnee::setTradeAmount($bdd, $order["Id"], $reste);
					echo "     Il reste ".$reste." amount of target";
					
					$amount = 0;
				}
				//Cas 2: l'amount de target est plus petit ou égal-> on trade tout ce qu'il a et on efface son order
				else{
					$amounttarget = floatval($order["Amount"]);
					$total= (float)sprintf("%.8f", ($amounttarget * $value));
					$totalfee = $total * $fee/100; 
					echo "the amount of the target is less or equal";
					
					//On effectue le trade de cryptocurrency entre user et target
					//On effectue le trade de cryptocurrency entre user/target et l'admin.
					if($type =="BUY"){
						echo "<p>Donne ".$total." ".$coin2." a target</p>";
						$wallet2->Client->move($username, $target, $total);
						$balanceuser2 -= $total;
						$balancetarget2 += $total;
						echo "<p>Donne ".$totalfee." ".$coin2." a l'admin</p>";
						if($username != "admin"){
							$wallet2->Client->move($username, "admin", $totalfee);
							$balanceuser2 -= $totalfee;
							$balanceadmin += $totalfee;
						}
						echo '<p>Target donne '.($total*$targetfee/100)." ".$coin2." a l'admin</p>";
						
						$wallet2->Client->move($target, "admin", ($total*$targetfee/100));
						$tmphelding2 += ($total*$targetfee/100);
						$balanceadmin += ($total*$targetfee/100);
						
						echo '<p>Target donne '.$amounttarget." ".$coin1." a user</p>";
						$wallet1->Client->move($target, $username, $amounttarget);
						$balanceuser1 += $amounttarget;
						$tmphelding1 += $amounttarget;
						BaseDonnee::addTradeHistory($bdd, $pair, $typeorder, number_format($value, 8, '.', ''), number_format($amounttarget, 8, '.', ''), $username, $target);
					}else{
						echo "<p>Donne ".$amounttarget." ".$coin1." a target</p>";
						$wallet1->Client->move($username, $target, $amounttarget);
						$balanceuser1 -= $amounttarget;
						$balancetarget1 += $amounttarget;
						echo "<p>Donne ".($total*$fee/100)." ".$coin2." a l'admin</p>";
						if($username != "admin"){
							$wallet2->Client->move($username, "admin", ($total*$fee/100));
							$balanceuser2 -= ($total*$fee/100);
							$balanceadmin += ($total*$fee/100);
						}
						echo '<p>Target donne '.($amounttarget*$value*$targetfee/100)." ".$coin2." a l'admin</p>";
						
						$wallet2->Client->move($target, "admin", ($amounttarget*$value*$targetfee/100));
						$tmphelding2 += $amounttarget*$value*$targetfee/100;
						$balanceadmin += $amounttarget*$value*$targetfee/100;
						
						echo '<p>Target donne '.$total." ".$coin2." a user</p>";
						$wallet2->Client->move($target, $username, $total);
						$balanceuser2 += $total;
						$tmphelding2 += $total;
						echo "<p>echanges terminée, ajout du trade dans l'history</p>";
						BaseDonnee::addTradeHistory($bdd, $pair, $typeorder, number_format($value, 8, '.', ''), number_format($amounttarget, 8, '.', ''), $target, $username);
						echo "<p>ajout en BDD terminé</p>";

					}
					echo "<p>suppression de l'open order</p>";
					BaseDonnee::deleteTrade($bdd, $order["Id"]);
					echo "<p>terminée</p>";
					$amount -= $amounttarget;
					echo "<p>amount devient ".$amount."</p>";
				}
				// edition des held for orders et des balances
				echo "<p>editions des helding et balances</p>";
				if($username == "admin"){
					$balanceuser2 += $balanceadmin;
				}
				else if($target == "admin"){
					$balancetarget2 += $balanceadmin;
				}
				else{
					$currentbalanceadmin = BaseDonnee::execQuery($bdd, "SELECT * FROM balances WHERE Account='admin' AND Coin = '$coin2'")[0]["Amount"];
					$newadminbalance = floatval($currentbalanceadmin) + $balanceadmin;
					BaseDonnee::setBalance($bdd, "admin", $coin2, $newadminbalance);
				}
				BaseDonnee::setHelding($bdd, $target, $coin1, ($targethelding1 - $tmphelding1));
				BaseDonnee::setHelding($bdd, $target, $coin2, ($targethelding2 - $tmphelding2)); 
				BaseDonnee::setBalance($bdd, $target, $coin1, ($balancetarget1 - $tmphelding1));
				BaseDonnee::setBalance($bdd, $target, $coin2, ($balancetarget2 - $tmphelding2));
				BaseDonnee::setBalance($bdd, $username, $coin1, $balanceuser1);
				BaseDonnee::setBalance($bdd, $username, $coin2, $balanceuser2);
				echo "<p>terminés</p>";
			}
			//ici, on verifie que $amount soit bien egal à 0. si non, plus de trade possible : on effectue un order pour le reste.
			if($amount != 0){
				echo "<p>Plus d'autres targets, on effectue un ".$type." order d'amount ".$amount."</p>";
				$total = floatval(number_format(($amount*$value), 8));
				BaseDonnee::addTrade($bdd, $type, $username, number_format($amount, 8, '.', ''), number_format($value, 8, '.', ''), $pair, $fee, $total);
				//On ajoute aussi le helding pour cet order
				$helding1 = 0.0;
				$helding2 = 0.0;
				if($type == "BUY"){
					$helding2 += (float)(( $total + ($total * $fee / 100)));
				}else{
					$helding2 += (float)($total * $fee / 100);
					$helding1 += (float)($amount);
				}
				$newhelding1 = floatval($sqlbalance1["Helding"]) + floatval(number_format($helding1, 8));
				$newhelding2 = floatval($sqlbalance2["Helding"]) + floatval(number_format($helding2, 8));
				BaseDonnee::setHelding($bdd, $username, $coin1, $newhelding1);
				BaseDonnee::setHelding($bdd, $username, $coin2, $newhelding2);
			}
			header("Location: /users/trades.php?market=".strtolower($coin1.'-'.$coin2));
			exit();
		}
	}else{
		$_SESSION["erreurs"] = $erreurs;
		header("Location: /users/trades.php?market=".strtolower($coin1.'-'.$coin2));
		exit();
	}
	
}else{
	header('HTTP/1.0 404 Not Found');
	exit("<h1>404 Not Found</h1>\nThe page that you have requested could not be found.");
}
?>