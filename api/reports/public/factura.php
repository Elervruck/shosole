<?php

require_once('../../helpers/report_public.php');

$pdf = new report;

if (isset($_GET['id_pedido'])) {

    require_once('../../entities/dto/pedidos.php');

    $pedido = new Pedido;

    if ($pedido->setId($_GET['id_pedido'])) {

        if ($rowPedido = $pedido->readOne()){

            $pdf->startReport('Comprobante de compra');
            $pdf->setFont('Arial', '', 10);
            $pdf->ln(5);
            $pdf->cell(0, 7, 'Cliente: ' . $pdf->encodeString($rowPedido['nombre_cliente']), 0, 1);
            $pdf->cell(0, 7,  $pdf->encodeString('Dirección: ' . $rowPedido['direccion_pedido']), 0, 1);
            $pdf->cell(0, 7, 'Fecha: ' . $rowPedido['fecha_pedido'], 0, 1);
            $pdf->ln(5);
            if ($dataPedidos = $pedido->readAllDetalle()) {

                $pdf->setFillColor(225);
                $pdf->setFont('Times', 'B', 11);

                $pdf->cell(96, 10, 'Producto', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Precio (US$)', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Cantidad', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Subtotal (US$)', 1, 1, 'C', 1);

                $pdf->setFont('Times', '', 11);
                $total = 0;
                foreach ($dataPedidos as $rowPedido) {
                    $subtotal = $rowPedido['precio_total'] * $rowPedido['cantidad_producto'];
                    $pdf->cell(96, 10, $pdf->encodeString($rowPedido['nombre_producto']), 1, 0,);
                    $pdf->cell(30, 10, $rowPedido['precio_total'], 1, 0);
                    $pdf->cell(30, 10, $rowPedido['cantidad_producto'], 1, 0);
                    $pdf->cell(30, 10, $subtotal, 1, 1);
                    $total += $subtotal;
                }
                $pdf->cell(0, 10, 'Total (US$) ' . $total, 1, 1, 'R');
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay productos'), 1, 1);
            }

            $pdf->output('I', 'factura.pdf');
       } else {
            print('Pedido inexistente');     
       }
    } else {
        print('Pedido incorrecto');
    }
} else {
    print('Debe crear y finalizar un pedido');
}