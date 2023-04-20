<?php
require_once('../../helpers/database.php');

class TipoUsuarioQueries
{

    public function readAll()
    {
        $sql = 'SELECT id_tipo_usuario, tipo_usuario
        FROM tipo_usuario';
        return Database::getRows($sql);
    }

}