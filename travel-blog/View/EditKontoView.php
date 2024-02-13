<?php

//Widok edycji konta
class EditKontoView extends MainView {
    public function __construct($model) {
        parent::__construct($model);
    }
    
    //pola formularza dla danych tekstowych postu
    public function editFormConstructor($errors, $dane) { // Konstruktor pól formularza  
    echo        '<div class="form-group mb-3">'.
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
    
    //pola formularza dla zmiany hasła
    public function passwordFormConstructor($errors, $dane) {
    echo        '<div class="form-group mb-3">'.
                    '<label for="password-old" class="form-label">Stare hasło</label>'.
                    '<input type="password" class="form-control ';
                    if (in_array("password-old", $errors)) { echo 'is-invalid'; }   
                    echo '" id="password-old" name="password-old">';
                    if (in_array("password-not-same", $errors)) { echo '<div class="invalid-feedback">Nieprawidłowe hasło</div>'; }
    echo         '</div>';
    echo         '<div class="form-group mb-3">'.
                    '<label for="password-new" class="form-label">Nowe hasło</label>'.
                    '<input type="password" class="form-control ';
                    if (in_array("password-new", $errors)) { echo 'is-invalid'; }   
                    echo '" aria-describedby="password-opis" id="password-new" name="password-new">';
                    if (in_array("no-new-pass", $errors)) { echo '<div class="invalid-feedback">Nowe hasło musi się różnić od starego</div>'; }
    echo            '<div id="password-opis" class="form-text">'.
                        '8-25 znaków, min. 1 duża i mała litera, znak specjalny i cyfra'.
                    '</div>'.
                '</div>';
    }
                        
    //widok ciała dla formularza edycji konta
    //$typ: 'haslo' - formularz dla zmiany hasła
    //$typ: 'dane' (i dodwolny inny) - formularz dla edycji danych konta
    public function showEditView($typ) {
        if ($this->model->getErrors()=="") { // Brak błędów - utwórz pustą tablicę
            $errors=[];
        } else { // Błędy pól formularza - zamień łańcuch błędów na tablicę
            $errors = explode(" ", $this->model->getErrors());
        }
        
        // Pobierz wartości wypełnionych pól z modelu
        $dane = $this->model->getUserData();
        
        echo    '<div class="container d-flex flex-column min-vh-100">'.
                '<div class="row">'.
                '<div class="col-sm-9 col-md-7 col-lg-5 mx-auto">'.
                    '<div class="card my-5">'.
                    '<div class="card-header text-center">Edytuj dane konta</div>'.
                    '<div class="card-body">'.
                        '<form action="editKonto.php" method="post">';
                            if ($typ=='haslo') {
                                $this->passwordFormConstructor($errors, $dane);
                            } else {
                                $this->editFormConstructor($errors, $dane);
                            }
        echo                '<hr>';
                                echo $this->model->getResultMessage();
        echo                '<div class="d-grid gap-3">';
                                 if ($typ=='haslo') {
                                    echo '<button class="btn btn-primary btn-block" type="submit" name="submit" value="haslo-edit">Zmień hasło</button>';
                                } else {
                                    echo '<button class="btn btn-primary btn-block" type="submit" name="submit" value="dane-edit">Edytuj</button>';
                                }
        echo                    '<button class="btn btn-danger btn-block" type="submit" name="submit" value="anuluj">Anuluj</button>'.            
                            '</div>'.
                        '</form>'.
                    '</div>'.
                    '</div>'.
                    '</div>'.
                '</div>'.  
                '</div>';          
    }
    
    //widok całości strony dla edycji danych konta
    public function showViewEdit($typ) {
        $this->showHeader();
        $this->showNavBar();
        $this->showEditView($typ);
        $this->showFooter();    
    }
}

