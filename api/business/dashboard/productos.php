<?php
require_once('../../entities/dto/productos.php');

if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $producto = new Producto;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {

            case 'readAll':
                if ($result['dataset'] = $producto->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;

            case 'readCondicion':
                if ($result['dataset'] = $producto::CONDICION) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay condiciones que esten registradas';
                }
                break;

            case 'readAllValoracion':
                if (!$producto->setId($_POST['id_producto'])) {

                    $result['exception'] = 'Valoracion incorrecta';
                } elseif ($result['dataset'] = $producto->readAllValoracion()) {

                    $result['status'] = 1;

                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {

                    $result['exception'] = Database::getException();
                } else {

                    $result['exception'] = 'No hay datos registrados';
                }
                break;


            case 'readOne':
                if (!$producto->setId($_POST['id'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif ($result['dataset'] = $producto->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Producto inexistente';
                }
                break;

            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $producto->searchRows($_POST['search'])) {
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

                if (!$producto->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$producto->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$producto->setModelo($_POST['modelo'])) {
                    $result['exception'] = 'Modelo incorrecto';
                } elseif (!$producto->setCondicion($_POST['condicion'])) {
                    $result['exception'] = 'Condicion incorrecta';
                } elseif (!$producto->setUsuario($_POST['usuario'])) {
                    $result['exception'] = 'Usario incorrecta';
                } elseif (!$producto->setEstadoProductos(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!$producto->setExistencia($_POST['existencia'])) {
                    $result['exception'] = 'Existecia incorrecta';
                } elseif (!$producto->setPrecio($_POST['precio'])) {
                    $result['exception'] = 'Precio incorrecta';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                } elseif (!$producto->setImagen($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($producto->createRow()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $producto->getRuta(), $producto->getImagen())) {
                        $result['message'] = 'Producto creado correctamente';
                    } else {
                        $result['message'] = 'Producto creado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();;
                }
                break;


            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$producto->setId($_POST['id'])) {
                    $result['exception'] = 'Id del producto incorrecto';
                } elseif (!$data = $producto->readOne()) {
                    $result['exception'] = 'Producto inexistente';
                } elseif (!$producto->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$producto->setExistencia($_POST['existencia'])) {
                    $result['exception'] = 'Existecia incorrecta';
                } elseif (!$producto->setPrecio($_POST['precio'])) {
                    $result['exception'] = 'Precio incorrecta';
                } elseif (!$producto->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$producto->setCondicion($_POST['condicion'])) {
                    $result['exception'] = 'Condicion incorrecto';
                } elseif (!$producto->setModelo($_POST['modelo'])) {
                    $result['exception'] = 'Modelo incorrecta';
                } elseif (!$producto->setUsuario($_POST['usuario'])) {
                    $result['exception'] = 'Usuario incorrecta';
                } elseif (!$producto->setEstadoProductos(isset($_POST['estado']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    if ($producto->updateRow($data['imagen_producto'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Producto modificado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$producto->setImagen($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($producto->updateRow($data['imagen_producto'])) {
                    $result['status'] = 1;

                    if (Validator::saveFile($_FILES['archivo'], $producto->getRuta(), $producto->getImagen())) {
                        $result['message'] = 'Producto modificado correctamente';
                    } else {
                        $result['message'] = 'Producto modificado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;


            case 'delete':
                if (!$producto->setId($_POST['id_producto'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif (!$data = $producto->readOne()) {
                    $result['exception'] = 'Producto inexistente';
                } elseif ($producto->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Producto eliminado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

            case 'deleteValo':
                if (!$producto->setIdValo($_POST['id_valoracion'])) {
                    $result['exception'] = 'Valoracion incorrecto';
                } elseif (!$data = $producto->readOneValo()) {
                    $result['exception'] = 'Valoracion inexistente';
                } elseif ($producto->deleteRowValo($data['estado_comentario'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Valoracion eliminado correctamente';
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
