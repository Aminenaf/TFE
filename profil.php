<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("dbConnect.php");

clearstatcache();


if (isset($_GET['id']) AND $_GET['id'] > 0)
{
    if (isset($_SESSION['id']) == null)
    {
        header("Location: connexion.php");
        die;
    }
$getid = intval($_GET['id']);
$requser = $bdd->prepare("SELECT * FROM membre WHERE id = ?");
$requser->execute(array($getid));
$userprofil = $requser->fetch();

    $reqsection = $bdd->prepare("SELECT nom_section FROM brownseartscout.section JOIN brownseartscout.membre on brownseartscout.section.id_section = brownseartscout.membre.id_section WHERE id = ?");
    $reqsection->execute(array($getid));
    $sectioninfo = $reqsection->fetch();

    if (isset($_SESSION['id']) AND isset($_GET['id']) AND $_GET['id'] == $_SESSION['id']) {

        if (isset($_POST['modifierpp'])) {

            if (isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name'])) {
                $tailleMax = 2097152;
                $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');
                if ($_FILES['avatar']['size'] <= $tailleMax) {
                    $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
                    if (in_array($extensionUpload, $extensionsValides)) {
                        $chemin = "membres/avatars/" . $_SESSION['id'] . "." . $extensionUpload;
                        $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
                        if ($resultat) {
                            $updateavatar = $bdd->prepare('UPDATE membre SET avatar = :avatar WHERE id = :id');
                            $updateavatar->execute(array(
                                'avatar' => $_SESSION['id'] . "." . $extensionUpload,
                                'id' => $_SESSION['id']
                            ));
                            header('Location: profil.php?id=' . $_SESSION['id']);
                        } else {
                            $err_avatar = "Erreur durant l'importation de votre photo de profil";
                            $valid = false;
                        }
                    } else {
                        $err_avatar = "Votre photo de profil doit être au format jpg, jpeg, gif ou png";
                        $valid = false;
                    }
                } else {
                    $err_avatar = "Votre photo de profil ne doit pas dépasser 2Mo";
                    $valid = false;
                }
            }

            clearstatcache();
            header("Cache-Control: no-cache, must-revalidate");
            header('Location: profil.php?id=' . $_SESSION['id']);
        }

        ?>
        <?php include("head.php"); ?>

<?php include("header.php"); ?>

<div class="container">

		<ol class="breadcrumb">
			<li><a href="index.php">Acceuil</a></li>
			<li class="active">Profil</li>
            <li class="active"><?php echo $sectioninfo['nom_section']?></li>
            <li class="active"><?php echo $userprofil['prenom']?></li>
		</ol>

		<div class="row">

			<!-- Sidebar -->
			<aside class="col-md-4 sidebar sidebar-left">
				<div class="row widget">
					<div class="col-xs-12">
						<h4>Photo de profil</h4>
                        <?php
                        if (!empty($userprofil['avatar'])) {
                            ?>
                            <p><img src="membres/avatars/<?php echo $userprofil['avatar'];?>" width="inherit" height="inherit"></p>
                            <?php
                        } else {
                        ?>
                            <p><img src="assets/images/pp.png"></p>
                        <?php } ?>
                        <form method="post" action="" enctype="multipart/form-data">
                            <input type="file" class="form-control" name="avatar"><br>
                            <button class="btn" type="submit" name="modifierpp">Modifier</button>
                        </form>
					</div>
				</div>

			</aside>
			<!-- /Sidebar -->

			<!-- Article main content -->
			<article class="col-md-8 maincontent">
				<header class="page-header">
					<h1 class="page-title">Profil de <?php echo $userprofil['prenom']?> </h1>
				</header>
                <h3>Section : <span class="text-muted"><?php if ($userprofil['isChef'] == 1 ) { echo "Chef ";}  ?><?php echo $sectioninfo['nom_section'] ?></span></h3><hr>
                <h4>Nom : <span class="text-muted"><?php echo $userprofil['nom']?></span></h4><hr>
                <h4>Prenom : <span class="text-muted"><?php echo $userprofil['prenom']?></span></h4><hr>
                <h4>Date de naissance : <span class="text-muted"><?php echo $userprofil['date_naissance']?></span></h4><hr>
                <h4>Numéro de téléphone : <span class="text-muted"><?php echo $userprofil['telephone']?></span></h4><hr>
                <h4>Totem : <span class="text-muted"><?php if (isset($userprofil['totem'])) {echo $userprofil['totem'];}?></span></h4><hr>
                <h4>Quali : <span class="text-muted"><?php if (isset($userprofil['quali'])) {echo $userprofil['quali'];}?></span></h4><hr>
                <h4>Adresse-mail : <span class="text-muted"><?php echo $userprofil['email']?></span></h4><hr>

                    <?php if ($userprofil['isChef'] == 1) { ?><p><a href="editionprofil.php" role="button" class="btn">Edition profil</a>&emsp;<?php } ?>
                    <a href="modifimdp.php" role="button" class="btn">Modifier mon mot de passe</a>&emsp;
                        <a href="mesdocuments.php" role="button" class="btn">Mes documents</a></p><hr>
                    <p><a href="deconnexion.php" role="button" class="btn btn-primary">Déconnexion</a></p>

			</article>
			<!-- /Article -->

		</div>
	</div>	<!-- /container -->

<?php include("footer.php"); ?>

        <?php include("jvs.php"); ?>

        <?php
    } else {
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
                                <h3 class="thin text-center">No Access</h3>
                                <p class="text-center text-muted">Vous ne pouvez pas accéder à cette page<br></p>
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

<?php } ?>
<?php
    }
?>