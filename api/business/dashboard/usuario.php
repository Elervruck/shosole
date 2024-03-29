<?php
require_once('../../entities/dto/usuario.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $usuario = new Usuario;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna a la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {

            case 'usuariosCargoGrafica':
                if ($result['dataset'] = $usuario->usuariosCargoGrafica()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
                break;  
                
            case 'getUser':
                if (isset($_SESSION['id_usuario'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['alias_usuario'];
                } else {
                    $result['exception'] = 'Alias de usuario indefinido';
                }
                break;
            case 'logOut':
                if (session_destroy()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sesión eliminada correctamente';
                } else {
                    $result['exception'] = 'Ocurrió un problema al cerrar la sesión';
                }
                break;
            case 'readProfile':
                if ($result['dataset'] = $usuario->readProfile()) {
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
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
                /*case 'editProfile':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setNombres($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$usuario->setApellidos($_POST['apellidos'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$usuario->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$usuario->setAlias($_POST['alias'])) {
                    $result['exception'] = 'Alias incorrecto';
                } elseif ($usuario->editProfile()) {
                    $result['status'] = 1;
                    $_SESSION['alias_usuario'] = $usuario->getAlias();
                    $result['message'] = 'Perfil modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;*/
            case 'changePassword':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setId($_SESSION['id_usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$usuario->checkPassword($_POST['actual'])) {
                    $result['exception'] = 'Clave actual incorrecta';
                } elseif ($_POST['nueva'] != $_POST['confirmar']) {
                    $result['exception'] = 'Claves nuevas diferentes';
                } elseif (!$usuario->setClave($_POST['nueva'])) {
                    $result['exception'] = Validator::getPasswordError();
                } elseif ($usuario->changePassword()) {
                    $result['status'] = 1;
                    $result['message'] = 'Contraseña cambiada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $usuario->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            

            case 'readGenero':
                if ($result['dataset'] = $usuario::GENERO) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay generos que esten registradas';
                }
                break;

            case 'readEstado':
                if ($result['dataset'] = $usuario::ESTADO) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay estados que esten registradas';
                }
                break;
            
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $usuario->searchRows($_POST['search'])) {
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
                if (!$usuario->setNombres($_POST['nombre-u'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$usuario->setApellidos($_POST['apellidos-u'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$usuario->setCorreo($_POST['correo-u'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$usuario->setAlias($_POST['alias-u'])) {
                    $result['exception'] = 'Alias incorrecto';
                } elseif (!$usuario->setClave($_POST['clave-u'])) {
                    $result['exception'] = Validator::getPasswordError();
                } elseif (!isset($_POST['genero-u'])) {
                    $result['exception'] = 'Seleccione un género';
                } elseif (!$usuario->setGenero($_POST['genero-u'])) {
                    $result['exception'] = 'Género incorrecto';
                } elseif (!$usuario->setEstado($_POST['estado-u'])) {
                    $result['exception'] = 'Estado es incorrecto';
                } elseif (!$usuario->setCargo($_POST['cargo-u'])) {
                    $result['exception'] = 'Cargo incorrecto';
                } elseif ($usuario->createRow()) {
                    $result['status'] = 1;
                    if (is_uploaded_file($_FILES['im_u']['tmp_name'])) {
                        if ($usuario->setImagen($_FILES['im_u'])) {
                            if (Validator::saveFile($_FILES['im_u'], $usuario->getRutaImagen(), $usuario->getImagen())) {
                                $result['message'] = 'Usuario creado correctamente';
                            } else {
                                $result['message'] = 'Usuario creado, pero no se guardó la imagen';
                            }
                        } else {
                            $result['exception'] = Validator::getFileError();
                        }
                    } else {
                        $result['message'] = 'Usuario creado correctamente sin foto';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readOne':
                if (!$usuario->setId($_POST['id_usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif ($result['dataset'] = $usuario->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Usuario inexistente';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setId($_POST['id'])) {
                    $result['exception'] = 'Usuario incorrecta';
                } elseif (!$data = $usuario->readOne()) {
                    $result['exception'] = 'Usuario inexistente';
                } elseif (!$usuario->setNombres($_POST['nombre-u'])) {
                    $result['exception'] = 'Hubo un error en el usuario';
                } elseif (!$usuario->setApellidos($_POST['apellidos-u'])) {
                    $result['exception'] = 'Apellido incorrecto';
                } elseif (!$usuario->setAlias($_POST['alias-u'])) {
                    $result['exception'] = 'Alias incorrecto';
                } elseif (!$usuario->setClave($_POST['clave-u'])) {
                    $result['exception'] = 'Clave incorrecta';
                } elseif (!$usuario->setCorreo($_POST['correo-u'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$usuario->setGenero($_POST['genero-u'])) {
                    $result['exception'] = 'Género incorrecto';
                } elseif (!$usuario->setEstado($_POST['estado-u'])) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!$usuario->setCargo($_POST['cargo-u'])) {
                    $result['exception'] = 'Cargo incorrecto';
                } elseif (!is_uploaded_file($_FILES['im_u']['tmp_name'])) {
                    if ($usuario->updateRow($data['foto_usuario'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Usuario modificado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$usuario->setImagen($_FILES['im_u'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($usuario->updateRow($data['foto_usuario'])) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['im_u'], $usuario->getRutaImagen(), $usuario->getImagen())) {
                        $result['message'] = 'Usuario modificado correctamente';
                    } else {
                        $result['message'] = 'Usuario modificado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if ($_POST['id_usuario'] == $_SESSION['id_usuario']) {
                    $result['exception'] = 'No se puede eliminar a sí mismo';
                } elseif (!$usuario->firstuser()) {
                    $result['exception'] = 'No se puede obtener el primer usuario';
                } elseif ($usuario->getId() == $_POST['id_usuario']) {
                    $result['exception'] = 'No puedes eliminar el primer usuario';
                } elseif (!$usuario->setId($_POST['id_usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$usuario->readOne()) {
                    $result['exception'] = 'Usuario inexistente';
                } elseif ($usuario->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario eliminado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readAllGenero':
                if ($result['dataset'] = $usuario->readAllGenero()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        // Se compara la acción a realizar cuando el administrador no ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readUsers':
                if ($usuario->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Debe autenticarse para ingresar';
                } else {
                    $result['exception'] = 'Parece que no tienes un usuario, empezemos a crearlo';
                }
                break;
            case 'readAllGenero':
                if ($result['dataset'] = $usuario->readAllGenero()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'signup':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setNombres($_POST['usuario_primer'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$usuario->setApellidos($_POST['apellido_primer'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$usuario->setCorreo($_POST['e_primer'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$usuario->setAlias($_POST['ali_primer'])) {
                    $result['exception'] = 'Alias incorrecto';
                } elseif (!$usuario->setClave($_POST['contra_primer'])) {
                    $result['exception'] = Validator::getPasswordError();
                } elseif ($_POST['rescon_primer'] != $_POST['contra_primer']) {
                    $result['exception'] = 'Claves diferentes';
                } elseif (!$usuario->setGenero($_POST['genero'])) {
                    $result['exception'] = 'Género incorrecto';
                } elseif (!$usuario->setEstado('Activo')) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!$usuario->setCargo(1)) {
                    $result['exception'] = 'Cargo incorrecto';
                } elseif ($usuario->createRow()) {
                    $result['status'] = 1;
                    if (is_uploaded_file($_FILES['im_primer']['tmp_name'])) {
                        if ($usuario->setImagen($_FILES['im_primer'])) {
                            if (Validator::saveFile($_FILES['im_primer'], $usuario->getRutaImagen(), $usuario->getImagen())) {
                                $result['message'] = 'Usuario creado correctamente con foto';
                            } else {
                                $result['message'] = 'Usuario creado, pero no se guardó la foto';
                            }
                        } else {
                            $result['exception'] = Validator::getFileError();
                        }
                    } else {
                        $result['message'] = 'Usuario creado correctamente sin foto';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

            
            
            case 'login':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->checkUser($_POST['alias'])) {
                    $result['exception'] = 'Alias incorrecto';
                } elseif ($usuario->getEstado() != 'Activo') {
                    $result['exception'] = 'Tú cuenta no está activa';
                } elseif ($usuario->checkPassword($_POST['clave'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Autenticación correcta';
                    $_SESSION['id_usuario'] = $usuario->getId();
                    $_SESSION['alias_usuario'] = $usuario->getAlias();
                } else {
                    $result['exception'] = 'Clave incorrecta';
                }
                break;

            default:
                $result['exception'] = 'Acción no disponible fuera de la sesión';
        }
    }
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
