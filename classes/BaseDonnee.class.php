<?php

/**
 * La classe BaseDonnee gérera les connexions/requêtes à la bdd. On se basera sur la pdo pour les effectués
 *
 */

class BaseDonnee
{
    /**
     * Se connecte à la bdd, la gestion d'erreur devra s'effectuer lors de l'appel de cette fonction
     * Pour éviter la diffusion du mdp en cas d'erreur, on inclut la gestion d'erreur avec try{}catch{}
     * 
     */
    var $PREFIXE_SHA1 =  'p8%B;Qdf78';

    static function connexion(){
        try{

           //LOCAL
            $dsn = "mysql:host=localhost;dbname=crypto";
            $usr = "root";
            $pass = "IOJIOjoijipodfhzeoufhozeifh584848";

            $options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            $bdd = new PDO($dsn, $usr, $pass);
            $bdd->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $bdd;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    
    /**
     * pseudoExistePred($bdd, $pseudo) => vérifie que le pseudo est présent dans la bdd
     * On commence par faire une requête dans la bdd en cherchant toute les lignes dans la table "membre" ou on trouve le
     * pseudo. Puis on compte les résultats, qui vaudra 0 ou 1.
     * 
     */
    
    static function pseudoExiste($bdd, $pseudo){

        try{

            $req = $bdd->prepare("SELECT * FROM Users WHERE Username = :pseudo");
            $req->bindValue(":pseudo", $pseudo, PDO::PARAM_STR);
            
            $req->execute();
            $result = $req->rowCount();
            
            $req->closeCursor();
            
            return $result;
        }catch (Exception $e){
            echo $e->getMessage();
        }
    }
    
    /**
     * Update le champ X à Y de la table $pseudo
     */  
    
    static function updateX($bdd, $pseudo, $X, $Y){
        if($X == "Password") $Y = sha1($PREFIXE_SHA1.$Y);
        $req = $bdd->prepare("UPDATE Users SET ".$X." = :y WHERE Username=:pseudo");
        $req->bindValue(":y", $Y, PDO::PARAM_STR);
        $req->bindValue(":pseudo", $pseudo, PDO::PARAM_STR);
        $req->execute();
        $req->closeCursor();
        if($req->rowCount() == 0){
            return false;
        }
        return true;
    }
    

    /**
     * mdpValide($bdd, $pseudo, $mdp) => Vérifie que le mot de passe est bon 
     * 
     */  
    
    static function mdpValide($bdd, $pseudo, $mdp){
        $mdp_crypted = sha1($PREFIXE_SHA1.$mdp);
        $req = $bdd->prepare("SELECT Password FROM Users WHERE Username = :pseudo AND Password = :mdp");
        $req->bindValue(":pseudo", $pseudo, PDO::PARAM_STR);
        $req->bindValue(":mdp", $mdp_crypted, PDO::PARAM_STR);
        
        $req->execute();
        $req->closeCursor();
        
        return $req->rowCount();
    }

    /**
     * mailExistePred($bdd, $mail) => Vérifie dans la bdd si le mail existe, renvoit true si un user a déja ce mail, false sinon
     *
     * Cette fonction sera utile lors de l'inscription pour vérifier que l'user n'est pas déja inscrit
     *
     */

    static function mailExiste($bdd, $mail){
        $req = $bdd->prepare("SELECT COUNT(*) FROM Users WHERE Email = :mail "); // on vérifie si le mail est disponible
        $req->bindValue(":mail", $mail, PDO::PARAM_STR);

        $req->execute();
        $mailDispo = ($req->fetchColumn() == 0)? true : false;

        $req->CloseCursor();

        return $mailDispo;
    }

    /**
     * getByUsername($bdd, $pseudo) => renvoi un tableau associatif avec tous les renseignements pour un pseudo
     * 
     */  
    
    static function getByUsername($bdd, $pseudo){
        $req = $bdd->prepare("SELECT * FROM Users WHERE Username = :pseudo");
        $req->bindValue(":pseudo", $pseudo, PDO::PARAM_STR);
        $req->execute();
        $result = $req->fetch(PDO::FETCH_ASSOC);
        $req->closeCursor();
        
        return $result;
    }

    /**
    *Cette méthode inscrit le client dans la base de donnée
    *Elle retourne true si l'inscription a réussie, false sinon.
    */
    static function userInscription($bdd, $pseudo, $mail, $mdp, $pays, $key){
        try{
            $mdp_crypted = sha1($PREFIXE_SHA1.$mdp);
            $req = $bdd->prepare("INSERT INTO Users (Username, Password, Email, Country, SignUpDate, LastSignIn, KeyActiveAccount) VALUES ( :pseudo, :mdp, :mail, :pays, NOW(), NOW(), :key )");
            $req->bindParam(":pseudo", $pseudo, PDO::PARAM_STR, 255);
            $req->bindParam(":mail", $mail, PDO::PARAM_STR, 255);
            $req->bindParam(":mdp", $mdp_crypted, PDO::PARAM_STR, 255);
            $req->bindParam(":pays", $pays, PDO::PARAM_STR, 255);
            $req->bindParam(":key", $key, PDO::PARAM_STR);
            $req->execute();
            $req->closeCursor();
            return $req->rowCount();
        } catch( PDOEXception $e ) {
           echo $e->getMessage(); // display bdd error
           exit();
       }
       
   }

   static function getX($bdd, $table, $X){
    $req = $bdd->prepare("SELECT * FROM ".$table);
    $req->execute();
    $result = $req->fetchAll(PDO::FETCH_ASSOC);
    $req->closeCursor();
    
    return $result;
}

static function execQuery($bdd, $query){
    try{
        $req = $bdd->prepare($query);
        $req->execute();
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $result;
    } catch( PDOEXception $e ) {
           echo $e->getMessage(); // display bdd error
           exit();
       }
   }

   static function getWallets($bdd){
    $req = $bdd->prepare("SELECT * FROM Wallets");
    $req->execute();
    $result = $req->fetchAll(PDO::FETCH_ASSOC);
    $req->closeCursor();
    
    return $result;
}

static function addWallet($bdd, $name, $acronymn, $ip, $username, $password, $port){
    try{
        $req = $bdd->prepare("INSERT INTO Wallets (Name, Acronymn, Wallet_IP, Wallet_Username, Wallet_Password, Wallet_Port, disabled) VALUES (:name, :acronymn, :ip, :username, :password, :port, 1)");
        $req->bindParam(":name", $name, PDO::PARAM_STR, 255);
        $req->bindParam(":acronymn", $acronymn, PDO::PARAM_STR, 255);
        $req->bindParam(":ip", $ip, PDO::PARAM_STR, 255);
        $req->bindParam(":username", $username, PDO::PARAM_STR, 255);
        $req->bindParam(":password", $password, PDO::PARAM_STR, 255);
        $req->bindParam(":port", $port, PDO::PARAM_STR, 255);
        $req->execute();
        $req->closeCursor();
        return $req->rowCount();
    }catch( PDOEXception $e ){
           echo $e->getMessage(); // display bdd error
           
       }
   }

   static function addBalance($bdd, $account, $coin, $walletid){
    try{
        $req = $bdd->prepare("INSERT INTO balances (Account, Amount, Coin, Helding, Wallet_ID) VALUES (:account, '0.0', :coin, 0, :walletid)");
        $req->bindParam(":account", $account, PDO::PARAM_STR, 255);
        $req->bindParam(":coin", $coin, PDO::PARAM_STR, 255);
        $req->bindParam(":walletid", $walletid, PDO::PARAM_STR, 255);
        $req->execute();
        $req->closeCursor();
        return $req->rowCount();
    }catch( PDOEXception $e ){
           echo $e->getMessage(); // display bdd error
           
       }
   }

   static function setHelding($bdd, $account, $coin, $value){
    try{
        $req = $bdd->prepare("UPDATE balances SET Helding = :value WHERE Account=:account AND Coin = :coin");
        $req->bindValue(":value", $value, PDO::PARAM_STR);
        $req->bindValue(":account", $account, PDO::PARAM_STR);
        $req->bindValue(":coin", $coin, PDO::PARAM_STR);
        $req->execute();
        $req->closeCursor();
        if($req->rowCount() == 0){
            return false;
        }
        return true;
    }catch( PDOEXception $e ){
           echo $e->getMessage(); // display bdd error
           
       }
   }

   static function addWithdrawal($bdd, $user, $amount, $address, $coin){
    try{
        $req = $bdd->prepare("INSERT INTO Withdraw_History (Timestamp, User, Amount, Address, Coin) VALUES (NOW(), :user, :amount, :address, :coin)");
        $req->bindParam(":user", $user, PDO::PARAM_STR, 255);
        $req->bindParam(":amount", $amount, PDO::PARAM_STR, 255);
        $req->bindParam(":address", $address, PDO::PARAM_STR, 255);
        $req->bindParam(":coin", $coin, PDO::PARAM_STR, 255);
        $req->execute();
        $req->closeCursor();
        return $req->rowCount();
    }catch( PDOEXception $e ){
           echo $e->getMessage(); // display bdd error
           
       }
   }

   static function addDeposit($bdd, $user, $amount, $paid, $transaction, $coin, $confirmations){
    try{
        $req = $bdd->prepare("INSERT INTO deposits (Timestamp, Transaction_Id, Amount, Coin, Paid, Account, Confirmations) VALUES (:time, :transaction, :amount, :coin, :paid, :user, :confirmations)");
        $req->bindParam(":time", time(), PDO::PARAM_STR, 255);
        $req->bindParam(":user", $user, PDO::PARAM_STR, 255);
        $req->bindParam(":amount", $amount, PDO::PARAM_STR, 255);
        $req->bindParam(":paid", $paid, PDO::PARAM_STR, 255);
        $req->bindParam(":transaction", $transaction, PDO::PARAM_STR, 255);
        $req->bindParam(":coin", $coin, PDO::PARAM_STR, 255);
        $req->bindParam(":confirmations", $confirmations, PDO::PARAM_STR, 255);
        $req->execute();
        $req->closeCursor();

        //Envoi d'une notification
        $text = "You just made a deposit of ".$amount." ".$coin.". Please wait it reach 4 confirmations to use it";
        self::addNotification($bdd, $user, "information", $text);

        return $req->rowCount();
    }catch( PDOEXception $e ){
           echo $e->getMessage(); // display bdd error
           
       }
   }

   static function setDeposit($bdd, $id, $paid, $confirmations){
    $req = $bdd->prepare("UPDATE deposits SET Paid = :paid, Confirmations = :confirmations WHERE Id=:id");
    $req->bindValue(":paid", $paid, PDO::PARAM_STR);
    $req->bindValue(":confirmations", $confirmations, PDO::PARAM_STR);
    $req->bindValue(":id", $id, PDO::PARAM_STR);
    $req->execute();
    $req->closeCursor();
    if($req->rowCount() == 0){
        return false;
    }
    return true;
}

static function addPair($bdd, $pair){
    try{
        $req = $bdd->prepare("INSERT INTO Markets (Pair, disabled, Fee) VALUES (:pair, 1, 0.4)");
        $req->bindParam(":pair", $pair, PDO::PARAM_STR, 255);
        $req->execute();
        $req->closeCursor();
        return $req->rowCount();
    }catch( PDOEXception $e ){
           echo $e->getMessage(); // display bdd error
           
       }
   }

   static function addTrade($bdd, $type, $username, $amount, $value, $pair, $fee, $total){
    try{
        $req = $bdd->prepare("INSERT INTO Trades (Date, Pair, Amount, Value, Username, Type, Finished, Fee, Total) VALUES (:time, :pair, :amount, :value, :username, :type, 0, :fee, :total)");
        $req->bindParam(":time", time(), PDO::PARAM_STR, 255);
        $req->bindParam(":pair", $pair, PDO::PARAM_STR, 255);
        $req->bindParam(":amount", $amount, PDO::PARAM_STR, 255);
        $req->bindParam(":value", $value, PDO::PARAM_STR, 255);
        $req->bindParam(":username", $username, PDO::PARAM_STR, 255);
        $req->bindParam(":type", $type, PDO::PARAM_STR, 255);
        $req->bindParam(":fee", $fee, PDO::PARAM_STR, 255);
        $req->bindParam(":total", $total, PDO::PARAM_STR, 255);
        $req->execute();
        $req->closeCursor();
		
		
		//PIERRE////Envoi d'une notification
		
        //$text = "Your Sell order has been placed for ".$amount." ".$coin.". @ ".$amount." BTC each ";
        //self::addNotification($bdd, $user, "information", $text);
		//PIERE END//
		
		
        return $req->rowCount();
    }catch( PDOEXception $e ){
           echo $e->getMessage(); // display bdd error
           
       }
   }

   static function addTradeHistory($bdd, $market, $type, $price, $quantity, $buyer, $seller){
    try{
        $req = $bdd->prepare("INSERT INTO Trade_History (Market, Type, Price, Quantity, Timestamp, Buyer, Seller) VALUES (:market, :type, :price, :quantity, :time, :buyer, :seller)");
        $req->bindParam(":market", $market, PDO::PARAM_STR, 255);
        $req->bindParam(":type", $type, PDO::PARAM_STR, 255);
        $req->bindParam(":price", $price, PDO::PARAM_STR, 255);
        $req->bindParam(":quantity", $quantity, PDO::PARAM_STR, 255);
        $req->bindParam(":time", time(), PDO::PARAM_STR, 255);
        $req->bindParam(":buyer", $buyer, PDO::PARAM_STR, 255);
        $req->bindParam(":seller", $seller, PDO::PARAM_STR, 255);
        $req->execute();
        $req->closeCursor();

        //Notifications
        $coin1 = explode("/", $market)[0];
        $coin2 = explode("/", $market)[1];

        //Envoi d'une notification au buyer
        $textbuyer = "You just bought ".$quantity." ".$coin1." at a price of ".$price." ".$coin2;
        self::addNotification($bdd, $buyer, "information", $textbuyer);
        //Envoi d'une notification au seller
        $textseller = "You just sold ".$quantity." ".$coin1." at a price of ".$price." ".$coin2;
        self::addNotification($bdd, $seller, "information", $textseller);

        return $req->rowCount();
    }catch( Exception $e ){
           echo $e->getMessage(); // display bdd error
           
       }
   }

   static function deleteTrade($bdd, $id){
    try{
        $req = $bdd->prepare("DELETE FROM Trades WHERE Id = :id");
        $req->bindValue(":id", $id, PDO::PARAM_INT);
        $req->execute();
        $req->closeCursor();
    }catch( PDOEXception $e ){
           echo $e->getMessage(); // display bdd error
           
       }
   }

   static function setTradeAmount($bdd, $id, $amount){
    $req = $bdd->prepare("UPDATE Trades SET Amount = :amount WHERE Id=:id");
    $req->bindValue(":amount", $amount, PDO::PARAM_STR);
    $req->bindValue(":id", $id, PDO::PARAM_STR);
    $req->execute();
    $req->closeCursor();
    if($req->rowCount() == 0){
        return false;
    }
    return true;
}

static function setState($bdd, $name, $state){
    $req = $bdd->prepare("UPDATE Wallets SET disabled = :state WHERE Name=:name");
    $req->bindValue(":state", $state, PDO::PARAM_STR);
    $req->bindValue(":name", $name, PDO::PARAM_STR);
    $req->execute();
    $req->closeCursor();
    if($req->rowCount() == 0){
        return false;
    }
    return true;
}

static function setMarketState($bdd, $pair, $disable){
    $req = $bdd->prepare("UPDATE Markets SET disabled = :disable WHERE Pair=:pair");
    $req->bindValue(":disable", $disable, PDO::PARAM_STR);
    $req->bindValue(":pair", $pair, PDO::PARAM_STR);
    $req->execute();
    $req->closeCursor();
    if($req->rowCount() == 0){
        return false;
    }
    return true;
}

static function setMarketFee($bdd, $pair, $fee){
    $req = $bdd->prepare("UPDATE Markets SET Fee = :fee WHERE Pair=:pair");
    $req->bindValue(":fee", $fee, PDO::PARAM_STR);
    $req->bindValue(":pair", $pair, PDO::PARAM_STR);
    $req->execute();
    $req->closeCursor();
    if($req->rowCount() == 0){
        return false;
    }
    return true;
}
static function setHash($bdd, $walletid, $hash){
    $req = $bdd->prepare("UPDATE Wallets SET Last_Hash = :hash WHERE Id=:walletid");
    $req->bindValue(":hash", $hash, PDO::PARAM_STR);
    $req->bindValue(":walletid", $walletid, PDO::PARAM_STR);
    $req->execute();
    $req->closeCursor();
    if($req->rowCount() == 0){
        return false;
    }
    return true;
}

static function setWallet($bdd, $row, $acronymn, $value){
    try{
        $req = $bdd->prepare("UPDATE Wallets SET ".$row." = :row WHERE Acronymn=:acronymn");
        $req->bindValue(":row", $value, PDO::PARAM_STR);
        $req->bindValue(":acronymn", $acronymn, PDO::PARAM_STR);
        $req->execute();
        $req->closeCursor();
    }catch( PDOEXception $e ){
           echo $e->getMessage(); // display bdd error
           
       }
       if($req->rowCount() == 0){
        return false;
    }
    return true;
}

static function setBalance($bdd, $account, $coin, $newbalance){
    try{
        $req = $bdd->prepare("UPDATE balances SET Amount = :newbalance WHERE Account=:account AND Coin = :coin");
        $req->bindValue(":newbalance", $newbalance, PDO::PARAM_STR);
        $req->bindValue(":account", $account, PDO::PARAM_STR);
        $req->bindValue(":coin", $coin, PDO::PARAM_STR);
        $req->execute();
        $req->closeCursor();
        if($req->rowCount() == 0){
            return false;
        }
        return true;
    }catch( PDOEXception $e ){
           echo $e->getMessage(); // display bdd error
           
       }
   }

   static function setFee($bdd, $name, $fee){
    $fee2 = ''.floatval($fee);
    $req = $bdd->prepare("UPDATE pairs SET fee = :fee WHERE name=:name");
    $req->bindValue(":fee", $fee2, PDO::PARAM_STR);
    $req->bindValue(":name", $name, PDO::PARAM_STR);
    $req->execute();
    $req->closeCursor();
    if($req->rowCount() == 0){
        return false;
    }
    return true;
}

static function updateLastTimeSeen($bdd, $username){
    try{
        $req = $bdd->prepare("UPDATE Users SET LastTimeSeen = NOW() WHERE Username=:username");
        $req->bindValue(":username", $username, PDO::PARAM_STR);
        $req->execute();
        $req->closeCursor();
        if($req->rowCount() == 0){
            return false;
        }
        return true;
    }catch( PDOEXception $e ){
           echo $e->getMessage(); // display bdd error
           
       }
   }

   static function updateLastSignIn($bdd, $username, $ip){
    try{
        $req = $bdd->prepare("UPDATE Users SET LastSignIn = NOW() WHERE Username=:username");
        $req->bindValue(":username", $username, PDO::PARAM_STR);
        $req->execute();
        $req->closeCursor();
        $req = $bdd->prepare("UPDATE Users SET Last_IP = :ip WHERE Username=:username");
        $req->bindValue(":ip", $ip, PDO::PARAM_STR);
        $req->bindValue(":username", $username, PDO::PARAM_STR);
        $req->execute();
        $req->closeCursor();
    }catch( PDOEXception $e ){
           echo $e->getMessage(); // display bdd error
           
       }
   }

   static function addVote($bdd, $acronymn, $name, $address){
    try{
        $req = $bdd->prepare("INSERT INTO Votes (Acronymn, Name, Address, Total, Actif) VALUES (:acr, :name, :address, 0, 0)");
        $req->bindParam(":acr", $acronymn, PDO::PARAM_STR, 255);
        $req->bindParam(":name", $name, PDO::PARAM_STR, 255);
        $req->bindParam(":address", $address, PDO::PARAM_STR, 255);
        $req->execute();
        $req->closeCursor();
        return $req->rowCount();
    }catch( PDOEXception $e ){
           echo $e->getMessage(); // display bdd error
           
       }
   }

   static function setVote($bdd, $acr, $state){
    $req = $bdd->prepare("UPDATE Votes SET Actif = :state WHERE Acronymn=:acr");
    $req->bindValue(":state", $state, PDO::PARAM_STR);
    $req->bindValue(":acr", $acr, PDO::PARAM_STR);
    $req->execute();
    $req->closeCursor();
    if($req->rowCount() == 0){
        return false;
    }
    return true;
}

static function editVoteTotal($bdd, $acr, $total){
    try{
        $req = $bdd->prepare("UPDATE Votes SET Total = :total WHERE Acronymn=:acr");
        $req->bindValue(":total", $total, PDO::PARAM_INT);
        $req->bindValue(":acr", $acr, PDO::PARAM_STR);
        $req->execute();
        $req->closeCursor();
        if($req->rowCount() == 0){
            return false;
        }
        return true;
    }catch( PDOEXception $e ){
           echo $e->getMessage(); // display bdd error
           
       }
   }

   static function addVoteHistory($bdd, $name, $acr, $time){
    try{
        $req = $bdd->prepare("INSERT INTO Votes_History (Username, Coin, Timestamp) VALUES (:name, :acr, :time)");
        $req->bindParam(":name", $name, PDO::PARAM_STR, 255);
        $req->bindParam(":acr", $acr, PDO::PARAM_STR, 255);
        $req->bindParam(":time", $time, PDO::PARAM_INT);
        $req->execute();
        $req->closeCursor();
        return $req->rowCount();
    }catch( PDOEXception $e ){
           echo $e->getMessage(); // display bdd error
           
       }
   }

   static function setVoteHistory($bdd, $name, $acr, $time){
    $req = $bdd->prepare("UPDATE Votes_History SET Timestamp = :time WHERE Username = :name AND Coin=:acr");
    $req->bindValue(":time", $time, PDO::PARAM_INT);
    $req->bindValue(":name", $name, PDO::PARAM_STR);
    $req->bindValue(":acr", $acr, PDO::PARAM_STR);
    $req->execute();
    $req->closeCursor();
    if($req->rowCount() == 0){
        return false;
    }
    return true;
}

//Renseigne que l'user est au courant de son deposit
static function addNotification($bdd, $username, $type, $text){
    try{
        $req = $bdd->prepare("INSERT INTO Notifications (Username, Type, Text) VALUES (:usr, :type, :txt)");
        $req->bindParam(":usr", $username, PDO::PARAM_STR, 255);
        $req->bindParam(":type", $type, PDO::PARAM_STR, 255);
        $req->bindParam(":txt", $text, PDO::PARAM_STR, 255);
        $req->execute();
        $req->closeCursor();
        return $req->rowCount();
    }catch( PDOEXception $e ){
           echo $e->getMessage(); // display bdd error
           
       }
   }

   static function setNotification($bdd, $id){
    $req = $bdd->prepare("UPDATE Notifications SET Viewed = 1 WHERE id = :id");
    $req->bindValue(":id", $id, PDO::PARAM_INT);
    $req->execute();
    $req->closeCursor();
    if($req->rowCount() == 0){
        return 0;
    }
    return 1;
}

static function addToChat($bdd, $time, $name, $msg){
    try{
        $req = $bdd->prepare("INSERT INTO Chat (Timestamp, Username, Message) VALUES (:time, :usr, :msg)");
        $req->bindParam(":time", $time, PDO::PARAM_INT);
        $req->bindParam(":usr", $name, PDO::PARAM_STR, 255);
        $req->bindParam(":msg", $msg, PDO::PARAM_STR, 255);
        $req->execute();
        $req->closeCursor();
        return $req->rowCount();
    }catch( PDOEXception $e ){
           echo $e->getMessage(); // display bdd error
           
       }
   }

   static function editKeyPassword($bdd, $usr, $key){
    $req = $bdd->prepare("UPDATE Users SET KeyResetPassword = :key, LostPasswordRequest = 1 WHERE Username = :usr");
    $req->bindValue(":usr", $usr, PDO::PARAM_STR);
    $req->bindValue(":key", $key, PDO::PARAM_STR);
    $req->execute();
    $req->closeCursor();
    if($req->rowCount() == 0){
        return 0;
    }
    return 1;
   }

   static function editPassword($bdd, $usr, $pass){
    $req = $bdd->prepare("UPDATE Users  SET Password = :pass, LostPasswordRequest = 0 WHERE Username = :usr");
    $req->bindValue(":usr", $usr, PDO::PARAM_STR);
    $req->bindValue(":pass", sha1($PREFIXE_SHA1.$pass), PDO::PARAM_STR);
    $req->execute();
    $req->closeCursor();
    if($req->rowCount() == 0){
        return 0;
    }
    return 1;
   }

   static function activeAccount($bdd, $usr){
    $req = $bdd->prepare("UPDATE Users  SET Actif = 1 WHERE Username = :usr");
    $req->bindValue(":usr", $usr, PDO::PARAM_STR);
    $req->execute();
    $req->closeCursor();
    if($req->rowCount() == 0){
        return 0;
    }
    return 1;
   }

}

?>
