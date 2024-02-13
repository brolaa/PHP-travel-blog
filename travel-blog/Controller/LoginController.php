<?php

//Kontroler strony login
class LoginController extends Controller {
    public function runView() {
        $db = new Baza("localhost", "root", "", "projekt");
        
        //sprawdź czy zalogowany jest użytkownik
        if (isset($_COOKIE[session_name()]) ) {
            session_start(); 
            $sessionId = session_id();
            $userId=$this->manager->getLoggedInUser($db, $sessionId); 
            if ($userId > 0) { // użytkownik zalogowany
                header("location:konto.php");
            } else {
                //usuń cookie i sesję
                setcookie(session_name(),'', time() - 42000, '/');
                session_destroy();
            }
         }          
        
        //naciśnięto przycisk logowania
        if (filter_input(INPUT_POST, "zaloguj")) {
            $userId=$this->manager->login($db); //sprawdź parametry logowania
            if ($userId > 0) { // logowanie powidło się
                header("location:konto.php");         
            } else { // logowanie nie powiodło się
                $this->model->setResultMessage('<p class="text-danger text-center">Błędna nazwa użytkownika lub hasło</p>');
                $this->view->showView();
            }
        } else {
            //pierwsze uruchomienie strony login
             $this->view->showView();
        } 
    }
}