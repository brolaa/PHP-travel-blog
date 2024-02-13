<?php
//klasa kontroler strony blog
class BlogController extends Controller { 
    public function runView() {
        $db = new Baza("localhost", "root", "", "projekt");
        //załaduj liczbę stron
        $this->model->loadPagesData($db);
        //pobierz liczbę stron
        $count=$this->model->getPageCount();
        
        //sprawdź czy w GET jest numer strony
        if ($page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS)) {
            //liczba pomiędzy pierwszą a ostatnią stroną
            if (($page >= 1) && ($page <= $count)) {
                //ustaw aktualną stronę
                $this->model->setCurrentPage($page);
                //ustaw offset 
                $offset=($page-1)*5;
                $this->model->loadPostsData($db, $offset);
            } else { //liczba niepoprawna lub inny typ
                $this->model->setCurrentPage(1);
                //załaduj posty
                $this->model->loadPostsData($db, 0);
            }     
        } else { //brak parametru w GET
            $this->model->setCurrentPage(1);
            //załaduj posty
            $this->model->loadPostsData($db, 0); 
        }
       
        $this->view->showView();
    }
}
