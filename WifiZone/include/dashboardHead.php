<div class="text-white card-img-top bg-dark font-weight-bold p-4">
    <span class="d-block mb-2"><?php echo $_SESSION['LoginClient']; ?></span>
    <a href="traitement/php/traitementDeconnexionClient.php" class="btn btn-danger btn-sm rounded-0 font-weight-bold">Deconnexion</a>
    <div class="dropdown d-inline">
        <button class="btn btn-secondary btn-sm rounded-0 font-weight-bold dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Plus
        </button>
        <div class="dropdown-menu rounded-0 shadow" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item font-weight-bold" href="clientDashboard.php">Acueil</a>
            <a class="dropdown-item font-weight-bold" href="mdpChange.php">Changer le mot de passe</a>
            <a class="dropdown-item font-weight-bold" href="updateTel.php">Changer le numéro de téléphone</a>
        </div>
    </div>
</div>