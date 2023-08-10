<?php
require_once('../../helpers/database.php');

class ModeloQueries
{

    public function searchRows($value)
    {
        $sql = 'SELECT id_modelo, modelo, id_marca
                FROM modelos
                WHERE modelo ILIKE ?
                ORDER BY modelo';
        $params =  array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO modelos(modelo, id_marca)
                VALUES(?,?)';
        $params = array($this->modelo, $this->id_marca);
        return Database::executeRow($sql, $params);
    }

    public function readMarca()
    {
        $sql = 'SELECT id_marca, marca
        FROM marcas
        ORDER BY id_marca';
        return Database::getRows($sql);
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
                SET modelo = ?, id_marca = ?
                WHERE id_modelo = ?';
        $params = array($this->modelo, $this->id_marca, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM modelos
                WHERE id_modelo = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function porcentajeModeloMarcas()
    {
        $sql = 'SELECT modelos, ROUND((COUNT(id_modelo) * 100.0 / (SELECT COUNT(id_modelo) FROM modelos)), 2) porcentaje 
                FROM modelos
                INNER JOIN marcas USING(id_marca)
                GROUP BY modelos ORDER BY porcentaje DESC';
        return Database::getRows($sql);
    }

}
