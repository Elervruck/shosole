<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/condicion_queries.php');

class Condicion extends CondicionUsuarioQueries

{
    protected $id = null;
    protected $condicion_producto = null;

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCondicion_producto($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->condicion_producto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCondicion_producto()
    {
        return $this->condicion_producto;
    }

}