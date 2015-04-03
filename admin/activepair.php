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
    Crypto Maniac - Active Pair
  </title>    
  <?php
  include_once($_SERVER['DOCUMENT_ROOT']."/includes/header.inc.php");
  ?>
  </head>
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
  			<a href="./admin.php">Admin Panel</a>
  			<a href="./addwallet.php">Add Wallet</a>
			<a href="./activewallet.php">Active Wallet</a>
			<a href="./activemarket.php">Active Market</a>

  <div class="panel-body">
       <div class="panel panel-default panel-change-contact-info">
         <div class="panel-heading"> 
		 <span class="glyphicon glyphicon-transfer"></span>
          
        </div> 
    <div class="panel-body">   
      <p class="descr">Uncheck the trade pairs that you would not like like displayed on the website.</p>
      <form action="./verif_admin.php" method = "post">
        <input type="hidden" name='setPairs' />
         <div class="tablewrap" style="height:float;">
        <table >
          <tr>
            <td><h5><strong> &nbsp;&nbsp;Trade couple</strong></h5> </td>
            <td><h5><strong>&nbsp;&nbsp;Trade Fees (%) </strong></h5></td>
          </tr>
          <?php
        //On genere tous les couples possible de currencies actives
        //Il faut aussi desactiver les pairs qui ne sont plus dans la liste "marketActifs".
          $sql= BaseDonnee::execQuery($bdd, "SELECT * FROM Markets ORDER BY Pair ASC");
        //Si le couple n'est pas dans la base de donnée, on l'ajoute et on le met inactif
          $k = 0;
          $back = "Lavender";
          foreach ($sql as $market) {
            $pair = $market["Pair"];
            echo '<tr style = "background-color:'.$back.'" ';
            echo'><td><label class="checkbox-inline">
            <input type="checkbox" name="'.$pair.'"  value="1"';
            if($market["disabled"] == '0') echo " checked />";
            else echo "/>";
            echo "<span>".$pair."</span></label></td>";
            echo "<td><input class='form-control' name = fee".$pair." type='text' value='".$market["Fee"]."'/></td></tr>";
            if($k == 2){
             $back = ($back == "Lavender") ? "White" : "Lavender";
             $k = 0;
            }else{
              $k++;
            }
          }

          ?>   
        </table>
        </div>
      </br><input  class="btn btn-default btn-success" type="submit" value="Set actif trades"/>
    </form>
  
  </div>
</div>
</div>

</div><!--/end working-contents--> 
</div><!--/content-->


</div><!--/row/maincontents-->


</div> <!-- /container -->

<div class="clearfix"></div>
<!-- Footer Start -->
<?php   include_once($_SERVER['DOCUMENT_ROOT']."/includes/footer.inc.php");   ?>
<!-- Footer end -->

</body>
<!-- web9 -->
</html>

<?php 
  //Par sécurité on supprime directement les variable session quand on en a plus besoin
unset($_SESSION["errors"]); 
unset($_SESSION["updated"]); 
unset($_SESSION["addErreur"]);
?> 
