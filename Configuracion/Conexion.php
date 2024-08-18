<?php
 
    $host = 'localhost';
    $dbname = 'proyecto_archivo';
    $username = 'root';
    $password = '';
 
    function obtenerConexion()
    {
        global $host, $dbname, $username, $password;
        
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
 
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
            return [ 'conexion' => $pdo];
            
        } catch (PDOException $e) {
            
            return ['success' => false, 'mensaje' => 'Error de conexión: ' . $e->getMessage()];
        }
    }
    
?>