<?php
require_once('../../entities/dto/inventario.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $inventario = new Inventario;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna a la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $inventario->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $inventario->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                
                break;
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$inventario->setCantidad($_POST['cantidad'])) {
                    $result['exception'] = 'Cantidad incorrecta';  
                } elseif (!$inventario->setPrecio($_POST['precio'])) {
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!$inventario->setFecha($_POST['nacimiento-i'])) {
                    $result['exception'] = 'Nacimiento incorrecto';
                } elseif (!$inventario->setUsuario($_POST['usuario-i'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$inventario->setProducto($_POST['productos'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif ($inventario->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Inventario creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                case 'update':
                    $_POST = Validator::validateForm($_POST);
                    if (!$inventario->setId($_POST['id'])) {
                        $result['exception'] = 'Inventario incorrecto'; 
                    } elseif (!$data = $inventario->readOne()) {
                        $result['exception'] = 'Inventario inexistente';
                    } elseif (!$inventario->setPrecio($_POST['precio'])) {
                        $result['exception'] = 'Precio incorrecto';  
                    } elseif (!$inventario->setCantidad($_POST['cantidad'])) {
                        $result['exception'] = 'Cantidad incorrecto';
                    } elseif (!$inventario->setFecha($_POST['nacimiento-i'])) {
                        $result['exception'] = 'Nacimiento incorrecto';
                    } elseif (!$inventario->setUsuario($_POST['usuario-i'])) {
                        $result['exception'] = 'Usuario incorrecto';
                    } elseif (!$inventario->setProducto($_POST['productos'])) {
                        $result['exception'] = 'Producto incorrecto';
                    }  elseif ($inventario->updateRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'Inventario modificada correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                    break;
                
            case 'readOne':
                if (!$inventario->setId($_POST['id_inventario_producto'])) {
                    $result['exception'] = 'Inventario incorrecto';
                } elseif ($result['dataset'] = $inventario->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Inventario inexistente';
                }
                break;
            
                
            default:
                $result['exception'] = 'No hay datos registrados';
        }
    }
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
