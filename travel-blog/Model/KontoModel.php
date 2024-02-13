<?php

//Model strony konto
class KontoModel extends PageModel {    
    protected $userData;

    public function __construct() {
        parent::__construct("Konto", "Konto");
    }
     
    public function getUserData() {
        return $this->userData;
    }
    
    public function setUserData($userData) {
        $this->userData = $userData;
    }
    
    //załaduj dane użytkownika o podanym id
    public function loadUserData($db, $userId) {
        $sql="SELECT userName, fullName, email, dateOfRegistration, dateOfBirth, status from users where id='$userId'";
        $pola=["userName","fullName","email", "dateOfRegistration", "dateOfBirth","status"];
            
        $userData=$db->selectData($sql, $pola);
        $this->userData=$userData[0];
    }
}
