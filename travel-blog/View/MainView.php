<?php

// Widok matka zawierający model, header, pasek nawigacji oraz footer.
class MainView {
    protected $model;
    
    public function __construct($model) {
        $this->model=$model;
    }
    
    public function getModel() {
        return $this->model;
    }
    
    public function setModel($model) {
        $this->model=$model;
    }
    
    //generuje i pokazuje nagłówek HTML
    public function showHeader() {
        echo '<html lang="pl">'.
                '<head>'.
                    '<meta charset="utf-8" />'.
                    '<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />'.
                    '<title>';
                        echo $this->model->getTitle();
        echo        '</title>'.
                '<link rel="icon" type="image/x-icon" href="Assets/favicon.ico" />'.
                '<link href="css/styles.css" rel="stylesheet" />'.
                '<script src="Scripts/scripts.js"></script>'.
            '</head>'.
            '<body class="d-flex flex-column min-vh-100">';
    }
    
    //generuje i pokazuje pasek nawigacji
    public function showNavBar() {
        echo    '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">'.
                '<div class="container">'.
                    '<a class="navbar-brand" href="blog.php">Travel Blog</a>'.
                    '<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>'.
                    '<div class="collapse navbar-collapse" id="navbarSupportedContent">'.
                        '<ul class="navbar-nav ms-auto mb-2 mb-lg-0">';
                                switch ($this->model->getNavName()) {
                                    case "Blog":
                                        $output=
                                            '<li class="nav-item"><a class="nav-link active" aria-current="page" href="blog.php">Blog</a></li>'.
                                            '<li class="nav-item"><a class="nav-link" href="dodajPost.php">Dodaj Post</a></li>'.
                                            '<li class="nav-item"><a class="nav-link" href="konto.php">Konto</a></li>';
                                        break;
                                    case "Dodaj Post":
                                        $output=
                                            '<li class="nav-item"><a class="nav-link" href="blog.php">Blog</a></li>'.
                                            '<li class="nav-item"><a class="nav-link active" aria-current="page" href="dodajPost.php">Dodaj Post</a></li>'.
                                            '<li class="nav-item"><a class="nav-link" href="konto.php">Konto</a></li>';
                                        break;
                                    case "Konto":
                                        $output=
                                            '<li class="nav-item"><a class="nav-link" href="blog.php">Blog</a></li>'.
                                            '<li class="nav-item"><a class="nav-link" href="dodajPost.php">Dodaj Post</a></li>'.
                                            '<li class="nav-item"><a class="nav-link active" aria-current="page" href="konto.php">Konto</a></li>';
                                    break; 
                                }
                                echo $output;
                                             
        echo            '</ul>'.
                    '</div>'.
                '</div>'.
            '</nav>';


    }
    
    //generuje i pokazuje stopkę
    public function showFooter() { 
        echo            '<footer class="py-5 mt-auto bg-dark">'.
                            '<div class="container"><p class="m-0 text-center text-white">Copyright &copy; Bartosz Rola 2023</p></div>'.
                        '</footer>'.
                    '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>'.
                '</body>'.
            '</html>';
    }
}
