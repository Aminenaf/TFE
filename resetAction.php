<?php
date_default_timezone_set('Europe/Brussels');

$token = $_GET['token'];
$mailoublie = $_GET['mail'];

include("dbConnect.php");

$req = $bdd->prepare("SELECT token_mdp,token_mdp_exp FROM token WHERE token_mdp = ?");
$req->execute(array($token));
$user = $req->fetch();
$dateexp = $user['token_mdp_exp'];
$datenow = date("Y-m-d H:i:s");

if ($user['token_mdp'] == $token && $dateexp > $datenow) {

    if (isset($_POST['mdpoublie']))
    {
        if (isset($_POST['mdpoublie1']) AND !empty($_POST['mdpoublie1']) AND isset($_POST['mdpoublie2']) AND !empty($_POST['mdpoublie2']))
        {
            $mdpoublie1 = $_POST['mdpoublie1'];
            $mdpoublie2 = $_POST['mdpoublie2'];
            $mdpoublieHash = password_hash($mdpoublie1, PASSWORD_BCRYPT);
            $mdpoublie2Hash = password_hash($mdpoublie2, PASSWORD_BCRYPT);

                if ($mdpoublie1 == $mdpoublie2)
                {
                    if (strlen($mdpoublie1) > 6)
                    {
                        if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])#', $mdpoublie1))
                        {
                            $insertnewmdp = $bdd->prepare("UPDATE membre SET mdp = ? WHERE email = ?");
                            $insertnewmdp->execute(array($mdpoublieHash, $mailoublie));
                            $correct = "Votre mot de passe à bien été modifié, vous pouvez à présent vous connecter<br>
                                        <a href='https://www.brownsea17.be/connexion.php'>Connexion</a>";


                        }
                        else {
                            $msg = "Votre nouveau mot de passe doit comporter des minuscules, des majuscules et des chiffres";
                        }
                    }
                    else
                    {
                        $msg = "Le nouveau mot de passe doit contenir au minimum 6 caractères ";
                    }
                }
                else
                {
                    $msg = "Les nouveaux mots de passe ne correspondent pas";
                }
        }
        else { $msg = "Veuillez remplir tout les champs"; }
    }
    ?>

    <?php include("head.php"); ?>

<?php include("header.php"); ?>

<div class="container">

    <ol class="breadcrumb">
        <li><a href="index.php">Acceuil</a></li>
        <li class="active">Accès utilisateur</li>
    </ol>

    <div class="row">

        <!-- Article main content -->
        <article class="col-xs-12 maincontent">
            <header class="page-header">
                <h1 class="page-title">Mot de passe oublié</h1>
            </header>

            <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3 class="thin text-center">Mot de passe oublié</h3>
                        <p class="text-center text-muted">Nouveau mot de passe</p>
                        <hr>
                        <?php
                        if (isset($msg) || isset($correct))
                        {
                            echo '<span style="color: red; ">' . $msg . '</span>';
                            echo '<span style="color: green; ">' . $correct . '</span>';
                        }
                        ?>
                        <form method="post" action="">
                            <div class="top-margin">
                                <label>Nouveau mot de passe<span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="mdpoublie1">
                            </div>
                            <div class="top-margin">
                                <label>Confirmation mot de passe<span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="mdpoublie2">
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-lg-4 text-right">
                                    <button class="btn btn-action" type="submit" name="mdpoublie">Confirmer</button>
                                </div>
                            </div>
                        </form>
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
                        <p class="text-center text-muted">Vous pouvez refaire une demande via le formulaire <br>
                            <a href="mdpoublié.php">Mot de passe oublié</a> !</p>
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

