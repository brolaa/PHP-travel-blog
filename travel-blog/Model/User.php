<?php

//klasa użytkownik
class User {
    const STATUS_USER = 1;
    const STATUS_ADMIN = 2;

    protected $userName;
    protected $password;
    protected $fullName;
    protected $email;
    protected $dateOfBirth;
    protected $dateOfRegistration;
    protected $status;
    
    //metody klasy:
    function __construct($userName, $password, $fullName, $email, $dateOfBirth){
        //implementacja konstruktora
        $this->status=User::STATUS_USER;
        $this->userName=$userName;
        $this->password=password_hash($password, PASSWORD_DEFAULT);
        $this->fullName=$fullName;
        $this->email=$email;
        $birthDate = date_create($dateOfBirth);
        $birthDate->format('Y-m-d');
        $this->dateOfBirth=$birthDate; 
        $datetime=new DateTime();
        $datetime->format('Y-m-d');
        $this->dateOfRegistration=$datetime;
    }
    
    //pokaż dane
    public function show() {
        $data = $this->dateOfRegistration->format('Y-m-d');
        $birthDate = $this->dateOfBirth->format('Y-m-d');
        echo $this->userName." ".$this->fullName." ".$this->email." ".$data
                ." ".$birthDate." status: ".$this->status;
    }
    
    // Zapisywanie użytkownika do bazy danych
    function saveDB($db) {
        $userName=$this->userName; 
        $password=$this->password;
        $fullName=$this->fullName;
        $email=$this->email;
        $data = $this->dateOfRegistration->format('Y-m-d');
        $birthDate = $this->dateOfBirth->format('Y-m-d');
        $status=$this->status;
        
        $sql="INSERT INTO users VALUES (NULL, '$userName', '$password', '$fullName', "
                                        ."'$email', '$birthDate', '$data', '$status')";
        $db->insert($sql);
    }
    
    public function getUserName() {
        return $this->userName;
    }

    public function getPasswd() {
        return $this->passwd;
    }

    public function getFullName() {
        return $this->fullName;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getDateOfBirth() {
        return $this->dateOfBirth;
    }
    
    public function getDateOfRegistration() {
        return $this->dateOfRegistration;
    }
    
    public function getStatus() {
        return $this->status;
    }

    public function setUserName($userName): void {
        $this->userName = $userName;
    }

    public function setPasswd($passwd): void {
        $this->passwd = $passwd;
    }

    public function setFullName($fullName): void {
        $this->fullName = $fullName;
    }

    public function setEmail($email): void {
        $this->email = $email;
    }
    
    public function setDateOfBirth($date): void {
        $this->dateOfBirth = $date;
    }

    public function setDateOfRegistration($date): void {
        $this->dateOfRegistration = $date;
    }

    public function setStatus($status): void {
        $this->status = $status;
    }
}
