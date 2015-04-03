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
         <span class="glyphicon glyphicon-transfer"></span>
  		   	<a href="./admin.php">Admin Panel</a>
			<a href="./activemarket.php">Active Market</a>
			<a href="./activepair.php">Active Pair</a>
			<a href="./earning.php">Earning</a>
			<a href="./userstats.php">User Stats</a>
    
  </div> 
  <div class="panel-body">
       <div class="panel panel-default panel-change-contact-info">
         <div class="panel-heading"> 
		 <span class="glyphicon glyphicon-transfer"></span> Active Wallet
          
        </div> 
        <div class="panel-body">
         <table class="table table-striped table-bordered table-condensed">
           <tr>
            <td > <label> Name</label></td>
            <td >  <label>Acronymn</label> </td>
            <td style="width: 120px;">  <label>Withdrawal Fee</label> </td>
            <td style="width: 200px;">  <label>Tx Fee</label> </td>
            <td style="width: 200px;">  <label>State</label> </td>
          </tr>
          <form action="./verif_admin.php" method = "POST">
            <input type="hidden" name='setWallets' />
            <?php
            $bdd = BaseDonnee::connexion();
            $lines = BaseDonnee::getWallets($bdd);
            foreach ($lines as $line) {
             echo('<tr ');
             if ($line["disabled"] == "0"){
              echo('class="success">');
            }else{
              echo('class="danger">');
            }
            echo("<td> <h5> ". $line["Name"] . "</h5> </td>");
            echo("<td> <h5> ". $line["Acronymn"] . "</h5> </td>");
            echo("<td><input class = 'form-control' name = 'Fee-".$line["Acronymn"]."' type = 'text' value = '".$line["Fee"]."'/></td>");
            echo("<td><input class = 'form-control' name = 'txFee-".$line["Acronymn"]."' type = 'text' value = '".$line["txFee"]."'/></td>");
            echo "<td>";
            echo "<select class='form-control' name='disabled-".$line["Acronymn"]."'>";
            echo "<option "; if($line["disabled"] == '1') echo "selected";
            echo "> Inactif </option>";
            echo "<option "; if($line["disabled"] == '0') echo "selected";
            echo "> Actif </option>";
            echo "</select>";
            echo "</td>";
          }
          echo('</tr>');
        ?>
      </table>
      <input  name = "updatewallet" class="btn btn-default btn-success" type="submit" value="Update"/>
    </form>
  </div>
</div>  <!--/panel list-->





</div><!--/end working-contents--> 
</div><!--/content-->


</div><!--/row/maincontents-->


</div> <!-- /container -->

<div class="clearfix"></div>
<?php   include_once($_SERVER['DOCUMENT_ROOT']."/includes/footer.inc.php");   ?>


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
