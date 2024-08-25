<?php

    // $host = 'localhost';
    // $dbname = 'proyecto_archivo';
    // $username = 'root';
    // $password = '';

    // function obtenerConexion() {
    //     global $host, $dbname, $username, $password;
    
    //     try {
    //         // Crear una conexión usando PDO
    //         $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    //         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //         return $conn;
    //     } catch (PDOException $e) {
    //         return ['mensaje' => 'Error al conectar a la base de datos: ' . $e->getMessage()];
    //     }
    // }


    $host = 'dpg-cr4tt9t2ng1s73e7gjr0-a.oregon-postgres.render.com'; // Cambia esto al host de tu servidor PostgreSQL
    $dbname = 'proyecto_archivo';
    $username = 'sebas0946'; // Cambia esto al nombre de usuario de tu base de datos PostgreSQL
    $password = 'NwXszdWQVbWO2fWaw70Z4yzbneLtFrNq'; // Cambia esto a tu contraseña de PostgreSQL

    function obtenerConexion() {
        global $host, $dbname, $username, $password;

        try {
            // Crear una conexión usando PDO para PostgreSQL
            $conn = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            return ['mensaje' => 'Error al conectar a la base de datos: ' . $e->getMessage()];
        }
    }
?>