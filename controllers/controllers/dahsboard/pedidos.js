const PEDIDO_API = 'business/dashboard/pedidos.php';
const CLIENTE_API = 'business/dashboard/cliente.php';
const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');
// //Constante para cambiarle el titulo a el modal
const MODAL_TITLE = document.getElementById('modal-title');
const SAVE_MODAL = new bootstrap.Modal(document.getElementById('pedido'));

// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('search-form');
// Constantes para cuerpo de la tabla
const SAVE_FORM = document.getElementById('save-form');
/*Constantes para detalle pedido*/
const TPEDIDO_ROWS = document.getElementById('tbodydp');
const REPEDIDO = document.getElementById('recodp');
const DETALLAP_MODAL = new bootstrap.Modal(document.getElementById('depepedido'));

//Método para que cargue graficamente la tabla
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

SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const JSON = await dataFetch(PEDIDO_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        SAVE_MODAL.hide();
        // Se carga nuevamente la tabla para visualizar los cambios.
        fillTable();
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
    const JSON = await dataFetch(PEDIDO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {

            (row.estado_pedido) ? icon = 'visibility' : icon = 'visibility_off';
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
            <tr>
                <td>${row.nombre_cliente}</td>
                <td>${row.fecha_pedido}</td>
                <td>${row.direccion_pedido}</td>
                <td><i class="material-icons">${icon}</i></td>
                <td>

                    <a onclick="openUpdate(${row.id_pedido})" class="btn waves-effect blue tooltipped" data-tooltip="Actualizar">
                        <i class="material-icons">mode_edit</i>
                    </a>
                    <a onclick="openDelete(${row.id_pedido})" class="btn waves-effect red tooltipped" data-tooltip="Eliminar">
                        <i class="material-icons">delete</i>
                    </a>
                    <a onclick="fillTableDetallePedido(${row.id_pedido})" class="btn waves-effect blue tooltipped" data-tooltip="Actualizar">
                        <i class="material-icons">list_alt</i>
                    </a>

                </td>
            </tr>
            `;
        });

        RECORDS.textContent = JSON.message;
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}

function openCreate() {

    SAVE_FORM.reset();
    
    fillSelect(CLIENTE_API, 'readAll', 'cliente', 'Seleccione un cliente');
    // Se asigna título a la caja de diálogo.
    MODAL_TITLE.textContent = 'Crear pedido';

}

async function openUpdate(id) {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id_pedido', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(PEDIDO_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        SAVE_MODAL.show();
        // Se asigna título para la caja de diálogo.
        MODAL_TITLE.textContent = 'Actualizar pedido';
        // Se inicializan los campos del formulario.
        document.getElementById('id').value = JSON.dataset.id_pedido;
        document.getElementById('fecha').value = JSON.dataset.fecha_pedido;
        document.getElementById('direccion').value = JSON.dataset.direccion_pedido;
        fillSelect (CLIENTE_API, 'readAll', 'cliente','Seleccione un cliente', JSON.dataset.id_cliente);
        if (JSON.dataset.estado_pedido) {
            document.getElementById('estado').checked = true;
        } else {
            document.getElementById('estado').checked = false;
        }
    
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

async function openDelete(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar el pedido de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_pedido', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(PEDIDO_API, 'delete', FORM);
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

async function fillTableDetallePedido(id) {
    // Se inicializa el contenido de la tabla.
    TPEDIDO_ROWS.innerHTML = '';
    REPEDIDO.textContent = '';

    const FORM = new FormData();
    FORM.append('id_pedido', id);
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(PEDIDO_API, 'readAllDetalle', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            DETALLAP_MODAL.show();
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TPEDIDO_ROWS.innerHTML += `
            <tr>
                <td>${row.id_detalle_pedido}</td>
                <td>${row.nombre_cliente}</td>
                <td>${row.nombre_producto}</td>
                <td>${row.cantidad_producto}</td>
                <td>${row.precio_producto}</td>
                <td>
                </td>
            </tr>
            `;
        });

        REPEDIDO.textContent = JSON.message;
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}