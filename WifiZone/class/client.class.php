<?php

include_once 'dbConnexion.class.php';
include_once 'session.class.php';

class Client
{
    public $IdClient;
    public $LoginClient;
    public $MdpClient;
    public $TelClient;
    public $ResetCode;

    public function __construct(){}

    //=====================================
    //=====================================
    //=====verifier si un login existe=====
    //=====================================
    //=====================================
    public function ExisteClient($LoginClient){
        try{
            $conn = Connection::getInstance();
            $con = $conn->prepare("SELECT COUNT(LoginClient) AS NbExisteLoginClient FROM client WHERE LoginClient = :LoginClient");
            $con->execute(array(
                "LoginClient" => $LoginClient
            ));
            $row = $con->fetch();
            return $row['NbExisteLoginClient'];
        }catch(PDOException $e){
            return false;
        }
    }

    //===========================================================
    //===========================================================
    //=====Relever tous les données correspondants à un login=====
    //===========================================================
    //===========================================================
    public function ClientAllDataByLogin($LoginClient){
        try{
            $conn = Connection::getInstance();
            $con = $conn->prepare("SELECT * FROM client WHERE LoginClient = :LoginClient");
            $con->execute(array(
                "LoginClient" => $LoginClient
            ));
            $row = $con->fetch();
            $this->IdClient = $row['IdClient'];
            $this->LoginClient = $row['LoginClient'];
            $this->MdpClient = $row['MdpClient'];
            $this->TelClient = $row['TelClient'];
            $this->ResetCode = $row['ResetCode'];
            return $this;
        }catch(PDOException $e){
            return false;
        }
    }
    
    //==============================
    //==============================
    //=====creation d'un client=====
    //==============================
    //==============================
    public function InsertClient($accountLogin, $accountPassword, $telClient){
        try{
            $conn=Connection::getInstance();
            $con= $conn->prepare("INSERT INTO client (LoginClient, MdpClient, telClient) VALUES (:LoginClient, :MdpClient, :telClient)");
            $con->execute(array(
                'LoginClient'=>$accountLogin,
                'MdpClient'=>$accountPassword,
                "telClient" => $telClient
            ));
            return $conn->lastInsertId();
        }catch(PDOException $e){
            return "false";
        }
    }

    //=======================================
    //=======================================
    //=====Connexion au compte du client=====
    //=======================================
    //=======================================
    public function ConnexionClient($LoginClient, $mdp_renseigner){
        //verification dans la base de données si le login renseigné existe
        $nbLogin = $this->ExisteClient($LoginClient);

        //si le login existe, on verifie le mot de passe 
        if($nbLogin == 1){
            $client_objet = $this->ClientAllDataByLogin($LoginClient);
            $mdpClient = $this->MdpClient;
            //si le mot de passe renseigné et celui relevé dans la base de donné sont égal, on ouvre la session
            if(password_verify($mdp_renseigner , $mdpClient)){
                //ouverture de la session
                $openSession = new Session();
                $session_objet = $openSession->SessionStart($LoginClient);
                return $session_objet;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }

    //=======================================
    //=======================================
    //=====UPDATE client=====
    //=======================================
    //=======================================
    public function UpdateMdpClient($MdpClient){//password update
        try{
            $conn=Connection::getInstance();
            $clientUpdateQuery = $conn->prepare("UPDATE client SET MdpClient = :MdpClient WHERE IdClient = :IdClient");
            $clientUpdateQuery->execute(array(
                "MdpClient" => password_hash($MdpClient , PASSWORD_DEFAULT),
                "IdClient" => $_SESSION['IdClient']
            ));
            return true;
        }catch(PDOException $e){
            return false;
        }
    }

    public function UpdateMdpClientByResetCode($MdpClient, $ResetCode){//password update
        try{
            $conn=Connection::getInstance();
            $clientUpdateQuery = $conn->prepare("UPDATE client SET MdpClient = :MdpClient WHERE ResetCode = :ResetCode");
            $clientUpdateQuery->execute(array(
                "MdpClient" => password_hash($MdpClient , PASSWORD_DEFAULT),
                "ResetCode" => $ResetCode
            ));
            return true;
        }catch(PDOException $e){
            return false;
        }
    }

    public function UpdateResetCodeClient($ResetCode, $LoginClient){//Email update
        try{
            $conn=Connection::getInstance();
            $clientUpdateQuery = $conn->prepare("UPDATE client SET ResetCode = :ResetCode WHERE LoginClient = :LoginClient");
            $clientUpdateQuery->execute(array(
                "ResetCode" => $ResetCode,
                "LoginClient" => $LoginClient
            ));
            return true;
        }catch(PDOException $e){
            return false;
        }
    }

    public function DeleteResetCodeClient($ResetCode){//Email update
        try{
            $conn=Connection::getInstance();
            $clientUpdateQuery = $conn->prepare("UPDATE client SET ResetCode = '' WHERE ResetCode = :ResetCode");
            $clientUpdateQuery->execute(array(
                "ResetCode" => $ResetCode,
            ));
            return true;
        }catch(PDOException $e){
            return false;
        }
    }

    public function UpdateTelClient($telClient){//password update
        try{
            $conn=Connection::getInstance();
            $clientUpdateQuery = $conn->prepare("UPDATE client SET TelClient = :telClient WHERE IdClient = :IdClient");
            $clientUpdateQuery->execute(array(
                "telClient" => $telClient,
                "IdClient" => $_SESSION['IdClient']
            ));
            return true;
        }catch(PDOException $e){
            return false;
        }
    }








}
