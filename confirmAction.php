<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('Europe/Brussels');

$token = $_GET['token'];

include("dbConnect.php");

$req = $bdd->prepare("SELECT token_mail,token_mail_exp FROM token WHERE token_mail = ?");
$req->execute(array($token));
$user = $req->fetch();
$dateexp = $user['token_mail_exp'];
$datenow = date("Y-m-d H:i:s");

//if ($user['token_mail'] == $token && $dateexp > $datenow) {
    //$insertmbr = $bdd->prepare("INSERT INTO membre(nom, prenom, date_naissance, telephone, email, mdp, id_section, date_inscription) VALUES(?,?,?,?,?,?,?,now())");
    //$insertmbr->execute(array($_POST['nom'], $_SESSION['prenom'], $_SESSION['dateNaiss'], $_SESSION['telephone'], $_SESSION['mail'], $_SESSION['mdp'], $_SESSION['idsection']));
    //var_dump($_POST['forminscription']);
    ?>

    <?php include("head.php"); ?>

    <?php include("header.php"); ?>

    <div class="container">

        <div class="row">

            <!-- Article main content -->
            <article class="col-xs-12 maincontent">
                <header class="page-header">
                    <h1 class="page-title">Félicitation</h1>
                </header>
                <br>
                <br>
                <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h3 class="thin text-center">Votre compte à bien été créé</h3>
                            <p class="text-center text-muted">Vous pouvez à présent vous connecter sur votre compte<br>
                                <a href="connexion.php">Connexion</a> !</p>
                            <hr>
                        </div>
                    </div>

                </div>

            </article>
            <!-- /Article -->

        </div>
    </div>    <!-- /container -->

    <?php include("footer.php") ?>

    <?php include("jvs.php"); ?>

    <?php
}
else {
    ?>

    <?php include("head.php"); ?>

    <?php include("header.php"); ?>

    <div class="container">

        <div class="row">

            <!-- Article main content -->
            <article class="col-xs-12 maincontent">
                <header class="page-header">
                    <h1 class="page-title">Erreur</h1>
                </header>
                <br>
                <br>
                <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h3 class="thin text-center">Votre lien à expiré</h3>
                            <p class="text-center text-muted">Vous pouvez refaire une demande d'inscription via le formulaire<br>
                                <a href="inscription.php">Inscription</a> !</p>
                            <hr>
                        </div>
                    </div>

                </div>

            </article>
            <!-- /Article -->

        </div>
    </div>	<!-- /container -->

    <?php include("footer.php") ?>

    <?php include("jvs.php"); ?>

<?php
}
?>