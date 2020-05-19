<?php
    include('config/init.php');
    include('header.php');
?>
    <div class="conteneur">
        <div class="container">
            <h1 class="text">TP Mini Combat</h1>
        </div>
        <div class="paras">
            <p class="p1">Création d'un personnage</p>
            <p class="p2">ou</p>
            <p class="p3">Utilisation d'un personnage existant</p>
        </div>
        <div class="boutons">
            <p class="b1"><a href="connexion.php">Connexion</a></p>
            <p class="b2"><a href="inscription.php">Inscription</a></p>
        </div>
<?php
    if(isset($_SESSION)) {
        if(isset($_SESSION['perso_inexistant'])) {
?>
        <p class="session">Personnage Inexistant ou Mort !</p>
<?php
            unset($_SESSION['perso_inexistant']);
        }elseif(isset($_SESSION['perso_existant'])) {
?>
        <p class="session">Ce nom de personnage existe déjà !</p>
<?php
            unset($_SESSION['perso_existant']);
        }elseif(isset($_SESSION['nom_vide'])) {
?>
        <p class="session">Donnez un nom à votre personnage</p>
<?php
            unset($_SESSION['nom_vide']);
        }
        unset($_SESSION);
    }
?>
    </div>
    <script src="titreAnime.js"></script>
<?php
    include('footer.php');
?>