<?php
//Initialize logging clases
include('logInit.php');
//
//Process the forms in this page:
//
// Login form:
if(isset($_POST['subLogin'])){ //Login form is sent
	if($_POST['username'] == 'demo' && $_POST['password'] == 'pass'){ //Login succesful
		//login succesful - Log it:
		$log->logg('login','Login allowed','low','blue'); //pretend that the page is login.php, the last parameter "mail" is set to default (no)
		//store message:
		$_SESSION['login_msg'] = 'Login successful and logged';
	}else{ //Login unsuccessful
		//log the attempt
		$log->logg('login','Login denied','high','red'); //pretend that the page is login.php, the last parameter "mail" is set to default (no)
		//store message:
		$_SESSION['login_msg'] = 'Login UNsuccessful and logged';
	}
}
// Edit form:
$_SESSION['defaultText'] = 'This is the default text';
if(isset($_POST['subEdit'])){ //Edit form is sent
	//store new text in session variable:
	$_SESSION['defaultText'] = $database->clean($_POST['editField']);
	//log the change:
	$log->logg('edit','Text was edited','medium','yellow'); //pretend that the page is login.php, the last parameter "mail" is set to default (no)
	//store the message:
	$_SESSION['edit_msg'] = 'Text changed';
}
// Contact form:
if(isset($_POST['subContact'])){ //Contact form sent:
	if($database->clean($_POST['name']) && $database->clean($_POST['message'])){ //fields not empty
		//here I would send the email:
		// mail('email_to','subject','body');
		//
		// Log the contact:
		$log->logg('contact','New message','low','green'); //pretend that the page is login.php, the last parameter "mail" is set to default (no)
		//store the message:
		$_SESSION['contact_msg'] = 'New message was logged';
	}else{
		//store the message:
		$_SESSION['contact_msg'] = 'Some fields were empty';
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DEMO - Logging PHP class:</title>
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
    	<h1 id="topH1">PHP logging class - DEMO page:</h1>
    	<p>So in case you don't know what this is about, you can read <a href="http://urbanoalvarez.es/blog/2008/03/21/php-logging-class/">my article about it</a>. This is a PHP class that easily logs to a database table all activity you want.</p>
    	<p>There are two files in this demo, this page, and the <a href="log.php">log page</a>. In this page there are several &quot;common&quot; actions you would find in a website, their purpose is to let you see how each action is logged.</p>
    	<h2>User login:</h2>
    	<p>This is a ver simple user login, there is only one username and password, and all others will be considered &quot;denied attempts&quot;.</p>
        <pre>
        Login data:
        Username: demo
        Password: pass
        </pre>
        <?php $log->displayMsg('login'); ?>
        <form id="loginForm" name="loginForm" method="post" action="test.php">
        <input name="subLogin" type="hidden" value="true" />
        <label for="user">Username:</label>
        <input name="username" type="text" size="40" maxlength="40" />
        <br />
        <label for="password">Password:</label>
        <input name="password" type="password" size="40" maxlength="40" />
        <br />
        <input name="loginBtn" type="submit" value="Login" class="btn" />
                        </form>
        <p></p>
        <h2>Edit data on a webpage:</h2>
        <p>In case your website supports page edition (With some sort of CMS) you can install logging to see who and when was edited:</p>
        <pre>
        For the example the following text is stored in a session variable which you can edit. Every change is logged
        <?php echo $_SESSION['defaultText']; ?>
        </pre>
        <?php $log->displayMsg('edit'); ?>
        <p><form action="test.php" id="editForm" name="editForm" method="post">
        <input name="subEdit" type="hidden" value="true" />
        <label for="editField">Change text:</label>
        <input name="editField" type="text" value="<?php echo $_SESSION['defaultText']; ?>" size="70" maxlength="70" />
        <br />
        <input name="editBtn" type="submit" value="Change" class="btn" />
        </form></p>
        <h2>Contact form:</h2>
        <p>If you have contact forms in your website, you can install logging to see who contacted you, at what time, and with what ip.</p>
        <?php $log->displayMsg('contact'); ?>
        <form id="contactForm" name="contactForm" method="post" action="test.php">
        <input name="subContact" type="hidden" value="true" />
          <label for="name">Name:</label>
          <input type="text" name="name" id="name" />
          <br />
          <label for="message">Message:</label>
          <textarea name="message" id="message" cols="45" rows="5"></textarea>
          <br />
          <input name="Send" type="submit" value="Send" class="btn" />
          <br />
          <small>Note: The contact form doesn't actually send any email. It is only used to test the logging class.</small>
        </form>
        <p>&nbsp;</p>
        <h2>Now what?</h2>
        <p>In case you didn't yet, you can go see the <a href="log.php">log page</a>, with all log entries since the last log clean up (usually done when it reaches 100 or more entries), or you can go to the original article to post your opinion there!</p>
    </div></td>
  </tr>
  <tr>
  <td></td>
  </tr>
 </table>
</body>
</html>
