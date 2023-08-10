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
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$cliente->setDui($_POST['dui-c'])) {
                    $result['exception'] = 'Dui incorrecto';
                } elseif (!$cliente->setCorreo($_POST['correo-c'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$cliente->setTelefono($_POST['telefono-c'])) {
                    $result['exception'] = 'Teléfono incorrecto';
                } elseif (!isset($_POST['genero-c'])) {
                    $result['exception'] = 'Seleccione un género';
                } elseif (!$cliente->setGenero($_POST['genero-c'])) {
                    $result['exception'] = 'Género incorrecto';
                } elseif (!$cliente->setClave($_POST['contra-c'])) {
                    $result['exception'] = Validator::getPasswordError();
                } elseif (!$cliente->setNacimiento($_POST['nacimiento-c'])) {
                    $result['exception'] = 'Nacimiento incorrecto';
                
                } elseif (!$cliente->setEstadoCliente(1)) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!$cliente->setDireccion(1)) {
                    $result['exception'] = 'Dirección incorrecta';
                } elseif ($cliente->createRow()) {
                    $result['status'] = 1;
                    if (is_uploaded_file($_FILES['im_cli']['tmp_name'])) {
                        if (!$cliente->setImagen($_FILES['im_cli'])) {
                            $result['exception'] = Validator::getFileError();
                            if (Validator::saveFile($_FILES['im_cli'], $cliente->getRutaImagen(), $cliente->getFoto())) {
                                $result['message'] = 'Cliente ha sido creada correctamente';
                            } else {
                                $result['message'] = 'Cliente ha sido creada, pero no se guardó la imagen';
                            }
                        } else {
                            $result['message'] = 'Cliente ha sido creada sin foto';
                        }
                    } else {
                        $result['message'] = 'Cliente creado correctamente sin foto';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readOne':
                if (!$cliente->setId($_POST['id_cliente'])) {
                    $result['exception'] = 'Cliente incorrecto';
                } elseif ($result['dataset'] = $cliente->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Cliente inexistente';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$cliente->setId($_POST['id'])) {
                    $result['exception'] = 'Cliente incorrecta';
                } elseif (!$data = $cliente->readOne()) {
                    $result['exception'] = 'Cliente inexistente';
                } elseif (!$cliente->setNombre($_POST['nombre-c'])) {
                    $result['exception'] = 'Hubo un error en el nombre';
                } elseif (!$cliente->setApellido($_POST['apellidos-c'])) {
                    $result['exception'] = 'Apellido incorrecto';
                } elseif (!$cliente->setUsuario($_POST['usuario-c'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$cliente->setDui($_POST['dui-c'])) {
                    $result['exception'] = 'Dui incorrecto';
                } elseif (!$cliente->setTelefono($_POST['telefono-c'])) {
                    $result['exception'] = 'Teléfono incorrecta';
                } elseif (!$cliente->setNacimiento($_POST['nacimiento-c'])) {
                    $result['exception'] = 'Nacimiento incorrecto';
                } elseif (!$cliente->setCorreo($_POST['correo-c'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$cliente->setDireccion($_POST['direccion-c'])) {
                    $result['exception'] = 'Dirección incorrecto';
                } elseif (!$cliente->setCorreo($_POST['correo-c'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$cliente->setGenero($_POST['genero-c'])) {
                    $result['exception'] = 'Género incorrecto';
                } elseif (!$cliente->setEstadoCliente($_POST['estado-c'])) {
                    $result['exception'] = 'Estado del cliente incorrecto';
                } elseif (!is_uploaded_file($_FILES['im_cli']['tmp_name'])) {
                    if ($cliente->updateRow($data['foto_cliente'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Usuario modificado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$cliente->setImagen($_FILES['im_cli'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($cliente->updateRow($data['foto_cliente'])) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['im_cli'], $cliente->getRutaImagen(), $cliente->getFoto())) {
                        $result['message'] = 'Cliente modificado correctamente';
                    } else {
                        $result['message'] = 'Cliente modificado pero no se guardó la imagen';
                    }
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
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'clientesMasPedidos':
                if($result['dataset'] = $cliente->cantidadPedidosTotal()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
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
