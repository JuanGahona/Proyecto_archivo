<?php

    require_once '../../Configuracion/Conexion.php';

    function ObtenerArchivos() {
        // Obtener la conexión
        $conn = obtenerConexion();
    
        // Verificar si la conexión fue exitosa
        if ($conn instanceof PDO) {
            // La conexión es válida
        } else {
            // En caso de error, devolver el mensaje de error
            $response = [
                'message' => isset($conn['mensaje']) ? $conn['mensaje'] : 'Error desconocido',
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
            // Consulta SQL para obtener los archivos y los datos del usuario
            $sql = "SELECT archivos.*, usuarios.nombres AS usuario_nombre, usuarios.usuario AS usuario_usuario 
                    FROM archivos 
                    LEFT JOIN usuarios ON archivos.usuario_id = usuarios.id";
    
            // Preparar y ejecutar la consulta
            $stmt = $conn->prepare($sql);
            $stmt->execute();
    
            // Obtener los resultados
            $archivos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Estructurar la respuesta JSON
            $response = [
                'message' => 'Archivos obtenidos con éxito',
                'data' => array_map(function($archivo) {
                    return [
                        'id' => $archivo['id'],
                        'numero_identificacion' => $archivo['numero_identificacion'],
                        'nombre_paciente' => $archivo['nombre_paciente'],
                        'fecha_creacion' => $archivo['fecha_creacion'],
                        'fecha_modificacion' => $archivo['fecha_modificacion'],
                        'folio' => $archivo['folio'],
                        'tomo' => $archivo['tomo'],
                        'fila' => $archivo['fila'],
                        'estanteria' => $archivo['estanteria'],
                        'archivero' => $archivo['archivero'],
                        'observacion' => $archivo['observacion'],
                        'usuario' => [
                            'nombre' => $archivo['usuario_nombre'],
                            'usuario' => $archivo['usuario_usuario']
                        ]
                    ];
                }, $archivos),
                'datatable' => [
                    'recordsTotal' => count($archivos),
                    'recordsFiltered' => count($archivos)
                ]
            ];
    
        } catch (PDOException $e) {
            $response = [
                'message' => 'Error al obtener archivos: ' . $e->getMessage(),
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
    }

    function BuscarPaciente($numeroIndentificaicon){
        // Obtener la conexión
        $conn = obtenerConexion();
    
        // Verificar si la conexión fue exitosa
        if ($conn instanceof PDO) {
            // La conexión es válida
        } else {
            // En caso de error, devolver el mensaje de error
            $response = [
                'message' => isset($conn['mensaje']) ? $conn['mensaje'] : 'Error desconocido',
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
            // Consulta SQL para obtener los archivos y los datos del usuario
            $sql = "SELECT id,fecha_creacion,nombre_paciente,folio,tomo,fila,estanteria,archivero,observacion FROM archivos where numero_identificacion = :numeroIndentificacion";
    
            // Preparar y ejecutar la consulta
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':numeroIndentificacion', $numeroIndentificaicon, PDO::PARAM_INT);
            $stmt->execute();
    
            // Obtener los resultados
            $archivos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Estructurar la respuesta JSON
            $response = [
                'message' => 'Paciente ya existe',
                'data' => array_map(function($archivo) {
                    return [
                        'id' => $archivo['id'],
                        'nombre_paciente' => $archivo['nombre_paciente'],
                        'fecha_creacion' => $archivo['fecha_creacion'],
                        'folio' => $archivo['folio'],
                        'tomo' => $archivo['tomo'],
                        'fila' => $archivo['fila'],
                        'estanteria' => $archivo['estanteria'],
                        'archivero' => $archivo['archivero'],
                        'observacion' => $archivo['observacion'],
                    ];
                }, $archivos),
                'datatable' => [
                    'recordsTotal' => count($archivos),
                    'recordsFiltered' => count($archivos)
                ]
            ];
    
        } catch (PDOException $e) {
            $response = [
                'message' => 'Error al obtener archivos: ' . $e->getMessage(),
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
    }

    // Obtener la acción desde la URL
    $action = isset($_GET['action']) ? $_GET['action'] : '';

    $numeroIdentificacion = isset($_GET['numeroIndentificacion']) ? intval($_GET['numeroIndentificacion']) : null;

    switch ($action) {
        case 'ObtenerArchivos':
            ObtenerArchivos();
            break;
        case 'BuscarPaciente':
            BuscarPaciente($numeroIdentificacion);
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