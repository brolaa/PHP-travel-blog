<?php

//Kontroler strony dodajPost
class DodajPostController extends Controller {
    //sprawdź czy zalogowany użytkownik stworzył post
    public function checkOwner($userId, $status) {
        if (!$this->model->checkPostOwner($userId) && $status!=2) {
            header("location:blog.php"); 
        }
    }
    
    public function runView() {
        $db = new Baza("localhost", "root", "", "projekt");
        
        session_start();
        $sessionId = session_id();
        
        //wyszukanie id użytkownika na podstawie id sesji
        $userId=$this->manager->getLoggedInUser($db, $sessionId); 
        //nie znaleziono użytkownika pasującego do id sesji
        if (filter_input(INPUT_POST, 'zaloguj')) {
            header("location:login.php");
        } else if ($userId == -1) {
            if ( isset($_COOKIE[session_name()]) ) {
                setcookie(session_name(),'', time() - 42000, '/');
            }                
            session_destroy();
            //pokaż widok dla niezalogowanych
            $this->view->showViewInfo();
        } else {
            // Użytkownik zalogowany
            // Załadowanie statusu
            $status=$this->model->loadUserStatus($db, $userId);
 
            //naciśnięto przycisk 
            if (filter_input(INPUT_POST, 'submit')) {
                //załaduj akcję przycisku
                $akcja = filter_input(INPUT_POST, "submit");
                //załąduj id postu
                $post = filter_input(INPUT_POST, 'post-id');
                
                switch ($akcja) {
                    //dodaj post
                    case "dodaj": 
                        $this->model->checkPost($db, $userId);
                        $this->view->showViewForm();
                        break;
                    //zatwierdź edycję zdjęcia
                    case "edytuj-pic": 
                        if (isset($post) && is_numeric($post)) {
                            if (!$this->model->checkPostOwner($db, $userId, $post) && $status!=2) {
                                header("location:blog.php"); 
                                return;
                            }
                            $wynik = $this->model->checkEditPicture($db, $post);
                            if ($wynik===true) {
                                header("location:blogDetail.php?post=$post"); 
                            }
                            $this->view->showViewEdit("picture");
                        } else {
                            header("location:blog.php");
                        }
                        break;
                    //zawtiwerdź edycję danych postu
                    case "edytuj-text":
                        if (isset($post) && is_numeric($post)) {
                            if (!$this->model->checkPostOwner($db, $userId, $post) && $status!=2) {
                                header("location:blog.php"); 
                                return;
                            }    
                            $wynik = $this->model->checkEditPost($db, $post);
                            if ($wynik===true) {
                                header("location:blogDetail.php?post=$post"); 
                            }
                             $this->view->showViewEdit("text");
                        } else {
                            header("location:blog.php");
                        }
                        break;
                    //wyświetl formularz edycji zdjęcia
                    case "pic-form":
                        if (isset($post) && is_numeric($post)) {
                            if (!$this->model->checkPostOwner($db, $userId, $post) && $status!=2) {
                                header("location:blog.php"); 
                                return;
                            }
                            $this->model->loadData($db, $post);
                            $this->model->setTitle("Edytuj zdjęcie");
                            $this->view->showViewEdit("picture");
                        } else {
                            header("location:blog.php");
                        }
                        break;
                    //wyświetl formularz edycji danych postu
                    case "text-form":
                        if (isset($post) && is_numeric($post)) {
                            if (!$this->model->checkPostOwner($db, $userId, $post) && $status!=2) {
                                header("location:blog.php"); 
                                return;
                            }
                            $this->model->loadData($db, $post);
                            $this->model->setTitle("Edytuj post");
                            $this->view->showViewEdit("text");
                        } else {
                            header("location:blog.php");
                        }
                        break;
                    //usuń post
                    case "usun": 
                        if (isset($post) && is_numeric($post)) {
                            if (!$this->model->checkPostOwner($db, $userId, $post) && $status!=2) {
                                header("location:blog.php"); 
                                return;
                            }
                            $this->model->removePost($db, $post);
                            header("location:blog.php");
                        } else {
                            header("location:blog.php");
                        }
                        break;
                    //anuluj akcję
                    case "anuluj":
                        if (isset($post) && is_numeric($post)) {
                            header("location:blogDetail.php?post=$post");
                        } else {
                            header("location:blog.php");
                        } 
                        break;  
                }
                
            } else {
                //Początkowy stan
                //Wyświetl formularz dodawania postu
                $this->view->showViewForm();
            }
            
        }
    }
}

