<script>
<?php 
if(isset($_SESSION["pseudo"])){
	$username = $_SESSION["pseudo"];
	$mynotifs = BaseDonnee::execQuery($bdd, "SELECT * FROM Notifications WHERE Username = '$username' AND Viewed = 0");
	if(!empty($mynotifs)){
		foreach ($mynotifs as $key => $notif) {
			echo "var n".$key." = noty({type: '".$notif["Type"]."', text: '".$notif["Text"]."'});";
			BaseDonnee::setNotification($bdd, intval($notif["id"]));
		}
	}
}
?>
</script>

