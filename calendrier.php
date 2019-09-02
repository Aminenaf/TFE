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
    <li class="active">Calendrier</li>
</ol>

<section class="container-full top-space">
    <iframe src="https://calendar.google.com/calendar/embed?height=600&amp;wkst=2&amp;bgcolor=%23ff1f1f&amp;ctz=Europe%2FBrussels&amp;src=aW9mNjU5NHQ1cmk1cWw0czV0MmJ2cGQ1bGNAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&amp;src=ZnIuYmUjaG9saWRheUBncm91cC52LmNhbGVuZGFyLmdvb2dsZS5jb20&amp;color=%23B39DDB&amp;color=%237986CB&amp;showPrint=0&amp;showDate=1&amp;showNav=1&amp;showTabs=0" style="border-width:0" width="100%" height="100%" frameborder="0" scrolling="no"></iframe>
</section>
    <div>
    <a target="_blank" href="https://calendar.google.com/event?action=TEMPLATE&amp;tmeid=MTJyOGFpOXZwZTRxczA4cG5uZHY5b2FiaGQgaW9mNjU5NHQ1cmk1cWw0czV0MmJ2cGQ1bGNAZw&amp;tmsrc=iof6594t5ri5ql4s5t2bvpd5lc%40group.calendar.google.com"><img border="0" src="https://www.google.com/calendar/images/ext/gc_button1_fr.gif"></a>
    </div>
    </div>
    <?php
}
else {
    ?>
    <header id="headoooo">
        <div class="container">
            <div class="row">
                <!--<p class="tagline">PROGRESSUS: free business bootstrap template by <a href="http://www.gettemplate.com/?utm_source=progressus&amp;utm_medium=template&amp;utm_campaign=progressus">GetTemplate</a></p>
                <p><a class="btn btn-default btn-lg" role="button">MORE INFO</a> <a class="btn btn-action btn-lg" role="button">DOWNLOAD NOW</a></p>-->
            </div>
        </div>
    </header>
    <!-- /Header -->

    <!-- Intro -->
    <div class="container text-center">
        <br> <br>
        <h2 class="thin">Vous devez être connecté pour pouvoir voir le calendrier</h2>
        <p class="text-muted">
            <a href="connexion.php">Se connecter</a>
        </p>
    </div>
    <?php
}
?>
<?php include("footer.php") ?>

<?php include("jvs.php"); ?>
