<?php

//Widok dla formularza logowania 
class LoginView extends MainView {
    public function __construct($model) {
        parent::__construct($model);
    }
    
    //pokaż pola formularza dla logowania
    public function formConstructor() {
        echo    '<div class="form-group mb-3">'.
                    '<label for="login" class="form-label">Login</label>'.
                    '<input type="text" class="form-control" id="login" name="login">'.
                '</div>'.
                '<div class="form-group mb-4">'.
                    '<label for="password" class="form-label">Hasło</label>'.
                    '<input type="password" class="form-control" id="password" name="password">'.
                '</div>';
    }
    
    //pokaż ciało formularza logowania
    public function showLoginView() { 
        echo    '<div class="container d-flex flex-column min-vh-100">'.
                    '<div class="row">'.
                        '<div class="col-sm-9 col-md-7 col-lg-5 mx-auto">'.
                            '<div class="card my-5">'.
                                '<div class="card-header text-center">Logowanie</div>'.
                                '<div class="card-body">'.
                                    '<form action="login.php" method="post">';
                                        $this->formConstructor();
        echo                            '<hr>';
                                        echo $this->model->getResultMessage();
        echo                            '<div class="d-grid gap-2">'.
                                            '<button class="btn btn-primary btn-block" type="submit" name="zaloguj" value="zaloguj">Logowanie</button>'.
                                            '<p style="text-align:center">Nie masz konta? <a href="registration.php">Zarejestruj się</a></p>'.
                                        '</div>'.
                                    '</form>'.
                                '</div>'.
                                '</div>'.
                            '</div>'.
                        '</div>'.      
                    '</div>';
    }
    
    //pokaz całość strony widoku
    public function showView() {
        $this->showHeader();
        $this->showNavBar();
        $this->showLoginView();
        $this->showFooter();          
    }
}


            
               
                    
                        
                            
                            
                           
            