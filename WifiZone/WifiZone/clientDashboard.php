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
                    include_once 'class/dbConnexion.class.php';
                    include_once 'class/ticket.class.php';
                    $conn = Connection::getInstance();

                    $ticketCode = new Ticket();
                    $clientTicketCode = $ticketCode->LastTicketForClient();

                    $device = "F CFA";
                    if(isset($_GET['ticketAvailability']) and $_GET['ticketAvailability'] == 'no'){
                        $loginAvailability = '<div class="font-weight-bold text-danger mb-3">Le type de forfait demandé n\'est plus en stock</div>';
                    }
                    else{
                        $loginAvailability = '';
                    }
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
                                                        <?php echo $loginAvailability; ?>
                                                        <div class="font-weight-bold">Acheter un autre ticket :</span></div>
                                                        <input type="hidden" name="typePayement" value="compteRecharge">
                                                        <select class="wide mt-1 mb-4" id="type_forfait" name="description" required="required">
                                                            <option value="START" selected="selected">Changer le forfait</option>
                                                            <?php
                                                                $type_forfait = $conn->query('SELECT * FROM typeticket');
                                                                $position = 0;
                                                                while($donnee_type_forfait = $type_forfait->fetch()){
                                                                    {
                                                                        ?>
                                                                            <option value="<?php echo $donnee_type_forfait['ReferenceTypeTicket']; ?>"><?php echo $donnee_type_forfait['ReferenceTypeTicket']." ".$donnee_type_forfait['MontantTypeTicket']." ".$device; ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                        <div id="global_detail_forfait">
                                                            <div id="load_detail_forfait">
                                                                <p class="card-title font-weight-bold">Forfait sélèctioné : <span id="title_forfait"><a href="#" class="btn btn-dark btn-sm rounded-0 font-weight-bold wow fadeInRight">START</a><a href="#" class="btn btn-secondary btn-sm rounded-0 font-weight-bold wow fadeInRight">500 F CFA</a></span></p>
                                                                <p class="card-text" id="detail_forfait"><span class="d-inline-block wow fadeInRight">Bande passante : <b>1Mbs</b><br>Temps : 24h<br>Validité : 1 jour</span></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="card-text mt-3"><button type="submit" class="btn btn-info rounded-0 font-weight-bold mr-2">Acheter</button></p>
                                            </form>
                                        </div>
                                        <!-- ------------- -->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <?php include 'include/foot.php'; ?>
                <script src="js/javascript.js"></script>
                <script>
                    //controle de l'egalité des champs mot de passe
                    var password = document.getElementById("id_mdp_client"), 
                        confirm_password = document.getElementById("id_conf_mdp_client");
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
    else{
        header('location: index.php');
    }
?>