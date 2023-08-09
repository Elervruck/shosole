<?php

require_once('../../helpers/report.php');

$pdf = new report;

if (isset($_GET['id_cliente'])) {

    require_once('../../entities/dto/clientes.php');
    require_once('../../entities/dto/pedidos.php');

    $cliente = new Clientes;
    $pedido = new Pedido;

    if ($cliente->setId($_GET['id_cliente']) && $pedido->setCliente($_GET['id_cliente'])) {

        if ($rowCliente = $cliente->readOne()){

            $pdf->startReport('Pedidos por cliente ' .$rowCliente['nombre_cliente']);

            if ($dataPedidos = $pedido->pedidosClientes()) {

                $pdf->setFillColor(225);
                $pdf->setFont('Times', 'B', 11);

                $pdf->cell(55, 10, 'Fecha', 1, 0, 'C', 1);
                $pdf->cell(90, 10, 'Direccion', 1, 0, 'C', 1);
                $pdf->cell(35, 10, 'Estado', 1, 1, 'C', 1);

                $pdf->setFont('Times', '', 11);

                foreach ($dataPedidos as $rowPedidos) {
                    $pdf->cell(55, 10, $pdf->encodeString($rowPedidos['fecha_pedido']), 1, 0,);
                    $pdf->cell(90, 10, $rowPedidos['direccion_pedido'], 1, 0);
                    $pdf->cell(35, 10, $rowPedidos['estados_pedido'], 1, 1);

                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay pedidos por el cliente'), 1, 1);
            }

            $pdf->output('I', 'clientes.pdf');
       } else {
            print('Cliente incorrecto');     
       }
    } else {
        print('cliente incorrecto');
    }
} else {
    print('debe seleccionar un cliente');
}