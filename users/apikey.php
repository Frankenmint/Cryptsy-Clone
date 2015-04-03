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
   Crypto Maniac - API</title>    
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
<?php	  
	 echo '<h1>API</h1>';
 /*check to see if user has an api key.*/
 
 //pierrecode
 //$bdd = BaseDonnee::connexion();
 //$api_select = BaseDonnee::execQuery($bdd, "SELECT * FROM Api_Keys WHERE `User_ID`='$id'");
//if(mysql_num_rows($api_select) > 0)
//pierre code end

 $api_select = mysql_query("SELECT * FROM Api_Keys WHERE `User_ID`='$id'");
if(mysql_num_rows($api_select) > 0) {
	$pkey = mysql_result($api_select, 0, "Public_Key");
	$akey = mysql_result($api_select, 0, "Authentication_Key");
	echo '<h3>Your Public Key is:</h3><br/>';
	echo $pkey;
	echo '<br/>';
	echo '<h3>Your Server Key is:</h3><br/>';
	echo $akey;
	echo '<br/>';		

}else{

	$topublic = generateKey($id); //public key

	$toprivate = generateKey($id); //private key

	$pub_check_no_collision = mysql_query("SELECT `Public_Key` FROM Api_Keys WHERE `Public_Key` = '$topublic'");

	$priv_check_no_collision = mysql_query("SELECT `Authentication_Key` FROM Api_Keys WHERE `Authentication_Key` = '$toprivate'");

	if(mysql_num_rows($pub_check_no_collision) > 0 ) {
		echo '<meta http-equiv="refresh" content="0; URL=index.php?page=api">';
	}else{
	
	$api_insert = mysql_query("INSERT INTO Api_Keys (`Public_Key`,`Authentication_Key`,`User_ID`) VALUES ('$topublic','$toprivate','$id')");
	echo '<meta http-equiv="refresh" content="0; URL=index.php?page=api">';
	}

} 
?>	  
	  
	  

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
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-xs-6 copyrights">
            <p>&copy; 2014 Crypto Maniac Inc  -  All Rights Reserved</p>
          </div>
          <div class="col-xs-6 nav">
            <ul class="nav nav-pills pull-right"> 
              <li><a href="/info/terms" title="Terms">Terms</a></li>
              <li><a href="/info/privacy" title="Privacy">Privacy</a></li>
              <li><a href="https://cryptomaniac.freshdesk.com/support/home" target=_new title="Support">Support</a></li>
              <li><a href="#" title="API">API Soon</a></li>
              <li><a href="/info/security" title="About">Security</a></li>
              <li><a href="/info/about" title="About">About</a></li>

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



    <script type="text/javascript">$('.dropdown-toggle').dropdown();</script> 
  </body>
  <!-- web7 -->
  </html>
