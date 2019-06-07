<?php 
    session_start(); 
    if(isset($_SESSION['session_status']) and $_SESSION['session_status'] == 'success159643'){
        header('location: clientDashboard');
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
                    if(isset($_GET['loginAvailability']) and $_GET['loginAvailability'] == 'no'){
                        $erreur = "Ce nom d'utilisateur est déjà pris par un autre client.";
                    }
                    elseif(isset($_GET['ticketAvailability']) and $_GET['ticketAvailability'] == 'no'){
                        $erreur = 'Le type de forfait demandé n\'est plus en stock';
                    }
                    else{
                        $erreur = '';
                    }
                ?>
                <section class="h-100">
                    <div class="container-fluid h-100">
                        <div class="row d-flex h-100">
                            <div class="col-lg-4 mx-auto align-self-center">
                                <div class="card-deck mb-3">
                                    <div class="card rounded-0 border-0 bg-transparent">
                                    <span class="text-center"><i class="material-icons text-white icon_page">person_add</i></span>
                                        <div class="card-body bg-warning border border-white">
                                            <p class="text-white font-weight-bold text-center">Créer votre nouveau compte WIFI-ZONE et faites le premier rechargement</p>
                                            <form method="POST" action="traitement/php/traitementDemandeClient.php" id="connexion_client">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <input type="hidden" name="typePayement" value="compteCreation">
                                                        <input type="text" class="form-control rounded-0 border-0 font-weight-bold" id="id_login_client" name="LoginClient" placeholder="Nom d'utilisateur" required="required">
                                                        <input type="password" class="form-control rounded-0 border-0 font-weight-bold my-1" id="id_mdp_client" name="MdpClient" placeholder="Mot de passe" required="required">
                                                        <input type="password" class="form-control rounded-0 border-0 font-weight-bold" id="id_conf_mdp_client" placeholder="Confirmation de mot de passe" required="required">
                                                        <select class="wide mt-1 mb-2" id="type_forfait" name="description" required="required">
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
                                                        <div class="w-100 mb-4 font-weight-bold text-danger wow flipInX" data-wow-delay="1s"><?php echo $erreur; ?></div>
                                                        <div id="global_detail_forfait">
                                                            <div id="load_detail_forfait">
                                                                <p class="card-title font-weight-bold">Forfait sélèctioné : <span id="title_forfait"><a href="#" class="btn btn-dark btn-sm rounded-0 font-weight-bold wow fadeInRight">START</a><a href="#" class="btn btn-secondary btn-sm rounded-0 font-weight-bold wow fadeInRight">500 F CFA</a></span></p>
                                                                <p class="card-text" id="detail_forfait"><span class="d-inline-block wow fadeInRight">Bande passante : <b>1Mbs</b><br>Temps : 24h<br>Validité : 1 jour</span></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="card-text mt-3"><button type="submit" class="btn btn-info btn-sm rounded-0 font-weight-bold mr-2">Créer</button><a href="index.php" class="btn btn-success btn-sm rounded-0 font-weight-bold">Se connecter</a></p>
                                            </form>
                                        </div>
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
?>