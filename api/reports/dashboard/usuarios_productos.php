<?php

require_once('../../helpers/report.php');

$pdf = new Report;

if (isset($_GET['id_usuario'])) {

    require_once('../../entities/dto/usuario.php');
    require_once('../../entities/dto/productos.php');

    $usuario = new Usuario;
    $producto = new Producto;
    
    if ($usuario->setId($_GET['id_usuario']) && $producto->setUsuario($_GET['id_usuario']) ) {

        if ($rowUsuario = $usuario->readOne()){

            $pdf->startReport('Productos agregados por: ' . $rowUsuario['nombre_usuario']);


            if ($dataProductos = $producto->productoUsuario()){


                $pdf->setFillColor(225);
                $pdf->setFont('Times', 'B', 11);

                $pdf->cell(60, 10, 'Producto', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Estado', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Precio', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Existencia', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Condicion', 1, 1, 'C', 1);

                $pdf->setFont('Times', '', 11);

                foreach ($dataProductos as $rowProducto) {
                    
                    $pdf->cell(60, 10, $pdf->encodeString($rowProducto['nombre_producto']),1 ,0);
                    $pdf->cell(30, 10, $rowProducto['estado_producto'], 1, 0);
                    $pdf->cell(30, 10, $rowProducto['precio_producto'], 1, 0);
                    $pdf->cell(30, 10, $rowProducto['existencia_producto'], 1, 0);
                    $pdf->cell(30, 10, $rowProducto['condicion_producto'], 1, 1);
                }

            }else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay productos por el usuario'), 1, 1);
            }
            $pdf->output('I', 'usuario.pdf');
        } else {
            print('usuario inexistente');
        }
    } else {
        print('categoria incorrecta');
    }
} else {
    print('Seleccione un usuario no sea chabacan');
}