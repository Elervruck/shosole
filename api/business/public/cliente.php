<?php
require_once('../../entities/dto/clientes.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $cliente = new Clientes;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
<<<<<<< HEAD
    $result = array('status' => 0, 'session' => 0, 'recaptcha' => 0, 'message' => null, 'exception' => null, 'username' => null, 'id' => 0);
=======
    $result = array('status' => 0, 'session' => 0, 'recaptcha' => 0, 'message' => null, 'exception' => null, 'username' => null, 'id'=>0);
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
    // Se verifica si existe una sesión iniciada como cliente para realizar las acciones correspondientes.
    if (isset($_SESSION['id_cliente'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un cliente ha iniciado sesión.
        switch ($_GET['action']) {
            case 'getUser':
<<<<<<< HEAD
                // Verificar si el usuario está definido en la sesión
                if (isset($_SESSION['usuario_cliente'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['usuario_cliente'];
                    $result['id'] = $_SESSION['id_cliente'];
=======
                if (isset($_SESSION['usuario_cliente'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['usuario_cliente'];
                    $result['id']=$_SESSION['id_cliente'];
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
                } else {
                    // Establecer excepción si el usuario no está definido en la sesión
                    $result['exception'] = 'El usuario es indefinido';
                }
                break;
                //Método para cerrar la sesión de un cliente
            case 'logOut':
                if (session_destroy()) {
                    // Destruir la sesión exitosamente
                    $result['status'] = 1;
                    $result['message'] = 'La sesión ha sido cerrada correctamente';
                } else {
                    // Ocurrió un problema al cerrar la sesión
                    $result['exception'] = 'Ocurrió un problema al cerrar la sesión';
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        // Se compara la acción a realizar cuando el cliente no ha iniciado sesión.
        switch ($_GET['action']) {
            case 'signup':
                // Validar y limpiar los datos recibidos por POST
                $_POST = Validator::validateForm($_POST);
                // Clave secreta para reCAPTCHA
                $secretKey = '6LdBzLQUAAAAAL6oP4xpgMao-SmEkmRCpoLBLri-';
                // Obtener la dirección IP del cliente
                $ip = $_SERVER['REMOTE_ADDR'];
                // Crear los datos para la verificación de reCAPTCHA
                $data = array('secret' => $secretKey, 'response' => $_POST['g-recaptcha-response'], 'remoteip' => $ip);
                // Opciones de la solicitud HTTP
                $options = array(
                    'http' => array('header'  => "Content-type: application/x-www-form-urlencoded\r\n", 'method' => 'POST', 'content' => http_build_query($data)),
                    'ssl' => array('verify_peer' => false, 'verify_peer_name' => false)
                );
                // URL para verificar reCAPTCHA
                $url = 'https://www.google.com/recaptcha/api/siteverify';
                // Crear contexto de la solicitud HTTP
                $context  = stream_context_create($options);
                // Realizar la solicitud a la API de reCAPTCHA
                $response = file_get_contents($url, false, $context);
                // Decodificar la respuesta JSON
                $captcha = json_decode($response, true);

                // if (!$captcha['success']) {
                //     $result['recaptcha'] = 1;
                //     $result['exception'] = 'No eres humano';
                // Establecer los datos en el objeto Cliente
                if (!$cliente->setNombre($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$cliente->setUsuario($_POST['usu'])) {
                    $result['exception'] = 'Usuario incorrectos';
                } elseif (!$cliente->setApellido($_POST['apellidos'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$cliente->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$cliente->setDUI($_POST['dui'])) {
                    $result['exception'] = 'DUI incorrecto';
                } elseif (!$cliente->setNacimiento($_POST['nacimiento'])) {
                    $result['exception'] = 'Fecha de nacimiento incorrecta';
                } elseif (!$cliente->setTelefono($_POST['telefono'])) {
                    $result['exception'] = 'Teléfono incorrecto';
                } elseif (!$cliente->setClave($_POST['clave'])) {
                    $result['exception'] = Validator::getPasswordError();
                } elseif ($cliente->crearCuenta()) {
                    $result['status'] = 1;
                    $result['message'] = 'Cuenta registrada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Método para iniiciar sesión desde la cuenta del cliente
            case 'login':
                // Validar y limpiar los datos recibidos por POST
                $_POST = Validator::validateForm($_POST);
                // Verificar si el usuario existe
                if (!$cliente->checkUser($_POST['usuario'])) {
                    $result['exception'] = 'El usuario es incorrecto';
                // Verificar si la cuenta está activa
                } elseif (!$cliente->getEstado() == 'Activo') {
                    $result['exception'] = 'La cuenta que has querido ingresar esta desactivada o inactiva';
                // Verificar si la contraseña es correcta
                } elseif ($cliente->checkPassword($_POST['contraseña'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Autenticación correcta';
                    $_SESSION['id_cliente'] = $cliente->getId();
                    $_SESSION['usuario_cliente'] = $cliente->getUsuario();
<<<<<<< HEAD
                // En caso de que la contraseña sea incorrecta
=======
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
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
