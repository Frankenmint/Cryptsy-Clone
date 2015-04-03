<?php

	// database settings
 	$db_user= 'root';
	$db_pass= 'IOJIOjoijipodfhzeoufhozeifh584848';
	$db_host='localhost';
	$db='crypto';
	$conn = mysql_connect($db_host, $db_user, $db_pass) or die(mysql_error());
	mysql_select_db($db) or die(mysql_error());
  //database settings END
  function randomFloat($min,$max) {
    return $min + mt_rand() / mt_getrandmax() * ($max - $min);
}
if(isset($_POST))
{
  $starttrade=$_POST['tradeid'];
  $random_time=time() - ($_POST['time'] * 60 * 60);
  $crtime= $random_time - (rand(1,10) *60);
  for($x=0;$x<$_POST['repeat'];$x++){
   $random_price=randomFloat($_POST['pr_low'], $_POST['pr_high']);
 $random_q=rand($_POST['q_min'],$_POST['q_max']);
 $strings = array(
    'BUY',
    'SELL',
);
$crtime= $crtime - (rand(1,10) *60);
$random_price=number_format($random_price,8) ;
  $starttrade=$starttrade+1;
$key = array_rand($strings);
$insert=mysql_query("INSERT INTO `Trade_History` (`Market`, `Type`, `Price`, `Quantity`, `Timestamp`, `trade_id`, `Buyer`, `Seller`)
VALUES ('".$_POST['market']."','".$strings[$key]."','".$random_price."','".$random_q."','".$crtime."','".$starttrade."', 'fake1', 'fake2')")or die (mysql_error());
 }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>
    Crypto Maniac - Trade History Generator
  </title>    

  <?php
  include_once($_SERVER['DOCUMENT_ROOT']."/includes/header.inc.php");
  ?>

  <!-- Fixed navbar -->
  <?php
//Affiche une barre différente si l'user est connecté
include($_SERVER['DOCUMENT_ROOT']."/includes/member_navbar.inc.php");?>
 
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
			<span class="glyphicon glyphicon-transfer"></span> Trade History Generator
			<a href="./addwallet.php">Add Wallet</a>
			<a href="./activewallet.php">Active Wallet</a>
			<a href="./activemarket.php">Active Market</a>
			<a href="./activepair.php">Active Pair</a>
			<a href="./userstats.php">Users Stats</a>
			<a href="./earning.php">Earning</a>
			<a href="./generator.php">Trade Generator</a>
			
             </div> 
            <div class="panel-body">
              
              <div class="row">
                <div class="col-xs-6">
                <table>

<form method="post">
<table>

<tr>
<td><input name='market'  />Market</td>
<td><input name='pr_low' />Pricelow</td>
<td><input name='pr_high' />PriceHigh</td>
<td><input name='q_min' />Quanmin</td>
</tr>
<tr>
<td><input name='q_max' />Quanmax</td>
<td><input name='tradeid'/>Trade_id</td>
<td><input name='time' />Pastime(h)</td>
<td><input name='repeat' />Repeat</td>


</tr>
<tr>
<td><input type="submit" /></td>
</tr>
</table>
</form>

 </table>
           </div>
           <div class="col-xs-6">
                

                
           </div>
         </div>

         </div>
       </div>  <!--/panel list-->



</div><!--/end working-contents--> 
</div><!--/content-->


</div><!--/row/maincontents-->


</div> <!-- /container -->

<div class="clearfix"></div>

	<!-- Footer Start -->
    <?php
    include($_SERVER['DOCUMENT_ROOT']."/includes/footer.inc.php");
    ?>
    <!-- Footer end -->





</body>
<!-- web9 -->
</html>