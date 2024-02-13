<?php

//Kontroler strony detailView
class BlogDetailController extends Controller {
    public function runView() {
        $db = new Baza("localhost", "root", "", "projekt");
        
        //sprawdź czy w GET jest parametr
        if ($page = filter_input(INPUT_GET, 'post', FILTER_SANITIZE_SPECIAL_CHARS)) {
            //sprawdź czy parameter jest numerem
            if (!is_numeric($page)) {
                header("location:blog.php"); 
            } else {
                //załaduj dane postu
                $this->model->loadPostData($db, $page);
                //pobierz dane postu
                $data = $this->model->getPostData();
                           
                //sprawdź czy dane nie są puste
                if (empty($data)) { 
                    header("location:blog.php"); 
                }
                
                session_start(); //rozpoczęcie sesji
                $sessionId = session_id(); //pobranie id sesji
        
                //wyszukanie id użytkownika na podstawie id sesji
                $loggedUserId=$this->manager->getLoggedInUser($db, $sessionId); 
                //nie znaleziono użytkownika pasującego do id sesji
                if ($loggedUserId == -1) {
                    //usuń cookie i sesję
                    if ( isset($_COOKIE[session_name()]) ) {
                        setcookie(session_name(),'', time() - 42000, '/');
                    }  
                    session_destroy();
                } else {
                    //pobierz dane zalogowanego użytkownika
                    $this->model->loadLoggedUserData($db, $loggedUserId);
                }              
               
                //załaduj id użytkownika który storzył post
                $userId = $data[0]['userId'];
                
                //załaduj dane użytkownika który storzył post
                $this->model->loadUserData($db, $userId);
            
                //pokaż widok
                $this->view->showView();  
            }
            
        } else { //przekieruj na stronę główną
            header("location:blog.php"); 
        }
    }
}

