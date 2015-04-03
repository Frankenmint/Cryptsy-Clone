<?php
$coin = strtoupper(end(explode('/', dirname(__FILE__))));
session_start();
session_regenerate_id();
require_once($_SERVER['DOCUMENT_ROOT']."/classes/BaseDonnee.class.php");
require_once($_SERVER['DOCUMENT_ROOT']."/classes/Wallet.class.php");

$bdd = BaseDonnee::connexion();
//Test si l'user est bien connecté
include_once($_SERVER['DOCUMENT_ROOT']."/includes/verifications.php");

try{
	
	$sql = BaseDonnee::execQuery($bdd, "SELECT * FROM Wallets WHERE Acronymn='$coin' AND disabled='0'")[0];
	if(empty($sql)) die("This wallet is temporaly disabled");
	//User informations
	$userid = BaseDonnee::execQuery($bdd, "SELECT * FROM Users WHERE Username='$username'")[0]["User_ID"];
	$balance = BaseDonnee::execQuery($bdd, "SELECT * FROM balances WHERE Account='$username' AND Coin = '$coin'")[0];
	//Fees informations
	$fee = (float)sprintf("%.8f", $sql["Fee"]); // total withdrawal fee
	$txfee = (float)sprintf("%.8f", $sql["txFee"]); //fee for the miners
	$balance = (float)sprintf("%.8f", ($balance["Amount"] - $balance["Helding"]));
	if(empty($balance)) $balance = 0;
}catch(Exception $e){
	header('HTTP/1.0 404 Not Found');
	exit("<h1>404 Not Found</h1>\nThe page that you have requested could not be found.");
}

$walletID = $sql["Id"];
$wallet = new Wallet($walletID);
$_SESSION["erreurs"] = array("general" => "",
	"amount" => "",
	"address" => "",
	"password" => "");
$error = false;

if(!empty($_POST["amount"])){
	if(empty($_POST["amount"]) || empty($_POST["address"]) || empty($_POST["password"])) {
		$_SESSION["erreurs"]["general"] = "A field is missing";
	}
	if(floatval($_POST["amount"]) > 0) {
		$amount = (float)sprintf("%.8f", $_POST["amount"]);
		$total = (float)sprintf("%.8f", ($amount - $fee));
		if($amount > $balance){
			$_SESSION["erreurs"]["general"] = "You haven't got enough coins".$amount." ".$total;
			$error = true;
		}
		if($total <= 0){
			$_SESSION["erreurs"]["general"] = "You can't withdraw null or negative amount";
			$error = true;
		}
	}else{
		$_SESSION["erreurs"]["amount"] = "has to be a positive number";
		$error = true;
	}
	if((strlen($_POST["address"]) < 27) || (strlen($_POST["address"]) > 34)){
		$_SESSION["erreurs"]["address"] = "size is invalid";
		$error = true;
	}
	if(!ctype_alnum($_POST["address"])){
		$_SESSION["erreurs"]["address"] = "is invalid";
		$error = true;
	}

		//Test si le dernier withdrawal etait il y a plus de 30 secondes
	$current = time();
	$date = BaseDonnee::execQuery($bdd, "SELECT Timestamp FROM Withdraw_History WHERE User = '$username'")[0]["Timestamp"];
	$difference = $current - (strtotime($date));
	if($difference < 30){
		$error = true;
		$_SESSION["erreurs"]["general"] = "Please wait at least 30 seconds for make another withdraw</br>";
	}

	$success = BaseDonnee::mdpValide($bdd, $username, $_POST["password"]);
	if(!$success){
		$_SESSION["erreurs"]["password"] = "is wrong";
		$error = true;
	}else{

		if(!$error){
			try{
				//Verify the txFee is the same
				$walletFee = $wallet->GetTxFee();
				if($txfee != $walletFee){
					try{
						$wallet->Client->settxfee($txfee);
					}catch(Exception $e){
						echo "This wallet is in maintenance, please try later";
						die();
					}
				}
				
				//Send from the current user account to the specified address
				$address = mysql_real_escape_string($_POST["address"]);
				$transactionamount = $amount - $fee;
				$transactionID = $wallet->Withdraw($bdd, $username, $address, $transactionamount, $coin);
				BaseDonnee::addWithdrawal($bdd, $username, $amount , $address, $coin);

				//update user's balance
				$newbalance = $balance - $amount;
				BaseDonnee::setBalance($bdd, $username, $coin, $newbalance);

				

				//Move fees to admin
				//If the transaction il in the same wallet, we transert the txfees to the admin and we update target balance
				try{
					$target = $wallet->Client->getaccount($address);
					$doMove = true;
				}catch(Exception $e){
					$doMove = false;
				}
				if($doMove){
					$feeForAdmin = (float)sprintf("%.8f", $fee);
					$targetbalance =  BaseDonnee::execQuery($bdd, "SELECT * FROM balances WHERE Account='$target' AND Coin = '$coin'")[0]["Amount"];
					if(empty($targetbalance)){
						echo "Wallet maintenance, please retry later";
						die();
					}
					$newtargetbalance = $targetbalance + $amount - $fee;
					BaseDonnee::setBalance($bdd, $target, $coin, $newtargetbalance);
				}else{
					$feeForAdmin = (float)sprintf("%.8f", ($fee - $txfee));
				}

				//Admin informations
				$adminid = BaseDonnee::execQuery($bdd, "SELECT * FROM Users WHERE Username='admin'")[0]["User_ID"];
				$adminbalance =  BaseDonnee::execQuery($bdd, "SELECT * FROM balances WHERE Account='admin' AND Coin = '$coin'")[0]["Amount"];
				$newbalanceadmin = $adminbalance + $feeForAdmin;
				$wallet->Client->move($username, "admin", $feeForAdmin);
				BaseDonnee::setBalance($bdd, "admin", $coin, $newbalanceadmin);

				header("Location: /users/winwithdrawal.php");
				exit();
			}catch(Exception $e){
				$_SESSION["erreurs"]["general"] = "Wallet maintenance, please retry later";
			}
		}

	}
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
	parent.$.colorbox.resize({innerWidth:x/2, innerHeight:y});	
});
function post_to_url(path, params, method) {
    method = method || "post"; // Set method to post by default if not specified.

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
    	if(params.hasOwnProperty(key)) {
    		var hiddenField = document.createElement("input");
    		hiddenField.setAttribute("type", "hidden");
    		hiddenField.setAttribute("name", key);
    		hiddenField.setAttribute("value", params[key]);

    		form.appendChild(hiddenField);
    	}
    }

    document.body.appendChild(form);
    form.submit();
}

function post_withdrawal(){
	post_to_url('./makewithdrawal.php', {amount: $('#amount').val(), address: $('#address').val(), password: $('#password').val()});
}


function updateTotal(value){
	var fee = parseFloat($('#withdrawalfee').html());
	var amount = parseFloat($('#amount').val());
	var res = amount - fee;

	if ( $.trim($('#amount').val()) == '' || res.toFixed(8) == "NaN"){
		$('#netwithdrawal').html('0.0');
		return true;
	}else{
		$('#netwithdrawal').html(parseFloat(res.toFixed(8)));
		return true;
	}

}
</script>

<div id='mydiv' class="page page-settings" style="width: 100%;">
	<div class="panel panel-default panel-account-balances">
		<div class="panel-heading"> <span class="glyphicon glyphicon-export"></span> Withdraw <?php echo$sql["Name"];?></div> 
		<div class="panel-body" style="padding:0px;">
			<div class="row">
				<div class="col-xs-6">
					<label class="text-danger" for=""><?php echo $_SESSION["erreurs"]["general"];?> </label>
				</div>
			</div>
			<form id="myform" action="./makewithdrawal.php" method="POST">
				<div class="row">
					<h4>Current Balance: <?php echo $balance.' '.$coin;?></h4>
				</div>
				<div class="row">
					
					<div class="col-xs-6">

						<div class="form-group">
							<label for="">Amount <span class="text-danger"> <?php echo $_SESSION["erreurs"]["amount"];?> </span></label>
							<input id="amount" onKeyUP="updateTotal(this.value);" class="form-control" type="text" placeholder="Insert an amount higher than 0.0"/>                          
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-3">
						<div class="form-group">
							<h5>Withdrawl fee: <strong><span id = "withdrawalfee"><?php echo $fee;?></span><?php echo(" ".$coin);?></strong></h5>                     
						</div>
					</div>
					<div class="col-xs-9">
						<div class="form-group">
							<h5>Net Withdrawal: <strong><span class="text-success" id = "netwithdrawal">0.0</span> <?php echo(" ".$coin);?></strong></h5>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-6">
						<div class="form-group">
							<label for="">Address <span class="text-danger"> <?php echo $_SESSION["erreurs"]["address"];?> </span></label>
							<input id="address" class="form-control" type="text" placeholder=<?php echo "'Insert a valid ".$sql["Name"]." address'";?>/>                          
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-xs-6">
						<div class="form-group">
							<label for="">Password <span class="text-danger"> <?php echo $_SESSION["erreurs"]["password"];?> </span></label>
							<input id="password" class="form-control" type="password"/>                          
						</div>
					</div>
				</div>
				<div clas="row">
					<div class="col-xs-6">
						<input name="processwithdrawal" type="button" class='btn btn-default btn-success' value="Process Withdrawal" onClick="post_withdrawal();"/>
					</div>
				</div>
			</form>
		</div> 

	</div>
</div>

<?php
unset($_SESSION["erreurs"]);
?>
