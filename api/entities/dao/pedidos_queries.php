<?php
require_once('../../helpers/database.php');

class PedidoQueries
{
    /*
    *   Métodos para realizar las operaciones de buscar(search) de pedido
    */
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

    public function readAll()
    {
        $sql = 'SELECT id_pedido, estado_pedido, fecha_pedido, direccion_pedido, nombre_cliente
        FROM pedidos
        INNER JOIN clientes USING(id_cliente)';
        return Database::getRows($sql);
    }

    public function readOne(){
        $sql='SELECT id_pedido, estado_pedido, fecha_pedido, direccion_pedido, nombre_cliente, id_cliente
        FROM pedidos
        INNER JOIN clientes USING(id_cliente)
        WHERE id_pedido=?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }
        
    public function deleteRow(){
        $sql='DELETE FROM pedidos 
              WHERE id_pedido = ?';
        $params=array($this->id);
        return Database:: executeRow($sql, $params);
    } 

    public function createRow()
    {
        $sql = 'INSERT INTO pedidos(estado_pedido, fecha_pedido, direccion_pedido, id_cliente)
            VALUES (?, ?, ?, ?)';
        $params = array($this->estado_pedido, $this->fecha_pedido, $this->direccion_pedido, $this->cliente);
        return Database::executeRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE pedidos
                SET estado_pedido = ?, fecha_pedido = ?, direccion_pedido = ?, id_cliente = ?
                WHERE id_pedido = ?';
        $params = array($this->estado_pedido, $this->fecha_pedido, $this-> direccion_pedido, $this-> cliente, $this->id);
        return Database::executeRow($sql, $params);
    }

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

}
