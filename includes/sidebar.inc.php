<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/classes/BaseDonnee.class.php");
$bdd = BaseDonnee::connexion();
?>

<div class="" id="sidebar" role="navigation">
  <div class="alert alert-black"><b><?php echo date('M jS h:i A').' EST';?></b></div>
 
  <input type="hidden" id="visChangeText" value="1">

  <?php
  if(isset($_SESSION["pseudo"])){
    echo '
    <div class="moduletable moduletable-account-balances">
    <div class="moduletable-header"><span class="glyphicon glyphicon-account-balances"></span> Account Balances</div>
    <div class="account-balances-wrap" id="account-balances">
    <ul class="nav nav-list">
    ';
    $username = $_SESSION["pseudo"];
    $userbalances = BaseDonnee::execQuery($bdd, "SELECT * FROM balances WHERE Account='$username'");
    foreach ($userbalances as $balance){
      echo "<li>";
      echo "<a href = /users/funds.php>".$balance["Coin"]."<span class ='status pull-right'>";
      echo(number_format($balance["Amount"], 8, '.', '')."</span></a></li>");
    }
    echo"</ul></div></div>";
  }


  $markets = BaseDonnee::execQuery($bdd, "SELECT * FROM Wallets WHERE Market='1'");
  $tradepairs = BaseDonnee::execQuery($bdd, "SELECT * FROM Markets WHERE disabled = '0'");
  foreach ($markets as $market){
   echo '
    <div class="moduletable moduletable-account-balances">
    <div class="moduletable-header"><span class="glyphicon glyphicon-account-balances"></span>'.$market["Acronymn"].' Markets</div>
    <div class="account-balances-wrap" id="'.strtolower($market["Acronymn"]).'-markets">
    <ul class="nav nav-list">
    ';

   foreach ($tradepairs as $key => $tradepair){
     $coinA = strstr($tradepair["Pair"], "/", true);
     $coinB = substr(strstr($tradepair["Pair"], "/"), 1);
     if($coinA == $market["Acronymn"] || $coinB == $market["Acronymn"]){
        if($coinB == $market["Acronymn"]){
           echo "<li><a href = '/users/trades.php?market=".strtolower($coinA)."-".strtolower($coinB)."'>";
          echo $tradepair["Pair"];
        }
        else{
          echo "<li><a href = '/users/trades.php?market=".strtolower($coinB)."-".strtolower($coinA)."'>";
          echo $coinB."/".$coinA;
        }
        $ipair = $tradepair["Pair"];
        $lasttrade = BaseDonnee::execQuery($bdd, "SELECT Price FROM Trade_History WHERE Market='$ipair' ORDER BY Timestamp DESC LIMIT 1")[0]["Price"];
        echo"<span class = 'pull-right glyphicon glyphicon-arrownone'></span>";
        echo '<span class="status pull-right" id="market_price_1">'.number_format($lasttrade, 8, '.', '').'</span></a></li>';
        unset($tradepairs[$key]);
     }
   }
   echo ' </ul> </div></div><hr class="separator">';
 }
 
 ?>

 <div class="clearfix"></div>

 </div>

