<?php
    include('../config/init.php');

    function chargerClass($class) {
        include('../' . $class . '.php');
    }
    spl_autoload_register('chargerClass');

    include('../config/db.php');

    if(isset($_GET['id_adversaire'])) {
        $id_adversaire = htmlspecialchars($_GET['id_adversaire']);
        $id_adversaire = intval($id_adversaire);
        $id_perso = $_SESSION['id_perso'];

        $perso1 = $_SESSION['perso'];
        $monPerso = new Personnage($perso1);
        
        $perso2 = $manager->selectionPerso($id_adversaire);
        $adversaire = new Personnage($perso2);

        $attaque = $monPerso->att($adversaire);

        if($attaque == 3) {
            $_SESSION['perso_frappe'] = true;
            $monPerso->addExp();
            $_SESSION['resultatsCombat']['addExp'] = 1;
            if($monPerso->getExpPerso() >= 100) {
                $monPerso->addLvl();
                $monPerso->setExpPerso(0);
                $_SESSION['resultatsCombat']['addLvl'] = 1;
                $_SESSION['resultatsCombat']['addExp'] = 0;
            }
            $manager->modifPerso($monPerso);
            $manager->modifPerso($adversaire);
            $monPerso = $manager->selectionPerso($id_perso);
            $_SESSION['perso'] = $monPerso;
            header('Location: ../attente_combat.php');
        }elseif($attaque = 2) {
            $_SESSION['perso_tue'] = true;
            $monPerso->addExp();
            if($monPerso->getExp() >= 100) {
                $monPerso->addLvl();
                $monPerso->setExpPerso(0);
            }
            $manager->modifPerso($monPerso);
            $manager->supprPerso($adversaire);
            header('Location: ../attente_combat.php');
        }else {
            $_SESSION['error_perso'] = true;
            header('Location: ../jeu.php');
        }
    }elseif(isset($_POST['searchPerso'])) {
        $nomAdversaire = htmlspecialchars($_POST['searchPerso']);
        $verif = $manager->verifAdversaire($nomAdversaire);

        if($verif == 2) {
            // Si champ nomPerso vide
            $_SESSION['nom_vide'] = true;
            header('Location: ../jeu.php');
        }elseif($verif == 1) {
            $_SESSION['perso_inexistant'] = true;
            // redirige vers jeu.php
            header('Location: ../jeu.php');
        }else {
            $perso1 = $_SESSION['perso'];
            $monPerso = new Personnage($perso1);

            $adversaire = new Personnage($verif);

            $attaque = $monPerso->att($adversaire);

            if($attaque == 3) {
                $_SESSION['perso_frappe'] = true;
                $monPerso->addExp();
                if($monPerso->getExp() >= 100) {
                    $monPerso->addLvl();
                    $monPerso->setExpPerso(0);
                }
                $manager->modifPerso($monPerso);
                $manager->modifPerso($adversaire);
                header('Location: ../attente_combat.php');
            }elseif($attaque = 2) {
                $_SESSION['perso_tue'] = true;
                $monPerso->addExp();
                if($monPerso->getExp() >= 100) {
                    $monPerso->addLvl();
                    $monPerso->setExpPerso(0);
                }
                $manager->modifPerso($monPerso);
                $manager->supprPerso($adversaire);
                header('Location: ../attente_combat.php');
            }else {
                $_SESSION['error_perso'] = true;
                header('Location: ../jeu.php');
            }
        }
    }