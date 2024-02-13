<?php

//klasa wspomagająca sesję użytkownika
class UserManager {    
    //zaloguj użytkownika
    function login($db) {
        //funkcja sprawdza poprawność logowania
        //wynik - id użytkownika zalogowanego lub -1
        $args = [
            'login' => FILTER_SANITIZE_ADD_SLASHES,
            'password' => FILTER_SANITIZE_ADD_SLASHES
            ];
        //przefiltruj dane z GET (lub z POST) zgodnie z ustawionymi w $args filtrami:
        $dane = filter_input_array(INPUT_POST, $args);
        //sprawdź czy użytkownik o loginie istnieje w tabeli users
        //i czy podane hasło jest poprawne
        $login = $dane["login"];
        $password = $dane["password"];
        $userId = $db->selectUser($login, $password, "users");
        if ($userId >= 0) {
            //rozpocznij sesję zalogowanego użytkownika
            session_start();
            //usuń wszystkie wpisy historyczne dla użytkownika o $userId
            $sql_d="DELETE FROM `logged_in_users` WHERE userId='$userId'";
            $db->delete($sql_d);
            //ustaw datę - format("Y-m-d H:i:s");
            $datetime=new DateTime();
            $data=$datetime->format("Y-m-d H:i:s");
            //pobierz id sesji i dodaj wpis do tabeli logged_in_users
            $id= session_id();
            $sql_i="INSERT INTO logged_in_users VALUES ('$id', '$userId', '$data')";
            $db->insert($sql_i);
        }
        return $userId;
    }
    
    //wyloguj użytkownika
    function logout($db) {
        //pobierz id bieżącej sesji (pamiętaj o session_start()
        session_start();
        $id= session_id();
        //usuń sesję (łącznie z ciasteczkiem sesyjnym)
        if ( isset($_COOKIE[session_name()]) ) {
            setcookie(session_name(),'', time() - 42000, '/');
        }
        session_destroy();
        //usuń wpis z id bieżącej sesji z tabeli logged_in_users
        $sql_d="DELETE FROM `logged_in_users` WHERE sessionId='$id'";
        $db->delete($sql_d);
    }
    
    //sprawdź czy użytkownik jest zalogowany i zwróć jego identyfikator
    function getLoggedInUser($db, $sessionId) {    
        //wynik -1 - nie ma wpisu dla tego id sesji w tabeli logged_in_users
        $id = -1;
        $sql = "SELECT * FROM `logged_in_users` WHERE sessionId='$sessionId'";
        if ($result = $db->getMysqli()->query($sql)) {
            $ile = $result->num_rows;
            if ($ile == 1) {
                $row = $result->fetch_object();
                $id = $row->userId;
            }
        }
        return $id;
    } 
}