<?php

    class Magicien extends Personnage {
        private $_mana = 100;
        private $_type = 'Magicien';

        public function setMana($nb) {
            $nb = intval($nb);
            if(!(is_int($nb))) {
                trigger_error('Les atouts doivent être des chiffres');
                return;
            }else {
                $this->_mana = $nb;
            }
        }

        public function getType() {
            return $this->_type;
        }

        public function getMana() {
            return $this->_mana;
        }

        public function lancerSort($perso) {
            if($perso->getIdPerso() == $this->_id){
                return self::CEST_MOI;
            }else {
                $verifMana = $this->verifMana();
                if($verifMana == 1) {
                    $this->_mana -= 20;
                    return $perso->bouleDeFeu();
                    // Si il tue l'ennemi il récupère 50% mana
                }else {
                    // On ne lance pas le sort
                }
            }
        }

        public function bouleDeFeu() {
            $this->_degats = $this->_degats + 15;
            if($this->_degats >= 100) {
                return self::PERSONNAGE_TUE;
            }else {
                return self::PERSONNAGE_FRAPPER;
            }
        }

        private function verifMana() {
            if($this->_mana > 0) {
                return self::ENCORE_DE_LA_MANA;
            }else {
                return self::PLUS_DE_MANA;
            }
        }
    }