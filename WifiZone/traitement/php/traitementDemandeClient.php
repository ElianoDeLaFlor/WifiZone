<?php

    session_start();

    //fichier de connexion à la base de données
    include_once '../../class/client.class.php';
    include_once '../../class/dbConnexion.class.php';
    include_once '../../class/typeTicket.class.php';
    include_once '../../class/payement.class.php';
    include_once '../../class/ticket.class.php';
    include_once '../../class/mail.class.php';
    include_once '../../class/other.class.php';

    //============================================================
    //============================================================
    //==========Recharge de compte ou creation de compte==========
    //============================================================
    //============================================================
    if(isset($_POST['typePayement'])){

        $AmountTypeTicket = new TypeTicket();
        $typeTicketAsked = $_POST['description'];
        $typeTicketAskedObjet = $AmountTypeTicket->SelectTypeTicket($typeTicketAsked);

        $ticketExiste = new Ticket();
        $IdTypeTicket = $AmountTypeTicket->IdTypeTicket;
        $ticketExisteObjet = $ticketExiste->SelectTicketToDeliver($IdTypeTicket);

        //SI LE TICKET DEMANDER EST EN STOCK
        if($ticketExisteObjet != false){
            //constitution des variables de la requêtes de payement
            $amount = $AmountTypeTicket->MontantTypeTicket;//montant du forfait acheté
            $token = "f423bc93-a16f-40c8-aecc-1e01c304e3a3";//API Key
            $url = "https://zone.afstrel.com/index.php?connexionRequired=yes";//url de retour apres payement
            $description = $typeTicketAsked;//type de forfait acheté

            //=================================================
            //=============cas de création de compte===========
            //=================================================
            if($_POST['typePayement'] == 'compteCreation'){
                $password_crypt = password_hash($_POST['MdpClient'], PASSWORD_DEFAULT);//criptage du mot de passe
                $identifier = strtolower($_POST['LoginClient'])."-".$password_crypt."-".$_POST['description']."-".$_POST['typePayement'];//conception de l'identifiant de payement
                
                $existeClient = new Client();//verifier si le client à créer n'existe pas déjà dans la base de données
                $LoginClient = $_POST['LoginClient'];
                $nbClientExiste = $existeClient->ExisteClient($LoginClient);

                if($nbClientExiste == 0){//envoie de la requête si le client n'existe pas
                    $payement = new Payement();
                    $payement->PayementInitiation($token, $amount, $description, $identifier, $url);
                }
                
                else{
                    header('location: ../../compteCreation.php?loginAvailability=no');
                }
            }

            //==================================================
            //===============cas de recharge de compte==========
            //==================================================
            elseif($_POST['typePayement'] == 'compteRecharge' and isset($_SESSION['session_status']) and $_SESSION['session_status'] == 'success159643'){
                $identifier = $_SESSION['IdClient']."-".bin2hex(random_bytes(16))."-".$_POST['description']."-".$_POST['typePayement'];
                
                $payement = new Payement();
                $payement->PayementInitiation($token, $amount, $description, $identifier, $url);
            }

            //====================================================================================
            //===========cas d'absence d'operation de recharger et de creation de compte==========
            //====================================================================================
            else{
                header('location: ../../index.php');
            }
        }

        //SI LE TICKET DEMANDER N'EST PAS EN STOCK
        else{
            if(isset($_SESSION['session_status']) and $_SESSION['session_status'] == 'success159643'){
                header('location: ../../clientDashboard.php?ticketAvailability=no');
            }
            else{
                header('location: ../../compteCreation.php?ticketAvailability=no');
            }
            
        }
    }

    //==============================================
    //==============================================
    //==========changement de mot de passe==========
    //==============================================
    //==============================================
    if(isset($_POST['mdpChange'])){

        $updateClient = new Client();
        $MdpClient = $_POST['MdpClient'];
        $updateResponse = $updateClient->UpdateMdpClient($MdpClient);
        if($updateResponse == true){
            $sessionDestroy = new Session();
            $sessionDestroyResponse = $sessionDestroy->SessionDestroy();
            if($sessionDestroyResponse == true){
                header('location: ../../index.php?mdpChangeStatus=yes');
            }
            else{
                header('location: ../../clientDashboard.php');
            }
        }
        else{
            header('location: ../../clientDashboard.php');
        }

    }

    //==============================================================
    //==============================================================
    //==========Envoie de code de réinitialisation par SmS==========
    //==============================================================
    //==============================================================
    if(isset($_POST['loginMdpReset'])){

        //generation de code de réinitialisation
        $resetCodeClass = new Other();
        $resetCode = $resetCodeClass->genererChaineAleatoire(5); 

        //verification si le code generé n'est pas déjà dans la base de données
        $nbResetCode = $resetCodeClass->existanceChaineAleatoire($resetCode);

        //générer un autre code tant que celui ci est déjà obtenue par un client
        while($nbResetCode != 0){
            $resetCode = $resetCodeClass->genererChaineAleatoire(5); 
        }

        // mise à jour du compte du client avec le code de réinitialisation
        $updateResetCodeclass = new Client();
        $updateResetCode = $updateResetCodeclass->UpdateResetCodeClient($resetCode, $_POST['LoginClient']);

        //recuperation des données du client par le login
        $clientObjet = $updateResetCodeclass->ClientAllDataByLogin($_POST['LoginClient']);
        $dest = $clientObjet->TelClient;

        //envoie du code de réinitialisation par SMS au client
        $msg = utf8_decode($resetCode." est votre code de réinitialisation de mot de passe sur GIX Hotspot");
        $smsStatus = $resetCodeClass->SmsSender($dest, $msg);

        if(stristr($smsStatus, 'OK') == true){
            header('location: ../../mdpReset.php');
        }
        else{
            header('location: ../../loginMdpReset.php?codeSendStatus=false');
        }

    }

    //====================================================
    //====================================================
    //==========Réinitialisation du mot de passe==========
    //====================================================
    //====================================================
    if(isset($_POST['resetMdp'])){

        //verifier l'existance du code de réinitialisation dans la base de données
        $resetCodeClass = new Other();
        $nbResetCode = $resetCodeClass->existanceChaineAleatoire($_POST['ResetCode']); 

        //mise à jour du mot de passe concerné par le code de réinitialisation
        if($nbResetCode == 1){
            $clientObjet = new Client();
            $clientUpdateStatus = $clientObjet->UpdateMdpClientByResetCode($_POST['MdpClient'], $_POST['ResetCode']);
            //redirection du client sur l'accueil pour se reconnecter avec le nouveau mot de passe
            if($clientUpdateStatus == true){
                $clientObjet->DeleteResetCodeClient($_POST['ResetCode']);
                header('location: ../../index.php?mdpChangeStatus=yes');
            }
        }  
    }

    //=====================================================
    //=====================================================
    //==========Changement de numero de téléphone==========
    //=====================================================
    //=====================================================
    if(isset($_POST['updateTel'])){

        $updateClient = new Client();
        $telClient = str_replace(' ', '', trim($_POST['TelClient']));
        $updateResponse = $updateClient->UpdateTelClient($telClient);
        if($updateResponse == true){
            header('location: ../../clientDashboard.php');
        }
        else{
            header('location: ../../updateTel.php?updateTelStatus=false');
        }

    }



    

?>    