<?php 
    session_start(); 
    if(isset($_SESSION['session_status']) and $_SESSION['session_status'] == 'success159643'){
        header('location: clientDashboard.php');
    }
    else{
        ?>
            <!DOCTYPE html>
            <html>
            <head>
                <title>AFSTREL-ZONE</title>
                <?php include 'include/head.php'; ?>
            </head>
            <body class="pt-3">
                <?php
                    include_once 'class/dbConnexion.class.php';
                    $conn = Connection::getInstance();
                    $device = "F CFA";
                    //------------
                    if(isset($_GET['statusConnexionData']) and $_GET['statusConnexionData'] == 'wrong'){
                        $statusConnexionDataMsg = '<div class="col-12 mt-2 font-weight-bold text-danger wow flipInX">Les données renseigné sont incorrect.</div>';
                    }
                    else{
                        $statusConnexionDataMsg = '';
                    }
                    //-------------
                    if(isset($_GET['connexionRequired']) and $_GET['connexionRequired'] == 'yes'){
                        $connexionRequired = '<div class="col-12 mb-2 font-weight-bold text-dark wow flipInX">Connectez vous pour visualiser le ticket acheté</div>';
                    }
                    elseif(isset($_GET['mdpChangeStatus']) and $_GET['mdpChangeStatus'] == 'yes'){
                        $connexionRequired = '<div class="col-12 mb-2 font-weight-bold text-dark wow flipInX">Reconnectez vous avec le nouveau mot de passe</div>';
                    }
                    else{
                        $connexionRequired = '';
                    }
                ?>
                
                <section class="h-100">
                    <div class="container-fluid h-100">
                        <div class="row d-flex h-100">
                            <div class="col-lg-4 mx-auto align-self-center">
                                <div class="card-deck mb-3">
                                    <div class="card rounded-0 border-0 bg-transparent">
                                        <span class="text-center"><i class="material-icons text-white text-center icon_page">account_circle</i></span>
                                        <div class="card-body bg-warning border border-white">
                                            <p class="text-white font-weight-bold text-center">Payez les forfaits wifi <u>AFSTREL-ZONE</u> par Flooz ou T-Money</p>
                                            <form method="POST" action="traitement/php/traitementConnexionClient.php" id="Id_ConnexionClient">
                                                <div class="row">
                                                    <?php echo $connexionRequired; ?>
                                                    <div class="col-12">
                                                        <input type="text" class="form-control rounded-0 border-0 font-weight-bold mb-1" id="Id_LoginClient" name="LoginClient" placeholder="Nom d'utilisateur" required="required">
                                                        <input type="password" class="form-control rounded-0 border-0 font-weight-bold mb-3" id="Id_MdpClient" name="MdpClient" placeholder="Mot de passe" required="required">
                                                        <a class="font-weight-bold text-info" href="loginMdpReset.php">Mot de passe oublié</a><span class="font-weight-bold text-info"> !</span>
                                                    </div>
                                                    <?php echo $statusConnexionDataMsg; ?>
                                                </div>
                                                <p class="card-text mt-3"><button type="submit" class="btn btn-danger btn-sm rounded-0 font-weight-bold mr-2">Se connecter</button><a href="compteCreation.php" class="btn btn-info btn-sm rounded-0 font-weight-bold">Créer un compte</a></p>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <?php include 'include/foot.php'; ?>
                <script src="traitement/js/javascript.js"></script>
            </body>
            </html>
        <?php
    }
?>