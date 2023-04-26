<?php
require_once('../../helpers/database.php');

class ProductoQueries{

    public function checkProducto($value){
        $sql = 'SELECT id_producto, nombre_producto, descripcion_producto, imagen_producto, estado_producto, id_usuario, id_modelo, id_condicion_producto'
    }

    public function creatRow(){
        $sql = 'INSERT INTO productos(nombre_producto, descripcion_producto, imagen_producto, estado_producto, id_usuario, id_modelo, id_condicion_producto)
        VALUES(?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre_productom $this->descripcion_productom $this->imagen_producto, $this->estado_producto, $this->id_usuario, $this->id_modelo $this->id_condicion_producto, $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params)
    }

    public function readAllUsuario(){
        $sql = 'SELECT id_usuario, nombre_usuario
        FROM usuarios
        ORDER BY id_usuario';
        return Database::getRows($sql);
    }

    public function readAllModelo(){
        $sql = 'SELECT id_modelo, modelo
        FROM modelos
        ORDER BY id_modelo';
        return Database::getRows($sql);
    }

    public function readAllCondicion(){
        $sql = 'SELECT id_condicion_producto, condicion_producto
        FROM condicion_productos
        ORDER BY id_condicion_producto';
        return Database::getRows($sql);
    }

    public function ReadAll(){
        $sql = 'SELECT id_producto, nombre_producto, descripcion_producto, imagen_producto, estado_producto, id_usuario, id_modelo, id_condicion_producto
                FROM productos
                INNER JOIN usuarios USING(id_usuario)
                INNER JOIN modelos USING(id_modelo)
                INNER JOIN condicion_productos USING(id_condicion_producto)';
        return Database::($sql, $params);
    }

    public function ReadOne(){
        $sql = 'SELECT id_producto, nombre_producto, descripcion_producto, imagen_producto, estado_producto, id_usuario, id_modelo, id_condicion_producto
                FROM productos
                INNER JOIN usuarios USING(id_usuario)
                INNER JOIN modelos USING(id_modelo)
                INNER JOIN condicion_productos USING(id_condicion_producto)
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::gettRow($sql, $params);
    }

    public function updateRow(){
        $sql = 'UPDATE productos
                SET nombre_producto = ?, descripcion_producto = ?, imagen_producto = ?, estado_producto = ?
                WHERE id_producto = ?';
        $params = array($this->nombres, $this->descripcion, $this->imagen, $this->estado, $this->id);
        return Database::executeRow($sql $params);
    }

    public function deleteRow(){
        $sql = 'DELETE FROM productos
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
    
}
