<?php

class Articulo
{
    private $conn;
    private $table = 'articulos';

    // propiedades
    public $id;
    public $titulo;
    public $imagen;
    public $texto;
    public $fecha_creacion;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function get_all()
    {
        try {
            $query = "SELECT * FROM $this->table";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function get($id)
    {
        try {
            $query = "SELECT * FROM $this->table WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function create($params)
    {
        try {
            $query = "INSERT INTO $this->table (titulo, imagen, texto) VALUES (:title, :image, :text)";
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute($params);
            return $result;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function update($params)
    {
        try {
            if (array_key_exists('image', $params)) {
                $query = "UPDATE $this->table SET titulo=:title, texto=:text, imagen=:image WHERE id = :id";
            } else {
                $query = "UPDATE $this->table SET titulo=:title, texto=:text WHERE id = :id";
            }
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute($params);
            return $result;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function delete($id)
    {
        try {
            $query = "DELETE FROM $this->table WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute(['id' => $id]);
            return $result;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
