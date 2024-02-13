<?php  
    require_once "Helpers/autoloader.php";
    
    $model = new DodajPostModel();
    $view = new DodajPostView($model);
    $controller = new DodajPostController($model, $view);
    $controller->runView();
