<?php
$filename = explode('.', basename($_SERVER['PHP_SELF']))[0];
if($filename == "checkDepositCron"){
	require_once("classes/jsonRPCClient.php");
}else{
	require_once($_SERVER['DOCUMENT_ROOT']."/classes/jsonRPCClient.php");	
}
class Wallet
{
	public $ip;
	public $port;
	public $username;
	public $password;
	public $Client;
	public $Wallet_Id;
	public $acronymn;

	function Wallet($Wallet_Id)
	{
		$bdd = BaseDonnee::connexion();
		$req = BaseDonnee::execQuery($bdd, "SELECT * FROM Wallets WHERE `Id`='$Wallet_Id'")[0];
		$this->acronymn = $req["Acronymn"];
		$this->ip = $req["Wallet_IP"];
		$this->username = $req["Wallet_Username"];
		$this->password = $req["Wallet_Password"];
		$this->Wallet_Id = $Wallet_Id;
		$this->port = $req["Wallet_Port"];
		$this->Client = new jsonRPCClient('http://' . $this->username . ':' .$this->password . '@' . $this->ip . ':' . $this->port . '/');

	}
	public function GetDepositAddress($account)
	{
		return $this->Client->getaccountaddress($account);
	}
	public function Withdraw($bdd, $user, $address,$total, $coin)
	{
		$address = mysql_real_escape_string($address);
		$total = mysql_real_escape_string($total);
		$user = mysql_real_escape_string($user);
		$isUser = false;
		try{
			$destinationUser = $this->Client->getaccount($address);
			if($destinationUser != ""){
				$isUser = true;
			}
		}catch(Exception $e){
			$isUser = false;
		}
		
		if ($total > 1000000) {
			if($isUser){
				$this->Client->move($user, $destinationUser, round($total));
				BaseDonnee::addDeposit($bdd, $destinationUser, round($total), 1, 'No txid', $this->acronymn, 4);
			}else{
				return $this->Client->sendfrom($user, $address, round($total), 4);
			}	
		}else{
			if($isUser){
				$this->Client->move($user, $destinationUser, (double)sprintf("%.8f", $total));
				BaseDonnee::addDeposit($bdd, $destinationUser, number_format($total, 8, '.', ''), 1, 'No txid', $this->acronymn, 4);
			}else{
				return $this->Client->sendfrom($user, $address, (double)sprintf("%.8f", $total), 4);
			}
		}
		
	}
	public function GetTxFee()
	{
		$info = $this->Client->getinfo();
		return $info["paytxfee"];
	}
	public function GetTransactions()
	{
		return $this->Client->listtransactions("*", 100);
	}
	public function GetTransaction($id)
	{
		return $this->Client->gettransaction($id);
	}
}
?>