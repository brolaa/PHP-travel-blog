<?php
    require_once "Helpers/autoloader.php";
    
    $model = new EditKontoModel();
    $view = new EditKontoView($model);
    $controller = new EditKontoController($model, $view);
    $controller->runView();
