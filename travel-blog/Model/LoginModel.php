<?php

//Model strony login
class LoginModel extends PageModel {    
    protected $resultMessage;
    
    public function __construct() {
        parent::__construct("Logowanie", "Konto");
    }
    
    public function getResultMessage() {
        return $this->resultMessage;
    }
    
    public function setResultMessage($message) {
        $this->resultMessage=$message;
    }

}

