
<!-- start market list -->
<div class="box">       
  <div class="panel panel-default panel-market-list">
   <div class="panel-heading"> <span class="glyphicon glyphicon-market-list"></span> Market List &nbsp; - &nbsp; 
    <?php  $tradepairs = BaseDonnee::execQuery($bdd, "SELECT * FROM Markets WHERE disabled = '0'");
    echo sizeof($tradepairs).' Active Market'; if(sizeof($tradepairs) > 1) echo "s";?> 
	
	<span style='float:right;'>
<a href="skype:crypto-maniac?add">&nbsp;<img style="border:0;" src="/img/skype_icon_01.png" alt="Skype Support " width="51" height="30" align="right" >Skype Support</a>
</span>
	
  </div>
  
  <div class="tablewrap"  id="market-wrap">
   <table class="table table-striped" id="markettable">
     <thead> 
       <tr> 
         <th>Market</th>
         <th>Currency</th>
         <th >Volume</th>
         <th>Last Trade</th>
         <th>24hr High</th>
         <th>24hr Low</th>
       </tr>
     </thead>
     <tbody>



      <?php

      foreach ($tradepairs as $tradepair) {
       $coin1 = strstr($tradepair["Pair"], "/", true);
       $coin2 = substr(strstr($tradepair["Pair"], "/"), 1);
       $apair = $tradepair["Pair"];
       $coinName = BaseDonnee::execQuery($bdd, "SELECT * FROM Wallets WHERE Acronymn='$coin1'")[0]["Name"];

       $last = BaseDonnee::execQuery($bdd, "SELECT Price FROM Trade_History WHERE Market='$apair' ORDER BY Timestamp DESC LIMIT 1")[0]["Price"];

       $aday = time() - 86400;
       $lastday = BaseDonnee::execQuery($bdd, "SELECT Price FROM Trade_History WHERE Market='$apair' AND Timestamp >= '$aday' ORDER BY PRICE DESC LIMIT 1");

       $alltrade = BaseDonnee::execQuery($bdd, "SELECT Price, Quantity FROM Trade_History WHERE Market='$apair'");
       if(empty($alltrade)) $volume = 0;
       else {
        $volume = 0;
        foreach ($alltrade as $trade) {
           $volume += floatval($trade["Quantity"]);
        }
      }
    /*
      echo "<tr><td><a href='/users/trades.php?market=".strtolower($coin1."-".$coin2).'\'>';
      echo $coin1."/".$coin2."</a></td><td>".$coinName."</td>";
      echo "<td>".$volume." ".$coin2."</td>";
      echo "<td>".$last."</td>";
      echo "<td>".$lastday[0]["Price"]."</td>";
      echo "<td>".end($lastday)["Price"]."</td></tr>";
	  */
	  //////////////////////////////////////////////Code Pierre END//////////////////////////////////////////////
	  echo "<tr><td><a href='/users/trades.php?market=".strtolower($coin1."-".$coin2).'\'>';
      echo $coin1."/".$coin2."</a></td><td>".$coinName."</td>";
      echo "<td>".number_format($volume, 8, '.', '')." ".$coin1."</td>";
      echo "<td>".number_format($last, 8, '.', '')."</td>";
      echo "<td>".number_format($lastday[0]["Price"], 8, '.', '')."</td>";
      echo "<td>".number_format(end($lastday)["Price"], 8, '.', '')."</td></tr>";
	  //////////////////////////////////////////////Code Pierre END/////////////////////////////////////////////
	  
	  
    }
    ?>



  </tbody>
</table>  	


<span class="clearFix">&nbsp;</span>
</div><!-- end of div.box-container -->
      	</div><!-- end of div.box -->