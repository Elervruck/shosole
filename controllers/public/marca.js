const MARCA_API = 'business/public/marca.php';

const PARAMS = new URLSearchParams(location.search);

const MARCA = document.getElementById('marca');

document.addEventListener('DOMContentLoaded', async () => {

    // Petición para solicitar los productos de la categoría seleccionada.
    const JSON = await dataFetch(MARCA_API, 'readAll');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se inicializa el contenedor de productos.
        MARCA.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        JSON.dataset.forEach(row => {
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
        sweetAlert(4, JSON.exception, true);
    }
});