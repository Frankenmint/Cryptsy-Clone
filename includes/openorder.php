<!-- row start -->
                  <div class="row small-market-list">
                    <!-- start cell -->
                    <?php
                    if(isset($_SESSION["erreurs"]["general"])){
                      echo'<div class="alert alert-danger fade in">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <strong>'.$_SESSION["erreurs"]["general"].'</strong></div>';
                    }
                      ?>
                    <div class="col-xs-6">

                      <div class="panel panel-default panel-market-list-small">
                        <div class="panel-heading"> <span class="glyphicon glyphicon-open-orders"></span> <?php echo "Buy ".$coin1." with ".$coin2;?></div>

                        <form action="#" class="middle-forms" name="tradebuy" id="buyorderform" onsubmit="event.returnValue = false; return false;" method="post" accept-charset="utf-8">
                          <div style="display:none;"><input type="hidden" name="_method" value="POST"/>
                            <input type="hidden" name="buyOrder" value="f156ff3f73c06cc251efef43590903ad1dc7e93d" id="Token215841795"/></div> 
							<fieldset>
                            <ol>

                              <li>
                                <div class="input text"><label for="TradeBuyAmount" class="field-title">Amount <?php echo $coin1;?></label>
                                  <input id="buyamount" name="amount" value="0.00000000" class="txtbox-short form-control" style="float:left;" type="text" onKeyUP="updateFields(this);"/>
                                </div>&nbsp;
                                <small style='color: #428bca;'>Minimum&nbsp;1</small><span class='clearFix'>&nbsp;</span>
                              </li>
                              <li class='even'><div class="input text"><label for="TradeBuyPrice" class="field-title">Price Per <?php echo $coin1;?></label>
                                <?php 
                                $lastbuy = "0.00000000";
                                if(!empty($buyorders[0]['Value'])){
                                  $lastbuy = number_format($buyorders[0]['Value'], 8, '.', '');
                                }
                                ?>
                                <input id="buyprice" name="price" value="<?php echo $lastbuy;?>" class="txtbox-short form-control" style="float:left;" type="text" onKeyUP="updateFields(this);"/>
                              </div>&nbsp;&nbsp;
                              <b><small>(<?php echo $coin2;?>)</small></b><span class='clearFix'>&nbsp;</span></li>
                              <li>
                                <label class='field-title'>Total <small>(<?php echo $coin2;?>)</small></label>
                                <span style='padding-left:13px;' id='buytotal'>0.00000000</span>
                              </li>
                              <?php
                              $fee = BaseDonnee::execQuery($bdd, "SELECT * FROM Markets WHERE Pair = '$pair' OR Pair = '$reversepair'")[0]["Fee"];
                              $heldingCoin2 = BaseDonnee::execQuery($bdd, "SELECT Helding FROM balances WHERE Coin = '$coin2' AND Account ='$username'")[0]["Helding"];
                              $availableBalance2 = $balance2 - $heldingCoin2;
                              echo "<li class='even'><label id='fee' class='field-title'>".$fee;
                              echo "% Fee <small>(".$coin2.")</small></label>";
                              ?>
                              <span style='padding-left:13px;' id='buyfee'>0.00000000</span></li>
                              <li><label class='field-title'>Net Total <small>(<?php echo $coin2;?>)</small></label>
                                <span style='padding-left:13px;' id='buynettotal'>0.00000000</span>
                              </li>      					
                            </ol>
                          </fieldset>
                          <p class="submit-holder">

                            <small>	
                              <span id="buybalance" onclick="updateAmount(this);" style="cursor:pointer; font-weight: bold; color: #428bca;" class="genbalance_3"><?php echo  number_format($availableBalance2, 8, '.', '');?></span> <?php echo $coin2;?> Available&nbsp;&nbsp;&nbsp
                            						
							</small>
                            <button id="makebuyorder" class='btn btn-default btn-success'> Submit Buy Order</button>

                          </p>

                          <div style="display:none;">
                            <input type="hidden" name="data[_Token][fields]" value="5149816219bb39ea63d99cbbfa27ccb59e6a4819%3A" id="TokenFields398380770"/><input type="hidden" name="data[_Token][unlocked]" value="" id="TokenUnlocked1359590607"/>
                          </div>
                        </form>

                      </div><!-- end panel-list -->
                    </div><!--/end cell-->

                    <!-- start cell -->
                    <div class="col-xs-6">
                      <div class="panel panel-default panel-market-list-small">
                        <div class="panel-heading"> <span class="glyphicon glyphicon-open-orders"></span> <?php echo "Sell ".$coin1." for ".$coin2;?></div>

                        <form action="#" class="middle-forms" name="tradesell" id="sellorderform" onsubmit="event.returnValue = false; return false;" method="post" accept-charset="utf-8">
                          <div style="display:none;">
                            <input type="hidden" name="sellOrder"/>
                          </div>      				
                          <fieldset>
                           <ol>

                            <li><div class="input text"><label for="TradeSellAmount" class="field-title">Amount <?php echo $coin1;?></label>
                              <input id="sellamount" name="amount" value="0.00000000" class="txtbox-short form-control" style="float:left;" type="text" onKeyUP="updateFields(this);"/></div>&nbsp;<small style='color: #428bca;'>Minimum&nbsp;1</small>
                              <span class='clearFix'>&nbsp;</span>
                            </li>
                            <li class='even'><div class="input text"><label for="TradeSellPrice" class="field-title">Price Per <?php echo $coin1;?></label>
                              <?php 
                                $lastsell = "0.00000000";
                                if(!empty($sellorders[0]['Value'])){
                                  $lastsell = number_format($sellorders[0]['Value'], 8, '.', '');
                                }
                                ?>
                              <input id="sellprice" name="price" value="<?php echo $lastsell;?>" class="txtbox-short form-control" style="float:left;" type="text" onKeyUP="updateFields(this);"/></div>&nbsp;&nbsp;
                              <b><small>(<?php echo $coin2;?>)</small></b><span class='clearFix'>&nbsp;</span>
                            </li>
                          </li>
                          <li><label class='field-title'>Total <small>(<?php echo $coin2;?>)</small></label>
                            <span style='padding-left:13px;' id='selltotal'>0.00000000</span>
                          </li>
                          <?php
                          $heldingCoin1 = BaseDonnee::execQuery($bdd, "SELECT Helding FROM balances WHERE Coin = '$coin1' AND Account ='$username'")[0]["Helding"];
                          $availableBalance1 = $balance1 - $heldingCoin1;
                          echo "<li class='even'><label class='field-title'>".$fee;
                          echo "% Fee <small>(".$coin2.")</small></label>";
                          ?>
                          <span style='padding-left:13px;' id='sellfee'>0.00000000</span></li>
                          <li><label class='field-title'>Net Total <small>(<?php echo $coin2;?>)</small></label>
                            <span style='padding-left:13px;' id='sellnettotal'>0.00000000</span></li>      					
                          </ol><!-- end of form elements -->
                        </fieldset>
                        <p class="submit-holder">

                          <small>
                           <span id="sellbalance" onclick="$('#sellamount').val($(this).text());$('#sellamount').trigger('change');updateFields(this);" style="cursor:pointer; font-weight: bold; color: #428bca;" class="genbalance_8"><?php echo number_format($availableBalance1, 8, '.', '');?></span> <?php echo $coin1;?> Available&nbsp;&nbsp;&nbsp;
                         </small>
                         <button id="makesellorder" class='btn btn-default btn-success'> Submit Sell Order</button>
                       </p>
                       <div style="display:none;"><input type="hidden" name="data[_Token][fields]" value="630d1745f8cb638fba531089b6c53edb73ff3b65%3A" id="TokenFields1859358892"/>
                        <input type="hidden" name="data[_Token][unlocked]" value="" id="TokenUnlocked832457522"/>
                      </div>
                    </form>



                  </div><!--/end panel-list-->
                </div><!--/end cell-->

              </div><!--/end row-->





              <div class="panel panel-default panel-trade-list">

                <div class="panel-heading"> 
                  <span class="glyphicon glyphicon-account-balances"></span> Your Open Orders
                </div>

                <div class="tablewrap"  id="market-wrap" style="height:115px; overflow:auto; color:#80BFFF;">
                  <form action="./verif_trades.php" method="POST">
                    <input type=hidden name="cancelorder"/>
                    <?php
                    $username = $_SESSION["pseudo"];
                    $openorders = BaseDonnee::execQuery($bdd, "SELECT * FROM Trades WHERE Username = '$username' AND Pair='$pair' AND Finished = '0'");
                    echo('
                      <table cellpadding="0" cellspacing="0" border="0" class="table table2 table-striped" id="userorderslist" >
                      <thead>
                      <tr>
                      <th>Order Date</th>
                      <th>Price ('.$coin2.')</th>
                      <th>Type</th>
                      <th>Amount '.$coin1.'</th>
                      <th>Total ('.$coin2.')</th>
                      <th>Action</th>
                      </tr></thead><tbody>
                      ');
                    foreach ($openorders as $openorder) {
                      echo '<tr>';
                      echo '<td>'.date('Y-m-d H:i:s',$openorder["Date"]).'</td>';
                      echo '<td>'.number_format($openorder["Value"], 8, '.', '').'</td>';
                      echo '<td>'.$openorder["Type"].'</td>';
                      echo '<td>'.number_format($openorder["Amount"], 8, '.', '').'</td>';
                      echo '<td>'.number_format($openorder["Total"], 8, '.', '').'</td>';
                      echo '<td><input name="'.$coin1.'-'.$coin2.$openorder["Id"].'" type="submit" class="btn btn-default btn-danger" value="Cancel"/></td>';
                      echo '</tr>';
                    }
                    ?>
                  </tbody> 
                </table>
              </form>
            </div>
          </div><!--/panel charts-->