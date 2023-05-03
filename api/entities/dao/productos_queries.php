<?php
require_once('../../helpers/database.php');

class ProductoQueries
{

    
    public function searchRows($value)
    {
        $sql = 'SELECT id_producto, nombre_producto, descripcion_producto, imagen_producto, correo_usuario, modelo, condicion_producto, estado_producto
        FROM productos
        INNER JOIN usuarios USING(id_usuario)
        INNER JOIN modelos USING(id_modelo)
        INNER JOIN condicion_productos USING(id_condicion_producto)
	    WHERE nombre_producto ILIKE ? OR CAST(estado_producto AS VARCHAR) ILIKE ? OR correo_usuario ILIKE ?';
        $params = array("%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }
    
    
    public function readAll()
    {
        $sql = 'SELECT id_producto, nombre_producto, descripcion_producto, imagen_producto, correo_usuario, modelo, condicion_producto, estado_producto
        FROM productos
        INNER JOIN usuarios USING(id_usuario)
        INNER JOIN modelos USING(id_modelo)
        INNER JOIN condicion_productos USING(id_condicion_producto)';
        return Database::getRows($sql);
    }

    

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

    public function deleteRowValo($estado)
    {
        ($estado) ? $estado=0 : $estado=1;
        $sql = 'UPDATE valoraciones
        SET estado_comentario = ?
        WHERE id_valoracion = ?';
        $params = array($estado, $this->idvalo);
        return Database::executeRow($sql, $params);
    }

    public function readOneValo()
    {
        $sql = 'SELECT id_valoracion, calificacion_producto, comentario_producto, fecha_comentario, estado_comentario, id_detalle_pedido
        FROM valoraciones
        WHERE id_valoracion = ?';
        $params = array($this->idvalo);
        return Database::getRow($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT id_producto, nombre_producto, descripcion_producto, imagen_producto, nombre_usuario, modelo, condicion_producto, estado_producto
        FROM productos
        INNER JOIN usuarios USING(id_usuario)
        INNER JOIN modelos USING(id_modelo)
        INNER JOIN condicion_productos USING(id_condicion_producto)
        WHERE id_producto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }


    public function createRow()
    {
        $sql = 'INSERT INTO productos(imagen_producto, nombre_producto, descripcion_producto, id_usuario, id_modelo, id_condicion_producto, estado_producto)
            VALUES (?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->imgp, $this->nombrep, $this->descripp, $this->usuario, $this->modelo, $this->condicion, $this->estadop);
        return Database::executeRow($sql, $params);
    }


    public function deleteRow()
    {
        $sql = 'DELETE FROM productos
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
    

    public function updateRow($current_image)
    {
        ($this->imgp) ? Validator::deleteFile($this->getRuta(), $current_image) : $this->imgp = $current_image;

        $sql = 'UPDATE productos
                SET imagen_producto = ?, nombre_producto = ?, descripcion_producto = ?, estado_producto = ?, id_usuario = ?, id_modelo = ?, id_condicion_producto = ?
                WHERE id_producto = ?';
        $params = array($this->imgp, $this->nombrep, $this->descripp, $this->estadop, $this->usuario, $this->modelo, $this->condicion, $this->id);
        return Database::executeRow($sql, $params);
    }

}