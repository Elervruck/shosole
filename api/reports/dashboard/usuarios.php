<?php
// Se incluye la clase con las plantillas para generar reportes.
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../helpers/report.php');
require_once('../../entities/dto/cargo.php');
require_once('../../entities/dto/usuario.php');
// Se instancian las entidades correspondientes.
$pdf = new Report;
$cargo = new Cargo;
// Se instancia la clase para crear el reporte
$pdf->startReport('Datos importantes de los usuarios');
// Se establece el valor del usuario, de lo contrario se muestra un mensaje.
if ($dataCargos = $cargo->readAll()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(175);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Times', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(40, 10, 'Nombre', 1, 0, 'C', 1);
    $pdf->cell(40, 10, 'Apellido', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Alias', 1, 0, 'C', 1);
    $pdf->cell(35, 10, 'genero', 1, 0, 'C', 1);
    $pdf->cell(35, 10, 'Estado', 1, 1, 'C', 1);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFillColor(225);
    $pdf->setFont('Times', '', 11);
// Se recorren los registros fila por fila.
    foreach ($dataCargos as $rowCargo) {
        $usuario = new Usuario;
        if ($usuario->setCargo($rowCargo['id_cargo'])) {
            if ($dataUsuarios = $usuario->usuariosReport()) {
                foreach ($dataUsuarios as $rowUsuario) {

                    $pdf->cell(40, 10, $rowUsuario['nombre_usuario'], 1, 0);
                    $pdf->cell(40, 10, $rowUsuario['apellido_usuario'], 1,0);
                    $pdf->cell(30, 10, $rowUsuario['alias_usuario'], 1, 0);
                    $pdf->cell(35, 10, $rowUsuario['generos_usuarios'], 1, 0);
                    $pdf->cell(35, 10, $rowUsuario['estado_usuarios'], 1, 1);

                }
            } 
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('Cargo incorrecta o inexistente'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay categorías para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'usuarios.pdf');
