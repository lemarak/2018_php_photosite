<?php

class Concours
{
    private $_id;
    private $_nom;
    private $_theme;
    private $_descriptif;
    private $_mois;
    private $_annee;
    private $_dateDebut;
    private $_dateFin;
    private $_actifDepot;
    private $_dateDebutVote;
    private $_dateFinVote;
    private $_actifVote;
    private $_archive;
    private $_dateCreation;

    //constructeur
    public function __construct(array $data){
        $this->hydrate($data);
    }

    //getters
    public function id() { return $this->_id; }
    public function nom() { return $this->_nom; }
    public function theme() { return $this->_theme; }
    public function descriptif() { return $this->_descriptif; }
    public function mois() { return $this->_mois; }
    public function annee() { return $this->_annee; }
    public function dateDebut() { return $this->_dateDebut; }
    public function dateFin() { return $this->_dateFin; }
    public function actifDepot() { return $this->_actifDepot; }
    public function dateDebutVote() { return $this->_dateDebutVote; }
    public function dateFinVote() { return $this->_dateFinVote; }
    public function actifVote() { return $this->_actifVote; }
    public function archive() { return $this->_archive; }
    public function dateCreation() { return $this->_dateCreation; }


    //hydrate
    public function hydrate(array $data){
        foreach($data as $key=>$value){
            $method='set'.ucfirst($key);
            if (method_exists($this,$method)){
                $this->$method($value);
            }
        }
    }

    //setters
    public function setId($id) {
        $this->_id = (int) $id;
    }
    public function setNom($str) {
        if (is_string($str)){
            $this->_nom = $str;
        }
    }
    public function setTheme($str) {
        if (is_string($str)){
            $this->_theme = $str;
        }
    }
    public function setDescriptif($str) {
        if (is_string($str)){
            $this->_descriptif = $str;
        }
    }
    public function setMois($str) {
        if (is_string($str)){
            $this->_mois = $str;
        }
    }
    public function setAnnee($num) {
        $this->_annee = (int) $num;
    }
    public function setDateDebut($dat) {
        $this->_dateDebut =  $dat;
    }
    public function setDateFin($dat) {
        $this->_dateFin =  $dat;
    }
    public function setActifDepot($bool) {
        $this->_actifDepot =  $bool;
    }
    public function setDateDebutVote($dat) {
        $this->_dateDebutVote =  $dat;
    }
    public function setDateFinVote($dat) {
        $this->_dateFinVote =  $dat;
    }
    public function setActifVote($bool) {
        $this->_actifVote =  $bool;
    }
    public function setArchive($bool) {
        $this->_archive =  $bool;
    }
    public function setDateCreation($dat) {
        $this->_dateCreation =  $dat;
    }
}