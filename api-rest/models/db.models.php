<?php 

class DB {

    static public function connection() {
        try {
            $link = new PDO('mysql:host=localhost;dbname=api-rest;port=3306','root','');
            $link->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            // echo "Success Conection";
            return $link;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

}
