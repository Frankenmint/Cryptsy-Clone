<?php
session_start();
session_regenerate_id();
require_once($_SERVER['DOCUMENT_ROOT']."/classes/BaseDonnee.class.php");
$bdd = BaseDonnee::connexion();
include_once($_SERVER['DOCUMENT_ROOT']."/includes/verifications.php");
//Verification variable get
$test = $_GET["coin"];

//Test si la variable get est bien composé de seulement des caracteres
if(!ctype_alpha($test)){
  header('HTTP/1.0 404 Not Found');
  exit("<h1>404 Not Found</h1>\nThe page that you have requested could not be found.");
}

$coin = strtoupper($test);
$verifcoin = BaseDonnee::execQuery($bdd, "SELECT * FROM Wallets WHERE Acronymn = '$coin'");
if(empty($verifcoin) && $coin != "ALL"){
  header('HTTP/1.0 404 Not Found');
  exit("<h1>404 Not Found</h1>\nThe page that you have requested could not be found.");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>
   Crypto Maniac - <?php echo $coin;?> Deposits</title>    

   <?php
   include_once($_SERVER['DOCUMENT_ROOT']."/includes/header.inc.php");
   ?>

 </head>

 <body>

  <!-- Fixed navbar -->
  <?php

      //Affiche une barre différente si l'user est connecté
  if(!isset($_SESSION["pseudo"])){
    header("Location: /demarque/index.php");
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
       
        <div class="panel panel-default panel-trade-list">
          

          
          
          
          <div class="page page-settings">
            <br>
            <div style='text-align:center;'>
              <p class="submit-holder">
                <button type="submit" onclick="location.href='./deposits.php?coin=all'" class="btn btn-default btn-success">View All Deposits</button>
                <button type="submit" onclick="location.href='./withdrawals.php?coin=all'" class="btn btn-default btn-success">View All Withdrawals</button>
                
              </p>
            </div>
            <div class="panel panel-default panel-account-balances">
              <div class="panel-heading"> <span class="glyphicon glyphicon-triggers"></span> 
                <?php
                if($coin == "ALL"){
                  echo 'All Deposits';
                }else{
                  echo "Your ".$coin." Deposits";
                }   
                ?> 
                &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="skype:crypto-maniac?add"><img style="border:0;" src="/img/skype_icon_01.png" alt="Skype Support " width="51" height="30" align="right" >Skype Support</a>
                
              </div> 
              
              
              
              
              
              
              

              <div class="tablewrap"  id="market-wrap" style="max-height:500px; overflow:auto;">
                <form action="./verif_trades.php" method="POST">
                  <input type=hidden name="cancelorder"/>
                  <?php
                  $username = $_SESSION["pseudo"];
                  if($coin == "ALL"){
                    $deposits = BaseDonnee::execQuery($bdd, "SELECT * FROM deposits WHERE Account = '$username' ORDER BY Timestamp DESC");
                  }else{
                    $deposits = BaseDonnee::execQuery($bdd, "SELECT * FROM deposits WHERE Account = '$username' AND Coin = '$coin'");
                  }
                  echo('
                    <table cellpadding="0" cellspacing="0" border="0" class="table table2 table-striped" id="userorderslist">
                    <thead>
                    <tr>
                    <th>Deposit Date</th>');
                  if($coin == "ALL"){
                    echo '<th>Coin</th>';
                  }
                  echo('
                    <th>Amount</th>
                    <th>Transaction ID</th>
                    <th>Confirmations</th>
                    </tr></thead><tbody>
                    ');
                  foreach ($deposits as $deposit) {
                    echo '<tr>';
                    echo '<td>'.date('m/d H:i:s',$deposit["Timestamp"]).'</td>';
                    if($coin == "ALL"){
                      echo '<td>'.$deposit["Coin"].'</td>';
                    }                
                    echo '<td>'.$deposit["Amount"].'</td>';
                    echo '<td>'.$deposit["Transaction_Id"].'</td>';
                    echo '<td>'.$deposit["Confirmations"].'</td>';
                    echo '</tr>';
                  }
                  ?>
                </tbody> 
              </table>
            </form>
          </div>
        </div><!--/panel charts-->

        <div class="box">      
          <div class="box-container">
            <div id="news-list">

              <style type="text/css">
              #twitter-widget-0{width:751px;}
              </style>
              <a class="twitter-timeline" width="720" href="https://twitter.com/_cryptomaniac"  data-widget-id="423246077890805760">Tweets by @_cryptomaniac</a>
              <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>


            </div>
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
