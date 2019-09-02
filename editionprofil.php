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



if(!empty($_POST)) {
    extract($_POST);
    $valid = true;

    if (isset($_POST['modifierprofil'])) {
        $newnom = htmlspecialchars(trim($_POST['newnom']));
        $newprenom = htmlspecialchars(trim($_POST['newprenom']));
        $newdate = $_POST['newdateNaiss'];
        $newtelephone = htmlspecialchars(trim($_POST['newtelephone']));
        $newtotem = htmlspecialchars(trim($_POST['newtotem']));
        $newquali = htmlspecialchars(trim($_POST['newquali']));
        $newmail = htmlspecialchars(trim($_POST['newmail']));
        $newsection = $_POST['newsection'];



        if (empty($_POST['newnom'])) {
            $valid = false;
            $er_nom = "Il faut mettre un nom";
        }

        if (empty($_POST['newprenom'])) {
            $valid = false;
            $er_prenom = "Il faut mettre un prenom";
        }

            if (empty($_POST['newdateNaiss'])) {
                $valid = false;
                $er_date = "Il faut mettre une date de naissance";
            }


        if (empty($_POST['newtelephone'])) {
            $valid = false;
            $er_tel = "Il faut mettre un numéro de telephone";
        }

        if (empty($_POST['newmail'])) {
            $valid = false;
            $er_mail = "Il faut mettre un mail";
        } elseif (!filter_var($newmail, FILTER_VALIDATE_EMAIL)) {
            $valid = false;
            $er_mail = "Le mail n'est pas valide";
        } elseif ($newmail != $user['email']) {
            $reqmail = $bdd->prepare("SELECT * FROM membre WHERE email = ?");
            $reqmail->execute(array($newmail));
            $mailexist = $reqmail->rowCount();
            if ($mailexist >= 1) {
                $valid = false;
                $er_mail = "Ce mail existe déjà";
            }
        }
    }



        if ($valid){

            $modifprofil = $bdd->prepare("UPDATE membre SET nom = ?, prenom = ?, date_naissance = ?, telephone = ?, totem = ?, quali = ?, email = ?, id_section = ? WHERE id = ?");
            $modifprofil->execute(array($newnom, $newprenom, $newdate, $newtelephone, $newtotem, $newquali, $newmail, $newsection, $_SESSION['id']));
            header('Location: profil.php?id='.$_SESSION['id']);

        }
    }

        //if (isset($_POST['retourprofil'])) {header('Location: profil.php?id='.$_SESSION['id']);}


?>

    <?php include("head.php"); ?>

    <?php include("header.php"); ?>

    <div class="container">

        <ol class="breadcrumb">
            <li><a href="index.php">Home</a></li>
            <li><a href="profil.php?id=<?= $_SESSION['id'] ?>">Profil</a></li>
            <li class="active">Edition profil</li>
        </ol>

        <div class="row">

            <!-- Sidebar -->
            <aside class="col-md-4 sidebar sidebar-left">
                <div class="row widget">
                    <div class="col-xs-12">
                        <h4>Photo de profil</h4>
                        <?php
                        if (!empty($user['avatar'])) {
                        ?>
                        <p><img src="membres/avatars/<?php echo $user['avatar']; ?>" alt=""></p>
                        <?php
                            } else {
                            ?>
                            <p><img src="assets/images/pp.png"></p>
                        <?php } ?>
                    </div>
                </div>

            </aside>
            <!-- /Sidebar -->

            <!-- Article main content -->
            <article class="col-md-8 maincontent">
                <div class="col-md-14">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h3 class="thin text-center">Modifier mon profil</h3>
                            <hr>
                            <span class="text-danger"><?php if (isset($er_nom)) {echo $er_nom;}
                                                            if (isset($er_prenom)) {echo $er_prenom;}
                                                            if (isset($er_date)) {echo $er_date;}
                                                            if (isset($er_mail)) {echo $er_mail;}
                                                            if (isset($err_avatar)) {echo $err_avatar;}
                                                            if (isset($err_doc1)) {echo $err_doc1;}
                                                            if (isset($err_doc2)) {echo $err_doc2;}
                                                            if (isset($err_doc3)) {echo $err_doc3;}
                                                            if (isset($err_doc4)) {echo $err_doc4;}
                                                            ?></span>
                            <form method="post" action="" enctype="multipart/form-data">
                                <div class="top-margin">
                                    <label>Nom</label>
                                    <input type="text" class="form-control" name="newnom" value="<?php echo $user['nom']; ?>">
                                </div>
                                <div class="top-margin">
                                    <label>Prenom</label>
                                    <input type="text" class="form-control" name="newprenom" value="<?php echo $user['prenom']; ?>">
                                </div>
                                <div class="top-margin">
                                    <label>Date de naissance</label>
                                    <input type="date" class="form-control" name="newdateNaiss" value="<?php echo $user['date_naissance']; ?>">
                                </div>
                                <div class="top-margin">
                                    <label>Téléphone</label>
                                    <input type="text" class="form-control" name="newtelephone" value="<?php echo $user['telephone']; ?>">
                                </div>
                                <div class="top-margin">
                                    <label>Totem</label>
                                    <input type="text" class="form-control" name="newtotem" value="<?php if (isset($user['totem'])) {echo $user['totem'];} ?>">
                                </div>
                                <div class="top-margin">
                                    <label>Quali</label>
                                    <input type="text" class="form-control" name="newquali" value="<?php if (isset($user['quali'])) {echo $user['quali'];} ?>">
                                </div>
                                <div class="top-margin">
                                    <label>Adresse e-mail</label>
                                    <input type="text" class="form-control" name="newmail" value="<?php echo $user['email']; ?>">
                                </div>
                                <div class="top-margin">
                                    <label>Section</label>
                                    <select name="newsection" class="form-control">
                                        <option <?php if ($user['id_section'] == 1) echo 'selected'; ?> value="1">Baladins</option>
                                        <option <?php if ($user['id_section'] == 2) echo 'selected'; ?> value="2">Louveteaux</option>
                                        <option <?php if ($user['id_section'] == 3) echo 'selected'; ?> value="3">Eclaireurs</option>
                                        <option <?php if ($user['id_section'] == 4) echo 'selected'; ?> value="4">Pionniers</option>
                                        <option <?php if ($user['id_section'] == 5) echo 'selected'; ?> value="5">La Tribu</option>
                                        <option <?php if ($user['id_section'] == 6) echo 'selected'; ?> value="6">Staff d'unité</option>
                                        <option <?php if ($user['id_section'] == 7) echo 'selected'; ?> value="7">Parent</option>
                                        <option <?php if ($user['id_section'] == 8) echo 'selected'; ?> value="8">Ancien</option>
                                    </select>
                                </div>
                                <hr>
                                <div class="row">
                                    <!--<div class="col-lg-4">
                                        <button class="btn btn-action2" type="submit" name="retourprofil">Profil</button>
                                    </div>-->
                                    <div class="col-lg-5 text-left">
                                        <button class="btn btn-action" type="submit" name="modifierprofil">Modifier</button>
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

    <?php include("footer.php"); ?>

    <?php include("jvs.php"); ?>
