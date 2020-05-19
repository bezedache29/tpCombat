<?php

    class Guerrier extends Personnage {
        // Sort : Lorsque full rage la prochaine attaque le soigne de 15 pv
        // Il gagne 4pts de rage par coups donnée
        private $_rage = 0; // Max 20
        private $_classe = 'guerrier';

        public function setRage($nb) {
            $nb = intval($nb);
            if(!(is_int($nb))) {
                trigger_error('Les atouts doivent être des chiffres');
                return;
            }else {
                $this->_rage = $nb;
            }
        }

        public function getClassePerso() {
            return $this->_classe;
        }

        public function getRagePerso() {
            return $this->_rage;
        }

        // Fonction permettant au Guerrier d'utiliser toute sa rage pour enlever 15pts de degats subis
        public function attFulgu($perso) {
            if($perso->getIdPerso() == $this->_id){
                return self::CEST_MOI;
            }else {
                $this->_rage = 0;
                $this->_degats -= 15;
                return $perso->dmgRecu();
            }
        }

        public function attWar($perso) {
            if($perso->getIdPerso() == $this->_id){
                return self::CEST_MOI;
            }else {
                $dmgRecu = $perso->dmgRecu();
                // Si le guerrier frappe sa cible il recupère 4pts de rage, Si la cible meurt, le guerrier recupère 10pts de rage
                if($dmgRecu == 3) {
                    $this->_rage += 4;
                }elseif($dmgRecu == 2) {
                    $this->_rage += 10;
                }else {

                }
                return $dmgRecu;
            }
        }
    }