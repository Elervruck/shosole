<?php
require_once('../../entities/dto/productos.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se instancia la clase correspondiente.
    $producto = new Producto;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se compara la acción a realizar según la petición del controlador.
    switch ($_GET['action']) {
<<<<<<< HEAD
        case 'readProductosMarca':
            // Verificar si el ID de la marca es incorrecto
            if (!$producto->setId($_POST['id_marca'])) {
                $result['exception'] = 'Marca incorrecta';
                // Leer los productos de la marca y asignar el conjunto de datos al resultado
=======
        
        case 'readProductosMarca':
            if (!$producto->setId($_POST['id_marca'])) {
                $result['exception'] = 'Marca incorrecta';
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
            } elseif ($result['dataset'] = $producto->readProductosMarca()) {
                $result['status'] = 1;
                // Manejar excepciones de la base de datos en caso de error
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
                // Indicar que no existen productos para mostrar
            } else {
                $result['exception'] = 'No existen productos para mostrar';
            }
            break;

        case 'readAll':
            // Verificar si el ID del producto es incorrecto
            if (!$producto->setId($_POST['id_producto'])) {
                $result['exception'] = 'Producto incorrecto';
                // Leer un único producto y asignar el conjunto de datos al resultado
            } elseif ($result['dataset'] = $producto->readOne()) {
                $result['status'] = 1;
                // Manejar excepciones de la base de datos en caso de error
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
                // Indicar que el producto no existe
            } else {
                $result['exception'] = 'Producto inexistente';
            }
            break;
<<<<<<< HEAD
        case 'readOneDel':
            // Verificar si el ID del producto es incorrecto
            if (!$producto->setId($_POST['id_producto'])) {
                $result['exception'] = 'Producto incorrecto';
                // Leer un único producto para eliminar y asignar el conjunto de datos al resultado
            } elseif ($result['dataset'] = $producto->readOneDel()) {
                $result['status'] = 1;
                // Manejar excepciones de la base de datos en caso de error
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
                // Indicar que el producto no existe
            } else {
                $result['exception'] = 'Producto inexistente';
            }
            break;
        case 'cargarComentarios':
            // Verificar si el ID del producto es incorrecto
            if (!$producto->setId($_POST['id_producto'])) {
                $result['exception'] = 'Comentarios incorrectos';
                // Cargar los comentarios del producto y asignar el conjunto de datos al resultado
            } elseif ($result['dataset'] = $producto->cargarComentarios()) {
                $result['status'] = 1;
                // Manejar excepciones de la base de datos en caso de error
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
                // Indicar que no se pueden cargar comentarios inexistentes
            } else {
                $result['exception'] = 'No se pueden cargar comentarios inexistentes';
            }
            break;
=======

        case 'readOneDel':
                if (!$producto->setId($_POST['id_producto'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif ($result['dataset'] = $producto->readOneDel()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Producto inexistente';
                }
                break;
            
            case 'cargarComentarios':
                    if (!$producto->setId($_POST['id_producto'])) {
                       $result['exception'] = 'Comentarios incorrectos';
                   } elseif ($result['dataset'] = $producto->cargarComentarios()) {
                       $result['status'] = 1;
                   } elseif (Database::getException()) {
                       $result['exception'] = Database::getException();
                   } else {
                       $result['exception'] = 'No se pueden cargar comentarios inexistentes';
                   }
                   break;
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
        default:
            $result['exception'] = 'Acción no disponible';
    }
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
