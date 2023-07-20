<?php
require_once('../../helpers/database.php');

class PedidoQueries
{
    /*
    *   Métodos para realizar las operaciones de buscar(search) de pedido
    */

    //Metodo para buscar un pedido
    public function searchRows($value)
    {
        $sql = 'SELECT id_pedido, estado_pedido, fecha_pedido, direccion_pedido, nombre_cliente
        FROM pedidos
        INNER JOIN clientes USING(id_cliente)
        WHERE nombre_cliente ILIKE ? OR CAST(fecha_pedido AS VARCHAR)
        ILIKE ? OR direccion_pedido ILIKE ?';
        $params = array("%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    //Metodo para obtener todos los registros de pedidos
    public function readAll()
    {
        $sql = 'SELECT id_pedido, estados_pedido, fecha_pedido, direccion_pedido, nombre_cliente
        FROM pedidos
        INNER JOIN clientes USING(id_cliente)';
        return Database::getRows($sql);
    }

    //Metodo para obtener un registo de pedidos
    public function readOne()
    {
        $sql = 'SELECT id_pedido, estado_pedido, fecha_pedido, direccion_pedido, nombre_cliente, id_cliente
        FROM pedidos
        INNER JOIN clientes USING(id_cliente)
        WHERE id_pedido=?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    //Metodo para eliminar un pedido
    public function deleteRow()
    {
        $sql = 'DELETE FROM pedidos 
            WHERE id_pedido = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    //Metodo para crear un pedido
    public function createRow()
    {
        $sql = 'INSERT INTO pedidos(estado_pedido, fecha_pedido, direccion_pedido, id_cliente)
            VALUES (?, ?, ?, ?)';
        $params = array($this->estado_pedido, $this->fecha_pedido, $this->direccion_pedido, $this->cliente);
        return Database::executeRow($sql, $params);
    }

    //Metodo para actualizar un pedido
    public function updateRow()
    {
        $sql = 'UPDATE pedidos
                SET estado_pedido = ?, fecha_pedido = ?, direccion_pedido = ?, id_cliente = ?
                WHERE id_pedido = ?';
        $params = array($this->estado_pedido, $this->fecha_pedido, $this->direccion_pedido, $this->cliente, $this->id);
        return Database::executeRow($sql, $params);
    }

    //Metodo para leer todos los registros de la tabla detalle pedido
    public function readAllDetalle()
    {
        $sql = 'SELECT d.id_detalle_pedido, cli.nombre_cliente, pro.nombre_producto, d.cantidad_producto, d.precio_producto
        from detalle_pedidos d
        inner join productos pro USING (id_producto)
        inner join pedidos ped USING (id_pedido)
        inner join clientes cli USING (id_cliente)
        where id_pedido = ?';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }





    // Método que verifica si existen pedidos si no crean uno
    public function startOrder()
    {
        $sql = "SELECT id_pedido
                FROM pedidos
                WHERE estados_pedido = 'En proceso' AND id_cliente = ?";
        $params = array($_SESSION['id_cliente']);

        if ($data = Database::getRow($sql, $params)) {
            $this->id = $data['id_pedido'];
            return true;
        } else {
            $sql = 'INSERT INTO pedidos(direccion_pedido, id_cliente)
                    VALUES((SELECT direccion_cliente FROM clientes WHERE id_cliente = ?), ?)';
            $params = array($_SESSION['id_cliente'], $_SESSION['id_cliente']);
            // Se obtiene el ultimo valor insertado en la llave primaria de la tabla pedidos.
            if ($this->id = Database::getLastRow($sql, $params)) {
                return true;
            } else {
                return false;
            }
        }
    }




    // Método para agregar un producto al carrito de compras.
    public function createDetail()
    {
        $sql = 'INSERT INTO detalle_pedidos(id_producto, precio_total, cantidad_producto, id_pedido)
        VALUES(?, (SELECT precio_producto FROM productos WHERE id_producto = ?), ?, ?)';
        $params = array($this->producto, $this->producto, $this->cantidad, $this->id);
        return Database::executeRow($sql, $params);
    }

    //metodo para modificar las existencias del inventario
    public function ModInventory()
    {
        $sql = 'UPDATE productos set existencia_producto = (existencia_producto-?)where id_producto = ?';
        $params = array($this->cantidad, $this->producto);
        return Database::executeRow($sql, $params);
    }
    //metodo para modificar las existencias del inventario (parametro)
    public function ModInventoryParam($producto, $diferencia, $aumento)
    {
        if ($aumento) {
            $sql = 'UPDATE productos set existencia_producto = (existencia_producto - ?) where id_producto = ?';
        } else {
            $sql = 'UPDATE productos set existencia_producto = (existencia_producto + ?) where id_producto = ?';
        }
        $params = array($diferencia, $producto);
        return Database::executeRow($sql, $params);
    }


    // Método que carga los productos que se encuentran en el carrito.
    public function readOrderDetail()
    {
        $sql = 'SELECT id_detalle_pedido, id_producto, nombre_producto, detalle_pedidos.precio_total, detalle_pedidos.cantidad_producto
                from pedidos
                INNER JOIN detalle_pedidos USING(id_pedido) 
                INNER JOIN productos USING(id_producto) 
		        where id_pedido = ?
                order by id_detalle_pedido, nombre_producto, detalle_pedidos.precio_total, detalle_pedidos.cantidad_producto';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

    //Metodo para finalizar mi compra 
    public function finishOrder()

    {
        date_default_timezone_set('America/El_Salvador');
        $date = date('Y-m-d');

        $this->estado_pedido = 'Entregado';

        $sql = 'UPDATE pedidos
                SET estados_pedido = ?, fecha_pedido = ?
                WHERE id_pedido = ?';
        $params = array($this->estado_pedido, $date, $_SESSION['id_pedido']);
        return Database::executeRow($sql, $params);
    }

    //Metodo para actualizar un detalle pedido
    public function updateDetail()
    {
        $sql = 'UPDATE detalle_pedidos
                SET cantidad_producto = ?
                WHERE id_detalle_pedido = ? AND id_pedido = ?';
        $params = array($this->cantidad, $this->iddetalle, $_SESSION['id_pedido']);
        return Database::executeRow($sql, $params);
    }

    //Metodo para eliminar un detalle pedido
    public function deleteDetail()
    {
        $sql = 'DELETE FROM detalle_pedidos
                WHERE id_detalle_pedido = ? AND id_pedido = ?';
        $params = array($this->iddetalle, $_SESSION['id_pedido']);
        return Database::executeRow($sql, $params);
    }

    //metodo para restaurar las existencias del inventario
    public function RestInventory()
    {
        $sql = 'UPDATE productos set existencia_producto = (existencia_producto+?)where id_producto = ?';
        $params = array($this->cantidad, $this->producto);
        return Database::executeRow($sql, $params);
    }


    //Método para cargar los pedidos del historial de compra
    public function cargarHistorial()
    {
        $sql = 'SELECT id_pedido, estados_pedido, fecha_pedido, direccion_pedido
        FROM pedidos
        INNER JOIN clientes USING(id_cliente)
        where id_cliente = ?';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

    //Metodo para ver los productos de cada pedido del cliente en sesion
    public function readVerCompra()
    {
        $sql = 'SELECT id_pedido, id_detalle_pedido, nombre_producto, detalle_pedidos.id_detalle_pedido, detalle_pedidos.precio_total, detalle_pedidos.cantidad_producto, productos.descripcion_producto, productos.imagen_producto, productos.condicion_producto, pedidos.estados_pedido 
        FROM pedidos
        INNER JOIN detalle_pedidos USING(id_pedido)
        INNER JOIN productos USING(id_producto) 
        WHERE id_pedido = ?';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }
}
