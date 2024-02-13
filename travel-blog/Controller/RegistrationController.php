<?php

class RegistrationController extends Controller {
    public function runView() {
        $db = new Baza("localhost", "root", "", "projekt");
        
        //Naciśnięto submit
        if (filter_input(INPUT_POST, 'submit', FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
            [$user, $errors, $dane] = $this->model->checkUser($db); //sprawdza poprawność danych
            if ($user === NULL) {
                $this->model->setResultMessage('<p class="text-danger text-center">Niepoprawne dane rejestracji.</p>');
                $this->model->setErrors($errors);
                // Zaktualizuj wartości pól
                $this->model->setDane($dane);
                $this->view->showView();
            } else {
                $this->model->setResultMessage('<p class="text-success text-center">Zarejestrowano pomyślnie!</p>');
                // Wyczyść wartości pól
                $this->model->setDane("");
                $this->view->showView();
            }         
        } else {
            //Stan początkowy
            $this->view->showView();
        }
    }
}
