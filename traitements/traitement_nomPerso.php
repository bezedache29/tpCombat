<?php

    include('../config/init.php');

    function chargerClass($class) {
        include('../' . $class . '.php');
    }
    spl_autoload_register('chargerClass');

    include('../config/db.php');

    if(isset($_POST['use']) && isset($_POST['nomPerso'])) {
        $nomPerso = htmlspecialchars($_POST['nomPerso']);
        $nomPerso = strtoupper($nomPerso);
        // On verifie le pseudo
        $verif = $manager->verifNom($nomPerso);

        if($verif == 0) {
            // On récupère les infos du perso
            $perso = $manager->selectionPerso($nomPerso);
            $_SESSION['perso'] = $perso;

            // On redirige vers la page jeu
            header('Location: ../jeu.php');
        }elseif($verif == 2) {
            $_SESSION['nom_vide'] = true;
            header('Location: ../index.php');
        }elseif($verif == 1) {
            $_SESSION['perso_inexistant'] = true;
            // redirige vers l'index.php
            header('Location: ../index.php');
        }
    }elseif(isset($_POST['create']) && isset($_POST['nomPerso'])) {
        $nomPerso = htmlspecialchars($_POST['nomPerso']);
        $nomPerso = strtoupper($nomPerso);
        // On verifie le pseudo
        $verif = $manager->verifNom($nomPerso);
        //echo $verif;

        // Si la verif renvoie false (Personnage non existant)
        if($verif == 1) {
            // Création fiche personnage
            $perso = new Personnage([
                'nomPerso' => $nomPerso,
            ]);

            // Insertion dans la BDD
            $manager->addPerso($perso);
            // On recupère les infos du perso
            $perso = $manager->selectionPerso($nomPerso);
            // On les inserent dans une session
            $_SESSION['perso'] = $perso;

            //print_r($_SESSION['perso']);
            
            // Redirection sur la page du jeu
            header('Location: ../jeu.php');
        }elseif($verif == 2) {
            // Si champ nomPerso vide
            $_SESSION['nom_vide'] = true;
            header('Location: ../index.php');
        }elseif($verif == 0){
            // Si le perso existe deja dans la BDD
            $_SESSION['perso_existant'] = true;
            header('Location: ../index.php');
        }
    }