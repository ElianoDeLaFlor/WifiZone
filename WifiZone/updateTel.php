<?php 
    session_start(); 
    if(isset($_SESSION['session_status']) and $_SESSION['session_status'] == 'success159643'){
        ?>
            <!DOCTYPE html>
            <html>
            <head>
                <title>AFSTREL-ZONE</title>
                <?php include 'include/head.php'; ?>
            </head>
            <body>
                <?php
                    // include_once 'DbConnexion/DbConnexion.php';
                    include_once 'class/dbConnexion.class.php';
                    include_once 'class/ticket.class.php';
                    $conn = Connection::getInstance();

                    $ticketCode = new Ticket();
                    $clientTicketCode = $ticketCode->LastTicketForClient();
                    
                    $device = "F CFA";
                ?>
                <section class="h-100">
                    <div class="container h-100">
                        <div class="row d-flex h-100">
                            <div class="col-lg-4 mx-auto align-self-center">
                                <!-- card -->
                                <div class="card-deck mb-3">
                                    <div class="w-100 text-center"><i class="material-icons text-white text-center icon_page">dashboard</i></div>
                                    <div class="card border border-white rounded-0 bg-transparent">

                                        <!-- dashboard head -->
                                        <?php include_once 'include/dashboardHead.php'; ?>

                                        <!-- dashboard body -->
                                        <div class="card-body bg-warning">
                                            <form method="POST" action="traitement/php/traitementDemandeClient.php" id="connexion_client">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="font-weight-bold mb-4">Ticket acheté : <span class="text-light"><?php echo $clientTicketCode; ?></span></div>
                                                        <div class="font-weight-bold">Modification du numéro de téléphone :</span></div>
                                                        <div class="font-weight-bold text-white">Ex : 22894756356</span></div>
                                                        <input type="hidden" name="updateTel" value="">
                                                        <input type="tel" class="form-control rounded-0 border-0 font-weight-bold my-1" id="id_TelClient" name="TelClient" placeholder="Nouveau numéro de téléphone" required="required">
                                                        <input type="tel" class="form-control rounded-0 border-0 font-weight-bold" id="id_conf_TelClient" placeholder="Confirmez le nouveau numéro de téléphone" required="required">
                                                    </div>
                                                </div>
                                                <p class="card-text mt-3"><button type="submit" class="btn btn-info rounded-0 font-weight-bold mr-2">Modifier</button></p>
                                            </form>
                                        </div>
                                        <!-- ------------ -->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <?php include 'include/foot.php'; ?>
                <script>
                    //controle de l'egalité des champs mot de passe
                    var password = document.getElementById("id_TelClient"), 
                        confirm_password = document.getElementById("id_conf_TelClient");
                    function validatePassword(){
                        if(password.value != confirm_password.value) {
                            confirm_password.setCustomValidity("Les numéros renseignés ne sont pas identiques.");
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
    else{
        header('location: index.php');
    }
?>