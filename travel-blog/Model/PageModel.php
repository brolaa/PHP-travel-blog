<?php

//Klasa matka klas modeli stron
class PageModel {
    protected $title;
    protected $navName;
    
    public function __construct($title, $navName) {
        $this->title=$title;
        $this->navName=$navName;
    }
    
    public function getTitle() {
        return $this->title;
    }

    public function getNavName() {
        return $this->navName;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setNavName($navName) {
        $this->navName = $navName;
    }


}

