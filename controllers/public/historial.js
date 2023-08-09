<<<<<<< HEAD
// Constante para completar la ruta de la API.
=======
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
const PEDIDO_API= 'business/public/pedido.php';

const PARAMS = new URLSearchParams(location.search);
const HISTORIAL = document.getElementById('historial');

document.addEventListener('DOMContentLoaded', async () => {
    // Se define un objeto con los datos de la categoría seleccionada.
    const FORM = new FormData();
    FORM.append('id_pedido', PARAMS.get('id'));
    // Petición para solicitar los productos de la categoría seleccionada.
    const JSON = await dataFetch(PEDIDO_API, 'cargarHistorial',  FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se inicializa el contenedor de productos.
        HISTORIAL.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
                 // Se crean y concatenan las tarjetas con los datos de cada producto.
<<<<<<< HEAD
            HISTORIAL.innerHTML += `
=======
          HISTORIAL.innerHTML += `
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
            <div class="card-compra my-5 ">
                <div class="content-compra">
                    <div class="title">${row.fecha_pedido}</div>
                    <div class="price">${row.estados_pedido}</div>
                    <div class="description">${row.direccion_pedido}</div>
                </div>
                    <button class="vercompra">
                    <a class="buttonpre" href="detallecompra.html?id=${row.id_pedido}">Ver compra</a>
                    </button>
            </div>
        `;
        });
    } 
});