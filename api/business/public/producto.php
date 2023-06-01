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
        //Se compara si hay existencia de registros de la tabla productos
        case 'readAllProductos':
            
            if ($result['dataset'] = $producto->readAllProductos()) {
                $result['status'] = 1;
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
            } else {
                $result['exception'] = 'No existen productos para mostrar';
            }
            break;
        //Se compara si hay existencia de los productos
        case 'readAll':
            if (!$producto->setId($_POST['id_producto'])) {
                $result['exception'] = 'Producto incorrecto';
            } elseif ($result['dataset'] = $producto->readOne()) {
                $result['status'] = 1;
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
            } else {
                $result['exception'] = 'Producto inexistente';
            }
            break;
        
            //Se compara si hay existencia de un registro
        case 'readOne':
        if (!$producto->setId($_POST['id_producto'])) {
            $result['exception'] = 'Producto incorrecto';
        } elseif ($result['dataset'] = $producto->readOne()) {
            $result['status'] = 1;
        } elseif (Database::getException()) {
            $result['exception'] = Database::getException();
        } else {
            $result['exception'] = 'Producto inexistente';
        }
        break;
        //Se compara si hay existencia de un registro
        case 'readOne':
        if (!$producto->setId($_POST['id_producto'])) {
            $result['exception'] = 'Producto incorrecto';
        } elseif ($result['dataset'] = $producto->readOne()) {
            $result['status'] = 1;
        } elseif (Database::getException()) {
            $result['exception'] = Database::getException();
        } else {
            $result['exception'] = 'Producto inexistente';
        }
        break;//Se compara si hay existencia de un registro
        case 'readOne':
        if (!$producto->setId($_POST['id_producto'])) {
            $result['exception'] = 'Producto incorrecto';
        } elseif ($result['dataset'] = $producto->readOne()) {
            $result['status'] = 1;
        } elseif (Database::getException()) {
            $result['exception'] = Database::getException();
        } else {
            $result['exception'] = 'Producto inexistente';
        }
        break;
        //Se compara si hay existencia de un registro
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
