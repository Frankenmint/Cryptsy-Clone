<?php
require_once($_SERVER['DOCUMENT_ROOT']."/classes/BaseDonnee.class.php");

session_start();
session_regenerate_id();

$bdd = BaseDonnee::connexion();
$res = BaseDonnee::getByUsername($bdd, $_SESSION["pseudo"]);

$erreurBool = false;
$erreurs = array("mail" => "",
                            "mdp" => ""); 

$updated = array("mail" => "",
                            "mdp" => ""); 

//L'user veut changer de Mail
if(isset($_POST["changemail"]) && ($_POST["changemail"] != $res["Email"])){
	if(!(BaseDonnee::mailExiste($bdd, $_POST["changemail"]))){
	    $erreurBool = true;
	    $erreurs["mail"] .= "This email already exists<br/>";
	}else{
		if(!(preg_match('#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#', $_POST["changemail"]))) {
			$erreurBool = true;
			$erreurs["mail"] .= "Please type a valid email <br/>";
		}else{
			$success = BaseDonnee::updateX($bdd, $_SESSION["pseudo"], "Email", $_POST["changemail"]);
			if(! $success){
				$erreurBool = true;
				$erreurs["mail"] .= "Please type another email<br/>";
			}else{
				$updated["mail"] = "Email updated <br/>";
			}	
		}
	}
}

//L'user veut changer de Mdp
if(isset($_POST["nowmdp"], $_POST["newmdp"], $_POST["newmdpconfirm"])){
	$success = BaseDonnee::mdpValide($bdd, $_SESSION["pseudo"], $_POST["nowmdp"]);
	if($success){
		if($_POST["newmdp"] != $_POST["newmdpconfirm"]){
		            $erreurBool = true;
		            $erreurs["mdp"] .= "Password confirmation error<br/>";
	      	}else{
		            $longueur = strlen($_POST["newmdp"]);

		            if($longueur < 8){
		                $erreurBool = true;
		                $erreurs["mdp"] .= "Password should have at least 8 characters <br/>";
		            }else{
		                $maj = $min = $autre = 0;
		                for($i = 0; $i < $longueur; $i++){
		                    $lettre = $_POST["newmdp"][$i];
		                    if ($lettre>='a' && $lettre<='z'){
		                        $min++;
		                    }
		                    else if ($lettre>='A' && $lettre <='Z'){
		                         $maj++;
		                    }
		                    else{
		                        $autre++;
		                    }
		                }

		                if($maj < 1 || $min < 1 || $autre < 1){
		                    $erreurBool = true;
		                    $erreurs["mdp"] .= "Please add";
		                    if($maj < 1)  $erreurs["mdp"] .= " 1 capital letter,";
		                    if($min < 1)  $erreurs["mdp"] .= " 1 lower case letter,";
		                    if($autre < 1)  $erreurs["mdp"] .= " 1 number or special character,";
		                    $erreurs["mdp"] = substr( $erreurs["mdp"], 0, -1);
		                    $erreurs["mdp"] .= " to you password <br/>";
		                }else{ //SI le format du mdp est ok
		                	if(empty($erreurs["mdp"])){
					$success = BaseDonnee::updateX($bdd, $_SESSION["pseudo"], "Password", $_POST["newmdp"]);
					if(! $success){
						$erreurBool = true;
						$erreurs["mdp"] .= "Please type another password<br/>";
					}else{
						$updated["mdp"] = "Password updated <br/>";
					}
				}
		                }
		            }   
		        }
		}
	
}

//Test sur les erreurs
$_SESSION["errors"] = $erreurs;
$_SESSION["updated"] = $updated;
if($_SESSION["pseudo"] == "admin"){
	header("Location: /admin/admin.php");
	exit();
}else{
	header("Location: ./settings.php");
	exit();
}


?>
