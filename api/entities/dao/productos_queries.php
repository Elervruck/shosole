<?php
require_once('../../helpers/database.php');

class ProductoQueries
{

    //Realiza una búsqueda en la base de datos de productos utilizando un valor de búsqueda.
    public function searchRows($value)
    {
        $sql = 'SELECT id_producto, nombre_producto, descripcion_producto, imagen_producto, correo_usuario, modelo, condicion_producto, estado_producto, existencia_producto, precio_producto
        FROM productos
        INNER JOIN usuarios USING(id_usuario)
        INNER JOIN modelos USING(id_modelo)
        INNER JOIN condicion_productos USING(id_condicion_producto)
	    WHERE nombre_producto ILIKE ? OR CAST(estado_producto AS VARCHAR) ILIKE ? OR correo_usuario ILIKE ?';
        $params = array("%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    //Obtiene todos los registros de productos y sus detalles relacionados desde la base de datos.
    public function readAll()
    {
        $sql = 'SELECT id_producto, nombre_producto, descripcion_producto, imagen_producto, correo_usuario, modelo, condicion_producto, estado_producto,existencia_producto, precio_producto
        FROM productos
        INNER JOIN usuarios USING(id_usuario)
        INNER JOIN modelos USING(id_modelo)';
        return Database::getRows($sql);
    }

    //Obtiene todos los registros de productos activos desde la base de datos.
    public function readAllProductos()
    {
        $sql = "SELECT id_producto, nombre_producto,condicion_producto, imagen_producto, estado_producto
        FROM productos
        WHERE estado_producto = 'true'";
        return Database::getRows($sql);
    }

    //Obtiene todas las valoraciones de un producto específico desde la base de datos.
    public function readAllValoracion()
    {
        $sql = 'SELECT id_valoracion, calificacion_producto, comentario_producto, fecha_comentario, estado_comentario
        from valoraciones
        inner join detalle_pedidos USING (id_detalle_pedido)
        inner join productos USING (id_producto)
        where id_producto = ?';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

    //Cambia el estado de una valoración específica en la base de datos.
    public function deleteRowValo($estado)
    {
        ($estado) ? $estado = 0 : $estado = 1;
        $sql = 'UPDATE valoraciones
        SET estado_comentario = ?
        WHERE id_valoracion = ?';
        $params = array($estado, $this->idvalo);
        return Database::executeRow($sql, $params);
    }

    //Obtiene los detalles de una valoración específica desde la base de datos.
    public function readOneValo()
    {
        $sql = 'SELECT id_valoracion, calificacion_producto, comentario_producto, fecha_comentario, estado_comentario, id_detalle_pedido
        FROM valoraciones
        WHERE id_valoracion = ?';
        $params = array($this->idvalo);
        return Database::getRow($sql, $params);
    }

    //Obtiene los detalles de un producto específico desde la base de datos.
    public function readOne()
    {
        $sql = 'SELECT id_producto, nombre_producto, descripcion_producto, imagen_producto, nombre_usuario, modelo, condicion_producto, estado_producto, existencia_producto, precio_producto
        FROM productos
        INNER JOIN usuarios USING(id_usuario)
        INNER JOIN modelos USING(id_modelo)
        WHERE id_producto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    //Crea un nuevo registro de producto en la base de datos.
    public function createRow()
    {
        $sql = 'INSERT INTO productos(imagen_producto, nombre_producto, descripcion_producto, id_usuario, id_modelo, id_condicion_producto, estado_producto,existencia_producto, precio_producto)
            VALUES (?, ?, ?, ?, ?, ?, ? ,? ,?)';
        $params = array($this->imgp, $this->nombrep, $this->descripp, $this->usuario, $this->modelo, $this->condicion, $this->estadop, $this->existencia_producto, $this->precio_producto);
        return Database::executeRow($sql, $params);
    }

    //Elimina un registro de producto de la base de datos.
    public function deleteRow()
    {
        $sql = 'DELETE FROM productos
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    //Actualiza un registro de producto en la base de datos.
    public function updateRow($current_image)
    {
        ($this->imgp) ? Validator::deleteFile($this->getRuta(), $current_image) : $this->imgp = $current_image;

        $sql = 'UPDATE productos
                SET imagen_producto = ?, nombre_producto = ?, descripcion_producto = ?, estado_producto = ?, id_usuario = ?, id_modelo = ?, id_condicion_producto = ?, existencia_producto =?, precio_producto = ?
                WHERE id_producto = ?';
        $params = array($this->imgp, $this->nombrep, $this->descripp, $this->estadop, $this->usuario, $this->modelo, $this->condicion, $this->existencia_producto, $this->precio_producto, $this->id);
        return Database::executeRow($sql, $params);
    }

    //Obtiene una lista de productos de una marca específica desde la base de datos.
    public function readProductosMarca()
    {
        $sql = 'SELECT id_producto, imagen_producto, nombre_producto, descripcion_producto, precio_producto 
        from productos
        INNER JOIN modelos USING(id_modelo)
        INNER JOIN marcas USING(id_marca)
        where id_marca = ? AND estado_producto = true
        order by nombre_producto';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

    //Obtiene los detalles de un producto específico para eliminarlo.
    public function readOneDel()
    {
        $sql = 'SELECT id_producto, nombre_producto, descripcion_producto, imagen_producto, modelo, condicion_producto, estado_producto, existencia_producto, precio_producto
        FROM productos
        INNER JOIN modelos USING(id_modelo)
        WHERE id_producto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    //CARGAR LOS COMENTARIOS DE UN DETALLE DEL PRODUCTO//
    public function cargarComentarios()
    {

        $sql = "SELECT b.comentario_producto, b.fecha_comentario, b.calificacion_producto, e.nombre_cliente, c.nombre_producto, b.id_valoracion, c.id_producto, b.estado_comentario
            from valoraciones b 
            INNER JOIN detalle_pedidos a using (id_detalle_pedido)
            INNER JOIN pedidos d using (id_pedido)
            INNER JOIN clientes e using (id_cliente)
            INNER JOIN productos c using (id_producto) 
            where id_producto = ? and estado_comentario = 'true'";
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }


    public function productosModelo() 
    {
        $sql = 'SELECT nombre_producto, precio_producto, condicion_producto, estado_producto, existencia_producto
                FROM productos
                INNER JOIN modelos USING(id_modelo)
                WHERE id_modelo = ?
                ORDER BY nombre_producto';
        $params = array ($this->modelo);
        return Database::getRows($sql, $params);
    }


    public function productoUsuario()
    {
        $sql = 'SELECT nombre_producto, precio_producto, condicion_producto, estado_producto, existencia_producto
                FROM productos
                INNER JOIN usuarios USING(id_usuario)
                WHERE id_usuario = ?
                ORDER BY nombre_producto';
        $params = array ($this->usuario);
        return Database::getRows($sql, $params);
    }

    public function cantidadProductosModelo()
    {
        $sql = 'SELECT modelo, COUNT(id_producto) cantidad
                FROM productos
                INNER JOIN modelos USING(id_modelo)
                GROUP BY modelo ORDER BY cantidad DESC';
        return Database::getRows($sql);
    }
}
