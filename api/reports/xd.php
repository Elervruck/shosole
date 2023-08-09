if ($rowCargo = $cargo->readOne()) {

$pdf->startReport('Usuarios por cargo '. $rowCargo['cargo']);

if ($dataUsuarios = $usuario->usuarioCargos()) {

    $pdf->setFillColor(225);

    $pdf->setFont('Times', 'B', 11);

    $pdf->cell(126, 10, 'Nombre', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Precio (US$)', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Estado', 1, 1, 'C', 1);

} else {
    $pdf->output('I', 'cargos.pdf');
}
} else {
print('cargo inexistente');
}