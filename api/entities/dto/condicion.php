<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/condicion_queries.php');

class Condicion extends CondicionUsuarioQueries

{
    protected $id = null;
    protected $condicionp = null;

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCondicion($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->condicionp = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCondicion()
    {
        return $this->condicionp;
    }

}
