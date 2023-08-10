<<<<<<< HEAD
<<<<<<< HEAD
// Constante para completar la ruta de la API.
=======
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
=======
// Constante para completar la ruta de la API.
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
const PEDIDO_API = 'business/public/pedido.php';
const VALO_API = 'business/public/valoracion.php';
const PARAMS = new URLSearchParams(location.search);


const VERCOMPRA = document.getElementById('vercompra');
<<<<<<< HEAD
<<<<<<< HEAD
//Constante para guardar el formulario
const SAVE_FORM = document.getElementById('save-form');
//Constante para guardar el modal
=======
const SAVE_FORM = document.getElementById('save-form');
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
=======
//Constante para guardar el formulario
const SAVE_FORM = document.getElementById('save-form');
//Constante para guardar el modal
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
const SAVE_MODAL = new bootstrap.Modal(document.getElementById('agregarvalo'));



document.addEventListener('DOMContentLoaded', async () => {
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
    // Se define un objeto con los datos de la categoría seleccionada.
    const FORM = new FormData();
    FORM.append('id_pedido', PARAMS.get('id'));

    ProductosCompra(FORM);

});

async function ProductosCompra(form) {
    const JSON = await dataFetch(PEDIDO_API, 'cargarVerCompra', form);
    if (JSON.status) {
        JSON.dataset.forEach(async (row) => {

            const FORM = new FormData();
            FORM.append('id_detpedido', row.id_detalle_pedido);
            const JSONVALO = await dataFetch(VALO_API, 'validarComentarios', FORM);
            // const JSONDP = await dataFetch(VALO_API, 'validarComentarios', FORM);
            if (row.estados_pedido == 'Entregado') {
                if (JSONVALO.dataset === false) {

                    VERCOMPRA.innerHTML += `
<<<<<<< HEAD
=======
// Se define un objeto con los datos de la categoría seleccionada.
const FORM = new FormData();
FORM.append('id_pedido', PARAMS.get('id'));

ProductosCompra(FORM);

});

    async function ProductosCompra(form) {
    const JSON = await dataFetch(PEDIDO_API, 'cargarVerCompra', form);
    if (JSON.status) {
    JSON.dataset.forEach(async (row) => {

    const FORM = new FormData();
    FORM.append('id_detpedido', row.id_detalle_pedido);
    const JSONVALO = await dataFetch(VALO_API, 'validarComentarios', FORM);
    // const JSONDP = await dataFetch(VALO_API, 'validarComentarios', FORM);
    if (row.estados_pedido == 'Entregado') {
    if (JSONVALO.dataset === false) {

        VERCOMPRA.innerHTML += `
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
=======
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
        <div class="card">
        <div class="infos">
            <div class="image"><img src="${SERVER_URL}imagenes/productos/${row.imagen_producto}"></div>
            <div class="info">
                <div>
                    <p class="name">
                    ${row.nombre_producto}
                    </p>
                    <p class="function">
                    ${row.descripcion_producto}
                    </p>
                </div>
                <div class="stats">
                        <p class="flex flex-col">
                            Cantidad pedida
                            <span class="state-value">
                            ${row.cantidad_producto}
                            </span>
                        </p>
                        <p class="flex">
                            Precio unitario
                            <span class="state-value">
                            ${row.precio_producto}
                            </span>
                        </p>
                        
                </div>
            </div>
        </div>
        <button class="request" type="button" data-bs-target="#agregarvalo"  onclick="openCreate(${row.id_pedido}, ${row.id_detalle_pedido})">
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
            Comentar
            </button>
        </div>
        `;
                } else {
                    VERCOMPRA.innerHTML += `
<<<<<<< HEAD
=======
              Comentar
            </button>
        </div>


        `;

    }else{
        VERCOMPRA.innerHTML += `
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
=======
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
        <div class="card">
        <div class="infos">
            <div class="image"><img src="${SERVER_URL}imagenes/productos/${row.imagen_producto}"></div>
            <div class="info">
                <div>
                    <p class="name">
                    ${row.nombre_producto}
                    </p>
                    <p class="function">
                    ${row.condicion_producto}
                    </p>
                </div>
                <div class="stats">
                        <p class="flex flex-col">
                            Cantidad:
                            <span class="state-value">
                            ${row.cantidad_producto}
                            </span>
                        </p>
                        <p class="flex">
                            Precio uni:
                            <span class="state-value">
                            ${row.precio_total}
                            </span>
                        </p>
                        
                </div>
            </div>
        </div>
        <button class="request" type="button">
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
            Comentado
            </button>
        </div>
        `;
                }
            }
            else {
                VERCOMPRA.innerHTML += `
<<<<<<< HEAD
=======
              Comentado
            </button>
        </div>
        `;
    }


    

    }
    else {
        VERCOMPRA.innerHTML += `
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
=======
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
        <div class="card">
            <div class="infos">
                <div class="image"><img src="${SERVER_URL}imagenes/productos/${row.imagen_producto}"></div>
                <div class="info">
                    <div>
                        <p class="name">
                        ${row.nombre_producto}
                        </p>
                        <p class="function">
                        ${row.condicion_producto}
                        </p>
                    </div>
                    <div class="stats">
                            <p class="flex flex-col">
                                Cantidad:
                                <span class="state-value">
                                ${row.cantidad_producto}
                                </span>
                            </p>
                            <p class="flex">
                                Precio uni:
                                <span class="state-value">
                                ${row.precio_total}
                                </span>
                            </p>
                            
                    </div>
                </div>
            </div>
        </div>
        `;
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
            }
        })
    }
}

SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const JSON = await dataFetch(VALO_API, 'createValoComentario', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se cierra la caja de diálogo.
        SAVE_MODAL.hide();

        // Se muestra un mensaje de éxito.
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
<<<<<<< HEAD
=======
    }
    })
    }
    }

SAVE_FORM.addEventListener('submit', async (event) => {
// Se evita recargar la página web después de enviar el formulario.
event.preventDefault();
// Constante tipo objeto con los datos del formulario.
const FORM = new FormData(SAVE_FORM);
// Petición para guardar los datos del formulario.
const JSON = await dataFetch(VALO_API, 'createValoComentario', FORM);
// Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
if (JSON.status) {
// Se cierra la caja de diálogo.
SAVE_MODAL.hide();

// Se muestra un mensaje de éxito.
sweetAlert(1, JSON.message, true);
} else {
sweetAlert(2, JSON.exception, false);
}
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
=======
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
});

function openCreate(id_pedido, id_detalle_pedido) {

    SAVE_MODAL.show();
    document.getElementById('id').value = id_pedido;
    document.getElementById('iddetallepedido').value = id_detalle_pedido;
<<<<<<< HEAD
<<<<<<< HEAD

}
=======
    
    }
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
=======

}
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b

