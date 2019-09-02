<?php
//if (session_status() == PHP_SESSION_NONE) {
//    session_start();
//}

include("dbConnect.php");

if (isset($_POST['formconnexion']))
{
    $mailconnect = htmlspecialchars($_POST['mailconnect']);
    $mdpconnect = $_POST['mdpconnect'];

    if (!empty($mailconnect) AND !empty($mdpconnect))
    {

        $requser = $bdd->prepare("SELECT * FROM membre WHERE email = ?");
        $requser->execute(array($mailconnect));
        $userexist = $requser->rowCount();
        if ($userexist == 1)
        {
            $userinfo = $requser->fetch();

            //$_SESSION['nom'] = $userinfo['nom'];
            //$_SESSION['prenom'] = $userinfo['prenom'];
            //$_SESSION['telephone'] = $userinfo['telephone'];
            //$_SESSION['email'] = $userinfo['email'];
            //$_SESSION['section'] = $userinfo['section'];
            //$_SESSION['mdp'] = $userinfo['mdp'];

            if (password_verify($mdpconnect, $userinfo['mdp'])) {
                if ($userinfo['confirme'] == 1) {
                    session_start();
                    $_SESSION['id'] = $userinfo['id'];
                    header("Location: profil.php?id=" . $_SESSION['id']);
                }

                else {
                    $error = "Votre compte n'a pas encore été confirmé par un administrateur";
                }
            }
            else {$error = "Password incorrect";}

        }
        else
        {
            $error = "Adresse mail non trouvé";
        }
    }
    else
    {
        $error = "Tout les champs doivent être rempli";
    }
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
                <h1 class="page-title">Connexion</h1>
            </header>
            <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3 class="thin text-center">Connexion à mon compte</h3>
                        <p class="text-center text-muted">Vous n'avez pas encore de compte et vous faite partie de l'unité ou vos enfants en font partie ? Alors <a href="inscription.php">inscrivez-vous</a> ! </p>
                        <hr>
                        <?php
                        if (isset($error))
                        {
                            echo '<span style="color: red; ">' . $error . '</span>';
                        }
                        ?>
                        <form method="post" action="">
                            <div class="top-margin">
                                <label>Adresse e-mail <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="mailconnect">
                            </div>
                            <div class="top-margin">
                                <label>Mot de passe <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="mdpconnect">
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-lg-8">
                                    <b><a href="mdpoublie.php">Mot de passe oublié ?</a></b>
                                </div>
                                <div class="col-lg-4 text-right">
                                    <button class="btn btn-action" type="submit" name="formconnexion">Connexion</button>
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