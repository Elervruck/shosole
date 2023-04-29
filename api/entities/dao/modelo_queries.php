<?php
require_once('../../helpers/database.php');

class ModeloQueries
{
    public function createRow()
    {
        $sql = 'INSERT INTO modelos(modelo, id_marca)
                VALUES(?, ?)';
        $params = array($this->modelo, $this->id_marca);
        return Database::executeRow($sql, $params);
    }


    public function readAll()
    {
        $sql = 'SELECT id_modelo, modelo, marca
        FROM modelos
        INNER JOIN marcas USING(id_marca)';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_modelo, modelo, marca
        FROM modelos
        INNER JOIN marcas USING(id_marca) 
        WHERE id_modelo = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE modelos 
                SET nombres_usuario = ?, apellidos_usuario = ?, correo_usuario = ?
                WHERE id_usuario = ?';
        $params = array($this->nombres, $this->apellidos, $this->correo, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM modeos
                WHERE id_modelo = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
