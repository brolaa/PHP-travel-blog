<?php

//Model strony dodajPost
class DodajPostModel extends PageModel {
    protected $post;
    protected $errors;
    protected $dane;
    protected $resultMessage;
    protected $postId;

    public function __construct() {
        parent::__construct("Dodaj Post", "Dodaj Post");
    }
    
    function getErrors() {
        return $this->errors;
    }
    
    function getDane() {
        return $this->dane;
    }
    
    function getResultMessage() {
        return $this->resultMessage;
    }
    
    
    function setPostId($id) {
        $this->postId=$id;
    }
    
    function setErrors($error) {
        $this->errors=$error;
    }
    
    function setDane($dane) {
        $this->dane = $dane;
    }

    function setResultMessage($resultMessage) {
        $this->resultMessage = $resultMessage;
    }
    
    // Walidacja danych nowego postu
    // Jeżeli walidacja przejdzie pomyślnie dodanie nowego postu
    function checkPost($db, $userId) {
        //przefiltruj dane tekstowe
        $dane = $this->filterText();
        $errors = "";
        
        $this->dane=$dane;

        $errors = $this->checkTextLength($errors, $dane);
        $errors = $this->checkPhoto($errors);
              
        if ($errors === "") { // Brak błędów
            $this->errors = "";
            $this->dane = "";

            $photoName = $this->savePhoto();

            $this->post=new Post($dane['title'], $userId,
                                 $dane['description'],$dane['content'], 
                                 $photoName);
            $this->post->saveDB($db);
            $this->resultMessage = '<div class="text-success text-center mt-5">Pomyślnie dodano nowy post!</div>';
        } else {
            $this->errors = $errors;
            $this->resultMessage = '<div class="text-danger text-center mt-5">Niepoprawne dane postu</div>';
            $this->post = NULL;
        }
        
        return $this->post;
    }
    
    // Walidacja danych edytowanego postu
    // Jeżeli walidacja przejdzie pomyślnie zaktualizowanie danych postu
    function checkEditPost($db, $postId) {
        //przefiltruj dane tekstowe
        $dane = $this->filterText();
        
        //zaktualizuj dane
        $errors = "";
        $this->dane=$dane;
        $this->dane['id'] = $postId;
        
        $errors = $this->checkTextLength($errors, $dane);
        
        // Sprawdz czy są błędy walidacji $errors 
        if ($errors === "") {
            $this->errors = "";

            $title = $dane['title'];
            $description = $dane['description'];
            $content = $dane['content'];
            
            $sql="UPDATE posts SET title='$title', description='$description', 
                  content='$content' WHERE id=$postId";
            $db->update($sql);
            $this->resultMessage = '<div class="text-success text-center mt-5">Pomyślnie dokonano edycji postu!</div>';
            return true;
        } else {
            $this->errors = $errors;
            $this->resultMessage = '<div class="text-danger text-center mt-5">Niepoprawne dane postu</div>';
            return false;
        }
        
    }
    
    // Walidacja danych edytowanego zdjęcia
    // Jeżeli walidacja przejdzie pomyślnie zaktualizowanie zdjęcia
    function checkEditPicture($db, $postId) {
        $errors = "";
        $this->dane['id'] = $postId;

        //walidacja zdjęcia
        $errors = $this->checkPhoto($errors);
        
        if ($errors === "") { // Brak błędów
            $this->errors = "";
            //usuń stare zdjęcie
            $this->removePhoto($db, $postId);
            //zapisz nowe zdjęcie
            $photoName = $this->savePhoto();
            //zaktualizuj wpis w bazie danych
            $sql="UPDATE posts SET photoName='$photoName' WHERE id=$postId";
            $db->update($sql);
            $this->resultMessage = '<div class="text-success text-center mt-5">Pomyślnie dokonano edycji postu!</div>';
            return true;
        } else {
            $this->errors = $errors;
            $this->resultMessage = '<div class="text-danger text-center mt-5">Niepoprawne dane zdjęcia</div>';
            return false;
        }
    }
    
    //Sprawdź czy post należy do aktualnie zalogowanego użytkownika
    function checkPostOwner($db, $userId, $postId) {
        $sql = "SELECT userId from posts WHERE id=$postId";
        $pola = ['userId'];
        $query = $db->selectData($sql, $pola);
        $postUserId = $query[0]['userId'];
        
        return $postUserId===$userId;
        
    }

    //Załaduj status użytkownika
    function loadUserStatus($db, $userId) {
        $sql = "SELECT status from users WHERE id=$userId";
        $pola = ['status'];
        $query = $db->selectData($sql, $pola);
        $status = $query[0]['status'];
        return $status;
    }

    //przefiltruj dane tekstowe postu
    function filterText() {
        $args = [
            'title' => ['filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS],
            'description' => ['filter' => FILTER_SANITIZE_SPECIAL_CHARS],
            'content' => ['filter' => FILTER_SANITIZE_SPECIAL_CHARS]
        ];
        
        $dane = filter_input_array(INPUT_POST, $args);
        
        return $dane;
    }
    
    //załaduj dane postu na podstawie id
    function loadData($db, $postId) {
        $sql = "SELECT id, userId, title, description, content FROM `posts` where id=$postId;";
        
        $pola=["id", "title","userId","description","content"];
        
        $query=$db->selectData($sql, $pola);
        $this->dane=$query[0];
    }

    //sprawdź długość danych postu
    function checkTextLength($errors, $dane) {
        if (strlen($dane['title'])>50 or $dane['title']=="") {
            $errors .= 'title'. ' ';
        }
        if (strlen($dane['description'])>250 or $dane['description']=="") {
            $errors .= 'description'. ' ';
        }
        if (strlen($dane['content'])>1000 or $dane['content']=="") {
            $errors .= 'content'. ' ';
        }
        return $errors;
    }

    //walidacja zdjęcia
    function checkPhoto($errors) {
        $allowed_extensions = array("jpg","jpeg","png");
        $name=$_FILES["picture"]["name"];
        $temp=explode(".", $name);
        $extension = end($temp);
        
        //sprawdź czy zdjęcie zostało załadowane
        if (is_uploaded_file($_FILES['picture']['tmp_name'])) {
            $type = $_FILES['picture']['type'];
            //sprawdź typ pliku
            if (($type=='image/jpg' ||
                $type=='image/jpeg' || 
                $type=='image/png') && in_array($extension, $allowed_extensions)) {
                //sprawdź rozmiar pliku
                if ($_FILES["picture"]["size"] > 25000000) {
                    $errors .= 'picture'. ' ';
                    $errors .= 'size'. ' ';
                }
            }
            else {
                $errors .= 'picture'. ' ';
                $errors .= 'type'. ' ';
            }
        }
        else {
            $errors .= 'picture'. ' ';
        }
        return $errors;
    }
     
    //zapisz zdjęcie na serwerze
    function savePhoto() {
        $katalog="./images/";
        $katalog_s="./images_src/";

        $type = $_FILES['picture']['type'];
        $name=$_FILES["picture"]["name"];
        if ($type=='image/png') {
            $extension='png';
        } else {
            $extension='jpeg';
        }
        
        #orginał
        $random = uniqid('img_'); //wygenerowanie losowej wartości             
        $pic = $random .'.'. $extension;
        $pic_src = 'src_'. $random .'.'. $extension;
        $pic_tmp = 'tmp_'. $random .'.'. $extension;
                    
        move_uploaded_file($_FILES['picture']['tmp_name'],$katalog_s. $pic_src); //m
                                 
        copy( $katalog_s.$pic_src, './' . $pic_tmp); //utworzenie kopii zdjęcia
                   
        list($width, $height) = getimagesize($pic_tmp);
                    
        $wys=756;
        $szer=1008;
                    
        
        $nowe = imagecreatetruecolor($szer, $wys); //czarny obraz 
        if ($type=='image/png') {
            $obraz = imagecreatefrompng($pic_tmp);
            imagecopyresampled($nowe, $obraz, 0, 0, 0, 0,
                               $szer, $wys, $width, $height); 
            imagepng($nowe, $katalog . $pic, -1);
        } else {
            $obraz = imagecreatefromjpeg($pic_tmp); 
            imagecopyresampled($nowe, $obraz, 0, 0, 0, 0,
                               $szer, $wys, $width, $height); 
            imagejpeg($nowe, $katalog . $pic, 100);
        }
                     
        imagedestroy($nowe);
        imagedestroy($obraz);
        unlink($pic_tmp);
        
        return $pic;
    }
    
    //usuń zdjęcie z serwera
    function removePhoto($db, $postId) {
        $sql="SELECT photoName FROM posts WHERE id='$postId'";
        $pola=['photoName'];
        $query=$db->selectData($sql, $pola);
        $photoName=$query[0]["photoName"];
        
        if (file_exists("./images/$photoName")) {
            unlink("./images/$photoName");
        }
        if (file_exists("./images_src/src_$photoName")) {
            unlink("./images_src/src_$photoName");
        }
        
    }
    
    //usuń post o podanym id z bazy danych
    function removePost($db, $postId) {
        $sql="DELETE FROM posts WHERE id='$postId'";
        $this->removePhoto($db, $postId);
        $db->delete($sql); 
    }
}

