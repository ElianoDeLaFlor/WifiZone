<?php


    include_once '../../class/dbConnexion.class.php';
    include_once '../../class/client.class.php';

    $connexionClient = new Client();
    $LoginClient = $_POST['LoginClient'];
    $mdp_renseigner = $_POST['MdpClient'];
    $sessionStatus = $connexionClient->ConnexionClient($LoginClient, $mdp_renseigner);
    if($sessionStatus == true){
        header('location: ../../clientDashboard.php');
    }
    else{
        header('location: ../../index.php?statusConnexionData=wrong');
    }


?>