<?php

include("dbConnect.php");

$userinfo =  array();
$userinfo['id'] = -1;
if (isset($_SESSION['id'])) {


    $userinfo['id'] = $_SESSION['id'];

}
?>

<?php include("head.php"); ?>

<?php include("header.php"); ?>


<?php
if (isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) {
    ?>
        <div class="container">

            <ol class="breadcrumb">
                <li><a href="index.php">Acceuil</a></li>
                <li class="active">Informations</li>
                <li class="active">Galerie</li>
            </ol>

            <h2 class="text-center thin">Album Photo</h2>

            <div class="row">
                <div class="col-md-4 col-sm-4 highlight">
                    <div class="h-caption"><img src="assets/images/bonfire.jpg" alt="Baladins" height="max-height" width="max-width"><h4>Fête d'unité 2019</h4></div>
                </div>
                <div class="col-md-4 col-sm-4 highlight">
                    <div class="h-caption"><img src="assets/images/bg_header.jpg" alt="Louveteaux" height="max-height" width="max-width"><h4>Week-end de passage 2019</h4></div>
                </div>
                <div class="col-md-4 col-sm-4 highlight">
                    <div class="h-caption"><img src="assets/images/gallery.jpg" alt="Eclaireurs" height="max-height" width="max-width"><h4>St Nicolas des baladins</h4></div>
                </div>
                <div class="col-md-4 col-sm-4 highlight">
                    <div class="h-caption"><img src="assets/images/ok.jpg" alt="Pionniers" height="max-height" width="max-width"><h4>24H Vélo 2019</h4></div>
                </div>
                <div class="col-md-4 col-sm-4 highlight">
                    <div class="h-caption"><img src="assets/images/test.jpg" alt="latribu" height="max-height" width="max-width"><h4>Week end passage 2018</h4></div>
                </div>
                <div class="col-md-4 col-sm-4 highlight">
                    <div class="h-caption"><img src="assets/images/heloo.jpg" alt="latribu" height="max-height" width="max-width"><h4>Fête d'unité 2018</h4></div>
                </div>
            </div> <!-- /row  -->

        </div>

    <?php
}
else {
    ?>
    <header id="headoo">
        <div class="container">
            <div class="row">
                <h1 class="leadoo">Galerie photo</h1>
                <!--<p class="tagline">PROGRESSUS: free business bootstrap template by <a href="http://www.gettemplate.com/?utm_source=progressus&amp;utm_medium=template&amp;utm_campaign=progressus">GetTemplate</a></p>
                <p><a class="btn btn-default btn-lg" role="button">MORE INFO</a> <a class="btn btn-action btn-lg" role="button">DOWNLOAD NOW</a></p>-->
            </div>
        </div>
    </header>
    <!-- /Header -->

    <!-- Intro -->
    <div class="container text-center">
        <br> <br>
        <h2 class="thin">Vous devez être connecté pour pouvoir voir les photos</h2>
        <p class="text-muted">
            <a href="connexion.php">Se connecter</a>
        </p>
    </div>
    <?php
}
?>

<?php include("footer.php") ?>

<?php include("jvs.php"); ?>