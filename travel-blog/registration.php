<?php
    require_once "Helpers/autoloader.php";
    
    $model = new RegistrationModel();
    $view = new RegistrationView($model);
    $controller = new RegistrationController($model, $view);
    $controller->runView();