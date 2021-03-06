<?php

    class PersonnagesManager {
        private $_db;

        const PERSONNAGE_EXISTANT = 0;
        const PERSONNAGE_INEXISTANT = 1;
        const PERSONNAGE_VIDE = 2;
        const MAIL_VIDE = 0;
        const MAIL_EXISTANT = 1;
        const MAIL_INEXISTANT = 2;
        const MOT_DE_PASSE_CORRECT = 1;
        const MOT_DE_PASSE_INCORRECT = 0;
        const PWD_VALIDE = 1;
        const PWD_INVALIDE = 0;

        public function __construct($db) {
            $this->setDb($db);
        }

        public function setDb($db) {
            $this->_db = $db;
        }

        public function addPerso(Personnage $perso, $id) {
            // Ajout d'un personnage dans la BDD
            // On enregistre les pseudo en majuscule dans la bdd
            $nomPerso = strtoupper($perso->getNomPerso());
            $classePerso = $perso->getClassePerso();

            $query = $this->_db->prepare('INSERT INTO tpcombat(nomPerso, classePerso, id_joueur) VALUES(:nomPerso, :classePerso, :id_joueur)');
            $value = [
                'nomPerso' => $nomPerso,
                'classePerso' => $classePerso,
                'id_joueur' => $id
            ];
            $query->execute($value);

            $perso->hydrate([
                'idPerso' => $this->_db->lastInsertId(),
                'degatsPerso' => 0,
                'manaPerso' => 0,
                'ragePerso' => 0
            ]);

            print_r($query->errorInfo());
        }

        public function dernierId() {
            return $this->_db->lastInsertId();
        }

        public function modifPerso(Personnage $perso) {
            // Modifie un personnage dans la BDD
            $query = $this->_db->prepare('UPDATE tpcombat SET degatsPerso = :degatsPerso, niveauPerso = :niveauPerso, expPerso = :expPerso, energiePerso = :energiePerso, ragePerso = :ragePerso, forcePerso = :forcePerso WHERE idPerso = :idPerso');
            $values = [
                'niveauPerso' => $perso->getNiveauPerso(),
                'expPerso' => $perso->getExpPerso(),
                'degatsPerso' => $perso->getDegatsPerso(),
                'idPerso' => $perso->getIdPerso(),
                'energiePerso' => $perso->getEnergiePerso(),
                'ragePerso' => $perso->getRagePerso(),
                'forcePerso' => $perso->getForcePerso()
            ];
            $query->execute($values);

            //print_r($query->errorInfo());
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

        public function RecupIdPerso($mail) {
            $query = $this->_db->prepare('SELECT * FROM joueurs INNER JOIN tpcombat ON joueurs.id_joueur = tpcombat.id_joueur WHERE joueurs.mail_joueur = :mail_joueur');
            $value = [
                'mail_joueur' => $mail
            ];
            $query->execute($value);
            $donnees = $query->fetch();

            return $donnees['idPerso'];
        }

        public function compterPersos() {
            $query = $this->_db->prepare('SELECT * FROM tpcombat');
            $query->execute();

            $resultats = $query->fetchAll();

            $cpt = count($resultats);

            return $cpt;
        }

        

        public function verifNom($nom) {
            if(empty($nom)) {
                $nomVide = self::PERSONNAGE_VIDE;
                return $nomVide;
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

        public function verifMail($mail) {
            if(empty($mail)) {
                $mailVide = self::MAIL_VIDE;
                return $mailVide;
            }else {
                $query = $this->_db->prepare('SELECT * FROM joueurs WHERE mail_joueur = :mail_joueur');
                $value = [
                    'mail_joueur' => $mail
                ];
                $query->execute($value);
                $donnees = $query->fetch();

                if($donnees['mail_joueur'] == $mail) {
                    return self::MAIL_EXISTANT;
                }else {
                    return self::MAIL_INEXISTANT;
                }
            }
        }

        public function verifAdversaire($nom) {
            if(empty($nom)) {
                $nomVide = self::PERSONNAGE_VIDE;
                return $nomVide;
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

        public function verifPwd($pwd1, $pwd2) {
            if($pwd1 != $pwd2) {
                return self::MOT_DE_PASSE_INCORRECT;
            }else {
                return self::MOT_DE_PASSE_CORRECT;
            }
        }

        public function addJoueur($mail, $pwd) {
            $query = $this->_db->prepare('INSERT INTO joueurs(mail_joueur, pwd_joueur, date_inscription) VALUES(:mail_joueur, :pwd_joueur, NOW())');
            $values = [
                'mail_joueur' => $mail,
                'pwd_joueur' => $pwd
            ];
            $query->execute($values);

            print_r($query->errorInfo());
        }

        public function verifPwdJoueur($mail, $pwd) {
            $query = $this->_db->prepare('SELECT * FROM joueurs WHERE mail_joueur = :mail_joueur');
            $value = [
                'mail_joueur' => $mail
            ];
            $query->execute($value);
            $donnees = $query->fetch();

            if($donnees['pwd_joueur'] == $pwd) {
                return self::PWD_VALIDE;
            }else {
                return self::PWD_INVALIDE;
            }
        }

        public function listItems($id) {
            $query = $this->_db->prepare('SELECT * FROM items INNER JOIN items_persos ON items.id_item = items_persos.id_item INNER JOIN tpcombat ON items_persos.idPerso = tpcombat.idPerso WHERE tpcombat.idPerso = :idPerso');
            $value = [
                'idPerso' => $id
            ];
            $query->execute($value);
            $donnees = $query->fetchAll();

            return $donnees;
        }

        public function useItem($idItem, $idPerso) {
            $query = $this->_db->prepare('SELECT * FROM items_persos WHERE idPerso = :idPerso AND id_item = :id_item');
            $values = [
                'idPerso' => $idPerso,
                'id_item' => $idItem
            ];
            $query->execute($values);
            $item = $query->fetch();

            $newNbItem = $item['nb_items'] -= 1;
            if($newNbItem == 0) {
                $this->supprItem($idItem, $idPerso);
            }else {
                $this->modifItem($idItem, $idPerso, $newNbItem);
            }

            //print_r($query->errorInfo());
        }

        public function supprItem($idItem, $idPerso) {
            $query = $this->_db->prepare('DELETE FROM items_persos WHERE idPerso = :idPerso AND id_item = :id_item');
            $values = [
                'idPerso' => $idPerso,
                'id_item' => $idItem
            ];
            $query->execute($values);

            //print_r($query->errorInfo());
        }

        public function modifItem($idItem, $idPerso, $newNbItem) {
            $query = $this->_db->prepare('UPDATE items_persos SET nb_items = :nb_items WHERE idPerso = :idPerso AND id_item = :id_item');
            $values = [
                'idPerso' => $idPerso,
                'id_item' => $idItem,
                'nb_items' => $newNbItem
            ];
            $query->execute($values);

            //print_r($query->errorInfo());            
        }
    }