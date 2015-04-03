<?php
//Page accessible seulement par l'administrateur
session_start();
session_regenerate_id();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>
		Crypto Maniac - Vote
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


				<div class="page page-trade">

					<br>

					<div class="panel panel-default">
						<div class="panel-heading"> <span class="glyphicon glyphicon-market-list"></span> Coin Voting
						</div> 
						<div class="tablewrap">


							<p style="padding:10px;">

								We're always looking to add new markets for the best altcoins, and to help us with this we'd like to ask you, our users to vote on what you'd like to see offered at Crypto Maniac.
								<br><br>
								Below is a list of coins that we're considering adding, ordered by the most voted. Please vote for your chosen coin below, due to the recent abuse of the system by bots, only registered users with a trade history are permitted to vote for coins. Every user is limited to 5 (five) votes per hour.
								<br><br>
								We're also accepting payment votes! We've put a lot of time and capital in to making the exchange, and we believe it's only right to let users show their confidence in new coins by allowing them to use their wallets. Each 0.00020000 BTC received will count for 1 vote. All payment votes will be publicly visible, as you can see by clicking the addresses below, and will go directly to improving Crypto Maniac infrastructure. Payment votes are automatically credited every 15 minutes after 1 network confirm.
								<br><br>
								We take the voting winner every Monday evening (UTC), we announce the official closing time earlier in the day. Although the majority of new markets will come from the voting system, we reserve the right to add new markets outside of the system where we feel necessary. Have a new coin that isn't on the list? Please contact us at support [@] crypto-maniac.com with the coin details (name and code) and bitcointalk thread link and we'll get the coin added. <br>
							</p>
							<?php 
							if(isset($_SESSION["notice"])){
								echo '<p style = "color:green; text-align:center;">'.$_SESSION["notice"].'</p>'; 
							}
							if(isset($_SESSION["error"])){
								echo '<p style = "color:red; text-align:center;">'.$_SESSION["error"].'</p>'; 
							}
							?>
							<table cellpadding="0" cellspacing="0" border="0" class="table table-striped">
								<thead>
									<tr>
										<th>Code</th>
										<th>Name</th>
										<th>BTC Payment Address</th>
										<th>Votes</th>
										<th></th>

									</tr>
								</thead>
								<tbody>
									<form action="./verif_vote.php" method = "POST">
										<input type="hidden" name="makeVote">
										<?php

										$sql = BaseDonnee::execQuery($bdd, "SELECT * FROM Votes WHERE Actif = '1' ORDER BY Total DESC");
										foreach ($sql as $vote) {
											echo '<tr style="height:40px">
											<td>'.$vote["Acronymn"].'</td>
											<td>'.$vote["Name"].'</td>
											<td><a ';
											echo "href='https://blockchain.info/address/".$vote["Address"]."?filter=2'>".$vote["Address"]."</a></td>";
											echo ' 
											<td align="center">'.$vote["Total"].'</td>
											<td align="center">
											<p class="submit-holder" style="margin:0px;">
											<input name="'.$vote["Acronymn"].'" type="submit" class="btn btn-default btn-success" value="Vote for '.$vote["Acronymn"].'" />
											</p>
											</td>
											</tr>';
										}
										?>
									</tbody>

								</table>
							</form>

							<span class="clearFix">&nbsp;</span>
						</div><!-- end of div.box-container -->
					</div><!-- end of div.box -->

				</div>

			</div><!--/end working-contents--> 
		</div><!--/content-->


	</div><!--/row/maincontents-->


</div> <!-- /container -->

<div class="clearfix"></div>
<div id="chat_div"></div>
<!-- Footer Start --><?php   include($_SERVER['DOCUMENT_ROOT']."/includes/footer.inc.php");   ?><!-- Footer end -->

<script>$('.dropdown-toggle').dropdown();</script>
<div id="pseudo" style="display:none"><?php echo $_SESSION["pseudo"]; ?></div>
<!-- CHATBOX -->
<script type="text/javascript" src="/js/myChatbox.js?rev=<?php echo time(); ?>"></script>

<!-- VIEWNOTIFS -->
<?php   include($_SERVER['DOCUMENT_ROOT']."/includes/viewNotif.inc.php");   ?>

</body>
<!-- web9 -->
</html>

<?php 
  //Par sécurité on supprime directement les variable session quand on en a plus besoin
unset($_SESSION["error"]); 
unset($_SESSION["notice"]); 
?> 
