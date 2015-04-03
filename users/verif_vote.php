<?php
require_once($_SERVER['DOCUMENT_ROOT']."/classes/BaseDonnee.class.php");
session_start();
session_regenerate_id();

$bdd = BaseDonnee::connexion();
$username = $_SESSION["pseudo"];

if(isset($_POST["makeVote"])){
	unset($_POST["makeVote"]);
	var_dump($_POST);
	foreach ($_POST as $key => $value) {
		//on verifie si il a déja voté pour ce coin
		
		$verif = BaseDonnee::execQuery($bdd, "SELECT * FROM Votes_History WHERE Username = '$username' AND Coin = '$key'");

		if(empty($verif)){ //jamais voté, on créé une ligne dans la db et on accepte son vote
			BaseDonnee::addVoteHistory($bdd, $username, $key, time());

			//Vote+1
			$total = BaseDonnee::execQuery($bdd, "SELECT * FROM Votes WHERE Acronymn = '$key'")[0]["Total"];
			BaseDonnee::editVoteTotal($bdd, $key, $total + 1);

			$_SESSION["notice"] = "Thanks for your vote !";
			header("Location: ./votes.php");
			exit();
		}else{
			echo "deja voté";
			var_dump($verif[0]);
			$lasttimestamp = $verif[0]["Timestamp"];
			$diff = time() - intval($lasttimestamp);
			echo "diff: ".$diff;
			if($diff < 86400){ //24h
				$_SESSION["error"] = "Sorry, you already voted for this coin today, please send some BTC to the indicated address or retry later";
			}else{
				//Vote+1
				$total = BaseDonnee::execQuery($bdd, "SELECT * FROM Votes WHERE Acronymn = '$key'")[0]["Total"];
				BaseDonnee::editVoteTotal($bdd, $key, $total + 1);
				BaseDonnee::setVoteHistory($bdd, $username, $key, time());

				$_SESSION["notice"] = "Thanks for your vote !";
			}
		}

		header("Location: ./votes.php");
		exit();
	}
}

?>