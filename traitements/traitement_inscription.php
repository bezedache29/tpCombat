<?php
    include('../config/init.php');

    function chargerClass($class) {
        include('../' . $class . '.php');
    }
    spl_autoload_register('chargerClass');

    include('../config/db.php');

    if(isset($_POST['mail']) && isset($_POST['pseudo']) && isset($_POST['pwd1']) && isset($_POST['pwd2']) && isset($_POST['classe'])) {
        $mail = htmlspecialchars($_POST['mail']);
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $pseudo = strtoupper($pseudo);
        $classe = $_POST['classe'];
        $pwd1 = $_POST['pwd1'];
        $pwd2 = $_POST['pwd2'];
        
        $verifMail = $manager->verifMail($mail);
        
        if($verifMail == 2) {
            $verifPwd = $manager->verifPwd($pwd1, $pwd2);
            if($verifPwd == 0) {
                $_SESSION['message'][] = "Les mots de passe ne sont pas identique";
                echo 'Les mots de passe ne sont pas identique';
                //header('Location: ../index.php');
            }else {
                // Création du joueur dans la BDD
                $manager->addJoueur($mail, $pwd1);
                $id = $manager->dernierId();
                // Création du personnage avec la bonne classe
                $perso = new $classe([
                    'nomPerso' => $pseudo
                ]);
                // Insertion dans la BDD
                $manager->addPerso($perso, $id);
                // On recupère les infos du perso
                $perso = $manager->selectionPerso($pseudo);
                // On les inserent dans une session
                $_SESSION['perso'] = $perso;

                echo 'Salut';

                print_r($_SESSION);

                print_r($_SESSION['perso']);

                //header('Location: ../jeu.php');
            }

        }elseif($verifMail == 1) {
            $_SESSION['message'][] = "Cette adrresse Mail existe déjà !";
            echo 'Cette adrresse Mail existe déjà !';
            //header('Location: ../index.php');
        }else {
            //header('Location: ../index.php');
        }
    }else {
        echo 'nope !';
    }