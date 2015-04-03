<?php
//Page accessible seulement par l'administrateur
session_start();
session_regenerate_id();
require_once($_SERVER['DOCUMENT_ROOT']."/classes/BaseDonnee.class.php");
$bdd = BaseDonnee::connexion();
//Si l'utilisateur qui accède à la page n'a pas le pseudo de l'administrateur dans sa variable session, il voit une page 404.
if($_SESSION["pseudo"] != "admin"){
	header('HTTP/1.0 404 Not Found');
	exit("<h1>404 Not Found</h1>\nThe page that you have requested could not be found.");
}
BaseDonnee::updateLastTimeSeen($bdd, "admin");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>
    Crypto Maniac - Earning
  </title>    

  <?php
  include_once($_SERVER['DOCUMENT_ROOT']."/includes/header.inc.php");
  ?>

  <!-- Fixed navbar -->
  <?php

      //Affiche une barre différente si l'user est connecté
  if(!isset($_SESSION["pseudo"])){
   include($_SERVER['DOCUMENT_ROOT']."/includes/guest_navbar.inc.php");
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


<!--start working-contents--> 
      <div class="working-contents">
        <div class="page page-settings" style="float:left;">

          <br>

          <div class="panel panel-default panel-change-contact-info">
		  
            <div class="panel-heading"> 
			<span class="glyphicon glyphicon-transfer"></span> Earning
			<a href="./addwallet.php">Add Wallet</a>
			<a href="./activewallet.php">Active Wallet</a>
			<a href="./activemarket.php">Active Market</a>
			<a href="./activepair.php">Active Pair</a>
            </div> 
			 
<div class="panel-body">
         <table class="table table-striped table-bordered table-condensed">
           <tbody><tr>
            <td> <label> Name</label></td>
            <td>  <label>Acronymn</label> </td>
            <td style="width: 120px;"><label>Volume</label></td>
            <td style="width: 200px;">  <label>Earning Fee</label> </td>
            <td style="width: 200px;">&nbsp;</td>
          </tr>
          
            <input type="hidden" name="setWallets">
            <tr class="success">
			<td> <h5> Bitcoin</h5> </td><td> <h5> BTC/LTC</h5> </td><td>
			<?php 
				 //Pierre Test Balance Start
				 $adminfee = BaseDonnee::execQuery($bdd,"SELECT  Quantity,SUM(Quantity)/ 003 FROM Trade_History WHERE Market = 'BTC/LTC'")[0];
			     echo' '.$adminfee["Amount"].' ';  
			     //Pierre Test Balance Start ?></td>
				 <td>
			<input type="text" value="0" name="txFee-BTC" class="form-control"></td><td>&nbsp;</td></tr>
			<tr class="success">
			<td> <h5> Litecoin</h5> </td><td> <h5> LTC</h5> </td><td>
			<input type="text" value="0.003" name="Fee-LTC" class="form-control"></td><td>
			<input type="text" value="0" name="txFee-LTC" class="form-control"></td><td>&nbsp;</td></tr>
			<tr class="success"><td> <h5> Dogecoin</h5> </td><td> <h5> DOGE</h5> </td><td><input type="text" value="0.003" name="Fee-DOGE" class="form-control"></td><td><input type="text" value="0" name="txFee-DOGE" class="form-control"></td><td>&nbsp;</td></tr>
			<tr class="success"><td> <h5> 42</h5> </td><td> <h5> 42</h5> </td><td><input type="text" value="0.003" name="Fee-42" class="form-control"></td><td><input type="text" value="0.00000001" name="txFee-42" class="form-control"></td><td>&nbsp;</td></tr><tr class="success"><td> <h5> Alphacoin</h5> </td><td> <h5> ALF</h5> </td><td><input type="text" value="0.003" name="Fee-ALF" class="form-control"></td><td><input type="text" value="0" name="txFee-ALF" class="form-control"></td><td>&nbsp;</td></tr><tr class="success"><td> <h5> Americancoin</h5> </td><td> <h5> AMC</h5> </td><td><input type="text" value="0.003" name="Fee-AMC" class="form-control"></td><td><input type="text" value="0" name="txFee-AMC" class="form-control"></td><td>&nbsp;</td></tr><tr class="success"><td> <h5> Anoncoin</h5> </td><td> <h5> ANC</h5> </td><td><input type="text" value="0.003" name="Fee-ANC" class="form-control"></td><td><input type="text" value="0" name="txFee-ANC" class="form-control"></td><td>&nbsp;</td></tr><tr class="success"><td> <h5> Argentum</h5> </td><td> <h5> ARG</h5> </td><td><input type="text" value="0.003" name="Fee-ARG" class="form-control"></td><td><input type="text" value="0" name="txFee-ARG" class="form-control"></td><td>&nbsp;</td></tr><tr class="success"><td> <h5> Auroracoin</h5> </td><td> <h5> AUR</h5> </td><td><input type="text" value="0.003" name="Fee-AUR" class="form-control"></td><td><input type="text" value="0" name="txFee-AUR" class="form-control"></td><td>&nbsp;</td></tr><tr class="success"><td> <h5> Battlecoin</h5> </td><td> <h5> BCX</h5> </td><td><input type="text" value="0.003" name="Fee-BCX" class="form-control"></td><td><input type="text" value="0.001" name="txFee-BCX" class="form-control"></td><td>&nbsp;</td></tr><tr class="success"><td> <h5> Betacoin</h5> </td><td> <h5> BET</h5> </td><td><input type="text" value="0.003" name="Fee-BET" class="form-control"></td><td><input type="text" value="0" name="txFee-BET" class="form-control"></td><td>&nbsp;</td></tr><tr class="success"><td> <h5> Bbqcoin</h5> </td><td> <h5> BQC</h5> </td><td><input type="text" value="0.003" name="Fee-BQC" class="form-control"></td><td><input type="text" value="0" name="txFee-BQC" class="form-control"></td><td>&nbsp;</td></tr><tr class="success"><td> <h5> Bitbar</h5> </td><td> <h5> BTB</h5> </td><td><input type="text" value="0.003" name="Fee-BTB" class="form-control"></td><td><input type="text" value="0.0001" name="txFee-BTB" class="form-control"></td><td>&nbsp;</td></tr><tr class="success"><td> <h5> Bytecoin</h5> </td><td> <h5> BTE</h5> </td><td><input type="text" value="0.003" name="Fee-BTE" class="form-control"></td><td><input type="text" value="0" name="txFee-BTE" class="form-control"></td><td>&nbsp;</td></tr><tr class="success"><td> <h5> Bitgem</h5> </td><td> <h5> BTG</h5> </td><td><input type="text" value="0.003" name="Fee-BTG" class="form-control"></td><td><input type="text" value="0.001" name="txFee-BTG" class="form-control"></td><td>&nbsp;</td></tr><tr class="success"><td> <h5> Cryptobuck</h5> </td><td> <h5> BUK</h5> </td><td><input type="text" value="0.003" name="Fee-BUK" class="form-control"></td><td><input type="text" value="0.01" name="txFee-BUK" class="form-control"></td><td>&nbsp;</td></tr><tr class="success"><td> <h5> Cachecoin</h5> </td><td> <h5> CACH</h5> </td><td><input type="text" value="0.003" name="Fee-CACH" class="form-control"></td><td><input type="text" value="0.01" name="txFee-CACH" class="form-control"></td><td>&nbsp;</td></tr><tr class="danger"><td> <h5> Cashcoin</h5> </td><td> <h5> CASH</h5> </td><td><input type="text" value="0.003" name="Fee-CASH" class="form-control"></td><td><input type="text" value="0.001" name="txFee-CASH" class="form-control"></td><td>&nbsp;</td></tr><tr class="success"><td> <h5> Bottlecaps</h5> </td><td> <h5> CAP</h5> </td><td><input type="text" value="0.003" name="Fee-CAP" class="form-control"></td><td><input type="text" value="0.001" name="txFee-CAP" class="form-control"></td><td>&nbsp;</td></tr><tr class="success"><td> <h5> Catcoin</h5> </td><td> <h5> CAT</h5> </td><td><input type="text" value="0.003" name="Fee-CAT" class="form-control"></td><td><input type="text" value="0" name="txFee-CAT" class="form-control"></td><td>&nbsp;</td></tr><tr class="success"><td> <h5> Cryptogenicbullion</h5> </td><td> <h5> CGB</h5> </td><td><input type="text" value="0.003" name="Fee-CGB" class="form-control"></td><td><input type="text" value="0.001" name="txFee-CGB" class="form-control"></td><td>&nbsp;</td></tr><tr class="success"><td> <h5> Chncoin</h5> </td><td> <h5> CHN</h5> </td><td><input type="text" value="0.003" name="Fee-CHN" class="form-control"></td><td><input type="text" value="0" name="txFee-CHN" class="form-control"></td><td>&nbsp;</td></tr><tr class="success"><td> <h5> Craftcoin</h5> </td><td> <h5> CRC</h5> </td><td><input type="text" value="0.003" name="Fee-CRC" class="form-control"></td><td><input type="text" value="0" name="txFee-CRC" class="form-control"></td><td>&nbsp;</td></tr><tr class="success"><td> <h5> Casinocoin</h5> </td><td> <h5> CSC</h5> </td><td><input type="text" value="0.003" name="Fee-CSC" class="form-control"></td><td><input type="text" value="0" name="txFee-CSC" class="form-control"></td><td>&nbsp;</td></tr><tr class="success"><td> <h5> Emark</h5> </td><td> <h5> DEM</h5> </td><td><input type="text" value="0.003" name="Fee-DEM" class="form-control"></td><td><input type="text" value="0.001" name="txFee-DEM" class="form-control"></td><td>&nbsp;</td></tr><tr class="success"><td> <h5> Digibyte</h5> </td><td> <h5> DGB</h5> </td><td><input type="text" value="0.003" name="Fee-DGB" class="form-control"></td><td><input type="text" value="0" name="txFee-DGB" class="form-control"></td><td>&nbsp;</td></tr><tr class="success"><td> <h5> Earthcoin</h5> </td><td> <h5> EAC</h5> </td><td><input type="text" value="0.003" name="Fee-EAC" class="form-control"></td><td><input type="text" value="0" name="txFee-EAC" class="form-control"></td><td>&nbsp;</td></tr><tr class="danger"><td> <h5> Darkcoin</h5> </td><td> <h5> DRK</h5> </td><td><input type="text" value="0.003" name="Fee-DRK" class="form-control"></td><td><input type="text" value="0" name="txFee-DRK" class="form-control"></td><td>&nbsp;</td></tr><tr class="success"><td> <h5> Diamond</h5> </td><td> <h5> DMD</h5> </td><td><input type="text" value="0.003" name="Fee-DMD" class="form-control"></td><td><input type="text" value="0.001" name="txFee-DMD" class="form-control"></td><td>&nbsp;</td></tr><tr class="success"><td> <h5> Elacoin</h5> </td><td> <h5> ELC</h5> </td><td><input type="text" value="0.003" name="Fee-ELC" class="form-control"></td><td><input type="text" value="0" name="txFee-ELC" class="form-control"></td><td>&nbsp;</td></tr><tr class="success"><td> <h5> Emerald</h5> </td><td> <h5> EMD</h5> </td><td><input type="text" value="0.003" name="Fee-EMD" class="form-control"></td><td><input type="text" value="0" name="txFee-EMD" class="form-control"></td><td>&nbsp;</td></tr><tr class="success"><td> <h5> Ezcoin</h5> </td><td> <h5> EZC</h5> </td><td><input type="text" value="0.003" name="Fee-EZC" class="form-control"></td><td><input type="text" value="0" name="txFee-EZC" class="form-control"></td><td>&nbsp;</td></tr><tr class="success"><td> <h5> Fireflycoin</h5> </td><td> <h5> FFC</h5> </td><td><input type="text" value="0.003" name="Fee-FFC" class="form-control"></td><td><input type="text" value="0" name="txFee-FFC" class="form-control"></td><td>&nbsp;</td></tr><tr class="success"><td> <h5> Freicoin</h5> </td><td> <h5> FRC</h5> </td><td><input type="text" value="0.003" name="Fee-FRC" class="form-control"></td><td><input type="text" value="0" name="txFee-FRC" class="form-control"></td><td>&nbsp;</td></tr><tr class="success"><td> <h5> Franko</h5> </td><td> <h5> FRK</h5> </td><td><input type="text" value="0.003" name="Fee-FRK" class="form-control"></td><td><input type="text" value="0" name="txFee-FRK" class="form-control"></td><td>&nbsp;</td></tr><tr class="danger"><td> <h5> Fastcoin</h5> </td><td> <h5> FST</h5> </td><td><input type="text" value="0.003" name="Fee-FST" class="form-control"></td><td><input type="text" value="0" name="txFee-FST" class="form-control"></td><td>&nbsp;</td></tr><tr class="success"><td> <h5> Feathercoin</h5> </td><td> <h5> FTC</h5> </td><td><input type="text" value="0.003" name="Fee-FTC" class="form-control"></td><td><input type="text" value="0" name="txFee-FTC" class="form-control"></td><td>&nbsp;</td></tr><tr class="success"><td> <h5> Grandcoin</h5> </td><td> <h5> GDC</h5> </td><td><input type="text" value="0.003" name="Fee-GDC" class="form-control"></td><td><input type="text" value="0" name="txFee-GDC" class="form-control"></td><td>&nbsp;</td></tr>      </tbody></table>
      
    
  </div>
       </div>  <!--/panel list-->
	   



</div><!--/end working-contents--> 
</div><!--/content-->


</div><!--/row/maincontents-->


</div> <!-- /container -->

<div class="clearfix"></div>
<footer>
  <div class="container">
    <div class="row">
      <div class="col-xs-6 copyrights">
        <p>&copy; 2014 Crypto Maniac -  All Rights Reserved</p>
      </div>
      <div class="col-xs-6 nav">
        <ul class="nav nav-pills pull-right"> 
          <li><a href="/pages/terms" title="Terms">Terms</a></li>
          <li><a href="/pages/privacy" title="Privacy">Privacy</a></li>
          <li><a href="http://cryptomaniac.freshdesk.com/support/home" target=_new title="Support">Support</a></li>
          <li><a href="#" title="API">API Soon</a></li>
          <li><a href="/pages/security" title="About">Security</a></li>
          <li><a href="/pages/about" title="About">About</a></li>

        </ul>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12 notice">
        <p>Market volatility, volume, and system availability may delay account access and trade executions.  Crypto Maniac Inc.<br>This is not an offer or solicitation in any jurisdiction where we are not authorized to do business. Crypto Maniac is a trademark owned by Crypto Maniac, Inc.</p>
      </div>
    </div>
  </div>
</footer> 



<script type="text/javascript" src="/js/freshwidget.js"></script>
<style type="text/css" media="screen, projection">
@import url(/css/freshwidget.css); 
</style> 
<script type="text/javascript">
$(function() {
  FreshWidget.init("", {"queryString": "", "buttonText": "Support", "buttonColor": "white", "buttonBg": "#428bca", "alignment": "4", "offset": "230px", "url": "https://cryptomaniac.freshdesk.com", "assetUrl": "https://s3.amazonaws.com/assets.freshdesk.com/widget"} );
});
</script>


</body>
<!-- web9 -->
</html>

<?php 
  //Par sécurité on supprime directement les variable session quand on en a plus besoin
unset($_SESSION["errors"]); 
unset($_SESSION["updated"]); 
unset($_SESSION["addErreur"]);
?> 