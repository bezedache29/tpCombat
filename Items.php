<?php

    class Items {
        protected $impactDegats;
        protected $impactForce;
        protected $impactRage;
        protected $impactMana;
        protected $nom;

        public function getImpactDegats() {
            return $this->impactDegats;
        }

        public function getImpactForce() {
            return $this->impactForce;
        }

        public function getImpactRage() {
            return $this->impactRage;
        }

        public function getImpactMana() {
            return $this->impactMana;
        }

        public function getNom() {
            return $this->nom;
        }
    }