// Constante para completar la ruta de la API.
const PRODUCTO_API = 'business/dashboard/productos.php';
const CLIENTE_API = 'business/dashboard/cliente.php';
const PEDIDO_API = 'business/dashboard/pedidos.php';
const USUARIO_API = 'business/dashboard/usuario.php';
const MODELO_API = 'business/dashboard/modelo.php'
// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Se llaman a la funciones que generan los gráficos en la página web.
    graficoProductosModelo();
    graficoPedidosEstado();
    graficoModelosMarca();
    graficoUsuariosCargo();
    graficoClientesPedidos();
});


/*
*   Función asíncrona para mostrar en un gráfico de barras para ver el cantidades de modelos por cada producto.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/

async function graficoProductosModelo() {
    // Petición para obtener los datos del gráfico.
    const DATA = await dataFetch(PRODUCTO_API, 'cantidadProductosModelo');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let modelos = [];
        let cantidades = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            modelos.push(row.modelo);
            cantidades.push(row.cantidad);
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        barGraph('chart1', modelos, cantidades, 'Cantidad de productos', 'Cantidad de productos por modelo');
    } else {
        document.getElementById('chart1').remove();
        console.log(DATA.exception);
    }
}

//* gráfico  de dona para mostrar el estado de los pedidos

async function graficoPedidosEstado() {
    // Petición para obtener los datos del gráfico.
    const DATA = await dataFetch(PEDIDO_API, 'obtenerPedidosEstado');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
     // Se declaran los arreglos para guardar los datos a graficar.
        let modelos = [];
        let cantidades = [];
         // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            modelos.push(row.estados_pedido);
            cantidades.push(row.cantidad);
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        doughnutGraph('chart2', modelos, cantidades, 'Cantidad de pedidos por estado');
    } else {
        document.getElementById('chart2').remove();
        console.log(DATA.exception);
    }
}

//* gráfico  de dona para mostrar el  porcentaje de los modelos por marca
async function graficoModelosMarca() {
    // Petición para obtener los datos del gráfico.
    const DATA = await dataFetch(MODELO_API, 'porcentajeModelosMarca');
// Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
// Se declaran los arreglos para guardar los datos a graficar.
        let marcas = [];
        let porcentajes = [];
// Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            marcas.push(row.marca);
            porcentajes.push(row.porcentaje);
        });
 // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        doughnutGraph('chart3', marcas, porcentajes, 'Porcentaje de modelos por marca');
    } else {
        document.getElementById('chart3').remove();
        console.log(DATA.exception);
    }
}

//* gráfico  de pastel para mostrar el  porcentaje de los usuarios por cargo
async function graficoUsuariosCargo() {
    // Petición para obtener los datos del gráfico.
    const DATA = await dataFetch(USUARIO_API, 'usuariosCargoGrafica');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a gráficar.
        let cargos = [];
        let porcentajes = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            cargos.push(row.cargo);
            porcentajes.push(row.porcentaje);
        });
        // Llamada a la función que genera y muestra un gráfico de pastel. Se encuentra en el archivo components.js
        pieGraph('chart4', cargos, porcentajes, 'Porcentaje de usuarios por cargo');
    } else {
        document.getElementById('chart4').remove();
        console.log(DATA.exception);
    }
}

//* gráfico  de  barras para mostrar  los clientes con mas pedidios

async function graficoClientesPedidos() {
    // Petición para obtener los datos del gráfico.
    const DATA = await dataFetch(CLIENTE_API, 'graficoPedidosCliente');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let clientes = [];
        let pedidos = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            clientes.push(row.usuario_cliente);
            pedidos.push(row.pedidos);
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        barGraph('chart5', clientes, pedidos, 'Cantidad de productos', 'Top 5 de clientes con más pedidos');
    } else {
        document.getElementById('chart5').remove();
        console.log(DATA.exception);
    }
}

