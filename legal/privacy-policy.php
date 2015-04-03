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

<h1>Crypto Maniac Privacy Policy</h1>
<p>This Privacy Policy was last modified on April 18, 2014.</p>
<p>Crypto Maniac ("us", "we", or "our") operates http://www.crypto-maniac.com (the "Site"). This page informs you of our policies regarding the collection, use and disclosure of Personal Information we receive from users of the Site.</p>
<p>We use your Personal Information only for providing and improving the Site. By using the Site, you agree to the collection and use of information in accordance with this policy. Unless otherwise defined in this Privacy Policy, terms used in this Privacy Policy have the same meanings as in our Terms and Conditions, accessible at http://www.crypto-maniac.com.</p>

<p><strong>Information Collection And Use</strong><br />While using our Site, we may ask you to provide us with certain personally identifiable information that can be used to contact or identify you. Personally identifiable information may include, but is not limited to, your name, email address, postal address and phone number ("Personal Information").</p>

<p><strong>Log Data</strong><br />Like many site operators, we collect information that your browser sends whenever you visit our Site ("Log Data"). This Log Data may include information such as your computer's Internet Protocol ("IP") address, browser type, browser version, the pages of our Site that you visit, the time and date of your visit, the time spent on those pages and other statistics.</p>

<p><strong>Cookies</strong><br />Cookies are files with small amount of data, which may include an anonymous unique identifier. Cookies are sent to your browser from a web site and stored on your computer's hard drive.</p>
<p>Like many sites, we use "cookies" to collect information. You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent. However, if you do not accept cookies, you may not be able to use some portions of our Site.</p>

<p><strong>Security</strong><br />The security of your Personal Information is important to us, but remember that no method of transmission over the Internet, or method of electronic storage, is 100% secure. While we strive to use commercially acceptable means to protect your Personal Information, we cannot guarantee its absolute security.</p>

<p><strong>Links To Other Sites</strong><br />Our Site may contain links to other sites that are not operated by us. If you click on a third party link, you will be directed to that third party's site. We strongly advise you to review the Privacy Policy of every site you visit.</p>
<p>Crypto Maniac has no control over, and assumes no responsibility for, the content, privacy policies, or practices of any third party sites or services.</p>

<p><strong>Changes To This Privacy Policy</strong><br />Crypto Maniac may update this Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on the Site. You are advised to review this Privacy Policy periodically for any changes.</p>

<p><strong>Contact Us</strong><br />If you have any questions about this Privacy Policy, please contact us.</p>


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
