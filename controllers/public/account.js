/*

*   Controlador de uso general en las páginas web del sitio privado.
>>>>>>> f6cdd49608db2e841e77f3db7e2b938677b30a67
*   Sirve para manejar las plantillas del encabezado y pie del documento.
*/

// Constante para completar la ruta de la API.
const USER_API = 'business/public/cliente.php';
// Constantes para establecer las etiquetas de encabezado y pie de la página web.
const NAV = document.querySelector('nav');
const FOOTER = document.querySelector('footer');
<<<<<<< HEAD
=======

>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468

document.addEventListener('DOMContentLoaded', async () => {
    // Petición para obtener en nombre del usuario que ha iniciado sesión.
    // const JSON = await dataFetch(USER_API, 'getUser');
    
    const JSON = await dataFetch(USER_API, 'getUser');
<<<<<<< HEAD

    // Se comprueba si el usuario está autenticado para establecer el encabezado respectivo.
    if (JSON.session) {
    url = `historialcompra.html?id=${JSON.id}&username=${JSON.username}`;
=======
      
    // Se comprueba si el usuario está autenticado para establecer el encabezado respectivo.
    if (JSON.session) {
      url = `historialcompra.html?id=${JSON.id}&username=${JSON.username}`;
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
    NAV.innerHTML = `
        <div class="container">
        <a class="navbar-brand" href="index.html"><i class="fa-solid fa-shop me-2"></i> <strong>Shosole</strong></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class=" collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto ">
                <li class="nav-item">
                    <a class="nav-link mx-2 text-uppercase active" aria-current="page" href="#">Offers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-2 text-uppercase" href="productos.html">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-2 text-uppercase" href="#">Catalog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-2 text-uppercase" href="#">Services</a>
                </li>
                
            </ul>
<<<<<<< HEAD
=======
            
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
            <ul class="navbar-nav ms-auto d-flex ">
                <li>
                    <a href="carrito.html">
                        <img src="../../resources/img/carrito-de-compras.png" alt="" height="30"
                            alt="Black and White Portrait of a Man" loading="lazy">
                    </a>
                </li>
<<<<<<< HEAD
=======

>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
                <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="../../resources/img/hongo_mario.jpg" alt="" class="rounded-circle ms-4"
<<<<<<< HEAD
                            height="30" alt="Black and White Portrait of a Man" loading="lazy">
                            Mi perfil
=======
                             height="30" alt="Black and White Portrait of a Man" loading="lazy">
                             Mi perfil
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                            <li><a class="dropdown-item" href="perfil.html">Mi cuenta</a></li>
                            <li><a class="dropdown-item" href="${url}">Historial de compra</a></li>
                            <li><a class="dropdown-item" onclick="logOut('login.html')">Cerrar sesión</a></li>
                        </ul>
                        </li>
                    </ul>
                </div>
            </ul>
        </div>
    </div>
    `;
    } else {
<<<<<<< HEAD
    // Se establece el nav del encabezado.
=======
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
    NAV.innerHTML = `
            <div class="container">
            <a class="navbar-brand" href="#"><i class="fa-solid fa-shop me-2"></i> <strong>Shosole</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class=" collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto ">
                    <li class="nav-item">
                        <a class="nav-link mx-2 text-uppercase active" aria-current="page" href="#">Offers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2 text-uppercase" href="productos.html">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2 text-uppercase" href="#">Catalog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2 text-uppercase" href="#">Services</a>
                    </li>
<<<<<<< HEAD
                    <li class="nav-item">     
=======
                    <li class="nav-item">
                       
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto d-flex ">
                    <li>
                        <a href="carrito.html">
                            <img src="../../resources/img/carrito-de-compras.png" alt="" height="30"
                                alt="Black and White Portrait of a Man" loading="lazy">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2 text-uppercase" href="login.html">Iniciar sesión</a>
<<<<<<< HEAD
                    </li>
=======
                     </li>
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
                </ul>
            </div>
        </div>
    `;
    }
<<<<<<< HEAD
    // Se establece el pie del encabezado.
    FOOTER.innerHTML = ` 
=======
    
    FOOTER.innerHTML = `
      
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
    `;
    
    });