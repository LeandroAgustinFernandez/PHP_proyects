<?php

    class Basemysql{

    //Parámetros base de datos
    private $host = 'localhost';
    private $db_name = 'blogudemy';
    private $username = 'root';
    private $password = '';
    // private $port = 3310;
    private $conn;

    //Conexión a la BD
    public function connect(){
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' .$this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error en la conexión: " . $e->getMessage();
        }

        return $this->conn;
    }

    }