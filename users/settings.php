<?php
session_start();
session_regenerate_id();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title> Crypto Maniac - User Settings</title>    
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



          <div class="panel panel-default panel-change-contact-info">
            <div class="panel-heading"> <span class="glyphicon glyphicon-edit"></span> Change Contact Information</div> 
            <div class="panel-body">
              <?php
              require_once($_SERVER['DOCUMENT_ROOT']."/classes/BaseDonnee.class.php");

              $bdd = BaseDonnee::connexion();
              $res = BaseDonnee::getByUsername($bdd, $_SESSION["pseudo"]);
              echo('
                <form action="./verif_settings.php" id="UserSettingsForm" method="post" accept-charset="utf-8"><div style="display:none;"><input type="hidden" name="_method" value="POST"/><input type="hidden" name="data[_Token][key]" value="750e0010456c6a132ff43c6a06f1539c7516f0cf" id="Token32834591"/></div><input type="hidden" name="data[User][updatetype]" value="allcontact" id="UserUpdatetype"/>                    <div class="row">
                
                
                <div class="row">
                <div class="col-xs-6">
                <div class="form-group">
                <label for=""><span class="glyphicon glyphicon-email"></span> Email</label>
                <input name="changemail" value="'.$res["mail"].'" class="form-control" maxlength="80" type="email" id="UserEmail" required="required"/>                          
                </div>
                <i class="text-danger">'.$_SESSION["errors"]["mail"].'</i>
                <i class="text-success">'.$_SESSION["updated"]["mail"].'</i>
                </div>   
                <div class="col-xs-6">
                <div class="form-group">
                <label for=""><span class="glyphicon glyphicon-password"></span> Existing Password (Required)</label>
                <input name="nowmdp" class="form-control" type="password" id="UserExistingPassword"/>                          
                </div>
                </div>   
                </div>
                <hr class="separator">
                <div class="row">
                <div class="col-xs-6">
                <div class="form-group">
                <label for=""><span class="glyphicon glyphicon-new-password"></span> New password</label>
                <input name="newmdp" class="form-control" type="password" id="UserPassword"/>                          
                </div>
                <i class="text-danger">'.$_SESSION["errors"]["mdp"].'</i>
                <i class="text-success">'.$_SESSION["updated"]["mdp"].'</i>
                </div>   
                <div class="col-xs-6">
                <div class="form-group">
                <label for=""><span class="glyphicon glyphicon-confirm-password"></span> Confirm password</label>
                <input name="newmdpconfirm" class="form-control" type="password" id="UserPassword2"/>                          
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
                <p class="submit-holder">
                <input  class="btn btn-default btn-success" type="submit" value="Save Contact Info"/><div style="display:none;"><input type="hidden" name="data[_Token][fields]" value="110d7719176119b7b1cc03728bb04ab522e9ddcd%3AUser.updatetype" id="TokenFields1484521498"/><input type="hidden" name="data[_Token][unlocked]" value="" id="TokenUnlocked1382357938"/></div>

                </form>  
                ');
                ?>
              </p>
              

            </div>
          </div>  <!--/panel list-->
          
          

          
        </div>
      </div>   



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



<script type="text/javascript" src="/js/freshwidget.js"></script>
<style type="text/css" media="screen, projection">
@import url(/css/freshwidget.css); 
</style> 
<script type="text/javascript">
$(function() {
  FreshWidget.init("", {"queryString": "", "buttonText": "Support", "buttonColor": "white", "buttonBg": "#428bca", "alignment": "4", "offset": "230px", "url": "https://cryptsy.freshdesk.com", "assetUrl": "https://s3.amazonaws.com/assets.freshdesk.com/widget"} );
});
</script>


</body>
<!-- web9 -->
</html>

<?php 
  //Par sécurité on supprime directement les variable session quand on en a plus besoin
unset($_SESSION["errors"]); 
unset($_SESSION["updated"]); 
?> 