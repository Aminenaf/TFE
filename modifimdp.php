<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("dbConnect.php");


if (!isset($_SESSION['id'])){
    header('Location: connexion.php');
    exit;
}

$requser = $bdd->prepare("SELECT * FROM membre WHERE id = ?");
$requser->execute(array($_SESSION['id']));
$user = $requser->fetch();

if (isset($_POST['retourprofil'])) {header('Location: profil.php?id='.$_SESSION['id']);}

if(!empty($_POST)) {
extract($_POST);
$valid = true;

    if (isset($_POST['formmdp']))
    {
        if (isset($_POST['oldmdp']) AND !empty($_POST['oldmdp']) AND isset($_POST['newmdp']) AND !empty($_POST['newmdp']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2']))
        {
            $oldmdp = $_POST['oldmdp'];
            $newmdp = $_POST['newmdp'];
            $newmdp2 = $_POST['newmdp2'];
            $newmdpHash = password_hash($newmdp, PASSWORD_BCRYPT);
            $newmdp2Hash = password_hash($newmdp2, PASSWORD_BCRYPT);

            if (password_verify($oldmdp, $user['mdp']))
            {
                if ($newmdp == $newmdp2)
                {
                    if (strlen($newmdp) > 6)
                    {
                        if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])#', $newmdp))
                        {
                            $insertmdp = $bdd->prepare("UPDATE membre SET mdp = ? WHERE id = ?");
                            $insertmdp->execute(array($newmdpHash, $_SESSION['id']));
                            header('Location: profil.php?id=' . $_SESSION['id']);
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
            else
            {
                $msg = "L'ancien mot de passe ne correspond pas";
            }
        }
        else { $msg = "Veuillez remplir tout les champs"; }
    }
}

?>

<?php include("head.php"); ?>

<?php include("header.php"); ?>

<div class="container">

    <div class="row">

        <!-- Article main content -->
        <article class="col-xs-12 maincontent">
            <header class="page-header">
                <h1 class="page-title">Modification du mot de passe</h1>
            </header>
            <br>
            <br>
            <div class="col-md-14">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3 class="thin text-center">Vous pouvez modifier votre mot de passe ci-dessous</h3>
                        <hr>
                        <form method="post" action="">
                            <div class="row top-margin">
                                <div class="col-sm-4">
                                    <label>Ancien mot de passe</label>
                                    <input type="password" class="form-control" name="oldmdp">
                                </div>
                                <div class="col-sm-4">
                                    <label>Nouveau mot de passe</label>
                                    <input type="password" class="form-control" name="newmdp">
                                </div>
                                <div class="col-sm-4">
                                    <label>Confirmer mot de passe</label>
                                    <input type="password" class="form-control" name="newmdp2">
                                </div>
                            </div>
                            <hr>
                            <span class="text-danger"><?php if (isset($msg)) {echo $msg;}?></span>
                            <hr>
                            <div class="row">
                                <div class="col-lg-4">
                                    <button class="btn btn-action2" type="submit" name="retourprofil">Profil</button>
                                </div>
                                <div class="col-lg-8 text-right">
                                    <button class="btn btn-action" type="submit" name="formmdp">Modifier</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </article>
        <!-- /Article -->

    </div>
</div>    <!-- /container -->

<?php include("footer.php") ?>

<?php include("jvs.php"); ?>