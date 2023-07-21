const PRODUCTO_API = 'business/dashboard/productos.php';
const USUARIOP_API = 'business/dashboard/usuario.php';
const MODELO_API = 'business/dashboard/modelo.php';

//Constante para cambiarle el titulo a el modal
const MODAL_TITLE = document.getElementById('modal-title');

const SAVE_MODAL = new bootstrap.Modal(document.getElementById('producto'));

const VALO_MODAL = new bootstrap.Modal(document.getElementById('calificaciones'));

const SEARCH_FORM = document.getElementById('search-form');
// Constantes para cuerpo de la tabla
const TBODY_ROWS = document.getElementById('tbody-rows');
// //VALO
const TBODYVALO_ROWS = document.getElementById('tbody-rowsv');
const RECORDSVALO = document.getElementById('recordsv');
// //
const RECORDS = document.getElementById('records');
const SAVE_FORM = document.getElementById('save-form');

// const SEARCH_FORM = document.getElementById('search-form');

document.addEventListener('DOMContentLoaded', () => {
    // Llama la tabla
    fillTable();
});

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
    const JSON = await dataFetch(PRODUCTO_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se cierra la caja de diálogo.
        SAVE_MODAL.hide();
        // Se carga nuevamente la tabla para visualizar los cambios.
        fillTable();

        // Se muestra un mensaje de éxito.
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});

function openCreate() {

    SAVE_MODAL.show();
    SAVE_FORM.reset();
    fillSelect(USUARIOP_API, 'readAll', 'usuario', 'Seleccione un usuario');
    fillSelect(PRODUCTO_API, 'readCondicion', 'condicion', 'Seleccione una condicion');
    fillSelect(MODELO_API, 'readAll', 'modelo', 'Seleccione un modelo');
    // Se asigna título a la caja de diálogo.
    MODAL_TITLE.textContent = 'Crear producto';

}

async function fillTable(form = null) {
    // Activa el contenido de la tabla
    TBODY_ROWS.innerHTML = '';
    RECORDS.textContent = '';
    // Se verifica lo que se va a hacer
    (form) ? action = 'search' : action = 'readAll';
    // Pide los datos obtenidos
    const JSON = await dataFetch(PRODUCTO_API, action, form);
    // Se comprueba la respuesta que no tenga error
    if (JSON.status) {
        // Se recorren filas por filas
        JSON.dataset.forEach(row => {

            (row.estado_producto) ? icon = 'visibility' : icon = 'visibility_off';
            // Se crean las filas
            TBODY_ROWS.innerHTML += `
            <tr>

                <td><img src="${SERVER_URL}images/productos/${row.imagen_producto}" class="materialboxed" height="100"></td>
                <td>${row.nombre_producto}</td>
                <td>${row.descripcion_producto}</td>
                <td>${row.modelo}</td>
                <td>${row.condicion_producto}</td>
                <td><i class="material-icons">${icon}</i></td>
                <td>${row.existencia_producto}</td>
                <td>${row.precio_producto}</td>
                <td>${row.correo_usuario}</td>
                <td>

                    <a onclick="openUpdate(${row.id_producto})" class="btn waves-effect blue tooltipped" data-tooltip="Actualizar">
                        <i class="material-icons">mode_edit</i>
                    </a>
                    <a onclick="openDelete(${row.id_producto})" class="btn waves-effect red tooltipped" data-tooltip="Eliminar">
                        <i class="material-icons">delete</i>
                    </a>
                    <a onclick="fillTableValoracion(${row.id_producto})" class="btn waves-effect red tooltipped" data-tooltip="Valoracion">
                    <i class="material-icons">reviews</i>
                    </a>
                    <a class="btn waves-effect red tooltipped" data-tooltip="Eliminar">
                    <i class="material-icons">assignment</i>
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

async function openDelete(id) {
    //Muestra el mesaje y captura la respuesta
    const RESPONSE = await confirmAction('¿Desea eliminar el producto de forma permanente?');
    // Verifica mensaje
    if (RESPONSE) {
        // Crea una constante con los datos que se han selecionado
        const FORM = new FormData();
        FORM.append('id_producto', id);
        // Pide para eliminar el registro selecionado
        const JSON = await dataFetch(PRODUCTO_API, 'delete', FORM);
        //Si no hay error arroja una respuesta de lo contrario arroja otra
        if (JSON.status) {
            // Se carga la tabla
            fillTable();
            // Se muestra un mensaje de éxito.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}

async function openUpdate(id) {
    // Se define un objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(PRODUCTO_API, 'readOne', FORM);

    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {

        // Se abre la caja de diálogo que contiene el formulario.
        SAVE_MODAL.show();
        // Se asigna el título para la caja de diálogo (modal).
        MODAL_TITLE.textContent = 'Actualizar producto';
        // Se establece el campo de archivo como opcional.
        document.getElementById('archivo').required = false;
        // Se inicializan los campos del formulario.
        document.getElementById('id').value = JSON.dataset.id_producto;
        document.getElementById('nombre').value = JSON.dataset.nombre_producto;
        document.getElementById('existencia').value = JSON.dataset.existencia_producto;
        document.getElementById('precio').value = JSON.dataset.precio_producto;
        document.getElementById('descripcion').value = JSON.dataset.descripcion_producto;
        fillSelect(USUARIOP_API, 'readAll', 'usuario','Elija un usuario', JSON.dataset.id_usuario);
        fillSelect(MODELO_API, 'readAll', 'modelo', 'Elije un módelo' ,JSON.dataset.id_modelo);
        if (JSON.dataset.estado_producto) {
            document.getElementById('estado').checked = true;
        } else {
            document.getElementById('estado').checked = false;
        }
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

// //document.querySelector('.custom-file-input').addEventListener('change', function (e) {
// // var name = document.getElementById("archivo").files[0].name;
// // var nextSibling = e.target.nextElementSibling ;
// // nextSibling.innerText = name });

// //Metdodo para valoracion

async function fillTableValoracion(id) {
    // Se inicializa el contenido de la tabla.
    TBODYVALO_ROWS.innerHTML = '';
    RECORDSVALO.textContent = '';
    const FORM = new FormData();
    FORM.append('id_producto', id);
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(PRODUCTO_API, 'readAllValoracion', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        VALO_MODAL.show();
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            (row.estado_comentario) ? icon = 'visibility' : icon = 'visibility_off';

            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODYVALO_ROWS.innerHTML += `
            <tr>
                    <td>${row.calificacion_producto}</td>
                    <td>${row.fecha_comentario}</td>
                    <td>${row.comentario_producto}</td>
                    <td><i class="material-icons">${icon}</i></td>
                    <td>


                    <button class="cta" onclick="openDeleteValo(${row.id_valoracion})" >
                    <span>Modificar</span>
                    <svg viewBox="0 0 13 10" height="10px" width="15px">
                        <path d="M1,5 L11,5"></path>
                        <polyline points="8 1 12 5 8 9"></polyline>
                    </svg>
                    </button>

                    </td>
            </tr>`;
        });

        RECORDSVALO.textContent = JSON.message;
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}


async function openDeleteValo(id) {
    console.log(id);
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea cambiar el estado de la valoracion?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_valoracion', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(PRODUCTO_API, 'deleteValo', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            // Se carga nuevamente la tabla para visualizar los cambios.
            fillTableValoracion(id);
            // Se muestra un mensaje de éxito.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}

function openReport() {
    const PATH = new URL(`${SERVER_URL}reports/dashboard/productos.php`)

    window.open(PATH.href);

}