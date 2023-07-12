<?php
require_once('../../helpers/database.php');

class CondicionUsuarioQueries
{

    public function searchRows($value)
    {
        $sql = 'SELECT id_condicion_producto, condicion_producto
                FROM condicion_productos
                WHERE condicion_producto ILIKE ?
                ORDER BY condicion_productos';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_condicion_producto, condicion_producto
                FROM condicion_productos';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_condicion_producto, condicion_producto
                FROM condicion_productos
                WHERE id_condicion_producto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function createRow()
    {   
        $sql = 'INSERT INTO condicion_productos(condicion_producto)
                VALUES(?)';
        $params = array($this->condicion_producto);
        return Database::executeRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE condicion_productos
                SET condicion_producto = ?
                WHERE id_condicion_producto = ?';
        $params = array($this->condicion_producto, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM condicion_productos
                WHERE id_condicion_producto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }


}