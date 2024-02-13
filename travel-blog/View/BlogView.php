<?php

//Widok strony głównej
class BlogView extends MainView {
    public function __construct($model) {
        parent::__construct($model);
    }
    
    //wyświetla baner na stronie głównej
    public function showBlogHeader() {
        echo    '<header class="py-5 bg-light border-bottom mb-4">'.
                    '<div class="container">'.
                        '<div class="text-center my-5">'.
                            '<h1 class="fw-bolder">Witaj na blogu podróżniczym!</h1>'.
                            '<p class="lead mb-0">Podziel się historią o twojej podróży.</p>'.
                        '</div>'.
                    '</div>'.
                '</header>';
    }
    
    //generuje i wyświetla posty
    public function generatePost() {
        $postData=$this->model->getPostData();
        
        if (empty($postData)) {
            echo '<h2 class="text-center my-5">Brak postów</h2>';
        } else {
            foreach ($postData as $post) {
                echo    '<div class="card mb-4">'.
                            '<img class="card-img-top" src="./images/';
                            if (file_exists("./images/".$post['photoName'])) {
                                echo $post['photoName'].'" alt="'.$post['photoName'].'" /></a>';
                            } else {
                                echo 'placeholder.jpg" alt="placeholder.txt" />';
                            }
                echo        '<div class="card-body">'.
                                '<div class="small text-muted">';
                echo                $post['submissionDate'];
                echo            '</div>'.
                                '<h2 class="card-title">';
                echo                $post['title'];
                echo            '</h2>'.
                                '<p class="card-text">';
                echo                $post['description'];
                echo            '</p>'.
                                '<a class="btn btn-primary" href="blogDetail.php?post=';
                echo                $post['id'];
                echo            '">Zobacz post</a>'.
                            '</div>'.
                        '</div>';
            }
        }
    }
    
    //generuje i wyświetla paginację na podstawie liczby stron i numeru aktualnej strony
    public function generatePagination() {
        $pageCount = $this->model->getPageCount();
        $currentPage = $this->model->getCurrentPage();
        
        echo    '<nav aria-label="Pagination">'.
                    '<hr class="my-0" />'.
                    '<ul class="pagination justify-content-center my-4">'.
                        '<li class="page-item ';
                        //przycisk poprzedniej strony
                        if ($currentPage<=1) { echo 'disabled'; }
        echo            '"><a class="page-link" href="blog.php?page=';
                        echo $currentPage-1;
        echo            '" tabindex="-1" aria-disabled="true">Nowsze</a></li>';
                
                        //pierwsza strona - zawsze widoczna
                        echo '<li class="page-item ';
                        if (1 == $currentPage) { echo  'active" aria-current="page'; }
                        echo '"><a class="page-link" href="blog.php?page=1">1</a></li>';
                        
                        if ($currentPage-1>2) {
                            echo '<li class="page-item disabled"><a class="page-link" href="#!">...</a></li>';
                                 
                        }
                        
                        if ($currentPage-1>1) {
                            echo '<li class="page-item"><a class="page-link" href="blog.php?page=';
                            echo ($currentPage-1).'">'.($currentPage-1).'</a></li>';      
                        }
                      
                        if ($currentPage != 1 && $currentPage != $pageCount) {
                            echo '<li class="page-item active" aria-current="page"><a class="page-link" href="blog.php?page=';
                            echo $currentPage.'">'.$currentPage.'</a></li>';
                        }
                         
                        if ($pageCount-$currentPage>1) {
                            echo '<li class="page-item"><a class="page-link" href="blog.php?page=';
                            echo ($currentPage+1).'">'.($currentPage+1).'</a></li>';
                        }
                        
                        if ($pageCount-$currentPage>2) {
                            echo '<li class="page-item disabled"><a class="page-link" href="#!">...</a></li>';
                        }
                    
                        //ostatnia strona - zawsze widoczna
                        if ($pageCount>1) {
                            echo '<li class="page-item ';
                            if ($pageCount == $currentPage) { echo  'active" aria-current="page'; }
                            echo '"><a class="page-link" href="blog.php?page=';
                            echo $pageCount.'">'.$pageCount.'</a></li>';
                        }
                        
                        //przyscisk następnej strony
        echo            '<li class="page-item ';
                        if ($currentPage>=$pageCount) { echo 'disabled'; }
        echo            '"><a class="page-link" href="blog.php?page=';
                        echo $currentPage+1;
        echo            '">Starsze</a></li>'.
                    '</ul>'.
                '</nav>';
    }
    
    //generuje i wyświetla widok ciała strony
    public function showBlogView() {
        $this->showBlogHeader();
        
        echo    '<div class="container">'.      
                    '<div class="row">'.
                        '<div class="col-lg-8">';
                            $this->generatePost();
                            $this->generatePagination();
        echo            '</div>'.    
                        '<div class="col-lg-4">';
        echo            '</div>'.
                    '</div>'.
                '</div>';
    }

    //pokazuje gotową, całą stronę
    public function showView() {
        $this->showHeader();
        $this->showNavBar();
        $this->showBlogView();
        $this->showFooter();          
    }
}
