
<?php

    include_once '../../class/ticket.class.php';
    include_once '../../class/client.class.php';
    include_once '../../class/dbConnexion.class.php';
    include_once '../../class/httpRequester.class.php';

    //=========téléchargement de données envoyer au callback par PAYGATE===========
    $json = file_get_contents('php://input');
    $reponse = json_decode($json, true);//conversion des données JSON reçus en variable PHP

    //===========donnee recueillis=========
    $tx_reference = $reponse['tx_reference'];
    $identifier = $reponse['identifier'];
    $payment_reference = $reponse['payment_reference'];
    $amount = $reponse['amount'];
    $datetime = $reponse['datetime'];
    $payment_method = $reponse['payment_method'];
    $PayementNum = $reponse['phone_number'];

    //=========vérification de l'état du payement==========
    $statut_data = '{
        "tx_reference" : "'."$tx_reference".'",
        "auth_token" : "f423bc93-a16f-40c8-aecc-1e01c304e3a3"
    }';//donné à envoyer à la requête
    $statut = HTTPRequester::HttPPost('https://paygateglobal.com/api/v1/status', $statut_data);//envoie de la requête de vérification
    $statutRow = json_decode($statut, true);//decodage des données JSON reçu en tableau PHP
    $statutValue = $statutRow['status'];//aleur du statut du payement

    //===========recharge ou création du compte si le statut du payement est égale à 0 (payement réussit)=========
    if($statutValue == 0){
        //recueille des parametre du compte du client
        $accountData = explode('-', $identifier);
        $typeTicketAsked = $accountData[2];//type du ticket demandé
        $typePayement = $accountData[count($accountData)-1];//identification du type de payement (Création de compte ou bien Recharge)

        //cas de création de compte
        if($typePayement == 'compteCreation'){
            $accountLogin = $accountData[0];//login
            $accountPassword = $accountData[1];//mot de passe
            $telClient = $PayementNum;
            //creation du compte
            $client = New Client();
            $IdClient = $client->InsertClient($accountLogin, $accountPassword, $telClient);
            //creation du compte au niveau du hostpost api
            //livraison du ticket sur le compte par mise à jour de la ligne du ticket
            $ticket = new Ticket();
            $status_livraison = $ticket->TicketLivraison($typeTicketAsked, $IdClient, $PayementNum);
        }

        //cas de recharge de compte
        elseif($typePayement == 'compteRecharge'){
            $IdClient = $accountData[0];//Id du client rechargeur
            //livraison du ticket sur le compte par mise à jour de la ligne du ticket
            $ticket = new Ticket();
            $status_livraison = $ticket->TicketLivraison($typeTicketAsked, $IdClient, $PayementNum);
        }
        
    }

?>