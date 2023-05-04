<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad USUARIO.
*/
class InventarioQueries
{
    /*
    *   Métodos para gestionar la cuenta del usuario.
    */


    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_cargo, cargo
                FROM cargos
                WHERE cargo ILIKE ? 
                ORDER BY cargo';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO inventario_productos(cantidad, precio, fecha, id_usuario, id_producto)
                VALUES(?, ?, ?, ?, ?)';
        $params = array($this->cantidad, $this->precio, $this->fecha, $this->id_usuario, $this->id_producto);
        return Database::executeRow($sql, $params);
    }


    public function readAll()
    {
        $sql = 'SELECT id_inventario_producto, cantidad, precio, fecha, id_usuario, id_producto
        FROM inventario_productos
        INNER JOIN usuarios USING(id_usuario)
        INNER JOIN productos USING(id_producto)';

        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_inventario_producto, cantidad, precio, fecha, id_usuario, id_producto
                FROM inventario_productos 
                WHERE inventario_productos = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    

    public function deleteRow()
    {
        $sql = 'DELETE FROM inventario_productos
                WHERE id_inventario_producto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
