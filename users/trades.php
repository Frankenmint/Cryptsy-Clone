<?php
session_start();
session_regenerate_id();
require_once($_SERVER['DOCUMENT_ROOT']."/classes/BaseDonnee.class.php");
$bdd = BaseDonnee::connexion();
$coin1 = strtoupper(strstr($_GET["market"], "-", true));
$coin2 = strtoupper(substr(strstr($_GET["market"], "-"), 1));

//Si les variables contiennent d'autres caracteres que des lettre, on renvoi sur une page 404
if(!ctype_alnum($coin1) || !ctype_alnum($coin2)){
  header('HTTP/1.0 404 Not Found');
  exit("<h1>404 Not Found</h1>\nThe page that you have requested could not be found.");
}
$coin1name = BaseDonnee::execQuery($bdd, "SELECT * FROM Wallets WHERE Acronymn='$coin1'")[0]["Name"];
$pair = $coin1."/".$coin2;
$reversepair = $coin2."/".$coin1;
$verif1 =  BaseDonnee::execQuery($bdd, "SELECT * FROM Markets WHERE Pair='$pair'");
$verif2 =  BaseDonnee::execQuery($bdd, "SELECT * FROM Markets WHERE Pair='$reversepair'");

if(!isset($_SESSION["pseudo"])){
  $guest = true;
}else{
  $guest = false;
  $username = $_SESSION["pseudo"];
  BaseDonnee::updateLastTimeSeen($bdd, $username);
}
if(empty($verif1)){
  if(empty($verif2)) {
    header('HTTP/1.0 404 Not Found');
    exit("<h1>404 Not Found</h1>\nThe page that you have requested could not be found.");
  }
  $pair = $reversepair;
}
if(($verif1["disabled"] == '1') || ($verif2["disabled"] == '1')) $guest = true;
$balance1 = BaseDonnee::execQuery($bdd, "SELECT Amount FROM balances WHERE Coin='$coin1' AND Account = '$username'")[0]["Amount"];
$balance2 = BaseDonnee::execQuery($bdd, "SELECT Amount FROM balances WHERE Coin='$coin2' AND Account = '$username'")[0]["Amount"];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Crypto Maniac - <?php echo $pair;?> Market</title>    
  <?php  include_once($_SERVER['DOCUMENT_ROOT']."/includes/header.inc.php"); ?>
  <script src="http://code.highcharts.com/stock/modules/exporting.js"></script>
</head>
<body>

  <!-- Fixed navbar -->
  <?php

      //Affiche une barre différente si l'user est connecté
  if(!isset($_SESSION["pseudo"])){
   include_once($_SERVER['DOCUMENT_ROOT']."/includes/guest_navbar.inc.php");
 }else{
   include_once($_SERVER['DOCUMENT_ROOT']."/includes/member_navbar.inc.php");
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



    <!-- Content start -->
    <div class="page" id="content" role="main">



      <div >


        <br />

        <div class="page page-dashboard" style="float:left;">

          <div class="panel panel-default panel-charts">
            <div class="panel-heading" > 
              <span class="glyphicon glyphicon-market-charts"></span> Market: <span id="pair"><?php echo $pair;?></span>
              &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;	
              <a href="skype:crypto-maniac?add"><img  src="/img/skype_icon_01.png" alt="Skype Support " width="51" height="30" align="right" >Skype Support</a></span>
            </div>
            <div class="panel-body">

              <div align="" class="target" title="Only Verified Business Account Are Allowed  + 15% commission fee"> Buy <?php echo $coin1;?> with <a href="skype:crypto-maniac?add"><img src="/img/paypalcoin2.png"></a>
               <?php
			//montre le dropdown au users connectés// 
               if(!$guest) include_once($_SERVER['DOCUMENT_ROOT']."/includes/dropdown.php");?>

             </div>			 
             <div id="tradechart" style="height:330px; width:719px;">

             </div>
           </div><!--/panel charts-->

           <?php 
            //On declare ces variables ici car on en a besoin dans openorder.php
           $sellorders = BaseDonnee::execQuery($bdd, "SELECT * FROM Trades WHERE Pair = '$pair' AND Type =  'SELL' AND Finished = '0' ORDER BY Value ASC");
           $buyorders = BaseDonnee::execQuery($bdd, "SELECT * FROM Trades WHERE Pair = '$pair' AND Type =  'BUY' AND Finished = '0' ORDER BY Value DESC");
            //Ces deux <p> camouflés nous seront utile pour savoir si l'user fait un trade de prix trop haut ou bas
           echo '<p id="lastbuyprice" style="display:none;">';
           if(empty($buyorders)) echo '0';
           else echo $buyorders[0]["Value"];
           echo '</p>'; 
           echo '<p id="lastsellprice" style="display:none;">';
           if(empty($sellorders)) echo '0';
           else echo $sellorders[0]["Value"];
           echo '</p>'; 

           if(!$guest) include_once($_SERVER['DOCUMENT_ROOT']."/includes/openorder.php");
           ?>
           <!-- row start -->
           <div class="row small-market-list">
            <!-- start cell -->
            <div class="col-xs-6">
              <div class="panel panel-default panel-market-list-small">
                <div class="panel-heading"> <span class="glyphicon glyphicon-open-orders"></span> Sell orders <small> </small></div>
                <div class="tablewrap" style="max-height:300px; overflow:auto;">



                  <div id="dialog"></div>
                  <table cellpadding="0" cellspacing="0" border="0" class="table table2 table-striped" id="sellorderlist">
                    <thead>


                     <?php
                  //Sell order part
                     echo '<thead>
                     <tr onClick="transfertValue(&quot;sell&quot;, this);">
                     <th>Price&nbsp;<small>('.$coin2.')</small></th>
                     <th>'.$coin1.'</th>
                     <th>Total&nbsp;<small>('.$coin2.')</small></th>
                     </tr>
                     </thead><tbody>';
                     $nbsellorders = sizeof($sellorders);
                  //Ces variables nous serviront en cas de doublons dans les orders pour les fusionner
                     $amount = 0.0;
                     $total = 0.0;
                     for($i = 0; $i < sizeof($sellorders); $i++){
                       echo '<tr onClick="transfertValue(&quot;sell&quot;, this);">';
                       $amount += floatval($sellorders[$i]["Amount"]);
                       $total += floatval($sellorders[$i]["Total"]);
                   //On test si deux order consecutifs possèdent le même prix. Si oui on ne reinitialise pas amount et total, ce qui les fera cumuler (fusion).
                       if($i < ($nbsellorders-1) && ($sellorders[$i]["Value"] == $sellorders[$i+1]["Value"])){
                        continue;
                      }

                      echo '<td>'.number_format($sellorders[$i]["Value"], 8,'.','').'</td>';
                      echo '<td>'.number_format(floatval($amount), 8,'.','').'</td>';
                      echo '<td>'.number_format(floatval($total), 8,'.','').'</td>';
                      echo '</tr></tbody>';
                      $amount = 0.0;
                      $total = 0.0;
                    }
                    ?>


                  </table>
                </div>
              </div><!-- end panel-list -->
            </div><!--/end cell-->


            <!-- start cell -->
            <div class="col-xs-6">
              <div class="panel panel-default panel-market-list-small"  >
                <div class="panel-heading"> <span class="glyphicon glyphicon-open-orders"></span> Buy Orders <small> </small></div>
                <div class="tablewrap" style="max-height:300px; overflow:auto;">
                  <table cellpadding="0" cellspacing="0" border="0" class="table table2 table-striped" id="buyorderlist">

                   <?php
                  //Buy order part
                   echo '<thead>
                   <tr>
                   <th>Price&nbsp;<small>('.$coin2.')</small></th>
                   <th>'.$coin1.'</th>
                   <th>Total&nbsp;<small>('.$coin2.')</small></th>
                   </tr>
                   </thead><tbody> ';
                   $nbbuyorders = sizeof($buyorders);
                  //Ces variables nous serviront en cas de doublons dans les orders pour les fusionner
                   $amount = 0.0;
                   $total = 0.0;
                   for($i = 0; $i < sizeof($buyorders); $i++){
                     echo '<tr onClick="transfertValue(&quot;buy&quot;, this);">';
                     $amount += floatval($buyorders[$i]["Amount"]);
                     $total += floatval($buyorders[$i]["Total"]);
                   //On test si deux order consecutifs possèdent le même prix. Si oui on ne reinitialise pas amount et total, ce qui les fera cumuler (fusion).
                     if($i < ($nbbuyorders-1) && ($buyorders[$i]["Value"] == $buyorders[$i+1]["Value"])){
                      continue;
                    }

                    echo '<td>'.number_format($buyorders[$i]["Value"], 8,'.','').'</td>';
                    echo '<td>'.number_format(floatval($amount), 8,'.','').'</td>';
                    echo '<td>'.number_format(floatval($total), 8,'.','').'</td>';
                    echo '</tr></tbody>';
                    $amount = 0.0;
                    $total = 0.0;
                  }
                  ?>

                </table>
              </div>
            </div><!--/end panel-list-->
          </div><!--/end cell-->

        </div><!--/end row-->


        <div class="panel panel-default panel-trade-list">

          <div class="panel-heading"> 
            <span class="glyphicon glyphicon-account-balances"></span> Market Trade History <small>(Last 200)</small>
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
              $tradehistory = BaseDonnee::execQuery($bdd, "SELECT * FROM Trade_History WHERE Market = '$pair' ORDER BY Timestamp DESC LIMIT 200");
              foreach ($tradehistory as $atrade) {
                echo '<tr><td>'.date('Y-m-d H:i:s',$atrade["Timestamp"]).'</td>';
                echo '<td>'.$atrade["Type"].'</td>';
                echo '<td>'.number_format(floatval($atrade["Price"]), 8,'.','').'</td>';
                echo '<td>'.number_format(floatval($atrade["Quantity"]), 8,'.','').'</td>';
                $total = number_format(floatval($atrade["Price"] * $atrade["Quantity"]), 8,'.','');
                echo '<td>'.$total.'</td></tr>';
              }
              ?>
            </tbody>

          </table>
        </div>

      </div><!--/panel charts-->
      <?php if(!$guest) include_once($_SERVER['DOCUMENT_ROOT']."/includes/yourtradehistory.php");?>
    </div>

    <div class="clearfix"></div>
  </div><!--/end working-contents--> 
</div><!--/content-->
</div>
</div><!--/row/maincontents-->
<!-- Sidebar start -->
<div class="clearfix"></div>
</div>
<div style="margin-top:100px">
  <div id="chat_div"></div>
  <!-- Footer Start --><?php   include($_SERVER['DOCUMENT_ROOT']."/includes/footer.inc.php");   ?><!-- Footer end -->

  <script>$('.dropdown-toggle').dropdown();</script>
  <div id="pseudo" style="display:none"><?php echo $_SESSION["pseudo"]; ?></div>
  <!-- CHATBOX -->
  <script type="text/javascript" src="/js/myChatbox.js?rev=<?php echo time(); ?>"></script>

  <!-- VIEWNOTIFS -->
  <?php   include($_SERVER['DOCUMENT_ROOT']."/includes/viewNotif.inc.php");   ?>
</div>

<!--Actualise dynamiquement les info dans les champs des formulaire de  sellorder et buyorder !-->
<script type="text/javascript">

function transfertValue(type, tr){
  var tab = [];
  $(tr).find("td").each(function()
  {
    tab.push($(this).text());
  });
  var targettype;
  if(type =="buy") targettype = "sell";
  else targettype = "buy";

  $('#'+targettype+'price').val(tab[0]);
  updateFields($('#'+targettype+'price'));
  $('#'+targettype+'amount').val(tab[1]);
  updateFields( $('#'+targettype+'amount'));


}
function updateAmount(val){
  var fee = parseFloat($('#fee').text());
  var balance = parseFloat($(val).text()); 
  var price = parseFloat($('#buyprice').val());
  console.log(fee);
  console.log(balance);
  console.log(price);
  console.log(balance/(1+fee));
  var resultat = balance / (price * (1+(fee/100)));
  $('#buyamount').val(resultat.toFixed(8));
  $('#buyamount').trigger('change');
  updateFields(val);
}
function post_to_url(path, params, method) {
    method = method || "post"; // Set method to post by default if not specified.

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
      if(params.hasOwnProperty(key)) {
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", key);
        hiddenField.setAttribute("value", params[key]);

        form.appendChild(hiddenField);
      }
    }

    document.body.appendChild(form);
    form.submit();
  }

// Update fields function
function updateFields(value){
  var val = $( value ).attr('id');
  var type = "";
  if(val.indexOf('buy') !== -1) type = 'buy';
  else type = 'sell';

  var amount = parseFloat($('#'+type+'amount').val());
  if ( $.trim(amount) == '' || isNaN(amount)) amount = 0.0;
  var price = parseFloat($('#'+type+'price').val());
  if ( $.trim(price) == '' || isNaN(price)) price = 0.0;
  var fee = parseFloat($('#fee').text());

  var total = (amount * price);
  var totalfee = (total * fee)/100;
  if(type == "buy"){
    var nettotal = parseFloat(total + totalfee);
  }else{
    var nettotal = parseFloat(total - totalfee);
  }

  $('#'+type+'total').html(total.toFixed(8));
  $('#'+type+'fee').html(totalfee.toFixed(8));
  $('#'+type+'nettotal').html(nettotal.toFixed(8));
}

window.pair = $("#pair").text();
// dialogue de confirmation d'un order
$( "#dialog" ).dialog({
  autoOpen: false,
  modal: true,
  resizable : false,
  height: 'auto',
  width: 'auto',
  draggable : false,
  zIndex: 10000,
  open: function( event, ui ) {
    $(".ui-dialog-titlebar").hide();
    var warning = $(this).data('warning');
    console.log(warning);
    var type = $(this).data('type');
    var amount = $(this).data('amount');
    if(isNaN(amount)) amount = 0.0;
    var price = $(this).data('price');
    if(isNaN(price)) price = 0.0;
    var fee = parseFloat($(this).data('fee'));
    var total = parseFloat(amount) * parseFloat(price);
    if(type == "BUY") var nettotal = total+ (total*fee / 100);
    else var nettotal = total- (total*fee / 100);
    nettotal = nettotal.toFixed(8);
    if(isNaN(nettotal)) nettotal = 0.0;
    var coin1 = window.pair.split("/")[0];
    var coin2 = window.pair.split("/")[1];
    var message = "<div style='text-align: center;vertical-align: middle;width:250px;'><p>Please confirm your " + type + " order for</p>"
    message += "<strong><p>"+amount.toFixed(8)+" "+coin1+" </p></strong><p>at a price per "+coin1+" of</p>"
    message += "<strong><p>"+price.toFixed(8)+" "+coin2+"</p></strong></br></strong><p>Net Total with fee:</p><p> <strong>"+nettotal + " "+coin2+"</strong></p></strong></div>";
    if(warning){
      if(type == 'SELL'){
        var lastbuyprice = $(this).data('lastbuyprice');
        message = "<div style='text-align: center;vertical-align: middle;width:250px;'><p style='color:red;'>IMPORTANT PRICE ALERT!</p> <p> Your SELL price of ";
        message += "<strong><p>" + price.toFixed(8)+" "+coin2+"</p></strong><p>is lower than the top current buying price of</p>";
        message += "<p> <strong>"+lastbuyprice.toFixed(8) + " "+coin2+"</strong></p> <p> All trades executes at best possible price </p></div>";
        price = lastbuyprice;      
      }else{
        var lastsellprice = $(this).data('lastsellprice');
        message = "<div style='text-align: center;vertical-align: middle;width:250px;'><p style='color:red;'>IMPORTANT PRICE ALERT!</p> <p> Your BUY price of ";
        message += "<strong><p>" + price.toFixed(8)+" "+coin2+"</p></strong><p>exceed the current top selling price of</p>";
        message += "<p> <strong>"+lastsellprice.toFixed(8) + " "+coin2+"</strong></p> <p> All trades executes at best possible price </p></div>";
        price = lastsellprice;
      }
    }
    $( "#dialog" ).html(message);
  },
  buttons:{
    "send":{
      text:'Submit',
      class:'btn btn-default btn-submit',
      click: function(){
        post_to_url("./verif_trades.php", {pair: window.pair, fee : parseFloat($('#fee').text()), type: $(this).data('type'), amount: $(this).data('amount'), price: $(this).data('price')});
      }
    },
    "cancel":{
      text:'Cancel',
      class:'btn btn-default btn-danger',
      click: function(){
        $(this).closest('.ui-dialog-content').dialog('close'); 
      }
    }
  }
});
//event sur les bouton de confirmation d'order
$( "#makebuyorder" ).click(function() {
  var lastsellprice = parseFloat($("#lastsellprice").text());
  var pricewanted = parseFloat($('#buyprice').val());
  var warning = false;
  if(pricewanted > lastsellprice){
    warning = true;
  }

  $( "#dialog" )
  .data('type', 'BUY')
  .data('amount', parseFloat($('#buyamount').val()))
  .data('price', pricewanted)
  .data('warning', warning)
  .data('lastsellprice', lastsellprice)
  .data('fee', parseFloat($('#fee').text()))
  .dialog( "open" );
});

$( "#makesellorder" ).click(function() {
  var lastbuyprice = parseFloat($("#lastbuyprice").text());
  console.log("lastbuy:  " + lastbuyprice);
  var pricewanted = parseFloat($('#sellprice').val());
  console.log("pricewanted:  " + pricewanted);
  var warning = false;
  if(pricewanted < lastbuyprice){
    warning = true;
  }  

  $( "#dialog" )
  .data('type', 'SELL')
  .data('amount', parseFloat($('#sellamount').val()))
  .data('price', pricewanted)
  .data('warning', warning)
  .data('lastbuyprice', lastbuyprice)
  .data('fee', parseFloat($('#fee').text()))
  .dialog( "open" );
});

</script>

<script>
$.getJSON('<?php echo "/api/api.php?pair=".$coin1."-".$coin2."&range=day";?>', function(data) {


    // split the data set into ohlc and volume
    var price = [],
    volume = [],
    dataLength = data.length;

    for (i = 0; i < dataLength; i++) {

      price.push([
        data[i][0], // the date
        data[i][1], // open
        data[i][2], // high
        data[i][3], // low
        data[i][4] // close
        ]);
      
      volume.push([
        data[i][0], // the date
        data[i][5] // the volume
        ])
    }
    // set the allowed units for data grouping
    var groupingUnits = [['minute',[5, 10, 15, 30]], ['hour',[1, 2, 3, 4, 6, 8, 12]], ['day',[1]], ['week',[1]], ['month',[1, 3, 6]], ['year',null]];

   // create the chart
   $('#tradechart').highcharts('StockChart', {
    title: {
    text: '<?php echo $coin1name." (".$coin1.") Price";?>', //title
    floating: true,
    x: 7,
    y: 20,
    style: {color: '#666666'}
  },
  rangeSelector : {
    buttons : [{
      type : 'hour',
      count : 6,
      text : '6h'
    }, {
      type : 'day',
      count : 1,
      text : '1D'
    }, {
      type : 'week',
      count : 1,
      text : '1W'
    }, {
      type : 'month',
      count : 1,
      text : '1M'
    }, {
      type : 'all',
      count : 1,
      text : 'All'
    }],
    selected : 1,
    inputEnabled : false
  },
  scrollbar: {enabled: false},
  navigator: {enabled: false},
  yAxis: [{lineWidth: 2},{gridLineWidth: 1,gridLineColor:'#eaeaea',opposite: true,offset:27}],
  credits: {
    enabled: false
  }, 
  xAxis : {
    events : {

      setExtremes: function(e) {
        if(typeof(e.rangeSelectorButton)!== 'undefined')
        {
          setExtremes(e);
        }
      }

    },
        minRange: 3600 * 1000 // one hour
      },

      series: [{
        type: 'column',
        data: volume,
        yAxis: 1,
        name : "Volume",
        color: '#ccc'
      },{
        type: 'candlestick',
        marginRight:25,
        groupPadding: '0.1',
        lineColor: '#0072bc', upLineColor: '#0072bc',
        upColor: '#def2ff',
          name : '<?php echo $coin1;?>', //price
          data: price,
          yAxis: 0
        }],
        tooltip: {shared: true},
      });
});

var zoomselected, zoomtext, zoommin, zoommax;

function setExtremes(e) {

  zoomtext = e.rangeSelectorButton.text;
  
  if (zoomtext == '6h')
  {
    zoomselected = 0;
  }
  else if (zoomtext == '1D')
  {
    zoomselected = 1;
  }
  else if (zoomtext == '1W')
  {
    zoomselected = 2;
  }
  else if (zoomtext == '1M')
  {
    zoomselected = 3;
  }
  else if (zoomtext == 'All')
  {
    zoomselected = 4;
  }

  afterSetExtremes();

}

//pour le changement de jeu de données
function afterSetExtremes() {

  var chart = $('#tradechart').highcharts();
  chart.showLoading('Loading data from server...');
  var url;
  
  if (zoomtext == '6h')
  {
    url = '<?php echo "/api/api.php?pair=".$coin1."-".$coin2."&range=hour";?>';
  }
  else if (zoomtext == '1D')
  {
    url = '<?php echo "/api/api.php?pair=".$coin1."-".$coin2."&range=day";?>';
  }
  else if (zoomtext == '1W')
  {
    url = '<?php echo "/api/api.php?pair=".$coin1."-".$coin2."&range=week";?>';
  }
  else if (zoomtext == '1M')
  {
    url = '<?php echo "/api/api.php?pair=".$coin1."-".$coin2."&range=month";?>';
  }
  else 
  {
    url = '<?php echo "/api/api.php?pair=".$coin1."-".$coin2."&range=all";?>';
  }
  
  
  $.getJSON(url, function(data) {

    // split the data set into ohlc and volume
    var price = [],
    volume = [],
    dataLength = data.length;

    for (i = 0; i < dataLength; i++) {

      price.push([
        data[i][0], // the date
        data[i][1], // open
        data[i][2], // high
        data[i][3], // low
        data[i][4] // close
        ]);
      
      volume.push([
        data[i][0], // the date
        data[i][5] // the volume
        ])
    }               

    chart.series[1].setData(price);
    chart.series[0].setData(volume);

    chart.zoomOut();

    chart.hideLoading();

    chart.rangeSelector.buttons[0].setState(0);
    chart.rangeSelector.buttons[1].setState(0);
    chart.rangeSelector.buttons[2].setState(0);
    chart.rangeSelector.buttons[3].setState(0);
    chart.rangeSelector.buttons[4].setState(0);

    chart.rangeSelector.buttons[zoomselected].setState(2);
    
  });

}
</script>
</body>
<!-- web9 -->
</html>

<?php
unset($_SESSION["erreurs"]);
?>

