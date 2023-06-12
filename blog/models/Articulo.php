<?php 

class Articulo {
    private $conn;
    private $table = 'articulos';

    // propiedades
    public $id;
    public $titulo;
    public $imagen;
    public $texto;
    public $fecha_creacion;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function get_all() {
        try {
            $query = "SELECT * FROM $this->table";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function get($id) {
        try {
            $query = "SELECT * FROM $this->table WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute(['id'=>$id]);
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
