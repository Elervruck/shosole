// Constante para completar la ruta de la API.
const CLIEN_API = 'business/public/cliente.php';
// Constante para establecer el formulario de registro del primer usuario.
const SIGNUP_FORM = document.getElementById('first-use');

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Petición para consultar los usuarios registrados.
    const JSON = await dataFetch(CLIEN_API);
    console.log(JSON);
    // Se comprueba si existe una sesión, de lo contrario se sigue con el flujo normal.
    if (JSON.session) {
        // Se direcciona a la página web de bienvenida.
        location.href = 'index.html';
    } else if (JSON.status) {
        // Se muestra el formulario para iniciar sesión.
        sweetAlert(4, JSON.message, true);
    } else {
        // Se muestra el formulario para registrar el primer usuario.
        //Método para buscar y llenar un SELECT
        sweetAlert(4, JSON.exception, true);
    }
});

// Método manejador de eventos para cuando se envía el formulario de guardar.
SIGNUP_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SIGNUP_FORM);
    // Petición para registrar el primer usuario del sitio privado.
    const JSON = await dataFetch(CLIEN_API, 'signup', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, true);
    }
});

