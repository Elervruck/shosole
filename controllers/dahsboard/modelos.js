// Constante para completar la ruta de la API.
const MODELO_API = 'business/dashboard/modelo.php';
// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');
// Constante para establecer el formulario de guardar.
const SAVE_FORM = document.getElementById('save-modelo');
// Constante para establecer el título de la modal.
const MODAL_TITLE = document.getElementById('modal-title');
const SAVE_MODAL = new bootstrap.Modal(document.getElementById('crear-modelo'));
// Constantes para establecer el contenido de la tabla.*/
const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');
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


// Método manejador de eventos para cuando se envía el formulario de guardar.
SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const JSON = await dataFetch(MODELO_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        SAVE_MODAL.hide();
        // Se carga nuevamente la tabla para visualizar los cambios.
        fillTable();
        // Se cierra la caja de diálogo.
        // Se muestra un mensaje de éxito.
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});


async function fillTable(form = null) {
    // Se inicializa el contenido de la tabla.
    TBODY_ROWS.innerHTML = '';
    RECORDS.textContent = '';  
    // Se verifica la acción a realizar.
    (form) ? action = 'search' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(MODELO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las fi las de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
                <tr>
                    <td>${row.modelo}</td>
                    <td>${row.marca}</td>
                    <td>
                    <a onclick="openUpdate(${row.id_modelo})" class="btn waves-effect blue tooltipped" data-tooltip="Actualizar">
                        <i class="material-icons">mode_edit</i>
                        </a>
                        <a onclick="openDelete(${row.id_modelo})" class="btn waves-effect red tooltipped" data-tooltip="Eliminar">
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

function openCreate() {
    // Se asigna título a la caja de diálogo.
    MODAL_TITLE.textContent = 'Crear Maodelo';

    // cargar cmb
    fillSelect(MARCA_API, 'readAll', 'nombre-marca', 'elija una marca')
}

async function openDelete(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Estás seguro que quieres eliminar la marca de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_marca', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(MODELO_API, 'delete', FORM);
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
