/*
*   Controlador de uso general en las páginas web del sitio privado.
*   Sirve para manejar las plantillas del encabezado y pie del documento.
*/

// Constante para completar la ruta de la API.
const USER_API = 'business/dashboard/usuario.php';



// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Petición para obtener en nombre del usuario que ha iniciado sesión.
    const JSON = await dataFetch(USER_API, 'getUser');
    // Se verifica si el usuario está autenticado, de lo contrario se envía a iniciar sesión.
    if (JSON.session) {
        // Se comprueba si existe un alias definido para el usuario, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            let menu = `
            <ul class="lista-admins">
                <li><a href="inventarios.html">Inventarios</a></li>
                <li><a href="dashboard.html">Dashboard</a></li>
                <li><a href="productos.html">Productos</a></li>
                <li><a href="marcas.html">Marcas</a></li>
                <li><a href="cargos.html">Cargos</a></li>
                <li><a href="modelos.html">Modelos</a></li>
                <li><a href="clientes.html">Clientes</a></li>
                <li><a href="usuarios.html">Usuarios</a></li>
                <li><a href="pedidos.html">Pedidos</a></li>
            </ul>
                `;
            document.querySelector('nav').innerHTML = menu;
        } else {
            sweetAlert(3, JSON.exception, false, 'index.html');
        }
    } else {

    }
});