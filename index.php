<?php
    include('config/init.php');
    include('header.php');

    if(isset($_SESSION)) {
        print_r($_SESSION);
        unset($_SESSION);
    }
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
        <form action="traitements/traitement_nomPerso.php" method="post">
            <label>Nom de votre Personnage :</label>
            <br>
            <input type="text" name="nomPerso" maxlength="30" />
            <br>
            <div class="boutons">
                <button name="create" class="b1">Créer Personnage</button>
                <button name="use" class="b2">Utiliser Personnage</button>
            </div>
        </form>
<?php
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
?>
    </div>
    <script src="titreAnime.js"></script>
<?php
    include('footer.php');
?>