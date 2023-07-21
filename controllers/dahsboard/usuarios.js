// Constante para completar la ruta de la API.
const USUARIO_API = 'business/dashboard/usuario.php';
// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');
// Constante para establecer el formulario de guardar.
const SAVE_FORM = document.getElementById('save-form');
// Constante para establecer el título de la modal.
const MODAL_TITLE = document.getElementById('modal-title');
const SAVE_MODAL = new bootstrap.Modal(document.getElementById('crear-usuario'));
// Constantes para establecer el contenido de la tabla.
const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');
const CGO_API = 'business/dashboard/cargo.php';

// Constante tipo objeto para establecer las opciones del componente Modal.
const OPTIONS = {
    dismissible: false
}
// Inicialización del componente Modal para que funcionen las cajas de diálogo.
// Constante para establecer la modal de guardar.
// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para llenar la tabla con los registros disponibles.
    fillTable();
});

// Método manejador de eventos para cuando se envía el formulario de buscar.
SEARCH_FORM.addEventListener('submit', (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SEARCH_FORM);
    // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
    fillTable(FORM);
});

// Método manejador de eventos para cuando se envía el formulario de guardar.
SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const JSON = await dataFetch(USUARIO_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        SAVE_MODAL.hide();
        // Se carga nuevamente la tabla para visualizar los cambios.
        fillTable();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});

/*
*   Función asíncrona para llenar la tabla con los registros disponibles.
*   Parámetros: form (objeto opcional con los datos de búsqueda).
*   Retorno: ninguno.
*/
async function fillTable(form = null) {
    // Se inicializa el contenido de la tabla.
    TBODY_ROWS.innerHTML = '';
    RECORDS.textContent = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'search' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(USUARIO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            let imagen = '';
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            if (row.foto_usuario != null) {
                imagen = `<td><img src="${SERVER_URL}images/usuario/${row.foto_usuario}" class="materialboxed" height="100"></td>`

            } else {
                imagen = `<td><img src="../../resources/img/imagen_predeterminada.png" class="materialboxed" height="100"></td>`
            }
            TBODY_ROWS.innerHTML += `
                <tr>
                    <td>${row.nombre_usuario}</td>
                    <td>${row.apellido_usuario}</td>
                    <td>${row.alias_usuario}</td>
                    <td>${row.generos_usuarios}</td>
                    <td>${row.cargo}</td>
                    <td>${row.correo_usuario}</td>
                    <td>${row.estado_usuarios}</td>
                        ${imagen}

                    <td>
                    <a onclick="openUpdate(${row.id_usuario})" class="btn waves-effect blue tooltipped" data-tooltip="Actualizar">
                            <i class="material-icons">mode_edit</i>
                        </a>
                        <a onclick="openDelete(${row.id_usuario})" class="btn waves-effect red tooltipped" data-tooltip="Eliminar">
                            <i class="material-icons">delete</i>
                            
                        </a>
                        </td>
                </tr>
            `;
        });
        // Se inicializa el componente Tooltip para que funcionen las sugerencias textuales.
        // Se muestra un mensaje de acuerdo con el resultado.
        RECORDS.textContent = JSON.message;
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}

/*
*   Función para preparar el formulario al momento de insertar un registro.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
function openCreate() {

    // Se asigna título a la caja de diálogo.
    MODAL_TITLE.textContent = 'Crear usuario';
    // cargar cmb
    fillSelect(CGO_API, 'readAll', 'cargo-u', 'Elija un cargo');
    fillSelect(USUARIO_API, 'readGenero', 'genero-u', 'Elija un género');
    fillSelect(USUARIO_API, 'readEstado', 'estado-u', 'Elija un estado');

}

/*
*   Función asíncrona para preparar el formulario al momento de actualizar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
async function openUpdate(id) {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id_usuario', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(USUARIO_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se abre la caja de diálogo que contiene el formulario.
        SAVE_MODAL.show();
        // Se asigna título a la caja de diálogo.
        MODAL_TITLE.textContent = 'Actualizar usuario';

        document.getElementById('id').value = JSON.dataset.id_usuario;
        document.getElementById('nombre-u').value = JSON.dataset.nombre_usuario;
        document.getElementById('apellidos-u').value = JSON.dataset.apellido_usuario;
        document.getElementById('correo-u').value = JSON.dataset.correo_usuario;
        document.getElementById('alias-u').value = JSON.dataset.alias_usuario;
        //Se manda a traer la información de la tabla a los controles
        fillSelect(CGO_API, 'readAll', 'cargo-u', 'Elija un cargo', JSON.dataset.id_cargo);
        fillSelect(USUARIO_API, 'readAllGenero', 'genero-u', 'Elija un género', JSON.dataset.id_genero);
        fillSelect(USUARIO_API, 'readAllEstado', 'estado-u', 'Elija un estado', JSON.dataset.id_estado_usuario);
        document.getElementById('im_u').required = false;


    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

/*
*   Función asíncrona para eliminar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
async function openDelete(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar el usuario de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_usuario', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(USUARIO_API, 'delete', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            // Se carga nuevamente la tabla para visualizar los cambios.
            fillTable();
            // Se muestra un mensaje de éxito.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}