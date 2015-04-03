<?php
require_once($_SERVER['DOCUMENT_ROOT']."/classes/BaseDonnee.class.php");
$bdd = BaseDonnee::connexion();

$explodepair = explode("-", $_GET["pair"]);
$pair = $explodepair[0]."/".$explodepair[1];

$range = $_GET["range"];

$currentTime = time();
$delta = 0;

//Interval (en seconde) entre chaque point du graphe (different selon le bouton sélectionné)
switch($range){
	case "hour": // 6 dernieres heures
	$since = 21600;
		$delta = "300"; // 5 minutes
		break;

	case "day": // depuis 24h
	$since = 86400;
		$delta = "600"; // 10 minutes
		break;

	case "week": // depuis une semaine
	$since = 604800;
		$delta = "3600"; // 1 heure
		break;

	case "month": // depuis un mois
	$since = 2592000;
		$delta = "14400"; // 4 heures
		break;

	case "all":  // depuis le debut
	$since = $currentTime - 1395703990;
		$delta = "43200"; // 12 heures
		break;

		default:
		$error = true;
		break;
	}

$start = $currentTime - $since;
//Selectionne tous les trades effectués depuis "since" dans l'ordre chronologique croissant
$history = BaseDonnee::execQuery($bdd, "SELECT Timestamp, Price, Quantity FROM Trade_History WHERE Market='$pair' AND Timestamp >= '$start' ORDER BY Timestamp ASC");
if(empty($history)){
	$history = BaseDonnee::execQuery($bdd, "SELECT Timestamp, Price, Quantity FROM Trade_History WHERE Market='$pair' ORDER BY Timestamp DESC LIMIT 1");
	$history[0]["Quantity"] = '0';
}

$data = array();
// à l'aide de delta, création de paquets de trades
$paquetTotal = 0;
$paquetVide = 0;
for($i = $start; $i <= $currentTime + $delta; $i += $delta){
	$tmp = array(); // Pour stocker le paquet de trades
	foreach ($history as $j => $trade) {
		if($trade["Timestamp"] < $i){
			$trade["Timestamp"] = $i;
			$tmp[] = $trade;
			unset($history[$j]);
		}else{
			break;
		}
	}
	if(empty($tmp)){
		$tmp[]["Timestamp"] = $i;
		$paquetVide++;
	}
	$data[] = $tmp;
	$paquetTotal++;
}

//TODO: data contient les paquet, faire une boucle qui fusionne les paquet en retournant pour chacun un array:
//[Timestamp(ms), open, high, low, close, volume]
$result = $array;

for($i = 0; $i < sizeof($data); $i++) {
	$tmp = array();
	$date = $data[$i][0]["Timestamp"] * 1000;
	//SI le paquet est vide, on reprend les valeurs de l'ancien avec open = low = high = close
	if(sizeof($data[$i][0]) == 1){
		//Si tous les paquets sont vide, on met
		if($paquetTotal == $paquetVide){
			$tmp = array($date, 0, 0, 0, 0 ,0); 
		}else{
			$prev = $result[$i-1];
			$tmp = array($date, $prev[4], $prev[4], $prev[4], $prev[4], 0); //4 : close
		}
		$result[] = $tmp;
	}else{
		
		$open = floatval($data[$i][0]["Price"]);
		$low = $open;
		$high = $open;
		$close = floatval(end($data[$i])["Price"]); reset($data[$i]);
		$volume = 0;
		foreach ($data[$i] as $trade) {
			$price = floatval($trade["Price"]);
			$quantity = floatval($trade["Quantity"]);
			if($price < $low) $low =  $price;
			if($price > $high) $high = $price;
			$volume += $quantity;
		}
		$result[] = array($date, $open, $high, $low, $close, $volume);
	}
}
echo json_encode($result);
?>
