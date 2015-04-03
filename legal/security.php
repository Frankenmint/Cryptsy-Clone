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

<div class="panel panel-default">

                <div class="panel-heading"> 
                	<span class="glyphicon glyphicon-trade-key"></span> Crypto Maniac Security Policy
                </div>

                  <div class="generaltext">
 	

<h4>Offline Funds Storage.</h4>
Offline Funds Storage
We store the majority of our customer's funds in a secure offline wallet, with only a portion available in a 'hot' wallet for instant withdrawals. This method vastly improves security at a minor expense of large withdrawals requiring manual processing. 
<br><br>  	
<h4>DDoS Protection</h4>
We utilize a leading DDoS provider for all public facing content and cache all static content on a CDN to provide the fastest possible load times.
<br><br>  	
<h4>Best Practices</h4>
Our website traffic runs entirely over encrypted SSL (https) using Extended Validation (green bar) certificates.  Wallets (and private keys) are stored using AES-256 encryption.
<br><br>  	
<h4>Firewall</h4>
We use firewalls to only allow authorized access to specific ports
<br><br>  	
<h4>Secure Website</h4>
All interaction with the website is required over HTTPS so all communication is encrypted via SSL.
<br><br>  	
<h4>Two-Factor Authentication</h4>
Customers can set up two-factor authentication for accounts with Google Authenticator to provide an extra layer of security. 
<br><br>  	
<h4>Application</h4>
We use SQL injection filters and verify the authenticity of POST, PUT, and DELETE requests to prevent CSRF attacks.  
All requests pass through a security layer to prevent DDoS and other security threats.
<br><br>  	
<h4>Authentication</h4>
We hash passwords stored in the database (encrypted).  We check for strong passwords on account creation and password reset.
<br><br>  	
</div>
</div>
   <div class="box">      
            <div class="box-container">

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

<!-- Footer Start --><?php   include($_SERVER['DOCUMENT_ROOT']."/includes/footer.inc.php");   ?><!-- Footer end -->
	
<script>$('.dropdown-toggle').dropdown();</script>
</body>
<!-- web9 -->
</html>