<?php
    include('config/init.php');
    include('config/auto_load.php');
    include('config/db.php');
    //include('config/secure/secure.php');

    include('header.php');

    $perso = $_SESSION['perso'];
    $classePerso = ucfirst($perso['classePerso']);
    $monPerso = new $classePerso($perso); 
?>
<section class="conteneur">
<div class="titre">
    <p class="infos">Nombre de personnages sur le serveur : <?= $manager->compterPersos(); ?></p>
    <p class="deco"><a href="traitements/traitement_deconnexion.php" class="link_deco">Déconnexion</a></p>
</div>
<h1 class="titre_page"><a href="jeu.php">Page Aventure</a></h1>
<div class="containeur_aventure">
    <div class="bloc_aventure perso_aventure">
        <h2>Mon Personnage</h2>
        <div class="monPerso">
            <p><?= $monPerso->getNomPerso(); ?></p>
            <p>Classe : <?= $monPerso->getClassePerso(); ?></p>
            <p>Niveau : <?= $monPerso->getNiveauPerso(); ?></p>
            <p>Expériences : <?= $monPerso->getExpPerso(); ?></p>
            <p>Dégats : <?= $monPerso->getDegatsPerso(); ?> / 100</p>
            <p>Rage : <?= $monPerso->getRagePerso(); ?> / 40</p>
            <p>Energie : <?= $monPerso->getEnergiePerso(); ?> / 100</p>
        </div>
    </div>
    <div class="bloc_aventure">
        <h2 class="titre_histoire">Mon Histoire</h2>
        <p>Votre personnage se trouve dans un village nommé "Village", et est en quête d'aventures ! A la sortie du village il y a 3 chemins qui mène a 3 endroits différents...</p>
        <p>Tirez les dés pour savoir quel chemin prendre (Vous perdrez 10 points d'énergie)</p>
<?php
    if(!(isset($_SESSION['action1']))) {
?>
        <form method="post" action="traitements/traitement_aventure?action=1">
            <button>Lancer le dé</button>
        </form>
<?php
    }elseif(isset($_SESSION['action1'])) {
        $numeroChemin = $_SESSION['action1'];
?>
        <p>Vous prenez le chemin n° <?= $numeroChemin; ?></p>
<?php
        if($numeroChemin == 1) {
?>
        <p>Vous avez perdu 10 pts d'énergie et gagné 5 pts d'experiences</p>
        <p>Vous voyez au loin une ombre, mais vous ne savez pas à quoi ressemble cette forme.</p>
        <p>Tirez les dés pour connaitre votre approche (Vous perdrez 10 points d'énergie)</p>
<?php
            echo 'test1';
            //$monPerso->setDegatsPerso(100);
            /* $verifEtat = $monPerso->verifEtat();
            if($verifEtat == 1) {
                // Perso mort
                // Delete
            }elseif($verifEtat == 2) {
                //perso blessé
                $manager->modifPerso($monPerso);
            } */
?>
        <p>Vous mourrez !</p>
<?php
        }elseif($numeroChemin == 2) {
            echo 'test2';
        }else {
            echo 'test3';
        }
?>
    </div>
</div>
<?php
    }
?>

