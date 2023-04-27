<?php
require_once('../../entities/dto/clientes.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $cliente = new Clientes;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna a la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {

            case 'readProfile':
                if ($result['dataset'] = $cliente->readProfile()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Usuario inexistente';
                }
                break;
            case 'read':
                if ($result['dataset'] = $producto->readCategoria()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay ningún dato registrado';
                }
                break;
               
            case 'readAll':
                if ($result['dataset'] = $cliente->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            
            case 'readAllEstado':
                if ($result['dataset'] = $cliente->readAllEstadoCliente()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;

                case 'readAllGenero':
                if ($result['dataset'] = $cliente->readAllGenero()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $cliente->searchRows($_POST['search'])) {
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
            if (!$cliente->setNombre($_POST['nombre-c'])) {
                $result['exception'] = 'Nombres incorrectos';
            } elseif (!$cliente->setApellido($_POST['apellidos-c'])) {
                $result['exception'] = 'Apellidos incorrectos';
            } elseif (!$cliente->setUsuario($_POST['usuario-c'])) {
                $result['exception'] = 'Correo incorrecto';
            } elseif (!$cliente->setDui($_POST['dui-c'])) {
                $result['exception'] = 'Alias incorrecto';
            } elseif (!$cliente->setCorreo($_POST['correo-c'])) {
                $result['exception'] = 'Correo incorrecto';
            } elseif (!isset($_POST['genero-c'])) {
                $result['exception'] = 'Seleccione un género';
            } elseif (!$cliente->setGenero($_POST['genero-c'])) {
                $result['exception'] = 'Género incorrecto';
            } elseif (!$usuario->setClave($_POST['contra-c'])) {
                $result['exception'] = Validator::getPasswordError();
            } elseif (!$usuario->setNacimiento($_POST['nacimiento-u'])) {
                $result['exception'] = 'Nacimiento incorrecto';
            } elseif (!$cliente->setEstadoCliente(1)) {
                $result['exception'] = 'Estado incorrecto';
            } elseif (!$cliente->setDireccion(1)) {
                $result['exception'] = 'Dirección incorrecta';
            } elseif (is_uploaded_file($_FILES['im_usu']['tmp_name'])) {
                if (!$cliente->setImagen($_FILES['im_usu'])) {
                    $result['exception'] = Validator::getFileError();
             }elseif ($cliente->createRow()) {
                $result['status'] = 1;
                if (Validator::saveFile($_FILES['im'], $cliente->getRutaImagen(), $cliente->getFoto())) {
                    $result['message'] = 'Cliente ha sido creada correctamente';
                } else {
                    $result['message'] = 'Cliente ha sido creada, pero no se guardó la imagen';
                }
            }
            break;
        }
            case 'readOne':
                if (!$cliente->setId($_POST['id_usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif ($result['dataset'] = $cliente->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Usuario inexistente';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$cliente->setId($_POST['id'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$cliente->readOne()) {
                    $result['exception'] = 'Usuario inexistente';
                } elseif (!$cliente->setNombres($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$cliente->setApellidos($_POST['apellidos'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$cliente->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif ($cliente->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario actualizado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                
                break;
                case 'delete':
                if (!$cliente->setId($_POST['id_cliente'])) {
                    $result['exception'] = 'Cliente incorrecto';
                } elseif (!$data = $cliente->readOne()) {
                    $result['exception'] = 'Cliente inexistente';
                } elseif ($cliente->deleteRow()) {
                    $result['status'] = 1;
                        $result['message'] = 'Cliente eliminado correctamente';
                } else{
                    $result['exception'] = Database::getException();
                }
                break;
                
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
    
        // Se compara la acción a realizar cuando el administrador no ha iniciado sesión.
        
           
    
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
}