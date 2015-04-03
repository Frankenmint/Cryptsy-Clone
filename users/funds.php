<?php
session_start();
session_regenerate_id();
require_once($_SERVER['DOCUMENT_ROOT']."/classes/BaseDonnee.class.php");
$bdd = BaseDonnee::connexion();
include_once($_SERVER['DOCUMENT_ROOT']."/includes/verifications.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>
   Crypto Maniac - Account Balances</title>    
   <?php
   include_once($_SERVER['DOCUMENT_ROOT']."/includes/header.inc.php");
   ?>
 </head>
 <body>
  <!-- Fixed navbar -->
  <?php
 //Affiche une barre différente si l'user est connecté
  if(!isset($_SESSION["pseudo"])){
    header("Location: /index.php");
    exit();
  }else{
   include($_SERVER['DOCUMENT_ROOT']."/includes/member_navbar.inc.php");
 }
 ?> 
 <div id="wrap" class="container ">
  <div class="row maincontents">
   <!-- Sidebar start -->
        <?php
        include($_SERVER['DOCUMENT_ROOT']."/includes/sidebar.inc.php");
        ?>
        <!-- Sidebar end -->
<!-- Content start -->
<div class="page" id="content" role="main">
  <div class="working-contents">
    <script>
$(document).ready(function(){
  $(".iframe").colorbox({iframe:true, width:"500", height:"450", scrolling: false, fastIframe:false });
  $(".iframe2").colorbox({iframe:true, width:"500", height:"450", scrolling: false, fastIframe:false });
  $(".iframe3").colorbox({iframe:true, width:"500", height:"450", scrolling: false, fastIframe:false });
});
</script>
<div class="page page-settings">
<br>
  <div style='text-align:center;'>
    <p class="submit-holder">
      <button type="submit" onclick="location.href='./deposits.php?coin=all'" class="btn btn-default btn-success">View All Deposits</button>
      <button type="submit" onclick="location.href='./withdrawals.php?coin=all'" class="btn btn-default btn-success">View All Withdrawals</button>
	  
    </p>
  </div>
  <div class="panel panel-default panel-account-balances">
    <div class="panel-heading"> <span class="glyphicon glyphicon-triggers"></span> Account Balances  
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="skype:crypto-maniac?add"><img style="border:0;" src="/img/skype_icon_01.png" alt="Skype Support " width="51" height="30" align="right" >Skype Support</a>
</div> 
	
     <div class="panel-body" style="padding:0px;">
     <table cellpadding="0" cellspacing="0" width="100%" class="table table2 table-striped table-bal">
        <tr style="background: #dddddd">
         <th style="padding:3px;border-bottom:1px solid #000000; font-weight:bold;">Coin Name</th>
         <th style="padding:3px;border-bottom:1px solid #000000; font-weight:bold;">Code</th>
         <th style="padding:3px;border-bottom:1px solid #000000; font-weight:bold;">Available Balance</th>
         <th style="padding:3px;border-bottom:1px solid #000000; font-weight:bold;">Pending Deposit</th>
         <th style="padding:3px;border-bottom:1px solid #000000; font-weight:bold;">Held for Orders</th>
         <th style="padding:3px;border-bottom:1px solid #000000; font-weight:bold;">Actions</th>
       </tr>
       <?php
       $username = $_SESSION["pseudo"];
       $approximation = 0.0; // approximation de la valeur du wallet
       $sql = BaseDonnee::execQuery($bdd, "SELECT * FROM Wallets WHERE disabled='0' ORDER BY Name ASC");
       foreach ($sql as $row){
        $coin = $row["Id"];
        $result = BaseDonnee::execQuery($bdd, "SELECT * FROM balances WHERE Account='$username' AND `Wallet_ID` = '$coin'");   
        $helding  = floatval($result[0]["Helding"]);
        if($result[0]["Amount"] == NULL) {
          $amount = 0;
          $pending = 0;
        }else{
          $amount = floatval($result[0]["Amount"]) - $helding;
          if($amount < 0) $amount = 0.0;
        }
        $account = $username;
        $acronymn = $row["Acronymn"];
        $market_id = $row["Id"];
        echo'
        <tr style="height:32px;">
        <td valign="middle" style="height:32px; padding:3px;border-bottom:1px solid #CCCCCC;">
        <a name="'.$row["Name"].'"></a>
        <span style="padding:2px; display: inline-block;"><strong>'.$row["Name"].'</strong></span>
        </td>
        <td valign="middle" style="height:32px; padding:3px;border-bottom:1px solid #CCCCCC;">
        <span style="padding:2px; display: inline-block;"><strong>'.$row["Acronymn"].'</strong></span>
        </td>
        <td valign="middle" style="height:32px; padding:3px;border-bottom:1px solid #CCCCCC;">
        <span style="padding:2px; display: inline-block;"><strong>'.sprintf("%.8f",$amount).'</strong></span>
        </td>
        <td valign="middle" style="height:32px; padding:3px;border-bottom:1px solid #CCCCCC;">
        <span style="padding:2px; display: inline-block;"><strong>'.sprintf("%.8f",$pending).'</strong></span>
        </td>
        <td valign="middle" style="height:32px; padding:3px;border-bottom:1px solid #CCCCCC;">
        <span style="padding:2px; display: inline-block;"><strong>'.sprintf("%.8f",$helding).'</strong></span>
        </td>
        <td style="height:32px; padding:0px;border-bottom:1px solid #CCCCCC; width:130px;">
        <ul class="menu">
        <li>
        <a class="btn btn-default btn-success" style="width:110px; margin:2px;" href="#">'.$row["Acronymn"].' Actions<span>&nbsp;</span></a>
        <ul>
        <li><a class="iframe3 cboxElement" href="/'.strtolower($row["Acronymn"]).'/makedeposit.php">Deposit '.$row["Acronymn"].'</a></li>
        <li><a class="iframe cboxElement" href="/'.strtolower($row["Acronymn"]).'/makewithdrawal.php">Withdraw '.$row["Acronymn"].'</a></li>
        <li><a href="./deposits.php?coin='.$row["Acronymn"].'">View&nbsp;'.$row["Acronymn"].'&nbsp;Deposits</a></li>
        <li><a href="./withdrawals.php?coin='.$row["Acronymn"].'">View&nbsp;'.$row["Acronymn"].'&nbsp;Withdrawals</a></li>
        </ul>
        </li>
        </ul>
        </td>
        </tr>';

        //Calcul de l'approximation de la valeur du wallet en BTC
      if($acronymn == "BTC"){
        $approximation += $amount;
        continue;
      }

      $approxPair = $acronymn.'/BTC';
      $lastprice = BaseDonnee::execQuery($bdd, "SELECT Price FROM Trade_History WHERE Market='$approxPair' ORDER BY Timestamp DESC LIMIT 1")[0]["Price"];
      $approximation += (floatval($lastprice) * $amount); 
      }


      ?>

    </table>
 <br>
    <center>
      <span style="font-size:18px;">Estimated Portfolio Value:  <b><?php echo number_format($approximation, 8); ?> BTC</b></span>
      <br>(Based on current market values - Does not include pending deposits)
    </center>
    <br>
    <span class="clearFix">&nbsp;</span>
  </div><!-- end of div.box-container -->
</div><!-- end of div.box -->
<script type="text/javascript">
$(document).ready(function() {
  $('.menu').dropit();
});
</script>
<div class="clearfix"></div>
</div><!--/end working-contents--> 
</div><!--/content-->
</div><!--/row/maincontents-->
</div> <!-- /container -->
<div class="clearfix"></div>

<div id="chat_div"></div>
<!-- Footer Start --><?php   include($_SERVER['DOCUMENT_ROOT']."/includes/footer.inc.php");   ?><!-- Footer end -->

<script>$('.dropdown-toggle').dropdown();</script>
<div id="pseudo" style="display:none"><?php echo $_SESSION["pseudo"]; ?></div>
<!-- CHATBOX -->
<script type="text/javascript" src="/js/myChatbox.js?rev=<?php echo time(); ?>"></script>

<!-- VIEWNOTIFS -->
<?php   include($_SERVER['DOCUMENT_ROOT']."/includes/viewNotif.inc.php");   ?>
 
<script type="text/javascript">$('.dropdown-toggle').dropdown();</script> 
</body>
<!-- web7 -->
</html>