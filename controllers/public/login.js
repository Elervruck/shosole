// Constante para establecer el formulario de iniciar sesión.
const SESSION_FORM = document.getElementById('session-form');
//Codigo personalizado

//Permite el cambio de formulario de primer uso a login

const signUpBUtton = document.getElementById("signUp");
const signInBUtton = document.getElementById("signIn");
const container = document.getElementById("container");

// Switch entre el login y el primer uso

signUpBUtton.addEventListener("click", () => {
  container.classList.add("right-panel-active");
});

signInBUtton.addEventListener("click", () => [
  container.classList.remove("right-panel-active")
]);


// Método manejador de eventos para cuando se envía el formulario de iniciar sesión.
SESSION_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SESSION_FORM);
    // Petición para determinar si el cliente se encuentra registrado.
    const JSON = await dataFetch(USER_API, 'login', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        sweetAlert(1, JSON.message, true, 'index.html');
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});