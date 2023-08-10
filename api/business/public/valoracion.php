<?php
require_once('../../entities/dto/valoracion.php');

if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $valo = new Valoracion;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_cliente'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
            case 'createValoComentario':
                // Validar y limpiar los datos recibidos por POST
                $_POST = Validator::validateForm($_POST);
                // Verificar si el ID del detalle del pedido es incorrecto
                if (!$valo->setIdDetallePedido($_POST['iddetallepedido'])) {
                    $result['exception'] = 'Producto incorrecto';
                // Verificar si el comentario es incorrecto
                } elseif (!$valo->setComentario($_POST['comentario'])) {
                    $result['exception'] = 'que incorrecta';
                // Verificar si la cantidad es incorrecta
                } elseif (!$valo->setCalificacion($_POST['cantidad'])) {
                    $result['exception'] = 'Cantidad incorrecta';
                 // Crear la valoración y el comentario
                } elseif ($valo->createValoComentario()) {
                    $result['status'] = 1;
                    $result['message'] = 'Valoracion agregado correctamente';
                // Capturar y manejar la excepción de la base de datos en caso de error
<<<<<<< HEAD
=======
            
                
            case 'createValoComentario':
                $_POST = Validator::validateForm($_POST);
                if (!$valo->setIdDetallePedido($_POST['iddetallepedido'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif (!$valo->setComentario($_POST['comentario'])) {
                    $result['exception'] = 'Cantidad incorrecta';
                } elseif (!$valo->setCalificacion($_POST['cantidad'])) {
                    $result['exception'] = 'Cantidad incorrecta';
                } elseif ($valo->createValoComentario()) {
                    $result['status'] = 1;
                    $result['message'] = 'Valoracion agregado correctamente';
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
=======
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
            case 'validarComentarios':
                // Verificar si el ID del detalle del pedido es incorrecto
                if (!$valo->setIdDetallePedido($_POST['id_detpedido'])) {
                    $result['exception'] = 'VerCompra incorrecto';
                // Validar el comentario
                } elseif ($result['dataset'] = $valo->validarComentario()) {
                    $result['status'] = 1;
                // Capturar y manejar la excepción de la base de datos en caso de error
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
<<<<<<< HEAD
=======

                case 'validarComentarios':
                    if (!$valo->setIdDetallePedido($_POST['id_detpedido'])) {
                       $result['exception'] = 'VerCompra incorrecto';
                   } elseif ($result['dataset'] = $valo->validarComentario()) {
                       $result['status'] = 1;
                   } else  {
                       $result['exception'] = Database::getException();
                   } 
                break;

               
                   

>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
=======
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
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
<<<<<<< HEAD
<<<<<<< HEAD
}
=======
}
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
=======
}
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
