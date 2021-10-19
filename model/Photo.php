<?php

//require_once('Manager.php');

class Photo extends Manager
{
    private $_id;
    private $_titre;
    private $_nom_fichier;
    private $_extension;
    private $_description;
    private $_technique;
    private $_camera;
    private $_objectif;
    private $_lieu;
    private $_datePrise;
    private $_idPseudo;
    private $_idTheme;
    private $_noteGlobale;
    private $_date_creation;

    private $_moyenne;

    public function __construct(array $data){
        $this->hydrate($data);
    }

    //getters
    public function id() { return $this->_id; }
    public function titre() { return $this->_titre; }
    public function nom_fichier() { return $this->_nom_fichier; }
    public function extension() { return $this->_extension; }
    public function description() { return $this->_description; }
    public function technique() { return $this->_technique; }
    public function camera() { return $this->_camera; }
    public function objectif() { return $this->_objectif; }
    public function lieu() { return $this->_lieu; }
    public function datePrise() { return $this->_datePrise; }
    public function idPSeudo() { return $this->_idPseudo; }
    public function idTheme() { return $this->_idTheme; }
    public function noteGlobale() { return $this->_noteGlobale; }
    public function date_creation() { return $this->_date_creation; }


    //Hydrate
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
    public function setTitre($titre) {
        if (is_string($titre)){
            $this->_titre = $titre;
        }
    }
    public function setNom_fichier($nom_fichier) {
        if (is_string($nom_fichier)) {
            $this->_nom_fichier = $nom_fichier;
        }
    }
    public function setExtension($extension)
    {
        if (is_string($extension)) {
            $this->_extension = $extension;
        }
    }
    public function setDescription($description)
    {
        if (is_string($description)) {
            $this->_description = $description;
        }
    }
    public function setTechnique($technique)
    {
        if (is_string($technique)) {
            $this->_technique = $technique;
        }
    }
    public function setCamera($camera)
    {
        if (is_string($camera)) {
            $this->_camera = $camera;
        }
    }
    public function setObjectif($objectif)
    {
        if (is_string($objectif)) {
            $this->_objectif = $objectif;
        }
    }
    public function setLieu($lieu)
    {
        if (is_string($lieu)) {
            $this->_lieu = $lieu;
        }
    }
    public function setDatePrise($datePrise)
    {
        if (is_string($datePrise)) {
            $this->_datePrise = $datePrise;
        }
    }
    public function setIdPSeudo($idPSeudo)
    {
            $this->_idPseudo = (int) $idPSeudo;
    }
    public function setIdTheme($idTheme)
    {
        $this->_idTheme = (int) $idTheme;
    }
    public function setNoteGlobale($noteGlobale)
    {
        $this->_noteGlobale = floatval($noteGlobale);
    }
    public function setDate_creation($date_creation)
    {
        if (is_string($date_creation)) {
            $this->_date_creation = $date_creation;
        }
    }


    //Calcul la note d'une critique
    public function calculNote($tabNotes) {
        $somme=0;
        for ($i=0;$i<4;$i++) {
            $somme+=$tabNotes[$i];
        }
        return ($somme/4.0);
    }
}