<?php
session_start();
session_regenerate_id();

   //Redirige vers l'accueil si l'user est connecté
if(isset($_SESSION["pseudo"])){
          header("Location: ../index.php"); //Redirection vers l'accueil
          exit();
        }
        ?>

        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
         <title>
          Crypto Maniac :: Login</title>    

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
                <?php
                    if(isset($_SESSION["just_registered"])){ //affichage unique d'un message lors de l'inscription
                    echo("<div class=\"panel-heading\"> <span class=\"glyphicon glyphicon-ok-circle\" style=\"color:green;\"></span> Thank you for your registration</div>
						  <div> <p> You will receive an activation email for activate your crypto-maniac account </p></div>" );
                      unset($_SESSION["just_registered"]); // On efface definitivement cette variable
                    }
                    ?>
                    <div class="panel-heading"> <span class="glyphicon"></span> Login</div> 
                    <div class="panel-body">
                     <?php
                     if(isset($_SESSION["erreur_login"])) echo("<p class=\"text-danger\"> Votre identifiant ou mot de passe est incorrect </p>");
                     ?>
                     <form action="./verif_login.php" id="UserLoginForm" method="post" accept-charset="utf-8"><div style="display:none;"><input type="hidden" name="_method" value="POST"/><input type="hidden" name="data[_Token][key]" value="6502ca303cad1e60c59e9b08b091d4cb3235e092" id="Token1128127150"/></div>
                      <div class="row">
                       <div class="col-xs-6">
                        <div class="form-group">
                         <label for=""><span class="glyphicon glyphicon-username"></span> Username</label>
                         <input name="pseudo" class="form-control" autocomplete="off" maxlength="20" type="text" id="UserUsername" required="required"/>                                                  
                       </div>
                     </div>   
                     <div class="col-xs-6">
                      <div class="form-group">
                       <label for=""><span class="glyphicon glyphicon-new-password"></span> Password</label>
                       <input name="mdp" class="form-control" autocomplete="off" type="password" id="UserPassword" required="required"/>                           

                     </div>
                   </div>   
                 </div>

                 <hr class="separator">


                 <center><label><a href='/users/forgotpass'>Forgot Password? Click Here</a></label></center>


                 <hr class="separator">


                 <p class="submit-holder" style="text-align:center;">
                   <input  class="btn btn-default btn-success" type="submit" value="Login"/><div style="display:none;"><input type="hidden" name="data[_Token][fields]" value="e0ae042b2ad2256e28a55023290bc187f367dc4a%3A" id="TokenFields1271582166"/><input type="hidden" name="data[_Token][unlocked]" value="" id="TokenUnlocked901194487"/></div></form>  
                 </p>  

               </div>
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



 </body>
 <!-- web9 -->
 </html>

 <?php
 if(isset($_SESSION["erreur_login"])) unset($_SESSION["erreur_login"]);
 ?>