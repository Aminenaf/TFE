<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("dbConnect.php");


if (!isset($_SESSION['id'])){
    header('Location: connexion.php');
    exit;
}

clearstatcache();

$requser = $bdd->prepare("SELECT * FROM membre WHERE id = ?");
$requser->execute(array($_SESSION['id']));
$user = $requser->fetch();

$reqdocument1 = $bdd->prepare("SELECT * FROM document_membre WHERE id_membre = ? AND id_doc = 1");
$reqdocument1->execute(array($_SESSION['id']));
$doc1 = $reqdocument1->rowCount();

$reqdocument2 = $bdd->prepare("SELECT * FROM document_membre WHERE id_membre = ? AND id_doc = 2");
$reqdocument2->execute(array($_SESSION['id']));
$doc2 = $reqdocument2->rowCount();

$reqdocument3 = $bdd->prepare("SELECT * FROM document_membre WHERE id_membre = ? AND id_doc = 3");
$reqdocument3->execute(array($_SESSION['id']));
$doc3 = $reqdocument3->rowCount();

$reqdocument4 = $bdd->prepare("SELECT * FROM document_membre WHERE id_membre = ? AND id_doc = 4");
$reqdocument4->execute(array($_SESSION['id']));
$doc4 = $reqdocument4->rowCount();

if (isset($_POST['retourprofil'])) {header('Location: profil.php?id='.$_SESSION['id']);}

if(!empty($_POST)) {
    extract($_POST);
    $valid = true;

    if (isset($_POST['modifierdoc'])) {

        if (isset($_FILES['doc1']) AND !empty($_FILES['doc1']['name'])) {
            $tailleMax1 = 2097152;
            $extensionsValides1 = array('pdf');
            if ($_FILES['doc1']['size'] <= $tailleMax1) {
                $extensionUpload1 = strtolower(substr(strrchr($_FILES['doc1']['name'], '.'), 1));
                if (in_array($extensionUpload1, $extensionsValides1)) {
                    $chemin1 = "membres/documents/FI/" . $user['nom'] . $user['prenom'] . "FI" . "." . $extensionUpload1;
                    $resultat1 = move_uploaded_file($_FILES['doc1']['tmp_name'], $chemin1);
                    if ($resultat1) {
                        $reqdoc1 = $bdd->prepare("SELECT * FROM document_membre WHERE id_membre = ? AND id_doc = 1");
                        $reqdoc1->execute(array($_SESSION['id']));
                        $docexist1 = $reqdoc1->rowCount();
                        if ($docexist1 == 0) {
                            $updatedoc1 = $bdd->prepare('INSERT INTO document_membre(id_membre, id_doc) VALUES(?,1)');
                            $updatedoc1->execute(array($_SESSION['id']));
                            //header('Location: profil.php?id=' . $_SESSION['id']);
                        } else {
                            //header('Location: profil.php?id=' . $_SESSION['id']);
                        }
                    } else {
                        $err_doc1 = "Erreur durant l'importation du fichier";
                        $valid = false;
                    }
                } else {
                    $err_doc1 = "Votre fichier doit être au format PDF";
                    $valid = false;
                }
            } else {
                $err_doc1 = "Votre fichier ne doit pas dépasser 2Mo";
                $valid = false;
            }
        }

        if (isset($_FILES['doc2']) AND !empty($_FILES['doc2']['name'])) {
            $tailleMax2 = 2097152;
            $extensionsValides2 = array('pdf');
            if ($_FILES['doc2']['size'] <= $tailleMax2) {
                $extensionUpload2 = strtolower(substr(strrchr($_FILES['doc2']['name'], '.'), 1));
                if (in_array($extensionUpload2, $extensionsValides2)) {
                    $chemin2 = "membres/documents/DI/" . $user['nom'] . $user['prenom'] . "DI" . "." . $extensionUpload2;
                    $resultat2 = move_uploaded_file($_FILES['doc2']['tmp_name'], $chemin2);
                    if ($resultat2) {
                        $reqdoc2 = $bdd->prepare("SELECT * FROM document_membre WHERE id_membre = ? AND id_doc = 2");
                        $reqdoc2->execute(array($_SESSION['id']));
                        $docexist2 = $reqdoc2->rowCount();
                        if ($docexist2 == 0) {
                            $updatedoc2 = $bdd->prepare('INSERT INTO document_membre(id_membre, id_doc) VALUES(?,2)');
                            $updatedoc2->execute(array($_SESSION['id']));
                            header('Location: profil.php?id=' . $_SESSION['id']);
                        } else {
                            header('Location: profil.php?id=' . $_SESSION['id']);
                        }
                    } else {
                        $err_doc2 = "Erreur durant l'importation de votre fichier";
                        $valid = false;
                    }
                } else {
                    $err_doc2 = "Votre fichier doit être au format PDF";
                    $valid = false;
                }
            } else {
                $err_doc2 = "Votre fichier ne doit pas dépasser 2Mo";
                $valid = false;
            }
        }

        if (isset($_FILES['doc3']) AND !empty($_FILES['doc3']['name'])) {
            $tailleMax3 = 2097152;
            $extensionsValides3 = array('pdf');
            if ($_FILES['doc3']['size'] <= $tailleMax3) {
                $extensionUpload3 = strtolower(substr(strrchr($_FILES['doc3']['name'], '.'), 1));
                if (in_array($extensionUpload3, $extensionsValides3)) {
                    $chemin3 = "membres/documents/FS/" . $user['nom'] . $user['prenom'] . "FS" . "." . $extensionUpload3;
                    $resultat3 = move_uploaded_file($_FILES['doc3']['tmp_name'], $chemin3);
                    if ($resultat3) {
                        $reqdoc3 = $bdd->prepare("SELECT * FROM document_membre WHERE id_membre = ? AND id_doc = 3");
                        $reqdoc3->execute(array($_SESSION['id']));
                        $docexist3 = $reqdoc3->rowCount();
                        if ($docexist3 == 0) {
                            $updatedoc3 = $bdd->prepare('INSERT INTO document_membre(id_membre, id_doc) VALUES(?,3)');
                            $updatedoc3->execute(array($_SESSION['id']));
                            header('Location: profil.php?id=' . $_SESSION['id']);
                        } else {
                            header('Location: profil.php?id=' . $_SESSION['id']);
                        }
                    } else {
                        $err_doc3 = "Erreur durant l'importation de votre fichier";
                        $valid = false;
                    }
                } else {
                    $err_doc3 = "Votre fichier doit être au format PDF";
                    $valid = false;
                }
            } else {
                $err_doc3 = "Votre fichier ne doit pas dépasser 2Mo";
                $valid = false;
            }
        }

        if (isset($_FILES['doc4']) AND !empty($_FILES['doc4']['name'])) {
            $tailleMax4 = 2097152;
            $extensionsValides4 = array('pdf');
            if ($_FILES['doc4']['size'] <= $tailleMax4) {
                $extensionUpload4 = strtolower(substr(strrchr($_FILES['doc4']['name'], '.'), 1));
                if (in_array($extensionUpload4, $extensionsValides4)) {
                    $chemin4 = "membres/documents/AP/" . $user['nom'] . $user['prenom'] . "AP" . "." . $extensionUpload4;
                    $resultat4 = move_uploaded_file($_FILES['doc4']['tmp_name'], $chemin4);
                    if ($resultat4) {
                        $reqdoc4 = $bdd->prepare("SELECT * FROM document_membre WHERE id_membre = ? AND id_doc = 4");
                        $reqdoc4->execute(array($_SESSION['id']));
                        $docexist4 = $reqdoc4->rowCount();
                        if ($docexist4 == 0) {
                            $updatedoc4 = $bdd->prepare('INSERT INTO document_membre(id_membre, id_doc) VALUES(?,4)');
                            $updatedoc4->execute(array($_SESSION['id']));
                            header('Location: profil.php?id=' . $_SESSION['id']);
                        } else {
                            header('Location: profil.php?id=' . $_SESSION['id']);
                        }
                    } else {
                        $err_doc4 = "Erreur durant l'importation de votre fichier";
                        $valid = false;
                    }
                } else {
                    $err_doc4 = "Votre fichier doit être au format PDF";
                    $valid = false;
                }
            } else {
                $err_doc4 = "Votre fichier ne doit pas dépasser 2Mo";
                $valid = false;
            }
        }
    }

    if ($valid) {
        clearstatcache();
        header('Location: profil.php?id='.$_SESSION['id']);
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
                <h1 class="page-title">Mes documents</h1>
            </header>
            <br>
            <br>
            <div class="col-md-7">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3 class="thin text-center">Vous pouvez ajouter ou modifier vos fichiers</h3>
                        <p>Ajouter un nouveau fichier pour remplacer le précédent.</p>
                        <p>Vous pouvez télécharger les documents vierges dans l'onglet <a href="document.php">Documents</a></p>
                        <hr>
                        <span class="text-danger">
                            <?php
                            if (isset($err_doc1)) {echo $err_doc1;}
                            if (isset($err_doc2)) {echo $err_doc2;}
                            if (isset($err_doc3)) {echo $err_doc3;}
                            if (isset($err_doc4)) {echo $err_doc4;}
                            ?></span>
                        <form method="post" enctype="multipart/form-data" action="">
                        <div class="top-margin">
                            <label>Fiche d'inscription</label><br>
                            <input type="file" class="form-control" name="doc1">
                        </div><br>
                            <p>Fichier déjà téléchargé : <?php if ($doc1 == 1) { ?><a target="_blank" href="membres/documents/FI/<?php echo $user['nom'].$user['prenom']."FI"."."."pdf";?>"><?php echo $user['nom'].$user['prenom']."FI"."."."pdf";?></a><?php } ?></p>
                            <hr>
                        <div class="top-margin">
                            <label>Droit à l'image</label><br>
                            <input type="file" class="form-control" name="doc2">
                        </div><br>
                            <p>Fichier déjà téléchargé : <?php if ($doc2 == 1) { ?><a target="_blank" href="membres/documents/DI/<?php echo $user['nom'].$user['prenom']."DI"."."."pdf";?>"><?php echo $user['nom'].$user['prenom']."DI"."."."pdf";?></a><?php } ?></p>
                            <hr>
                        <div class="top-margin">
                            <label>Fiche Santé</label><br>
                            <input type="file" class="form-control" name="doc3">
                        </div><br>
                            <p>Fichier déjà téléchargé : <?php if ($doc3 == 1) { ?><a target="_blank" href="membres/documents/FS/<?php echo $user['nom'].$user['prenom']."FS"."."."pdf";?>"><?php echo $user['nom'].$user['prenom']."FS"."."."pdf";?></a><?php } ?></p>
                            <hr>
                        <div class="top-margin">
                            <label>Autorisation Parental</label><br>
                            <input type="file" class="form-control" name="doc4">
                        </div><br>
                            <p>Fichier déjà téléchargé : <?php if ($doc4 == 1) { ?><a target="_blank" href="membres/documents/AP/<?php echo $user['nom'].$user['prenom']."AP"."."."pdf";?>"><?php echo $user['nom'].$user['prenom']."AP"."."."pdf";?></a><?php } ?></p>
                            <hr>
                            <div class="row">
                                <div class="col-lg-4">
                                    <button class="btn btn-action2" type="submit" name="retourprofil">Profil</button>
                                </div>
                                <div class="col-lg-8 text-right">
                                    <button class="btn btn-action" type="submit" name="modifierdoc">Modifier</button>
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
