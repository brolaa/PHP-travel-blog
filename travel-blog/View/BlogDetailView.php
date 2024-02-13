<?php

//Widok szczegółu postu
class BlogDetailView extends MainView {
    public function __construct($model) {
        parent::__construct($model);
    }
    
    //Generuje i wyświetla ciało widoku
    public function showBlogDetailView() {
        $postData=$this->model->getPostData();
        $userData=$this->model->getUserData();
        $postData=$postData[0];
        $userData=$userData[0];
        $loggedUserData=$this->model->getLoggedUserData();
            
        echo    '<div class="container mt-5">'.
                    '<div class="row">'.
                        '<div class="col-lg-8">'.
                            '<article>'.
                                '<header class="mb-4">'.
                                    '<h1 class="fw-bolder mb-1">';
        echo                        $postData['title'];                           
        echo                        '</h1>'.
                                    '<div class="text-muted fst-italic mb-2">Zamieszczono ';
        echo                        $postData['submissionDate'];
        echo                        ' przez ';
        echo                        $userData['userName'];
        echo                        '</div>'.
                                '</header>'.
                                '<figure class="mb-4"><img class="img-fluid rounded" src="./images/';
                                if (file_exists("./images/".$postData['photoName'])) {
                                    echo $postData['photoName'].'" alt="'.$postData['photoName'].'" />';
                                } else {
                                    echo 'placeholder.jpg" alt="placeholder.txt" />';
                                }
        echo                    '</figure>'.
                                '<section class="mb-5">'.
                                    '<p class="fs-5 mb-4">';
        echo                        $postData['description'];   
        echo                        '</p>'.
                                    '<p class="fs-5 mb-4">';
        echo                        $postData['content'];
        echo                        '</p>'.
                                '</section>'.
                            '</article>'.
                        '</div>'.  
                        '<div class="col-lg-4">';
                            if (isset($loggedUserData)) {
                                if ($loggedUserData['id']==$userData['id'] || 
                                    $loggedUserData['status']==2) {
                                    echo '<form method="post" action="dodajPost.php';
                                    echo '">'.
                                            '<input type="hidden" name="post-id" value="';
                                    echo        $postData['id'];
                                    echo    '">'.
                                            '<div class="d-grid gap-2">'.
                                            
                                                '<button type="submit" class="btn btn-dark btn-block" name="submit" value="text-form">Edytuj post</button>'.
                                                '<button type="submit" class="btn btn-dark btn-block" name="submit" value="pic-form">Edytuj zdjęcie</button>'.
                                                '<button type="submit" class="btn btn-danger btn-block" name="submit" value="usun">Usuń post</button>'.
                                            '</div>'.   
                                        '</form>';
                                }
                            }
        echo            '</div>'.
                    '</div>'.
                '</div>';
        
    }

    //pokazuje gotową, całą stronę
    public function showView() {
        $this->showHeader();
        $this->showNavBar();
        $this->showBlogDetailView();
        $this->showFooter();          
    }
}

