<?php
    include('../config/init.php');

    function chargerClass($class) {
        include('../' . $class . '.php');
    }
    spl_autoload_register('chargerClass');

    include('../config/db.php');

    if(isset($_GET['action'])) {
        $action = htmlspecialchars($_GET['action']);

        if($_GET['action'] == 1) {
            // Création de l'objet de mon personnage
            $perso = $_SESSION['perso'];
            $classePerso = ucfirst($perso['classePerso']);
            $monPerso = new $classePerso($perso); 

            // On verifie que le personnage a assez d'energie
            $verifEnergie = $monPerso->verifEnergie(10);
            if($verifEnergie == 0) {
                $_SESSION['message'][] = "Vous n'avez plus assez d'énergie ...";
                header('Location: ../aventure.php');
            }else {
                // Numero aleatoire pour attribué le chemin
                $numeroChemin = $monPerso->lanceDes(1,3);
                // On retire l'energie du personnage
                $monPerso->perteEnergie(10);
                // On ajoute l'experience gagné
                $monPerso->gainExp(5);
                // On verifie les niveaux des barres d'infos
                $monPerso->verifEtat();
                // On modifie les infos dans la BDD
                $manager->modifPerso($monPerso);
                // On recupère le personnage de la BDD pour mettre a jour dans la session
                $persoMAJ = $manager->selectionPerso($monPerso->getNomPerso());
                $_SESSION['perso'] = $persoMAJ;
                // On indique dans la session le numero du chemin a prendre
                $_SESSION['action1'] = $numeroChemin;
                header('Location: ../aventure.php');
            }
        }elseif($_GET['action'] == 1.1) {
            $perso = $_SESSION['perso'];
            $classePerso = ucfirst($perso['classePerso']);
            $monPerso = new $classePerso($perso);

            // On verifie que le personnage a assez d'energie
            $verifEnergie = $monPerso->verifEnergie(10);
            if($verifEnergie == 0) {
                $_SESSION['message'][] = "Vous n'avez plus assez d'énergie ...";
                header('Location: ../aventure.php');
            }else {
                $numeroApproche = $monPerso->lanceDes(1,3);
                $monPerso->perteEnergie(10);
                // On verifie les niveaux des barres d'infos
                $monPerso->verifEtat();
                $manager->modifPerso($monPerso);
                $persoMAJ = $manager->selectionPerso($monPerso->getNomPerso());
                $_SESSION['perso'] = $persoMAJ;
                $_SESSION['action1_1'] = $numeroApproche;
                header('Location: ../aventure.php');
            }

        }elseif($_GET['action'] == 2) {
            $perso = $_SESSION['perso'];
            $classePerso = ucfirst($perso['classePerso']);
            $monPerso = new $classePerso($perso);

            // On verifie que le personnage a assez d'energie
            $verifEnergie = $monPerso->verifEnergie(10);
            if($verifEnergie == 0) {
                $_SESSION['message'][] = "Vous n'avez plus assez d'énergie ...";
                header('Location: ../aventure.php');
            }else {
                $numeroApproche = $monPerso->lanceDes(1,3);
                $monPerso->perteEnergie(10);
                // On verifie les niveaux des barres d'infos
                $monPerso->verifEtat();
                $manager->modifPerso($monPerso);
                $persoMAJ = $manager->selectionPerso($monPerso->getNomPerso());
                $_SESSION['perso'] = $persoMAJ;
                $_SESSION['action2'] = 1;
                header('Location: ../aventure.php');
            }

        }elseif($_GET['action'] == 2.2) {
            $perso = $_SESSION['perso'];
            $classePerso = ucfirst($perso['classePerso']);
            $monPerso = new $classePerso($perso);

            // On verifie que le personnage a assez d'energie
            $verifEnergie = $monPerso->verifEnergie(20);
            if($verifEnergie == 0) {
                $_SESSION['message'][] = "Vous n'avez plus assez d'énergie ...";
                header('Location: ../aventure.php');
            }else {
                // Combat
                $monPerso->perteEnergie(20);
                $premierCombattant = $monPerso->combatEnPremier();
                if($premierCombattant == 1) {
                    $monPerso->attaquePNJ();
                    $monPerso->gainExp(15);
                    $_SESSION['combat'] = 1; // perfect_combat
                }else {
                    $monPerso->attaqueDuPNJ(5);
                    $verifMort = $monPerso->verifMort();
                    if($verifMort == 4) {
                        $monPerso->attaquePNJ();
                        $monPerso->gainExp(15);
                        $_SESSION['combat'] = 2; // blessure combat
                    }else {
                        $_SESSION['message'][] = "OOPS ! Votre personnage a succombé !";
                        // Delete le perso de la BDD
                        header('Location: ../index.php');
                    }
                }
                // On verifie les niveaux des barres d'infos
                $monPerso->verifEtat();
                $manager->modifPerso($monPerso);
                $persoMAJ = $manager->selectionPerso($monPerso->getNomPerso());
                $_SESSION['perso'] = $persoMAJ;
                $_SESSION['cacherBouton'] = true;
                header('Location: ../attente_combat.php');
            }
        }elseif($_GET['action'] == 2.3) {
            // Fuite
            $perso = $_SESSION['perso'];
            $classePerso = ucfirst($perso['classePerso']);
            $monPerso = new $classePerso($perso);

            // On verifie que le personnage a assez d'energie
            $verifEnergie = $monPerso->verifEnergie(30);
            if($verifEnergie == 0) {
                $_SESSION['message'][] = "Vous n'avez plus assez d'énergie ...";
                header('Location: ../aventure.php');
            }else {
                $monPerso->perteEnergie(30);
                $chance = $monPerso->lanceDes(1, 2);
                if($chance == 1) {
                    // Pas de degats
                    // On verifie les niveaux des barres d'infos
                    $monPerso->verifEtat();
                    $manager->modifPerso($monPerso);
                    $persoMAJ = $manager->selectionPerso($monPerso->getNomPerso());
                    $_SESSION['perso'] = $persoMAJ;
                    $_SESSION['fuite'] = 1;
                    $_SESSION['cacherBouton'] = true;
                    header('Location: ../attente_combat.php');
                }else {
                    // 5 pts de degats
                    $monPerso->attaqueDuPNJ(5);
                    $verifMort = $monPerso->verifMort();
                    if($verifMort == 4) {
                        // On verifie les niveaux des barres d'infos
                        $monPerso->verifEtat();
                        $manager->modifPerso($monPerso);
                        $persoMAJ = $manager->selectionPerso($monPerso->getNomPerso());
                        $_SESSION['perso'] = $persoMAJ;
                        $_SESSION['cacherBouton'] = true;
                        $_SESSION['fuite'] = 2;
                        header('Location: ../attente_combat.php');
                    }else {
                        $_SESSION['message'][] = "OOPS ! Votre personnage a succombé !";
                        // Delete le perso de la BDD
                        header('Location: ../index.php');
                    }
                }
            }

        }elseif($_GET['action'] == 2.4) {
            $perso = $_SESSION['perso'];
            $classePerso = ucfirst($perso['classePerso']);
            $monPerso = new $classePerso($perso);
            
            // On verifie les niveaux des barres d'infos
            $monPerso->verifEtat();
            $manager->modifPerso($monPerso);
            $persoMAJ = $manager->selectionPerso($monPerso->getNomPerso());
            // On supprime la session pour pouvoir rejouer a la fin du jeu sans devoir se deco/reco
            session_unset();
            $_SESSION['perso'] = $persoMAJ;
            $_SESSION['finAventure'] = true;
            
            header('Location: ../jeu2.php');
        }
    }elseif(isset($_GET['id_item']) && isset($_GET['nb_items'])) {
        $idItem = htmlspecialchars($_GET['id_item']);
        $nbItems = htmlspecialchars($_GET['nb_items']);

        $perso = $_SESSION['perso'];
        $classePerso = ucfirst($perso['classePerso']);
        $monPerso = new $classePerso($perso);

        $idPerso = $monPerso->getIdPerso();

        // Verifier les niveau avant de use l'item !!

        $manager->useItem($idItem, $idPerso);
        $monPerso->effetItem($idItem);
        // On verifie les niveaux des barres d'infos
        $monPerso->verifEtat();
        $manager->modifPerso($monPerso);
        $persoMAJ = $manager->selectionPerso($monPerso->getNomPerso());
        $_SESSION['perso'] = $persoMAJ;
        header('Location: ../aventure.php');
    }