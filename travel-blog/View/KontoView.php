<?php

//Widok danych konta
class KontoView extends MainView {
    public function __construct($model) {
        parent::__construct($model);
    }
    
    //pokaż ciało widoku
    public function showKontoView() { 
        //załaduj dane konta użytkownika
        $data = $this->model->getUserData();
        
        echo    '<div class="container d-flex flex-column min-vh-100">'.
                    '<div class="row">'.
                        '<div class="col-sm-9 col-md-7 col-lg-5 mx-auto">'.
                            '<div class="card my-5">'.
                                '<div class="card-header text-center">';
                                    if (isset($data['userName'])) { echo $data['userName']; }
        echo                        '<br>';
                                    if (isset($data['status'])) {
                                        if ($data['status']=='2') {
                                            echo '<div class="text-warning"><small>Administrator</small></div>';
                                        } else {
                                            echo '<div class="text-secondary"><small>Użytkownik</small></div>';
                                        }
                                    }
        echo                    '</div>'.
                                '<div class="card-body">'.
                                    '<table class="table table-borderless">'.
                                     '<tr>'.
                                        '<td><div class="text-end">Imię i nazwisko:</div></td>'.
                                        '<td><div class="text-start">';
                                        if (isset($data['fullName'])) {
                                            echo $data['fullName'];
                                        }
        echo                            '</div></td>'.
                                    '</tr>'.
                                    '<tr>'.
                                        '<td><div class="text-end">Adres e-mail:</div></td>'.
                                        '<td><div class="text-start">';
                                        if (isset($data['email'])) {
                                            echo $data['email'];
                                        }
        echo                            '</div></td>'.
                                    '</tr>'.
                                    '<tr>'.
                                        '<td><div class="text-end">Data rejstracji:</div></td>'.
                                        '<td><div class="text-start">';
                                        if (isset($data['dateOfRegistration'])) {
                                            echo $data['dateOfRegistration'];
                                        }
        echo                            '</div></td>'.
                                    '</tr>'.
                                    '<tr>'.
                                        '<td><div class="text-end">Data urodzenia:</div></td>'.
                                        '<td><div class="text-start">';
                                        if (isset($data['dateOfBirth'])) {
                                            echo $data['dateOfBirth'];
                                        }
        echo                            '</div></td>'.
                                    '</tr>'.
                                    '</table>'.
                                    '<form method="post" action="editKonto.php">'.
                                        '<div class="d-grid gap-2">'.
                                            '<button type="submit" class="btn btn-dark btn-block" name="haslo-form" value="haslo-form">Zmień hasło</button>'.
                                            '<button type="submit" class="btn btn-dark btn-block" name="dane-form" value="dane-form">Edytuj dane</button>'.
                                            '<button type="submit" class="btn btn-danger btn-block" name="usun" value="usun">Usuń konto</button>';
        echo                            '</div>'.  
                                    '</form>'.
                                    '<form method="post">'.
                                       '<div class="d-grid gap-2">';
        echo                                '<button type="submit" class="btn btn-primary btn-block" name="wyloguj" value="wyloguj">Wyloguj się</button>'.
                                        '</div>'.   
                                    '</form>'.
                                '</div>'.
                            '</div>'.
                        '</div>'.
                    '</div>'.
                '</div>';
    }
    
    //pokaż całość strony dla danych konta
    public function showView() {
        $this->showHeader();
        $this->showNavBar();
        $this->showKontoView();
        $this->showFooter();          
    }
    
}

