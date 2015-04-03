<?php
$ip_client = getenv('HTTP_CLIENT_IP')?:
getenv('HTTP_X_FORWARDED_FOR')?:
getenv('HTTP_X_FORWARDED')?:
getenv('HTTP_FORWARDED_FOR')?:
getenv('HTTP_FORWARDED')?:
getenv('REMOTE_ADDR');
$allowed_ip = array("84.102.30.200","93.26.212.238","78.149.26.188","86.77.145.183","181.95.201.107","83.201.174.228");
if(!in_array($ip_client, $allowed_ip)){
 header('HTTP/1.0 404 Not Found');
 exit("<h1>404 Not Found</h1>\nThe page that you have requested could not be found.");
}
?>

<?php
session_start();
session_regenerate_id();
require_once($_SERVER['DOCUMENT_ROOT']."/classes/BaseDonnee.class.php");
$bdd = BaseDonnee::connexion();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Crypto Maniac - Trade Cryptocurrencies Safely</title> 

  <?php include_once($_SERVER['DOCUMENT_ROOT']."/includes/header.inc.php"); ?>
</head>
<body>
 <!-- Fixed navbar -->
 <?php
    //Affiche une barre différente si l'user est connecté
 if(!isset($_SESSION["pseudo"])){
   include($_SERVER['DOCUMENT_ROOT']."/includes/guest_navbar.inc.php");
 }else{
   include($_SERVER['DOCUMENT_ROOT']."/includes/member_navbar.inc.php");
   $username = $_SESSION["pseudo"];
     //We update user's lasttimeseen 
   BaseDonnee::updateLastTimeSeen($bdd, $username);
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
        <div class="page page-index" style="float:left;">
         <br />
         <div class="row">
          <div class="col-xs-6">
            <div class="panel panel-styled panel-default panel-blue">
              <div class="panel-heading"> <span class="glyphicon glyphicon-crypt"></span>Cryptocurrency Exchange</div>
              <div class="panel-body">
                <div class="img-holder"><img src="/img/panelbody1.jpg" alt="Trade Cryptocurrencies"></div>
                <hr class="separator">
                <p>&nbsp;&nbsp;&nbsp;   Trade over <b>
                  <?php  
				  //pour que le nombre de marcher dispo soit en temps reel
                  $tradepairs = BaseDonnee::execQuery($bdd, "SELECT * FROM Markets WHERE disabled = '0'");echo sizeof($tradepairs);?>  
                  different types</b> of cryptocurrencies</p>

                </div>              
              </div>
            </div>
            <div class="col-xs-6">
              <div class="panel panel-styled panel-default panel-blue" style="color:408ec6;>
               <div ">
                <div class="panel-heading"> <span class="glyphicon glyphicon-coin"></span>Real-Time Trading</div>
                <div class="panel-body">
                  <div class="img-holder"><img src="/img/panel-2.jpg" alt="Coin Transfers"></div>
                  <hr class="separator">
                  <p>&nbsp;&nbsp; Easy interface allows you to <b>trade in real-time</b></p>
                </div>              
              </div>
            </div>
          </div>

          <?php
          include($_SERVER['DOCUMENT_ROOT']."/includes/marketlist.inc.php");
          ?>

          <div class="box">    


            <div class="box-container">
              <div id="news-list">

                <style type="text/css">
                #twitter-widget-0{width:100%;}
                </style>
                <a class="twitter-timeline" href="https://twitter.com/_cryptomaniac"  data-widget-id="423246077890805760">Tweets by @_cryptomaniac</a>
                <script>
                !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
                $('#twitter-widget-0').width("100%");
                </script>

              </div>
              <span class="clearFix">&nbsp;</span>
            </div><!-- end of div.box-container -->
          </div><!-- end of div.box -->
        </div>
      </div>
      <script type="text/javascript">
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

</body>
<!-- web9 -->
</html>