<?php include("head.php"); ?>

<?php include("header.php"); ?>

<div class="container">

    <ol class="breadcrumb">
        <li><a href="index.php">Acceuil</a></li>
        <li class="active">Contact</li>
    </ol>

    <div class="row">

        <!-- Article main content -->
        <article class="col-sm-9 maincontent">
            <header class="page-header">
                <h1 class="page-title">Contactez-nous</h1>
            </header>
            <br>
            <form>
                <div class="row">
                    <div class="col-sm-4">
                        <input class="form-control" type="text" placeholder="Nom">
                    </div>
                    <div class="col-sm-4">
                        <input class="form-control" type="text" placeholder="E-mail">
                    </div>
                    <div class="col-sm-4">
                        <input class="form-control" type="text" placeholder="Numéro de téléphone">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12">
                        <textarea placeholder="Ecrivez votre message ici ..." class="form-control" rows="9"></textarea>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-6 text-right">
                        <input class="btn btn-action" type="submit" value="Envoyer">
                    </div>
                </div>
            </form>

        </article>
        <!-- /Article -->

        <!-- Sidebar -->
        <aside class="col-sm-3 sidebar sidebar-right">

            <div class="widget">
                <h4>Adresse</h4>
                <address>
                    Eglise de Froidmont 1330 Rixensart
                </address>
                <h4>Téléphone</h4>
                <address>
                    +32 478 56 77 43
                </address>
            </div>

        </aside>
        <!-- /Sidebar -->

    </div>
</div>	<!-- /container -->

<section class="container-full top-space">
    <iframe width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0" id="gmap_canvas" src="https://maps.google.com/maps?q=%C3%A9glise%20saint%20etienne%20rixensart&t=k&z=17&ie=UTF8&iwloc=&output=embed"></iframe>
</section>

<?php include("footer.php") ?>


<?php include("jvs.php"); ?>