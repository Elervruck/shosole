<?php

require_once('../../helpers/report.php');
require_once('../../entities/dto/cargo.php');
require_once('../../entities/dto/usuario.php');

$pdf = new Report;
$pdf->startReport('Usuarios por estado');
$cargo = new Cargo;

if ($dataCargos = $cargo->readAll()) {

    $pdf->setFillColor(175);
    $pdf->setFont('Times', 'B', 11);

    $pdf->cell(63, 10, 'Nombre', 1, 0, 'C', 1);
    $pdf->cell(63, 10, 'Apellidos', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'genero', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Estado', 1, 1, 'C', 1);

    
    $pdf->setFillColor(225);
    $pdf->setFont('Times', '', 11);

    foreach ($dataCargos as $rowCargo) {


        $usuario = new Usuario;

        if ($usuario->setCargo($rowCargo['id_cargo'])) {
            if ($dataUsuarios = $usuario->usuariosCargo()) {
                foreach ($dataUsuarios as $rowUsuario) {

                    $pdf->cell(63, 10, $rowUsuario['nombre_usuario'], 1, 0);
                    $pdf->cell(63, 10, $rowUsuario['apellido_usuario'], 1,0);
                    $pdf->cell(30, 10, $rowUsuario['generos_usuarios'], 1, 0);
                    $pdf->cell(30, 10, $rowUsuario['estado_usuarios'], 1, 0);

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
