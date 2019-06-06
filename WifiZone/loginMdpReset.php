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

                    if(isset($_GET['codeSendStatus']) and $_GET['codeSendStatus'] == 'false'){
                        $smsSendError = '<div class="text-danger font-weight-bold mb-3">Le code de réinitialisation n\'est pas envoyé. Réessayez</div>';
                    }
                    else{
                        $smsSendError = "";
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
                                            
                                            <form method="POST" action="traitement/php/traitementDemandeClient.php" id="Id_ConnexionClient">
                                                <input type="hidden" name="loginMdpReset">
                                                <div class="row">
                                                    <div class="col-12 font-weight-bold mb-2">Réinitialisation de mot de passe</div>
                                                    <div class="col-12">
                                                        <input type="text" class="form-control rounded-0 border-0 font-weight-bold mb-2" id="Id_LoginClient" name="LoginClient" placeholder="Entrer le login du compte à réinitialiser" required="required">
                                                        <?php echo $smsSendError; ?>
                                                        <a class="font-weight-bold text-info" href="mdpReset.php">Code de réinitialisation déjà reçu</a><span class="font-weight-bold text-info"> ?</span>
                                                    </div>
                                                </div>
                                                <p class="card-text mt-3"><button type="submit" class="btn btn-danger btn-sm rounded-0 font-weight-bold mr-2">Suivant</button></p>
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