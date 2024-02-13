<?php
    require_once "Helpers/autoloader.php";
    
    $model = new BlogModel();
    $view = new BlogView($model);
    $controller = new BlogController($model, $view);
    $controller->runView();
