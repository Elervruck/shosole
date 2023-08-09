<?php
require_once('../../helpers/database.php');

class ValoracionQueries
{
<<<<<<< HEAD
    //Metodo para obtener todos lo registros de la tabla valoracion
=======

>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
    public function readAll()
    {
        $sql = 'SELECT id_valoracion, calificacion_producto, comentario_producto, fecha_comentario, estado_comentario
        from valoracion 
        inner join detalle_pedido USING (id_detalle_pedido)
        inner join detalle_producto USING (id_detalle_producto)
        inner join producto USING (id_producto)
        where id_producto = ?';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }
<<<<<<< HEAD

    //Metodo para obtener solo un registro
=======
   
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
    public function readOne()
    {
        $sql = 'SELECT id_talla, talla 
        FROM talla
        WHERE id_talla = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

<<<<<<< HEAD
    //Metodo para eliminar un registro
=======
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
    public function deleteRow()
    {
        $sql = 'DELETE FROM talla
                WHERE id_talla = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
    
<<<<<<< HEAD
    //Metodo para actualizar un registro
=======
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
    public function updateRow()
    {
        $sql = 'UPDATE talla
                SET talla=?
                WHERE id_talla = ?';
        $params = array($this->talla, $this->id);
        return Database::executeRow($sql, $params);
    }

<<<<<<< HEAD
    //Metodo para crear un comentario
=======
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
    public function createValoComentario()
    {
        $fecha = date("d-m-Y");
        $estado = 'true';
        $sql="INSERT INTO valoraciones(calificacion_producto, comentario_producto, fecha_comentario, estado_comentario, id_detalle_pedido)
        VALUES(?, ?, ?, ?, ?)";
        $params = array( $this->calificacion, $this->comentario, $fecha, $estado, $this->id_detalle_pedido);
        return Database::executeRow($sql, $params);
    }

<<<<<<< HEAD
    //Metodo para validar un comentario
=======
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
    public function validarComentario(){
        $sql = 'SELECT a.comentario_producto from valoraciones a 
		INNER JOIN detalle_pedidos b using (id_detalle_pedido)
		INNER JOIN pedidos d using (id_pedido)
		INNER JOIN productos c using (id_producto) 
		where id_detalle_pedido = ?';
        $params = array($this->id_detalle_pedido);
        return Database::getRow($sql, $params);
<<<<<<< HEAD
    }
=======
     }


     

>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
}