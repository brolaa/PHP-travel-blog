<?php

//Kontroler strony konto
class KontoController extends Controller {
    public function runView() {
        $db = new Baza("localhost", "root", "", "projekt");
        
        //wylogowanie z pomocą przycisku wylouj
        if (filter_input(INPUT_POST, "wyloguj")) {
            $this->manager->logout($db);
            header("location:login.php"); 
        }
        
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
            
            //przekieruj do formularza logowania
            header("location:login.php"); 
           
        } else {
            $this->model->loadUserData($db, $userId);
            $this->view->showView();
        }
    }
}

