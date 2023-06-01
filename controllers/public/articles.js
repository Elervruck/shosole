// Constante para completar la ruta de la API.
const PRODUCTO_API = 'business/public/producto.php';
// Constante tipo objeto para obtener los parámetros disponibles en la URL.
const PARAMS = new URLSearchParams(location.search);
// Constantes para establecer el contenido principal de la página web.
const PRODUCTOS = document.getElementById('productos');

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Se define un objeto con los datos de la categoría seleccionada.
    const FORM = new FormData();
    FORM.append('id_producto', PARAMS.get('id'));
    // Petición para solicitar los productos de seleccionada.
    const JSON = await dataFetch(PRODUCTO_API, 'readAllProductos', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se inicializa el contenedor de productos.
        PRODUCTOS.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las tarjetas con los datos de cada producto.
            PRODUCTOS.innerHTML += `
            <div class="card g-col-6">
                <div class="card-img">
                    <img src="${SERVER_URL}images/productos/${row.imagen_producto}" alt="holaaaaaaaa        " class="w-100 h-100">
                </div>
            <div class="card-info">
                <p class="text-title"${row.nombre_producto}> </p>
                <p class="text-body">Product description and details</p>
                <a href="detalle_productos.html?id=${row.id_producto}" class="bg-info">Agregar a carrito</a>
            </div>
            <div class="card-footer">
                <span class="text-title">$${row.precio_producto}</span>
                <div class="card-button">
                <a href="detalle_productos.html?id=${row.id_producto}">
                   <button id=${row.id_producto}" class="">Ver detalles</button>
                   </a>
                </div>
            </div>
        </div>
            
            `;
        });
        // Se asigna como título la categoría de los productos.
        // Se inicializa el componente Material Box para que funcione el efecto Lightbox.
    } else {
        // Se presenta un mensaje de error cuando no existen datos para mostrar.
    }
});