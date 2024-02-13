<?php

// Widok formularza rejestracji
class RegistrationView extends MainView {
    
    public function __construct($model) {
        parent::__construct($model);
    }
    
    // Konstruktor pól formularza
    public function formConstructor() { 
        if ($this->model->getErrors()=="") { // Brak błędów - utwórz pustą tablicę
            $errors=[];
        } else { // Błędy pól formularza - zamień łańcuch błędów na tablicę
            $errors = explode(" ", $this->model->getErrors());
        }
        
        // Pobierz wartości wypełnionych pól z modelu
        $dane = $this->model->getDane();
        
        echo    '<div class="form-group mb-3">'.
                    '<label for="login" class="form-label">Login</label>'.
                    '<input type="text" class="form-control ';
                    if (in_array("userName", $errors)) echo 'is-invalid'; // Ustaw pole na błędne
                    echo'" aria-describedby="login-opis" id="userName" name="userName" value="';
                    if (isset($dane['userName'])) { echo $dane['userName'];} // Ustaw wartość pola
        echo        '">';
                    if (in_array("userNameUQ", $errors)) { echo '<div class="invalid-feedback">Użytkownik o podanym nicku już istnieje</div>'; }
        echo        '<div id="login-opis" class="form-text">'.
                        '2-25 znaków, dozwolone małe i duże litery, cyfry, znak myślnika oraz podkreślenia'.
                    '</div>'.
                '</div>'.
                '<div class="form-group mb-3">'.
                    '<label for="password" class="form-label">Hasło</label>'.
                    '<input type="password" class="form-control ';
                    if (in_array("password", $errors)) { echo 'is-invalid'; }   
                    echo '" aria-describedby="password-opis" id="password" name="password" value="';
                    if (isset($dane['password'])) { echo $dane['password'];}
                    echo '">'.
                    '<div id="password-opis" class="form-text">'.
                        '8-25 znaków, min. 1 duża i mała litera, znak specjalny i cyfra'.
                    '</div>'.
                '</div>'.
                '<div class="form-group mb-3">'.
                    '<label for="fullName" class="form-label">Imię i Nazwisko</label>'.
                    '<input type="text" class="form-control ';
                    if (in_array("fullName", $errors)) { echo 'is-invalid'; }        
                    echo '" aria-describedby="fullName-opis" id="fullName" name="fullName" value="';
                    if (isset($dane['fullName'])) { echo $dane['fullName'];}
                    echo '">'.
                    '<div id="fullName-opis" class="form-text">'.
                    'Imię i nazwisko z dużej litery, możliwe 2 nazwiska rozdzielone myślnikiem'.
                    '</div>'.
                '</div>'.
                '<div class="form-group mb-3">'.
                    '<label for="email" class="form-label">Adres e-mail</label>'.
                    '<input type="email" class="form-control ';
                    if (in_array("email", $errors)) { echo 'is-invalid'; }
                    echo ' " id="email" name="email" value ="';
                    if (isset($dane['email'])) { echo $dane['email'];}
    echo            '">';
                if (in_array("emailUQ", $errors)) { echo '<div class="invalid-feedback">Podany adres e-mail jest zajęty</div>'; }
    echo        '</div>'.
                '<div class="form-group mb-4">'.
                    '<label for="dateOfBirth" class="form-label">Data urodzenia</label>'.
                    '<input type="date" class="form-control ';
                    if (in_array("dateOfBirth", $errors)) { echo 'is-invalid'; }
                    echo '" aria-describedby="date-opis" id="dateOfBirth" name="dateOfBirth" value="';
                    if (isset($dane['dateOfBirth'])) { echo $dane['dateOfBirth'];}
                    echo '">'.
                    '<div id="date-opis" class="form-text">'.
                        'Wymagana pełnoletność'.
                    '</div>'.
                '</div>';
    }
    
    // Pokaż formularz rejestracji
    public function showRegistrationView() { 
        echo    '<div class="container d-flex flex-column min-vh-100">'.
                '<div class="row">'.
                '<div class="col-sm-9 col-md-7 col-lg-5 mx-auto">'.
                    '<div class="card my-5">'.
                    '<div class="card-header text-center">Rejestracja</div>'.
                    '<div class="card-body">'.
                        '<form action="registration.php" method="post">';
                            $this->formConstructor();
        echo                '<hr>';
                                echo $this->model->getResultMessage();
        echo                '<div class="d-grid gap-3">'.
                                '<button class="btn btn-primary btn-block" type="submit" name="submit" value="submit">Rejestracja</button>'.
                                '<a href="login.php" style="text-align:center">Logowanie</a>'.
                            '</div>'.
                        '</form>'.
                    '</div>'.
                    '</div>'.
                    '</div>'.
                '</div>'.  
                '</div>';          
    }
    
    // Pokaż całość strony
    public function showView() {
        $this->showHeader();
        $this->showNavBar();
        $this->showRegistrationView();
        $this->showFooter();          
    }
}

