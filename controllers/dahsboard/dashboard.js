// Constante para completar la ruta de la API.
const PRODUCTO_API = 'business/dashboard/productos.php';
const CLIENTE_API='business/dashboard/clientes.php';
const PEDIDO_API='business/dashboard/pedidos.php';
// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
   // Se llaman a la funciones que generan los gráficos en la página web.
graficoBarrasmodelo();
graficoPastelCategorias();
graficolinea();
graficodona();
grafipolararea();
});
function updateClock() {
    const clock = document.querySelector('.clock');
    const hoursSpan = document.getElementById('hours');
    const minutesSpan = document.getElementById('minutes');
    const secondsSpan = document.getElementById('seconds');
  
    const now = new Date();
    const hours = now.getHours();
    const minutes = now.getMinutes();
    const seconds = now.getSeconds();
  
    hoursSpan.textContent = hours < 10 ? '0' + hours : hours;
    minutesSpan.textContent = minutes < 10 ? '0' + minutes : minutes;
    secondsSpan.textContent = seconds < 10 ? '0' + seconds : seconds;

  }
  setInterval(updateClock, 1000);
 

/*
*   Función asíncrona para mostrar en un gráfico de barras para ver el porcentaje de modelo por cada producto.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/

async function graficoBarrasmodelo() {
  // Petición para obtener los datos del gráfico.
  const DATA = await dataFetch(PRODUCTO_API, 'porcentajeProductosModelo');
  // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
  if (DATA.status){
      // Se declaran los arreglos para guardar los datos a graficar.
      let Modelo = [];
      let Porcentaje = [];
      // Se recorre el conjunto de registros fila por fila a través del objeto row.
      DATA.dataset.forEach(row => {
          // Se agregan los datos a los arreglos.
          Modelo.push(row.modelo);
          Porcentaje.push(row.porcentaje);
      });
      // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
      barGraph('chart1', Modelo, Porcentaje, 'Cantidad de productos', 'Cantidad de productos por modelo');
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
async function graficoPastelmavendidos() {
  // Petición para obtener los datos del gráfico.
  const DATA = await dataFetch(CLIENTE_API,'ordenesporcliente');
  // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
  if (DATA.status) {
      // Se declaran los arreglos para guardar los datos a gráficar.
      let  orden= [];
      let  cliente= [];
      // Se recorre el conjunto de registros fila por fila a través del objeto row.
      DATA.dataset.forEach(row => {
          // Se agregan los datos a los arreglos.
          orden.push(row.id_cliente);
        cliente.push(row.id_pedido);
      });
      // Llamada a la función que genera y muestra un gráfico de pastel. Se encuentra en el archivo components.js
      pieGraph('chart2',orden,cliente,'ordenes realizas', 'clientes que la realizaron');
  } else {
      document.getElementById('chart2').remove();
      console.log(DATA.exception);
  }
} 

/*
*   Función asíncrona para mostrar en un gráfico de linea .
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
async function graficolinea() {
  // Petición para obtener los datos del gráfico.
  const DATA = await dataFetch(PEDIDO_API, 'fechasderealizaciondeordene');
  // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
  if (DATA.status) {
      // Se declaran los arreglos para guardar los datos a gráficar.
      let fechas = [];
      let clientes = [];
      // Se recorre el conjunto de registros fila por fila a través del objeto row.
      DATA.dataset.forEach(row => {
          // Se agregan los datos a los arreglos.
        fechas.push(row.fecha_pedido);
        cliente.push(row.id_cliente);
      });
      // Llamada a la función que genera y muestra un gráfico de pastel. Se encuentra en el archivo components.js
      pieGraph('chart3',fechas,cliente, 'fechas','cliente que la realizo');
  } else {
      document.getElementById('chart3').remove();
      console.log(DATA.exception);
  }
} 

/*
*   Función asíncrona para mostrar en un gráfico de dona .
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
async function graficodona() {
    // Petición para obtener los datos del gráfico.
    const DATA = await dataFetch(PRODUCTO_API, '');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a gráficar.
        let  = [];
        let  = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            .push(row.);
            .push(row.);
        });
        // Llamada a la función que genera y muestra un gráfico de pastel. Se encuentra en el archivo components.js
        pieGraph('chart4', categorias, porcentajes, '');
    } else {
        document.getElementById('chart4').remove();
        console.log(DATA.exception);
    }
  } 

  /*
*   Función asíncrona para mostrar en un gráfico de areapolar .
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
async function grafipolararea() {
    // Petición para obtener los datos del gráfico.
    const DATA = await dataFetch(PRODUCTO_API, '');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a gráficar.
        let  = [];
        let  = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            .push(row.);
            .push(row.);
        });
        // Llamada a la función que genera y muestra un gráfico de pastel. Se encuentra en el archivo components.js
        pieGraph('chart5', ,, '');
    } else {
        document.getElementById('chart5').remove();
        console.log(DATA.exception);
    }
  } 