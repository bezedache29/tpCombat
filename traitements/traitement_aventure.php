<?php
    include('../config/init.php');

    function chargerClass($class) {
        include('../' . $class . '.php');
    }
    spl_autoload_register('chargerClass');

    include('../config/db.php');

    if(isset($_GET['action'])) {
        $perso = $_SESSION['perso'];
        $classePerso = ucfirst($perso['classePerso']);
        $monPerso = new $classePerso($perso); 

        $action = htmlspecialchars($_GET['action']);
        if($action == 1) {
            $numeroChemin = $monPerso->lanceDes(1,3);
            $monPerso->perteEnergie(10);
            $manager->modifPerso($monPerso);
            $persoMAJ = $manager->selectionPerso($monPerso->getNomPerso());
            $_SESSION['perso'] = $persoMAJ;
            $_SESSION['action1'] = $numeroChemin;
            header('Location: ../aventure.php');
        }
    }