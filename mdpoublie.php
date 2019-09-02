<?php

include("dbConnect.php");

if (isset($_POST['formmdp']))
{
    $mailmdpoublié = htmlspecialchars($_POST['mailmdpoublié']);

    if (!empty($mailmdpoublié))
    {
        $requser = $bdd->prepare("SELECT * FROM membre WHERE email = ?");
        $requser->execute(array($mailmdpoublié));
        $userexist = $requser->rowCount();
        if ($userexist == 1)
        {
            $userinfo = $requser->fetch();
            $_SESSION['id'] = $userinfo['id'];
            $userinfoid = $userinfo['id'];
            //$_SESSION['nom'] = $userinfo['nom'];
            //$_SESSION['prenom'] = $userinfo['prenom'];
            //$_SESSION['telephone'] = $userinfo['telephone'];
            //$_SESSION['email'] = $userinfo['email'];
            //$_SESSION['section'] = $userinfo['section'];

            //header("Location: profil.php?id=".$_SESSION['id']);
            //$error = "Ce mail existe";
            $token = bin2hex(random_bytes(9));
            $newtoken = $bdd->prepare("INSERT INTO token(token_mdp, token_mdp_exp) VALUE (?,now() + INTERVAL 24 HOUR)");
            $newtoken->execute(array($token));
            $header="MIME-Version: 1.0\r\n";
            $header.='From:"brownsea17.be"<webmaster@brownsea17.be>'."\n";
            $header.='Content-Type:text/html; charset="uft-8"'."\n";
            $header.='Content-Transfer-Encoding: 8bit';
            $message='
                                                     <html>
                                                        <body>
                                                           <div align="center">
                                                              <p>Vous avez oublié votre mot de passe</p><br>
                                                              <p>Le lien ci-dessous n\'est plus valide après 24h à partir du moment ou vous avez fait une demande de nouveau mot de passe</p><br>
                                                              <p>Veuillez cliquer sur ce lien pour créer un nouveau mot de passe</p><br>
                                                              <a class="btn-success"  href="https://www.brownsea17.be/resetAction.php?token=' . $token . '&mail=' . $mailmdpoublié .'">Clickez ici</a>   
                                                           </div>
                                                        </body>
                                                     </html>
                                                     ';
            mail($mailmdpoublié, "Récuperation de mot de passe", $message, $header);
            $correct = "Votre demande à bien été prise en compte, un mail vous à été envoyé.<br>
                        Attention, vous avez 24h pour effectuer le changement.";
            //Voici votre token : <a href='http://localhost/tfe/resetAction.php?token=$token'>Clickez ici</a> <br>
            //Le lien ci-dessus n'est plus valide après 24h à partir du moment ou vous avez fait une demande de nouveau mot de passe <br>
            //Merci ";
        }
        else
        {
            $error = "Ce mail n'existe pas";
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
                <h1 class="page-title">Mot de passe oublié</h1>
            </header>

            <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3 class="thin text-center">Mot de passe oublié</h3>
                        <p class="text-center text-muted">Un mail vous sera envoyé sur votre boite mail</p>
                        <hr>
                        <?php
                        if (isset($error) || isset($correct))
                        {
                            echo '<span style="color: red; ">' . $error . '</span>';
                            echo '<span style="color: green; ">' . $correct . '</span>';
                        }
                        ?>
                        <form method="post" action="">
                            <div class="top-margin">
                                <label>Adresse e-mail <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="mailmdpoublié">
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-lg-4 text-right">
                                    <button class="btn btn-action" type="submit" name="formmdp">Envoyer nouveau mot de passe</button>
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
