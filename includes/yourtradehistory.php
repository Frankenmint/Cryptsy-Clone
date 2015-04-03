    <div class="panel panel-default panel-trade-list">

      <div class="panel-heading"> 
        <span class="glyphicon glyphicon-account-balances"></span> Your Trade History <small>(Last 50)</small>
      </div>

      <div class="tablewrap"  id="market-wrap" style="height:300px; overflow:auto;">

        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped" id="tradehistory">

          <thead>
            <tr>
             <th>Date</th>
             <th>Type</th>
             <th>Price Each <small>(<?php echo $coin2;?>)</small></th>
             <th><?php echo $coin1;?> Traded</th>
             <th>Total <?php echo $coin2;?></th>
           </tr>
         </thead>
         <tbody>
          <?php
          $username = $_SESSION["pseudo"];
          $tradehistory = BaseDonnee::execQuery($bdd, "SELECT * FROM Trade_History WHERE (Market = '$pair' OR Market = '$reversepair') AND (Buyer = '$username' OR Seller = '$username') ORDER BY Timestamp DESC LIMIT 50");
          foreach ($tradehistory as $atrade) {
            echo '<tr><td>'.date('Y-m-d H:i:s',$atrade["Timestamp"]).'</td>';
            echo '<td>'.$atrade["Type"].'</td>';
            echo '<td>'.number_format($atrade["Price"], 8, '.', '').'</td>';
            echo '<td>'.number_format($atrade["Quantity"], 8, '.', '').'</td>';
            $total = number_format(floatval($atrade["Price"] * $atrade["Quantity"]), 8, '.', '');
            echo '<td>'.$total.'</td></tr>';
          }
          ?>
        </tbody>

      </table>

    </div>

  </div>