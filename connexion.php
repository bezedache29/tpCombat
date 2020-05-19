<?php
    include('config/init.php');
    include('header.php');

    //print_r($_SESSION);
?>
<section class="section_container">
    <h1>Connexion d'un personnage</h1>
    <form method="post" action="traitements/traitement_connexion.php" class="form_connexion">
        <div class="bloc">
            <div class="labels">
                <label for="email">Votre E-mail</label>
                <input type="email" id="email" name="email" class="input_inscription" />
            </div>
            <div class="labels">
                <label for="pwd">Votre mot de passe</label>
                <input type="password" name="pwd" class="input_inscription caps" id="pwd" />
            </div>
        </div>
        <div class="boutons_inscription">
            <button>Connexion</button>
            <a href="index.php">Annuler</a>
        </div>
    </form>
    <a href="traitements/traitement_deconnexion.php">DECO</a>
</section>