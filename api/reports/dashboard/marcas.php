<?php

require_once('../../helpers/report.php');

require_once('../../entities/dto/marca.php');

$pdf = new Report;

$pdf->startReport('Marcas de productos');

if($dataMarcas = $marca->readAll()){
    $pdf->SetFillColor(175);

    $pdf->SetFont('Times', 'B', 11);

    $pdf->cell(126, 10, 'Nombre', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Foto', 1, 0, 'C', 1);

    $pdf->SetFillColor(225);
    $pdf->SetFont('Times', '', 11);


    foreach
}