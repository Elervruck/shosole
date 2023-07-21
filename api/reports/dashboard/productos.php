<?php

require_once('../../helpers/report.php');

require_once('../../entities/dto/productos.php');
require_once('../../entities/dto/modelo.php');

$pdf = new Report;

$pdf->startReport('productos por modelos');

$modelo = new Modelo;

if($dataModelo = $modelo->readAll()){
    $pdf->SetFillColor(175);

    $pdf->SetFont('Times', 'B', 11);

    $pdf->cell(126,10,'Nombre',1,0,'C',1);
    $pdf->cell(30, 10, 'Precio (US$)', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Estado', 1, 1, 'C', 1);
    $pdf->cell(30, 10, 'Existencia', 1, 1, 'C', 1);

    $pdf->SetFillColor(225);
    $pdf->SetFont('Times', '', 11);

    foreach ($dataModelo as $rowModelo){
        $pdf->cell(0, 10, $pdf->encodeString('Modelo: ' . $rowModelo['nombre_modelo']), 1,1, 'C', 1);

        $producto = new Producto;

        if($producto->setModelo($rowModelo['id_modelo'])){
            
            if($dataProductos = $producto->productosModelo()){
                
                foreach($dataProductos as $rowProducto) {
                    ($rowProducto['estadop']) ? $estado = 'Activo' : $estado = 'Inactivo';

                    $pdf->cell(126, 10, $pdf->encodeString($rowProducto['nombrep']),1,0);

                    $pdf->cell(30,10,$rowProducto['precio_producto'],1,0);

                    $pdf->cell(30, 10, $estado, 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay productos para el modelo'), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('modelo incorrecta o inexistente'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay modelo para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'productos.pdf');

