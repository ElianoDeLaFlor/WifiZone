<?php
    //fichier de connexion à la base de données
    include_once 'dbConnexion.class.php';
    include_once 'client.class.php';

    class Session{

        //==============================
        //==============================
        //=====Ouverture de session=====
        //==============================
        //==============================
        public function SessionStart($LoginClient){
            //recueil des données du client connecté
            $client = new Client();
            $conn = Connection::getInstance();
            $client_objet = $client->ClientAllDataByLogin($LoginClient);
            //creation des variables de session
            //demarrage de la session
            if(session_start()){
                $_SESSION['IdClient'] = $client_objet->IdClient;
                $_SESSION['LoginClient'] = $client_objet->LoginClient;
                $_SESSION['session_status'] = 'success159643';
                //retourner true apres
                return true;
            }
            else{
                return false;
            }
        }


        //==============================
        //==============================
        //=====fermeture de session=====
        //==============================
        //==============================
        public function SessionDestroy(){
            session_start();
            $_SESSION = array();
            if(session_destroy()){
                return true;
            }
            else{
                return false;
            }
        }
    }