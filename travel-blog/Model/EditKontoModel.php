<?php

//Model strony editKonto
class EditKontoModel extends PageModel {
    protected $errors;
    protected $userData;
    protected $resultMessage;
    
    public function __construct() {
        parent::__construct("Edytuj dane konta", "Konto");
    }
    
    public function getErrors() {
        return $this->errors;
    }

    public function getUserData() {
        return $this->userData;
    }

    public function getResultMessage() {
        return $this->resultMessage;
    }

    public function setErrors($errors) {
        $this->errors = $errors;
    }

    public function setUserData($userData) {
        $this->userData = $userData;
    }

    public function setResultMessage($resultMessage) {
        $this->resultMessage = $resultMessage;
    }

    //załaduj dane użytkownika
    function loadUserData($db, $userId) {
        $sql="SELECT id, password, fullName, email, dateOfBirth from users where id='$userId'";
        
        $pola=["id", "password", "fullName", "email", "dateOfBirth"];
        
        $query=$db->selectData($sql, $pola);
        $this->userData=$query[0];
    }
    
    //waliduj dane zmiany hasła
    //zaktualizuj hasło w bazie danych jeżeli walidacja przejdzie pomyślnie
    function checkPasswordData($db, $userId) {
        $args = [
        'password-old' => ['filter' =>  FILTER_DEFAULT],
         // hasło 8-25 znaków, minumum jedna duża litera, mała litera, znak specjalny i cyfra
        'password-new' => ['filter' => FILTER_VALIDATE_REGEXP,
                           'options' => ['regexp' => '/^\S*(?=\S{8,25})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$/']]
            ];
        
        $password=$this->userData['password'];
        
        $dane = filter_input_array(INPUT_POST, $args);
        
        // Sprawdz czy są błędy walidacji $errors 
        $errors = "";
        
        foreach ($dane as $key => $val) {
        if ($val === false or $val === NULL) { 
            $errors .= $key . " ";
            }     
        }   
        
        // Zaktualizuj wartości pól
        $this->userData=$dane;
        
        if (!password_verify($dane['password-old'], $password)) {
            $errors .= "password-old"." ";
            $errors .= "password-not-same"." ";
        }
        
        if ($dane['password-old']===$dane['password-new']) {
            $errors .= "password-new"." ";
            $errors .= "no-new-pass"." ";
        }
       
        
        if ($errors === "") { w
            $this->errors="";
            $password=password_hash($dane['password-new'], PASSWORD_DEFAULT);
            $sql="UPDATE users SET password='$password' WHERE id=$userId";
            $db->update($sql);
            $this->resultMessage='<p class="text-success text-center">Zamieniono dane pomyślnie!</p>';
            return true;
        } else {
            $this->resultMessage='<p class="text-danger text-center">Niepoprawne dane rejestracji.</p>';
            $this->errors = $errors;
            return false;
        }
    }


    //sprawdź dane edycji konta
    //zaktualizuj dane użytkownika jeżeli waldacja przejdzie pomyślnie
    function checkEditData($db, $userId) {
        $args = [
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
        $this->userData=$dane;
        $this->userData['id'] = $userId;
        
        $errors = $this->validateAge($errors);
        $errors = $this->checkEmail($db, $errors);
        
        
        if ($errors === "") {
            $this->errors="";
            
            $fullName=$dane['fullName'];
            $email=$dane['email'];
            $dateOfBirth=$dane['dateOfBirth'];
            
            $sql="UPDATE users SET fullName='$fullName', email='$email', 
                  dateOfBirth='$dateOfBirth' WHERE id=$userId";
            $db->update($sql);
            $this->resultMessage='<p class="text-success text-center">Zamieniono dane pomyślnie!</p>';
            return true;
        } else {
             $this->resultMessage='<p class="text-danger text-center">Niepoprawne dane rejestracji.</p>';
            // Zaaktualizuj nazwy błędnych pól
            $this->errors = $errors;
            return false;
        }
    }
    
    // usuń konto użtkownika o podanym id z bazy danych
    function usunKonto($db, $userId) {
        $sql="DELETE FROM users WHERE id='$userId'";
        return $result = $db->update($sql);     
    }

    // sprawdź czy e-mail jest unikalny
    function checkEmail($db, $errors) {
        $email=$this->userData['email'];
        $userId=$this->userData['id'];
        $sql = "SELECT email from users WHERE email='$email' AND NOT id='$userId'";
        $pola = ['email'];
        
        $query=$db->selectData($sql, $pola);
        
        if (!empty($query)) {
            $this->dane['email']='';
            $errors .= 'email'. ' ';
            $errors .= 'emailUQ'. ' ';
        }
        return $errors;
    }
    
    // waliduj wiek
    function validateAge($errors) {
        $dateOfBirth=$this->userData['dateOfBirth'];
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
