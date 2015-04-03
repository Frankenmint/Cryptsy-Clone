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
    Crypto Maniac - Add Wallet
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
		 
		 
<div class="panel panel-default panel-change-contact-info">
  <div class="panel-heading"> 
         <span class="glyphicon glyphicon-transfer"></span> Add a Wallet
  		   	<a href="./admin.php">Admin Panel</a>
			<a href="./activewallet.php">Active Wallet</a>
			<a href="./activemarket.php">Active Market</a>
			<a href="./activepair.php">Active Pair</a>
			<a href="./earning.php">Earning</a>
			<a href="./userstats.php">User Stats</a>
    
  </div> 
  <div class="panel-body">
    <form action="./verif_admin.php" method = "POST">
      <table>
       <tr>
        <td> <label> Name</label></td>
        <td><input  name="addName" class="form-control" type="text" placeholder="Insert currency's name"/></td>
        <td>  <label>&nbsp;&nbsp;Acronymn</label> </td>
        <td><input  name="addAcronymn" class="form-control" type="text" placeholder="Insert its acronymn"/></td>
      </tr>
      <tr>
        <td>  <label>IP</label> </td>
        <td><input  name="addIP" class="form-control" type="text" placeholder="Insert its IP"/></td>
        <td>  <label>&nbsp;&nbsp;Port</label> </td>
        <td><input  name="addPort" class="form-control" type="text" placeholder="Insert its port"/></td>
      </tr>
      <tr>
       <td>  <label>Username</label> </td>
       <td><input  name="addUsername" class="form-control" type="text" placeholder="Insert its username"/></td>
       <td>  <label>&nbsp;&nbsp;Password</label> </td>
       <td><input  name="addPassword" class="form-control" type="text" placeholder="Insert its password"/></td>
     </tr>
     <tr>
       <td>  <label>Withdrawal Fee</label> </td>
       <td><input  name="addWithdrawalFee" class="form-control" type="text" placeholder="Insert its withdrawal fee amount"/></td>
       <td>  <label>&nbsp;&nbsp;Tx Fee</label> </td>
       <td><input  name="addTxFee" class="form-control" type="text" placeholder="Insert Tx fee for miners"/></td>
     </tr>

     <p class="text-danger"><?php echo $_SESSION["addErreur"] ?></p>

   </table>
   <input  class="btn btn-default btn-success" type="submit" value="Add this wallet"/>
 </form>
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
