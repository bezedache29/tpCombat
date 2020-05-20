<?php
    include('config/init.php');
    include('config/auto_load.php');
    include('config/db.php');
    //include('config/secure/secure.php');

    include('header.php');

    print_r($_SESSION);

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
<?php
    if(isset($_SESSION['message'])) {
        foreach($_SESSION['message'] as $message) {
?>
<p class="session message_aventure"><?= $message ?></p>
<?php
        }
    unset($_SESSION['message']);
    }
?>
<div class="containeur_aventure">
    <div class="perso_aventure">
        <h2>Mon Personnage</h2>
        <div class="monPerso">
            <div class="img_classe">
<?php
    if($monPerso->getClassePerso() == 'guerrier') {
?>
                <img src="images/classes/war.jpg" alt="Image guerrier">
<?php
    }else {
?>
                <img src="images/classes/mage.jpg" alt="Image mage">
<?php
    }
?>
            </div>
            <div class="stats_perso">
                <p><?= $monPerso->getNomPerso(); ?></p>
                <p>Classe : <?= $monPerso->getClassePerso(); ?></p>
                <p>Niveau : <?= $monPerso->getNiveauPerso(); ?></p>
                <p>Expériences : <?= $monPerso->getExpPerso(); ?></p>
                <p>Dégats : <?= $monPerso->getDegatsPerso(); ?> / 100</p>
                <p>Rage : <?= $monPerso->getRagePerso(); ?> / 40</p>
                <p>Energie : <?= $monPerso->getEnergiePerso(); ?> / 100</p>
            </div>
            <div class="items_sac">
                <img src="images/icones/sac.png" alt="Sac" id="sac" class="sac" />
                <div id="items" class="items">
<?php
    //boucle permettant de voir les items
    $donnees = $manager->listItems($monPerso->getIdPerso());
    foreach($donnees as $item) {
?>
                    <img src="<?= $item['lien_item']; ?>" alt="<?= $item['nom_item']; ?>" /> X <?= $item['nb_items']; ?><br />
<?php
    }
?>
                </div>
            </div>
        </div>
    </div>
    <div class="bloc_aventure">
        <h2 class="titre_histoire">Mon Histoire</h2>
        <p>Votre personnage se trouve dans un village nommé "Village", et est en quête d'aventures ! A la sortie du village il y a 3 chemins qui mène a 3 endroits différents...</p>
        <p>Tirez les dés pour savoir quel chemin prendre (Vous perdrez 10 points d'énergie)</p>
<?php
    if(!(isset($_SESSION['action1']))) {
?>
        <a href="traitements/traitement_aventure.php?action=1" class="de"><img src="images/icones/de.png" alt="dé de 6" /><span class="span_de">Lancez le dé</span></a>
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
            if(!(isset($_SESSION['action1_1']))) {
?>
        <a href="traitements/traitement_aventure.php?action=1.1" class="de"><img src="images/icones/de.png" alt="dé de 6" /><span class="span_de">Lancez le dé</span></a>
<?php
            }elseif(isset($_SESSION['action1_1'])) {
                $numeroApproche = $_SESSION['action1_1'];
                if($numeroApproche == 1) {
?>
        <p>Vous avez perdu 10 pts d'énergie et gagné 5 pts d'experiences</p>
        <p>Vous vous approchez furtivement de l'endroit ou vous avez aperçu une ombre. Quel surprise lorsque vous arrivez sur place !<br />
        Un mystérieux coffre se dresse devant vous, ne demandant qu'a être ouvert.</p>
        <p>Tirez les dés pour savoir si vous êtes capable de l'ouvrir. (Vous perdrez 20 points d'énergie) Ou passez votre chemin(Vous perdrez 10 points d'énergie)</p>
<?php
                }elseif($numeroApproche == 2) {
?>
        <!-- APPROCHE AGRESSIVE -->
        <p>A venir ...</p>
<?php
                }else {
                    // Demande de l'aide + perte XP
?>
        <p>Bientôt ...</p>
<?php
                }
            }
        }elseif($numeroChemin == 2) {
?>
        <p>Vous avez perdu 10 pts d'énergie et gagné 5 pts d'experiences</p>
        <p>Vous marcher pendant un moment lorsque vous tomber nez à nez face un être surprenant.</p>
        <p>Tirez les dés pour connaître votre approche.(Vous perdrez 10 points d'énergie)</p>
<?php
            if(!(isset($_SESSION['action2']))) {
?>
        <a href="traitements/traitement_aventure.php?action=2" class="de"><img src="images/icones/de.png" alt="dé de 6" /><span class="span_de">Lancez le dé</span></a>
<?php
            }elseif(isset($_SESSION['action2'])) {
                $numeroApproche = $_SESSION['action2'];
                if($numeroApproche == 1) {
?>
        <p>Vous avez perdu 10 pts d'énergie et gagné 5 pts d'experiences</p>
        <p>Vous êtes immobilisé de terreur face au squelette qui vous fonce dessus !</p>
        <img src="images/ennemis/war_squelette.jpg" alt="squelette ennemi" class="squelette" />
        <p>Vous avez le choix de combattre ou de vous enfuir</p>
        <p>Vous perderez 20 points d'énergie pour le combat et 30 points d'énergie si vous fuyer</p>
<?php
                    if(!(isset($_SESSION['cacherBouton']))) {
?>
        <div class="boutons_aventure">
            <a href="traitements/traitement_aventure.php?action=2.2"><img src="images/icones/combat.png" alt="combat" class="icones" /><span class="span_combat">Force de l'ennemi : 5<br />Vie de l'ennemi : 5</span></a>
            <a href="traitements/traitement_aventure.php?action=2.3"><img src="images/icones/flag.png" alt="fuir" class="icones" /><span class="span_fuite">le bouton du lâche</span></a>
        </div>
<?php
                    }elseif(isset($_SESSION['cacherBouton'])) {
                        if(isset($_SESSION['combat'])) {
                            if($_SESSION['combat'] == 1) {
                                // Combat perfect
    ?>
                                <p>Vous Avez remporté le combat facilement, sans prendre de dégats !</p>
                                <p>Vous perdez 20 points d'énergie, gagnez 15 points d'expériences et gagnez 4 points de rage !</p>
                                <p>Vous retournez au village fêter cette victoire :-)</p>
                                <p>FIN de l'Histoire (la suite prochainement)</p>
                                <a href="traitements/traitement_aventure.php?action=2.4">Retourner au village</a>
    <?php
                            }else {
                                // Blessures
    ?>
                                <p>Vous avez remporté le combat mais avez subis des blessures</p>
                                <p>Vous perdez 20 points d'énergie, gagnez 15 points d'expériences, gagnez 4 points de rage, et gagnez 5 pts de dégats !</p>
                                <p>Vous retournez au village fêter cette victoire :-)</p>
                                <p>FIN de l'Histoire (la suite prochainement)</p>
                                <a href="traitements/traitement_aventure.php?action=2.4">Retourner au village</a>
    <?php
                            }
    
                        }elseif(isset($_SESSION['fuite'])) {
                            if($_SESSION['fuite'] == 1) {
    ?>
                                <p>Vous avez tentez du fuir et vous avez réussi a vous en tirer sans blessures</p>
                                <p>Vous perdez seulement 30 points d'énergie</p>
                                <p>Vu que vous ête un pétochard, vous pouvez retourner au village. Pas d'aventures pour les amateurs !</p>
                                <a href="traitements/traitement_aventure.php?action=2.4">Retourner au village</a>
    <?php
                            }else {
    ?>
                                <p>Vous avez tentez de fuir et vous avez avez réussi mais non sans mal, car vous avez des blessures</p>
                                <p>Vous perdez 30 points d'énergie et gagnez 5 points de dégats</p>
                                <p>Vu que vous ête un pétochard, vous pouvez retourner au village. Pas d'aventures pour les amateurs !</p>
                                <a href="traitements/traitement_aventure.php?action=2.4">Retourner au village</a>
    <?php
                            }
                        }
                    
                    }


                

                }elseif($numeroApproche == 2) {

                }else {

                }
            }
        }else {
?>
        <p>Vous avez perdu 10 pts d'énergie et gagné 5 pts d'experiences</p>
        <p>Ce chemin vous mène à une petite maison caché a l'entrée d'une forêt</p>
        <p>Tirez les dés pour connaitre l'intérêt de cette batisse. (Vous perdrez 10 points d'énergie)</p>
<?php
        }
    }
?>
    </div>
</div>