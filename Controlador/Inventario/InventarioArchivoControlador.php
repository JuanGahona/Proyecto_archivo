<?php

    require_once '../../Configuracion/Conexion.php';

    function ObtenerArchivos() {
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
                    LEFT JOIN usuarios ON archivos.usuario_id = usuarios.id ORDER BY id ASC";
    
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

    function crearArchivo() {
        // Obtener la conexión
        $conn = obtenerConexion();
    
        // Verificar si la conexión fue exitosa
        if (!$conn instanceof PDO) {
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
    
        // Verificar si se recibieron los datos
        if (isset($_POST['numero_identificacion']) && isset($_POST['nombre_paciente']) &&
            isset($_POST['folio']) && isset($_POST['tomo']) && isset($_POST['fila']) &&
            isset($_POST['archivero']) && isset($_POST['estanteria']) && isset($_POST['observacion']) &&
            isset($_POST['usuario_id']) && isset($_FILES['archivo'])) {
    
            $numero_identificacion = $_POST['numero_identificacion'];
            $nombre_paciente = $_POST['nombre_paciente'];
            $folio = $_POST['folio'];
            $tomo = $_POST['tomo'];
            $fila = $_POST['fila'];
            $archivero = $_POST['archivero'];
            $estanteria = $_POST['estanteria'];
            $observacion = $_POST['observacion'];
            $usuario_id = $_POST['usuario_id'];
    
            try {
                // Insertar en la tabla de archivos
                $sql = "INSERT INTO public.archivos (numero_identificacion, fecha_creacion, nombre_paciente, fecha_modificacion, folio, tomo, fila, archivero, estanteria, observacion, usuario_id)
                        VALUES (:numero_identificacion, NOW(), :nombre_paciente, NULL, :folio, :tomo, :fila, :archivero, :estanteria, :observacion, :usuario_id)";
                
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':numero_identificacion', $numero_identificacion);
                $stmt->bindParam(':nombre_paciente', $nombre_paciente);
                $stmt->bindParam(':folio', $folio);
                $stmt->bindParam(':tomo', $tomo);
                $stmt->bindParam(':fila', $fila);
                $stmt->bindParam(':archivero', $archivero);
                $stmt->bindParam(':estanteria', $estanteria);
                $stmt->bindParam(':observacion', $observacion);
                $stmt->bindParam(':usuario_id', $usuario_id);
    
                $stmt->execute();
    
                // Obtener el ID del archivo recién insertado
                $archivo_id = $conn->lastInsertId();
    
                // Llamar a la función para crear el detalle del archivo
                crearDetalleArchivo($archivo_id, $usuario_id, $_FILES['archivo']['name'], $nombre_paciente, $folio);
    
                // Devolver la respuesta en formato JSON
                $response = [
                    'message' => 'Archivo y detalle creados con éxito',
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
                    'message' => 'Error al crear el archivo: ' . $e->getMessage(),
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
    

    function crearDetalleArchivo($archivo_id, $usuario_id, $nombre_archivo, $nombre_paciente, $folio) {
        // Obtener la conexión
        $conn = obtenerConexion();
    
        // Verificar si la conexión fue exitosa
        if (!$conn instanceof PDO) {
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
    
        // Definir rutas para carpetas y archivo
        $ruta_carpeta_paciente = 'C:/xampp/htdocs/Proyecto_Archivo/assets/' . $nombre_paciente;
        $ruta_carpeta_folio = $ruta_carpeta_paciente . '/folio_' . $folio;
        $ruta_archivo = $ruta_carpeta_folio . '/' . $nombre_archivo;
    
        // Crear carpetas si no existen
        if (!file_exists($ruta_carpeta_paciente)) {
            mkdir($ruta_carpeta_paciente, 0777, true);
        }
        if (!file_exists($ruta_carpeta_folio)) {
            mkdir($ruta_carpeta_folio, 0777, true);
        }
    
        // Obtener la información del archivo
        $info_archivo = pathinfo($nombre_archivo);
        $nombre_sin_extension = $info_archivo['filename'];
        $extension_archivo = isset($info_archivo['extension']) ? $info_archivo['extension'] : '';
    
        // Mover el archivo a la carpeta deseada
        if (!move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta_archivo)) {
            $response = [
                'message' => 'Error al mover el archivo cargado',
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
            // Insertar en la tabla de detalles del archivo
            $sql = "INSERT INTO detalle_archivo (archivo_id, usuario_id, nombre_archivo, extension_archivo, fecha_creacion)
                    VALUES (:archivo_id, :usuario_id, :nombre_archivo, :extension_archivo, NOW())";
    
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':archivo_id', $archivo_id);
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->bindParam(':nombre_archivo', $nombre_sin_extension);
            $stmt->bindParam(':extension_archivo', $extension_archivo);
    
            $stmt->execute();
    
        } catch (PDOException $e) {
            $response = [
                'message' => 'Error al crear el detalle del archivo: ' . $e->getMessage(),
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

    $numeroIdentificacion = isset($_GET['numeroIndentificacion']) ? intval($_GET['numeroIndentificacion']) : null;

    switch ($action) {
        case 'ObtenerArchivos':
            ObtenerArchivos();
            break;
        case 'BuscarPaciente':
            BuscarPaciente($numeroIdentificacion);
            break;
        case 'CrearArchivo':
            crearArchivo();
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