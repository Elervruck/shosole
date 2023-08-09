<<<<<<< HEAD
const MARCA_API = 'business/public/marca.php';
=======
const MARCA_API= 'business/public/marca.php';
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468

const PARAMS = new URLSearchParams(location.search);

const MARCA = document.getElementById('marca');

document.addEventListener('DOMContentLoaded', async () => {
<<<<<<< HEAD

=======
 
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
    // Petición para solicitar los productos de la categoría seleccionada.
    const JSON = await dataFetch(MARCA_API, 'readAll');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se inicializa el contenedor de productos.
        MARCA.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
<<<<<<< HEAD
            url = `productos.html?id=${row.id_marca}&marca=${row.marca}`;
            // Se crean y concatenan las tarjetas con los datos de cada producto.
            MARCA.innerHTML += `
                <div class="card">
                <div class="imgbox">
                    <div class="img">
                    <img src="${SERVER_URL}images/marcas/${row.imagen_marca}">
                    </div>
                </div>
                <div class="details">
                <a class="buttonpre" href="${url}">
                <h2 class="title">${row.marca}</h2>
                </a>
                </div>
            </div>
        `;
        });
    } else {
=======

            url = `productos.html?id=${row.id_marca}&marca=${row.marca}`;
                 // Se crean y concatenan las tarjetas con los datos de cada producto.
                 MARCA.innerHTML += `
                 <div class="card">
                 <div class="imgbox">
                     <div class="img">
                     <img src="${SERVER_URL}images/marcas/${row.imagen_marca}">
                     </div>
                 </div>
                 <div class="details">
                 <a class="buttonpre" href="${url}">
                 <h2 class="title">${row.marca}</h2>
                 </a>
                    
                 </div>
             </div>
        `;
        });
    } else{
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
        sweetAlert(4, JSON.exception, true);
    }
});