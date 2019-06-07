<?php

//fichier de connexion à la base de données
include_once 'dbConnexion.class.php';
include_once 'typeTicket.class.php';


class Ticket
{
    
    public $IdTicket;
    public $CodeTicket;
    public $DateCreationTicket;
    public $PayementNum;
    public $FK_IdTypeTicket;
    public $FK_IdClient;

    public function __construct(){}
 
    //==============================
    //==============================
    //=====creation des tickets=====
    //==============================
    //==============================
    public function InsertTicket(){
        try{

            $conn=Connection::getInstance();
            //------------------------
            $con= $conn->prepare("INSERT INTO ticket (CodeTicket, DateCreationTicket, DateAchatTicket, FK_IdTypeTicket, FK_IdClient, PayementNum) VALUES (:CodeTicket, :DateCreationTicket, :DateAchatTicket, :FK_IdTypeTicket, :FK_IdClient, :PayementNum)");
            $con->execute(array(
                "CodeTicket" => $this->CodeTicket,
                "DateCreationTicket" => $this->DateCreationTicket,
                "DateAchatTicket" => NULL,
                "FK_IdTypeTicket" => $this->FK_IdTypeTicket,
                "FK_IdClient" => 0,
                "PayementNum" => ''
            ));
            //------------------;
        }catch(PDOException $e){
            return false;
        }
    }
    
    //====================================
    //====================================
    //=====mise à jour du ticket payé=====
    //====================================
    //====================================
    public function UpdateTicket($IdClient, $IdTicket, $PayementNum){
        try{
            $conn=Connection::getInstance();
            //-----------------
            $con= $conn->prepare("UPDATE ticket SET FK_IdClient = :IdClient, DateAchatTicket = UTC_TIMESTAMP(), PayementNum = :PayementNum WHERE IdTicket = :IdTicket");
            $con->execute(array(
                "IdClient" => $IdClient,
                "IdTicket" => $IdTicket,
                "PayementNum" => $PayementNum
            ));
            //--------------
            return true;
        }catch(PDOException $e){
            return false;
        }
    }

    //=================================================================================
    //=================================================================================
    //======lecture de tous les propriété du tickets à délivrer=======
    //=================================================================================
    //=================================================================================
    public function SelectTicketToDeliver($IdTypeTicket){
        $conn=Connection::getInstance();

        $stmt = $conn->prepare("SELECT * FROM ticket WHERE IdTicket IN (SELECT MIN(IdTicket) FROM ticket WHERE FK_IdTypeTicket = :IdTypeTicket AND FK_IdClient = 0)");
        $stmt->execute(array(
            "IdTypeTicket" => $IdTypeTicket
        ));

        $row = $stmt->fetch();
        $nb_row = $stmt->rowCount();

        if($nb_row == 1){
            $this->IdTicket = $row['IdTicket'];
            $this->CodeTicket = $row['CodeTicket'];
            $this->DateCreationTicket = $row['DateCreationTicket'];
            $this->PayementNum = $row['PayementNum'];
            $this->FK_IdTypeTicket = $row['FK_IdTypeTicket'];
            $this->FK_IdClient = $row['FK_IdClient'];
            return $this;
        }
        
        else{
            return false;
        }
    }

    //===================================================================
    //===================================================================
    //=======livraison de ticket en mettant à jour la table ticket=======
    //===================================================================
    //===================================================================
    public function TicketLivraison($typeTicketAsked, $IdClient, $PayementNum){
        //recueille de l'identifiant du type de ticket choisi
        $typeTicket = New TypeTicket();
        $typeTicket_objet = $typeTicket->SelectTypeTicket($typeTicketAsked);

        //l'objet ticket à délivrer au client
        $ticketByTypeTicket = New Ticket();
        $IdTypeTicket = $typeTicket_objet->IdTypeTicket;//L'identifiant concernant le type du ticket choisi
        $ticket_objet = $ticketByTypeTicket->SelectTicketToDeliver($IdTypeTicket);//selection de la ligne du ticket à délivrer
        
        //livraison du ticket choisi par mise à jour du champ "FK_IdClient" avec l'identifiant du client précédement relevé 
        $IdTicket = $ticket_objet->IdTicket;//l'ID du ticket à delivrer au client
        return $ticketByTypeTicket->UpdateTicket($IdClient, $IdTicket, $PayementNum);//mise à jour de la ligne du ticket délivré
    }

    //====================================
    //====================================
    //=====dernier ticket du client=====
    //====================================
    //====================================
    public function LastTicketForClient(){

        $conn=Connection::getInstance();

        if(isset($_SESSION['session_status']) and $_SESSION['session_status'] == 'success159643'){

            $ticket = $conn->prepare("SELECT * FROM ticket WHERE DateAchatTicket IN (SELECT MAX(DateAchatTicket) FROM ticket WHERE FK_IdClient = :FK_IdClient)");
            $ticket->execute(array(
                "FK_IdClient" => $_SESSION['IdClient']
            ));

            $response = $ticket->fetch();
            return $response['CodeTicket'];
        }

    }


    
}