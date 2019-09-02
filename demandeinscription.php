<?php

if (isset($_POST['demandeInscription'])) {

    $nomi = htmlspecialchars($_POST['nomi']);
    $prenomi = htmlspecialchars($_POST['prenomi']);
    $dateNaissi = htmlspecialchars($_POST['dateNaissi']);
    $anneescol = htmlspecialchars($_POST['anneescol']);
    $commune = htmlspecialchars($_POST['commune']);
    $tel1 = htmlspecialchars($_POST['tel1']);
    $tel2 = htmlspecialchars($_POST['tel2']);
    $emaili = htmlspecialchars($_POST['emaili']);
    $section = htmlspecialchars($_POST['section']);
    $comi = htmlspecialchars($_POST['comi']);
    $mailStaff = "amine.naf@hotmail.com";

        if (!empty($_POST['nomi']) AND !empty($_POST['prenomi']) AND !empty($_POST['dateNaissi']) AND !empty($_POST['anneescol']) AND !empty($_POST['commune']) AND !empty($_POST['tel1']) AND !empty($_POST['tel2']) AND !empty($_POST['emaili']))
        {
            if (filter_var($emaili, FILTER_VALIDATE_EMAIL)) {
                $header="MIME-Version: 1.0\r\n";
                $header.='From:'.$emaili."\n";
                $header.='Content-Type:text/html; charset="uft-8"'."\n";
                $header.='Content-Transfer-Encoding: 8bit';
                $message='
                            <html>
                            <body>
                            <div align="center">
                                <p>Vous avez une demande d\'inscription : </p><br>
                                <p>Nom : ' . $nomi . '</p><br>
                                <p>Prenom : ' . $prenomi . '</p><br>
                                <p>Date de naissance : ' . $dateNaissi . '</p><br>
                                <p>Année scolaire: ' . $anneescol . '</p><br>
                                <p>Commune : ' . $commune . '</p><br>
                                <p>Telephone 1  : ' . $tel1 . '</p><br>
                                <p>Telephone 2 (Si pas joignable) : ' . $tel2 . '</p><br>
                                <p>Section : ' . $section . '</p><br>
                                <p>Commentaire : ' . $comi . '</p><br>
                            </div>
                            </body>
                            </html>
                            ';
                mail("webmaster@brownsea17.be","Demande d'inscription", $message, $header);
                $msg = "La demande à bien été envoyée";
            }
        }
}

?>

<?php include("head.php"); ?>

<?php include("header.php"); ?>

<div class="container">

    <ol class="breadcrumb">
        <li><a href="index.php">Acceuil</a></li>
        <li class="active">Demande d'inscription</li>
    </ol>

    <div class="row">

        <!-- Article main content -->
        <article class="col-sm-12 maincontent">
            <header class="page-header">
                <h1 class="page-title text-center">Demande d'inscription pour mon enfant</h1>
            </header>
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3 class="thin text-center">Demande Inscription</h3>
                    <p class="text-center text-muted">Un mail sera envoyé aux staffs, nous vous répondrons dans les plus brefs délais</p>
                    <?php if (isset($msg)) { echo '<span style="color: green; ">' . $msg . '</span>'; } ?>
            <form method="post" action="demandeinscription.php" enctype="multipart/form-data">
                <div class="row top-margin">
                    <div class="col-sm-4">
                        <label>Nom <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nomi" value="" required>
                    </div>
                    <div class="col-sm-4">
                        <label>Prénom <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="prenomi" value="" required>
                    </div>
                    <div class="col-sm-4">
                        <label>Date de Naissance<span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="dateNaissi" value="" required>
                    </div>
                </div>
                <br>
                <div class="row top-margin">
                    <div class="col-sm-4">
                        <label>Année scolaire <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="anneescol" value="(Ex: 3ème primaire)" required>
                    </div>
                    <div class="col-sm-4">
                        <label>Commune <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="commune" value="(Ex: Rixensart)" required>
                    </div>
                    <div class="col-sm-4">
                        <label>Telephone 1 <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" name="tel1" value="" required>
                    </div>
                </div>
                <br>
                <div class="row top-margin">
                    <div class="col-sm-4">
                        <label>Telephone 2 (Si Tel 1 non-joignable) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="tel2" value="" required>
                    </div>
                    <div class="col-sm-4">
                        <label>Adresse email <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="emaili" value="" required>
                    </div>
                    <div class="col-sm-4">
                        <label>Section <span class="text-danger">*</span></label><br>
                        <select name="section" class="form-control">
                            <option value="1">Baladins</option>
                            <option value="2">Louveteaux</option>
                            <option value="3">Eclaireurs</option>
                            <option value="4">Pionniers</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row top-margin">
                    <div class="col-sm-10">
                        <label>Commentaire :</label>
                        <textarea placeholder="Ecrivez votre message ici ..." class="form-control" rows="5" name="commi"></textarea>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-6">
                        <input class="btn btn-action" type="submit" value="Envoyer" name="demandeInscription">
                    </div>
                </div>
            </form>
                </div>
            </div>

        </article>
        <!-- /Article -->

    </div>
</div>	<!-- /container -->
    <script src="https://www.google.com/recaptcha/api.js?render=6Le6FbIUAAAAACTlQSXxa0Xt20MlAx77-XfgNFMO"></script>
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('6Le6FbIUAAAAACTlQSXxa0Xt20MlAx77-XfgNFMO', {action: 'homepage'}).then(function(token) {
                console.log(token);
            });
        });
    </script>

<?php include("footer.php") ?>


<?php include("jvs.php"); ?>