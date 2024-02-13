<?php
    require_once "Helpers/autoloader.php";

    $model = new BlogDetailModel();
    $view = new BlogDetailView($model);
    $controller = new BlogDetailController($model, $view);
    $controller->runView();