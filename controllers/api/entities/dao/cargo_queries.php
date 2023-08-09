<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad USUARIO.
*/
class CargoQueries
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
        $sql = 'INSERT INTO cargos(cargo)
                VALUES(?)';
        $params = array($this->cargo);
        return Database::executeRow($sql, $params);
    }


    public function readAll()
    {
        $sql = 'SELECT id_cargo, cargo
        FROM cargos';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_cargo, cargo
                FROM cargos 
                WHERE id_cargo = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE cargos 
                SET    cargo = ?
                WHERE id_cargo = ?';
        $params = array($this->cargo, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM cargos
                WHERE id_cargo = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
