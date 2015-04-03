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
    Crypto Maniac - Active Market
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



      <div class="working-contents">





        <div class="page page-settings" style="float:left;">

          <br>


<div class="panel panel-default panel-market-display-settings">
  <div class="panel-heading"> 
			<a href="./addwallet.php">Add Wallet</a>
			<a href="./activewallet.php">Active Wallet</a>
			<a href="./activemarket.php">Active Market</a>
			<a href="./activepair.php">Active Pair</a>
			<a href="./userstats.php">Users Stats</a>
			<a href="./adminvote.php">Admin Votes</a>
			<a href="./earning.php">Earning</a>
			<a href="./generator.php">Trade Gen</a>
   
  </div> 

  <div class="panel-body">  
    <h4>Active Markets</h4>
    <p class="descr">Uncheck the markets that you would not like like displayed on the Cryptsy website.</p>
    <form action="./verif_admin.php" method = "POST">
      <input type="hidden" name='setMarkets' />
      <?php
      $sql = BaseDonnee::execQuery($bdd, "SELECT * FROM Wallets");
      $marketActifs = array();
      foreach ($sql as $wallet) {
        echo '<label class="checkbox-inline" style="width:115px;">
        <input type="checkbox" name="'.$wallet["Name"].'"  value="1" ';
        if($wallet["Market"] == '1'){
          echo 'checked/>';
          $marketActifs[] = $wallet["Acronymn"]; 
        }else {
          echo '/>';
        }
        echo "<span>".$wallet["Acronymn"]."</span></label>";
      }
      ?>   
    </br><input  class="btn btn-default btn-success" type="submit" value="Set actif markets"/>
  </form>     
</div>
</div>



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
        <p>Market volatility, volume, and system availability may delay account access and trade executions.  Crypto Maniac Inc. FinCEN BSA ID: 31000027060819<br>This is not an offer or solicitation in any jurisdiction where we are not authorized to do business. Crypto Maniac is a trademark owned by Crypto Maniac, Inc.</p>
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
  FreshWidget.init("", {"queryString": "", "buttonText": "Support", "buttonColor": "white", "buttonBg": "#428bca", "alignment": "4", "offset": "230px", "url": "https://cryptsy.freshdesk.com", "assetUrl": "https://s3.amazonaws.com/assets.freshdesk.com/widget"} );
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
