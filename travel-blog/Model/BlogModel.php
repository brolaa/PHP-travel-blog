<?php

//Model strony blog
class BlogModel extends PageModel {    
    protected $postData;
    protected $postCount;
    protected $pageCount;
    protected $currentPage;

    public function __construct() {
        parent::__construct("Blog", "Blog");
    }
    
    public function getPostData() {
        return $this->postData;
    }
    
    public function getPostCount() {
        return $this->postCount;
    }
    
    public function getPageCount() {
        return $this->pageCount;
    }

    public function getCurrentPage() {
        return $this->currentPage;
    }
    
    public function setPostData($postData): void {
        $this->postData = $postData;
    }
    
    public function setPostCount($postCount): void {
        $this->postCount = $postCount;
    }

    public function setPageCount($pageCount): void {
        $this->pageCount = $pageCount;
    }

    public function setCurrentPage($currentPage): void {
        $this->currentPage = $currentPage;
    } 
    
    //załaduj dane pięciu postów w posortowane od najnowszych do najstarszych
    //począwszy od przesunięcia określonego parametrem $offset
    function loadPostsData($db, $offset) {
        $sql = "SELECT * FROM `posts` ORDER BY submissionDate DESC LIMIT 5 OFFSET $offset;";
        
        $pola=["id","title","userId", "submissionDate", "description","photoName"];
        
        $this->postData=$db->selectData($sql, $pola);
       
    }
    
    //załaduj liczbę stron na podstawie ilości wierszy w bazie danych (5 postów na stronę)
    function loadPagesData($db) {
        $this->postCount=$db->countRows('posts');
        
        $pageNum = intval($this->postCount/5);
        if ($this->postCount%5 != 0 || $this->postCount==0) {
            $pageNum+=1;
        }
        
        $this->pageCount=$pageNum;
    }
}
