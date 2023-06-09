// Constante para completar la ruta de la API.
const PROD_API = 'business/public/producto.php';
const PED_API = 'business/public/pedido.php';
// Constantes para establecer el contenido principal de la página web.
const COMPRAS = document.getElementById('shopping');
//Constante de tipo objeto para poder obtener los parametros disponibles en la URL
const PARAMS = new URLSearchParams(location.search);

const VALORACION = document.getElementById('favorito');


document.addEventListener('DOMContentLoaded', async () => {
    //Constante del tipo objeto de los datos que se selecciona un producto
    const FORM = new FormData();
    FORM.append('id_producto', PARAMS.get('id'));
    //Hacer una petición para soicitar los datos de los porductos que se seleccionan

    const JSON = await dataFetch(PROD_API, 'readOneDel', FORM);
    //Comporbar si se da una respuesta con resultados positivos, sino es el caso mostrara mensaje de excepción
    if (JSON.status) {
        //Vista de la información que se coloca para que se pueda ver en la página web en base al producto seleccionado
        document.getElementById('imagen').src = SERVER_URL.concat('imagenes/productos', JSON.dataset.imagen_producto);
        document.getElementById('condicion').textContent = JSON.dataset.condicion_producto;
        document.getElementById('detalle_descripcion').textContent = JSON.dataset.descripcion_producto;
        document.getElementById('nombreproducto').textContent = JSON.dataset.nombre_producto;
        document.getElementById('precio_pro').textContent = JSON.dataset.precio_producto;
        document.getElementById('idpro').value = JSON.dataset.id_producto;


    } else {
        //Limpia el contenido cuando no hayan datos que se puedan mostrar
        document.getElementById('condetalle').innerHTML = '';
    }
});



//Método para uso del formulario cuando se quiera agreagr un producto
COMPRAS.addEventListener('submit', async (event) => {
    //Evita cargar la página web después de enviar el formulario.
    event.preventDefault();
    //Constante de tipo objeto que tiene los datos del formulario.
    const FORM = new FormData(COMPRAS);
    //Hacer una petición para guardar la información del formulario
    const JSON = await dataFetch(PED_API, 'createDetail', FORM);
    //Verificar si la respuesta está bien, en caso contrario se envía un mensaje
    if (JSON.status) {
        sweetAlert(1, JSON.message, true, 'carrito.html');
    } else if (JSON.session) {
        sweetAlert(2, JSON.message, false);
    } else {
        sweetAlert(3, JSON.message, true, 'login.html');
    }
});


document.addEventListener('DOMContentLoaded', async () => {
    // Se define un objeto con los datos de la categoría seleccionada.
    const FORM = new FormData();
    FORM.append('id_producto', PARAMS.get('id'));
    // Petición para solicitar los productos de la categoría seleccionada.
    const JSON = await dataFetch(PROD_API, 'cargarComentarios', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se inicializa el contenedor de productos.
        VALORACION.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las tarjetas con los datos de cada producto.
            VALORACION.innerHTML += `
            <div  class="card col-12">
                    <div class="card-body">
                    <h5 class="card-title">nombre:${row.nombre_cliente}</h5>
                        <h5 class="card-title">fecha del comentario:${row.fecha_comentario}</h5>
                        <h5 class="card-title"></h5>
                        <h5 class="card-title">Calificacion producto:${row.calificacion_producto}</h5>
                        <h5 class="card-title"></h5>
                        <h5 class="card-title">Comentario:${row.comentario_producto}</h5>
                        <h4 id="precios_libros"></h4>
                    </div>
                </div>
        `;
        });
        // Se asigna como título la categoría de los productos.
        TITULO.textContent = PARAMS.get('nombre');

    } else {
        // Se presenta un mensaje de error cuando no existen datos para mostrar.
        TITULO.textContent = JSON.exception;
    }
});