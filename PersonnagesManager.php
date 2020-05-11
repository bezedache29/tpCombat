<?php

    class PersonnagesManager {
        private $_db;

        public function __construct($db) {
            $this->setDb($db);
        }

        public function setDb($db) {
            $this->_db = $db;
        }

        public function addPerso(Personnage $perso) {
            // Ajout d'un personnage dans la BDD
            // On enregistre les pseudo en majuscule dans la bdd
            $nomPerso = strtoupper($perso->getNomPerso());

            $query = $this->_db->prepare('INSERT INTO tpcombat(nomPerso) VALUES(:nomPerso)');
            $value = [
                'nomPerso' => $nomPerso,
            ];
            $query->execute($value);

            $perso->hydrate([
                'idPerso' => $this->_db->lastInsertId(),
                'degatsPerso' => 0
            ]);

            //print_r($query->errorInfo());
        }

        public function modifPerso(Personnage $perso) {
            // Modifie un personnage dans la BDD
            $query = $this->_db->prepare('UPDATE tpcombat SET degatsPerso = :degatsPerso, niveauPerso = :niveauPerso, expPerso = :expPerso WHERE idPerso = :idPerso');
            $values = [
                'niveauPerso' => $perso->getNiveauPerso(),
                'expPerso' => $perso->getExpPerso(),
                'degatsPerso' => $perso->getDegatsPerso(),
                'idPerso' => $perso->getIdPerso()
            ];
            $query->execute($values);

            print_r($query->errorInfo());
        }

        public function supprPerso(Personnage $perso) {
            // Supprime un perso dans la BDD
            $query = $this->_db->prepare('DELETE FROM tpcombat WHERE idPerso = :idPerso');
            $value = [
                'idPerso' => $perso->getIdPerso()
            ];
            $query->execute($value);

            print_r($query->errorInfo());
        }

        public function listPersos() {
            // Liste tous les persos de la BDD
            $query = $this->_db->prepare('SELECT * FROM tpcombat');
            $query->execute();
            $donnees = $query->fetchAll();

            return $donnees;
        }

        public function selectionPerso($valeur) {
            // Liste infos de l'id en question
            if(is_int($valeur)) {
                echo $valeur;
                $query = $this->_db->prepare('SELECT * FROM tpcombat WHERE idPerso = :idPerso');
                $value = [
                    'idPerso' => $valeur
                ];
                $query->execute($value);
                $donnees = $query->fetch();

                return $donnees;
            }else if(is_string($valeur)) {
                $query = $this->_db->prepare('SELECT * FROM tpcombat WHERE nomPerso = :nomPerso');
                $value = [
                    'nomPerso' => $valeur
                ];
                $query->execute($value);
                $donnees = $query->fetch();

                return $donnees;
            }
        }

        public function compterPersos() {
            $query = $this->_db->prepare('SELECT * FROM tpcombat');
            $query->execute();

            $resultats = $query->fetchAll();

            $cpt = count($resultats);

            return $cpt;
        }

        const PERSONNAGE_EXISTANT = 0;
        const PERSONNAGE_INEXISTANT = 1;
        const PERSONNAGE_VIDE = 2;

        public function verifNom($nom) {
            if(empty($nom)) {
                $nom_vide = self::PERSONNAGE_VIDE;
                return $nom_vide;
            }else {
                $query = $this->_db->prepare('SELECT * FROM tpcombat WHERE nomPerso = :nomPerso');
                $value = [
                    'nomPerso' => $nom
                ];
                $query->execute($value);
                $donnees = $query->fetch();

                if($donnees['nomPerso'] == $nom) {
                    return self::PERSONNAGE_EXISTANT;
                }else {
                    return self::PERSONNAGE_INEXISTANT;
                }
            }
        }

        public function verifAdversaire($nom) {
            if(empty($nom)) {
                $nom_vide = self::PERSONNAGE_VIDE;
                return $nom_vide;
            }else {
                $query = $this->_db->prepare('SELECT * FROM tpcombat WHERE nomPerso = :nomPerso');
                $value = [
                    'nomPerso' => $nom
                ];
                $query->execute($value);
                $donnees = $query->fetch();

                $nom = strtoupper($nom);

                if($donnees['nomPerso'] == $nom) {
                    return $donnees;
                }else {
                    return self::PERSONNAGE_INEXISTANT;
                }
            }
        }

        /* public function persoExiste(Personnage $perso) {
            if(isset($perso->getId())) {
                $query = $this->_db->prepare('SELECT * FROM tpcombat WHERE idPerso = :idPerso');
                $value = [
                    'idPerso' => $perso->getId()
                ];
                $query->execute($value);
                $donnees = $query->fetch();

                return $donnees;
            }
        } */
    }