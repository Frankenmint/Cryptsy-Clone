<?php
require_once($_SERVER['DOCUMENT_ROOT']."/classes/BaseDonnee.class.php");
session_start();
session_regenerate_id();

// contiendra les erreurs rencontrés pour chaque champs afin de pouvoir les afficher facilement au bon endroit
$erreurs = array(  "pseudo" => "", 
    "mail" => "",
    "mdp" => "", 
    "captcha" => "", 
    "general" => ""); 

$erreurBool = false; // Vaut true si des erreurs ont été rencontrés

$_SESSION["champs_inscription"] = $_POST;

if(isset ($_POST['pseudo'], $_POST['mail'], $_POST['pays'], $_POST['mdp1'], $_POST['mdp2'], 
    $_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field'])) {

    $pseudo = $_POST['pseudo'];
$mail = $_POST['mail'];
$pays = $_POST['pays'];
$mdp1 = $_POST['mdp1'];
$mdp2 = $_POST['mdp2'];
$captcha_challenge = $_POST['recaptcha_challenge_field'];
$captcha_response = $_POST['recaptcha_response_field'];


/* VERIFICATIONS */

//Verif allow register
$handle = file("../admin/allow_register.txt");
var_dump($handle);
if ($handle != false){
    $string = preg_replace('/\s+/', '', $handle[0]);
    $allow = explode("=", $string);
    var_dump($allow); 
    if(($allow[0] != "lock_register") || ($allow[1] != "true")){
        $erreurBool = true;
    }
}else{
       $erreurBool = true;
}

if($erreurBool){
    $erreurs["general"] = "Sorry, registration are currently not allowed";
    $_SESSION['errors'] = $erreurs;
    header("Location: ./register.php");
    exit();
}

if(empty($pseudo) || empty($mail) || empty($mdp1) || empty($mdp2) || 
   empty($captcha_challenge) || empty($captcha_response)){
    $erreurBool = true;
$erreurs["general"] .= "Some fields are empty<br/>";
}else{
    $bdd = BaseDonnee::connexion();

        // Verif pseudo (Contient seulement des lettres et chiffres et n'existe pas déja)
    if (!(ctype_alnum($pseudo))) {
        $erreurBool = true;
        $erreurs["pseudo"] .= "Username should contains only alphanumeric characters <br/>";
    }
    if (strlen($pseudo) < 3) {
        $erreurBool = true;
        $erreurs["pseudo"] .= "Username should contains at least 3 characters <br/>";
    }
    if (strlen($pseudo) > 9) {
        $erreurBool = true;
        $erreurs["pseudo"] .= "Username is too long <br/>";
    }
    if(BaseDonnee::pseudoExiste($bdd, $pseudo)){
        $erreurBool = true;
        $erreurs["pseudo"] .= "This username already exists<br/>";
    }

        // Verif mail
    if(!(preg_match('#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#', $mail))) {
        $erreurBool = true;
        $erreurs["mail"] .= "Invalid email<br/>";
    }
    if(!(BaseDonnee::mailExiste($bdd, $mail))){
        $erreurBool = true;
        $erreurs["mail"] .= "This email already exists<br/>";
    }

        //Verif mdp (8 caracteres ou plus + 1 majuscule + 1 minuscule +  1 nombre/caractere spécial)
    if($mdp1 != $mdp2){
        $erreurBool = true;
        $erreurs["mdp"] .= "Password confirmation error<br/>";
    }else{
        $longueur = strlen($mdp1);

        if($longueur < 8){
            $erreurBool = true;
            $erreurs["mdp"] .= "Password should have at least 8 characters <br/>";
        }else{
            $maj = $min = $autre = 0;
            for($i = 0; $i < $longueur; $i++){
                $lettre = $mdp1[$i];
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
        }
    }   
}

        //Verif recaptcha
$private_key = '6LfGCO8SAAAAAPEa2ZDgPO-io0webUcWT6atka1Y';
$ip_client = getenv('HTTP_CLIENT_IP')?:
getenv('HTTP_X_FORWARDED_FOR')?:
getenv('HTTP_X_FORWARDED')?:
getenv('HTTP_FORWARDED_FOR')?:
getenv('HTTP_FORWARDED')?:
getenv('REMOTE_ADDR');

$url = "http://www.google.com/recaptcha/api/verify";
$data = array('privatekey' => $private_key, 
    'remoteip' => $ip_client, 
    'challenge' => $captcha_challenge,
    'response' => $captcha_response);

        // use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
        )
    );
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if (strpos($result, 'true') === false){
    $erreurBool = true;
    $erreurs["captcha"] .= "Recaptcha verification error<br/>";
}
}
}else{
    $erreurs["general"] .= "A field is empty<br/>";
}

if(!$erreurBool){ // Si aucune erreur, on fait l'inscription
try{
    $registerkey = sha1(mt_rand(10000,99999).time().$mail);
    $rep = BaseDonnee::userInscription($bdd, $pseudo, $mail, $mdp1, $pays, $registerkey);
}catch(Exception $e){
    $erreurs["general"] .= "A field is too long<br/>";
    header("Location: ./register.php");
    exit();
}
    // Maintenant on vérifie l'état de l'inscription
    if( $rep ){ //Si l'inscription a réussi 
        $link = "http://www.crypto-maniac.com/users/register.php?usr=".$pseudo."&key=".$registerkey;
            // Sujet
        $subject = 'Crypto-maniac - Account activation';

            // message
        $message = '
        <html>
        <head>
        <title>Crypto-maniac - Account activation</title>
        </head>
        <body>
        <h3>Hello '.$pseudo.'</h3>
        <p> Thank you for your register request on crypto-maniac !</p>
        <p> Please click on this <a href="'.$link.'">  link </a> for activate your account</p>
        </body>
        </html>
        ';

        // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            // En-têtes additionnels
        $headers .= 'To: '.$username.' <'.$mail.'>' . "\r\n";
        $headers .= 'From: Crypto-maniac <register@crypto-maniac.com>' . "\r\n";

         // Envoi
        mail($mail, $subject, $message, $headers);
        
        // On créé une balance pour l'user dans chaque currency
        $sql = BaseDonnee::execQuery($bdd, "SELECT * FROM Wallets");
        foreach ($sql as $wallet) {
            $acronymn = $wallet["Acronymn"];
            $walletid = BaseDonnee::execQuery($bdd, "SELECT Id FROM Wallets WHERE Acronymn = '$acronymn'")[0]["Id"];
            BaseDonnee::addBalance($bdd, $pseudo, $acronymn, $walletid);
        }
        unset($_SESSION["champs_inscription"]); //on détruit les champs qui avaient été save dans $_SESSION
        unset( $_SESSION['errors']);
		$_SESSION['just_registered'] = "ok";
        header("Location: ./login.php"); // redirection vers la page de login
        exit();
    }
    else{
        $erreurBool = true;
        $erreurs["general"] .= "Database connection error<br/>";
    }
}else{ //On stock les erreurs dans la variable POST pour les afficher sur la page register.php
    $_SESSION['errors'] = $erreurs;
    header("Location: ./register.php");
    exit();
}
?>
