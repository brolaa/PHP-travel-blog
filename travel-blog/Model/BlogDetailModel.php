<?php

//Model strony detailBlog
class BlogDetailModel extends PageModel{
    protected $postData;
    protected $userData;
    protected $loggedUserData;
    
    public function __construct() {
        parent::__construct("Szczegóły postu", "Blog");
    }
    
    public function getPostData() {
        return $this->postData;
    }
    
    public function getUserData() {
        return $this->userData;
    }
    
    public function getLoggedUserData() {
        return $this->loggedUserData;
    }

    public function setPostData($postData) {
        $this->postData = $postData;
    }
    
    public function setUserData($userData) {
        $this->userData = $userData;
    }
    
    public function setLoggedUserData($loggedUserData) {
        $this->loggedUserData = $loggedUserData;
    }

    //załaduj dane postu o określonym id
    function loadPostData($db, $id) {
        $sql = "SELECT * FROM `posts` where id=$id;";
        
        $pola=["id","title","userId", "submissionDate", "description","content","photoName"];
        
        $this->postData=$db->selectData($sql, $pola);
    }
    
    //załaduj dane użytkownika o określonym id
    function loadUserData($db, $id) {
        $sql = "SELECT id, userName, status FROM `users` where id=$id;";
        
        $pola=["id","userName","status"];
        
        $data = $db->selectData($sql, $pola);
        
        if (empty($data)) { 
            $pole = array("id" => -1, "userName" => "użytkownik usunięty",
                               "status" => -1);
            $this->userData = array($pole);
        } else {
            $this->userData = $data;
        }
    }

    //załaduj id i status zalogowanego użytkownika o określonym id
    function loadLoggedUserData($db, $id) {
        $sql = "SELECT id, status FROM `users` where id=$id;";
        
        $pola=["id","status"];
        
        $data = $db->selectData($sql, $pola);
        $this->loggedUserData=$data[0];
    }
}
