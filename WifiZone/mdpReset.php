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
                                                <input type="hidden" name="resetMdp">
                                                <div class="row">
                                                    <div class="col-12 font-weight-bold mb-2">Réinitialisation de mot de passe</div>
                                                    <div class="col-12">
                                                        <input type="text" class="form-control rounded-0 border-0 font-weight-bold mb-1" id="Id_ResetCode" name="ResetCode" placeholder="Code de réinitialisation reçu par SMS" required="required">
                                                        <input type="password" class="form-control rounded-0 border-0 font-weight-bold mb-1" id="Id_MdpClient" name="MdpClient" placeholder="Nouveau mot de passe" required="required">
                                                        <input type="password" class="form-control rounded-0 border-0 font-weight-bold" id="Id_confMdpClient" placeholder="Confirmation du nouveau mot de passe" required="required">
                                                    </div>
                                                </div>
                                                <p class="card-text mt-3"><button type="submit" class="btn btn-success btn-sm rounded-0 font-weight-bold mr-2">Réinitialiser</button><a class="btn btn-sm btn-danger rounded-0 font-weight-bold" href="loginMdpReset.php">Précédent</a></p>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <?php include 'include/foot.php'; ?>

                <script>
                    //controle de l'egalité des champs mot de passe
                    var password = document.getElementById("Id_MdpClient"), 
                        confirm_password = document.getElementById("Id_confMdpClient");
                    function validatePassword(){
                        if(password.value != confirm_password.value) {
                            confirm_password.setCustomValidity("Les mots de passe saisies ne sont pas identiques.");
                        } else {
                            confirm_password.setCustomValidity('');
                        }
                    }
                    password.onchange = validatePassword;
                    confirm_password.onkeyup = validatePassword;
                </script>

            </body>
            </html>
        <?php
    }
?>