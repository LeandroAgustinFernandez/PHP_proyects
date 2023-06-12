<?php 
require_once 'db.models.php';

class CoursesModel {

    function index($table) {
        try {
            $stmt = DB::connection()->prepare("SELECT * FROM $table");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function getByTitle($table, $title) {
        try {
            $stmt = DB::connection()->prepare("SELECT * FROM $table WHERE titulo = '$title'");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function getById($table, $id) {
        try {
            $stmt = DB::connection()->prepare("SELECT * FROM $table WHERE id = '$id'");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function insert($table, $params) {
        try {
            $stmt = DB::connection()->prepare("INSERT INTO $table(titulo, descripcion, instructor, imagen, precio, id_creador, created_at, updated_at) VALUES (:title, :description, :instructor, :image, :price, :id_creator, :created_at, :updated_at)");
            $result = $stmt->execute($params);
            return $result;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    
    function update($table, $id, $params) {
        try {            
            $stmt = DB::connection()->prepare("UPDATE $table SET titulo=:title, descripcion=:description, instructor=:instructor, imagen=:image, precio=:price, id_creador=:id_creator, updated_at=:updated_at WHERE id = $id");
            $result = $stmt->execute($params);
            return $result;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function delete($table, $id) {
        try {
            $stmt = DB::connection()->prepare("DELETE FROM $table WHERE id = '$id'");
            $result = $stmt->execute();
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
