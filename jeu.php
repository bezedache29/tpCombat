<?php
    include('config/init.php');
    include('config/auto_load.php');
    include('config/db.php');

    include('header.php');
?>
<section class="conteneur">
<div class="titre">
    <p class="infos">Nombre de personnages sur le serveur : <?= $manager->compterPersos(); ?></p>
    <p class="deco"><a href="traitements/traitement_deconnexion.php" class="link_deco">Déconnexion</a></p>
</div>
<h1 class="titre_page"><a href="jeu.php">Page Jeu</a></h1>
<?php
    // Si le personnage existe dans la BDD, on récupère les infos et on hydrate les attributs de la class
    if(isset($_SESSION['perso'])) {
        $perso = $_SESSION['perso'];
        $personnage = new Personnage($perso);
        $_SESSION['id_perso'] = $personnage->getIdPerso();
?>
        <h2>Mon Personnage</h2>
        <div class="monPerso">
            <p><?= $personnage->getNomPerso(); ?></p>
            <p>Niveau : <?= $personnage->getNiveauPerso(); ?></p>
            <p>Expériences : <?= $personnage->getExpPerso(); ?></p>
            <p>Dégats : <?= $personnage->getDegatsPerso(); ?></p>
        </div>
<?php
    if(isset($_SESSION['resultatsCombat'])) {
        unset($_SESSION['resultatsCombat']);
    }
?>
        
        <h2>Mes Ennemis</h2>
        <div class="containeurPersos">
<?php
        $resultats = $manager->listPersos();

        foreach($resultats as $personnages) {
            if($personnages['idPerso'] != $personnage->getIdPerso()) {
?>
            <div class="blocPerso">
                <a href="traitements/traitement_combat.php?id_adversaire=<?= $personnages['idPerso']; ?>">
                    <p><?= $personnages['nomPerso']; ?></p>
                    <p>Niveau : <?= $personnages['niveauPerso']; ?></p>
                    <p>Dégats : <?= $personnages['degatsPerso']; ?></p>
                </a>
            </div>
<?php
            }
        }
?>
        </div>
        <form method="post" action="traitements/traitement_combat.php">
            <label>Rechercher un ennemi par son pseudo :</label>
            <br>
            <input type="text" name="searchPerso">
            <br>
            <button>Rechercher</button>
        </form>
        </section>
<?php
    }else {
        header('Location: index.php');
    }
    
    include('footer.php');
?>