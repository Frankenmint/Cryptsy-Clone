<?php
session_start();
session_regenerate_id();

set_include_path('/var/www/crypto-maniac.com/public_html');

require_once("classes/BaseDonnee.class.php");
require_once("classes/Wallet.class.php");

$bdd = BaseDonnee::connexion();
$sql = BaseDonnee::execQuery($bdd, "SELECT * FROM Wallets WHERE disabled ='0'");
$wallets = array();

//On met tous les wallets dans un array
foreach ($sql as $row) {
	//Creation de la wallet
	$walletid = $row["Id"];
	$coin = $row["Acronymn"];
	$wallet = new Wallet($walletid);
	echo $coin;
	// Envoi d'une notification par mail en cas d'erreur de connexion à un daemon
	try{
		//Ici, on va checker les pending deposits pour voir si ils ont assez de confirmation pour être accepté
		$pending = BaseDonnee::execQuery($bdd, "SELECT * FROM deposits WHERE Coin = '$coin' AND Paid = 0");
		foreach ($pending as $p) {
			$txid = $p["Transaction_Id"];
			$id = $p["id"];
			$account = $p["Account"];
			$amount = floatval($p["Amount"]);
			$pending_transaction = $wallet->Client->gettransaction($txid);
			$conf = intval($pending_transaction["confirmations"]);
			if($conf >= 4){
				//Si la transaction a suffisament de confirmations, on set son Paid à 1 et on set la Balance
				BaseDonnee::setDeposit($bdd, $id, 1, $conf);
				$balance = BaseDonnee::execQuery($bdd, "SELECT * FROM balances WHERE Coin = '$coin' AND Account='$account'")[0]["Amount"];
				$newbalance = floatval($balance) + $amount;
				BaseDonnee::setBalance($bdd, $account, $coin, $newbalance);
			}else{
				if($p["Confirmations"] != $pending_transaction["confirmations"]){
					BaseDonnee::setDeposit($bdd, $id, 0, $conf);
				}
			}
		}
		
		$lastHash = $row["Last_Hash"];
		/*S'il n'y a pas de "last hash" dans la BDD : le wallet viens d'être créée.
	 	  Il faut donc lui assigner la valeur du dernier hash */
		if(empty($lastHash)){
			$transactionsInfo = $wallet->Client->listsinceblock();
		}else{
			$transactionsInfo = $wallet->Client->listsinceblock($lastHash);
		}
		//Si $transactioninfos est vide, alors on a pas eu de nouvelles transactions. On passe son tour.
		if(empty($transactionsInfo["transactions"])) continue;

		echo "<pre>";
		var_dump($transactionsInfo);
	}catch(Exception $e){
		$email = BaseDonnee::getByUsername($bdd, "admin")["Email"];
		$object = $row["Name"]." Wallet ne répond pas";
		$from = 'adytech2010@gmail.com';
   		$header = 'From:'.$from;
		$message = "Le wallet ".$row["Name"]." semble avoir un problème et a été désactivée automatiquement.\nVeuillez le redemarrer et le réactiver dans le panel admin.\n";
		BaseDonnee::setState($bdd, $row["Name"], 1);
		if(mail($email,$object, $message, $header)){
			echo "mail sent";
		}else{
			echo "mail failed";
		}
	}

	
	/*Selectionne toutes les transactions depuis ce dernier hash.
	   Tri par timestamp croissant */
	
	sortBySubkey($transactionsInfo["transactions"], 'timereceived');
	$sortedTransactionInfos = $transactionsInfo["transactions"];
	var_dump($sortedTransactionInfos);
	//On parcourt toutes les transactions restantes dans l'ordre chronologique
	foreach ($sortedTransactionInfos as $transaction) {
		/*Theoriquement, si les withdrawals ont été supprimé, il n'y aura pas de send à archiver.
		* De plus, les trades étant realisé via seulement des "move", tous les "receive" sont forcemment des deposits
		* Nous allons ici archiver en BDD seulement les deposits, afin de s'assurer que la balance ne sera pas actualisée 2 fois.
		* La transaction doit avoir au minimum 4 confirmations pour être acceptée*/
		if(($transaction["category"] == "receive") && intval($transaction["confirmations"]) >= 1){
			$amount = (float)sprintf("%.8f", $transaction["amount"]);
			$account = $transaction["account"];
			$address = $transaction["address"];
			$txid = $transaction["txid"];
			$newhash =  $transaction["blockhash"]; 

			//On regarde si le dépot était destiné à un vote (seulement pour BTC)
			if($coin == "BTC"){
				$votes = BaseDonnee::execQuery($bdd, "SELECT * FROM Votes WHERE Address = '$address'");
				if(!empty($votes)){
					$voteNumber = intval($votes[0]["Total"]);
					$voteAdd = round(($amount / 0.0002), 0, PHP_ROUND_HALF_DOWN);
					if($voteAdd >= 1){
						BaseDonnee::editVoteTotal($bdd, "BTC", $voteNumber + $voteAdd);
					}
					continue;
				}
			}

			/*Reception de coins par un wallet tiers (deposit)
			* Mise à jour de la balance de l'user */
			if(intval($transaction["confirmations"]) >= 4){
				$balance = BaseDonnee::execQuery($bdd, "SELECT * FROM balances WHERE Coin = '$coin' AND Account='$account'")[0]["Amount"];
				$newbalance = floatval($balance) + $amount;
				BaseDonnee::setBalance($bdd, $account, $coin, $newbalance);
				//Ajout d'un deposit en BDD afin d'en retracer l'historique
				BaseDonnee::addDeposit($bdd, $account, $amount, 1, $txid, $row["Acronymn"], intval($transaction["confirmations"]));
			}else{
				//Une transaction a été detectée mais elle a moins de 4 confirmations
				BaseDonnee::addDeposit($bdd, $account, $amount, 0, $txid, $row["Acronymn"], intval($transaction["confirmations"]));
				echo "add deposit de ".$amount.$row["Acronymn"];
			}

			

		//On sauvegarde en BDD notre avancement en inserant le hash de la derniere transaction
		BaseDonnee::setHash($bdd, $walletid, $newhash);
		}
	}
	
}



function sortBySubkey(&$array, $subkey, $sortType = SORT_ASC) {
	foreach ($array as $subarray) {
		$keys[] = $subarray[$subkey];
	}
	array_multisort($keys, $sortType, $array);
}

?>
