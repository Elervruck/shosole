// Constante para completar la ruta de la API.
const PEDIDO_API = 'business/public/pedido.php';
// Constante para establecer el formulario de cambiar producto.
const ITEM_FORM = document.getElementById('item-form');
// Constante para establecer el cuerpo de la tabla.
const TBODY_ROWS = document.getElementById('tbody-rows');
// Constante tipo objeto para establecer las opciones del componente Modal.
const OPTIONS = {
    dismissible: false
}
const ITEM_MODAL = new bootstrap.Modal(document.getElementById('item-modal'));

let cantidadM = null;
let productoM = null

document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para mostrar los productos del carrito de compras.
    readOrderDetail();
});


async function readOrderDetail() {
    // Petición para obtener los datos del pedido en proceso.
    const JSON = await dataFetch(PEDIDO_API, 'readOrderDetail');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se inicializa el cuerpo de la tabla.
        TBODY_ROWS.innerHTML = '';
        // Se declara e inicializa una variable para calcular el importe por cada producto.
        let subtotal = 0;
        // Se declara e inicializa una variable para sumar cada subtotal y obtener el monto final a pagar.
        let total = 0;
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
            subtotal = row.precio_total * row.cantidad_producto;
            total += subtotal;
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
                <tr>
                    <td>${row.nombre_producto}</td>
                    <td>${row.precio_total}</td>
                    <td>${row.cantidad_producto}</td>
                    <td>${subtotal.toFixed(2)}</td>
                    <td>
                    <a onclick="openUpdate(${row.id_detalle_pedido}, ${row.cantidad_producto}, ${row.id_producto})" class="btn waves-effect blue tooltipped" data-tooltip="Cambiar">
                        <i class="material-icons">exposure</i>
                    </a>
                    <a onclick="openDelete(${row.id_detalle_pedido}, ${row.cantidad_producto}, ${row.id_producto})" class="btn waves-effect red tooltipped" data-tooltip="Remover">
                        <i class="material-icons">remove_shopping_cart</i>
                    </a>
                </td>
                </tr>
            `;
        });
        // Se muestra el total a pagar con dos decimales.
        document.getElementById('pago').textContent = total.toFixed(2);
        
    } else {
        sweetAlert(4, JSON.exception, false, 'index.html');
    }
}
// Método manejador de eventos para cuando se envía el formulario de cambiar cantidad de producto.
ITEM_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(ITEM_FORM);
<<<<<<< HEAD
<<<<<<< HEAD
=======
    //obteniendo el valor de la cantidad a modificar
    mod = document.getElementById('cantidad').value;
    debugger
    if(mod > cantidadM){
        debugger
        mod = Number(cantidadM) + Number(mod);
        FORM.append('cantidad_cambio', mod);
    }else if(mod < cantidadM){
        debugger
        mod = Number(cantidadM) - Number(mod);
        FORM.append('cantidad_cambio', mod*-1);
    }
    FORM.append('id_producto', productoM);
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
=======
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
    // Petición para actualizar la cantidad de producto.
    const JSON = await dataFetch(PEDIDO_API, 'updateDetail', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se actualiza la tabla para visualizar los cambios.
        readOrderDetail();
        // Se cierra la caja de diálogo del formulario.
        ITEM_MODAL.hide();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});



function openUpdate(id, quantity, producto) {
    // Se abre la caja de diálogo que contiene el formulario.
    ITEM_MODAL.show();
    // Se inicializan los campos del formulario con los datos del registro seleccionado.
    document.getElementById('id_detalle').value = id;
<<<<<<< HEAD
<<<<<<< HEAD
    document.getElementById('cantidad_actual').value = quantity;
    document.getElementById('cantidad_nueva').value = quantity;
    document.getElementById('id_producto').value = producto;
=======
    document.getElementById('cantidad').value = quantity;
    cantidadM = quantity;
    productoM = producto;
   //
   
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
=======
    document.getElementById('cantidad_actual').value = quantity;
    document.getElementById('cantidad_nueva').value = quantity;
    document.getElementById('id_producto').value = producto;
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
}


async function finishOrder() {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Está seguro de finalizar el pedido?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Petición para finalizar el pedido en proceso.
        const JSON = await dataFetch(PEDIDO_API, 'finishOrder');
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            sweetAlert(1, JSON.message, true, 'index.html');
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}


async function openDelete(id, cantidad, producto) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Está seguro de remover el producto?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define un objeto con los datos del producto seleccionado.
        const FORM = new FormData();
        FORM.append('id_detalle', id);
        FORM.append('cantidad', cantidad);
        FORM.append('id_producto', producto);
        // Petición para eliminar un producto del carrito de compras.
        const JSON = await dataFetch(PEDIDO_API, 'deleteDetail', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            // Se carga nuevamente la tabla para visualizar los cambios.
            readOrderDetail();
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}