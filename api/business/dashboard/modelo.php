<?php
require_once('../../entities/dto/maodelo.php')
// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $modelo = new Modelo;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna a la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
     // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        $result['session'] = 1;
         // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch($_GET['action']){
            case 'readAll'
                if ($result['dataset'] = $modelo->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . 'registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                } 
                break;
            case 'search'
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $modelo->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;

            case 'create'
                $_POST = Validator::validateForm($_POST);
                if(!$modelo->setModelo($_POST['nombre-modelo'])){
                    $result[exception] = 'Modelo incorrectos';
                } elseif (!isset($_POST['nombre-marca'])) {
                    $result['exception'] = 'Seleccione una marca';
                } elseif (!$modelo->setMarca($_POST['nombre-marca'])) {
                    $result['exception'] = 'Marca incorrecto';
                } elseif ($modelo->createRow()){
                    $result['status'] = 1;
                else {
                        $result['exception'] = Database::getException();
                    }
                }
                break;

            case 'readOne'
            
                break;

            case 'update'
            
                break;

            case 'delete'
            if (!$modelo->setId($_POST['id_modelo'])) {
                $result['exception'] = 'Modelo incorrecto';
            } elseif (!$data = $modelo->readOne()) {
                $result['exception'] = 'Modelo inexistente';
            } elseif ($modelo->deleteRow()) {
                $result['status'] = 1;
                    $result['message'] = 'El modelo eliminada correctamente';
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