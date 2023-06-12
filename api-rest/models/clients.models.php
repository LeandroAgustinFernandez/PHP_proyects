<?php 
require_once 'db.models.php';

class ClientModel {

    function index($table) {
        try {
            $stmt = DB::connection()->prepare("SELECT * FROM $table");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    function get($table, $email) {
        try {
            $stmt = DB::connection()->prepare("SELECT * FROM $table WHERE email = '$email'");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function getByCredentials($table, $credentials) {
        $id_client = $credentials['id_client'];
        $secret_key = $credentials['secret_key'];
        try {
            $stmt = DB::connection()->prepare("SELECT * FROM $table WHERE id_cliente = '$id_client' AND llave_secreta = '$secret_key'");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    
    function insert($table, $params) {
        try {
            $stmt = DB::connection()->prepare("INSERT INTO $table(`nombre`, `apellido`, `email`, `id_cliente`, `llave_secreta`, `created_at`, `updated_at`) VALUES (:first_name,:last_name,:email,:id_client,:secret_key,:created_at,:updated_at)");
            $result = $stmt->execute($params);
            return $result;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

}
