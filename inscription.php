<?php

include("dbConnect.php");

if(isset($_POST['forminscription']))
{
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $telephone = htmlspecialchars($_POST['telephone']);
    $mail = htmlspecialchars($_POST['mail']);
    $mail2 = htmlspecialchars($_POST['mail2']);
    $idsection = $_POST['section'];
    $mdp = $_POST['mdp'];
    $mdpHash = password_hash($mdp, PASSWORD_BCRYPT);
    $mdp2 = $_POST['mdp2'];
    $mdpHash2 = password_hash($mdp2, PASSWORD_BCRYPT);
    $dateNaiss = $_POST['dateNaiss'];

    if(!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['dateNaiss']) AND !empty($_POST['telephone']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2']))
    {
        $nomlenght = strlen($nom);
        $prenomlenght = strlen($prenom);
        $telephonelenght = strlen($telephone);

        if ($nomlenght <= 45)
        {
            if ($prenomlenght <= 45)
            {
                if ($telephonelenght <= 15)
                {
                    if ($mail == $mail2) {
                        if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                            $reqmail = $bdd->prepare("SELECT * FROM membre WHERE email = ?");
                            $reqmail->execute(array($mail));
                            $mailexist = $reqmail->rowCount();
                            if ($mailexist == 0) {
                                if ($mdp == $mdp2) {
                                   if (strlen($mdp) > 6) {
                                       if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])#', $mdp)) {
                                           $insertmbr = $bdd->prepare("INSERT INTO membre(nom, prenom, date_naissance, telephone, email, mdp, id_section, date_inscription) VALUES(?,?,?,?,?,?,?,now())");
                                           $insertmbr->execute(array($nom, $prenom, $dateNaiss, $telephone, $mail, $mdpHash, $idsection));
                                           $correct = "Votre compte a bien été créé, un mail d'activation vous sera envoyé une fois qu'un administrateur aura confirmé votre compte<br>";
                                       } else {$error = "Votre mot de passe doit comporter des minuscules, des majuscules et des chiffres";}
                                   } else {$error = 'Le mot de passe doit contenir minimum 6 caractères';}
                                } else { $error = "Les mots de passe ne correspondent pas"; }
                            } else {
                                $error = "Adresse mail déjà utilisée";
                            }
                        } else {
                            $error = "Votre adresse mail n'est pas valide";
                        }
                    } else {
                        $error = "Les mails ne correspondent pas";
                    }
                }
                else {
                    $error = "Le numéro de téléphone n'est pas conforme";
                }
            }
            else {
                $error = "Le prénom ne peut pas dépasser 45 caractères";
            }
        }
        else
        {
            $error = "Le nom ne peut pas dépasser 45 caractères";
        }
    }
    else
    {
        $error = 'Tous les champs doivent être completé';
    }
}
?>

<?php include("head.php"); ?>

<?php include("header.php"); ?>

<div class="container">

    <ol class="breadcrumb">
        <li><a href="index.php">Acceuil</a></li>
        <li class="active">Inscription</li>
    </ol>

    <div class="row">

        <!-- Article main content -->
        <article class="col-xs-12 maincontent">
            <header class="page-header">
                <h1 class="page-title">Inscription</h1>
            </header>

            <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3 class="thin text-center">Enregistrer un nouveau compte</h3>
                        <p class="text-center text-muted">Si vous avez déjà un compte vous pouvez directement vous <a href="connexion.php">connecter</a> ! </p>
                        <hr>
                        <?php
                        if (isset($error) || isset($correct))
                        {
                            echo '<span style="color: red; ">' . $error . '</span>';
                            echo '<span style="color: green; ">' . $correct . '</span>';
                        }
                        ?>

                        <form method="post" action="inscription.php" enctype="multipart/form-data">
                            <div class="top-margin">
                                <label>Nom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nom" value="<?php if(isset($nom)) {echo $nom;} ?>" required>
                            </div>
                            <div class="top-margin">
                                <label>Prenom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="prenom" value="<?php if(isset($prenom)) {echo $prenom;} ?>" required>
                            </div>
                            <div class="top-margin">
                                <label>Date de naissance <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="dateNaiss" value="<?php if(isset($dateNaiss)) {echo $dateNaiss;} ?>" required>
                            </div>
                            <div class="top-margin">
                                <label>Numéro de telephone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="telephone" value="<?php if(isset($telephone)) {echo $telephone;} ?>" required>
                            </div>
                            <div class="top-margin">
                                <label>Adresse e-mail <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="mail" value="<?php if(isset($mail)) {echo $mail;} ?>" required>
                            </div>
                            <div class="top-margin">
                                <label>Confirmer mon adresse mail <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="mail2" value="<?php if(isset($mail2)) {echo $mail2;} ?>" required>
                            </div>
                            <div class="row top-margin">
                                <div class="col-sm-6">
                                    <label>Mot de passe <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="mdp" required>
                                </div>
                                <div class="col-sm-6">
                                    <label>Confirmer mot de passe <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="mdp2" required>
                                </div>
                            </div>
                            <div class="top-margin">
                                <label>Section <span class="text-danger">*</span></label><br>
                                <select name="section" class="form-control">
                                    <option value="1">Baladins</option>
                                    <option value="2">Louveteaux</option>
                                    <option value="3">Eclaireurs</option>
                                    <option value="4">Pionniers</option>
                                    <option value="5">La Tribu</option>
                                    <option value="6">Staff d'unité</option>
                                    <option value="7">Parent</option>
                                    <option value="8">Ancien</option>
                                </select>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-lg-4 text-right">
                                    <button class="btn btn-action" type="submit" name="forminscription">Je m'inscris ! </button>
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
