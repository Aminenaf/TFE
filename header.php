<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("dbConnect.php");

$userinfo =  array();
$userinfo['id'] = -1;
if (isset($_SESSION['id'])) {
        $userinfo['id'] = $_SESSION['id'];

        $requser = $bdd->prepare("SELECT * FROM membre WHERE id = ?");
        $requser->execute(array($_SESSION['id']));
        $useradmin = $requser->fetch();
        $_SESSION['id_role'] = $useradmin['id_role'];
}

//
//var_dump($_SESSION);die;

?>
<div class="navbar navbar-inverse navbar-fixed-top headroom" >
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
            <!--<a class="navbar-brand" href="index.html"><img src="assets/images/logo.png" alt="Progressus HTML5 template"></a>-->
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav pull-right">
                <li><a href="index.php">Accueil</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sections <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="baladin.php">Baladins</a></li>
                        <li><a href="louveteau.php">Louveteaux</a></li>
                        <li><a href="eclaireur.php">Eclaireurs</a></li>
                        <li><a href="pionnier.php">Pionniers</a></li>
                        <li><a href="latribu.php">La Tribu</a></li>
                        <li><a href="staffdu.php">Staff d'unité</a></li>
                        <?php
                        if (isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id'] AND $useradmin['isChef'] == 1) {
                            ?>
                            <li><a href="masection.php">Ma section</a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Informations <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="document.php">Documents</a></li>
                        <li><a href="galerie.php">Galerie</a></li>
                        <li><a href="calendrier.php">Calendrier</a></li>
                        <!--<li><a href="#">Info Pratiques</a></li>-->
                        <li><a href="demandeinscription.php">Demande d'inscription</a></li>
                    </ul>
                </li>
                <li><a href="contact.php">Contact</a></li>
                <?php
                if (isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id'] AND $useradmin['id_role'] <= 2)
                {
                ?>
                <li><a href="admin.php">Administrateur</a></li>
                <?php
                }
                ?>
                <?php
                if (isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id'])
                {
                    ?>
                    <li><a class="btn" href="profil.php?id=<?= $userinfo['id'] ?>">Mon profil</a></li>
                    <?php
                }
                else { ?>
                    <li><a class="btn" href="connexion.php">Connexion / Inscription</a></li>
                <?php
                }
                ?>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>
<header id="head" class="secondary"></header>