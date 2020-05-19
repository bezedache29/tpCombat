<?php
    include('config/init.php');
    include('config/auto_load.php');
    include('config/db.php');
    //include('config/secure/secure.php');

    include('header.php');
?>
<section class="conteneur">
<div class="titre">
    <p class="infos">Nombre de personnages sur le serveur : <?= $manager->compterPersos(); ?></p>
    <p class="deco"><a href="traitements/traitement_deconnexion.php" class="link_deco">Déconnexion</a></p>
</div>
<h1 class="titre_page"><a href="jeu.php">Page Personnage</a></h1>
<?php
    // Si le personnage existe dans la BDD, on récupère les infos et on hydrate les attributs de la class
    if(isset($_SESSION['perso'])) {
        $perso = $_SESSION['perso'];
        // On met la premier lettre en Majuscule
        $classePerso = ucfirst($perso['classePerso']);
        // Nouvelle objet de la classe du personnage
        $monPerso = new $classePerso($perso);
?>
        <h2>Mon Personnage</h2>
        <div class="monPerso">
            <p><?= $monPerso->getNomPerso(); ?></p>
            <p>Classe : <?= $monPerso->getClassePerso(); ?></p>
            <p>Niveau : <?= $monPerso->getNiveauPerso(); ?></p>
            <p>Expériences : <?= $monPerso->getExpPerso(); ?></p>
            <p>Dégats : <?= $monPerso->getDegatsPerso(); ?> / 100</p>
            <p>Rage : <?= $monPerso->getRagePerso(); ?> / 40</p>
        </div>
        <h2>Commencer l'aventure ?</h2>
        <a href="aventure.php" class="game">J'entre dans le GAME !</a>
<?php
    }