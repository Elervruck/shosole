Pasos para poner en funcionamiento el proyecto en Microsoft Windows:
1. Configurar PHP para que conecte con PostgreSQL. Una forma es acceder a la dirección C:\xampp\php y realizar lo siguiente:
    a. Ubicar y abrir el archivo php.ini
    b. Buscar la línea ;extension=pdo_pgsql
    c. Borrar el ; que esta al inicio de la línea
    d. Guardar los cambios y cerrar el archivo
    e. Iniciar Apache

Paso para usar primer usuario

Para vericar el funcionamiento de primer uso en pgadmin NO DEBE crear los registros de usuario
ya que al detectar un usuario te mandara al login


Cuando se cree el primer usuario el formato de imagen DEBE SER jpg (no otro tipo de imagen)

Cuando de vaya a descargar el proyecto hacer lo siguiente para que sirva la conexión con postgres.
- Eliminar las plecas del archivo config.php
- Agregar la contraseña respectiva de su dispositivo a config.php
- Cuanto termine todo los cambios de que vaya ha hacer, antes de subir los cambios al repositorio, *BORRAR LA CONTRASEÑA Y VOLVER A PONER LAS PLECAS en config.php

Por cada comentario personalizado debe crear
primero el comentario

<!--COMENTARIO PERSONALIZADO--!>

y luego poner la acción que está realizando






