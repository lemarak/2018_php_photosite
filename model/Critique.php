<?php

/**
 * Created by PhpStorm.
 * User: steph
 * Date: 05/01/2018
 * Time: 11:29
 */

require_once('Manager.php');

class Critique extends Manager
{
    private $_id;
    private $_idPhoto;
    private $_idVotant;
    private $_noteIntention;
    private $_noteTechnique;
    private $_noteImage;
    private $_noteRendu;
    private $_comIntention;
    private $_comTechnique;
    private $_comImage;
    private $_comRendu;
    private $_noteFinale;
    private $_critique;
    private $_DateCritique;

    public function __construct(array $data){
        $this->hydrate($data);
    }

    public function id() { return $this->_id; }
    public function idPhoto() { return $this->_idPhoto; }
    public function idVotant() { return $this->_idVotant; }
    public function noteIntention() { return $this->_noteIntention; }
    public function noteTechnique() { return $this->_noteTechnique; }
    public function noteImage() { return $this->_noteImage; }
    public function noteRendu() { return $this->_noteRendu; }
    public function comIntention() { return $this->_comIntention; }
    public function comTechnique() { return $this->_comTechnique; }
    public function comImage() { return $this->_comImage; }
    public function comRendu() { return $this->_comRendu; }
    public function noteFinale() { return $this->_noteFinale; }
    public function critique() { return $this->_critique; }
    public function DateCritique() { return $this->_DateCritique; }

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
    public function setIdPhoto($idPhoto) {
        $this->_idPhoto = (int) $idPhoto;
    }
    public function setIdVotant($idVotant) {
        $this->_idVotant = (int) $idVotant;
    }
    public function setNoteIntention($noteIntention) {
        $this->_noteIntention = (int) $noteIntention;
    }
    public function setNoteTechnique($noteTechnique) {
        $this->_noteTechnique = (int) $noteTechnique;
    }
    public function setNoteIMage($noteImage) {
        $this->_noteImage = (int) $noteImage;
    }
    public function setNoteRendu($noteRendu) {
        $this->_noteRendu = (int) $noteRendu;
    }
    public function setComIntention($comIntention) {
        $this->_comIntention =  $comIntention;
    }
    public function setComTechnique($comTechnique) {
        $this->_comTechnique =  $comTechnique;
    }
    public function setComImage($comImage) {
        $this->_comImage =  $comImage;
    }
    public function setComRendu($comRendu) {
        $this->_comRendu =  $comRendu;
    }
    public function setNoteFinale($noteFinale) {
        $this->_noteFinale =  $noteFinale;
    }
    public function setCritique($critique) {
        $this->_critique = $critique;
    }
    public function setDateCritique($DateCritique) {
        $this->_DateCritique =  $DateCritique;
    }
}