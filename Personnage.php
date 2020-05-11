<?php

    class Personnage {
        private $_id;
        private $_nom;
        private $_degats;
        private $_niveau;
        private $_exp;

        const CEST_MOI = 1;
        const PERSONNAGE_TUE = 2;
        const PERSONNAGE_FRAPPER = 3;

        public function __construct(array $donnees) {
            $this->hydrate($donnees);
        }

        public function hydrate(array $donnees) {   // Exemple : pour le 'nom' | On récupère dans un tableau des infos du personnage
            foreach($donnees as $key => $value) {   // On liste les infos en recupérant l'index et la valeur (ici index 'nom' et valeur du nom)
                $method = 'set' . ucfirst($key);    // Création d'une method ayant pour valeur : setNom
                if(method_exists($this, $method)) { // Si dans la class Personnage un setNom existe alors :
                    $this->$method($value);         // Personnage::setNom = la valeur de nom
                }
            }
        }

        public function att($perso) {
            // Si l'id du $perso est identitque a mon ID, alors on retourne une erreur
            if($perso->getIdPerso() == $this->_id){
                return self::CEST_MOI;
            // Sinon on apel la methode dmgRecu pour le $perso
            }else {
                return $perso->dmgRecu();
            }
        }

        public function dmgRecu() {
            $this->_degats = $this->_degats + 5;
            if($this->_degats >= 100) {
                return self::PERSONNAGE_TUE;
            }else {
                return self::PERSONNAGE_FRAPPER;
            }
        }

        public function addExp() {
            $exp = $this->getExpPerso() + 5;
            $this->setExpPerso($exp);
        }

        public function addLvl() {
            $lvl = $this->getNiveauPerso() + 1;
            $this->setNiveauPerso($lvl);
        }

        // SEETERS
        public function setIdPerso($id) {
            $id = intval($id);
            if(!(is_int($id))) {
                trigger_error('Les ID doivent être des chiffres');
                return;
            }else {
                $this->_id = $id;
            }
        }

        public function setNomPerso($nom) {
            if(!(is_string($nom))) {
                trigger_error('Les noms doivent être des strings');
                return;
            }else  if(strlen($nom) > 30) {
                trigger_error('Les noms ne doivent pas dépasser 30 caractères');
                return;
            }else {
                $this->_nom = $nom;
            }
        }

        public function setDegatsPerso($dmg) {
            $dmg = intval($dmg);
            if(!(is_int($dmg))) {
                trigger_error('Les dégats doivent être des chiffres');
                return;
            }else if($dmg < 0 && $dmg > 100) {
                trigger_error('Les dégats doivent être entre 0 et 100');
                return;
            }else {
                $this->_degats = $dmg;
            }
        }

        public function setNiveauPerso($lvl) {
            $lvl = intval($lvl);
            if(!(is_int($lvl))) {
                trigger_error('Les niveaux doivent être des chiffres');
                return;
            }else if($lvl < 1 && $lvl > 100) {
                trigger_error('Les niveaux doivent être entre 1 et 100');
                return;
            }else {
                $this->_niveau = $lvl;
            }
        }

        public function setExpPerso($exp) {
            $exp = intval($exp);
            if(!(is_int($exp))) {
                trigger_error('Les expériences doivent être des chiffres');
                return;
            }else if($exp < 1 && $exp > 100) {
                trigger_error('Les expériences doivent être entre 1 et 100');
                return;
            }else {
                $this->_exp = $exp;
            } 
        }

        // GETTERS
        public function getIdPerso() {
            return $this->_id;
        }
        public function getNomPerso() {
            return $this->_nom;
        }
        public function getDegatsPerso() {
            return $this->_degats;
        }
        public function getNiveauPerso() {
            return $this->_niveau;
        }
        public function getExpPerso() {
            return $this->_exp;
        }
    }