<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("dbConnect.php");

$userinfo =  array();
$userinfo['id'] = -1;
if (isset($_SESSION['id'])) {


    $userinfo['id'] = $_SESSION['id'];

    $membreStaff = $bdd->query('SELECT * FROM brownseartscout.membre WHERE id_section = 1 AND isChef = 1');

    function age($date) {
        $age = date('Y') - (int)$date;
        if (date('md') < date('md', strtotime($date))) {
            return $age - 1;
        }
        return $age;
    }

}
?>

<?php include("head.php"); ?>

<?php include("header.php"); ?>

<div class="container">

    <ol class="breadcrumb">
        <li><a href="index.php">Acceuil</a></li>
        <li class="active">Sections</li>
        <li class="active">Baladins</li>
    </ol>

    <div class="row">

        <!-- Article main content -->
        <article class="col-sm-8 maincontent">
            <header class="page-header">
                <h1 class="page-title">Baladins</h1>
            </header>
            <h3>Lorem ipsum</h3>
            <p><img src="assets/images/baladins.jpg" alt="" class="img-rounded pull-right" height="252" width="260"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eveniet, consequuntur eius repellendus eos aliquid molestiae ea laborum ex quibusdam laudantium voluptates placeat consectetur quam aliquam beatae soluta accusantium iusto nihil nesciunt unde veniam magnam repudiandae sapiente.</p>
            <p>Quos, aliquam nam velit impedit minus tenetur beatae voluptas facere sint pariatur! Voluptatibus, quisquam, error, est assumenda corporis inventore illo nesciunt iure aut dolor possimus repellat minima veniam alias eius!</p>
            <h3>Necessitatibus</h3>
            <p>Velit, odit, eius, libero unde impedit quaerat dolorem assumenda alias consequuntur optio quae maiores ratione tempore sit aliquid architecto eligendi pariatur ab soluta doloremque dicta aspernatur labore quibusdam dolore corrupti quod inventore. Maiores, repellat, consequuntur eius repellendus eos aliquid molestiae ea laborum ex quibusdam laudantium voluptates placeat consectetur quam aliquam!</p>
            <h3>Fugit, laboriosam</h3>
            <p>Eum, quasi, est, vitae, ipsam nobis consectetur ea aspernatur ad eos voluptatibus fugiat nisi perferendis impedit. Quam, nulla, excepturi, voluptate minus illo tenetur sint ab in culpa cumque impedit quibusdam. Saepe, molestias quia voluptatem natus velit fugiat omnis rem eos sapiente quasi quaerat aspernatur quisquam deleniti accusantium laboriosam odio id?</p>
            <h3>Doloribus, illo ipsum</h3>
            <p>Velit, odit, eius, libero unde impedit quaerat dolorem assumenda alias consequuntur optio quae maiores ratione tempore sit aliquid architecto eligendi pariatur ab soluta doloremque dicta aspernatur labore quibusdam dolore corrupti quod inventore. Maiores, repellat, consequuntur eius repellendus eos aliquid molestiae ea laborum ex quibusdam laudantium voluptates placeat consectetur quam aliquam!</p>
            <p>Eum, quasi, est, vitae, ipsam nobis consectetur ea aspernatur ad eos voluptatibus fugiat nisi perferendis impedit. Quam, nulla, excepturi, voluptate minus illo tenetur sint ab in culpa cumque impedit quibusdam. Saepe, molestias quia voluptatem natus velit fugiat omnis rem eos sapiente quasi quaerat aspernatur quisquam deleniti accusantium laboriosam odio id?</p>

        </article>
        <!-- /Article -->

        <!-- Sidebar -->
        <aside class="col-sm-4 sidebar sidebar-right">
            <?php
            if (isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id'])
            {
                ?>
                <div class="widget">
                    <h2>Le Staff Baladin</h2>
                    <?php while ($c = $membreStaff->fetch()) { ?>
                        <div>
                            <div class="col-md-12 col-sm-6 highlight oki">
                                <br>
                                <?php
                                if (!empty($c['avatar'])) {
                                    ?>
                                    <div class="h-caption"><img src="membres/avatars/<?php echo $c['avatar']; ?>" alt="img" style="height: 300px;" height="max-height" width="max-width"></div>
                                    <?php
                                } else {
                                    ?>
                                    <p><img src="assets/images/pp.png"></p>
                                <?php } ?>
                                <div class="h-body text-center">
                                    <br>
                                    <h4>Nom : <?php echo $c['nom']; ?></h4>
                                    <h4>Prenom : <?php echo $c['prenom']; ?> </h4>
                                    <h4>Age : <?php echo age($c['date_naissance']); ?> </h4>
                                    <h4>Telephone : <?php echo $c['telephone'] ?> </h4>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <?php
            }
            else { ?>
                <div class="widget">
                    <h2>Le Staff Baladin</h2>
                    <div class="col-md-10 col-sm-6 highlight">
                        <div class="h-caption"><h3><i class="fa fa-ban"></i><span class="text-danger">Accès limité</span></h3></div>
                        <div class="h-body text-center">
                            <p>Vous devez être connecté pour pouvoir voir les membres du staff<br><a href="connexion.php">Se connecter</a></p>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>

        </aside>
        <!-- /Sidebar -->

    </div>
</div>	<!-- /container -->

<?php include("footer.php") ?>

<?php include("jvs.php"); ?>