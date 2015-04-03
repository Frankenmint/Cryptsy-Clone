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

<h1>Crypto Maniac Terms and Conditions ("Agreement")</h1>
<p>This Agreement was last modified on April 18, 2014.</p>

<p>Please read these Terms and Conditions ("Agreement", "Terms and Conditions") carefully before using http://www.crypto-maniac.com ("the Site") operated by Crypto Maniac ("us", "we", or "our"). This Agreement sets forth the legally binding terms and conditions for your use of the Site at http://www.crypto-maniac.com.</p>
<p>By accessing or using the Site in any manner, including, but not limited to, visiting or browsing the Site or contributing content or other materials to the Site, you agree to be bound by these Terms and Conditions. Capitalized terms are defined in this Agreement.</p>

<p><strong>Intellectual Property</strong><br />The Site and its original content, features and functionality are owned by Crypto Maniac and are protected by international copyright, trademark, patent, trade secret and other intellectual property or proprietary rights laws.</p>

<p><strong>Trademarks </strong><br /> "Crypto Maniac", the Crypto Maniac logos and any other Crypto Maniac product or service name, logo or slogan contained in the Site are trademarks or service marks of Crypto Maniac (the "Crypto Maniac Marks") and may not be copied, imitated or used, in whole or in part, except as expressly permitted in these Terms or on the Site or with the prior written permission of Crypto Maniac. You may not use any meta tags or any other "hidden text" utilizing any Crypto Maniac Marks without our prior written permission. In addition, the look and feel of the Site, including all page headers, custom graphics, button icons and scripts, is the service mark, trademark and/or trade dress of Crypto Maniac and is part of the Crypto Maniac Marks and may not be copied, imitated or used, in whole or in part, without our prior written permission except as expressly permitted herein or on the Site. All other trademarks, registered trademarks, product names and company names or logos mentioned in the Site are the property of their respective owners and may not be copied, imitated or used, in whole or in part, without the written permission of the applicable trademark holder. Reference to any products, services, processes or other information, by trade name, trademark, manufacturer, supplier or otherwise does not constitute or imply endorsement, sponsorship or recommendation thereof by us. </p>

<p><strong>Termination</strong><br />We may terminate your access to the Site, without cause or notice, which may result in the forfeiture and destruction of all information associated with you. All provisions of this Agreement that by their nature should survive termination shall survive termination, including, without limitation, ownership provisions, warranty disclaimers, indemnity, and limitations of liability.</p>

<p><strong>Electronic Trading Terms</strong><br/> 
<br />a. Electronic Order entry for Market Orders equals Order execution
To enter an online order, you must access the Markets window, then click on "BUY/SELL" for the relevant market where you will enter the price and lot size. The order is filled shortly after you hit the submit order button provided you have sufficient funds in your Account. Orders may fail for several reasons including changing dealer prices, insufficient margin, unspecified lot size or unanticipated technical difficulties.
<br /> b. Access requirements
You will be responsible for providing the System to enable you to use an Electronic Service.
<br />c. Use of information, data and software
In the event that you receive any data, information or software via an Electronic Service other than that which you are entitled to receive pursuant to this Agreement, you will immediately notify us and will not use, in any way whatsoever, such data, information or software.
<br />d. Withdrawals
If you request a withdrawal of monies from your Account and we cannot comply with it without closing some part of your open positions, we will not comply with the request until you have closed sufficient positions to allow you to make the withdrawal.
<br />e. Execution of orders
We shall use our reasonable endeavors to execute any order promptly, but in accepting your orders we do not represent or warrant that it will be possible to execute such order or that execution will be possible according to your instructions. If we encounter any material difficulty relevant to the proper carrying out of an order on your behalf we shall notify you promptly.
<br />f. Authority
We shall be entitled to act for you upon instructions given or purporting to be given by you or any person authorized on your behalf without further inquiry as to the genuineness, authority or identity of the person giving or purporting to give such instructions provided such instruction is accompanied by your correct Account number and password.
<br />g. Currency of Accounts
You will be able to open your trading Account(s) in USD or any currency that may be offered by Crypto Maniac, including crypto currencies. Account(s) balances will be calculated and reported to you in the currency in which Account(s) are maintained.
<br />h. System defects
In the event you become aware of a material defect, malfunction or virus in the System or in an Electronic Service, you will immediately notify us of such defect, malfunction or virus and cease all use of such Electronic Service until you have received permission from us to resume use.
<br />i. Liability and Indemnity
Without prejudice to any other terms of this Agreement, relating to the limitation of liability and provision of indemnities, the following clauses shall apply to our Electronic Services.
<br />j. System errors
We shall have no liability to you for damage which you may suffer as a result of transmission errors, technical faults, malfunctions, illegal intervention in network equipment, network overloads, malicious blocking of access by third parties, internet malfunctions, interruptions or other deficiencies on the part of internet service providers. You acknowledge that access to Electronic Services may be limited or unavailable due to such system errors, and that we reserve the right upon notice to suspend access to Electronic Services for this reason.
<br />k. Delays
Neither we nor any third party software provider accepts any liability in respect of any delays, inaccuracies, errors or omissions in any data provided to you in connection with an Electronic Service.
We do not accept any liability in respect of any delays, inaccuracies or errors in prices quoted to you if these delays, inaccuracies or errors are caused by third party service providers with which we may collaborate.
We shall not be obliged to execute any instruction which has been identified that is based on errors caused by delays of the system to update prices provided by the system price feeder or the third party service providers. We do not accept any liability towards executed trades that have been based and have been the result of delays as described above.
<br />l. Viruses from an Electronic Service
We shall have no liability to you (whether in contract or in tort, including negligence) in the event that any viruses, worms, software bombs or similar items are introduced into the System via an Electronic Service or any software provided by us to you in order to enable you to use the Electronic Service, provided that we have taken reasonable steps to prevent any such introduction.
<br />m. Viruses from your System
You will ensure that no computer viruses, worms, software bombs or similar items are introduced into our computer system or network and will indemnify us on demand for any loss that we suffer arising as a result of any such introduction.
<br />n. Unauthorized use
We shall not be liable for any loss, liability or cost whatsoever arising from any unauthorized use of the Electronic Service. You shall on demand indemnify, protect and hold us harmless from and against all losses, liabilities, judgements, suits, actions, proceedings, claims, damages and costs resulting from or arising out of any act or omission by any person using an Electronic Service by using your designated passwords, whether or not you authorized such use.
<br />o. Markets
We shall not be liable for any act taken by or on the instruction of an exchange, clearing house or regulatory body.
<br />p. Immediate suspension or permanent withdrawal
We have the right, unilaterally and with immediate effect, to suspend or withdraw permanently your ability to use any Electronic Service, or any part thereof, without notice, where we consider it necessary or advisable to do so, for example due to your non-compliance with the Applicable Regulations, breach of any provisions of this Agreement, on the occurrence of an Event of Default, network problems, failure of power supply, for maintenance, or to protect you when there has been a breach of security. In addition, the use of an Electronic Service may be terminated automatically, upon the termination (for whatever reason) of:
<br />- any license granted to us which relates to the Electronic Service; or
  - this Agreement.
<br />q. Effects of termination
In the event of a termination of the use of an Electronic Service for any reason, upon request by us, you shall, at our option, return to us or destroy all hardware, software and documentation we have provided you in connection with such Electronic Service and any copies thereof. </p>
<p><strong>Links To Other Sites</strong><br />Our Site may contain links to third-party sites that are not owned or controlled by Crypto Maniac.</p>
<p>Crypto Maniac has no control over, and assumes no responsibility for, the content, privacy policies, or practices of any third party sites or services. We strongly advise you to read the terms and conditions and privacy policy of any third-party site that you visit.</p>

<p><strong>Governing Law</strong><br />This Agreement (and any further rules, polices, or guidelines incorporated by reference) shall be governed and construed in accordance with the laws of France, without giving effect to any principles of conflicts of law.</p>

<p><strong>Changes To This Agreement</strong><br />We reserve the right, at our sole discretion, to modify or replace these Terms and Conditions by posting the updated terms on the Site. Your continued use of the Site after any such changes constitutes your acceptance of the new Terms and Conditions.</p>
<p>Please review this Agreement periodically for changes. If you do not agree to any of this Agreement or any changes to this Agreement, do not use, access or continue to access the Site or discontinue any use of the Site immediately.</p>

<p><strong>Contact Us</strong><br />If you have any questions about this Agreement, please contact us.</p>


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