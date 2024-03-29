<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad USUARIO.
*/
class MarcaQueries
{
    /*
    *   Métodos para gestionar la cuenta del usuario.
    */


    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */

    //Metodo para buscar un registro
    public function searchRows($value)
    {
        $sql = 'SELECT id_marca, marca, imagen_marca
                FROM marcas
                WHERE marca ILIKE ?  
                ORDER BY marca';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    //Metodo para crear un registro
    public function createRow()
    {
        $sql = 'INSERT INTO marcas(marca, imagen_marca)
                VALUES(?, ?)';
        $params = array($this->marca, $this->imagen_marca);
        return Database::executeRow($sql, $params);
    }

    //metodo para obtener todos los registros
    public function readAll()
    {
        $sql = 'SELECT id_marca, marca, imagen_marca
        FROM marcas';
        return Database::getRows($sql);
    }

    //Metodo para leer una marca
    public function readMarca()
    {
        $sql = 'SELECT id_marca, marca, imagen_marca FROM marcas
                ORDER BY id_marca ';
        return Database::getRows($sql);
    }
    
    //Metodo para leer solo un registro de marca
    public function readOne()
    {
        $sql = 'SELECT id_marca, marca, imagen_marca
                FROM marcas 
                WHERE id_marca = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    //Metodo para actualizar un registro de marca
    public function updateRow($current_image)
    {
        ($this->imagen_marca) ? Validator::deleteFile($this->getRutaImagen(), $current_image) : $this->imagen_marca = $current_image;
        $sql = 'UPDATE marcas 
                SET imagen_marca = ?, marca = ? 
                WHERE id_marca = ?';
        $params = array($this->imagen_marca, $this->marca, $this->id);
        return Database::executeRow($sql, $params);
    }

    //Metodo para eliminar un registro de marca
    public function deleteRow()
    {
        $sql = 'DELETE FROM marcas
                WHERE id_marca = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }


    
}
