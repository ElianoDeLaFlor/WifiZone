<?php

    include_once 'dbConnexion.class.php';

    class Payement{

        public function PayementInitiation($token, $amount, $description, $identifier, $url){
            //--------------
            $post_url = "https://paygateglobal.com/v1/page?token=$token&amount=$amount&description=$description&identifier=$identifier&url=$url";//url d'anvoie de la requete
            //-------------
            header('location: '.$post_url);//envoie de la requete
        }

    }