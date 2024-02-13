<?php

//klasa post
class Post {    
    protected $title;
    protected $userId;
    protected $submissionDate;
    protected $description;
    protected $content;
    protected $photoName;
    
    function __construct($title, $userId, $description, $content, $photoName){
        $this->title=$title;
        $this->userId=$userId;
        $this->description=$description;
        $this->content=$content;
        $this->photoName=$photoName; 
        $datetime=new DateTime();
        $datetime->format('Y-m-d H:i');
        $this->submissionDate=$datetime;
    }
    
    //pokaż dane
    public function show() {
        $data = $this->submissionDate->format('Y-m-d h:i');
        
        echo $this->title." ".$this->userId." ".$data." ".$this->description
                ." ".$this->content." ".$this->photoName;
    }
    
    //zapisz post do bazy danych
    function saveDB($db) {
        $title=$this->title; 
        $userId=$this->userId;
        $description=$this->description;
        $content=$this->content;
        $photoName= $this->photoName;
        $data = $this->submissionDate->format('Y-m-d h:i');
        
        $sql="INSERT INTO posts VALUES (NULL, '$title', '$userId', '$data', "
                                        ."'$description', '$content', '$photoName')";
        $db->insert($sql);
    }
    
    public function getTitle() {
        return $this->title;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getSubmitionDate() {
        return $this->submissionDate;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getContent() {
        return $this->content;
    }

    public function getPhotoName() {
        return $this->photoName;
    }
    
    public function setTitle($title): void {
        $this->title = $title;
    }

    public function setUserId($userId): void {
        $this->userId = $userId;
    }

    public function setSubmitionDate($submitionDate): void {
        $this->submissionDate = $submitionDate;
    }

    public function setDescription($description): void {
        $this->description = $description;
    }

    public function setContent($content): void {
        $this->content = $content;
    }

    public function setPhotoName($photoName): void {
        $this->photoName = $photoName;
    }
}

