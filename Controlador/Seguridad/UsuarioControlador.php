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

    function crearUsuario(){
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

        // Recibir los datos enviados desde JavaScript
        $input = json_decode(file_get_contents('php://input'), true);

        // Verificar si se recibieron los datos correctamente
        if (is_array($input)) {
            $usuario = $input['usuario'];
            $contrasena = $input['contrasena'];
            $nombres = $input['nombres'];
            $email = $input['email'];
            $sucursal = $input['sucursal'];
            $rol_id = $input['rol_id'];
            $estado = $input['estado'];
            $CreadoPor = $input['creado_por'];

            try {
                $sql = "INSERT INTO `usuarios` (`usuario`, `contrasena`, `nombres`, `email`, `sucursal`, `rol_id`, `estado`, `creado_por`, `created_at`, `updated_at`)
                        VALUES (:usuario, SHA2(:contrasena, 256), :nombres, :email, :sucursal, :rol_id, :estado, :creado_por, NOW(), NOW())";
                        
                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(':usuario', $usuario);
                $stmt->bindParam(':contrasena', $contrasena);
                $stmt->bindParam(':nombres', $nombres);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':sucursal', $sucursal);
                $stmt->bindParam(':rol_id', $rol_id);
                $stmt->bindParam(':estado', $estado);
                $stmt->bindParam(':creado_por', $CreadoPor);

                $stmt->execute();

                // Devolver la respuesta en formato JSON
                $response = [
                    'message' => 'Usuario creado con éxito',
                    'data' => [],
                    'datatable' => [
                        'recordsTotal' => 0,
                        'recordsFiltered' => 0
                    ]
                ];

                header('Content-Type: application/json');
                echo json_encode($response);

            } catch (PDOException $e) {
                $response = [
                    'message' => 'Error al crear usuario: ' . $e->getMessage(),
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
        } else {
            // En caso de no recibir los datos correctamente
            $response = [
                'message' => 'Datos no válidos',
                'data' => [],
                'datatable' => [
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0
                ]
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }

    function Auditoria($id) {
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
            // Consulta SQL para obtener la auditoría del usuario por ID
            $sql = "SELECT usuario, creado_por, created_at, actualizado_por, updated_at FROM usuarios WHERE id = :id";
    
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
    
            // Obtener los resultados
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($usuario) {
                $usuarioData = [
                    'usuario' => $usuario['usuario'],
                    'creado_por' => $usuario['creado_por'],
                    'fecha_creacion' => $usuario['created_at'],
                    'actualizado_por' => $usuario['actualizado_por'],
                    'fecha_actualizacion' => $usuario['updated_at'],
                ];
    
                // Estructurar la respuesta JSON
                $response = [
                    'message' => 'Auditoría obtenida con éxito',
                    'data' => $usuarioData,
                    'datatable' => [
                        'recordsTotal' => 1,
                        'recordsFiltered' => 1
                    ]
                ];
            } else {
                // Usuario no encontrado
                $response = [
                    'message' => 'Usuario no encontrado',
                    'data' => [],
                    'datatable' => [
                        'recordsTotal' => 0,
                        'recordsFiltered' => 0
                    ]
                ];
            }
    
            // Devolver la respuesta en formato JSON
            header('Content-Type: application/json');
            echo json_encode($response);
    
        } catch (PDOException $e) {
            $response = [
                'message' => 'Error al obtener la auditoría: ' . $e->getMessage(),
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

    function ConsultarRol() {
        // Obtener la conexión a la base de datos
        $conexionData = obtenerConexion();
        $response = [
            'message' => '',
            'data' => [],
            'datatable' => [
                'recordsTotal' => 0,
                'recordsFiltered' => 0
            ]
        ];
    
        // Verificar si la conexión fue exitosa
        if (!isset($conexionData['conexion'])) {
            // En caso de error, devolver el mensaje de error
            $response['message'] = $conexionData['mensaje'];
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }
    
        $conexion = $conexionData['conexion'];
    
        try {
            // Consulta SQL para obtener los roles
            $sql = "SELECT * FROM roles";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
    
            // Obtener los resultados
            $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Estructurar la respuesta JSON
            $response['message'] = 'Roles obtenidos con éxito';
            $response['data'] = $roles;
            $response['datatable']['recordsTotal'] = count($roles);
            $response['datatable']['recordsFiltered'] = count($roles);
    
        } catch (PDOException $e) {
            $response['message'] = 'Error al obtener roles: ' . $e->getMessage();
        }
    
        // Devolver la respuesta en formato JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    // Obtener la acción desde la URL
    $action = isset($_GET['action']) ? $_GET['action'] : '';

    // Obtener el ID desde la URL si está presente
    $id = isset($_GET['id']) ? intval($_GET['id']) : null;

    switch ($action) {
        case 'ObtenerUsuarios':
            obtenerUsuarios();
            break;
        case 'CrearUsuario':
            crearUsuario();
            break;
        case 'Auditoria':
            if ($id !== null) {
                Auditoria($id);
            } else {
                $response = [
                    'message' => 'ID no proporcionado',
                    'data' => [],
                    'datatable' => [
                        'recordsTotal' => 0,
                        'recordsFiltered' => 0
                    ]
                ];

                header('Content-Type: application/json');
                echo json_encode($response);
            }
            break;
        case 'ObtenerRoles':
            ConsultarRol();
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