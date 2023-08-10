<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se verifica si existe un valor para el cargo, de lo contrario se muestra un mensaje.
if (isset($_GET['id_cargo'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
    require_once('../../entities/dto/cargo.php');
    require_once('../../entities/dto/usuario.php');
    // Se instancian las entidades correspondientes.
    $cargo = new Cargo;
    $usuario = new Usuario;
    // Se establece el valor del cargo, de lo contrario se muestra un mensaje.
    if ($cargo->setId($_GET['id_cargo']) && $usuario->setCargo($_GET['id_cargo'])) {
        // Se verifica si el cargo existe, de lo contrario se muestra un mensaje.        
        if ($rowCargo = $cargo->readOne()) {
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Usuarios por cargo '. $rowCargo['cargo']);
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataUsuarios = $usuario->usuariosCargos()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(225);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Times', 'B', 11);
                // Se imprimen las celdas con los encabezados.
                $pdf->cell(60, 10, 'nombre', 1, 0, 'C', 1);
                $pdf->cell(60, 10, 'Apellido', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Alias', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Genero', 1, 1, 'C', 1);
                // Se establece la fuente para los datos de los usuarios.
                $pdf->setFont('Times', '', 11);
                // Se recorren los registros fila por fila.
                foreach ($dataUsuarios as $rowUsuario ){
                    $pdf->cell(60, 10, $pdf->encodeString($rowUsuario['nombre_usuario']), 1, 0);
                    $pdf->cell(60, 10, $rowUsuario['apellido_usuario'], 1, 0);
                    $pdf->cell(30, 10, $rowUsuario['alias_usuario'], 1, 0);
                    $pdf->cell(30, 10, $rowUsuario['generos_usuarios'], 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay usuarios por el cargo'), 1, 1);
            }
            $pdf->output('I', 'cargos.pdf');
        } else {
            print('cargo inexistente');
        }
    } else {
        print('cargo incorrecto');
    }
} else {
    print('Debe seleccionar un cargo');
}