<?php
require_once('../../entities/dto/pedidos.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $pedido = new Pedido;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como cliente para realizar las acciones correspondientes.
    if (isset($_SESSION['id_cliente'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un cliente ha iniciado sesión.
        switch ($_GET['action']) {
            case 'createDetail':
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
                // Inicia el pedido y maneja excepciones en caso de error
                if (!$pedido->startOrder()) {
                    $result['exception'] = Database::getException();
                    // Verifica si el producto es incorrecto
<<<<<<< HEAD
=======
                if (!$pedido->startOrder()) {
                    $result['exception'] = Database::getException();
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
=======
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
                } elseif (!$pedido->setProducto($_POST['idpro'])) {
                    $result['exception'] = 'Producto incorrecto';
                    // Verifica si la cantidad es incorrecta
                } elseif (!$pedido->setCantidad($_POST['cantidad'])) {
                    $result['exception'] = 'Cantidad incorrecta';
<<<<<<< HEAD
<<<<<<< HEAD
                    // Modifica el inventario y crea el detalle del pedido correctamente
=======
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
=======
                    // Modifica el inventario y crea el detalle del pedido correctamente
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
                } elseif ($pedido->ModInventory() && $pedido->createDetail()) {
                    $result['status'] = 1;
                    $result['message'] = 'Producto agregado correctamente';
                    // Maneja excepciones de la base de datos en caso de error
                } else {
                    $result['exception'] = Database::getException();
                }
                break;

            
            case 'readOrderDetail':
                // Verifica si el pedido ha sido iniciado, en caso contrario muestra un mensaje de error
                if (!$pedido->startOrder()) {
                    $result['exception'] = 'Debe agregar un producto al carrito';
                    // Lee los detalles del pedido y asigna el resultado al conjunto de datos del resultado
                } elseif ($result['dataset'] = $pedido->readOrderDetail()) {
                    $result['status'] = 1;
                    $_SESSION['id_pedido'] = $pedido->getId();
<<<<<<< HEAD
<<<<<<< HEAD
                    // Maneja excepciones de la base de datos en caso de error
=======
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
=======
                    // Maneja excepciones de la base de datos en caso de error
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                    // Muestra un mensaje de error si no hay productos en el carrito
                } else {
                    $result['exception'] = 'No tiene productos en el carrito';
                }
                break;


            case 'updateDetail':
                // Validar y limpiar los datos recibidos en $_POST
                $_POST = Validator::validateForm($_POST);
<<<<<<< HEAD
<<<<<<< HEAD
                // Verificar si el id de detalle es incorrecto
=======
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
=======
                // Verificar si el id de detalle es incorrecto
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
                if (!$pedido->setIddetalle($_POST['id_detalle'])) {
                    $result['exception'] = 'Detalle incorrecto';
                    // Verificar si la cantidad es incorrecta
                } elseif (!$pedido->setCantidad($_POST['cantidad_nueva'])) {
                    $result['exception'] = 'Cantidad incorrecta';
<<<<<<< HEAD
<<<<<<< HEAD
                    // Actualizar el detalle del pedido correctamente
=======
                } elseif (!$pedido->ModInventoryParam($_POST['id_producto'])) {
                    $result['exception'] = 'Error modificando el inventario';
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
=======
                    // Actualizar el detalle del pedido correctamente
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
                } elseif ($pedido->updateDetail()) {
                    if ($_POST['cantidad_nueva'] > $_POST['cantidad_actual']) {
                        $diferencia = $_POST['cantidad_nueva'] - $_POST['cantidad_actual'];
                        $aumento = 1;
                    } else {
                        $diferencia = $_POST['cantidad_actual'] - $_POST['cantidad_nueva'];
                        $aumento = 0;
                    }
                    // Modificar el inventario con el parámetro id_producto recibido
                    if ($pedido->ModInventoryParam($_POST['id_producto'], $diferencia, $aumento)) {
                        $result['status'] = 1;
                        $result['message'] = 'Cantidad modificada correctamente';
                    } else {
                        $result['exception'] = 'Error modificando el inventario';
                    }
                    // Manejar cualquier otro problema al modificar la cantidad
                } else {
                    $result['exception'] = 'Ocurrió un problema al modificar la cantidad';
                }
                break;

            case 'deleteDetail':
                // Verificar si el id de detalle es incorrecto
                if (!$pedido->setIdDetalle($_POST['id_detalle'])) {
                    $result['exception'] = 'Detalle incorrecto';
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
                    // Verificar si la cantidad es incorrecta
                } elseif (!$pedido->setCantidad($_POST['cantidad'])) {
                    $result['exception'] = 'Cantidad incorrecta';
                    // Verificar si el id de producto es incorrecto
                } elseif (!$pedido->setProducto($_POST['id_producto'])) {
                    $result['exception'] = 'Producto incorrecto';
                    // Restar del inventario y eliminar el detalle del pedido correctamente
                } elseif ($pedido->RestInventory() && $pedido->deleteDetail()) {
                    $result['status'] = 1;
                    $result['message'] = 'Producto agregado correctamente';
                    // Manejar cualquier otra excepción de la base de datos
<<<<<<< HEAD
=======
                } elseif (!$pedido->setCantidad($_POST['cantidad'])) {
                    $result['exception'] = 'Cantidad incorrecta';
                } elseif (!$pedido->setProducto($_POST['id_producto'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif ($pedido->RestInventory() && $pedido->deleteDetail()) {
                    $result['status'] = 1;
                    $result['message'] = 'El producto del carrito ha sido eliminado correctamente';
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
=======
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
                } else {
                    $result['exception'] = Database::getException();
                }
                //------------
                /*if (!$pedido->setIdDetalle($_POST['id_detalle'])) {
                    $result['exception'] = 'Detalle incorrecto';
                } elseif ($pedido->deleteDetail()) {
                    $result['status'] = 1;
                    $result['message'] = 'Producto removido correctamente';
                } else {
                    $result['exception'] = 'Ocurrió un problema al remover el producto';
                }*/
                break;

            case 'finishOrder':
                // Finalizar el pedido correctamente
                if ($pedido->finishOrder()) {
                    $result['status'] = 1;
                    $result['message'] = 'Pedido finalizado correctamente';
                    // Manejar cualquier otro problema al finalizar el pedido
                } else {
                    $result['exception'] = 'Ocurrió un problema al finalizar el pedido';
                }
<<<<<<< HEAD
                break;
            case 'cargarHistorial':
                if (!$pedido->setId($_POST['id_pedido'])) {
                    $result['exception'] = 'Cliente incorrecto';
                } elseif ($result['dataset'] = $pedido->cargarHistorial()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Historial inexistente';
                }
                break;
            case 'cargarVerCompra':
                // Verificar si el id del pedido es incorrecto
                if (!$pedido->setId($_POST['id_pedido'])) {
                    $result['exception'] = 'VerCompra incorrecto';
                    // Cargar el historial del pedido y asignar el conjunto de datos al resultado
                } elseif ($result['dataset'] = $pedido->readVerCompra()) {
                    $result['status'] = 1;
                    // Manejar excepciones de la base de datos en caso de error
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                    // Indicar que no existe historial para el pedido
                } else {
                    $result['exception'] = 'VerCompra inexistente';
                }
                break;
<<<<<<< HEAD
=======
            break;


             case 'cargarHistorial':
                    if (!$pedido->setId($_POST['id_pedido'])) {
                        $result['exception'] = 'Cliente incorrecto';
                    } elseif ($result['dataset'] = $pedido->cargarHistorial()) {
                        $result['status'] = 1;
                    } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'Historial inexistente';
                    }
             break;

             case 'cargarVerCompra':
                if (!$pedido->setId($_POST['id_pedido'])) {
                   $result['exception'] = 'VerCompra incorrecto';
               } elseif ($result['dataset'] = $pedido->readVerCompra()) {
                   $result['status'] = 1;
               } elseif (Database::getException()) {
                   $result['exception'] = Database::getException();
               } else {
                   $result['exception'] = 'VerCompra inexistente';
               }
               break;
            
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
=======
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
            default:
            
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        // Se compara la acción a realizar cuando un cliente no ha iniciado sesión.
        switch ($_GET['action']) {
            case 'createDetail':
                $result['exception'] = 'Debe iniciar sesión para agregar el producto al carrito';
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
