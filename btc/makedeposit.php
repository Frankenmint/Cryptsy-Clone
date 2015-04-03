<?php
$coin = strtoupper(end(explode('/', dirname(__FILE__))));
session_start();
session_regenerate_id();
require_once($_SERVER['DOCUMENT_ROOT']."/classes/BaseDonnee.class.php");
require_once($_SERVER['DOCUMENT_ROOT']."/classes/Wallet.class.php");

$bdd = BaseDonnee::connexion();
//Test si l'user est bien connecté
include_once($_SERVER['DOCUMENT_ROOT']."/includes/verifications.php");

$sql = BaseDonnee::execQuery($bdd, "SELECT * FROM Wallets WHERE Acronymn='$coin' AND disabled='0'")[0];

$walletID = $sql["Id"];
$wallet = new Wallet($walletID);
$username = $_SESSION["pseudo"];
$balance = BaseDonnee::execQuery($bdd, "SELECT Amount FROM balances WHERE Account='$username' AND `Wallet_ID` = '$walletID'")[0]["Amount"];   

try{
	if(isset($_POST["depositaddress"])){
		$address = $wallet->Client->getnewaddress($username);
	}else{
		$address = $wallet->Client->getaccountaddress($username);
	}
}catch(Exception $e){
	$_SESSION["erreurs"]["general"] = "Wallet maintenance, please retry later";
}

?>

<head>
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="../js/jquery-1.10.2.min.js"></script>
</head>

<style>
body {
	background: #ffffff;
}
</style>

<script>
$(document).ready(function(){$("input").attr("autocomplete","off");});
$(function() {
	var x = $('#mydiv').width();
	var y = $('#mydiv').height();
	parent.$.colorbox.resize({innerWidth:x/1.3, innerHeight:y});
	
});
</script>

<div id='mydiv' class="page page-settings" style="width: 100%;">
	<div class="panel panel-default panel-account-balances">
		<div class="panel-heading"> <span class="glyphicon glyphicon-triggers"></span> Deposit <?php echo$sql["Name"];;?></div> 
		<div class="panel-body" style="padding:0px;">
			<div class="row">
				<div class="col-xs-6">
					<label class="text-danger" for=""><?php echo $_SESSION["erreurs"]["general"];?> </label>
				</div>
			</div>
			<form action="./makedeposit.php" name="tradesell" id="TradeSellMakedepositForm" method="post" accept-charset="utf-8">
				<div class="row">
					<h4>Current Balance: <?php echo $balance.' '.$coin;?></h4>
				</div>
				<div class="row">
					<div>Notice: Do NOT mine directly to this deposit address.</div>   
				</div> 
				<br />
				<div class="row">
					<div class="form-group " id="depositmask">
						<label for="">Your Deposit Address</label>
						<input style='width:400px; font-size:13pt; color:blue;-moz-border-radius: 15px; border-radius: 15px; border:solid 1px black; padding:5px;' type='text' value=<?php echo "'".$address."'";?>>                      
						<input name='depositaddress' class='btn btn-default btn-success' type='submit' value='Generate a new deposit address'>
					</div>

				</div>
				<div class="row">
					<p>Deposits post after 4 confirmations. You may use older addresses after generating a new address.</p> 
				</div>
			</form>
		</div> 
		
	</div>
</div>
</div>

<?php
unset($_SESSION["erreurs"]);
?>
