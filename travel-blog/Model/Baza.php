<?php
//klasa połączenie bazy danych
class Baza {
    private $mysqli;
    public function __construct($serwer, $user, $pass, $baza) {
        $this->mysqli = new mysqli($serwer, $user, $pass, $baza);
        /* sprawdz połączenie */
        if ($this->mysqli->connect_errno) {
            printf("Nie udało sie połączenie z serwerem: %s\n",
                        $mysqli->connect_error);
            exit();
        }
        /* zmien kodowanie na utf8 */
        if ($this->mysqli->set_charset("utf8")) {
            //udało sie zmienić kodowanie
        }
    }
    function __destruct() {
        $this->mysqli->close();
    }
    
    //sprawdź czy dane logowania są poprawne
    public function selectUser($login, $password, $tabela) {
        //parametry $login, $password , $tabela – nazwa tabeli z użytkownikami
        //wynik – id użytkownika lub -1 jeśli dane logowania nie są poprawne
        $id = -1;
        $sql = "SELECT * FROM $tabela WHERE userName='$login'";
        if ($result = $this->mysqli->query($sql)) {
            $ile = $result->num_rows;
            if ($ile == 1) {
                $row = $result->fetch_object();
                $hash = $row->password;
                if (password_verify($password, $hash))
                    $id = $row->id;
            }
            $result->close();
        }
        return $id;
    }
    
    //pobierz wartości z kolumn w określonych wierszach
    public function selectData($sql, $pola) {
        $data = [];
        $element = [];
        if ($result = $this->mysqli->query($sql)) {
            $ilepol = count($pola); //ile pól
            // pętla po wyniku zapytania $results
            while ($row = $result->fetch_object()) {
                for ($i = 0; $i < $ilepol; $i++) {
                    $p = $pola[$i];
                    if ($p == "dateOfBirth" || $p == "dateOfRegistration" ||
                        $p =="submissionDate") { //sformafuj odpowiednio datę
                        list($date, $time) = explode(" ", $row->$p);
                        $element[$p]=$date;
                    } else {
                        $element[$p]=$row->$p;
                    }  
                }
                $data[] = $element;
            }
            $result->close();
        }
        return $data;
    }
    
    //przelicz liczbę wierszów w tabeli
    public function countRows($tabela) {
        $sql="SELECT * from $tabela";
        $result = $this->mysqli->query($sql);
        $rowcount=0;
        if ($result = $this->mysqli->query($sql)) {
            $rowcount = mysqli_num_rows( $result );
        }
        $result->close();
        return $rowcount;
    }
    
    public function delete($sql) {
        if ($this->mysqli->query($sql)) return true; else return false;
    }
    public function insert($sql) {
        if( $this->mysqli->query($sql)) return true; else return false;
    }
    public function update($sql) {
        if( $this->mysqli->query($sql)) return true; else return false;
    }
    public function getMysqli() {
        return $this->mysqli;
    }
}
