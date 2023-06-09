<?php
require_once('../../entities/dashboard/dto/condicion.php');

if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $condicion = new Condicion;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            
            case 'readAll':
                if ($result['dataset'] = $condicion->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;

            case 'readOne':
                if (!$condicion->setId($_POST['id'])) {
                    $result['exception'] = 'Modelo incorrecto';
                } elseif ($result['dataset'] = $condicion->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Condicion inexistente';
                }
                break;

             case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] == 'Ingrese una condicion para buscar';
                } elseif ($result['dataset'] = $condicion->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen' . count($result['dataset']) . 'coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = databaseL::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;

            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$condicion->setCondicion_producto($_POST['condicion'])) {
                    $result['exception'] = 'Condicion incorrecta';
                } elseif ($condicion->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Condicion creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            
            case 'delete':
                if (!$condicion->setId($_POST['id'])) {
                    $result['exception'] = 'Condicion incorrecta';
                } elseif (!$data = $condicion->readOne()) {
                    $result['exception'] = 'Condicion inexistente';
                } elseif ($condicion->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'La Condicion eliminada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            
             case 'update':
                    $_POST = Validator::validateForm($_POST);
                    if (!$condicion->setId($_POST['id'])) {
                        $result['exception'] = 'Condicion incorrecto'; 
                    } elseif (!$data = $condicion->readOne()) {
                        $result['exception'] = 'Condicion inexistente';
                    } elseif (!$condicion->setCondicion_producto($_POST['condicion'])) {
                        $result['exception'] = 'Condicion incorrecto';
                    }  elseif ($condicion->updateRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'Condicion modificada correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                    break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
        // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
        header('content-type: application/json; charset=utf-8');
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
    } else {
        print(json_encode('Acceso denegado'));
    }
} else {
    print(json_encode('Recurso no disponible'));
}