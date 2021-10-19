<?php

require_once('Manager.php');

class Membre extends Manager
{
    private $_id;
    private $_nom;
    private $_prenom;
    private $_pseudo;
    private $_pwd;
    private $_email;
    private $_presentation;
    private $_dateCreation;

    public function __construct(array $data){
        $this->hydrate($data);
    }

    //Hydrate
    public function hydrate(array $data){

        foreach($data as $key=>$value){
            $method='set'.ucfirst($key);
            if (method_exists($this,$method)){
                $this->$method($value);

            }
        }
    }

    //getters
    public function id() { return $this->_id; }
    public function nom() { return $this->_nom; }
    public function prenom() { return $this->_prenom; }
    public function pseudo() { return $this->_pseudo; }
    public function pwd() { return $this->_pwd; }
    public function email() { return $this->_email; }
    public function presentation() { return $this->_presentation; }
    public function dateCreation() { return $this->_dateCreation; }


    //setters
    public function setId($id) {
        $this->_id = (int) $id;
    }
    public function setNom($nom) {
        if (is_string($nom)){
            $this->_nom = $nom;
        }
    }
    public function setPrenom($prenom) {
        if (is_string($prenom)){
            $this->_prenom = $prenom;
        }
    }
    public function setPseudo($pseudo) {
        if (is_string($pseudo)){
            $this->_pseudo = $pseudo;
        }
    }
    public function setPwd($pwd) {
        if (is_string($pwd)){
            $this->_pwd = $pwd;
        }
    }
    public function setEmail($email)
    {
        if (is_string($email)) {
            $this->_email = $email;
        }
    }

    public function setPresentation($str)
    {
        if (is_string($str)) {
            $this->_presentation = $str;
        }
    }

    public function setDateCreation($date_creation)
    {
        if (is_string($date_creation)) {
            $this->_dateCreation = $date_creation;
        }
    }

    public function affiche() {
        echo $this->nom() .'<br/>';
        echo $this->prenom() .'<br/>';
        echo $this->pseudo() .'<br/>';
        echo $this->email() .'<br/>';
        echo $this->pwd() .'<br/>';
    }

}