<?php

require_once('../../helpers/report.php');

$pdf = new Report;

if(isset($_GET['id_modelo'])) {

    require_once('../../entities/dto/modelo.php');
    require_once('../../entities/dto/productos.php');

    $modelo = new Modelo;
    $producto = new Producto;

    if ($modelo->setId($_GET['id_modelo']) && $producto->setModelo($_GET['id_modelo']) ) {

        if ($rowModelo = $modelo->readOne() ) {

            $pdf->startReport('Productos por modelo '. $rowModelo['modelo']);

            if ($dataProductos = $producto->productosModelo()) {


                $pdf->setFillColor(225);
                $pdf->setFont('Times', 'B', 11);

                $pdf->cell(70, 10, 'Nombre producto', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Precio (US$)', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Condicion', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Estado', 1, 0, 'C', 1);
                $pdf->cell(20, 10, 'Existencia', 1, 1, 'C', 1);
                
                $pdf->setFont('Times', '', 11);

                foreach ($dataProductos as $rowProducto) {
                    $pdf->cell(70, 10, $pdf->encodeString($rowProducto['nombre_producto']), 1, 0);
                    $pdf->cell(30, 10, $rowProducto['precio_producto'], 1, 0);
                    $pdf->cell(30, 10, $rowProducto['condicion_producto'], 1, 0);
                    $pdf->cell(30, 10, $rowProducto['estado_producto'], 1, 0);
                    $pdf->cell(20, 10, $rowProducto['existencia_producto'], 1, 1);
                }

            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay productos por el modelo'), 1, 1);
            }

            $pdf->output('I', 'categoria.pdf');

        } else {
            print('Modelo inexistente');
        }
    } else {
        print('Modelo incorrecta');
    }
} else {
    print('Debe seleccionar un modelo');
}