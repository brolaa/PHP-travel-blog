<?php

//Kontroler strony editKonto
class EditKontoController extends Controller {
    public function runView() {
        $db = new Baza("localhost", "root", "", "projekt"); //zaczep do bazy
        
        session_start();
        $sessionId = session_id();
        
        //wyszukanie id użytkownika na podstawie id sesji
        $userId=$this->manager->getLoggedInUser($db, $sessionId); 
        //nie znaleziono użytkownika pasującego do id sesji
        if ($userId == -1) {
            if ( isset($_COOKIE[session_name()]) ) {
                setcookie(session_name(),'', time() - 42000, '/');
            }                
            session_destroy();
            header("location:login.php"); 
        } else { //użytkownik zalogowany
            //pobierz dane użytkownika
            $this->model->loadUserData($db, $userId);
            
            //akcja submit z strony editView
            if (filter_input(INPUT_POST, 'submit')) { 
                $akcja = filter_input(INPUT_POST, "submit");
                switch ($akcja) {
                    //zatwierdź edycję hasła
                    case "haslo-edit":
                        $wynik = $this->model->checkPasswordData($db, $userId);
                        if ($wynik===true) {
                            header("location:konto.php");
                        }
                        $this->view->showViewEdit('haslo');
                        break;
                    //zatwierdź deycję danych
                    case "dane-edit":
                        $wynik = $this->model->checkEditData($db, $userId);
                        if ($wynik===true) {
                            header("location:konto.php");
                        }
                        $this->view->showViewEdit('dane');
                        break;
                    //anuluj akcję
                    case "anuluj":
                        header("location:konto.php");
                        break;
                }
            //akcje od strony konto
            //wyświetl formularz edycji hasła
            } else if (filter_input(INPUT_POST, 'haslo-form')) {
                $this->model->loadUserData($db, $userId);
                $this->view->showViewEdit('haslo');
            //wyświetl formularz edycji danych
            } else if (filter_input(INPUT_POST, 'dane-form')) {
                $this->model->loadUserData($db, $userId);
                $this->view->showViewEdit('dane');
            //usuń konto
            } else if (filter_input(INPUT_POST, 'usun')) {
                $this->model->usunKonto($db, $userId);
                $this->manager->logout($db);
                header("location:login.php");
            //brak akcji - przekieruj na stronę główną
            } else {
                header("location:konto.php");
            }
            
        }
    }
}

