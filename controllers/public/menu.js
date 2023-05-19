//Codigo personalizado
//constante para hacer acciones en el menu

const openMenu = document.querySelector("#open-menu");
const closeMenu = document.querySelector("#close-menu");
const aside = document.querySelector("aside");

//Evento para abrir el menú
openMenu.addEventListener("click", () => {
    aside.classList.add("aside-visible");
})
//Evento para cerrar el menú
closeMenu.addEventListener("click", () => {
    aside.classList.remove("aside-visible");
})