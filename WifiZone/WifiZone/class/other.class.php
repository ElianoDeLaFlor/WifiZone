<?php

    include_once 'dbConnexion.class.php';

    class Other{

        //========================================
        //========================================
        //=====Génération de chaine aléqtoire=====
        //========================================
        //========================================
        public function genererChaineAleatoire($longueur) {  //fonction de generation de chaine servant d'identifiant du fichier pour le securiser
            $listeCar = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $chaine = '';  
            $max = mb_strlen($listeCar, '8bit') - 1;  
            for ($i = 0; $i < $longueur; ++$i) {  
                $chaine .= $listeCar[random_int(0, $max)];  
            }  
            return $chaine; 
        }

        //=========================================================
        //=========================================================
        //=====Verification de l'existance d'une chaine générée====
        //=========================================================
        //=========================================================
        public function existanceChaineAleatoire($chaine){
            $conn=Connection::getInstance();

            $query = $conn->prepare('SELECT COUNT(ResetCode) AS nbResetCode FROM client WHERE ResetCode = :ResetCode');
            $query->execute(array(
                "ResetCode" => $chaine
            ));
            $queryData = $query->fetch();

            return $queryData['nbResetCode'];
        }

        //======================
        //======================
        //=====Envoie de SMS====
        //======================
        //======================
        public function SmsSender($dest, $msg){
            try {
                $serverUrl = "http://aspsmsapi.com/http/sendsms.aspx?"; // URL de base
                $username = "22899229853"; // Votre nom d'utilisateur
                $apikey = "8W0KV32H8N"; // Votre clé API
                $senderid = "AFSTREL"; // Identifiant d'envoi
                $authmode = "http"; // Obligatoire. Ne pas modifier
                // CURL_INIT
                $ch = curl_init($serverUrl);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch,CURLOPT_POSTFIELDS,"dest=$dest&username=$username&apikey=$apikey&senderid=$senderid&msg=$msg&authmode=$authmode");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                $output = curl_exec($ch); // Afficher le résultat du serveur
                curl_close($ch);
                return $output;
            }
            catch(Exception $ex) {
                return false;
            }
        }

    }