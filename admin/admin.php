<?php
/*
$ip_client = getenv('HTTP_CLIENT_IP')?:
getenv('HTTP_X_FORWARDED_FOR')?:
getenv('HTTP_X_FORWARDED')?:
getenv('HTTP_FORWARDED_FOR')?:
getenv('HTTP_FORWARDED')?:
getenv('REMOTE_ADDR');

$allowed_ip = array("84.102.30.200","93.26.212.238","86.77.145.183");

if(!in_array($ip_client, $allowed_ip)){
   header('HTTP/1.0 404 Not Found');
   exit("<h1>404 Not Found</h1>\nThe page that you have requested could not be found.");
}
*/
?>
<?php
function get_server_memory_usage(){
 
        $free = shell_exec('free');
        $free = (string)trim($free);
        $free_arr = explode("\n", $free);
        $mem = explode(" ", $free_arr[1]);
        $mem = array_filter($mem);
        $mem = array_merge($mem);
        $memory_usage = $mem[2]/$mem[1]*100;
 
        return $memory_usage;
}

function get_server_cpu_usage(){

        $output = shell_exec('cat /proc/loadavg');
        $loadavg = substr($output,0,strpos($output," ")); 

        return $loadavg;
}
//Pierre Cpu load & memory snippet end

?>

<?php
//Page accessible seulement par l'administrateur
session_start();
session_regenerate_id();

require_once($_SERVER['DOCUMENT_ROOT']."/classes/BaseDonnee.class.php");

$bdd = BaseDonnee::connexion();
//Si l'utilisateur qui accède à la page n'a pas le pseudo de l'administrateur dans sa variable session, il voit une page 404.
if($_SESSION["pseudo"] != "admin"){
	header('HTTP/1.0 404 Not Found');
	exit("<h1>404 Not Found</h1>\nThe page that you have requested could not be found.");
}

BaseDonnee::updateLastTimeSeen($bdd, "admin");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>
    Crypto Maniac - Admin Panel
  </title>    

  <?php
  include_once($_SERVER['DOCUMENT_ROOT']."/includes/header.inc.php");
  ?>

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


<!--start working-contents--> 
      <div class="working-contents">
        <div class="page page-settings" style="float:left;">

          <br>

          <div class="panel panel-default panel-change-contact-info">
		  
            <div class="panel-heading"> 
			<a href="./addwallet.php">Add Wallet</a>
			<a href="./activewallet.php">Active Wallet</a>
			<a href="./activemarket.php">Active Market</a>
			<a href="./activepair.php">Active Pair</a>
			<a href="./userstats.php">Users Stats</a>
			<a href="./adminvote.php">Admin Votes</a>
			<a href="./earning.php">Earning</a>
			<a href="./generator.php">Trade Gen</a>
			
             </div> 
            <div class="panel-body">
			<h4>Users Stats</h4>
              <?php
              $nbconnecte = BaseDonnee::execQuery($bdd, "SELECT COUNT(*) FROM Users WHERE LastTimeSeen > DATE_SUB(NOW(), INTERVAL 5 MINUTE)")[0]["COUNT(*)"];
              $totaluser = BaseDonnee::execQuery($bdd, "SELECT COUNT(*) FROM Users ")[0]["COUNT(*)"];
              $lastip = BaseDonnee::execQuery($bdd, "SELECT * FROM Users ORDER BY LastSignIn DESC LIMIT 1")[0];
              ?>
              <div class="row">
                <div class="col-xs-6">
                <table>
                 <tr>
                  <td> <strong> Total users: </strong></td>
                  <td> <?php echo $totaluser;?> </td>
                </tr>
                <tr>
                  <td> <strong> Connected users: </strong></td>
                  <td> <?php echo $nbconnecte;?> </td>
                </tr>
                <tr>
                 <td> <strong> Lastest connection: </strong></td>
                 <td > <span style="color:red;"><?php echo $lastip["Last_IP"];?></span> <?php echo '('.explode(' ', $lastip["LastSignIn"])[1].')';?> </td>				
               </tr>
			  
			  <!-- Pierre Code CPU & Memory Start -->
			   <tr>
                 <td> <strong> Memory Usage: </strong></td>
                 <td >  
				 <p><span class="description">Server Memory Usage:</span> <span class="result"><?= get_server_memory_usage() ?>%</span></p>
				  </td>				
               </tr>			   			 				
				<tr>
                 <td> <strong> CPU Usage: </strong></td>
                 <td >  
				  <p><span class="description">Server CPU Usage: </span> <span class="result"><?= get_server_cpu_usage() ?>%</span></p>
				 </td>				
               </tr>

				
				

             </table>
           </div>
           <div class="col-xs-6">
                

                
           </div>
         </div>

         </div>
       </div>  <!--/panel list-->
	   
	   
	   <!--change contact start-->
	             <div class="panel panel-default panel-change-contact-info">
            <div class="panel-heading"> <span class="glyphicon glyphicon-edit"></span> Change Contact Information</div> 
            <div class="panel-body">
              <?php

              $res = BaseDonnee::getByUsername($bdd, $_SESSION["pseudo"]);
              echo('
                <form action="/users/verif_settings.php" id="UserSettingsForm" method="post" accept-charset="utf-8">             

                <div class="row">
                <div class="col-xs-6">
                <div class="form-group">
                <label for=""><span class="glyphicon glyphicon-email"></span> Email</label>
                <input name="changemail" value="'.$res["Email"].'" class="form-control" maxlength="80" type="email" id="UserEmail" required="required"/>                          
                </div>
                <i class="text-danger">'.$_SESSION["errors"]["mail"].'</i>
                <i class="text-success">'.$_SESSION["updated"]["mail"].'</i>
                </div> 
                </div>  

                <hr class="separator">

                <div class="row">
                <div class="col-xs-6">
                <div class="form-group">
                <label for=""><span class="glyphicon glyphicon-password"></span> Existing Password (Required)</label>
                <input name="nowmdp" class="form-control" type="password" id="UserExistingPassword"/>    
                </div>                     
                </div>   

                </div>



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
                <input  class="btn btn-default btn-success" type="submit" value="Save Contact Info" /><div style="display:none;"><input type="hidden" name="data[_Token][fields]" value="110d7719176119b7b1cc03728bb04ab522e9ddcd%3AUser.updatetype" id="TokenFields1484521498"/><input type="hidden" name="data[_Token][unlocked]" value="" id="TokenUnlocked1382357938"/></div>

                </form>  
                ');
                ?>
              </p>

            </div>
          </div>  <!--/panel list-->



</div><!--/end working-contents--> 
</div><!--/content-->


</div><!--/row/maincontents-->


</div> <!-- /container -->

<div class="clearfix"></div>

	<!-- Footer Start -->
    <?php
    include($_SERVER['DOCUMENT_ROOT']."/includes/footer.inc.php");
    ?>
    <!-- Footer end -->





</body>
<!-- web9 -->
</html>

<?php 
  //Par sécurité on supprime directement les variable session quand on en a plus besoin
unset($_SESSION["errors"]); 
unset($_SESSION["updated"]); 
unset($_SESSION["addErreur"]);
?> 
