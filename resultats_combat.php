<?php
    include('config/init.php');
    include('config/auto_load.php');
    include('config/db.php');

    include('header.php');

    if(isset($_SESSION['resultatsCombat'])) {
        $monPerso = $_SESSION['perso'];
        $monPerso = new Personnage($monPerso);
?>
    <section class="resultats">
        <h1 class="titre_page">Résultats du combat</h1>
        <p class="para">Votre personnage <?= $monPerso->getNomPerso(); ?> à bien attaqué sa cible et l'a frappé pour 5 points de dégats !</p>
<?php
        if(isset($_SESSION['resultatsCombat']['addExp'])) {
            if($_SESSION['resultatsCombat']['addExp'] == 1) {
                $expPerso = $monPerso->getExpPerso();
?>
        <p class="para">Votre personnage a pris 5 points d'expériences supplémentaire et est maintneant à <?= $expPerso; ?> points d'expériences.</p>
<?php
            }elseif(($_SESSION['resultatsCombat']['addExp'] == 0) && isset($_SESSION['resultatsCombat']['addLvl'])) {
                $expPerso = $monPerso->getExpPerso();
                $niveauPerso = $monPerso->getNiveauPerso();
?>
        <p class="para">Bravo ! Votre personnage a pris un niveau supplémentaire et est maintenant de niveau <?= $niveauPerso; ?> avec <?= $expPerso; ?> points d'expériences.</p>
<?php
            }
        }
?>
        <p class="bouton"><a href="jeu.php">Récolter les fruits de la victoire !</a></p>
     </section>
<?php
    }