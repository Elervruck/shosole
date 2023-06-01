const PEDIDO_API = 'business/public/pedido.php';

const ITEN_FORM = document.getElementById('item-form');

const TBODY_ROWS = document.getElementById('tbody-rows');

const OPTIONS = {
    dismissible: false
}

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
            subtotal = row.precio_producto * row.cantidad_producto;
            total += subtotal;
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
                <tr>
                    <td>${row.nombre_producto}</td>
                    <td>${row.precio_producto}</td>
                    <td>${row.cantidad_producto}</td>
                    <td>${subtotal.toFixed(2)}</td>
                    <td>
                        <a onclick="openUpdate(${row.id_detalle}, ${row.cantidad_producto})" class="btn waves-effect blue tooltipped" data-tooltip="Cambiar">
                            <i class="material-icons">exposure</i>
                        </a>
                        <a onclick="openDelete(${row.id_detalle})" class="btn waves-effect red tooltipped" data-tooltip="Remover">
                            <i class="material-icons">remove_shopping_cart</i>
                        </a>
                    </td>
                </tr>
            `;
        });
        // Se muestra el total a pagar con dos decimales.
        document.getElementById('pago').textContent = total.toFixed(2);
        // Se inicializa el componente Tooltip para que funcionen las sugerencias textuales.
        M.Tooltip.init(document.querySelectorAll('.tooltipped'));
    } else {
        sweetAlert(4, JSON.exception, false, 'index.html');
    }
}
