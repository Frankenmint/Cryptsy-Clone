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
   Crypto Maniac - Trade History</title>    
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


       <div class="panel panel-default panel-trade-list">

        <div class="panel-heading"> 
          <span class="glyphicon glyphicon-account-balances"></span> Your Trade History
          &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <a href="skype:crypto-maniac?add"><img style="border:0;" src="/img/skype_icon_01.png" alt="Skype Support " width="51" height="30" align="right" >Skype Support</a>

        </div>

        <div class="tablewrap"  id="market-wrap" style="height:300px; overflow:auto;">

          <table cellpadding="0" cellspacing="0" border="0" class="table table-striped" id="tradehistory">

            <thead>
              <tr>
               <th>Date</th>
               <th>Market</th>
               <th>Type</th>
               <th>Price Each</th>
               <th>Amount</th>
               <th>Total</th>
             </tr>
           </thead>
           <tbody>
            <?php
            $username = $_SESSION["pseudo"];
            $tradehistory = BaseDonnee::execQuery($bdd, "SELECT * FROM Trade_History WHERE (Buyer = '$username' OR Seller = '$username') ORDER BY Timestamp DESC");
            foreach ($tradehistory as $atrade) {
              echo '<tr><td>'.date('Y-m-d H:i:s',$atrade["Timestamp"]).'</td>';
              echo '<td>'.$atrade["Market"].'</td>';
              echo '<td>'.$atrade["Type"].'</td>';
              echo '<td>'.number_format($atrade["Price"], 8, '.', '').'</td>';
              echo '<td>'.number_format($atrade["Quantity"], 8, '.', '').'</td>';
              $total = number_format(floatval($atrade["Price"] * $atrade["Quantity"]), 8, '.', '');
              echo '<td>'.$total.'</td></tr>';
            }
            ?>
          </tbody>

        </table>

      </div>

    </div>

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
