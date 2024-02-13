<?php
    require_once "Helpers/autoloader.php";
    
    $model = new KontoModel();
    $view = new KontoView($model);
    $controller = new KontoController($model, $view);
    $controller->runView();
