<?php

//Model strony registration
class RegistrationModel extends PageModel {
    protected $resultMessage;
    protected $errors;
    protected $dane;


    public function __construct() {
        parent::__construct("Rejestracja", "Konto");
        $this->errors="";
    }
    
    function getResultMessage() {
        return $this->resultMessage;
    }
    
    function getErrors() {
        return $this->errors;
    }
    
    function getDane() {
        return $this->dane;
    }
    
    function setResultMessage($message) {
        $this->resultMessage=$message;
    }
    
    
    function setErrors($error) {
        $this->errors=$error;
    }
     
    function setDane($dane) {
        $this->dane = $dane;
    }

    //Funkcja walidująca dane formularza
    //Zapisuje użytkownika do bazy danych jeżli walidacją przejdzie pomyślnie
    function checkUser($db){ 
        //Walidacja danych
        $args = [
        'userName' => ['filter' => FILTER_VALIDATE_REGEXP,
                       'options' => ['regexp' => '/^[0-9A-Za-z_-]{2,25}$/']],
         // hasło 8-25 znaków, minumum jedna duża litera, mała litera, znak specjalny i cyfra
        'password' => ['filter' => FILTER_VALIDATE_REGEXP,
                       'options' => ['regexp' => '/^\S*(?=\S{8,25})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$/']],
        'fullName' => ['filter' => FILTER_VALIDATE_REGEXP,
                       'options' => ['regexp' => '/^[A-ZŁ]{1}[a-ząęłńśćźżóć]{1,15}[\s]{1}[A-ZŻŹŁĆ]{1}[a-ząęłńśćźżóć]{1,20}(-{1}[A-ZŻŹŁĆ]{1}[a-ząęłńśćźżóć]{1,20})?$/u']],
        'email' => ['filter' => FILTER_VALIDATE_EMAIL],
        'dateOfBirth' => ['filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS]
            ];
        
        // Przefiltruj dane:
        $dane = filter_input_array(INPUT_POST, $args);
        // Sprawdz czy są błędy walidacji $errors 
        $errors = "";
        
        foreach ($dane as $key => $val) {
        if ($val === false or $val === NULL) { 
            $errors .= $key . " ";
            }     
        }   
        
        // Zaktualizuj wartości pól
        $this->dane=$dane;
        
        $errors = $this->validateAge($errors);
        $errors = $this->checkUserName($db, $errors);
        $errors = $this->checkEmail($db, $errors);
         
        if ($errors === "") {
            $this->user=new User($dane['userName'], $dane['password'],
                                 $dane['fullName'],$dane['email'], 
                                 $dane['dateOfBirth']);
            $this->user->saveDB($db);
        } else {
            $this->errors = $errors;
            $this->user = NULL;
        }
            // Zwróć użytkownika, listę błędnych pól oraz wartość wypełnionych pól
            return array($this->user, $this->errors, $this->dane);
    }
    
    // sprawdzenie czy login nie jest zajęty
    function checkUserName($db, $errors) {
        $userName=$this->dane['userName'];
        $sql = "SELECT userName from users WHERE username='$userName'";
        $pola = ['userName'];
        
        $query=$db->selectData($sql, $pola);
        
        if (!empty($query)) {
            $this->dane['userName']='';
            $errors .= 'userName'. ' ';
            $errors .= 'userNameUQ'. ' ';
        }
        return $errors;
    }
    
    // sprawdzenie czy e-mail nie jest zajęty
    function checkEmail($db, $errors) {
        $email=$this->dane['email'];
        $sql = "SELECT email from users WHERE email='$email'";
        $pola = ['email'];
        
        $query=$db->selectData($sql, $pola);
        
        if (!empty($query)) {
            $this->dane['email']='';
            $errors .= 'email'. ' ';
            $errors .= 'emailUQ'. ' ';
        }
        return $errors;
    }
    
    //walidacja wieku
    function validateAge($errors) {
        $dateOfBirth=$this->dane['dateOfBirth'];
        if ($dateOfBirth === "") { // Sprawdznie czy pusta
            $errors .= 'dateOfBirth'. ' ';
        } else { // Sprawdzenie pełnoletności
            $date=date($dateOfBirth);
            $today = date("Y-m-d");
            $min_date = date("1900-01-01");
            
            $diff = date_diff(date_create($dateOfBirth), date_create($today));
            $age = $diff->format('%y');
            if (($age < 18) || 
                ($min_date > $date) ||
                ($date > $today)) {
                $this->dane['dateOfBirth']='';
                $errors .= 'dateOfBirth'. ' ';
            }
        }
        return $errors;
    }
    
}

