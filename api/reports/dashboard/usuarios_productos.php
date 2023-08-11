<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se verifica si existe un valor para el usuario, de lo contrario se muestra un mensaje.
if (isset($_GET['id_usuario'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
    require_once('../../entities/dto/usuario.php');
    require_once('../../entities/dto/productos.php');
    // Se instancian las entidades correspondientes.
    $usuario = new Usuario;
    $producto = new Producto;
    // Se establece el valor del usuario, de lo contrario se muestra un mensaje.
    if ($usuario->setId($_GET['id_usuario']) && $producto->setUsuario($_GET['id_usuario']) ) {
        // Se verifica si el usuario existe, de lo contrario se muestra un mensaje. 
        if ($rowUsuario = $usuario->readOne()){
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Productos agregados por: ' . $rowUsuario['nombre_usuario']);
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataProductos = $producto->productoUsuario()){
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(225);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Times', 'B', 11);
                // Se imprimen las celdas con los encabezados.
                $pdf->cell(60, 10, 'Producto', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Estado', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Precio', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Existencia', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Condición', 1, 1, 'C', 1);
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', '', 11);
                // Se recorren los registros fila por fila.
                foreach ($dataProductos as $rowProducto) {
                    // Se imprime el nombre del producto.
                    $pdf->cell(60, 10, $pdf->encodeString($rowProducto['nombre_producto']),1 ,0);
                    // Se imprime el estado del producto.
                    $pdf->cell(30, 10, $rowProducto['estado_producto'], 1, 0);
                    // Se imprime el precio del producto.
                    $pdf->cell(30, 10, $rowProducto['precio_producto'], 1, 0);
                    // Se imprime la existencia del producto.
                    $pdf->cell(30, 10, $rowProducto['existencia_producto'], 1, 0);
                    // Se imprime la condicion del producto.
                    $pdf->cell(30, 10,$pdf->encodeString( $rowProducto['condición_producto']), 1, 1);
                }
            }else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay productos por el usuario'), 1, 1);
            }
            $pdf->output('I', 'usuario.pdf');
        } else {
            // Si no se encontró el usuario en la base de datos, se muestra un mensaje de error.            
            print('usuario inexistente');
        }
    } else {
        print('categoria incorrecta');
    }
} else {
    print('Seleccione un usuario no sea chabacan');
}