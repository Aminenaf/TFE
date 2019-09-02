<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("dbConnect.php");

if (isset($_GET['supprime']) AND !empty($_GET['supprime'])) {
    $supprime = (int) $_GET['supprime'];
    $req = $bdd->prepare('DELETE FROM membre WHERE id = ?');
    $req->execute(array($supprime));
}

if (isset($_GET['confirme']) AND !empty($_GET['confirme'])) {
    $confirme = (int) $_GET['confirme'];
    $mailconfirm = $_GET['mail'];
    $req = $bdd->prepare('UPDATE membre SET confirme = 1 WHERE id = ?');
    $req->execute(array($confirme));
    $header="MIME-Version: 1.0\r\n";
    $header.='From:"brownsea17.be"<webmaster@brownsea17.be>'."\n";
    $header.='Content-Type:text/html; charset="uft-8"'."\n";
    $header.='Content-Transfer-Encoding: 8bit';
    $message='
                                                     <html>
                                                        <body>
                                                           <div align="center">
                                                              <p>Votre compte a bien été confirmé, vous pouvez à présent vous connecter<br>
                                                                  <a href="https://www.brownsea17.be/connexion.php">https://www.brownsea17.be/connexion.php</a></p>
                                                           </div>
                                                        </body>
                                                     </html>
                                                     ';
    mail($mailconfirm, "Confirmation de compte", $message, $header);
}

if (isset($_GET['chef']) AND !empty($_GET['chef'])) {
    $chef = (int) $_GET['chef'];
    $req = $bdd->prepare('UPDATE membre SET isChef = 1, id_role = 3 WHERE id = ?');
    $req->execute(array($chef));
}


if (!isset($_SESSION['id'])){
    header('Location: connexion.php');
    exit;
}
$requser = $bdd->prepare("SELECT * FROM membre WHERE id = ?");
$requser->execute(array($_SESSION['id']));
$useradmin = $requser->fetch();

$membres = $bdd->query('SELECT * FROM membre ORDER BY id DESC');

$_SESSION['id_role'] = $useradmin['id_role'];
if ($useradmin['id_role'] > 2) {
    $err = "Vous n'avez pas accès à cette page";
}


?>

<?php include("head.php"); ?>

<?php include("header.php"); ?>

<div class="container">

    <div class="row">

        <!-- Article main content -->
        <article class="col-xs-12 maincontent">
            <header class="page-header">
                <h1 class="page-title">Page Administration</h1>
            </header>
            <br>
            <br>
            <div class="col-md-10 col-sm-8">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3 class="thin text-left">Utilisateurs</h3>
                        <p class="text-left text-muted"><?php if (isset($err)) {echo $err;} ?><br>
                            <?php while ($m = $membres->fetch()) { ?>
                        <p class="text-left text-justify"><?= $m['nom'] ?>  <?= $m['prenom'] ?><br>
                        <p class="text-left text-justify">Adresse e-mail : <?= $m['email'] ?><br>
                        <p><a class="btn btn-danger" href="admin.php?supprime=<?= $m['id'] ?>" role="button">Supprimer</a>
                            <?php if ($m['confirme'] == 0) { ?><a class="btn btn-success" href="admin.php?confirme=<?= $m['id'] ?>&mail=<?= $m['email'] ?>" role="button">Confirmer</a><?php } ?>
                            <?php if ($m['isChef'] == 0) { ?><a class="btn btn-warning" href="admin.php?chef=<?= $m['id'] ?>" role="button">Approuvé chef</a></p><?php } ?><hr>
                            <?php } ?>
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