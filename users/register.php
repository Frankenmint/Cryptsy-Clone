<?php
// Import this file for generate a recaptcha in the form
require_once($_SERVER["DOCUMENT_ROOT"]."/classes/recaptchalib.php");
session_start();
session_regenerate_id();
require_once($_SERVER['DOCUMENT_ROOT']."/classes/BaseDonnee.class.php");
$bdd = BaseDonnee::connexion();
if(isset($_SESSION["pseudo"])){
  header("Location: ../index.php");
  exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>
   Crypto Maniac - Register New Account</title>    
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <?php include_once($_SERVER['DOCUMENT_ROOT']."/includes/header.inc.php");?>
 </head>
 <body>

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

          <script type='text/javascript'>

          function checkforusstate() 
          {
           if ($('#UserCountry').val() == 'United States') 
           {
            $('#usstate').show();
          }
          else
          {
            $('#usstate').hide();
          }
        }

        </script>

        <br />

        <!-- start panel list -->
        <div class="panel panel-default panel-chatbox-configuration">
          <div class="panel-heading" style="width:746px;"> <span class="glyphicon glyphicon-contact-info"></span> Register New Account</div> 
          <div class="panel-body">

            <?php 
            if(!isset($_GET["usr"]) || !isset($_GET["key"])){
              echo '
            <form action="../users/verif_register.php" id="UserRegisterForm" method="post" accept-charset="utf-8">
            <div style="display:none;"><input type="hidden" name="_method" value="POST"/>
            <input type="hidden" name="data[_Token][key]" value="8c8e7583700a067a34fd1f892213ac523f9c28db" id="Token884952512"/>
            </div>
            <p class="text-danger">'.$_SESSION["errors"]["general"].'</p>
            <p class="descr">Please complete the form below as accurately as possible. All fields are Mandatory.</p>
            <div class="row">
            <div class="col-xs-6">
            <div class="form-group">
            <label for=""><span class="glyphicon glyphicon-username"></span> Username</label>

            <input name="pseudo" class="form-control" maxlength="20" type="text" value = "'.$_SESSION["champs_inscription"]["pseudo"].'" id="UserUsername" required="required"/>                          

            </div>
            <p class="text-danger">'.$_SESSION["errors"]["pseudo"].'</p>
            </div>   
            <div class="col-xs-6">
            <div class="form-group">
            <label for=""><span class="glyphicon glyphicon-email"></span> Email</label>
            <input name="mail" class="form-control" maxlength="80" type="email" value = "'.$_SESSION["champs_inscription"]["mail"].'" id="UserEmail" required="required"/>                          
            </div>
            <p class="text-danger">'.$_SESSION["errors"]["mail"].'</p>

            </div>    
            </div>
            <hr class="separator">

            <div class="row">
            <div class="col-xs-6" style="padding-left:35px;">
            <div class="form-group short-form">
            <label for=""><span class="glyphicon glyphicon-position"></span> Country of Residence</label>
            <select name="pays" class="form-control" id="UserCountry">';
                      // Generation de la liste des pays
            require_once("./countryList.php");
            foreach($countryList as $c){
                      //Pour reselectionné le pays précédemment selectionné (en cas d'erreur)
              $selected = ($_SESSION["champs_inscription"]["pays"] == $c)? "selected = \"selected\"" : "";
              echo("<option ".$selected." value = \"".$c."\">".$c."</option>");
            }
            echo'
            </select>                 
            <p class="text-danger"> <?php echo $_SESSION["errors"]["pays"] ?> </p>    
            </div>

            </div> 
            </div>    

            <hr class="separator">
            <div class="row">
            <div class="col-xs-6">
            <div class="form-group">
            <label for=""><span class="glyphicon glyphicon-new-password"></span> Password</label>
            <input name="mdp1" class="form-control" type="password" id="UserPassword" required="required"/>                          
            </div>
            <p class="text-danger"> '.$_SESSION["errors"]["mdp"].'</p>
            </div>   
            <div class="col-xs-6">
            <div class="form-group">
            <label for=""><span class="glyphicon glyphicon-confirm-password"></span> Confirm password</label>
            <input name="mdp2" class="form-control" type="password" id="UserPassword2" required="required"/>                          
            </div>
            </div>   
            </div>

            <p class="text-center"><b>Password Requirements</b></p> 

            <div class="row small-row">
            <div class="col-xs-6">
            <ul>
            <li>8 characters minimum </li>
            <li>1 or more upper-case letters</li>
            </ul>
            </div>
            <div class="col-xs-6">
            <ul>
            <li>1 or more lower-case letters  </li>
            <li>1 or more digits or special characters</li>
            </ul>
            </div>
            </div>
            <hr class="separator">      			
            <div class="row">
            <div class="col-xs-6">
            <div class="form-group short-form">
            <p class="text-danger"> '.$_SESSION["errors"]["captcha"].'</p>
            <label for=""><span class="glyphicon glyphicon-new-password"></span> Enter Captcha Code</label>
            <script type="text/javascript">
				 //<![CDATA[
            var RecaptchaOptions = {"theme":"clean","lang":"en","custom_translations":[]}
                 //]]>
            </script>
            <div class="recaptcha">
            '.recaptcha_get_html('6LfGCO8SAAAAALgCyRn6DqRLssI6Pxfs-MdLVN9G').'
            </div>
            <p class="submit-holder" style="text-align:center">
            <input  class="btn btn-default btn-success" type="submit" value="Register New Account"/><div style="display:none;"><input type="hidden" name="data[_Token][fields]" value="1655c6f30c5b281a90bd288f74949cdd1e59aa8f%3A" id="TokenFields29805640"/><input type="hidden" name="data[_Token][unlocked]" value="recaptcha_challenge_field%7Crecaptcha_response_field" id="TokenUnlocked719997573"/></div> 
            </form>  
          </p>      		';
        }else{
          $usr = mysql_escape_string($_GET["usr"]);
          $key = mysql_escape_string($_GET["key"]);
          $sql = BaseDonnee::execQuery($bdd, "SELECT * FROM Users WHERE Username = '$usr' AND KeyActiveAccount = '$key'");
          if(empty($sql)){
           header("Location: ../index.php"); // redirection vers la page de login
           exit();
          }else{
            //un utilisateur s'active
            BaseDonnee::activeAccount($bdd, $usr);
            echo '<h2 class="text-success"> '.$usr.', Thank you for your registration !</h2>
            <p> Now you can <a href="./login.php">login</a> and enjoy trade crypto currencies !</p>';
          }
        }

          ?>		
        </div><!-- end of div.box-container -->
      </div><!-- end of div.box -->

    </div>
    <div class="clearfix"></div>

  </div><!--/end working-contents--> 
</div><!--/content-->

</div><!--/row/maincontents-->


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

<?php 
  //Par sécurité on supprime directement les variable session quand on en a plus besoin
unset($_SESSION["errors"]); 
unset($_SESSION["champs_inscription"]); 
?> 
