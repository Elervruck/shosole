<?php

require_once('../../entities/dto/pedidos.php');

require_once('../../entities/dto/clientes.php');

$pdf = new Report;

$pdf->startReport('Pedidos por clientes');

$clientes = new Clientes;

if($dataClientes = $clientes->readAll()){
    $pdf->SetFillColor(175);
    $pdf->SetFont('Times', 'B', 11);
    
    $pdf->cell(126, 10, 'Cliente',1,0,'C', 1);
    $pdf->cell(30, 10, 'fecha',1,0,'C',1);
    $pdf->cell(30,10,'direccion',1,0,'C',1);

    $pdf->setFillColor(225);
    $pdf->setFont('Times', '', 11);

    foreach ($dataClientes as $rowCliente) {
        $pdf->cell(0, 10, $pdf->encodeString('Cliente: ' . $rowCliente['nombre_cliente']),1,1,'C',1);

        $pedidos = new Pedido;
    }

}
