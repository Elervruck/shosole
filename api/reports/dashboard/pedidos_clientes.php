<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');

// Se instancia la clase para crear el reporte.
$pdf = new report;
// Se verifica si existe un valor para el cliente, de lo contrario se muestra un mensaje.
if (isset($_GET['id_cliente'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
    require_once('../../entities/dto/clientes.php');
    require_once('../../entities/dto/pedidos.php');
    // Se instancian las entidades correspondientes.
    $cliente = new Clientes;
    $pedido = new Pedido;
    // Se establece el valor del cliente, de lo contrario se muestra un mensaje.
    if ($cliente->setId($_GET['id_cliente']) && $pedido->setCliente($_GET['id_cliente'])) {
        // Se verifica si el cliente existe, de lo contrario se muestra un mensaje.   
        if ($rowCliente = $cliente->readOne()){
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Pedidos por cliente ' .$rowCliente['nombre_cliente']);
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataPedidos = $pedido->pedidosClientes()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(225);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Times', 'B', 11);
                // Se imprimen las celdas con los encabezados.
                $pdf->cell(55, 10, 'Fecha', 1, 0, 'C', 1);
                $pdf->cell(90, 10, $pdf->encodeString('Dirección'), 1, 0, 'C', 1);
                $pdf->cell(35, 10, 'Estado', 1, 1, 'C', 1);
                // Se establece la fuente para los datos de los pedidos.
                $pdf->setFont('Times', '', 11);
                // Se recorren los registros fila por fila.
                foreach ($dataPedidos as $rowPedidos) {
                    // Se imprime la fecha del pedido en una celda.
                    $pdf->cell(55, 10, $pdf->encodeString($rowPedidos['fecha_pedido']), 1, 0,);
                    // Se imprime la dirección del pedido en una celda.
                    $pdf->cell(90, 10, $pdf->encodeString($rowPedidos['dirección_pedido']), 1, 0);
                    // Se imprime el estado del pedido en una celda y se agrega un salto de línea.
                    $pdf->cell(35, 10, $rowPedidos['estados_pedido'], 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay pedidos por el cliente'), 1, 1);
            }

            $pdf->output('I', 'clientes.pdf');
       } else {
            // Si no se encontró el cliente en la base de datos, se muestra un mensaje de error.
            print('Cliente incorrecto');     
       }
    } else {
        print('cliente incorrecto');
    }
} else {
    print('debe seleccionar un cliente');
}