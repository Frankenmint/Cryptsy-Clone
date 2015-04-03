<?php
//Initialize logging clases
include('logInit.php');
//
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PHP logging class - DEMO log</title>
<link href="/blog/wp-content/themes/altruism/style.css" rel="stylesheet" type="text/css" />
<link href="styles.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
#topH1{
	border-bottom-color:#C7D082;
	border-bottom-style:inset;
	border-bottom-width:5px;
}
p{
	font-size:1.2em;
}
label {
display: block;
width: 150px;
float: left;
margin-bottom: 10px;
}
.btn{
	width:150px;
	height:25px;
}
 
label {
text-align: right;
width: 75px;
padding-right: 20px;
}
 
br {
clear: left;
}
-->
</style>
</head>

<body>
<table width="480" border="0" align="center" cellpadding="0" cellspacing="0" id="page">
  <tr>
    <td><div align="center" id="header"><a href="http://urbanoalvarez.es"><img src="/img/blog/small_logo.jpg" alt="Urbano Alvarez Foundation" width="480" height="75" border="0" /></a></div></td>
  </tr>
  <tr>
    <td><div class="entry">
    	<h1 id="topH1">PHP logging class - DEMO log:</h1>
    	<p>This is a demo log, containing the activity log of <a href="test.php">the test page</a>.</p>
    	<div id="log_header">Activity log for file "<a href="test.php">test.php</a>"</div>
        <div id="log_num">Showing all entries</div>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="16" class="log_top">&nbsp;</td>
            <td width="169" class="log_top"><div align="center">Action/Event</div></td>
            <td width="190" class="log_top"><div align="center">Username</div></td>
            <td width="140" class="log_top"><div align="center">Time/Date</div></td>
            <td width="104" class="log_top"><div align="center">IP used</div></td>
            <td width="139" class="log_top"><div align="center">Priority</div></td>
          </tr>
          <?php
            $log->displayLogs();
          ?>
          <tr>
            <td colspan="6">&nbsp;</td>
          </tr>
        </table>
        <div class="log_nav"><a href="#topH1">Top</a> | <a href="test.php">Go to test page</a></div>
        <p>&nbsp;</p>
        <p align="center">If you liked this, go comment and share it to the <a href="http://urbanoalvarez.es/blog/2008/03/21/php-logging-class/">article's page</a>!</p>
        <p align="center">&nbsp;</p>
    </div></td>
  </tr>
  <tr>
  <td></td>
  </tr>
 </table>
</body>
</html>
