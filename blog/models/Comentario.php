<?php

class Comentario
{
    private $conn;
    private $table = 'comentarios';

    public $id;
    public $comentario;
    public $estado;
    public $fecha_creacion;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function getAll()
    {
        try {
            $query = "SELECT c.*, u.nombre, u.email, a.titulo  FROM $this->table as c INNER JOIN usuarios as u ON u.id = c.usuario_id INNER JOIN articulos as a ON a.id = c.articulo_id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function get($id)
    {
        try {
            $query = "SELECT c.*, u.nombre, u.email, a.titulo FROM $this->table as c INNER JOIN usuarios as u ON u.id = c.usuario_id INNER JOIN articulos as a ON a.id = c.articulo_id WHERE c.id = $id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function getByArticle($article_id)
    {
        try {
            $query = "SELECT c.*, u.nombre, u.email, a.titulo FROM $this->table as c INNER JOIN usuarios as u ON u.id = c.usuario_id INNER JOIN articulos as a ON a.id = c.articulo_id WHERE c.articulo_id = $article_id AND estado = 1";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function create($params)
    {
        try {
            $query = "INSERT INTO $this->table (comentario, usuario_id, articulo_id, estado) VALUES (:coment,:user_id,:article_id,0)";
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
            $query = "UPDATE $this->table SET estado=:state WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute($params);
            return $result;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function delete($id)
    {
        try {
            $query = "DELETE FROM $this->table WHERE id = $id";
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute();
            return $result;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
