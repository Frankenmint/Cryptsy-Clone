<?php
session_start();
session_regenerate_id();

$reset = false;
if(isset($_GET["usr"]) && isset($_GET["key"])){
  $reset = true;
}

//Redirige vers l'accueil si l'user est connecté
if(isset($_SESSION["pseudo"])){
      header("Location: ../index.php"); //Redirection vers l'accueil
      exit();
    }

    function generatePassword($length = 8) {
      $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
      $count = mb_strlen($chars);

      for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
      }

      return $result;
    } 
    ?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
     <title>
      Crypto Maniac :: Forgot Password</title>    

      <?php
      include_once($_SERVER['DOCUMENT_ROOT']."/includes/header.inc.php");
      ?>
    </head>
    <body>


      <!-- Fixed navbar -->
      <?php
     //Si l'utilisateur n'est pas connecté, on affiche la barre de navigation pour les visiteurs
      include("../includes/guest_navbar.inc.php");
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



           <!-- start panel list -->
           <div class="panel panel-default">
            <div class="panel-heading"> <span class="glyphicon"></span> Forgot Password</div> 
            <div class="panel-body">
              <form action="./verif_forgotpass.php" id="UserLoginForm" method="post" accept-charset="utf-8">
             <?php
             if(!$reset){
               if(isset($_SESSION["erreur_forgotpass"])) echo("<p class=\"text-danger\"> Your username and email don't match any user </p>");
               if(isset($_SESSION["success_forgotpass"])) echo("<p class=\"text-success\"> A reset email has been sent to your mailbox </p>");
               echo('<div class="row">
                 <div class="col-xs-6">
                 <div class="form-group">
                 <label for=""><span class="glyphicon glyphicon-username"></span> Username</label>
                 <input name="pseudo" class="form-control" autocomplete="off" maxlength="30" type="text" required="required"/>                                                  
                 </div>
                 </div>   
                 <div class="col-xs-6">
                 <div class="form-group">
                 <label for=""><span class="glyphicon glyphicon-new-password"></span> Email</label>
                 <input name="mail" class="form-control" maxlength="30"  type="text" autocomplete="off" required="required"/>                           
                 </div>
                 </div>   
                 </div>
                 <hr class="separator">
                 <p class="submit-holder" style="text-align:center;">
                 <input  class="btn btn-default btn-success" type="submit" value="Request a new password"/>
                 </form>  
                 </p>  
                 </div>
                 </div>');
}else{
              //reset
              //verifications
  $usr = mysql_escape_string($_GET["usr"]);
  $key = mysql_escape_string($_GET["key"]);
  $sql = BaseDonnee::execQuery($bdd, "SELECT * FROM Users WHERE LostPasswordRequest = 1 AND Username = '$usr' AND KeyResetPassword = '$key'");
  if(!empty($sql)){
    $newmdp = generatePassword();
    BaseDonnee::editPassword($bdd, $usr, $newmdp);
    echo '
    <h2> Hi '.$usr.'</h2>
    <p> Here is your new generated password, please connect and go in your account section for change it now</p>
    <p><strong>'.$newmdp.'</strong></p>';
  }else{
    header("Location: ../index.php"); // redirection vers la page de login
   exit();
  }
}
?>


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



</body>
<!-- web9 -->
</html>

<?php
if(isset($_SESSION["erreur_forgotpass"] )) unset($_SESSION["erreur_forgotpass"] );
if(isset($_SESSION["success_forgotpass"] )) unset($_SESSION["success_forgotpass"] );
?>