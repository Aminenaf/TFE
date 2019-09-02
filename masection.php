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
$userchef = $requser->fetch();

$reqmembre = $bdd->prepare("SELECT * FROM brownseartscout.membre WHERE id_section = ? AND isChef = 0");
$reqmembre->execute(array($userchef['id_section']));
//$listeAnime = $reqmembre->fetch();

$reqsection = $bdd->prepare("SELECT nom_section FROM brownseartscout.section JOIN brownseartscout.membre on brownseartscout.section.id_section = brownseartscout.membre.id_section WHERE id = ?");
$reqsection->execute(array($_SESSION['id']));
$sectioninfo = $reqsection->fetch();

$membres = $bdd->query('SELECT * FROM membre ORDER BY id DESC');

if (!isset($_SESSION['id'])){
    header('Location: connexion.php');
    exit;
}

$_SESSION['id_role'] = $userchef['id_role'];
if ($userchef['isChef'] != 1) {
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
                    <h1 class="page-title">Ma section</h1>
                </header>
                <br>
                <br>
                <div class="col-md-10 col-sm-8">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h3 class="thin text-left">Membres animés de la section :  <?php echo $sectioninfo['nom_section'] ?> </h3>
                            <p class="text-left text-muted"><?php if (isset($err)) {echo $err;} ?><br>
                                <?php while ($m = $reqmembre->fetch()) {
                                $lesdoc = $bdd->prepare("SELECT * FROM document_membre WHERE id_membre = ?");
                                $lesdoc->execute(array($m['id']));
                                ?>
                                <div class="col-md-15">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <?php
                                            if (!empty($m['avatar'])) {
                                                ?>
                                                <img class="img-circle" src="membres/avatars/<?php echo $m['avatar']; ?>" alt="img" style="height: 100px;" height="inherit" width="inherit">
                                                <?php
                                            } else {
                                                ?>
                                                <img class="img-circle" src="assets/images/pp.png" style="height: 100px;" height="inherit" width="inherit">
                                            <?php } ?>
                                            <div class="col-md-10">
                                <p class="text-left text-justify"><?= $m['nom'] ?>  <?= $m['prenom'] ?><br>
                                <p class="text-left text-justify"><?= $m['email'] ?><br>
                                <p class="text-left text-justify"><?= $m['telephone'] ?><br>
                                <?php while ($f = $lesdoc->fetch()) { ?>
                                <?php if ($f['id_doc'] == 1) { ?><a target="_blank" href="membres/documents/FI/<?php echo $m['nom'].$m['prenom']."FI"."."."pdf";?>"><?php echo $m['nom'].$m['prenom']."FI"."."."pdf";?></a><br><?php } ?>
                                <?php if ($f['id_doc'] == 2) { ?><a target="_blank" href="membres/documents/DI/<?php echo $m['nom'].$m['prenom']."DI"."."."pdf";?>"><?php echo $m['nom'].$m['prenom']."DI"."."."pdf";?></a><br><?php } ?>
                                <?php if ($f['id_doc'] == 3) { ?><a target="_blank" href="membres/documents/FS/<?php echo $m['nom'].$m['prenom']."FS"."."."pdf";?>"><?php echo $m['nom'].$m['prenom']."FS"."."."pdf";?></a><br><?php } ?>
                                <?php if ($f['id_doc'] == 4) { ?><a target="_blank" href="membres/documents/AP/<?php echo $m['nom'].$m['prenom']."AP"."."."pdf";?>"><?php echo $m['nom'].$m['prenom']."AP"."."."pdf";?></a><br><?php } ?>
                            <?php } ?><hr>
                        </div>
                    </div>
                </div>
                </div>
                <?php } ?>
                        </div>
                    </div>

                </div>

            </article>
            <!-- /Article -->

        </div>
    </div>	<!-- /container -->

<?php include("footer.php") ?>

<?php include("jvs.php"); ?>