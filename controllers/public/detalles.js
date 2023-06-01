// Constante para completar la ruta de la API.
const PROD_API = 'business/public/producto.php';
const PED_API = 'business/public/pedido.php';
// Constantes para establecer el contenido principal de la página web.
const COMPRAS = document.getElementById('shopping');
//Constante de tipo objeto para poder obtener los parametros disponibles en la URL
const PARAMS = new URLSearchParams(location.search);

document.addEventListener('DOMContentLoaded', async () => {
    //Constante del tipo objeto de los datos que se selecciona un producto
    const FORM = new FormData();
    FORM.append('id_producto', PARAMS.get('id'));
    //Hacer una petición para soicitar los datos de los porductos que se seleccionan

    const JSON = await dataFetch(PROD_API, 'readOneDel', FORM);
    //Comporbar si se da una respuesta con resultados positivos, sino es el caso mostrara mensaje de excepción
    if (JSON.status) {
        //Vista de la información que se coloca para que se pueda ver en la página web en base al producto seleccionado
        document.getElementById('imagen').src = SERVER_URL.concat('images/productos/', JSON.dataset.imagen_producto);
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
    console.log(JSON)
    //Verificar si la respuesta está bien, en caso contrario se envía un mensaje
    if (JSON.status) {
        sweetAlert(1, JSON.message, true, 'carrito.html');
    } else if (JSON.session) {
        sweetAlert(2, JSON.message, false);
    } else {
        sweetAlert(3, JSON.message, true, 'login.html');
    }
});


//Ya añadi el footer pero siempre da error agregar al carrito
