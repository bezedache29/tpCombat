<?php
    include('../config/init.php');

    function chargerClass($class) {
        include('../' . $class . '.php');
    }
    spl_autoload_register('chargerClass');

    include('../config/db.php');

    if(isset($_POST['email']) && isset($_POST['pwd'])) {
        $mail = htmlspecialchars($_POST['email']);
        $pwd = htmlspecialchars($_POST['pwd']);

        $verifMail = $manager->verifMail($mail);
        if($verifMail == 2) {
            $_SESSION['message'][] = "Cette adresse mail n'existe pas !";
            echo "Cette adresse mail n'existe pas !";
            //header('Location: .../connexion.php');
        }elseif($verifMail == 1) {
            $verifPwdJoueur = $manager->verifPwdJoueur($mail, $pwd);
            if($verifPwdJoueur == 0) {
                $_SESSION['message'][] = "Identifiant ou mot de passe invalide !";
                echo "Identifiant ou mot de passe invalide !";
                //header('Location: .../connexion.php');
            }else {
                // On recupère l'id du perso grace au mail du joueur
                $idPerso = $manager->recupIdPerso($mail);
                // On lui dit que c'est un chiffre
                $idPerso = intval($idPerso);
                // On recupere les infos du perso dans la bdd grace a son id
                $perso = $manager->selectionPerso($idPerso);
                // On place les infos dans la SESSION
                $_SESSION['perso'] = $perso;
                //print_r($_SESSION['perso']);
                header('Location: ../jeu2.php');
            }
        }
    }else {
        echo 'nope';
    }