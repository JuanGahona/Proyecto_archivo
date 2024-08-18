<?php

require_once('../../Configuracion/Conexion.php');

    function obtenerUsuarios()
    {
        // Obtener la conexión a la base de datos
        $conexionData = obtenerConexion();

        // Verificar si la conexión fue exitosa
        if (isset($conexionData['conexion'])) {
            $conexion = $conexionData['conexion'];
        } else {
            // En caso de error, devolver el mensaje de error
            $response = [
                'message' => $conexionData['mensaje'],
                'data' => [],
                'datatable' => [
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0
                ]
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        try {
            // Consulta SQL para obtener los usuarios con personas y roles
            $sql = "SELECT 
                        usuarios.id AS user_id, 
                        usuarios.usuario,
                        usuarios.nombres,
                        usuarios.email,
                        usuarios.sucursal,
                        usuarios.rol_id,
                        usuarios.estado,
                        usuarios.created_at,
                        usuarios.updated_at,
                        roles.id AS rol_id, 
                        roles.nombre AS rol_nombre
                    FROM usuarios
                    LEFT JOIN roles 
                    ON usuarios.rol_id = roles.id";

            $stmt = $conexion->prepare($sql);
            $stmt->execute();

            // Obtener los resultados
            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Agrupar la información
            $usuariosData = [];
            foreach ($usuarios as $usuario) {
                $usuarioId = $usuario['user_id'];

                if (!isset($usuariosData[$usuarioId])) {
                    $usuariosData[$usuarioId] = [
                        'id' => $usuarioId,
                        'usuarios' => $usuario['usuario'],
                        'nombres' => $usuario['nombres'],
                        'email' => $usuario['email'],
                        'sucursal' => $usuario['sucursal'],
                        'rol_id' => $usuario['rol_id'],
                        'estado' => $usuario['estado'],                        
                        'created_at' => $usuario['created_at'],
                        'updated_at' => $usuario['updated_at'],


                        

                        'rol' => [
                            'id' => $usuario['rol_id'],
                            'nombre' => $usuario['rol_nombre']
                        ],
                    ];
                }
            }

            // Convertir a un array indexado
            $usuariosData = array_values($usuariosData);

            // Estructurar la respuesta JSON
            $response = [
                'message' => 'Usuarios obtenidos con éxito',
                'data' => $usuariosData,
                'datatable' => [
                    'recordsTotal' => count($usuariosData),
                    'recordsFiltered' => count($usuariosData)
                ]
            ];

            // Devolver la respuesta en formato JSON
            header('Content-Type: application/json');
            echo json_encode($response);

        } catch (PDOException $e) {
            $response = [
                'message' => 'Error al obtener usuarios: ' . $e->getMessage(),
                'data' => [],
                'datatable' => [
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0
                ]
            ];

            // Devolver el error en formato JSON
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }

    function buscarUsuario(){

        // Obtener la conexión a la base de datos
        $conexionData = obtenerConexion();

        // Verificar si la conexión fue exitosa
        if (isset($conexionData['conexion'])) {
            $conexion = $conexionData['conexion'];
        } else {
            // En caso de error, devolver el mensaje de error
            $response = [
                'message' => $conexionData['mensaje'],
                'data' => [],
                'datatable' => [
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0
                ]
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        try {
            // Consulta SQL para obtener los usuarios con personas y roles
            $sql = "SELECT
                        usuarios.id AS user_id, 
                        usuarios.usuario,
                        usuarios.nombres,
                        usuarios.email,
                        usuarios.sucursal,
                        usuarios.rol_id,
                        usuarios.estado,
                        usuarios.created_at,
                        usuarios.updated_at,
                        roles.id AS rol_id, 
                        roles.nombre AS rol_nombre
                    FROM usuarios
                    LEFT JOIN roles 
                    ON usuarios.rol_id = roles.id
                    WHERE usuarios.id = :user_id";


            $stmt = $conexion->prepare($sql);
            $stmt->execute();

            // Obtener los resultados
            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Agrupar la información
            $usuariosData = [];
            foreach ($usuarios as $usuario) {
                $usuarioId = $usuario['user_id'];

                if (!isset($usuariosData[$usuarioId])) {
                    $usuariosData[$usuarioId] = [
                        'id' => $usuarioId,
                        'usuarios' => $usuario['usuario'],
                        'nombres' => $usuario['nombres'],
                        'email' => $usuario['email'],
                        'sucursal' => $usuario['sucursal'],
                        'rol_id' => $usuario['rol_id'],
                        'estado' => $usuario['estado'],                        
                        'created_at' => $usuario['created_at'],
                        'updated_at' => $usuario['updated_at'],


                        

                        'rol' => [
                            'id' => $usuario['rol_id'],
                            'nombre' => $usuario['rol_nombre']
                        ],
                    ];
                }
            }

            // Convertir a un array indexado
            $usuariosData = array_values($usuariosData);

            // Estructurar la respuesta JSON
            $response = [
                'message' => 'Usuarios obtenidos con éxito',
                'data' => $usuariosData,
                'datatable' => [
                    'recordsTotal' => count($usuariosData),
                    'recordsFiltered' => count($usuariosData)
                ]
            ];

            // Devolver la respuesta en formato JSON
            header('Content-Type: application/json');
            echo json_encode($response);

        } catch (PDOException $e) {
            $response = [
                'message' => 'Error al obtener usuarios: ' . $e->getMessage(),
                'data' => [],
                'datatable' => [
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0
                ]
            ];

            // Devolver el error en formato JSON
            header('Content-Type: application/json');
            echo json_encode($response);
        }

    }

    // Obtener la acción desde la URL
    $action = isset($_GET['action']) ? $_GET['action'] : '';

    switch ($action) {
        case 'ObtenerUsuarios':
            obtenerUsuarios();
            break;
        default:
            $response = [
                'message' => 'Acción no válida',
                'data' => [],
                'datatable' => [
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0
                ]
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
            break;
    }

?>