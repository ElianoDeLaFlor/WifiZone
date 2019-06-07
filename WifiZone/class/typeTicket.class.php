<?php

    //fichier de connexion à la base de données
    include_once 'dbConnexion.class.php';

    class TypeTicket{

        public $IdTypeTicket;
        public $idTypeTicketInHotspotSoftware;
        public $ReferenceTypeTicket;
        public $TimeTypeTicket;
        public $DownSpeedTypeTicket;
        public $MontantTypeTicket;
        public $ValiditeTypeTicket;

        public function __construct(){}

        //========================================
        //========================================
        //=======lecture de ticket par Type=======
        //========================================
        //========================================
        public function SelectTypeTicket($typeTicketAsked){

            $conn=Connection::getInstance();

            $typeTicketChoisi = $conn->prepare("SELECT * FROM typeticket WHERE ReferenceTypeTicket = :typeTicketAsked");
            $typeTicketChoisi->execute(array(
                "typeTicketAsked" => $typeTicketAsked
            ));

            $row = $typeTicketChoisi->fetch();

            $this->IdTypeTicket = $row['IdTypeTicket'];
            $this->idTypeTicketInHotspotSoftware = $row['idTypeTicketInHotspotSoftware'];
            $this->ReferenceTypeTicket = $row['ReferenceTypeTicket'];
            $this->TimeTypeTicket = $row['TimeTypeTicket'];
            $this->DownSpeedTypeTicket = $row['DownSpeedTypeTicket'];
            $this->MontantTypeTicket = $row['MontantTypeTicket'];
            $this->ValiditeTypeTicket = $row['ValiditeTypeTicket'];

            return $this;
        }

    }