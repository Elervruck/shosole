<?php
require_once('../../entities/dto/marca.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $marca = new Marca;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna a la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $marca->readAll()) {
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
                } elseif ($result['dataset'] = $marca->searchRows($_POST['search'])) {
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
                if (!$marca->setMarca($_POST['nombre-m'])) {
                    $result['exception'] = 'Marca incorrectos';
                } elseif (!is_uploaded_file($_FILES['im_m']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } elseif (!$marca->setImagen($_FILES['im_m'])) {
                    $result['exception'] = Validator::getFileError();            
                } elseif ($marca->createRow()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['im_m'], $marca->getRutaImagen(), $marca->getImagen())) {
                        $result['message'] = 'La marca ha sido creada correctamente';
                    } else {
                        $result['message'] = 'La marca ha sido creada, pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                
            case 'readOne':
                if (!$marca->setId($_POST['id_cargo'])) {
                    $result['exception'] = 'Cargo incorrecto';
                } elseif ($result['dataset'] = $marca->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Cargo inexistente';
                }
                break;

            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$marca->setId($_POST[''])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$marca->readOne()) {
                    $result['exception'] = 'Usuario inexistente';
                } elseif (!$marca->setNombres($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$marca->setApellidos($_POST['apellidos'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$marca->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif ($marca->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            
                case 'delete':
                if (!$marca->setId($_POST['id_marca'])) {
                    $result['exception'] = 'Marca incorrecto';
                } elseif (!$data = $marca->readOne()) {
                    $result['exception'] = 'Marca inexistente';
                } elseif ($marca->deleteRow()) {
                    $result['status'] = 1;
                        $result['message'] = 'La marca eliminada correctamente';
                } else {
                    $result['exception'] = Database::getException();
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
