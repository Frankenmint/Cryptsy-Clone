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
    Crypto Maniac - Admin Vote
  </title>    

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


          <div class="panel panel-default panel-market-display-settings">
            <div class="panel-heading"> 
             <span class="glyphicon glyphicon-transfer"></span>Admin Votes
           </div> 
           <div class="panel panel-default panel-market-display-settings">
            <div class="panel-body">
              <a href="./admin.php">Return to admin panel</a>
              <p class="text-danger"> <?php echo $_SESSION["error"]["general"]; ?> </p>
                <div class="tablewrap" style="max-height:500px; overflow:auto;">
                  <form action="./verif_admin_vote.php" method = "POST">
                    <input type="hidden" name="updateVote"/>
                    <table class='table table-striped table-bordered table-condensed'>
                      <tr>
                        <td><label>Code</label> </td>
                        <td><label>Name</label> </td>
                        <td><label>Address</label> </td>
                        <td><label>Total</label> </td>
                        <td><label>Action</label> </td>
                      </tr>
                      <?php
                      $sql= BaseDonnee::execQuery($bdd, "SELECT * FROM Votes ORDER BY Total DESC");
                      foreach ($sql as $vote) {
                        echo "<tr ";
                        if ($vote["Actif"] == "1"){
                          echo('class="success">');
                        }else{
                          echo('class="danger">');
                        }
                        echo "><td>".$vote["Acronymn"]."</td>";
                        echo "<td>".$vote["Name"]."</td>";
                        echo "<td>".$vote["Address"]."</td>";
                        echo "<td>".$vote["Total"]."</td>";
                        if($vote["Actif"]){
                          echo "<td>".'<input  name="'.$vote["Acronymn"].'" class="btn btn-default btn-danger" type="submit" value="Desactiver"/>'."</td>";
                        }else{
                            echo "<td>".'<input name="'.$vote["Acronymn"].'" class="btn btn-default btn-success" type="submit" value="Activer"/>'."</td>";
                          }
                          echo "</tr>";
                        }
                        ?>   
                      </table>
                    </form>
                  </div>
              </form>

            </div>
          </div>

          <div class="panel panel-default panel-market-display-settings">
            <div class="panel-heading"> 
             <span class="glyphicon glyphicon-transfer"></span>Add a vote
           </div>
            <div class="panel-body">   
              <p> A new address will be generate for this vote </p>
              <form action="./verif_admin_vote.php" method = "POST">
                <input type="hidden" name="addVote">
                  <table class='table table-striped table-bordered table-condensed'>
                      <tr>
                        <td><label>Code</label></td>
                        <td><label>Name</label></td>
                      </tr>
                      <tr>
                        <td><input class="form-control" name="Acronymn" type="text"/></td>
                        <td><input class="form-control" name="Name" type="text"/></td>
                      </tr>
                    </table>
                     <input  class="btn btn-default btn-success" type="submit" value="Create"/>
              </form>
            </div>
          </div>

        </div><!--/end working-contents--> 
      </div><!--/content-->


    </div><!--/row/maincontents-->


  </div> <!-- /container -->

  <div class="clearfix"></div>
  <!-- Footer Start -->
  <?php   include_once($_SERVER['DOCUMENT_ROOT']."/includes/footer.inc.php");   ?>
  <!-- Footer end -->

</body>
<!-- web9 -->
</html>

<?php 
  //Par sécurité on supprime directement les variable session quand on en a plus besoin
unset($_SESSION["error"]); 
?> 
