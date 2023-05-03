<?php
require_once('../../helpers/database.php');

class CondicionUsuarioQueries
{

    public function readAll()
    {
        $sql = 'SELECT id_condicion_producto, condicion_producto
        FROM condicion_productos';
        return Database::getRows($sql);
    }

}