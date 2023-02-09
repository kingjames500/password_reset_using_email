<?php

class Dbh {
    protected function dbConnect(){
        try {
            $username = "root";
            $password = "1234";
            $dbh = new PDO('mysql:host=localhost;dbname=login', $username, $password);
            return $dbh;
        } catch (PDOException $e) {
            print "Connection Error" . $e->getMessage() . "<br/>";
            die();
        }
    }
}

