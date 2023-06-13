<?php

class Usuario
{

    private $conn;
    private $table = 'usuarios';

    // ? PROPIEDADES
    public $nombre;
    public $email;
    public $password;
    public $rol_id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function getAll()
    {
        try {
            $query = "SELECT u.*, r.nombre as role FROM usuarios as u INNER JOIN roles as r ON u.rol_id = r.id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function get($id)
    {
        try {
            $query = "SELECT u.*, r.nombre as role FROM usuarios as u INNER JOIN roles as r ON u.rol_id = r.id WHERE u.id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute(['id' => $id]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function getByEmail($email)
    {
        try {
            $query = "SELECT * FROM usuarios WHERE email = '$email'";
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
            $query = "INSERT INTO usuarios(nombre, email, password, rol_id) VALUES (:name, :email, :password, 2)";
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
            $query = "UPDATE $this->table SET rol_id = :role WHERE id = :id";
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
            $query = "DELETE FROM usuarios WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute(['id' => $id]);
            return $result;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function login($params) {
        try {
            try {
                $query = "SELECT * FROM usuarios WHERE email = :email AND password = :password";
                $stmt = $this->conn->prepare($query);
                $stmt->execute($params);
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
