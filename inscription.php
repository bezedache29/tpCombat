<?php
    include('config/init.php');
    include('header.php');
?>
<section class="section_container">
    <h1>Création d'un personnage</h1>
    <form method="post" action="traitements/traitement_inscription" class="from_inscription">
        <div class="blocs">
            <div class="bloc">
                <div class="labels">
                    <label for="email">Votre E-mail</label>
                    <input type="email" id="email" name="mail" class="input_inscription" />
                </div>
                <div class="labels">
                    <label for="pwd1">Votre mot de passe</label>
                    <input type="password" name="pwd1" class="input_inscription" id="pwd1" />
                    
                </div>
            </div>
            <div class="bloc">
                <div class="labels">
                    <label for="pseudo">Votre pseudo</label>
                    <input type="text" name="pseudo" class="input_inscription caps" id="pseudo" />
                </div>
                <div class="labels">
                    <label for="pwd2">Confirmer mot de passe</label>
                    <input type="password" name="pwd2" class="input_inscription" id="pwd2" />
                </div>
            </div>
        </div>
        <div class="classes">
            <label class="container">Guerrier
                <input type="radio" name="classe" checked="checked" value="Guerrier" />
                <span class="checkmark"></span>
            </label>
            <label class="container">Magicien
                <input type="radio" name="classe" value="Magicien" />
                <span class="checkmark"></span>
            </label>
        </div>
        <div class="boutons_inscription">
            <button>S'enregistrer</button>
            <a href="index.php">Annuler</a>
        </div>
        
    </form>

</section>
<?php
    include('footer.php');
?>