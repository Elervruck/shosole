// Constante para completar la ruta de la API.
const CONDICION_API = 'business/dashboard/condicion.php';
// Constante para establecer el formulario de busqueda.
const SEARCH_FORM =  document.getElementById('search-form');
// Constante para establecer el formulario de guardar.
const SAVE_FORM = document.getElementById('save-condicion');
// Constante para establecer el titulo del modal.
const MODAL_TITLE = document.getElementById('modal-title');
const SAVE_MODAL = new bootstrap.Modal(document.getElementById('crear-condicion'));
// Constantes para establecer el contenido de la tabla
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
    // Llamado a la funcion para llenar la tabla con los registros disponibles.
    fillTable();
})

SEARCH_FORM.addEventListener('submit', (event) => {
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SEARCH_FORM);
    // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
    fillTable(FORM);
}) 


// Método manejador de eventos para cuando se envía el formulario de guardar.
SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const JSON = await dataFetch(CONDICION_API, action, FORM);
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


async function fillTable(form = null){
    // Se inicializa el contenido de la tabla
    TBODY_ROWS.innerHTML = '';
    RECORDS.textContent = '';
    // Se verifica la accion a realizar.
    (form) ? action = 'search' : action = 'readAll';
    // Peticion para obtener los registros disponibles.
    const JSON = await dataFetch(CONDICION_API, action, form);
    // Se comprueba si la respuesta es satisfactoria. de lo contrario se muestra un mensaje con la exception.
    if(JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
                <tr>
                    <td>${row.condicion_producto}</td>
                    <td> 
                        <a onclick="openUpdate(${row.id_condicion_producto})" class="btn waves-effect blue tooltipped" data-tooltip="Actualizar">
                            <i class="material-icons">mode_edit</i>
                        </a>
                        <a onclick="openDelete(${row.id_condicion_producto})" class="btn waves-effect red tooltipped" data-tooltip="Eliminar">
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
    // Se asigna titulo a la caja de dialogo
    MODAL_TITLE.textContent = 'Crear Condicion';
    SAVE_MODAL.show();
    SAVE_FORM.reset();
}

async function openUpdate(id)  {
    const FORM = new FormData();
    FORM.append('id', id);
    const JSON = await dataFetch(CONDICION_API, 'readOne', FORM);
    if (JSON.status) {
        SAVE_MODAL.show();
        SAVE_FORM.reset();
        MODAL_TITLE.textContent = 'Actualizar modelo';
        document.getElementById('id').value = JSON.dataset.id_condicion_producto;
        document.getElementById('condicion').value = JSON.dataset.condicion_producto;
        //Se manda a traer la información de la tabla a los controles
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}


async function openDelete(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Estas seguro que quieres eliminar la condicion?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(CONDICION_API, 'delete', FORM);
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
