<?php
//Widok dodawania i edycji postu
class DodajPostView extends MainView {
    public function __construct($model) {
        parent::__construct($model);
    }
    
    //załaduj licznik znaków
    public function loadCount($val, $maxLen) { 
        if (strlen($val) > $maxLen) {
            echo '<span style="color: red;">'.strlen($val)."/$maxLen</span>";
        } else {
            echo strlen($val)."/$maxLen";
        }
    }
    
    //generuje i wyświetla nagłówek karty
    public function cardHeader($name) {
        echo    '<div class="container">'.               
                    '<div class="row">'.    
                        '<div class="col-md-10 col-lg-9 mx-auto">';          
                            if ($this->model->getResultMessage() != "") { echo $this->model->getResultMessage(); }             
        echo                '<div class="card my-5">'.
                            '<div class="card-header text-center">';
        echo                    $name;
        echo                '</div>'.
                            '<div class="card-body">'.
                                '<form action="dodajPost.php" enctype="multipart/form-data" method="post">';
    }
    
    //generuje i wyświetla stopkę karty
    public function cardFooter() {
        echo                    '</form>'.
                            '</div>'.
                            '</div>'.
                        '</div>'.
                    '</div>'.
                '</div>';     
    }
    
    //widok dla użytkowników niezalogowanych
    public function showInfo() {   
        echo    '<div class="container">'.
                    '<div class="row">'.
                        '<div class="col-sm-9 col-md-7 col-lg-5 mx-auto">'.
                            '<div class="card my-5">'.
                                '<div class="card-header text-center">Informacja</div>'.
                                '<div class="card-body text-center">'.
                                    'Aby dodać post, wymagane jest zalogowanie.<br><br>'.
                                    '<form action="dodajPost.php" method="post">'.
                                    '<div class="d-grid gap-2">'.
                                        '<button type="submit" class="btn btn-dark btn-block" name="zaloguj" value="zaloguj">'.
                                            'Logowanie'.
                                        '</button>'.
                                    '</div>'.
                                    '</form>'.
                                '</div>'.
                            '</div>'.
                        '</div>'.
                    '</div>'.
                '</div>';
    }
    
    //pola formularza dla danych tekstowych postu
    public function formConstructor($errors, $dane) {    
        echo    '<div class="form-group mb-3">'.
                    '<label for="title">Tytuł</label>'.
                    '<div id="title-opis" class="form-text">'.
                        'Maksymalnie 50 znaków'.
                    '</div>'.
                    '<input type="text" class="form-control '; 
                    if (in_array("title", $errors)) echo 'is-invalid';
        echo        '" id="title" name="title" onkeyup="countChars(this, 50,\'title-char\');" value="';
                    if (isset($dane['title'])) { echo $dane['title'];}
        echo        '">'.
                    '<div class="text-end" id="title-char">';
                    if (isset($dane['title'])) { $this->loadCount($dane['title'], 50); } else { echo '0/50';}
        echo        '</div>'.
                '</div>'.
                '<div class="form-group mb-3">'.
                    '<label for="decription">Opis</label>'.
                    '<div id="description-opis" class="form-text">'.
                        'Maksymalnie 250 znaków'.
                    '</div>'.
                    '<textarea class="form-control ';
                    if (in_array("description", $errors)) echo 'is-invalid';
        echo        '" id="description" rows="5" name="description" onkeyup="countChars(this, 250,\'opis-char\');">';
                    if (isset($dane['description'])) { echo $dane['description'];}
        echo        '</textarea>'.
                    '<div class="text-end" id="opis-char">';
                    if (isset($dane['description'])) { $this->loadCount($dane['description'], 250); } else { echo '0/250';}
        echo        '</div>'.
                '</div>'.
                '<div class="form-group mb-3">'.
                    '<label for="content">Zawartość</label>'.
                    '<div id="content-opis" class="form-text ">'.
                        'Maksymalnie 1000 znaków'.
                    '</div>'.
                    '<textarea class="form-control ';
                    if (in_array("content", $errors)) echo 'is-invalid';
        echo        '" id="content" rows="20" name="content" onkeyup="countChars(this, 1000,\'content-char\');">';
                    if (isset($dane['content'])) { echo $dane['content'];}
        echo        '</textarea>'.
                    '<div class="text-end" id="content-char">';
                    if (isset($dane['content'])) { $this->loadCount($dane['content'], 1000); } else { echo '0/1000';}
        echo        '</div>'.
                '</div>';
                
    }
    
    //pole formularza dla dodawania zdjęć
    public function photoFormConstructor($errors) {
        echo    '<div class="form-group mb-3">'.
                    '<label class="form-label" for="picture">Dodaj zdjęcie</label>'.
                    '<div id="picture-opis" class="form-text">'.
                        'Zdjęcie w formacie .jpg, .jpeg lub .png, maksymalny rozmiar 25 MB, preferowana orientacja pozioma, format 4:3'.
                    '</div>'.
                    '<input type="file" class="form-control ';
                    if (in_array("picture", $errors)) { echo 'is-invalid'; }
        echo        '" id="picture" name="picture"/>';
                    if (in_array("type", $errors)) { echo '<div class="invalid-feedback">Nieprawidłowy format pliku</div>'; }
                    if (in_array("size", $errors)) { echo '<div class="invalid-feedback">Rozmiar zdjęcia za duży</div>'; }                 
        echo    '</div>';
    }
    
    //załaduj błędy walidacji z modelu
    public function loadErrors() {
        if ($this->model->getErrors()=="") { // Brak błędów - utwórz pustą tablicę
            $errors=[];
        } else { // Błędy pól formularza - zamień łańcuch błędów na tablicę
            $errors = explode(" ", $this->model->getErrors());
        }
        return $errors;
    }
    
    //pokaż ciało widoku dodawania
    public function showDodajPostView() { 
        $errors= $this->loadErrors();
        
        // Pobierz wartości wypełnionych pól z modelu
        $dane = $this->model->getDane();
        
        $this->cardHeader("Nowy post");
        $this->formConstructor($errors, $dane);
        $this->photoFormConstructor($errors);
        echo    '<hr>'.
                '<div class="d-grid gap-2">'.
                    '<button class="btn btn-primary btn-block" type="submit" name="submit" value="dodaj">Dodaj Post</button>'.
                '</div>';
        $this->cardFooter();
      
    }
    
    //pokaż ciało widoku edytowania danych postu;
    //typ: "picture" - widok formularza edycji zdjęcia postu
    //typ: "text" (lub dowlony) -  widok formularza edycji danych tekstowych postu
    public function showEdytujPostView($typ) {
        $errors= $this->loadErrors();
        
        // Pobierz wartości wypełnionych pól z modelu
        $dane = $this->model->getDane();
        
        
        if ($typ=="picture") {
            $this->cardHeader("Edytuj zdjęcie");
            $this->photoFormConstructor($errors);
            echo    '<hr>'.
                '<div class="d-grid gap-2">'.
                    '<button class="btn btn-primary btn-block" type="submit" name="submit" value="edytuj-pic">Edytuj zdjęcie</button>';
        } else {
            $this->cardHeader("Edytuj post");
            $this->formConstructor($errors, $dane);
            echo    '<hr>'.
                '<div class="d-grid gap-2">'.
                    '<button class="btn btn-primary btn-block" type="submit" name="submit" value="edytuj-text">Edytuj post</button>';
        }
        echo    '<input type="hidden" name="post-id" value="';
        echo        $dane['id'];
        echo    '">';
        echo    '<button class="btn btn-danger btn-block" type="submit" name="submit" value="anuluj">Anuluj</button>'.
              '</div>';
        
        
        $this->cardFooter();
    }
    
    //pokaż gotowy widok całości strony dla dodawania postu
    public function showViewForm() {
        $this->showHeader();
        $this->showNavBar();
        $this->showDodajPostView();
        $this->showFooter();          
    }
    
     //pokaż gotowy widok całości strony dla niezalogowanych
    public function showViewInfo() {
        $this->showHeader();
        $this->showNavBar();
        $this->showInfo();
        $this->showFooter();    
    }
    
     //pokaż gotowy widok całości strony dla edycji postu
    public function showViewEdit($typ) {
        $this->showHeader();
        $this->showNavBar();
        $this->showEdytujPostView($typ);
        $this->showFooter();    
    }
}

