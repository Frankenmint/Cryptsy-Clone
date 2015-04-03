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

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>
    Crypto Maniac - Users Stats
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

	
	
	<div class="working-contents">
        <div class="page page-settings" style="float:left;">

          <br>

          <div class="panel panel-default panel-change-contact-info">
		  
            <div class="panel-heading"> 
			<span class="glyphicon glyphicon-transfer"></span> Users Stats
			<a href="./admin.php">Admin</a>
			<a href="./addwallet.php">Add Wallet</a>
            <a href="./activewallet.php">Active Wallet</a>
			<a href="./activemarket.php">Active Market</a>
			<a href="./activepair.php">Active Pair</a>
			<a href="./earning.php">Earning</a>
			
             </div> 
            <div class="panel-body">
			
 
<link rel="stylesheet" href="/js/jqx/jqx.base.css" type="text/css" />
<script type="text/javascript" src="/js/jqx/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="/js/jqx/jqxcore.js"></script>
<script type="text/javascript" src="/js/jqx/jqxchart.js"></script>	
<script type="text/javascript" src="/js/jqx/jqxdata.js"></script>
				
				<script type="text/javascript">
$(document).ready(function () {
var source =
{
datatype: "json",
datafields: [
{ name: 'Month'},
{ name: 'Users'}
],
url: 'ajax-userstats.php'
};
var dataAdapter = new $.jqx.dataAdapter(source,
{
autoBind: true,
async: false,
downloadComplete: function () { },
loadComplete: function () { },
loadError: function () { }
});
// prepare jqxChart settings
var settings = {
title: "Orders by Date",
showLegend: true,
padding: { left: 5, top: 5, right: 5, bottom: 5 },
titlePadding: { left: 90, top: 0, right: 0, bottom: 10 },
source: dataAdapter,
categoryAxis:
{
text: 'Category Axis',
textRotationAngle: 0,
dataField: 'Month',
showTickMarks: true,
tickMarksInterval: Math.round(dataAdapter.records.length / 6),
tickMarksColor: '#888888',
unitInterval: Math.round(dataAdapter.records.length / 6),
showGridLines: true,
gridLinesInterval: Math.round(dataAdapter.records.length / 3),
gridLinesColor: '#888888',
axisSize: 'auto'
},
colorScheme: 'scheme05',
seriesGroups:
[
{
type: 'line',
valueAxis:
{
displayValueAxis: true,
description: 'Users',
//descriptionClass: 'css-class-name',
axisSize: 'auto',
tickMarksColor: '#888888',
unitInterval: 20,
minValue: 0,
maxValue: 100
},
series: [
{ dataField: 'Users', displayText: 'Users' }
]
}
]
};
// setup the chart
$('#jqxChart').jqxChart(settings);
});
</script>
<div id="jqxChart" style="border: 1px solid #555; height: 200px;">		
</div>	
<!------------------------------------start Pierre Analitic End---------------------------------------------------------------------------------->						
<!------------------------------------start Pierre Analitic End---------------------------------------------------------------------------------->	
<!------------------------------------start Pierre Analitic End---------------------------------------------------------------------------------->					

             </table>
           </div>
           <div class="col-xs-6">
                

                
           </div>
         </div>

         </div>
       </div>  <!--/panel list-->
	   




</div><!--/end working-contents--> 
</div><!--/content-->


</div><!--/row/maincontents-->


</div> <!-- /container -->

<div class="clearfix"></div>

 


</body>
<!-- web9 -->
</html>