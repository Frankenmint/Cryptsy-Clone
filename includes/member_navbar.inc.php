<?php
  session_start();
  session_regenerate_id();
  $filename = explode('.', basename($_SERVER['PHP_SELF']))[0];
  //$_SESSION["pseudo"] existe forcement si nous entrons dans ce fichier (l'user est connecté)
?>
<div class="navbar navbar-default navbar-blue">
      <div class="container ">
        <div class="navbar-header"> 
          <a  href="/index.php"><img src="/img/cryptomaniac10.jpg" alt="" width="250" height="50"></a>
        </div> 
          <ul class="nav navbar-nav pull-right ">
           
            <li <?php if($filename == "marketview") echo "class='active'";?>><a href="/users/marketview.php"><span class="glyphicon "></span>Markets</a></li>
            <li <?php if($filename == "balances") echo "class='active'";?>><a id='headbalances' href="/users/funds.php"><span class="glyphicon "></span>Your Funds</a></li>
            <li <?php if($filename == "orders") echo "class='active'";?>><a id='headorders' href="/users/orders.php"><span class="glyphicon "></span>Live Orders</a></li>
			<li><a href="/users/votes.php"><span class="glyphicon "></span>Vote</a></li> 
			<li><a href="#SOON"><span class="glyphicon "></span>Mine</a></li> 
            <li <?php if($filename == "tradehistory") echo "class='active'";?>><a href="/users/tradehistory.php"><span class="glyphicon "></span>History</a></li>     
            <li class="dropdown">
              <a href="../#" class="dropdown-toggle" data-toggle="dropdown"> 
                <div class="avatar">
                <img src="/img/userslogin-crypto-maniac.png" alt="">&nbsp;&nbsp;Howdy&nbsp;<strong><?php echo htmlspecialchars($_SESSION["pseudo"]); ?></strong> 
                <b class="caret"></b></div>
              </a>
              <ul class="dropdown-menu">
                <?php
                    //Lien vers les reglages different pour l'administrateur.
                    if($_SESSION["pseudo"] == "admin"){
                      echo "<li><a href=\"/admin/admin.php\"><span class=\"glyphicon glyphicon-cog\"></span>Parametre</a></li>";
                    }else{
                      echo "<li><a href=\"/users/settings.php\"><span class=\"glyphicon glyphicon-cog\"></span>Parametre</a></li>";
                    }
                 ?>
                <li><a href="/users/logout.php"><span class="glyphicon glyphicon-off"></span>Deconnexion</a></li>
                
              </ul>
           </li>
          </ul>  
      </div>
</div>    