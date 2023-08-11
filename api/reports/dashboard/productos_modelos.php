<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se verifica si existe un valor para el modelo, de lo contrario se muestra un mensaje.
if(isset($_GET['id_modelo'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
    require_once('../../entities/dto/modelo.php');
    require_once('../../entities/dto/productos.php');
    // Se instancian las entidades correspondientes.
    $modelo = new Modelo;
    $producto = new Producto;
    // Se establece el valor del modelo, de lo contrario se muestra un mensaje.
    if ($modelo->setId($_GET['id_modelo']) && $producto->setModelo($_GET['id_modelo']) ) {
        // Se verifica si el modelo existe, de lo contrario se muestra un mensaje. 
        if ($rowModelo = $modelo->readOne() ) {
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Productos por modelo '. $rowModelo['modelo']);
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataProductos = $producto->productosModelo()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(225);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Times', 'B', 11);
                // Se imprimen las celdas con los encabezados.
                $pdf->cell(70, 10, 'Nombre producto', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Precio (US$)', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Condición', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Estado', 1, 0, 'C', 1);
                $pdf->cell(20, 10, 'Existencia', 1, 1, 'C', 1);
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', '', 11);
                // Se recorren los registros fila por fila.
                foreach ($dataProductos as $rowProducto) {
                    // Se imprime el nombre del producto.
                    $pdf->cell(70, 10, $pdf->encodeString($rowProducto['nombre_producto']), 1, 0);
                    // Se imprime el precio del producto.
                    $pdf->cell(30, 10, $rowProducto['precio_producto'], 1, 0);
                    // Se imprime la condicion del producto.
                    $pdf->cell(30, 10,$pdf->encodeString( $rowProducto['condicón_producto']), 1, 0);
                    // Se imprime el estado del producto.
                    $pdf->cell(30, 10, $rowProducto['estado_producto'], 1, 0);
                    // Se imprime la existencia del producto.
                    $pdf->cell(20, 10, $rowProducto['existencia_producto'], 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay productos por el modelo'), 1, 1);
            }
            $pdf->output('I', 'categoria.pdf');
        } else {
            // Si no se encontró el modelo en la base de datos, se muestra un mensaje de error.            
            print('Modelo inexistente');
        }
    } else {
        print('Modelo incorrecta');
    }
} else {
    print('Debe seleccionar un modelo');
}