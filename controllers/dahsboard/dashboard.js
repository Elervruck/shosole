// Constante para completar la ruta de la API.
const PRODUCTO_API = 'business/dashboard/productos.php';
const CLIENTE_API='business/dashboard/cliente.php';
const PEDIDO_API='business/dashboard/pedidos.php';
const USUARIO_API = 'business/dashboard/usuario.php';
const MODELO_API = 'business/dashboard/modelo.php'
// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
   // Se llaman a la funciones que generan los gráficos en la página web.
graficoBarrasmodelo();
graficoUsuariosCargos();
grafioModeloMarcas();
clientesMasPedidos();
});
 

/*
*   Función asíncrona para mostrar en un gráfico de barras para ver el porcentaje de modelo por cada producto.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/

async function graficoBarrasmodelo() {
  // Petición para obtener los datos del gráfico.
  const DATA = await dataFetch(PRODUCTO_API, 'cantidadProductosModelo');
  // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
  if (DATA.status){
      // Se declaran los arreglos para guardar los datos a graficar.
      let modelo = [];
      let existencia = [];
      // Se recorre el conjunto de registros fila por fila a través del objeto row.
      DATA.dataset.forEach(row => {
          // Se agregan los datos a los arreglos.
          modelo.push(row.modelo);
          existencia.push(row.existencia_producto);
      });
      // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
      barGraph('chart1', modelo, existencia, 'Cantidad de productos', 'Cantidad de productos por modelo');
  } else {
      document.getElementById('chart1').remove();
      console.log(DATA.exception);
  }
}



/*
*   Función asíncrona para mostrar en un gráfico de pastel 
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
async function graficoUsuariosCargos() {
  // Petición para obtener los datos del gráfico.
  const DATA = await dataFetch(USUARIO_API, 'usuariosCargosGrafica');
  // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
  if (DATA.status) {
      // Se declaran los arreglos para guardar los datos a gráficar.
      let  cargo = [];
      let  porcentaje = [];
      // Se recorre el conjunto de registros fila por fila a través del objeto row.
      DATA.dataset.forEach(row => {
          // Se agregan los datos a los arreglos.
          cargo.push(row.cargo);
          porcentaje.push(row.porcentaje);
      });
      // Llamada a la función que genera y muestra un gráfico de pastel. Se encuentra en el archivo components.js
      pieGraph('chart2', cargo, porcentaje,'usuarios por cargo', 'clientes que la realizaron');
  } else {
      document.getElementById('chart2').remove();
      console.log(DATA.exception);
  }
} 


async function grafioModeloMarcas() {
  const DATA = await dataFetch(MODELO_API, 'porcentajeModeloConsolas');

  if (DATA.status){

    let modelo = [];
    let porcentaje = [];

    DATA.dataset.forEach(row => {

      modelo.push(row.modelos);
      porcentaje.push(row.porcentaje);
    });

    doughnutGraph('chart3', modelo, porcentaje,'modelos por marcas', 'clientes que la realizaron');
  } else {
      document.getElementById('chart3').remove();
      console.log(DATA.exception);
  }
}


async function graficoUsuariosCargos() {
  // Petición para obtener los datos del gráfico.
  const DATA = await dataFetch(USUARIO_API, 'usuariosCargosGrafica');
  // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
  if (DATA.status) {
      // Se declaran los arreglos para guardar los datos a gráficar.
      let  cargo = [];
      let  porcentaje = [];
      // Se recorre el conjunto de registros fila por fila a través del objeto row.
      DATA.dataset.forEach(row => {
          // Se agregan los datos a los arreglos.
          cargo.push(row.cargo);
          porcentaje.push(row.porcentaje);
      });
      // Llamada a la función que genera y muestra un gráfico de pastel. Se encuentra en el archivo components.js
      pieGraph('chart4', cargo, porcentaje,'usuarios por cargo', 'clientes que la realizaron');
  } else {
      document.getElementById('chart4').remove();
      console.log(DATA.exception);
  }
} 


async function clientesMasPedidos() {
  // Petición para obtener los datos del gráfico.
  const DATA = await dataFetch(CLIENTE_API, 'clientesMasPedidos');
  // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
  if (DATA.status){
      // Se declaran los arreglos para guardar los datos a graficar.
      let nombre = [];
      let total = [];
      // Se recorre el conjunto de registros fila por fila a través del objeto row.
      DATA.dataset.forEach(row => {
          // Se agregan los datos a los arreglos.
          nombre.push(row.nombre_cliente);
          total.push(row.total_pedidos);
      });
      // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
      barGraph('chart5', nombre, total, 'Cantidad de productos', 'Total de pedidos');
  } else {
      document.getElementById('chart5').remove();
      console.log(DATA.exception);
  }
}




/*
*   Función asíncrona para mostrar en un gráfico de linea .
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/



/*
*   Función asíncrona para mostrar en un gráfico de dona .
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
