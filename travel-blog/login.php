<?php
    require_once "Helpers/autoloader.php";
    
    $model = new LoginModel();
    $view = new LoginView($model);
    $controller = new LoginController($model, $view);
    $controller->runView();