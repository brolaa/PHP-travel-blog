<?php

abstract class Controller {
    protected $model;
    protected $view;
    protected $manager;
    
    public function __construct($model, $view) {
        $this->model=$model;
        $this->view=$view;
        $this->manager=new UserManager();
    }
    
    public function getModel() {
        return $this->model;
    }
    
    public function setModel($model) {
        $this->model=$model;
    }
    
    abstract public function runView(); 
}

